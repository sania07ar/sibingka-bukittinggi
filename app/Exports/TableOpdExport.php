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
                        // Sel pertama adalah label baris (nama kecamatan / bulan / kategori), jangan dihapus
                        if ($cellIndex === 1) {
                            return "<td{$attr}>{$val}</td>";
                        }
                        // Jika sel numerik atau strip, jadikan tanda strip '-' bersih
                        return "<td{$attr}>-</td>";
                    }, $rowHtml);
                    return "<tr{$trAttr}>{$newRow}</tr>";
                }, $tbody);
                return "<tbody>{$tbody}</tbody>";
            }, $cleanHtml);
        }

        // Format judul agar tidak dobel prefix "Tabel" atau "Table"
        $displayTitleId = $this->titleId ?: '';
        if (!preg_match('/^Tabel\s+/i', $displayTitleId)) {
            $displayTitleId = "Tabel {$this->tableCode} {$displayTitleId}";
        }

        $displayTitleEn = $this->titleEn ?: '';
        if (!empty($displayTitleEn) && !preg_match('/^Table\s+/i', $displayTitleEn)) {
            $displayTitleEn = "Table {$displayTitleEn}";
        }

        // Hitung estimasi max kolom
        $maxCols = 6;
        if (preg_match_all('/<th\b/i', $cleanHtml, $thMatches)) {
            $maxCols = max(6, count($thMatches[0]));
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

        $headerStartRow = null;
        $colNumberRow = null;
        $dataStartRow = null;
        $dataEndRow = null;
        $footerStartRow = null;

        for ($r = 1; $r <= $highestRow; $r++) {
            $rowText = '';
            for ($c = 'A'; $c <= $highestCol; $c++) {
                $rowText .= ' ' . trim((string) $sheet->getCell("{$c}{$r}")->getValue());
            }

            if ($r > 3 && !$headerStartRow && (
                str_contains($rowText, 'Kecamatan') || 
                str_contains($rowText, 'Bulan') || 
                str_contains($rowText, 'District') ||
                str_contains($rowText, 'No.') ||
                str_contains($rowText, 'Rincian')
            )) {
                $headerStartRow = $r;
            }

            if (str_contains($rowText, '(1)')) {
                $colNumberRow = $r;
                $dataStartRow = $r + 1;
            }

            if (str_contains($rowText, 'Sumber') || str_contains($rowText, 'Source:')) {
                $footerStartRow = $r;
                if (!$dataEndRow && $dataStartRow) {
                    $d = $r - 1;
                    while ($d >= $dataStartRow && trim((string) $sheet->getCell("A{$d}")->getValue()) === '') {
                        $d--;
                    }
                    $dataEndRow = $d;
                }
            }
        }

        if (!$headerStartRow) $headerStartRow = 5;
        if (!$colNumberRow) $colNumberRow = $headerStartRow + 1;
        if (!$dataStartRow) $dataStartRow = $colNumberRow + 1;
        if (!$dataEndRow) $dataEndRow = $footerStartRow ? $footerStartRow - 2 : $highestRow - 2;

        // 1. Style Header Title (Row 1-2)
        $sheet->getStyle("A1:{$highestCol}1")->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle("A2:{$highestCol}2")->getFont()->setItalic(true)->setSize(10)->getColor()->setARGB('FF475569');

        // 2. Style Table Header Cells (Orange background, white bold text)
        if ($headerStartRow && $colNumberRow && $headerStartRow < $colNumberRow) {
            $headerEndRow = $colNumberRow - 1;
            $sheet->getStyle("A{$headerStartRow}:{$highestCol}{$headerEndRow}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFEA580C'], // Official BPS Orange
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
        }

        // 3. Style Column Number Row (1), (2), ... (Soft orange, dark orange text)
        if ($colNumberRow) {
            $sheet->getStyle("A{$colNumberRow}:{$highestCol}{$colNumberRow}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFEDD5'], // Light orange
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FF9A3412'],
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
        }

        // 4. Style Data Rows
        if ($dataStartRow && $dataEndRow && $dataStartRow <= $dataEndRow) {
            $sheet->getStyle("A{$dataStartRow}:{$highestCol}{$dataEndRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FFCBD5E1'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Cek setiap baris data
            for ($dr = $dataStartRow; $dr <= $dataEndRow; $dr++) {
                $valA = trim((string) $sheet->getCell("A{$dr}")->getValue());
                $isTotalRow = preg_match('/(?:Jumlah|Total|Rata-rata|Average)/i', $valA);

                if ($isTotalRow) {
                    $sheet->getStyle("A{$dr}:{$highestCol}{$dr}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFFFEDD5'],
                        ],
                        'font' => [
                            'bold' => true,
                        ],
                    ]);
                }

                // Kolom label (A dan B) rata kiri, sisanya rata kanan
                $sheet->getStyle("A{$dr}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                for ($c = 'B'; $c <= $highestCol; $c++) {
                    $cVal = trim((string) $sheet->getCell("{$c}{$dr}")->getValue());
                    if (is_numeric($cVal) || $cVal === '-') {
                        $sheet->getStyle("{$c}{$dr}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    }
                }
            }
        }

        // 5. Footer styling (Sumber & Catatan)
        if ($footerStartRow) {
            $sheet->getStyle("A{$footerStartRow}:{$highestCol}{$highestRow}")->getFont()->setSize(9);
            $sheet->getStyle("A{$footerStartRow}")->getFont()->getColor()->setARGB('FF334155');
        }

        return [];
    }
}
