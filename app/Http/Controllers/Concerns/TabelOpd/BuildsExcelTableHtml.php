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

        return "<table class=\"w-full border-collapse text-xs text-left\">\n<thead>\n{$theadHtml}</thead>\n<tbody>\n{$tbodyHtml}</tbody>\n</table>";
    }
}
