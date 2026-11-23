<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

/**
 * Trait untuk membangun struktur table_html lengkap (thead dan tbody) langsung dari baris Excel.
 */
trait BuildsExcelTableHtml
{
    /**
     * Memformat teks header sel tabel (misal memisahkan teks dwibahasa dengan slash /)
     */
    protected function formatHeaderCellText(string $val): string
    {
        $val = trim($val);
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
        // Khusus Tabel 8.1.4 (Banyak & Panjang Jembatan): Gunakan builder terstruktur multi-tahun
        // agar tidak timbul 'Kolom 2', penomoran (2)(2) ganda, atau pemecahan merged cell
        if ($tableCode === '8.1.4') {
            $custom814 = $this->buildTabel814HtmlFromExcelRows($excelRows, $year);
            if (!empty($custom814)) {
                return $custom814;
            }
        }

        // Khusus Tabel 2.2.5 (Keputusan DPRD): Gunakan builder terstruktur 22 baris & 5 tahun
        // agar tidak timbul duplikasi/dobel tabel, penomoran -1, atau kurung pada header
        if ($tableCode === '2.2.5') {
            $custom225 = $this->buildTabel225HtmlFromExcelRows($excelRows, $year);
            if (!empty($custom225)) {
                return $custom225;
            }
        }
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

        // Fallback pencarian baris penomoran jika penomoran berupa angka polos 1, 2, 3...
        if ($numRowIdx === null) {
            foreach ($excelRows as $rIdx => $row) {
                if (!is_array($row)) continue;
                $numericSequences = 0;
                $firstSeqCol = null;
                foreach ($row as $cIdx => $c) {
                    $cStr = trim((string)$c);
                    if ($cStr === '1' || $cStr === '01') {
                        $firstSeqCol = $cIdx;
                    }
                    if (is_numeric($cStr) && (int)$cStr >= 1 && (int)$cStr <= 20) {
                        $numericSequences++;
                    }
                }
                if ($numericSequences >= 2 && $firstSeqCol !== null) {
                    $numRowIdx = $rIdx;
                    $rawNumRow = $row;
                    $minPhysicalCol = $firstSeqCol;
                    $hasExplicitNumRow = true;
                    break;
                }
            }
        }

        // 2. Tentukan indeks baris data (tbody) pertama dan baris header (thead)
        $headerStartRow = 0;
        $headerEndRow = 0;

        if ($hasExplicitNumRow && $numRowIdx !== null) {
            $headerEndRow = $numRowIdx;
            $dataStartRow = $numRowIdx + 1;
            // Cari baris header teratas (yang bukan metadata tabel)
            for ($r = 0; $r < $numRowIdx; $r++) {
                $row = $excelRows[$r] ?? [];
                $nonEmpty = array_filter($row, fn($x) => trim((string)$x) !== '');
                $firstVal = trim((string)(reset($nonEmpty) ?: ''));
                if (preg_match('/^(Tabel|Table|Sumber|Source|Catatan|Note)/i', $firstVal)) {
                    continue;
                }
                if (count($nonEmpty) >= 1) {
                    $headerStartRow = $r;
                    break;
                }
            }
        } else {
            // Jika tidak ada baris (1), (2), ambil baris teratas yang berisi teks kolom
            $headerStartRow = 0;
            for ($r = 0; $r < min(count($excelRows), 15); $r++) {
                $row = $excelRows[$r] ?? [];
                $nonEmpty = array_filter($row, fn($x) => trim((string)$x) !== '');
                $firstVal = trim((string)(reset($nonEmpty) ?: ''));
                if (preg_match('/^(Tabel|Table|Sumber|Source|Catatan|Note)/i', $firstVal)) {
                    continue;
                }
                if (count($nonEmpty) >= 2) {
                    $headerStartRow = $r;
                    $headerEndRow = $r;
                    $dataStartRow = $r + 1;
                    break;
                }
            }
            if (!isset($dataStartRow)) {
                $dataStartRow = 1;
                $headerStartRow = 0;
                $headerEndRow = 0;
            }
        }

        // 3. Tentukan batas kolom fisik maksimum dari header dan data
        $maxPhysicalCol = 0;
        for ($r = $headerStartRow; $r < count($excelRows); $r++) {
            $row = $excelRows[$r] ?? [];
            if (!is_array($row)) continue;
            foreach ($row as $cIdx => $val) {
                if (trim((string)$val) !== '') {
                    if ($cIdx > $maxPhysicalCol) $maxPhysicalCol = $cIdx;
                }
            }
        }

        // Tentukan jumlah kolom tabel
        $numCols = max(1, ($maxPhysicalCol - $minPhysicalCol + 1));

        // 4. Bangun THEAD secara dinamis dari baris-baris header Excel
        $theadHtml = '';
        $headerRowsToProcess = [];
        for ($r = $headerStartRow; $r <= $headerEndRow; $r++) {
            $row = $excelRows[$r] ?? [];
            $sliced = [];
            for ($c = $minPhysicalCol; $c <= $maxPhysicalCol; $c++) {
                $sliced[] = isset($row[$c]) ? trim((string)$row[$c]) : '';
            }
            // Abaikan jika seluruhnya kosong
            if (count(array_filter($sliced, fn($x) => $x !== '')) > 0) {
                $headerRowsToProcess[] = $sliced;
            }
        }

        // Jika tidak ada header yang valid, buat header default dari jumlah kolom
        if (empty($headerRowsToProcess)) {
            $defaultRow = [];
            for ($c = 1; $c <= $numCols; $c++) {
                $defaultRow[] = ($c === 1) ? 'Rincian / Details' : "Kolom {$c}";
            }
            $headerRowsToProcess[] = $defaultRow;
        }

        // Render baris-baris thead
        $totalHeaderRows = count($headerRowsToProcess);
        foreach ($headerRowsToProcess as $hIdx => $hRow) {
            $isLastHeaderRow = ($hIdx === $totalHeaderRows - 1);
            $isNumberingRow = false;
            
            // Cek apakah baris ini baris penomoran (1), (2), (3)...
            $numCount = 0;
            foreach ($hRow as $cellVal) {
                if (preg_match('/^\(?\-?\d+\)?$/', $cellVal) && $cellVal !== '') $numCount++;
            }
            if ($numCount >= max(1, floor($numCols * 0.5))) {
                $isNumberingRow = true;
            }

            $theadHtml .= '<tr class="border-b border-slate-700 bg-[#f95a00] text-white">';
            
            // Lakukan grouping kolom jika ada sel kosong berurutan di header utama
            $c = 0;
            while ($c < $numCols) {
                $val = $hRow[$c] ?? '';
                $colspan = 1;

                if (!$isNumberingRow && $val !== '') {
                    // Cek apakah sel-sel berikutnya di baris yang sama kosong
                    while ($c + $colspan < $numCols && ($hRow[$c + $colspan] ?? '') === '') {
                        $colspan++;
                    }
                }

                $classes = 'py-3 px-4 font-bold border border-slate-700';
                if ($isNumberingRow) {
                    $classes .= ' text-center text-xs bg-[#e65100]';
                    $formattedVal = '(' . ltrim(trim($val, '() -'), '0') . ')';
                    if ($formattedVal === '()') $formattedVal = '(' . ($c + 1) . ')';
                    $theadHtml .= "<th class=\"{$classes}\">{$formattedVal}</th>";
                    $c += $colspan;
                    continue;
                }

                $colspanAttr = ($colspan > 1) ? " colspan=\"{$colspan}\"" : '';
                $formattedCell = $this->formatHeaderCellText($val ?: ($c === 0 ? 'Rincian / Details' : "Kolom " . ($c + 1)));
                $theadHtml .= "<th class=\"{$classes} text-center\"{$colspanAttr}>{$formattedCell}</th>";
                $c += $colspan;
            }

            $theadHtml .= "</tr>\n";
        }

        // 5. Bangun TBODY dari baris data Excel
        $tbodyHtml = '';
        $dataRowsCount = 0;

        for ($r = $dataStartRow; $r < count($excelRows); $r++) {
            $row = $excelRows[$r] ?? [];
            if (!is_array($row)) continue;

            $rowData = [];
            for ($c = $minPhysicalCol; $c <= $maxPhysicalCol; $c++) {
                $rowData[] = isset($row[$c]) ? trim((string)$row[$c]) : '';
            }

            // Abaikan baris kosong total
            if (count(array_filter($rowData, fn($x) => $x !== '')) === 0) {
                continue;
            }

            $firstCell = $rowData[0] ?? '';
            // Berhenti jika baris berupa Catatan / Sumber / Keterangan di bagian bawah tabel
            if (preg_match('/^(Sumber|Source|Catatan|Note|Keterangan)/i', $firstCell)) {
                break;
            }

            // Cegah duplikasi tabel jika di file Excel ada tabel kedua yang ditempel di bawahnya
            if ($dataRowsCount >= 3 && (preg_match('/^(Tabel|Table)\s*\d+/i', $firstCell) || preg_match('/^(Jenis Keputusan|Type Of Decision)/i', $firstCell))) {
                break;
            }

            // Identifikasi apakah baris ini baris Jumlah / Total
            $isTotalRow = (bool)preg_match('/^(Jumlah|Total|Rata-rata|Average)/i', $firstCell);
            
            $trClass = $isTotalRow 
                ? 'font-bold bg-[#fef9c3] hover:bg-amber-100/60 transition-colors text-slate-900 border-t-2 border-b-2 border-slate-400' 
                : ($dataRowsCount % 2 === 1 ? 'hover:bg-amber-50/40 transition-colors bg-slate-50/50' : 'hover:bg-amber-50/40 transition-colors');

            $tbodyHtml .= "<tr class=\"{$trClass}\">";

            foreach ($rowData as $colIdx => $cellVal) {
                $tdClasses = 'py-2.5 px-3 border border-slate-200';
                
                // Pembersihan nilai desimal & serial tanggal Excel
                $cellVal = $this->cleanExcelDateSerials($cellVal);

                if ($colIdx === 0) {
                    $tdClasses .= ' text-left font-medium';
                } else {
                    $isNum = is_numeric(str_replace(['.', ',', '%', ' '], '', $cellVal));
                    $tdClasses .= $isNum ? ' text-right' : ' text-center';
                }

                $displayVal = ($cellVal === '' || $cellVal === null) ? '-' : htmlspecialchars($cellVal);
                $tbodyHtml .= "<td class=\"{$tdClasses}\">{$displayVal}</td>";
            }

            $tbodyHtml .= "</tr>\n";
            $dataRowsCount++;
        }

        // Jika tidak ada data yang masuk, buat 1 baris placeholder strip
        if ($dataRowsCount === 0) {
            $tbodyHtml .= "<tr>";
            for ($c = 0; $c < $numCols; $c++) {
                $align = ($c === 0) ? 'text-left font-medium' : 'text-center';
                $tbodyHtml .= "<td class=\"py-2.5 px-3 border border-slate-200 {$align}\">-</td>";
            }
            $tbodyHtml .= "</tr>\n";
        }

        return "<thead>\n{$theadHtml}</thead>\n<tbody>\n{$tbodyHtml}</tbody>";
    }

