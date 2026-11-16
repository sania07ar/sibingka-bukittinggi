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
 * Template HTML tabel kode 118 dan 112.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait BuildsBab1Templates
{
    /**
     * Membangun HTML bersih dan akurat untuk Tabel 11.2 (Dinas PMPTSP - NIB Menurut Sektor)
     * dengan rentang 6 tahun historis pada bagian Jumlah: [year, year-1, ..., year-5]
     */
    /**
     * Membangun HTML bersih dan akurat untuk Tabel 1.1.8 (Kantor Pertanahan - Pembuatan Sertifikat Menurut Jenis Kepemilikan)
     * dengan rentang 7 tahun historis dinamis: [year - 6 s.d. year]
     */
    private function buildTabel118Html(int $year, ?string $existingHtml = null): string
    {
        $dash = '<span class="text-slate-400 font-normal">-</span>';

        $knownData = [
            2017 => ['68', '4', '10', '–', '–', '596'],
            2018 => ['1.167', '14', '5', '0', '0', '-'],
            2019 => ['995', '8', '31', '0', '0', '-'],
            2020 => ['410', '9', '23', '0', '0', '268'],
            2021 => ['433', '6', '18', '0', '0', '433'],
            2022 => ['369', '3', '135', '0', '0', '400'],
            2023 => ['751', '7', '65', '0', '0', '398'],
            2024 => ['774', '9', '72', '0', '0', '392'],
            2025 => ['200', '5', '35', '-', '-', '286'],
        ];

        // Ekstrak baris data yang sudah ada dari existingHtml jika relevan
        $existingRowData = [];
        if (!empty($existingHtml)) {
            if (preg_match('/<tbody[^>]*>(.*?)<\/tbody>/is', $existingHtml, $m)) {
                preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $m[1], $trs);
                foreach ($trs[1] as $tr) {
                    preg_match_all('/<td[^>]*>(.*?)<\/td>/is', $tr, $tds);
                    if (isset($tds[1]) && count($tds[1]) >= 7) {
                        $rYear = (int)trim(strip_tags($tds[1][0]));
                        if ($rYear > 1900 && $rYear < 2100) {
                            $vals = [];
                            for ($i = 1; $i <= 6; $i++) {
                                $v = trim(strip_tags($tds[1][$i]));
                                $vals[] = ($v === '' || $v === '-') ? $dash : $v;
                            }
                            $existingRowData[$rYear] = $vals;
                        }
                    }
                }
            }
        }

        $startYear = $year - 6;

        $html = '<thead>' . "\n";
        $html .= '    <tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '            <div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '            <div>Hak Milik</div><div class="italic font-normal text-[11px] sm:text-xs">Freehold Title</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '            <div>Hak Guna Bangunan</div><div class="italic font-normal text-[11px] sm:text-xs">Building Rights Title</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '            <div>Hak Pakai</div><div class="italic font-normal text-[11px] sm:text-xs">Right of Use Title</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '            <div>Hak Pengelolaan</div><div class="italic font-normal text-[11px] sm:text-xs">Management Rights</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '            <div>Hak Guna Usaha</div><div class="italic font-normal text-[11px] sm:text-xs">Commercial Exploitation Rights</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '            <div>Hak Tanggungan</div><div class="italic font-normal text-[11px] sm:text-xs">Mortgage Rights</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '    </tr>' . "\n";
        $html .= '    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' . "\n";
        $html .= '        <th class="py-1 px-3 border border-slate-700">(1)</th>' . "\n";
        $html .= '        <th class="py-1 px-3 border border-slate-700">(2)</th>' . "\n";
        $html .= '        <th class="py-1 px-3 border border-slate-700">(3)</th>' . "\n";
        $html .= '        <th class="py-1 px-3 border border-slate-700">(4)</th>' . "\n";
        $html .= '        <th class="py-1 px-3 border border-slate-700">(5)</th>' . "\n";
        $html .= '        <th class="py-1 px-3 border border-slate-700">(6)</th>' . "\n";
        $html .= '        <th class="py-1 px-3 border border-slate-700">(7)</th>' . "\n";
        $html .= '    </tr>' . "\n";
        $html .= '</thead>' . "\n";

        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";
        for ($y = $startYear; $y <= $year; $y++) {
            $rowVals = $existingRowData[$y] ?? $knownData[$y] ?? array_fill(0, 6, $dash);
            $fmtVals = array_map(function($v) use ($dash) {
                if ($v === null || $v === '' || $v === '-' || $v === '–') return $dash;
                return $v;
            }, $rowVals);

            $html .= '    <tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
            $html .= '        <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">' . $y . '</td>' . "\n";
            for ($col = 0; $col < 6; $col++) {
                $val = $fmtVals[$col] ?? $dash;
                $html .= '        <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">' . $val . '</td>' . "\n";
            }
            $html .= '    </tr>' . "\n";
        }
        $html .= '</tbody>';

        return $html;
    }

    private function buildTabel112Html(int $year, ?string $existingHtml = null): string
    {
        $knownTotals = [
            2025 => '3565',
            2024 => '6008',
            2023 => '6907',
            2022 => '2542',
            2021 => '138',
            2020 => '278',
            2019 => '246',
        ];

        // Ekstrak nilai sektor dari existingHtml jika ada
        $sectorValues = [];
        if ($existingHtml) {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $existingHtml . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);
            $rows = $xpath->query('//tbody/tr');
            $secIdx = 0;
            foreach ($rows as $tr) {
                $tds = $xpath->query('td', $tr);
                if ($tds->length >= 2) {
                    $firstText = trim($tds->item(0)->textContent);
                    if (preg_match('/^(0[1-9]|1[0-1])\./', $firstText)) {
                        $lastTd = $tds->item($tds->length - 1);
                        $val = trim($lastTd->textContent);
                        $sectorValues[$secIdx++] = ($val === '-' || $val === '') ? '<span class="text-slate-400 font-normal">-</span>' : $val;
                    }
                }
            }
        }

        $sectors = [
            '01. Kelautan dan Perikanan / <span class="italic font-normal text-slate-700">Marine and Fisheries Sector</span>',
            '02. Pertanian / <span class="italic font-normal text-slate-700">Agriculture</span>',
            '03. Lingkungan Hidup dan Kehutanan / <span class="italic font-normal text-slate-700">Environment and Forestry</span>',
            '04. Industri / <span class="italic font-normal text-slate-700">Industry</span>',
            '05. Perdagangan / <span class="italic font-normal text-slate-700">Trade</span>',
            '06. Transportasi / <span class="italic font-normal text-slate-700">Transportation</span>',
            '07. Kesehatan, Obat dan Makanan / <span class="italic font-normal text-slate-700">Health, Drug and Food</span>',
            '08. Pariwisata / <span class="italic font-normal text-slate-700">Tourism</span>',
            '09. Ketenagakerjaan / <span class="italic font-normal text-slate-700">Manpower</span>',
            '10. Pekerjaan Umum dan Perumahan Rakyat / <span class="italic font-normal text-slate-700">Public Works and Housing</span>',
            '11. Pendidikan dan Kebudayaan / <span class="italic font-normal text-slate-700">Education and Culture</span>',
        ];

        $html = '<thead>' . "\n";
        $html .= '<tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">' . "\n";
        $html .= '        <div>Sektor</div><div class="italic font-normal text-[11px] sm:text-xs">Sector</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '<tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs"><th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th><th class="py-1 px-3 border border-slate-700">(2)</th></tr>' . "\n";
        $html .= '</thead>' . "\n";
        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";

        // 11 Sektor baris
        foreach ($sectors as $idx => $secLabel) {
            $val = isset($sectorValues[$idx]) && $sectorValues[$idx] !== '' ? $sectorValues[$idx] : '<span class="text-slate-400 font-normal">-</span>';
            $valCls = ($val === '<span class="text-slate-400 font-normal">-</span>') ? 'text-center align-middle' : 'text-center align-top';
            $html .= '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">' . "\n";
            $html .= '        ' . $secLabel . "\n";
            $html .= '    </td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 ' . $valCls . '">' . "\n";
            $html .= '        ' . $val . "\n";
            $html .= '    </td>' . "\n";
            $html .= '</tr>' . "\n";
        }

        // Jumlah Section: 6 tahun historis [year, year-1, year-2, year-3, year-4, year-5]
        for ($i = 0; $i < 6; $i++) {
            $y = $year - $i;
            $label = ($y <= 2022) ? "{$y}(SIUP)" : (string)$y;
            
            if ($i === 0) {
                // Tahun aktif
                $val = isset($knownTotals[$year]) ? $knownTotals[$year] : '<span class="text-slate-400 font-normal">-</span>';
            } else {
                $val = isset($knownTotals[$y]) ? $knownTotals[$y] : '<span class="text-slate-400 font-normal">-</span>';
            }

            $valCls = ($val === '<span class="text-slate-400 font-normal">-</span>') ? 'text-center align-middle' : 'text-center align-top';

            if ($i === 0) {
                $html .= '<tr class="bg-[#fed7aa] font-bold">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" rowspan="6">' . "\n";
                $html .= '        Jumlah' . "\n";
                $html .= '    </td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . "\n";
                $html .= '        ' . $label . "\n";
                $html .= '    </td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 ' . $valCls . ' font-extrabold">' . "\n";
                $html .= '        ' . $val . "\n";
                $html .= '    </td>' . "\n";
                $html .= '</tr>' . "\n";
            } else {
                $html .= '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . "\n";
                $html .= '        ' . $label . "\n";
                $html .= '    </td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 ' . $valCls . '">' . "\n";
                $html .= '        ' . $val . "\n";
                $html .= '    </td>' . "\n";
                $html .= '</tr>' . "\n";
            }
        }

        $html .= '</tbody>';
        return $html;
    }
}
