<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

use App\Models\TabelData;
use App\Models\TabelMetadata;
use App\Models\TabelComment;
use App\Exports\TableOpdExport;
use App\Exports\AgencyTablesExport;
use App\Imports\TableOpdImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

/**
 * Ekspor dan impor Excel serta pembersihan data Excel.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait HandlesExcel
{
    /**
     * Export Tabel OPD ke Microsoft Excel (.xlsx) menggunakan Laravel Excel (Maatwebsite\Excel)
     */
    public function exportExcel(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $year = (int) $request->query('year', 2025);
        $type = $request->query('type', 'opd');
        $isTemplate = (bool) $request->query('template', 0);

        [$opdCode, $type] = $this->normalizeAgency($tableCode, $opdCode, $type);

        $meta = $this->getOrCreateMetadata($tableCode, $opdCode, $year, $type);
        if (!$meta || empty($meta->table_html) || str_contains($meta->table_html, 'Indicator Details')) {
            $fallback = TabelMetadata::where('table_code', $tableCode)
                ->whereNotNull('table_html')
                ->where('table_html', '!=', '')
                ->where('table_html', 'not like', '%Indicator Details%')
                ->where('table_html', 'not like', '%Belum ada data untuk tabel ini%')
                ->orderByRaw("ABS(year - {$year}) ASC")
                ->first();
            if ($fallback) {
                $meta = $fallback;
            }
        }

        $cleanTableCode = str_replace('.', '_', $tableCode);
        $fileName = ($isTemplate ? "Template_Tabel_{$cleanTableCode}_{$year}.xlsx" : "Tabel_{$cleanTableCode}_{$year}.xlsx");

        return Excel::download(
            new TableOpdExport(
                $tableCode,
                $opdCode,
                $year,
                $meta?->title_id,
                $meta?->title_en,
                $meta?->source,
                $meta?->note,
                $meta?->table_html,
                $isTemplate
            ),
            $fileName
        );
    }

    /**
     * Export Seluruh Tabel milik sebuah OPD / Instansi ke dalam 1 berkas Excel (.xlsx) dengan multi-sheet
     */
    public function exportAgencyExcel(Request $request)
    {
        $opdCode = $request->query('opd', $request->query('code', '01'));
        $year = (int) $request->query('year', date('Y'));
        $type = $request->query('type', 'opd');
        $isTemplate = (bool) $request->query('template', 0);

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);

        // 1. Ambil daftar kode tabel resmi khusus untuk tipe dan kode OPD/Instansi ini
        $catalog = config("sibingka_tables.{$type}", []);
        $officialTables = $catalog[$cleanOpd] ?? [];

        // Map seluruh tabel resmi dari kategori lain untuk mencegah kontaminasi silang
        $allOfficialBpsTables = [];
        foreach (config('sibingka_tables.bps', []) as $tbls) {
            foreach ($tbls as $t) $allOfficialBpsTables[$t] = true;
        }

        $allOfficialInstansiTables = [];
        foreach (config('sibingka_tables.instansi', []) as $tbls) {
            foreach ($tbls as $t) $allOfficialInstansiTables[$t] = true;
        }

        $allOfficialOpdTables = [];
        foreach (config('sibingka_tables.opd', []) as $c => $tbls) {
            foreach ($tbls as $t) $allOfficialOpdTables[$t] = true;
        }

        // 2. Ambil tabel dinamis / kustom murni milik instansi ini
        $customTablesQuery = TabelMetadata::where('opd_code', $cleanOpd)
            ->where('year', $year)
            ->where('source_type', '!=', 'deleted');

        if ($type === 'opd') {
            $customTablesQuery->where(function($q) {
                $q->where('source_type', 'like', '%opd%')
                  ->orWhereNull('source_type');
            })
            ->where('source_type', 'not like', '%bps%')
            ->where('source_type', 'not like', '%instansi%');
        } elseif ($type === 'instansi') {
            $customTablesQuery->where('source_type', 'like', '%instansi%')
                ->where('source_type', 'not like', '%bps%');
        } elseif ($type === 'bps') {
            $customTablesQuery->where('source_type', 'like', '%bps%');
        }

        $customTables = $customTablesQuery->pluck('table_code')->toArray();

        // Filter ketat: buang tabel yang merupakan milik BPS atau kategori lain
        if ($type === 'opd') {
            $customTables = array_filter($customTables, function($t) use ($allOfficialBpsTables, $allOfficialInstansiTables, $officialTables) {
                if (in_array($t, $officialTables, true)) return true;
                if (isset($allOfficialBpsTables[$t]) || isset($allOfficialInstansiTables[$t])) return false;
                return true;
            });
        } elseif ($type === 'instansi') {
            $customTables = array_filter($customTables, function($t) use ($allOfficialBpsTables, $allOfficialOpdTables, $officialTables) {
                if (in_array($t, $officialTables, true)) return true;
                if (isset($allOfficialBpsTables[$t]) || isset($allOfficialOpdTables[$t])) return false;
                return true;
            });
        }

        $allTableCodes = array_values(array_unique(array_merge($officialTables, $customTables)));
        natsort($allTableCodes);

        $opdList = config('sibingka.opd_list', []);
        $instansiList = config('sibingka.instansi_list', []);
        
        $agencyInfo = $type === 'instansi' 
            ? ($instansiList[$cleanOpd] ?? null) 
            : ($opdList[$cleanOpd] ?? null);
            
        $agencyName = $agencyInfo['short_name'] ?? ($agencyInfo['name'] ?? "OPD_{$cleanOpd}");
        $cleanAgencyName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $agencyName);

        $sheets = [];

        foreach ($allTableCodes as $tableCode) {
            $metaQuery = TabelMetadata::where('table_code', $tableCode)
                ->where('year', $year);

            if ($type === 'opd') {
                $metaQuery->where(function($q) use ($cleanOpd) {
                    $q->where('opd_code', $cleanOpd)
                      ->orWhere('source_type', 'like', '%opd%');
                })
                ->where('source_type', 'not like', '%bps%')
                ->where('source_type', 'not like', '%instansi%');
            } elseif ($type === 'instansi') {
                $metaQuery->where('opd_code', $cleanOpd)
                    ->where('source_type', 'not like', '%bps%');
            } else {
                $metaQuery->where('opd_code', $cleanOpd);
            }

            $meta = $metaQuery->first();

            // Jika belum ada di tahun terpilih, cari fallback snapshot dari tahun terdekat
            if (!$meta || empty($meta->table_html) || str_contains($meta->table_html, 'Indicator Details')) {
                $fallbackQuery = TabelMetadata::where('table_code', $tableCode)
                    ->whereNotNull('table_html')
                    ->where('table_html', '!=', '')
                    ->where('table_html', 'not like', '%Indicator Details%')
                    ->where('table_html', 'not like', '%Belum ada data untuk tabel ini%');

                if ($type === 'opd') {
                    $fallbackQuery->where('source_type', 'not like', '%bps%')
                        ->where('source_type', 'not like', '%instansi%');
                } elseif ($type === 'instansi') {
                    $fallbackQuery->where('source_type', 'not like', '%bps%');
                }

                $meta = $fallbackQuery->orderByRaw("ABS(year - {$year}) ASC")->first();
            }

            // Jika masih belum ada di database, buat template resmi
            if (!$meta || empty($meta->table_html)) {
                $meta = $this->getOrCreateMetadata($tableCode, $cleanOpd, $year, $type);
            }

            $sheets[] = new TableOpdExport(
                $tableCode,
                $cleanOpd,
                $year,
                $meta?->title_id,
                $meta?->title_en,
                $meta?->source,
                $meta?->note,
                $meta?->table_html,
                $isTemplate
            );
        }

        if (empty($sheets)) {
            $sheets[] = new TableOpdExport(
                '0',
                $cleanOpd,
                $year,
                "Belum Ada Tabel Terdaftar",
                null,
                'BPS Kota Bukittinggi',
                null,
                '<table><tr><td>Belum ada data tabel yang terdaftar untuk ' . htmlspecialchars($agencyName) . ' pada tahun ' . $year . '</td></tr></table>',
                true
            );
        }

        $fileName = ($isTemplate ? "Template_Excel_{$cleanAgencyName}_{$year}.xlsx" : "Data_Excel_{$cleanAgencyName}_{$year}.xlsx");

        return Excel::download(
            new AgencyTablesExport($sheets),
            $fileName
        );
    }

    /**
     * Import Tabel OPD dari berkas Excel (.xlsx / .xls / .csv) menggunakan Laravel Excel
     */
    public function importExcel(Request $request)
    {
        $file = $request->file('excel_file') ?? $request->file('file');
        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada berkas Excel yang diunggah.',
            ], 400);
        }

        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code', '01');
        $year = (int) $request->input('year', 2025);
        $type = $request->input('type', 'opd');

        [$opdCode, $type] = $this->normalizeAgency($tableCode, $opdCode, $type);

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $opdList = array_unique([$opdCode, $cleanOpd]);

        // 1. Ambil atau inisialisasi metadata untuk tahun dan OPD yang sedang dibuka
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', $opdList)
            ->where('year', $year)
            ->first();

        if (!$meta) {
            $meta = $this->getOrCreateMetadata($tableCode, $opdCode, $year, $type);
        }

        if (!$meta) {
            $meta = new TabelMetadata();
            $meta->table_code = $tableCode;
            $meta->opd_code = $cleanOpd;
            $meta->year = $year;
            $meta->source_type = match($type) {
                'bps' => 'custom_bps',
                'instansi' => 'custom_instansi',
                default => 'custom_opd'
            };
        }

        // 2. Jika struktur HTML tabel masih kosong atau berupa starter dummy, pinjam template struktur dari tahun terdekat
        if (empty($meta->table_html) || $this->isDummyOrPlaceholderTable($meta->table_html)) {
            $fallback = TabelMetadata::where('table_code', $tableCode)
                ->whereIn('opd_code', $opdList)
                ->whereNotNull('table_html')
                ->where('table_html', '!=', '')
                ->where('table_html', 'not like', '%Indicator Details%')
                ->where('table_html', 'not like', '%Rincian Indikator%')
                ->where('table_html', 'not like', '%Data Statistik Sektoral%')
                ->where('year', '!=', $year)
                ->orderByRaw("ABS(year - {$year}) ASC")
                ->first();

            // Hanya fallback lintas OPD jika BUKAN instansi vertikal
            if (!$fallback && $type !== 'instansi') {
                $fallback = TabelMetadata::where('table_code', $tableCode)
                    ->whereNotNull('table_html')
                    ->where('table_html', '!=', '')
                    ->where('table_html', 'not like', '%Indicator Details%')
                    ->where('table_html', 'not like', '%Rincian Indikator%')
                    ->where('table_html', 'not like', '%Data Statistik Sektoral%')
                    ->orderByRaw("ABS(year - {$year}) ASC")
                    ->first();
            }

            if ($fallback && !empty($fallback->table_html)) {
                $meta->table_html = $this->adjustYearInHtml($fallback->table_html, (int)$fallback->year, $year);
                if (empty($meta->title_id)) $meta->title_id = $fallback->title_id;
                if (empty($meta->title_en)) $meta->title_en = $fallback->title_en;
                if (empty($meta->source)) $meta->source = $fallback->source;
                if (empty($meta->note)) $meta->note = $fallback->note;
            }
        }

        try {
            $import = new TableOpdImport();
            $sheets = Excel::toArray($import, $file);

            if (empty($sheets)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berkas Excel kosong atau tidak terbaca.',
                ], 400);
            }

            // 1. Temukan Sheet yang paling sesuai dengan $tableCode
            $targetSheet = null;
            $cleanCode = str_replace(' ', '', strtolower($tableCode));

            foreach ($sheets as $sRows) {
                if (!is_array($sRows)) continue;
                foreach ($sRows as $r) {
                    if (!is_array($r)) continue;
                    $rText = str_replace([' ', '_', '-'], '', strtolower(implode(' ', array_filter($r, fn($c) => $c !== null && $c !== ''))));
                    if (str_contains($rText, 'tabel' . $cleanCode) || str_contains($rText, 'table' . $cleanCode)) {
                        $targetSheet = $sRows;
                        break 2;
                    }
                }
            }

            if ($targetSheet === null) {
                foreach ($sheets as $sRows) {
                    if (!is_array($sRows)) continue;
                    foreach ($sRows as $r) {
                        if (!is_array($r)) continue;
                        foreach ($r as $c) {
                            $cClean = str_replace([' ', '_', '-'], '', strtolower((string)$c));
                            if ($cClean === $cleanCode || $cClean === 'tabel' . $cleanCode || $cClean === 'table' . $cleanCode) {
                                $targetSheet = $sRows;
                                break 3;
                            }
                        }
                    }
                }
            }

            if ($targetSheet === null) {
                $targetSheet = $sheets[0] ?? [];
            }
            $rows = $targetSheet;

            if (empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berkas Excel kosong atau tidak terbaca.',
                ], 400);
            }

            // 2. Isolasi blok tabel jika dalam 1 sheet terdapat banyak tabel tersusun vertikal (seperti Tabel 8.1.10 mulai di baris 27)
            $startSliceIdx = null;
            foreach ($rows as $rIdx => $r) {
                if (!is_array($r)) continue;
                $rText = str_replace([' ', '_', '-'], '', strtolower(implode(' ', array_filter($r, fn($c) => $c !== null && $c !== ''))));
                if (str_contains($rText, 'tabel' . $cleanCode) || str_contains($rText, 'table' . $cleanCode)) {
                    $startSliceIdx = $rIdx;
                    break;
                }
            }

            if ($startSliceIdx !== null && $startSliceIdx > 0) {
                $endSliceIdx = count($rows);
                for ($r = $startSliceIdx + 1; $r < count($rows); $r++) {
                    $rArr = $rows[$r] ?? [];
                    if (!is_array($rArr)) continue;
                    $rText = str_replace([' ', '_', '-'], '', strtolower(implode(' ', array_filter($rArr, fn($c) => $c !== null && $c !== ''))));
                    if (preg_match('/^tabel\d+\.\d+/i', $rText) && !str_contains($rText, 'tabel' . $cleanCode)) {
                        $endSliceIdx = $r;
                        break;
                    }
                }
                $rows = array_values(array_slice($rows, $startSliceIdx, $endSliceIdx - $startSliceIdx));
            }

            // Ekstrak Title & Source / Note dari berkas Excel jika tersedia
            $excelTitleId = '';
            $excelTitleEn = '';
            $excelSource = '';
            $excelNote = '';

            for ($r = 0; $r < min(count($rows), 6); $r++) {
                $rCells = array_values(array_filter(array_map('trim', $rows[$r] ?? []), fn($c) => $c !== ''));
                if (empty($rCells)) continue;

                foreach ($rCells as $cell) {
                    if (!$excelTitleId && preg_match('/\b(Jumlah|Banyaknya|Panjang|Luas|Rata-rata|Realisasi|Persentase|Data|Kejadian|Kecelakaan|Tabrakan)\b/i', $cell)) {
                        $excelTitleId = trim(preg_replace('/^Tabel\s*[\d\.]*\s*/i', '', $cell));
                    } elseif (!$excelTitleEn && preg_match('/\b(Number|Length|Wide|Average|Percentage|Total|Accident|Traffic)\b/i', $cell)) {
                        $excelTitleEn = trim(preg_replace('/^Table\s*[\d\.]*\s*/i', '', $cell));
                    }
                }

                $fullRowText = implode(' ', $rCells);
                if (!$excelTitleId && preg_match('/^Tabel\b/i', $fullRowText)) {
                    $excelTitleId = trim(preg_replace('/^Tabel\s*[\d\.]*\s*/i', '', $fullRowText));
                }
                if (!$excelTitleEn && preg_match('/^Table\b/i', $fullRowText)) {
                    $excelTitleEn = trim(preg_replace('/^Table\s*[\d\.]*\s*/i', '', $fullRowText));
                }
            }

            // Ekstrak Catatan (Note) dan Sumber (Source) dari bagian bawah berkas Excel (mendukung Catatan di atas Sumber maupun sebaliknya, single-line maupun multi-line)
            $sourceRowIdx = null;
            $noteRowIdx = null;
            $noteLines = [];
            $sourceLines = [];

            $scanLimit = min(count($rows), 20);
            $startFooterScan = max(0, count($rows) - $scanLimit);

            for ($r = $startFooterScan; $r < count($rows); $r++) {
                $rCells = array_values(array_filter(array_map('trim', $rows[$r] ?? []), fn($c) => $c !== ''));
                if (empty($rCells)) continue;
                $rText = implode(' ', $rCells);

                // Cek baris Sumber / Source
                if (preg_match('/^(?:Sumber\s*(?:\/\s*Source)?|Source)\s*[:\.]?\s*(.*)$/i', $rText, $mSrc)) {
                    $sourceRowIdx = $r;
                    $srcContent = trim($mSrc[1]);
                    $srcContent = trim(preg_replace('/^(?:Source\s*[:\.]?\s*)/i', '', $srcContent));
                    if ($srcContent !== '') {
                        $sourceLines[] = $srcContent;
                    }
                    continue;
                }

                // Cek baris Catatan / Note
                if (preg_match('/^(?:Catatan\s*(?:\/\s*Note)?|Note)\s*[:\.]?\s*(.*)$/i', $rText, $mNote)) {
                    $noteRowIdx = $r;
                    $noteContent = trim($mNote[1]);
                    $noteContent = trim(preg_replace('/^(?:Note\s*[:\.]?\s*)/i', '', $noteContent));
                    if ($noteContent !== '') {
                        $noteLines[] = $noteContent;
                    }
                    continue;
                }

                // Jika baris berada setelah Catatan dan sebelum Sumber (Catatan di atas Sumber):
                if ($noteRowIdx !== null && ($sourceRowIdx === null || $r < $sourceRowIdx)) {
                    if (!preg_match('/^(?:Tabel|Table)\b/i', $rText)) {
                        $noteLines[] = $rText;
                    }
                    continue;
                }

                // Jika baris berada setelah Sumber:
                if ($sourceRowIdx !== null && ($noteRowIdx === null || $r > $noteRowIdx)) {
                    if (!preg_match('/^(?:Tabel|Table)\b/i', $rText)) {
                        $sourceLines[] = $rText;
                    }
                    continue;
                }
            }

            if (!empty($sourceLines)) {
                $excelSource = implode(' ', $sourceLines);
            }

            if (!empty($noteLines)) {
                if (count($noteLines) === 1) {
                    $excelNote = $noteLines[0];
                } else {
                    $excelNote = '<div class="space-y-1">' . implode('', array_map(fn($l) => "<div>{$l}</div>", $noteLines)) . '</div>';
                }
            }

            if (!empty($excelTitleId)) $meta->title_id = $excelTitleId;
            if (!empty($excelTitleEn)) $meta->title_en = $excelTitleEn;
            if (!empty($excelSource)) $meta->source = $excelSource;
            if (!empty($excelNote)) $meta->note = $excelNote;

            // 3. Terapkan data Excel ke struktur tabel:
            // Coba bangun tabel langsung dari baris Excel (Deteksi Otomatis Instan)
            $generatedHtml = $this->buildTableHtmlFromExcelRows($rows, $tableCode, $year);

            $hasValidStructure = !empty($meta->table_html) && !$this->isDummyOrPlaceholderTable($meta->table_html);
            if ($hasValidStructure && $tableCode === '8.1.10' && !str_contains($meta->table_html, 'Januari')) {
                $hasValidStructure = false;
            }

            // Cek apakah tabel ini sebelumnya sudah pernah diimpor/disimpan (re-import)
            $isReimport = in_array($meta->source_type, ['custom_instansi', 'custom_bps'], true) || $meta->is_saved;

            // Cek kompatibilitas jumlah kolom antara struktur HTML lama dengan Excel baru
            $colCountMatch = true;
            if ($hasValidStructure && !empty($generatedHtml)) {
                preg_match('/<tr[^>]*>(.*?)<\/tr>/is', $meta->table_html, $oldFirstRow);
                preg_match('/<tr[^>]*>(.*?)<\/tr>/is', $generatedHtml, $newFirstRow);
                if (!empty($oldFirstRow[1]) && !empty($newFirstRow[1])) {
                    preg_match_all('/<(?:th|td)\b/i', $oldFirstRow[1], $oldCols);
                    preg_match_all('/<(?:th|td)\b/i', $newFirstRow[1], $newCols);
                    if (count($oldCols[0]) !== count($newCols[0])) {
                        $colCountMatch = false;
                    }
                }
            }

            if (!empty($generatedHtml)) {
                // Jika halaman sudah pernah diimpor sebelumnya (re-impor), atau struktur lama tidak valid,
                // atau jumlah kolom berbeda: LANGSUNG gunakan tabel baru hasil bangun Excel ($generatedHtml)
                // agar tabel lama tergantikan secara bersih dan tidak bertabrakan / menumpuk ("nabrak")!
                if (!$hasValidStructure || $isReimport || !$colCountMatch) {
                    $updatedHtml = $generatedHtml;
                } else {
                    $appliedHtml = $this->applyExcelRowsToTableHtml($meta->table_html, $rows, $tableCode);
                    $updatedHtml = !empty($appliedHtml) ? $appliedHtml : $generatedHtml;
                }
            } elseif ($hasValidStructure) {
                $updatedHtml = $this->applyExcelRowsToTableHtml($meta->table_html, $rows, $tableCode);
            } else {
                $updatedHtml = $meta->table_html ?? '';
            }

            $schoolCodes = ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.15', '4.1.16', '4.1.17'];
            if (in_array($tableCode, $schoolCodes) && $type !== 'bps') {
                $updatedHtml = $this->build3in1EducationHtml($year, $updatedHtml);
            }

            $updatedHtml = $this->cleanExcelDateSerials($updatedHtml);
            $updatedHtml = $this->formatFinancialHtml($updatedHtml, $opdCode, $tableCode);

            $meta->table_html = $updatedHtml;
            $meta->is_saved = true;
            $meta->source_type = match($type) {
                'bps' => 'custom_bps',
                'instansi' => 'custom_instansi',
                default => 'custom_opd'
            };

            // Berlakukan juga validasi pernyataan kebenaran data pada hasil impor
            $sender = session('user.displayName', 'Pengguna');
            if (!in_array($meta->verification_status, ['verified', 'validated'], true) && !$meta->is_locked) {
                $meta->verification_status = 'submitted';
                $meta->data_declared = true;
                $meta->submitted_at = now();
                $meta->submitted_by = $sender;
                $meta->rejection_notes = null;
            }
            $meta->save();

            // Sinkronkan ke progres Monitoring agar langsung terhitung sebagai Input Data dengan pernyataan kebenaran
            $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            try {
                \App\Support\MonitoringProgress::syncStage(
                    $type,
                    $cleanOpd,
                    $year,
                    'Tabel ' . $tableCode . ' diimpor oleh ' . $sender . ' dengan pernyataan kebenaran data.'
                );
            } catch (\Throwable $e) {}

            // Simpan file cache snapshot
            try {
                $cacheDir = storage_path('app/tables');
                if (!is_dir($cacheDir)) @mkdir($cacheDir, 0777, true);
                $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
                $cacheFile = "{$cacheDir}/table_{$type}_{$cleanOpd}_{$tableCode}_{$year}.json";
                @file_put_contents($cacheFile, json_encode($meta->toArray()));
            } catch (\Throwable $e) {}

            return response()->json([
                'success' => true,
                'message' => 'Data tabel berhasil diimpor menggunakan Laravel Excel!',
                'table_html' => $updatedHtml,
                'title_id' => $meta->title_id,
                'title_en' => $meta->title_en,
                'source' => $meta->source,
                'note' => $meta->note,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses berkas Excel: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cek apakah table_html masih berupa template dummy/placeholder bawaan atau rusak
     */
    protected function isDummyOrPlaceholderTable(?string $html): bool
    {
        if (empty($html)) return true;
        if (str_contains($html, 'Rincian Indikator') || str_contains($html, 'Indicator Details')) return true;
        if (str_contains($html, 'Data Statistik Sektoral')) return true;
        if (str_contains($html, 'Belum ada data untuk tabel ini')) return true;
        if (!str_contains($html, '<tbody')) return true;

        // Cek jika tabel memiliki header kolom dummy seperti 3+ kolom berurutan berisi '-'
        if (preg_match_all('/<th[^>]*>\s*(?:<div>\s*)?-\s*(?:<\/div>\s*)?<\/th>/i', $html, $mDummyTh)) {
            if (count($mDummyTh[0]) >= 3) return true;
        }

        return false;
    }

    /**
     * Normalisasi label baris untuk perbandingan nama/kategori yang akurat
     */
    protected function normalizeRowLabel(string $str): string
    {
        $s = strip_tags($str);
        $s = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $s = preg_replace('/[\x{2013}\x{2014}\-\–\—]/u', '-', $s);
        $s = preg_replace('/^\s*\d+[\.\)\-]\s*/u', '', $s);
        $s = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $s);
        return strtolower(trim($s));
    }

    /**
     * Format isi teks sel header menjadi dua baris (Indonesia dan Inggris jika ada '/')
     */
    protected function formatHeaderCellText(string $val): string
    {
        $val = trim($val);
        if ($val === '' || $val === '-') {
            return '<div>-</div>';
        }
        if (str_contains($val, '/')) {
            $parts = explode('/', $val, 2);
            return '<div>' . htmlspecialchars(trim($parts[0])) . '</div><div class="italic font-normal text-[11px] sm:text-xs">' . htmlspecialchars(trim($parts[1])) . '</div>';
        }
        return '<div>' . htmlspecialchars($val) . '</div>';
    }

    /**
     * Membangun struktur table_html lengkap (thead dan tbody) langsung dari baris Excel
     * Mencegah himpitan/tumpukan data Excel ke struktur tabel lama atau placeholder
     */
    public function buildTableHtmlFromExcelRows(array $excelRows, string $tableCode = '', int $year = 2025): string
    {
        // 1. Temukan baris penomoran (1), (2), (3)... atau -1, -2, -3... atau 1, 2, 3...
        $numRowIdx = null;
        $rawNumRow = [];
        $minPhysicalCol = 0;
        $hasExplicitNumRow = false;

        foreach ($excelRows as $rIdx => $row) {
            if (!is_array($row)) continue;
            foreach ($row as $cIdx => $c) {
                $cStr = trim((string)$c);
                if ($cStr === '(1)' || $cStr === '-1' || (preg_match('/^\(1\)/', $cStr) && (in_array('(2)', array_map('trim', $row)) || in_array('-2', array_map('trim', $row))))) {
                    $numRowIdx = $rIdx;
                    $rawNumRow = $row;
                    $minPhysicalCol = $cIdx;
                    $hasExplicitNumRow = true;
                    break 2;
                }
            }
        }

        // Jika belum ketemu, cari baris penomoran angka biasa 1, 2, 3...
        if ($numRowIdx === null) {
            foreach ($excelRows as $rIdx => $row) {
                if (!is_array($row)) continue;
                $nonEmpty = array_values(array_filter(array_map('trim', $row), fn($x) => $x !== ''));
                if (count($nonEmpty) >= 2) {
                    $isSeq = true;
                    $expected = 1;
                    foreach ($nonEmpty as $val) {
                        if (preg_match('/^\(?(\d+)\)?$/', $val, $nm) && (int)$nm[1] === $expected) {
                            $expected++;
                        } else {
                            $isSeq = false;
                            break;
                        }
                    }
                    if ($isSeq && $expected >= 3) {
                        $numRowIdx = $rIdx;
                        $rawNumRow = $row;
                        $hasExplicitNumRow = true;
                        foreach ($row as $cIdx => $c) {
                            if (trim((string)$c) !== '') {
                                $minPhysicalCol = $cIdx;
                                break;
                            }
                        }
                        break;
                    }
                }
            }
        }

        // Jika masih belum ada baris penomoran eksplisit: Deteksi baris header dan baris data secara otomatis!
        if ($numRowIdx === null) {
            $firstDataIdx = null;
            foreach ($excelRows as $rIdx => $row) {
                if (!is_array($row)) continue;
                $cells = array_map(fn($c) => $c !== null ? trim((string)$c) : '', $row);
                $nonEmpty = array_values(array_filter($cells, fn($x) => $x !== ''));
                if (count($nonEmpty) < 2) continue;

                $firstCell = $nonEmpty[0];
                if (preg_match('/^(?:Tabel|Table|Sumber|Source|Catatan|Note)\b/i', $firstCell)) continue;

                // Cek apakah sel-sel berikutnya dominan angka atau tanda '-' (indikasi kuat baris data)
                $numericCount = 0;
                for ($k = 1; $k < count($nonEmpty); $k++) {
                    $valClean = str_replace(['.', ',', ' ', '%'], '', $nonEmpty[$k]);
                    if (is_numeric($valClean) || $nonEmpty[$k] === '-' || $nonEmpty[$k] === '–' || $nonEmpty[$k] === '—' || $nonEmpty[$k] === '...') {
                        $numericCount++;
                    }
                }

                if ($numericCount >= 1 && ($numericCount / (count($nonEmpty) - 1)) >= 0.4) {
                    $firstDataIdx = $rIdx;
                    break;
                }
            }

            if ($firstDataIdx !== null && $firstDataIdx > 0) {
                $numRowIdx = $firstDataIdx - 1;
                $hasExplicitNumRow = false;
                foreach ($excelRows[$firstDataIdx] as $cIdx => $c) {
                    if (trim((string)$c) !== '') {
                        $minPhysicalCol = $cIdx;
                        break;
                    }
                }
            }
        }

        if ($numRowIdx === null) {
            return '';
        }

        // Hitung total kolom fisik di spreadsheet (hanya dari baris header, baris penomoran, dan baris data s/d total)
        $maxPhysicalCols = 0;
        $scanEndIdx = count($excelRows);
        for ($sIdx = $numRowIdx + 1; $sIdx < count($excelRows); $sIdx++) {
            $sRow = $excelRows[$sIdx] ?? [];
            if (!is_array($sRow)) continue;
            $sText = implode(' ', array_filter(array_map('trim', $sRow), fn($c) => $c !== ''));
            if (preg_match('/^(?:Sumber|Source|Catatan|Note)\b/i', $sText)) {
                $scanEndIdx = $sIdx;
                break;
            }
        }

        // Jika ada baris penomoran eksplisit (1), (2), (3)... gunakan batas kolom penomoran tersebut
        $maxNumCol = 0;
        if ($hasExplicitNumRow && !empty($rawNumRow) && is_array($rawNumRow)) {
            foreach ($rawNumRow as $cIdx => $cVal) {
                if (preg_match('/^\(?(\d+)\)?$/', trim((string)$cVal))) {
                    $maxNumCol = max($maxNumCol, $cIdx + 1);
                }
            }
        }

        for ($rIdx = max(0, $numRowIdx - 3); $rIdx < $scanEndIdx; $rIdx++) {
            $r = $excelRows[$rIdx] ?? [];
            if (is_array($r)) {
                $nonEmptyIndices = array_keys(array_filter($r, fn($val) => $val !== null && trim((string)$val) !== ''));
                if (!empty($nonEmptyIndices)) {
                    $maxPhysicalCols = max($maxPhysicalCols, max($nonEmptyIndices) + 1);
                }
            }
        }

        if ($maxNumCol > 0) {
            $maxPhysicalCols = min($maxPhysicalCols, $maxNumCol);
        }

        if ($maxPhysicalCols <= $minPhysicalCol) {
            return '';
        }

        // Deteksi apakah kolom awal memiliki colspan 2 (karena merge kolom A+B di Excel atau karena sub-tabel historical total)
        $knownColspan2Tables = ['11.1', '11.3', '4.3.13', '4.3.14', '8.1.10'];
        $firstColColspan2 = in_array($tableCode, $knownColspan2Tables, true);
        if (!$firstColColspan2 && !in_array($tableCode, ['4.2.3', '4.2.2']) && $hasExplicitNumRow && ($maxPhysicalCols - $minPhysicalCol) >= 2) {
            $numCol0 = trim((string)($rawNumRow[$minPhysicalCol] ?? ''));
            $numCol1 = trim((string)($rawNumRow[$minPhysicalCol + 1] ?? ''));
            if (($numCol0 === '(1)' || $numCol0 === '-1') && ($numCol1 === '' || $numCol1 === null)) {
                // Pastikan baris data memang memiliki pola historical sub-years
                foreach ($excelRows as $r) {
                    if (!is_array($r)) continue;
                    $c0 = trim((string)($r[$minPhysicalCol] ?? ''));
                    $c1 = trim((string)($r[$minPhysicalCol + 1] ?? ''));
                    if (preg_match('/(?:Jumlah|Total)/i', $c0) && preg_match('/^(?:19|20)\d{2}/', $c1)) {
                        $firstColColspan2 = true;
                        break;
                    }
                }
            }
        }
        if (!$firstColColspan2) {
            foreach ($excelRows as $r) {
                if (!is_array($r)) continue;
                $c0 = trim((string)($r[$minPhysicalCol] ?? ''));
                $c1 = trim((string)($r[$minPhysicalCol + 1] ?? ''));
                if (preg_match('/(?:Jumlah|Total)/i', $c0) && preg_match('/^(?:19|20)\d{2}/', $c1)) {
                    $firstColColspan2 = true;
                    break;
                }
            }
        }

        // 2. Ambil baris-baris header
        $headerRows = [];
        $headerLimitIdx = $hasExplicitNumRow ? $numRowIdx : ($numRowIdx + 1);
        for ($r = 0; $r < $headerLimitIdx; $r++) {
            $row = $excelRows[$r] ?? [];
            if (!is_array($row)) continue;
            $cells = array_map(fn($c) => $c !== null ? trim((string)$c) : '', $row);
            $nonEmpty = array_values(array_filter($cells, fn($x) => $x !== ''));
            if (empty($nonEmpty)) continue;
            if (preg_match('/^(?:Tabel|Table)\b/i', $nonEmpty[0])) continue;
            if (count($nonEmpty) === 1 && preg_match('/^(?:Jumlah|Banyaknya|Number|Total)/i', $nonEmpty[0])) continue;
            $headerRows[] = $row;
        }

        if (empty($headerRows) && isset($excelRows[$numRowIdx])) {
            $headerRows[] = $excelRows[$numRowIdx];
        }

        $theadHtml = "<thead>\n";
        if (count($headerRows) === 2) {
            $h0 = $headerRows[0];
            $h1 = $headerRows[1];

            // Cek apakah baris 0 dan baris 1 sebenarnya adalah pasangan terjemahan Indonesia & Inggris 1-ke-1
            // (yaitu tidak ada sel di h0 yang membawahi banyak sub-kolom berbeda di h1)
            $isTranslationPair = true;
            $hasSubColumns = false;
            for ($c = $minPhysicalCol; $c < $maxPhysicalCols; $c++) {
                if ($firstColColspan2 && $c === $minPhysicalCol + 1) {
                    continue; // Kolom ke-2 dari merge kolom pertama (Kecamatan)
                }
                $v0 = trim((string)($h0[$c] ?? ''));
                $v1 = trim((string)($h1[$c] ?? ''));
                // Jika v0 kosong sedangkan v1 ada isinya, ini pertanda sub-kolom (h0 punya colspan)
                if ($v0 === '' && $v1 !== '' && !in_array($v1, ['-', '–', '—'])) {
                    $hasSubColumns = true;
                    $isTranslationPair = false;
                    break;
                }
            }

            if ($isTranslationPair && !$hasSubColumns) {
                // RENDER SEBAGAI 1 BARIS THEAD STANDAR BPS DENGAN SUBTITLE INGGRIS ITALIC
                $theadHtml .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">\n";
                $c = $minPhysicalCol;
                while ($c < $maxPhysicalCols) {
                    $v0 = trim((string)($h0[$c] ?? ''));
                    $v1 = trim((string)($h1[$c] ?? ''));
                    $isCol0Colspan = ($c === $minPhysicalCol && $firstColColspan2);
                    $colspanAttr = $isCol0Colspan ? ' colspan="2"' : '';

                    // Ekstrak teks Indonesia dan Inggris
                    $cleanV0 = htmlspecialchars(trim(preg_replace('/\s*\/\s*.*$/', '', $v0)));
                    $cleanV1 = htmlspecialchars(trim($v1 !== '-' && $v1 !== '–' && $v1 !== '—' ? $v1 : ''));
                    if (empty($cleanV1) && str_contains($v0, '/')) {
                        $parts = explode('/', $v0, 2);
                        $cleanV0 = htmlspecialchars(trim($parts[0]));
                        $cleanV1 = htmlspecialchars(trim($parts[1]));
                    }

                    $cellInner = "<div>{$cleanV0}</div>";
                    if (!empty($cleanV1)) {
                        $cellInner .= "<div class=\"italic font-normal text-[11px] sm:text-xs\">{$cleanV1}</div>";
                    }

                    $theadHtml .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\"{$colspanAttr}>{$cellInner}</th>\n";
                    $c += $isCol0Colspan ? 2 : 1;
                }
                $theadHtml .= "    </tr>\n";
            } else {
                $colspans0 = [];
                $rowspans0 = [];
                $c = $minPhysicalCol;
                while ($c < $maxPhysicalCols) {
                    $v0 = trim((string)($h0[$c] ?? ''));
                    $v1 = trim((string)($h1[$c] ?? ''));
                    $isV1EmptyOrDash = ($v1 === '' || $v1 === '-' || $v1 === '–' || $v1 === '—');

                    if ($v0 !== '' && $isV1EmptyOrDash) {
                        $span = 1;
                        $k = $c + 1;
                        while ($k < $maxPhysicalCols && trim((string)($h0[$k] ?? '')) === '' && trim((string)($h1[$k] ?? '')) !== '' && !in_array(trim((string)($h1[$k] ?? '')), ['-', '–', '—'])) {
                            $span++;
                            $k++;
                        }
                        if ($span > 1) {
                            $colspans0[$c] = $span;
                            $c += $span;
                        } else {
                            $rowspans0[$c] = 2;
                            $c++;
                        }
                    } elseif ($v0 !== '') {
                        $span = 1;
                        $k = $c + 1;
                        while ($k < $maxPhysicalCols && trim((string)($h0[$k] ?? '')) === '' && trim((string)($h1[$k] ?? '')) !== '') {
                            $span++;
                            $k++;
                        }
                        $colspans0[$c] = $span;
                        $c += $span;
                    } else {
                        $c++;
                    }
                }

                // Header baris 1
                $theadHtml .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">\n";
                $c = $minPhysicalCol;
                while ($c < $maxPhysicalCols) {
                    $isCol0Colspan = ($c === $minPhysicalCol && $firstColColspan2);
                    if (isset($rowspans0[$c])) {
                        $v0 = trim((string)($h0[$c] ?? ''));
                        $cellInner = $this->formatHeaderCellText($v0);
                        $extraSpan = $isCol0Colspan ? ' colspan="2"' : '';
                        $theadHtml .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\" rowspan=\"2\"{$extraSpan}>{$cellInner}</th>\n";
                        $c += $isCol0Colspan ? 2 : 1;
                    } elseif (isset($colspans0[$c])) {
                        $span = $colspans0[$c];
                        if ($isCol0Colspan && $span < 2) $span = 2;
                        $v0 = trim((string)($h0[$c] ?? ''));
                        $cellInner = $this->formatHeaderCellText($v0);
                        $colspanAttr = $span > 1 ? " colspan=\"{$span}\"" : '';
                        $theadHtml .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\"{$colspanAttr}>{$cellInner}</th>\n";
                        $c += $span;
                    } else {
                        $c += $isCol0Colspan ? 2 : 1;
                    }
                }
                $theadHtml .= "    </tr>\n";

                // Header baris 2
                $theadHtml .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">\n";
                for ($c = $minPhysicalCol; $c < $maxPhysicalCols; $c++) {
                    if (isset($rowspans0[$c]) || ($firstColColspan2 && $c === $minPhysicalCol + 1)) {
                        continue; // Dilewati karena sudah di-rowspan/colspan dari baris 1
                    }
                    $v1 = trim((string)($h1[$c] ?? ''));
                    if ($c === $minPhysicalCol && ($v1 === '-' || $v1 === '–' || $v1 === '—' || $v1 === '')) {
                        continue; // Jangan render dummy dash di bawah kolom pertama
                    }
                    $cellInner = $this->formatHeaderCellText($v1);
                    $theadHtml .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\">{$cellInner}</th>\n";
                }
                $theadHtml .= "    </tr>\n";
            }
        } else {
            foreach ($headerRows as $hRow) {
                $theadHtml .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">\n";
                $cIdx = $minPhysicalCol;
                while ($cIdx < $maxPhysicalCols) {
                    $cellVal = trim((string)($hRow[$cIdx] ?? ''));
                    $isCol0Colspan = ($cIdx === $minPhysicalCol && $firstColColspan2);
                    $colspanAttr = $isCol0Colspan ? ' colspan="2"' : '';
                    $cellInner = $this->formatHeaderCellText($cellVal);

                    $theadHtml .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\"{$colspanAttr}>{$cellInner}</th>\n";
                    $cIdx += $isCol0Colspan ? 2 : 1;
                }
                $theadHtml .= "    </tr>\n";
            }
        }

        // Baris penomoran (1), (2), (3)...
        $theadHtml .= "    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">\n";
        $cIdx = $minPhysicalCol;
        $numCounter = 1;
        while ($cIdx < $maxPhysicalCols) {
            $isCol0Colspan = ($cIdx === $minPhysicalCol && $firstColColspan2);
            $colspanAttr = $isCol0Colspan ? ' colspan="2"' : '';
            $theadHtml .= "        <th class=\"py-1 px-3 border border-slate-700\"{$colspanAttr}>({$numCounter})</th>\n";
            $numCounter++;
            $cIdx += $isCol0Colspan ? 2 : 1;
        }
        $theadHtml .= "    </tr>\n</thead>\n";

        // 3. Ambil baris data dan baris total
        $tbodyHtml = "<tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">\n";

        // Kumpulkan baris data mentah
        $bodyRows = [];
        for ($r = $numRowIdx + 1; $r < count($excelRows); $r++) {
            $row = $excelRows[$r] ?? [];
            if (!is_array($row)) continue;
            $cells = array_map(fn($c) => $c !== null ? trim((string)$c) : '', $row);
            $nonEmpty = array_values(array_filter($cells, fn($x) => $x !== ''));
            if (empty($nonEmpty)) continue;

            if (preg_match('/^(?:Sumber|Source|Catatan|Note)\b/i', $nonEmpty[0])) break;
            if (in_array('(1)', $cells) || in_array('-1', $cells)) continue;
            if (preg_match('/^(?:Tabel|Table|College|Mahasiswa|Dosen)\b/i', $nonEmpty[0])) continue;

            $bodyRows[] = $row;
        }

        // Hitung apakah ada sub-tabel historical total (Jumlah/Total yang diikuti baris tahun-tahun)
        $historicalTotalSpan = 0;
        $historicalTotalStartIdx = null;
        foreach ($bodyRows as $bIdx => $bRow) {
            $c0 = trim((string)($bRow[$minPhysicalCol] ?? ''));
            $c1 = trim((string)($bRow[$minPhysicalCol + 1] ?? ''));
            if (preg_match('/(?:Jumlah|Total)/i', $c0) && preg_match('/^(?:19|20)\d{2}/', $c1)) {
                $historicalTotalStartIdx = $bIdx;
                $historicalTotalSpan = 1;
                for ($k = $bIdx + 1; $k < count($bodyRows); $k++) {
                    $subC0 = trim((string)($bodyRows[$k][$minPhysicalCol] ?? ''));
                    $subC1 = trim((string)($bodyRows[$k][$minPhysicalCol + 1] ?? ''));
                    if (($subC0 === '' || $subC0 === null || preg_match('/^(?:19|20)\d{2}/', $subC0)) && (preg_match('/^(?:19|20)\d{2}/', $subC1) || preg_match('/^(?:19|20)\d{2}/', $subC0))) {
                        $historicalTotalSpan++;
                    } else {
                        break;
                    }
                }
                break;
            }
        }

        foreach ($bodyRows as $bIdx => $bRow) {
            $c0 = trim((string)($bRow[$minPhysicalCol] ?? ''));
            $c1 = trim((string)($bRow[$minPhysicalCol + 1] ?? ''));
            $rowText = implode(' ', array_filter(array_map('trim', $bRow), fn($x) => $x !== ''));

            $isTotalRow = (bool) preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $rowText);
            $isHistoricalSubYear = ($historicalTotalStartIdx !== null && $bIdx > $historicalTotalStartIdx && $bIdx < $historicalTotalStartIdx + $historicalTotalSpan);

            if ($isTotalRow || $isHistoricalSubYear) {
                $trClass = 'bg-[#fed7aa] font-bold text-slate-900 border-t border-slate-700';
                $boldClass = ' font-bold';
            } else {
                $trClass = 'hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium';
                $boldClass = '';
            }

            $tbodyHtml .= "    <tr class=\"{$trClass}\">\n";

            if ($historicalTotalStartIdx !== null && $bIdx === $historicalTotalStartIdx) {
                // Baris awal historical total (Jumlah/Total dengan rowspan)
                $labelHtml = 'Jumlah / <span class="italic font-bold">Total</span>';
                $tbodyHtml .= "        <td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle font-bold\" rowspan=\"{$historicalTotalSpan}\">{$labelHtml}</td>\n";
                $tbodyHtml .= "        <td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle font-bold\">" . htmlspecialchars($c1) . "</td>\n";
                for ($c = $minPhysicalCol + 2; $c < $maxPhysicalCols; $c++) {
                    $val = trim((string)($bRow[$c] ?? ''));
                    $valDisplay = ($val === '' || $val === '-' || $val === '–' || $val === '—') ? '<span class="text-slate-400 font-normal">-</span>' : htmlspecialchars($val);
                    $tbodyHtml .= "        <td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle font-bold\">{$valDisplay}</td>\n";
                }
            } elseif ($isHistoricalSubYear) {
                // Baris sub-tahun dalam historical total (Col 0 dilewati karena kena rowspan)
                $yearVal = $c1 !== '' ? $c1 : $c0;
                $valStartCol = $c1 !== '' ? ($minPhysicalCol + 2) : ($minPhysicalCol + 1);
                $tbodyHtml .= "        <td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle font-bold\">" . htmlspecialchars($yearVal) . "</td>\n";
                for ($c = $valStartCol; $c < $maxPhysicalCols; $c++) {
                    $val = trim((string)($bRow[$c] ?? ''));
                    $valDisplay = ($val === '' || $val === '-' || $val === '–' || $val === '—') ? '<span class="text-slate-400 font-normal">-</span>' : htmlspecialchars($val);
                    $tbodyHtml .= "        <td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle font-bold\">{$valDisplay}</td>\n";
                }
            } else {
                // Baris normal (Kecamatan atau kategori)
                if ($firstColColspan2) {
                    $label = $c0 !== '' ? $c0 : $c1;
                    $tbodyHtml .= "        <td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle{$boldClass}\" colspan=\"2\">" . htmlspecialchars($label) . "</td>\n";
                    for ($c = $minPhysicalCol + 2; $c < $maxPhysicalCols; $c++) {
                        $val = trim((string)($bRow[$c] ?? ''));
                        $valDisplay = ($val === '' || $val === '-' || $val === '–' || $val === '—') ? '<span class="text-slate-400 font-normal">-</span>' : htmlspecialchars($val);
                        $tbodyHtml .= "        <td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle{$boldClass}\">{$valDisplay}</td>\n";
                    }
                } else {
                    for ($c = $minPhysicalCol; $c < $maxPhysicalCols; $c++) {
                        $val = trim((string)($bRow[$c] ?? ''));
                        $valDisplay = ($val === '' || $val === '-' || $val === '–' || $val === '—') ? '<span class="text-slate-400 font-normal">-</span>' : htmlspecialchars($val);
                        $align = ($c === $minPhysicalCol) ? 'text-left font-semibold' : 'text-center';
                        $tbodyHtml .= "        <td class=\"py-2.5 px-4 border border-slate-700 {$align} align-middle{$boldClass}\">{$valDisplay}</td>\n";
                    }
                }
            }

            $tbodyHtml .= "    </tr>\n";
        }

        $tbodyHtml .= "</tbody>";

        $fullHtml = $theadHtml . $tbodyHtml;

        // Auto-heal Kolom 6 jika ada
        if ($tableCode === '2.2.2' || stripos($fullHtml, 'Partai') !== false || stripos($fullHtml, 'Pendidikan') !== false) {
            $fullHtml = preg_replace('/Kolom\s*6/i', 'S2/S3', $fullHtml);
        }
        if ($tableCode === '4.2.11' || stripos($fullHtml, 'Donatur Darah') !== false || stripos($fullHtml, 'Golongan Darah') !== false) {
            $fullHtml = preg_replace('/Kolom\s*6/i', 'AB', $fullHtml);
        }
        if ($tableCode === '8.1.6' || (stripos($fullHtml, 'Bemo') !== false && stripos($fullHtml, 'Bus Umum') !== false)) {
            $fullHtml = preg_replace('/Kolom\s*6/i', 'Taksi/Taxi', $fullHtml);
        }
        if (in_array($tableCode, ['9.4', '5.1.18']) || stripos($fullHtml, 'Guguk Panjang') !== false) {
            $fullHtml = preg_replace('/Kolom\s*6/i', 'Aur Birugo Tigo Baleh', $fullHtml);
        }
        if ($tableCode === '4.1.21' || stripos($fullHtml, 'Perpustakaan') !== false) {
            $fullHtml = preg_replace('/<th([^>]*)colspan="2"([^>]*)>\s*(?:<div>)?\s*Kolom\s*10\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div></th>', $fullHtml);
            $fullHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*10\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div></th>', $fullHtml);
            $fullHtml = preg_replace('/>\s*Kolom\s*10\s*</i', '>Lain-lain<', $fullHtml);
            $fullHtml = preg_replace('/Kolom\s*10/i', 'Lain-lain', $fullHtml);
        }
        if ($tableCode === '4.1.23' || (stripos($fullHtml, 'Penggolongan') !== false && stripos($fullHtml, '100') !== false)) {
            $fullHtml = preg_replace(
                '/<th([^>]*)colspan="2"([^>]*)>\s*(?:<div>)?\s*Kolom\s*2\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div></th>' . "\n" . '        <th class="py-3 px-4 font-bold border border-slate-700"><div>0</div></th>',
                $fullHtml
            );
            $fullHtml = preg_replace(
                '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*2\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div></th>',
                $fullHtml
            );
        }
        if ($tableCode === '4.5.2' || (stripos($fullHtml, 'Pidana') !== false && stripos($fullHtml, 'Lalu Lintas') !== false && stripos($fullHtml, 'Perkara yang Masuk') !== false)) {
            $fullHtml = preg_replace(
                '/<th([^>]*)colspan=["\']?\d+["\']?([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                $fullHtml
            );
            $fullHtml = preg_replace(
                '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                $fullHtml
            );
        }
        if ($tableCode === '4.5.4' || (stripos($fullHtml, 'Pidana') !== false && stripos($fullHtml, 'SPDP') !== false)) {
            $fullHtml = preg_replace(
                '/<th([^>]*)colspan=["\']?\d+["\']?([^>]*)>\s*(?:<div>)?\s*Kolom\s*7\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                $fullHtml
            );
            $fullHtml = preg_replace(
                '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*7\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                $fullHtml
            );
        }
        if ($tableCode === '8.1.10' || (stripos($fullHtml, 'Tabrakan') !== false && stripos($fullHtml, 'Kecelakaan') !== false)) {
            $fullHtml = preg_replace('/Taksi[^\/<\n]*Kerugi[^\/<\n]*(?:\([^\)]*\))?/i', 'Taksiran Kerugian Material (Rp)', $fullHtml);
            $fullHtml = preg_replace('/Sligly/i', 'Slightly', $fullHtml);
            $fullHtml = preg_replace('/Severly/i', 'Severely', $fullHtml);
        }

        return $fullHtml;
    }

    /**
     * Terapkan baris data dari berkas Excel ke dalam table_html secara presisi menggunakan Laravel Excel
     */
    protected function applyExcelRowsToTableHtml(string $tableHtml, array $excelRows, string $tableCode = ''): string
    {
        // 1. Auto-heal Header Kolom 6, Taksi, & Kecamatan
        if ($tableCode === '2.2.2' || stripos($tableHtml, 'Partai') !== false || stripos($tableHtml, 'Pendidikan') !== false) {
            $tableHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>', $tableHtml);
            $tableHtml = preg_replace('/<th([^>]*)>\s*Kolom\s*6\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>', $tableHtml);
            $tableHtml = preg_replace('/>\s*Kolom\s*6\s*</i', '>S2/S3<', $tableHtml);
            $tableHtml = preg_replace('/Kolom\s*6/i', 'S2/S3', $tableHtml);
        }
        if ($tableCode === '4.2.11' || stripos($tableHtml, 'Donatur Darah') !== false || stripos($tableHtml, 'Golongan Darah') !== false) {
            $tableHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>AB</div></th>', $tableHtml);
            $tableHtml = preg_replace('/Kolom\s*6/i', 'AB', $tableHtml);
        }
        if ($tableCode === '8.1.6' || (stripos($tableHtml, 'Bemo') !== false && stripos($tableHtml, 'Bus Umum') !== false)) {
            $tableHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Taksi</div><div class="italic font-normal text-[11px] sm:text-xs">Taxi</div></th>', $tableHtml);
            $tableHtml = preg_replace('/>\s*Kolom\s*6\s*</i', '>Taksi/Taxi<', $tableHtml);
            $tableHtml = preg_replace('/Kolom\s*6/i', 'Taksi/Taxi', $tableHtml);
        }
        if (in_array($tableCode, ['9.4', '5.1.18']) || stripos($tableHtml, 'Guguk Panjang') !== false) {
            $tableHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Aur Birugo Tigo Baleh</div></th>', $tableHtml);
            $tableHtml = preg_replace('/>\s*Kolom\s*6\s*</i', '>Aur Birugo Tigo Baleh<', $tableHtml);
            $tableHtml = preg_replace('/Kolom\s*6/i', 'Aur Birugo Tigo Baleh', $tableHtml);
        }
        if ($tableCode === '4.1.21' || stripos($tableHtml, 'Perpustakaan') !== false) {
            $tableHtml = preg_replace('/<th([^>]*)colspan="2"([^>]*)>\s*(?:<div>)?\s*Kolom\s*10\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div></th>', $tableHtml);
            $tableHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*10\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div></th>', $tableHtml);
            $tableHtml = preg_replace('/>\s*Kolom\s*10\s*</i', '>Lain-lain<', $tableHtml);
            $tableHtml = preg_replace('/Kolom\s*10/i', 'Lain-lain', $tableHtml);
        }
        if ($tableCode === '4.1.23' || (stripos($tableHtml, 'Penggolongan') !== false && stripos($tableHtml, '100') !== false)) {
            $tableHtml = preg_replace(
                '/<th([^>]*)colspan="2"([^>]*)>\s*(?:<div>)?\s*Kolom\s*2\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div></th>' . "\n" . '        <th class="py-3 px-4 font-bold border border-slate-700"><div>0</div></th>',
                $tableHtml
            );
            $tableHtml = preg_replace(
                '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*2\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div></th>',
                $tableHtml
            );
        }
        if ($tableCode === '4.5.2' || (stripos($tableHtml, 'Pidana') !== false && stripos($tableHtml, 'Lalu Lintas') !== false && stripos($tableHtml, 'Perkara yang Masuk') !== false)) {
            $tableHtml = preg_replace(
                '/<th([^>]*)colspan=["\']?\d+["\']?([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                $tableHtml
            );
            $tableHtml = preg_replace(
                '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                $tableHtml
            );
        }
        if ($tableCode === '4.5.4' || (stripos($tableHtml, 'Pidana') !== false && stripos($tableHtml, 'SPDP') !== false)) {
            $tableHtml = preg_replace(
                '/<th([^>]*)colspan=["\']?\d+["\']?([^>]*)>\s*(?:<div>)?\s*Kolom\s*7\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                $tableHtml
            );
            $tableHtml = preg_replace(
                '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*7\s*(?:<\/div>)?\s*<\/th>/i',
                '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                $tableHtml
            );
        }
        if ($tableCode === '8.1.10' || (stripos($tableHtml, 'Tabrakan') !== false && stripos($tableHtml, 'Kecelakaan') !== false)) {
            $tableHtml = preg_replace('/Taksi[^\/<\n]*Kerugi[^\/<\n]*(?:\([^\)]*\))?/i', 'Taksiran Kerugian Material (Rp)', $tableHtml);
            $tableHtml = preg_replace('/Sligly/i', 'Slightly', $tableHtml);
            $tableHtml = preg_replace('/Severly/i', 'Severely', $tableHtml);
        }

        // 2. Parse baris data dari Excel hasil bacaan Laravel Excel
        $foundColNumberRow = false;
        $excelDataRows = [];

        // Deteksi apakah tabel ini berbasis baris tahun (misal: 4.1.18, 4.1.19, 8.1.1, 8.1.2, 8.1.3, 8.1.6, 8.1.7, 8.1.8, 1.1.10)
        $isYearRowTable = in_array($tableCode, ['4.1.18', '4.1.19', '8.1.1', '8.1.2', '8.1.3', '8.1.6', '8.1.7', '8.1.8', '1.1.10', '8.2.2', '2.2.5', '9.1', '9.3', '2.4.3', '2.4.1', '2.4.2']);

        foreach ($excelRows as $row) {
            if (!is_array($row)) continue;
            $cells = array_map(fn($c) => $c !== null ? trim((string)$c) : '', $row);
            $nonEmpty = array_values(array_filter($cells, fn($c) => $c !== ''));
            if (empty($nonEmpty)) continue;

            // Lewati seluruh baris judul & header sampai melewati baris penomoran (1), (2), dst ATAU -1, -2, dst
            if (!$foundColNumberRow) {
                $isColNumRow = false;
                foreach ($cells as $c) {
                    if (preg_match('/^\(1\)$/', $c) || preg_match('/^\(1\)/', $c) || $c === '-1') {
                        $isColNumRow = true;
                        break;
                    }
                }
                if ($isColNumRow || in_array('(1)', $cells) || in_array('-1', $cells)) {
                    $foundColNumberRow = true;
                }
                continue;
            }

            $firstCell = $nonEmpty[0];

            // Hentikan jika mencapai baris catatan atau sumber
            if (preg_match('/^(?:Sumber|Source|Catatan|Note)\b/i', $firstCell)) {
                break;
            }

            // Lewati jika baris ini ternyata duplikasi penomoran kolom (-1, -2, (1), (2), dsb)
            if (in_array('(1)', $cells) || in_array('-1', $cells) || preg_match('/^(?:-1|\(1\))$/', $firstCell)) {
                continue;
            }

            // Lewati baris yang mengulang header tabel (seperti "Perguruan Tinggi", "Kecamatan", "Sekolah", "Guru", "Murid", "Negeri", "Swasta", dsb)
            if (preg_match('/^(?:Tabel|Table|Perguruan\s+Tinggi|College|Mahasiswa|Lulusan|Dosen|Lecturer|Kecamatan|District|Sekolah|Schools|Guru|Teachers|Murid|Students|Negeri|Public|Swasta|Private)\b/i', $firstCell)) {
                continue;
            }
            if (preg_match('/^\d{4}\s*\/\s*\d{4}$/', $firstCell)) {
                continue;
            }

            // Ekstrak label baris dan daftar nilai selnya
            $label = '';
            $vals = [];
            $passedLabel = false;
            foreach ($cells as $c) {
                if (!$passedLabel) {
                    if ($c !== '') {
                        $label = $c;
                        $passedLabel = true;
                    }
                    continue;
                }
                $vals[] = ($c !== '') ? $c : '-';
            }

            if (!empty($label)) {
                // Khusus tabel 8.1.10 dan 11.3: Bersihkan pergeseran kolom akibat kolom A dan B yang di-merge di Excel sehingga kolom B kosong
                if ($tableCode === '8.1.10') {
                    $isMonth = (bool) preg_match('/(?:Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|April|May|June|July|August|September|October|November|December)/i', $label);
                    if ($isMonth && count($vals) === 6 && ($vals[0] === '-' || $vals[0] === '' || $vals[0] === null)) {
                        array_shift($vals);
                    }
                } elseif ($tableCode === '11.3') {
                    $isMonth = (bool) preg_match('/(?:Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|April|May|June|July|August|September|October|November|December)/i', $label);
                    $isSiup = (bool) preg_match('/\(SIUP\)/i', $label);
                    if (($isMonth || $isSiup) && count($vals) >= 2 && ($vals[0] === '-' || $vals[0] === '' || $vals[0] === null)) {
                        array_shift($vals);
                    }
                }

                // Untuk tabel baris tahun: abaikan jika bukan tahun 4 digit dan bukan Total
                if ($isYearRowTable) {
                    if (!preg_match('/^(?:19|20)\d{2}$/', $label) && !preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $label)) {
                        continue;
                    }
                }

                $excelDataRows[] = [
                    'label' => $label,
                    'normLabel' => $this->normalizeRowLabel($label),
                    'values' => $vals,
                    'isTotal' => (bool) preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $label),
                ];
            }
        }

        // Fallback jika baris penomoran (1) tidak ditemukan
        if (empty($excelDataRows)) {
            foreach ($excelRows as $row) {
                if (!is_array($row)) continue;
                $cells = array_map(fn($c) => $c !== null ? trim((string)$c) : '', $row);
                $nonEmpty = array_values(array_filter($cells, fn($c) => $c !== ''));
                if (empty($nonEmpty)) continue;

                $firstCell = $nonEmpty[0];
                if (preg_match('/^(?:Tabel|Table|Sumber|Source|Catatan|Note|Perguruan\s+Tinggi|College|Mahasiswa|Lulusan|Dosen|Lecturer)\b/i', $firstCell)) continue;
                if (preg_match('/^(?:\(1\)|-1)$/i', $firstCell) || in_array('(1)', $cells) || in_array('-1', $cells) || (in_array('(1)', $cells) && in_array('(2)', $cells))) continue;

                $label = '';
                $vals = [];
                $passedLabel = false;
                foreach ($cells as $c) {
                    if (!$passedLabel) {
                        if ($c !== '') {
                            $label = $c;
                            $passedLabel = true;
                        }
                        continue;
                    }
                    $vals[] = ($c !== '') ? $c : '-';
                }

                if (!empty($label)) {
                    // Khusus tabel 8.1.10 dan 11.3: Bersihkan pergeseran kolom akibat kolom A dan B yang di-merge di Excel sehingga kolom B kosong
                    if ($tableCode === '8.1.10') {
                        $isMonth = (bool) preg_match('/(?:Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|April|May|June|July|August|September|October|November|December)/i', $label);
                        if ($isMonth && count($vals) === 6 && ($vals[0] === '-' || $vals[0] === '' || $vals[0] === null)) {
                            array_shift($vals);
                        }
                    } elseif ($tableCode === '11.3') {
                        $isMonth = (bool) preg_match('/(?:Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|April|May|June|July|August|September|October|November|December)/i', $label);
                        $isSiup = (bool) preg_match('/\(SIUP\)/i', $label);
                        if (($isMonth || $isSiup) && count($vals) >= 2 && ($vals[0] === '-' || $vals[0] === '' || $vals[0] === null)) {
                            array_shift($vals);
                        }
                    }

                    if ($isYearRowTable) {
                        if (!preg_match('/^(?:19|20)\d{2}$/', $label) && !preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $label)) {
                            continue;
                        }
                    }

                    $excelDataRows[] = [
                        'label' => $label,
                        'normLabel' => $this->normalizeRowLabel($label),
                        'values' => $vals,
                        'isTotal' => (bool) preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $label),
                    ];
                }
            }
        }

        if (empty($excelDataRows)) {
            return $tableHtml;
        }

        // 3. Terapkan data ke dalam <tbody> dengan styling resmi BPS
        return preg_replace_callback('/<tbody([^>]*)>(.*?)<\/tbody>/is', function($tbodyMatch) use ($excelDataRows, $tableCode, $isYearRowTable) {
            $tbodyAttr = ' class="bg-[#fef9c3] text-slate-900 font-medium"';
            $tbodyHtml = $tbodyMatch[2];

            // Bersihkan baris hantu (duplikasi header / nomor kolom) yang sudah terlanjur tersimpan di <tbody>
            $tbodyHtml = preg_replace_callback('/<tr[^>]*>(.*?)<\/tr>/is', function($trM) use ($isYearRowTable) {
                if (preg_match('/<td[^>]*>(.*?)<\/td>/is', $trM[1], $firstTd)) {
                    $rawText = trim(strip_tags($firstTd[1]));
                    if (str_contains($rawText, 'Perguruan Tinggi') || str_contains($rawText, 'College')) {
                        return '';
                    }
                    if ($rawText === '-1' || $rawText === '(1)' || preg_match('/^-1\b/', $rawText)) {
                        preg_match_all('/<td[^>]*>/i', $trM[1], $allTds);
                        if (count($allTds[0]) >= 7) {
                            return $trM[0];
                        }
                        return '';
                    }
                    if ($isYearRowTable && !preg_match('/^(?:19|20)\d{2}$/', $rawText) && !preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $rawText)) {
                        return '';
                    }
                }
                return $trM[0];
            }, $tbodyHtml);

            $excelCursor = 0;
            $usedExcelIndices = [];

            // Ganti nilai sel pada baris data yang sudah ada di HTML
            $newTbody = preg_replace_callback('/<tr([^>]*)>(.*?)<\/tr>/is', function($trMatch) use (&$excelCursor, &$usedExcelIndices, $excelDataRows, $isYearRowTable) {
                $trAttr = trim($trMatch[1]);
                $rowHtml = $trMatch[2];

                preg_match_all('/<td([^>]*)>(.*?)<\/td>/is', $rowHtml, $tdMatches, PREG_SET_ORDER);
                if (empty($tdMatches)) return $trMatch[0];

                $rawRowLabel = trim(strip_tags($tdMatches[0][2]));
                $normRowLabel = $this->normalizeRowLabel($rawRowLabel);

                // Cek jika baris ini adalah subheader atau pemisah di tabel multi-bagian (Guru, Murid, Sekolah, Tahun, Nomor Kolom)
                $isSubheaderRow = str_contains($trAttr, 'subtable-spacer-row') ||
                                  str_contains($trAttr, 'subtable-header') ||
                                  str_contains($rowHtml, '&nbsp;') ||
                                  (preg_match('/(?:Guru|Teachers|Murid|Students|Sekolah|Schools|Kangkung|Tomat|Sayuran|Vegetables)/i', $rowHtml) && preg_match('/(?:Kecamatan|District|Jumlah|Total)/i', $rowHtml)) ||
                                  (preg_match('/(?:Negeri|Public)/i', $rowHtml) && preg_match('/(?:Swasta|Private)/i', $rowHtml)) ||
                                  (preg_match('/\b\d{4}\s*\/\s*\d{4}\b/', $rowHtml) && count($tdMatches) >= 6) ||
                                  (count($tdMatches) >= 6 && (str_contains($rawRowLabel, '-1') || str_contains($rawRowLabel, '(1)')));

                if ($isSubheaderRow) {
                    return $trMatch[0];
                }

                $isTotalRow = preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $rawRowLabel);

                if ($isTotalRow) {
                    $trAttr = ' class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700"';
                } else {
                    $trAttr = ' class="hover:bg-amber-100/60 transition-colors"';
                }

                // Cocokkan ke baris Excel
                $matchedIdx = null;

                // Prioritas 1: Kecocokan persis label normalisasi yang belum digunakan
                foreach ($excelDataRows as $idx => $eRow) {
                    if (isset($usedExcelIndices[$idx])) continue;
                    if ($eRow['normLabel'] === $normRowLabel) {
                        $matchedIdx = $idx;
                        break;
                    }
                }

                // Prioritas 2: Kecocokan substring jika belum cocok
                if ($matchedIdx === null && !empty($normRowLabel)) {
                    foreach ($excelDataRows as $idx => $eRow) {
                        if (isset($usedExcelIndices[$idx])) continue;
                        if (!empty($eRow['normLabel'])) {
                            if (str_contains($eRow['normLabel'], $normRowLabel) || str_contains($normRowLabel, $eRow['normLabel'])) {
                                $matchedIdx = $idx;
                                break;
                            }
                        }
                    }
                }

                // Prioritas 3: Sequential fallback (HANYA jika bukan baris tahun / bukan tabel baris tahun)
                $isYearRow = (bool) preg_match('/^(?:19|20)\d{2}$/', $rawRowLabel);
                if ($matchedIdx === null && !$isYearRow && !$isYearRowTable) {
                    while (isset($usedExcelIndices[$excelCursor]) && $excelCursor < count($excelDataRows)) {
                        $excelCursor++;
                    }
                    if (isset($excelDataRows[$excelCursor])) {
                        $matchedIdx = $excelCursor;
                    }
                }

                if ($matchedIdx !== null) {
                    $usedExcelIndices[$matchedIdx] = true;
                    $matchedRow = $excelDataRows[$matchedIdx];
                    $dataValues = $matchedRow['values'];

                    // Safeguard: Jika baris HTML memiliki kolom label pertama dengan colspan >= 2 (misal baris bulan pada sel gabung A+B di Excel),
                    // dan dataValues[0] bernilai kosong/'-' sementara terdapat nilai data pada dataValues berikutnya,
                    // maka geser dataValues agar nilai data riil dari kolom C Excel tidak terbuang.
                    $hasFirstColspan2 = (bool) preg_match('/<td[^>]*colspan=["\']?[2-9]["\']?/i', $tdMatches[0][0]);
                    if ($hasFirstColspan2 && count($dataValues) >= 2 && ($dataValues[0] === '-' || $dataValues[0] === '' || $dataValues[0] === null) && ($dataValues[1] !== '-' && $dataValues[1] !== '' && $dataValues[1] !== null)) {
                        array_shift($dataValues);
                    }

                    $cellIndex = 0;
                    $valIndex = 0;
                    $newRowHtml = preg_replace_callback('/<td([^>]*)>(.*?)<\/td>/is', function($tdMatch) use (&$cellIndex, &$valIndex, $dataValues, $isTotalRow) {
                        $cellIndex++;
                        $attr = trim($tdMatch[1]);

                        if ($cellIndex === 1) {
                            // Pertahankan label sel pertama dengan border slate rapi dan pertahankan colspan/rowspan jika ada
                            $spans = '';
                            if (preg_match('/\bcolspan=["\']?(\d+)["\']?/i', $attr, $cm)) {
                                $spans .= ' colspan="' . $cm[1] . '"';
                            }
                            if (preg_match('/\browspan=["\']?(\d+)["\']?/i', $attr, $rm)) {
                                $spans .= ' rowspan="' . $rm[1] . '"';
                            }
                            return "<td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-top\"{$spans}>{$tdMatch[2]}</td>";
                        }

                        if (isset($dataValues[$valIndex])) {
                            $insertVal = $dataValues[$valIndex];
                            $valIndex++;

                            if (is_numeric($insertVal)) {
                                $cleanNum = (float)$insertVal == (int)$insertVal ? (string)(int)$insertVal : (string)$insertVal;
                            } else {
                                $cleanNum = trim($insertVal);
                                if ($cleanNum === '' || $cleanNum === '...') $cleanNum = '-';
                            }

                            $alignClass = 'text-center align-middle';
                            $boldClass = $isTotalRow ? ' font-extrabold' : ' font-medium';

                            if ($cleanNum === '-' || $cleanNum === '–' || $cleanNum === '—') {
                                return "<td class=\"py-2.5 px-4 border border-slate-700 {$alignClass}\"><span class=\"text-slate-400 font-normal\">-</span></td>";
                            }

                            return "<td class=\"py-2.5 px-4 border border-slate-700 {$alignClass}{$boldClass}\">{$cleanNum}</td>";
                        }

                        return $tdMatch[0];
                    }, $rowHtml);

                    return "<tr{$trAttr}>{$newRowHtml}</tr>";
                }

                return "<tr{$trAttr}>{$rowHtml}</tr>";
            }, $tbodyHtml);

            // 4. Masukkan baris baru dari Excel yang belum ada di HTML (misal 18 partai Pemilu 2024)
            // Khusus tabel berurutan tahun, kecamatan, bulan, atau tabel berstruktur tetap: JANGAN menumpuk baris ekstra ke bawah!
            $isDistrictTable = (bool) preg_match('/(?:Kecamatan|District|Guguk Panjang|Mandiangin)/i', $tbodyHtml);
            $isMonthTable = (bool) preg_match('/(?:Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|May|June|July|August|October|December)/i', $tbodyHtml);
            $isFixedTable = in_array($tableCode, ['11.3', '1.1.10', '4.2.3', '4.2.2', '8.1.10', '4.1.21', '4.2.12']);

            $extraRowsHtml = '';
            if (!$isYearRowTable && !$isDistrictTable && !$isMonthTable && !$isFixedTable) {
                foreach ($excelDataRows as $idx => $eRow) {
                    if (!isset($usedExcelIndices[$idx]) && !$eRow['isTotal']) {
                        $lbl = trim($eRow['label']);
                        // Jangan pernah memasukkan header atau nomor kolom Excel sebagai baris baru
                        if (preg_match('/^(?:-?\d+|\(\d+\))$/', $lbl) && (int)$lbl < 100) continue;
                        if (preg_match('/(?:Perguruan\s+Tinggi|College|Mahasiswa|Lulusan|Dosen|Lecturer)/i', $lbl)) continue;
                        if ($isYearRowTable && !preg_match('/^(?:19|20)\d{2}$/', $lbl)) continue;

                        $rowClass = 'hover:bg-amber-100/60 transition-colors';
                        $rowContent = "<td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-top\">" . htmlspecialchars($eRow['label']) . "</td>";
                        foreach ($eRow['values'] as $v) {
                            $vStr = is_numeric($v) ? ((float)$v == (int)$v ? (string)(int)$v : (string)$v) : trim($v);
                            if ($vStr === '' || $vStr === '-' || $vStr === '–' || $vStr === '—' || $vStr === '...') {
                                $rowContent .= "<td class=\"py-2.5 px-4 border border-slate-700 text-center align-middle\"><span class=\"text-slate-400 font-normal\">-</span></td>";
                            } else {
                                $rowContent .= "<td class=\"py-2.5 px-4 border border-slate-700 text-center align-middle font-medium\">" . htmlspecialchars($vStr) . "</td>";
                            }
                        }
                        $extraRowsHtml .= "<tr class=\"{$rowClass}\">{$rowContent}</tr>\n";
                    }
                }
            }

            if (!empty($extraRowsHtml)) {
                // Sisipkan baris baru tepat sebelum baris total jika ada
                if (preg_match('/(<tr[^>]*>(?:(?!<\/tr>).)*?(?:Jumlah|Total|BUKITTINGGI)(?:(?!<\/tr>).)*?<\/tr>)/is', $newTbody, $mTot)) {
                    $newTbody = str_replace($mTot[1], $extraRowsHtml . $mTot[1], $newTbody);
                } else {
                    $newTbody .= "\n" . $extraRowsHtml;
                }
            }

            return "<tbody{$tbodyAttr}>{$newTbody}</tbody>";
        }, $tableHtml);
    }

    /**
     * Bersihkan / pulihkan angka desimal dari Time / Date Serial Excel & Google Sheets (tahun 1899/1900)
     */
    protected function cleanExcelDateSerials(?string $text): ?string
    {
        if (!$text) return $text;

        $pattern = '/(?:(\d{1,2})[\/\-\.](\d{1,2})[\/\-\.](1900|1899)|(1900|1899)[\/\-\.](\d{1,2})[\/\-\.](\d{1,2}))(?:\s+|T)(\d{1,2})[:\.](\d{2})(?:[:\.](\d{2}))?(?:\s*(AM|PM))?/i';
        $text = preg_replace_callback($pattern, function ($m) {
            $year = !empty($m[3]) ? (int)$m[3] : (int)$m[4];
            $day = !empty($m[3]) ? (int)$m[1] : (int)$m[6];
            $hours = (int)$m[7];
            $mins = (int)$m[8];
            $secs = !empty($m[9]) ? (int)$m[9] : 0;
            $ampm = !empty($m[10]) ? strtoupper($m[10]) : null;

            if ($ampm === 'PM' && $hours < 12) $hours += 12;
            if ($ampm === 'AM' && $hours === 12) $hours = 0;

            $dayCount = ($year === 1900) ? $day : 0;
            $fraction = ($hours * 3600 + $mins * 60 + $secs) / 86400;
            $total = $dayCount + $fraction;
            $formatted = rtrim(rtrim(number_format($total, 4, '.', ''), '0'), '.');
            if (preg_match('/^\d+\.\d$/', $formatted)) {
                $formatted .= '0';
            }
            return str_replace('.', ',', $formatted);
        }, $text);

        // Serial tanggal 1900 saja (misal "01/01/1900" -> 1, "02/01/1900" -> 2)
        $text = preg_replace('/\b0?([1-9]|[12]\d|3[01])[\/\-\.]0?1[\/\-\.]1900\b/', '$1', $text);
        $text = preg_replace('/\b1900[\/\-\.]0?1[\/\-\.]0?([1-9]|[12]\d|3[01])\b/', '$1', $text);

        return $text;
    }

    /**
     * Format nilai angka ribuan dengan titik pemisah untuk tabel keuangan
     */
    private function formatFinancialHtml(?string $html, string $opdCode, string $tableCode): ?string
    {
        if (!$html) return $html;
        $isFinancial = ($opdCode === '05' || str_starts_with($tableCode, '2.4'));
        if (!$isFinancial) return $html;

        return preg_replace_callback('/<td([^>]*)>(.*?)<\/td>/is', function ($matches) {
            $attrs = $matches[1];
            $content = $matches[2];
            
            $clean = trim(strip_tags($content));
            if (preg_match('/^-?\d+(\.\d+)?$/', $clean)) {
                if (preg_match('/^(19|20)\d{2}$/', $clean)) {
                    return $matches[0];
                }
                $formatted = $this->formatNumberDots($clean);
                if (!str_contains($attrs, 'text-right')) {
                    if (str_contains($attrs, 'class="')) {
                        $attrs = preg_replace('/class="([^"]*)"/', 'class="$1 text-right font-medium"', $attrs);
                    } else {
                        $attrs .= ' class="text-right font-medium"';
                    }
                }
                return "<td{$attrs}>{$formatted}</td>";
            }
            
            return $matches[0];
        }, $html);
    }

    /**
     * Format string angka menjadi ribuan dengan titik
     */
    private function formatNumberDots(string $numStr): string
    {
        $parts = explode('.', $numStr);
        $intPart = $parts[0];
        $decPart = isset($parts[1]) ? ',' . $parts[1] : '';
        
        $sign = '';
        if (str_starts_with($intPart, '-')) {
            $sign = '-';
            $intPart = substr($intPart, 1);
        }

        $len = strlen($intPart);
        if ($len > 3) {
            $reversed = strrev($intPart);
            $chunks = str_split($reversed, 3);
            $formattedInt = strrev(implode('.', $chunks));
        } else {
            $formattedInt = $intPart;
        }

        return $sign . $formattedInt . $decPart;
    }
}