    /**
     * Membangun HTML khusus untuk Tabel 8.1.4 yang memiliki struktur multi-tahun (Kecamatan + Jumlah per Tahun)
     * Mencegah timbulnya 'Kolom 2', penomoran (2)(2) ganda, atau baris bertumpuk.
     */
    protected function buildTabel814HtmlFromExcelRows(array $excelRows, int $year = 2025): ?string
    {
        $gp_u = '-'; $gp_p = '-';
        $mks_u = '-'; $mks_p = '-';
        $abt_u = '-'; $abt_p = '-';
        
        $yearsData = [
            2025 => ['u' => '-', 'p' => '-'],
            2024 => ['u' => '-', 'p' => '-'],
            2023 => ['u' => '-', 'p' => '-'],
            2022 => ['u' => '-', 'p' => '-'],
            2021 => ['u' => '-', 'p' => '-'],
        ];

        foreach ($excelRows as $row) {
            if (!is_array($row)) continue;
            $rowStr = implode(' ', array_map('strval', $row));
            
            if (stripos($rowStr, 'Guguk Panjang') !== false) {
                $nums = $this->extractTrailingNumbersFromRow($row);
                if (isset($nums[0])) $gp_u = $nums[0];
                if (isset($nums[1])) $gp_p = $nums[1];
            } elseif (stripos($rowStr, 'Mandiangin') !== false) {
                $nums = $this->extractTrailingNumbersFromRow($row);
                if (isset($nums[0])) $mks_u = $nums[0];
                if (isset($nums[1])) $mks_p = $nums[1];
            } elseif (stripos($rowStr, 'Aur Birugo') !== false) {
                $nums = $this->extractTrailingNumbersFromRow($row);
                if (isset($nums[0])) $abt_u = $nums[0];
                if (isset($nums[1])) $abt_p = $nums[1];
            } else {
                foreach ([2025, 2024, 2023, 2022, 2021, 2026, 2027, 2028, 2029, 2030] as $y) {
                    if (preg_match('/\b' . $y . '\b/', $rowStr)) {
                        $nums = $this->extractTrailingNumbersFromRow($row, (string)$y);
                        if (isset($nums[0])) $yearsData[$y]['u'] = $nums[0];
                        if (isset($nums[1])) $yearsData[$y]['p'] = $nums[1];
                        break;
                    }
                }
            }
        }

        $p = [2025, 2024, 2023, 2022, 2021];
        if ($year >= 2026) {
            $p = range($year, $year - 4);
        }

        $jumlahRowsHtml = '';
        foreach ($p as $idx => $y) {
            $uVal = $yearsData[$y]['u'] ?? '-';
            $pVal = $yearsData[$y]['p'] ?? '-';
            $fontSemibold = ($idx === 0) ? 'font-semibold' : '';

            $jumlahRowsHtml .= '<tr>';
            if ($idx === 0) {
                $spanCount = count($p);
                $jumlahRowsHtml .= "<td class=\"py-2.5 px-4 font-bold border border-slate-700 text-center align-middle bg-amber-50/70\" rowspan=\"{$spanCount}\">
                    <div>Jumlah</div>
                    <div class=\"italic font-normal text-xs text-slate-600\">Total</div>
                </td>";
            }
            $jumlahRowsHtml .= "<td class=\"py-2 px-3 font-bold border border-slate-700 text-center\">{$y}</td>
                <td class=\"py-2 px-3 text-center border border-slate-700 {$fontSemibold}\">{$uVal}</td>
                <td class=\"py-2 px-3 text-center border border-slate-700 {$fontSemibold}\">{$pVal}</td>
            </tr>\n";
        }

        return "<thead>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
        <th class=\"py-3 px-4 font-bold border border-slate-700 w-[50%]\" colspan=\"2\" rowspan=\"2\">
            <div>Kecamatan</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">District</div>
        </th>
        <th class=\"py-2.5 px-4 font-bold border border-slate-700 text-center w-[50%]\" colspan=\"2\">
            <div>Jembatan</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Bridge</div>
        </th>
    </tr>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
        <th class=\"py-2 px-3 font-bold border border-slate-700 w-[25%]\">
            <div>Banyaknya</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Number</div>
        </th>
        <th class=\"py-2 px-3 font-bold border border-slate-700 w-[25%]\">
            <div>Panjang</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Length</div>
        </th>
    </tr>
    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
        <th class=\"py-1 px-3 border border-slate-700 text-center\" colspan=\"2\">(1)</th>
        <th class=\"py-1 px-3 border border-slate-700 text-center\">(2)</th>
        <th class=\"py-1 px-3 border border-slate-700 text-center\">(3)</th>
    </tr>
</thead>
<tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\" colspan=\"2\">01. GUGUK PANJANG</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">{$gp_u}</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">{$gp_p}</td>
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\" colspan=\"2\">02. MANDIANGIN KOTO SELAYAN</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">{$mks_u}</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">{$mks_p}</td>
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\" colspan=\"2\">03. AUR BIRUGO TIGO BALEH</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">{$abt_u}</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">{$abt_p}</td>
    </tr>
    {$jumlahRowsHtml}
</tbody>";
    }

