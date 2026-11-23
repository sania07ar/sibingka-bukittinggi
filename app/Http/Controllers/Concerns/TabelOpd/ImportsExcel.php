<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

use App\Models\TabelMetadata;
use App\Imports\TableOpdImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

/**
 * Trait untuk penanganan impor berkas Excel (.xlsx / .xls / .csv) ke struktur tabel SiBingka.
 */
trait ImportsExcel
{
    use BuildsExcelTableHtml, MapsExcelToHtml;

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

            // Ekstrak Catatan (Note) dan Sumber (Source) dari bagian bawah berkas Excel
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

                if ($noteRowIdx !== null && ($sourceRowIdx === null || $r < $sourceRowIdx)) {
                    if (!preg_match('/^(?:Tabel|Table)\b/i', $rText)) {
                        $noteLines[] = $rText;
                    }
                    continue;
                }

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

            // Pastikan tidak ada tag <table> atau </table> pembungkus luar agar tidak terjadi duplikasi tabel di DOM
            $updatedHtml = preg_replace('/<\/?table[^>]*>/i', '', $updatedHtml);

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
}
