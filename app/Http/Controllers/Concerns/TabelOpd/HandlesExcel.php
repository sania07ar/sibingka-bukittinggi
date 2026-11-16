<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

use App\Models\TabelData;
use App\Models\TabelMetadata;
use App\Models\TabelComment;
use App\Exports\TableOpdExport;
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

        if ($type !== 'bps' && $type !== 'instansi') {
            $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
        }

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

        if ($type !== 'bps' && $type !== 'instansi') {
            $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
        }

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
            $meta->source_type = ($type === 'bps' ? 'custom_bps' : 'custom_instansi');
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

            if (!$fallback) {
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
            $rows = $sheets[0] ?? [];

            if (empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berkas Excel kosong atau tidak terbaca.',
                ], 400);
            }

            // Ekstrak Title & Source / Note dari berkas Excel jika tersedia
            $excelTitleId = '';
            $excelTitleEn = '';
            $excelSource = '';
            $excelNote = '';

            for ($r = 0; $r < min(count($rows), 5); $r++) {
                $rCells = array_values(array_filter(array_map('trim', $rows[$r] ?? []), fn($c) => $c !== ''));
                if (count($rCells) === 1) {
                    $cText = $rCells[0];
                    if (preg_match('/^Tabel\b/i', $cText) || (preg_match('/\b(Jumlah|Banyaknya|Panjang|Luas|Rata-rata|Realisasi|Persentase)\b/i', $cText) && !$excelTitleId)) {
                        $excelTitleId = preg_replace('/^Tabel\s*[\d\.]*\s*/i', '', $cText);
                    } elseif (preg_match('/^Table\b/i', $cText) || (preg_match('/\b(Number|Length|Wide|Average|Percentage|Total)\b/i', $cText) && !$excelTitleEn)) {
                        $excelTitleEn = preg_replace('/^Table\s*[\d\.]*\s*/i', '', $cText);
                    }
                }
            }

            for ($r = count($rows) - 1; $r >= max(0, count($rows) - 6); $r--) {
                $rText = implode(' ', array_filter(array_map('trim', $rows[$r] ?? []), fn($c) => $c !== ''));
                if (preg_match('/^(?:Sumber\s*[\/:]|Source\s*[\/:]|Sumber:|Source:)\s*(.*)$/i', $rText, $mSrc)) {
                    $excelSource = trim($mSrc[1]);
                } elseif (preg_match('/^(?:Catatan\s*[\/:]|Note\s*[\/:]|Catatan:|Note:)\s*(.*)$/i', $rText, $mNote)) {
                    $excelNote = trim($mNote[1]);
                }
            }

            if (!empty($excelTitleId)) $meta->title_id = $excelTitleId;
            if (!empty($excelTitleEn)) $meta->title_en = $excelTitleEn;
            if (!empty($excelSource)) $meta->source = $excelSource;
            if (!empty($excelNote)) $meta->note = $excelNote;

            // 3. Terapkan data Excel ke struktur tabel:
            // Jika tabel sudah memiliki template BPS yang rapi, petakan baris Excel ke dalam struktur tersebut ("sesuaikan isian yang ada")
            if (!empty($meta->table_html) && !$this->isDummyOrPlaceholderTable($meta->table_html)) {
                $updatedHtml = $this->applyExcelRowsToTableHtml($meta->table_html, $rows, $tableCode);
            } else {
                // Jika sama sekali tidak ada template di database, bangun dari baris Excel
                $generatedHtml = $this->buildTableHtmlFromExcelRows($rows, $tableCode, $year);
                $updatedHtml = !empty($generatedHtml) ? $generatedHtml : ($meta->table_html ?? '');
            }

            $schoolCodes = ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'];
            if (in_array($tableCode, $schoolCodes)) {
                $updatedHtml = $this->build3in1EducationHtml($year, $updatedHtml);
            }

            $updatedHtml = $this->cleanExcelDateSerials($updatedHtml);
            $updatedHtml = $this->formatFinancialHtml($updatedHtml, $opdCode, $tableCode);

            $meta->table_html = $updatedHtml;
            $meta->is_saved = true;
            $meta->source_type = ($type === 'bps' ? 'custom_bps' : 'custom_instansi');
            $meta->save();

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
     * Membangun struktur table_html lengkap (thead dan tbody) langsung dari baris Excel
     * Mencegah himpitan/tumpukan data Excel ke struktur tabel lama atau placeholder
     */
    public function buildTableHtmlFromExcelRows(array $excelRows, string $tableCode = '', int $year = 2025): string
    {
        // 1. Temukan baris penomoran (1), (2), (3)... atau -1, -2, -3...
        $numRowIdx = null;
        $rawNumRow = [];
        $minPhysicalCol = 0;

        foreach ($excelRows as $rIdx => $row) {
            if (!is_array($row)) continue;
            foreach ($row as $cIdx => $c) {
                $cStr = trim((string)$c);
                if ($cStr === '(1)' || $cStr === '-1' || (preg_match('/^\(1\)/', $cStr) && (in_array('(2)', array_map('trim', $row)) || in_array('-2', array_map('trim', $row))))) {
                    $numRowIdx = $rIdx;
                    $rawNumRow = $row;
                    $minPhysicalCol = $cIdx;
                    break 2;
                }
            }
        }

        if ($numRowIdx === null) {
            return '';
        }

        // Hitung total kolom fisik di spreadsheet (panjang baris data/total)
        $maxPhysicalCols = 0;
        foreach ($excelRows as $rIdx => $r) {
            if ($rIdx >= $numRowIdx && is_array($r)) {
                $nonEmptyIndices = array_keys(array_filter($r, fn($val) => $val !== null && trim((string)$val) !== ''));
                if (!empty($nonEmptyIndices)) {
                    $maxPhysicalCols = max($maxPhysicalCols, max($nonEmptyIndices) + 1);
                }
            }
        }

        if ($maxPhysicalCols <= $minPhysicalCol) {
            return '';
        }

        // Deteksi apakah kolom awal memiliki colspan 2 (misal Col 0 terisi, Col 1 null/kosong pada penomoran dan header)
        $firstColColspan2 = false;
        if (($maxPhysicalCols - $minPhysicalCol) >= 2) {
            $numCol0 = trim((string)($rawNumRow[$minPhysicalCol] ?? ''));
            $numCol1 = trim((string)($rawNumRow[$minPhysicalCol + 1] ?? ''));
            if (($numCol0 === '(1)' || $numCol0 === '-1') && ($numCol1 === '' || $numCol1 === null)) {
                $firstColColspan2 = true;
            }
        }

        // 2. Ambil baris-baris header sebelum baris penomoran
        $headerRows = [];
        for ($r = 0; $r < $numRowIdx; $r++) {
            $row = $excelRows[$r] ?? [];
            if (!is_array($row)) continue;
            $cells = array_map(fn($c) => $c !== null ? trim((string)$c) : '', $row);
            $nonEmpty = array_values(array_filter($cells, fn($x) => $x !== ''));
            if (empty($nonEmpty)) continue;
            if (preg_match('/^(?:Tabel|Table)\b/i', $nonEmpty[0])) continue;
            if (count($nonEmpty) === 1 && preg_match('/^(?:Jumlah|Banyaknya|Number|Total)/i', $nonEmpty[0])) continue;
            $headerRows[] = $row;
        }

        $theadHtml = "<thead>\n";
        foreach ($headerRows as $hRow) {
            $theadHtml .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">\n";
            $cIdx = $minPhysicalCol;
            while ($cIdx < $maxPhysicalCols) {
                $cellVal = trim((string)($hRow[$cIdx] ?? ''));
                $isCol0Colspan = ($cIdx === $minPhysicalCol && $firstColColspan2);
                $colspanAttr = $isCol0Colspan ? ' colspan="2"' : '';

                if (str_contains($cellVal, '/')) {
                    $parts = explode('/', $cellVal, 2);
                    $cellInner = '<div>' . htmlspecialchars(trim($parts[0])) . '</div><div class="italic font-normal text-[11px] sm:text-xs">' . htmlspecialchars(trim($parts[1])) . '</div>';
                } else {
                    $cellInner = '<div>' . htmlspecialchars($cellVal ?: '-') . '</div>';
                }

                $theadHtml .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\"{$colspanAttr}>{$cellInner}</th>\n";
                $cIdx += $isCol0Colspan ? 2 : 1;
            }
            $theadHtml .= "    </tr>\n";
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
            if (preg_match('/(?:Jumlah|Total)/i', $c0) && preg_match('/^(?:19|20)\d{2}$/', $c1)) {
                $historicalTotalStartIdx = $bIdx;
                $historicalTotalSpan = 1;
                for ($k = $bIdx + 1; $k < count($bodyRows); $k++) {
                    $subC0 = trim((string)($bodyRows[$k][$minPhysicalCol] ?? ''));
                    $subC1 = trim((string)($bodyRows[$k][$minPhysicalCol + 1] ?? ''));
                    if (($subC0 === '' || $subC0 === null) && preg_match('/^(?:19|20)\d{2}$/', $subC1)) {
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
                $tbodyHtml .= "        <td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle font-bold\">" . htmlspecialchars($c1) . "</td>\n";
                for ($c = $minPhysicalCol + 2; $c < $maxPhysicalCols; $c++) {
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

        // 2. Parse baris data dari Excel hasil bacaan Laravel Excel
        $foundColNumberRow = false;
        $excelDataRows = [];

        // Deteksi apakah tabel ini berbasis baris tahun (misal: 4.1.18, 4.1.19, 8.1.4, 8.1.5, 8.1.6, 1.1.10)
        $isYearRowTable = in_array($tableCode, ['4.1.18', '4.1.19']) || str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['1.1.10']);

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
            $newTbody = preg_replace_callback('/<tr([^>]*)>(.*?)<\/tr>/is', function($trMatch) use (&$excelCursor, &$usedExcelIndices, $excelDataRows) {
                $trAttr = trim($trMatch[1]);
                $rowHtml = $trMatch[2];

                preg_match_all('/<td([^>]*)>(.*?)<\/td>/is', $rowHtml, $tdMatches, PREG_SET_ORDER);
                if (empty($tdMatches)) return $trMatch[0];

                $rawRowLabel = trim(strip_tags($tdMatches[0][2]));
                $normRowLabel = $this->normalizeRowLabel($rawRowLabel);

                // Cek jika baris ini adalah subheader atau pemisah di tabel multi-bagian (Guru, Murid, Sekolah, Tahun, Nomor Kolom)
                $isSubheaderRow = str_contains($trAttr, 'subtable-spacer-row') ||
                                  str_contains($rowHtml, '&nbsp;') ||
                                  (preg_match('/(?:Guru|Teachers|Murid|Students|Sekolah|Schools)/i', $rowHtml) && preg_match('/(?:Kecamatan|District|Jumlah|Total)/i', $rowHtml)) ||
                                  (preg_match('/(?:Negeri|Public)/i', $rowHtml) && preg_match('/(?:Swasta|Private)/i', $rowHtml)) ||
                                  (preg_match('/\b\d{4}\s*\/\s*\d{4}\b/', $rowHtml) && count($tdMatches) >= 6) ||
                                  (count($tdMatches) >= 7 && (str_contains($rawRowLabel, '-1') || str_contains($rawRowLabel, '(1)')));

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

                    $cellIndex = 0;
                    $valIndex = 0;
                    $newRowHtml = preg_replace_callback('/<td([^>]*)>(.*?)<\/td>/is', function($tdMatch) use (&$cellIndex, &$valIndex, $dataValues, $isTotalRow) {
                        $cellIndex++;
                        $attr = trim($tdMatch[1]);

                        if ($cellIndex === 1) {
                            // Pertahankan label sel pertama dengan border slate rapi
                            return "<td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-top\">{$tdMatch[2]}</td>";
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
            // Khusus tabel berurutan tahun atau tabel tetap per kecamatan: jangan menumpuk baris ekstra ke bawah
            $isDistrictTable = (bool) preg_match('/(?:Kecamatan|District|Guguk Panjang|Mandiangin)/i', $tbodyHtml);
            $extraRowsHtml = '';
            if (!$isYearRowTable && !$isDistrictTable) {
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