    /**
     * Ekstrak angka-angka numerik dari baris Excel
     */
    protected function extractTrailingNumbersFromRow(array $row, ?string $skipValue = null): array
    {
        $numbers = [];
        $foundSkip = false;
        
        foreach ($row as $cell) {
            $val = trim((string)$cell);
            if ($val === '') continue;
            
            if ($skipValue !== null && !$foundSkip && $val === $skipValue) {
                $foundSkip = true;
                continue;
            }

            $val = $this->cleanExcelDateSerials($val);
            $cleanNum = str_replace(['.', ',', ' '], '', $val);
            if (is_numeric($cleanNum) || $val === '-' || $val === '–') {
                $numbers[] = $val;
            }
        }

        if (count($numbers) > 2) {
            $numbers = array_slice($numbers, -2);
        }

        return $numbers;
    }

    /**
     * Membangun HTML khusus untuk Tabel 2.2.5 (Keputusan DPRD)
     * Mencegah timbulnya tabel ganda/dobel vertikal, -1, atau tanda kurung pada header.
     */
    protected function buildTabel225HtmlFromExcelRows(array $excelRows, int $year = 2025): ?string
    {
        $p = ($year >= 2026) ? range($year - 4, $year) : [2021, 2022, 2023, 2024, 2025];
        
        $rowDefs = [
            'peraturan_daerah' => ['label' => '01. Peraturan daerah', 'match' => 'Peraturan daerah'],
            'keputusan_dprd' => ['label' => '02. Keputusan DPRD', 'match' => 'Keputusan DPRD'],
            'keputusan_pimpinan' => ['label' => '03. Keputusan Pimpinan', 'match' => 'Keputusan Pimpinan'],
            'pernyataan' => ['label' => '04. Pernyataan', 'match' => 'Pernyataan'],
            'pernyataan_pendapat' => ['label' => '05. Pernyataan Pendapat', 'match' => 'Pernyataan Pendapat'],
            'resolusi' => ['label' => '06. Resolusi', 'match' => 'Resolusi'],
            'dengar_pendapat' => ['label' => '07. Dengar Pendapat dengan Pemerintah', 'match' => 'Dengar Pendapat'],
            'paripurna_terbuka' => ['label' => '08. Rapat Paripurna Terbuka', 'match' => 'Paripurna Terbuka'],
            'paripurna_istimewa' => ['label' => '09. Rapat Paripurna Istimewa', 'match' => 'Paripurna Istimewa'],
            'panitia_musyawarah' => ['label' => '10. Rapat Panitia Musyawarah', 'match' => 'Panitia Musyawarah'],
            'badan_kehormatan' => ['label' => '11. Rapat Badan Kehormatan', 'match' => 'Badan Kehormatan'],
            'badan_anggaran' => ['label' => '12. Rapat Panitia / Badan Anggaran', 'match' => 'Badan Anggaran'],
            'panitia_khusus' => ['label' => '13. Rapat Panitia Khusus', 'match' => 'Panitia Khusus'],
            'gabungan_komisi' => ['label' => '14. Rapat Gabungan Komisi', 'match' => 'Gabungan Komisi'],
            'rapat_komisi' => ['label' => '15. Rapat Komisi', 'match' => 'Rapat Komisi'],
            'turun_lapangan' => ['label' => '16. Turun ke Lapangan ke Kelurahan', 'match' => 'Turun ke Lapangan'],
            'keluar_daerah' => ['label' => '17. Keluar Daerah', 'match' => 'Keluar Daerah'],
            'rapat_kerja' => ['label' => '18. Rapat Kerja', 'match' => 'Rapat Kerja'],
            'penyampaian_aspirasi' => ['label' => '19. Penyampaian Aspirasi', 'match' => 'Penyampaian Aspirasi'],
            'study_banding' => ['label' => '20. Study Banding', 'match' => 'Study Banding'],
            'reses' => ['label' => '21. Reses', 'match' => 'Reses'],
            'kunker_komisi' => ['label' => '22. Kunker Komisi', 'match' => 'Kunker Komisi'],
        ];

        $matchedValues = [];
        foreach ($rowDefs as $k => $d) {
            $matchedValues[$k] = array_fill_keys($p, '-');
        }

        foreach ($excelRows as $row) {
            if (!is_array($row)) continue;
            
            foreach ($rowDefs as $k => $d) {
                // Cari kolom mana yang memuat teks kategori ini
                $labelCol = null;
                foreach ($row as $cIdx => $cell) {
                    if (stripos((string)$cell, $d['match']) !== false) {
                        $labelCol = $cIdx;
                        break;
                    }
                }

                if ($labelCol !== null) {
                    // Ambil nilai dari kolom-kolom setelah labelCol secara berurutan
                    $nums = [];
                    for ($c = $labelCol + 1; $c < count($row); $c++) {
                        $rawVal = trim((string)($row[$c] ?? ''));
                        if ($rawVal === '') {
                            $nums[] = '-';
                        } else {
                            $cleanVal = $this->cleanExcelDateSerials($rawVal);
                            $cleanVal = trim((string)$cleanVal);
                            $nums[] = ($cleanVal === '' || $cleanVal === '–') ? '-' : $cleanVal;
                        }
                    }

                    if (count($nums) >= count($p)) {
                        foreach ($p as $idx => $y) {
                            $val = $nums[$idx] ?? '-';
                            if ($val === '' || $val === '–') $val = '-';
                            $matchedValues[$k][$y] = $val;
                        }
                    }
                    break;
                }
            }
        }

        $yearsHeaders = '';
        $numHeaders = '';
        foreach ($p as $idx => $y) {
            $yearsHeaders .= "<th class=\"py-3 px-4 border border-slate-700 text-center font-bold bg-[#f95a00] text-white\">{$y}</th>";
            $numHeaders .= "<th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs bg-[#fed7aa] text-slate-900\">(" . ($idx + 2) . ")</th>";
        }

        $tbodyHtml = '';
        foreach ($rowDefs as $k => $d) {
            $tbodyHtml .= "<tr>\n<td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\">{$d['label']}</td>\n";
            foreach ($p as $y) {
                $val = $matchedValues[$k][$y] ?? '-';
                $tbodyHtml .= "<td class=\"py-2 px-3 text-center border border-slate-700\">{$val}</td>\n";
            }
            $tbodyHtml .= "</tr>\n";
        }

        return "<thead>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
        <th class=\"py-3 px-4 font-bold border border-slate-700 text-left align-middle min-w-[280px]\">
            <div>Jenis Keputusan</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Type Of Decision</div>
        </th>
        {$yearsHeaders}
    </tr>
    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
        <th class=\"py-1 px-3 border border-slate-700 text-center\">(1)</th>
        {$numHeaders}
    </tr>
</thead>
<tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
{$tbodyHtml}
</tbody>";
    }
}
