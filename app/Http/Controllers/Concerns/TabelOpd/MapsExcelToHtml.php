<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

/**
 * Trait untuk pemetaan baris data Excel ke struktur table_html template yang ada,
 * pembersihan serial tanggal Excel, serta pemformatan ribuan angka keuangan.
 */
trait MapsExcelToHtml
{
    /**
     * Terapkan nilai baris-baris data dari berkas Excel ke dalam struktur HTML tabel yang sudah ada.
     */
    protected function applyExcelRowsToTableHtml(string $tableHtml, array $excelRows, string $tableCode = '', int $year = 2025): string
    {
        // 1. Temukan baris penomoran (1), (2), (3)... di Excel
        $numRowIdx = null;
        $minPhysicalCol = 0;
        $maxPhysicalCol = 0;
        $hasExplicitNumRow = false;

        foreach ($excelRows as $rIdx => $row) {
            if (!is_array($row)) continue;
            foreach ($row as $cIdx => $c) {
                $cStr = trim((string)$c);
                if ($cStr === '(1)' || $cStr === '-1' || (preg_match('/^\(1\)/', $cStr) && (in_array('(2)', array_map('trim', $row)) || in_array('-2', array_map('trim', $row))))) {
                    $numRowIdx = $rIdx;
                    $minPhysicalCol = $cIdx;
                    $hasExplicitNumRow = true;
                    break 2;
                }
            }
        }

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
                    $minPhysicalCol = $firstSeqCol;
                    $hasExplicitNumRow = true;
                    break;
                }
            }
        }

        $dataStartRow = ($numRowIdx !== null) ? $numRowIdx + 1 : 1;

        // Ambil batas kolom terbesar
        for ($r = $dataStartRow; $r < count($excelRows); $r++) {
            $row = $excelRows[$r] ?? [];
            if (!is_array($row)) continue;
            foreach ($row as $cIdx => $val) {
                if (trim((string)$val) !== '') {
                    if ($cIdx > $maxPhysicalCol) $maxPhysicalCol = $cIdx;
                }
            }
        }

        // Kumpulkan baris data Excel yang valid
        $cleanDataRows = [];
        for ($r = $dataStartRow; $r < count($excelRows); $r++) {
            $row = $excelRows[$r] ?? [];
            if (!is_array($row)) continue;

            $rowData = [];
            for ($c = $minPhysicalCol; $c <= $maxPhysicalCol; $c++) {
                $rowData[] = isset($row[$c]) ? trim((string)$row[$c]) : '';
            }

            if (count(array_filter($rowData, fn($x) => $x !== '')) === 0) {
                continue;
            }

            $firstCell = $rowData[0] ?? '';
            if (preg_match('/^(Sumber|Source|Catatan|Note|Keterangan)/i', $firstCell)) {
                break;
            }

            $cleanDataRows[] = $rowData;
        }

        if (empty($cleanDataRows)) {
            return $tableHtml;
        }

        // 2. Petakan baris Excel ke dalam tag <tbody> dari $tableHtml
        return preg_replace_callback('/<tbody([^>]*)>(.*?)<\/tbody>/is', function ($matches) use ($cleanDataRows, $tableCode, $year) {
            $tbodyAttr = $matches[1];
            $tbodyHtml = $matches[2];

            // Pecah <tr> yang ada di template
            preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $tbodyHtml, $trMatches, PREG_SET_ORDER);
            if (empty($trMatches)) {
                return $matches[0];
            }

            $newTbody = '';
            $excelRowIdx = 0;
            $totalExcelRows = count($cleanDataRows);

            foreach ($trMatches as $trIdx => $trItem) {
                $fullTr = $trItem[0];
                $innerTr = $trItem[1];

                // Cek apakah baris template adalah baris pemisah / subtable header
                if (str_contains($fullTr, 'subtable-header') || str_contains($fullTr, 'subtable-spacer')) {
                    $newTbody .= $fullTr;
                    continue;
                }

                // Cek sel-sel <td> di baris template
                preg_match_all('/<td([^>]*)>(.*?)<\/td>/is', $innerTr, $tdMatches, PREG_SET_ORDER);
                if (empty($tdMatches)) {
                    $newTbody .= $fullTr;
                    continue;
                }

                if ($excelRowIdx >= $totalExcelRows) {
                    $newTbody .= $fullTr;
                    continue;
                }

                $excelRow = $cleanDataRows[$excelRowIdx];
                $excelRowIdx++;

                // Bangun ulang sel <td> dengan data dari Excel
                $newTrInner = '';
                $tdCount = count($tdMatches);

                foreach ($tdMatches as $tdColIdx => $tdItem) {
                    $tdAttr = $tdItem[1];
                    $originalContent = $tdItem[2];

                    $excelVal = $excelRow[$tdColIdx] ?? null;

                    if ($excelVal !== null && $excelVal !== '') {
                        $cleanVal = $this->cleanExcelDateSerials($excelVal);
                        $formattedVal = htmlspecialchars($cleanVal);
                    } else {
                        $formattedVal = $originalContent;
                    }

                    $newTrInner .= "<td{$tdAttr}>{$formattedVal}</td>";
                }

                // Ekstrak atribut <tr> asli
                preg_match('/^<tr([^>]*)>/is', $fullTr, $trOpenMatch);
                $trAttr = $trOpenMatch[1] ?? '';

                $newTbody .= "<tr{$trAttr}>{$newTrInner}</tr>\n";
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
        }

        $cleanInt = ltrim($intPart, '-');
        $len = strlen($cleanInt);
        if ($len > 3) {
            $reversed = strrev($cleanInt);
            $chunks = str_split($reversed, 3);
            $formattedInt = strrev(implode('.', $chunks));
        } else {
            $formattedInt = $cleanInt;
        }

        return $sign . $formattedInt . $decPart;
    }
}
