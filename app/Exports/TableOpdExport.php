<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TableOpdExport implements FromView, ShouldAutoSize, WithTitle, WithStyles
{
    public function __construct(
        protected string $tableCode,
        protected string $opdCode,
        protected int $year,
        protected ?string $titleId = null,
        protected ?string $titleEn = null,
        protected ?string $source = null,
        protected ?string $note = null,
        protected ?string $tableHtml = null,
        protected bool $isTemplate = false
    ) {}

    public function view(): View
    {
        $rawHtml = $this->tableHtml ?? '';

        // Auto-heal Kolom 6 jika diekspor
        if ($this->tableCode === '2.2.2' || stripos($rawHtml, 'Partai') !== false || stripos($rawHtml, 'Pendidikan') !== false) {
            $rawHtml = preg_replace('/Kolom\s*6/i', 'S2/S3', $rawHtml);
        }
        if ($this->tableCode === '4.2.11' || stripos($rawHtml, 'Donatur Darah') !== false || stripos($rawHtml, 'Golongan Darah') !== false) {
            $rawHtml = preg_replace('/Kolom\s*6/i', 'AB', $rawHtml);
        }
        if ($this->tableCode === '8.1.6' || (stripos($rawHtml, 'Bemo') !== false && stripos($rawHtml, 'Bus Umum') !== false)) {
            $rawHtml = preg_replace('/Kolom\s*6/i', 'Taksi / Taxi', $rawHtml);
        }
        if (in_array($this->tableCode, ['9.4', '5.1.18']) || stripos($rawHtml, 'Guguk Panjang') !== false) {
            $rawHtml = preg_replace('/Kolom\s*6/i', 'Aur Birugo Tigo Baleh', $rawHtml);
        }

        // Bersihkan tag div dwibahasa menjadi spasi / slash yang rapi
        $cleanHtml = preg_replace('/<\/div>\s*<div[^>]*>/i', ' / ', $rawHtml);
        $cleanHtml = preg_replace('/<\/?div[^>]*>/i', '', $cleanHtml);

        // Jika mode template: kosongkan isi sel data numerik di tbody
        if ($this->isTemplate) {
            $cleanHtml = preg_replace_callback('/<tbody[^>]*>(.*?)<\/tbody>/is', function($tbodyMatch) {
                $tbody = $tbodyMatch[1];
                $tbody = preg_replace_callback('/<tr([^>]*)>(.*?)<\/tr>/is', function($trMatch) {
                    $trAttr = $trMatch[1];
                    $rowHtml = $trMatch[2];
                    $cellIndex = 0;
                    $newRow = preg_replace_callback('/<td([^>]*)>(.*?)<\/td>/is', function($tdMatch) use (&$cellIndex) {
                        $cellIndex++;
                        $attr = $tdMatch[1];
                        $val = trim(strip_tags($tdMatch[2]));
                        if ($cellIndex === 1) {
                            return "<td{$attr}>{$val}</td>";
                        }
                        return "<td{$attr}>-</td>";
                    }, $rowHtml);
                    return "<tr{$trAttr}>{$newRow}</tr>";
                }, $tbody);
                return "<tbody>{$tbody}</tbody>";
            }, $cleanHtml);
        }

        // Format judul agar tidak dobel prefix "Tabel" atau "Table"
        $displayTitleId = trim($this->titleId ?: '');
        $displayTitleId = preg_replace('/^Tabel\s*[\d\.]*\s*/i', '', $displayTitleId);
        $displayTitleId = "Tabel {$this->tableCode} {$displayTitleId}";

        $displayTitleEn = trim($this->titleEn ?: '');
        if (!empty($displayTitleEn)) {
            $displayTitleEn = preg_replace('/^Table\s*[\d\.]*\s*/i', '', $displayTitleEn);
            $displayTitleEn = "Table {$displayTitleEn}";
        }

        // Hitung jumlah kolom sebenarnya dari baris penomoran (1), (2) atau baris data pertama
        $maxCols = 6;
        if (preg_match('/<tr[^>]*>\s*<th[^>]*>\s*\(1\)[\s\S]*?<\/tr>/i', $cleanHtml, $mColRow)) {
            $maxCols = max(1, substr_count($mColRow[0], '<th'));
        } elseif (preg_match('/<tr[^>]*>([\s\S]*?)<\/tr>/i', $cleanHtml, $mFirstRow)) {
            $maxCols = max(1, substr_count($mFirstRow[1], '<th') + substr_count($mFirstRow[1], '<td'));
        }

        return view('exports.table_excel', [
            'tableCode' => $this->tableCode,
            'opdCode' => $this->opdCode,
            'year' => $this->year,
            'titleId' => $displayTitleId,
            'titleEn' => $displayTitleEn,
            'source' => strip_tags($this->source ?: 'BPS Kota Bukittinggi'),
            'note' => strip_tags($this->note ?: ''),
            'cleanTableHtml' => $cleanHtml,
            'maxCols' => $maxCols,
            'isTemplate' => $this->isTemplate,
        ]);
    }

    public function title(): string
    {
        return mb_substr("Tabel_{$this->tableCode}", 0, 31);
    }

    public function styles(Worksheet $sheet): ?array
    {
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Calibri');
        $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();

        $headerStartRow = 4;
        $colNumberRow = null;
        $footerStartRow = null;

        for ($r = 1; $r <= $highestRow; $r++) {
            $rowText = '';
            for ($c = 'A'; $c <= $highestCol; $c++) {
                $rowText .= ' ' . trim((string) $sheet->getCell("{$c}{$r}")->getValue());
            }

            if (str_contains($rowText, '(1)') && str_contains($rowText, '(2)')) {
                $colNumberRow = $r;
            }

            if (str_contains($rowText, 'Sumber') || str_contains($rowText, 'Source:')) {
                $footerStartRow = $r;
            }
        }

        if (!$colNumberRow) $colNumberRow = 5;
        $headerEndRow = $colNumberRow - 1;
        $dataStartRow = $colNumberRow + 1;
        $dataEndRow = $footerStartRow ? ($footerStartRow - 2) : ($highestRow - 2);

        // 1. Style Header Title (Row 1-2)
        $sheet->getStyle("A1:{$highestCol}1")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("A2:{$highestCol}2")->getFont()->setItalic(true)->setSize(9.5)->getColor()->setARGB('FF475569');
        $sheet->getRowDimension(1)->setRowHeight(24);
        if ($sheet->getCell('A2')->getValue()) {
            $sheet->getRowDimension(2)->setRowHeight(20);
        }
        $sheet->getRowDimension(3)->setRowHeight(10);

        // 2. Style Table Header Cells (Official BPS Orange #F95A00, white bold text)
        if ($headerStartRow <= $headerEndRow) {
            $sheet->getStyle("A{$headerStartRow}:{$highestCol}{$headerEndRow}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFF95A00'],
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                    'size' => 10,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF334155'],
                    ],
                ],
            ]);
            for ($hr = $headerStartRow; $hr <= $headerEndRow; $hr++) {
                $sheet->getRowDimension($hr)->setRowHeight(26);
            }
        }

        // 3. Style Column Number Row (1), (2), ... (Soft peach #FED7AA, dark text)
        if ($colNumberRow) {
            $sheet->getStyle("A{$colNumberRow}:{$highestCol}{$colNumberRow}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFED7AA'],
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FF0F172A'],
                    'size' => 9,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF334155'],
                    ],
                ],
            ]);
            $sheet->getRowDimension($colNumberRow)->setRowHeight(18);
        }

        // 4. Style Data Rows (Signature BPS Soft Warm Yellow #FEF9C3, borders, alignments)
        if ($dataStartRow && $dataEndRow && $dataStartRow <= $dataEndRow) {
            for ($dr = $dataStartRow; $dr <= $dataEndRow; $dr++) {
                $sheet->getRowDimension($dr)->setRowHeight(20);
                $valA = trim((string) $sheet->getCell("A{$dr}")->getValue());
                $isTotalRow = preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $valA);

                $fillColor = $isTotalRow ? 'FFFED7AA' : 'FFFFF9C3';
                $isBold = $isTotalRow;

                $sheet->getStyle("A{$dr}:{$highestCol}{$dr}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => $fillColor],
                    ],
                    'font' => [
                        'bold' => $isBold,
                        'size' => 10,
                        'color' => ['argb' => 'FF0F172A'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => $isTotalRow ? 'FF334155' : 'FF94A3B8'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Alignment: Kolom A rata kiri, sisanya rata kanan jika angka, tengah jika strip
                $sheet->getStyle("A{$dr}")->getAlignment()->setHorizontal($isTotalRow ? Alignment::HORIZONTAL_CENTER : Alignment::HORIZONTAL_LEFT);
                for ($c = 'B'; $c <= $highestCol; $c++) {
                    $cVal = trim((string) $sheet->getCell("{$c}{$dr}")->getValue());
                    if ($cVal === '-' || $cVal === '–' || $cVal === '') {
                        $sheet->getStyle("{$c}{$dr}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    } else {
                        $sheet->getStyle("{$c}{$dr}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    }
                }
            }
        }

        // 5. Footer styling
        if ($footerStartRow) {
            $sheet->getStyle("A{$footerStartRow}:{$highestCol}{$highestRow}")->getFont()->setSize(9);
            $sheet->getStyle("A{$footerStartRow}")->getFont()->getColor()->setARGB('FF334155');
        }

        // 6. Column Widths
        $sheet->getColumnDimension('A')->setWidth(35);
        for ($c = 'B'; $c <= $highestCol; $c++) {
            $sheet->getColumnDimension($c)->setWidth(16);
        }

        return [];
    }
}
