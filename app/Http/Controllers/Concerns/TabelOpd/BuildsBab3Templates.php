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
 * Template HTML tabel kode 311, 312, 318, dan 328.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait BuildsBab3Templates
{
    /**
     * Membangun HTML standar untuk Tabel 3.1.1 (Disdukcapil - Penduduk Menurut Kecamatan)
     */
    private function buildTabel311Html(int $year, ?string $existingHtml = null): string
    {
        $dash = '<span class="text-slate-400 font-normal">-</span>';

        // Data resmi Disdukcapil Kota Bukittinggi per kecamatan
        $knownDataByYear = [
            2025 => [
                '01' => ['pop' => '50.210', 'pct' => '34,97', 'ratio' => '100,73'],
                '02' => ['pop' => '61.395', 'pct' => '42,76', 'ratio' => '100,60'],
                '03' => ['pop' => '31.990', 'pct' => '22,28', 'ratio' => '100,09'],
                'total' => ['pop' => '143.595', 'pct' => '-', 'ratio' => '100,53'],
            ],
            2024 => [
                '01' => ['pop' => '49.614', 'pct' => '34,99', 'ratio' => '100,70'],
                '02' => ['pop' => '60.751', 'pct' => '42,84', 'ratio' => '100,60'],
                '03' => ['pop' => '31.439', 'pct' => '22,17', 'ratio' => '100,10'],
                'total' => ['pop' => '141.804', 'pct' => '-', 'ratio' => '100,52'],
            ],
        ];

        $curData = $knownDataByYear[$year] ?? [
            '01' => ['pop' => $dash, 'pct' => $dash, 'ratio' => $dash],
            '02' => ['pop' => $dash, 'pct' => $dash, 'ratio' => $dash],
            '03' => ['pop' => $dash, 'pct' => $dash, 'ratio' => $dash],
            'total' => ['pop' => $dash, 'pct' => $dash, 'ratio' => $dash],
        ];

        // Ekstrak nilai jika ada di existingHtml
        if ($existingHtml) {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $existingHtml . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);
            $trs = $xpath->query('//tbody/tr');
            foreach ($trs as $tr) {
                $tds = $xpath->query('td', $tr);
                if ($tds->length >= 4) {
                    $label = strtolower(trim($tds->item(0)->textContent));
                    $p = trim($tds->item(1)->textContent);
                    $pct = trim($tds->item(2)->textContent);
                    $r = trim($tds->item(3)->textContent);

                    $key = null;
                    if (str_contains($label, 'guguk') || str_contains($label, '01')) $key = '01';
                    elseif (str_contains($label, 'mandiangin') || str_contains($label, '02')) $key = '02';
                    elseif (str_contains($label, 'aur') || str_contains($label, 'birugo') || str_contains($label, '03')) $key = '03';
                    elseif (str_contains($label, 'bukittinggi') || str_contains($label, 'jumlah') || str_contains($label, 'total')) $key = 'total';

                    if ($key) {
                        if ($p !== '' && $p !== '-') $curData[$key]['pop'] = $p;
                        if ($pct !== '' && $pct !== '-') $curData[$key]['pct'] = $pct;
                        if ($r !== '' && $r !== '-') $curData[$key]['ratio'] = $r;
                    }
                }
            }
        }

        $rows = [
            ['label' => '01. Guguk Panjang', 'data' => $curData['01']],
            ['label' => '02. Mandiangin Koto Selayan', 'data' => $curData['02']],
            ['label' => '03. Aur Birugo Tigo Baleh', 'data' => $curData['03']],
            ['label' => 'Bukittinggi', 'data' => $curData['total'], 'isTotal' => true],
        ];

        $html = '<thead>' . "\n";
        $html .= '<tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">Subdistrict</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Jumlah Penduduk (jiwa)</div><div class="italic font-normal text-[11px] sm:text-xs">Population (people)</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Persentase Penduduk</div><div class="italic font-normal text-[11px] sm:text-xs">Percentage of Total Population (%)</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Rasio Jenis Kelamin</div><div class="italic font-normal text-[11px] sm:text-xs">Population Sex Ratio</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '<tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(1)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(2)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(3)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(4)</th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '</thead>' . "\n";
        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";

        foreach ($rows as $r) {
            $isTot = !empty($r['isTotal']);
            $trCls = $isTot ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
            $boldVal = $isTot ? ' font-extrabold' : '';
            $d = $r['data'];
            $pop = ($d['pop'] !== $dash && is_numeric(str_replace('.', '', $d['pop']))) ? number_format((float)str_replace('.', '', $d['pop']), 0, ',', '.') : $d['pop'];
            $pct = $d['pct'];
            $ratio = $d['ratio'];

            $html .= '<tr class="' . $trCls . '">' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">' . $r['label'] . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top' . $boldVal . '">' . $pop . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top' . $boldVal . '">' . $pct . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top' . $boldVal . '">' . $ratio . '</td>' . "\n";
            $html .= '</tr>' . "\n";
        }

        $html .= '</tbody>';
        return $html;
    }

    /**
     * Membangun HTML standar untuk Tabel 3.1.2 (Disdukcapil - Penduduk Menurut Kelompok Umur & Jenis Kelamin)
     */
    private function buildTabel312Html(int $year, ?string $existingHtml = null): string
    {
        $dash = '<span class="text-slate-400 font-normal">-</span>';
        $is2025 = ($year === 2025);
        $groups = [
            '0_4' => ['label' => '0–4', 'l' => $is2025 ? '5.203' : $dash, 'p' => $is2025 ? '4.882' : $dash, 'tot' => $is2025 ? '10.085' : $dash],
            '5_9' => ['label' => '5–9', 'l' => $is2025 ? '6.541' : $dash, 'p' => $is2025 ? '6.044' : $dash, 'tot' => $is2025 ? '12.585' : $dash],
            '10_14' => ['label' => '10–14', 'l' => $is2025 ? '6.837' : $dash, 'p' => $is2025 ? '6.469' : $dash, 'tot' => $is2025 ? '13.306' : $dash],
            '15_19' => ['label' => '15–19', 'l' => $is2025 ? '6.594' : $dash, 'p' => $is2025 ? '6.223' : $dash, 'tot' => $is2025 ? '12.817' : $dash],
            '20_24' => ['label' => '20–24', 'l' => $is2025 ? '6.303' : $dash, 'p' => $is2025 ? '5.946' : $dash, 'tot' => $is2025 ? '12.249' : $dash],
            '25_29' => ['label' => '25–29', 'l' => $is2025 ? '6.127' : $dash, 'p' => $is2025 ? '5.937' : $dash, 'tot' => $is2025 ? '12.064' : $dash],
            '30_34' => ['label' => '30–34', 'l' => $is2025 ? '5.472' : $dash, 'p' => $is2025 ? '5.429' : $dash, 'tot' => $is2025 ? '10.901' : $dash],
            '35_39' => ['label' => '35–39', 'l' => $is2025 ? '5.169' : $dash, 'p' => $is2025 ? '5.094' : $dash, 'tot' => $is2025 ? '10.263' : $dash],
            '40_44' => ['label' => '40–44', 'l' => $is2025 ? '5.101' : $dash, 'p' => $is2025 ? '5.096' : $dash, 'tot' => $is2025 ? '10.197' : $dash],
            '45_49' => ['label' => '45–49', 'l' => $is2025 ? '4.657' : $dash, 'p' => $is2025 ? '4.476' : $dash, 'tot' => $is2025 ? '9.133' : $dash],
            '50_54' => ['label' => '50–54', 'l' => $is2025 ? '4.025' : $dash, 'p' => $is2025 ? '4.025' : $dash, 'tot' => $is2025 ? '8.050' : $dash],
            '55_59' => ['label' => '55–59', 'l' => $is2025 ? '3.179' : $dash, 'p' => $is2025 ? '3.369' : $dash, 'tot' => $is2025 ? '6.548' : $dash],
            '60_64' => ['label' => '60–64', 'l' => $is2025 ? '2.663' : $dash, 'p' => $is2025 ? '2.866' : $dash, 'tot' => $is2025 ? '5.529' : $dash],
            '65_69' => ['label' => '65–69', 'l' => $is2025 ? '2.070' : $dash, 'p' => $is2025 ? '2.262' : $dash, 'tot' => $is2025 ? '4.332' : $dash],
            '70_74' => ['label' => '70–74', 'l' => $is2025 ? '1.305' : $dash, 'p' => $is2025 ? '1.507' : $dash, 'tot' => $is2025 ? '2.812' : $dash],
            '75_plus' => ['label' => '75+', 'l' => $is2025 ? '1.198' : $dash, 'p' => $is2025 ? '1.898' : $dash, 'tot' => $is2025 ? '3.096' : $dash],
        ];

        $totL = $is2025 ? '71.987' : $dash;
        $totP = $is2025 ? '71.608' : $dash;
        $totTot = $is2025 ? '143.595' : $dash;

        if ($existingHtml) {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $existingHtml . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);
            $trs = $xpath->query('//tbody/tr');
            foreach ($trs as $tr) {
                $tds = $xpath->query('td', $tr);
                if ($tds->length >= 4) {
                    $lbl = trim($tds->item(0)->textContent);
                    $l = trim($tds->item(1)->textContent);
                    $p = trim($tds->item(2)->textContent);
                    $tot = trim($tds->item(3)->textContent);

                    if (str_contains(strtolower($lbl), 'jumlah') || str_contains(strtolower($lbl), 'total')) {
                        if ($l !== '' && $l !== '-') $totL = $l;
                        if ($p !== '' && $p !== '-') $totP = $p;
                        if ($tot !== '' && $tot !== '-') $totTot = $tot;
                        continue;
                    }

                    foreach ($groups as $k => &$grp) {
                        $cleanLbl = str_replace([' ', '–', '—'], ['', '-', '-'], $lbl);
                        $cleanGrp = str_replace([' ', '–', '—'], ['', '-', '-'], $grp['label']);
                        if ($cleanLbl === $cleanGrp) {
                            if ($l !== '' && $l !== '-') $grp['l'] = $l;
                            if ($p !== '' && $p !== '-') $grp['p'] = $p;
                            if ($tot !== '' && $tot !== '-') $grp['tot'] = $tot;
                            break;
                        }
                    }
                }
            }
        }

        $html = '<thead>' . "\n";
        $html .= '<tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Kelompok Umur</div><div class="italic font-normal text-[11px] sm:text-xs">Age Group</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Laki–laki</div><div class="italic font-normal text-[11px] sm:text-xs">Male</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Perempuan</div><div class="italic font-normal text-[11px] sm:text-xs">Female</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '<tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(1)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(2)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(3)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(4)</th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '</thead>' . "\n";
        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";

        foreach ($groups as $g) {
            $html .= '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">' . $g['label'] . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $g['l'] . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $g['p'] . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $g['tot'] . '</td>' . "\n";
            $html .= '</tr>' . "\n";
        }

        $html .= '<tr class="bg-[#fed7aa] font-bold">' . "\n";
        $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total</span></td>' . "\n";
        $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $totL . '</td>' . "\n";
        $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $totP . '</td>' . "\n";
        $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $totTot . '</td>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '</tbody>';

        return $html;
    }

    /**
     * Membangun HTML bersih dan rapi untuk Tabel 3.1.6 (BPS Susenas - Jenis Kelamin & Kepandaian Membaca dan Menulis)
     */
    private function buildTabel316Html(int $year, ?string $existingHtml = null): string
    {
        $dash = '<span class="text-slate-400 font-normal">-</span>';

        $knownData = [
            2025 => [
                'l_dapat' => '99,60',
                'l_tidak' => '0,40',
                'p_dapat' => '99,48',
                'p_tidak' => '0,52',
            ],
            2024 => [
                'l_dapat' => '99,45',
                'l_tidak' => '0,55',
                'p_dapat' => '99,85',
                'p_tidak' => '0,15',
            ],
        ];

        $cur = $knownData[$year] ?? [
            'l_dapat' => $dash,
            'l_tidak' => $dash,
            'p_dapat' => $dash,
            'p_tidak' => $dash,
        ];

        $valLDapat = $cur['l_dapat'];
        $valLTidak = $cur['l_tidak'];
        $valPDapat = $cur['p_dapat'];
        $valPTidak = $cur['p_tidak'];

        return <<<HTML
<thead>
    <tr class="bg-[#f95a00] text-white text-center font-bold">
        <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
            <div>Jenis Kelamin</div>
            <div class="italic font-normal text-[11px] sm:text-xs">Sex Type</div>
        </th>
        <th class="py-3 px-4 font-bold border border-slate-700">
            <div>Persentase</div>
            <div class="italic font-normal text-[11px] sm:text-xs">Percentage</div>
        </th>
    </tr>
    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
        <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>
        <th class="py-1 px-3 border border-slate-700">(2)</th>
    </tr>
</thead>
<tbody class="bg-[#fef9c3] text-slate-900 font-medium">
    <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
        <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle" rowspan="2">Laki–laki / <span class="italic font-normal">Male</span></td>
        <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Dapat Baca Tulis / <span class="italic font-normal">Read / Write Skill</span></td>
        <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">{$valLDapat}</td>
    </tr>
    <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
        <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Tidak Dapat Baca Tulis / <span class="italic font-normal">Read / Write Unskill</span></td>
        <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">{$valLTidak}</td>
    </tr>
    <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
        <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle" rowspan="2">Perempuan / <span class="italic font-normal">Female</span></td>
        <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Dapat Baca Tulis / <span class="italic font-normal">Read / Write Skill</span></td>
        <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">{$valPDapat}</td>
    </tr>
    <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
        <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Tidak Dapat Baca Tulis / <span class="italic font-normal">Read / Write Unskill</span></td>
        <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">{$valPTidak}</td>
    </tr>
</tbody>
HTML;
    }

    /**
     * Membangun HTML bersih dan akurat untuk Tabel 3.1.8 (Disdukcapil - Penduduk Wajib KTP)
     * dengan rentang 6 tahun historis pada bagian Jumlah: [year, year-1, ..., year-5]
     */
    private function buildTabel318Html(int $year, ?string $existingHtml = null): string
    {
        $dash = '<span class="text-slate-400 font-normal">-</span>';

        $fmt = function($val) use ($dash) {
            if ($val === null || $val === '' || $val === '-') return $dash;
            $str = (string) $val;
            $clean = preg_replace('/[^\d]/', '', $str);
            if ($clean === '') return $dash;
            return number_format((float)$clean, 0, ',', '.');
        };

        // Data resmi kecamatan untuk tahun 2025 dan 2024
        $knownKecByYear = [
            2025 => [
                0 => ['pop' => '50210', 'wajib' => '35853', 'ktp' => '35348'],
                1 => ['pop' => '61395', 'wajib' => '43995', 'ktp' => '43463'],
                2 => ['pop' => '31990', 'wajib' => '22523', 'ktp' => '22214'],
            ],
            2024 => [
                0 => ['pop' => '49614', 'wajib' => '35197', 'ktp' => '34988'],
                1 => ['pop' => '60751', 'wajib' => '43195', 'ktp' => '42932'],
                2 => ['pop' => '31439', 'wajib' => '21901', 'ktp' => '21764'],
            ],
        ];

        $kecValues = $knownKecByYear[$year] ?? [
            0 => ['pop' => null, 'wajib' => null, 'ktp' => null],
            1 => ['pop' => null, 'wajib' => null, 'ktp' => null],
            2 => ['pop' => null, 'wajib' => null, 'ktp' => null],
        ];

        // Ekstrak nilai kecamatan jika ada di existingHtml
        if ($existingHtml) {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $existingHtml . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);
            $rows = $xpath->query('//tbody/tr');
            $kIdx = 0;
            foreach ($rows as $tr) {
                if ($kIdx >= 3) break;
                $tds = $xpath->query('td', $tr);
                if ($tds->length > 0) {
                    $firstText = trim($tds->item(0)->textContent);
                    if (preg_match('/^(0[1-3])\./', $firstText)) {
                        $vals = [];
                        for ($c = 1; $c < $tds->length; $c++) {
                            $txt = trim($tds->item($c)->textContent);
                            if ($txt !== '' && $txt !== '-') {
                                $vals[] = $txt;
                            }
                        }
                        if (count($vals) === 3) {
                            $kecValues[$kIdx] = ['pop' => $vals[0], 'wajib' => $vals[1], 'ktp' => $vals[2]];
                        }
                        $kIdx++;
                    }
                }
            }
        }

        $knownTotals = [
            2025 => ['pop' => '143595', 'wajib' => '102371', 'ktp' => '101025'],
            2024 => ['pop' => '141804', 'wajib' => '100293', 'ktp' => '99684'],
            2023 => ['pop' => '138534', 'wajib' => '99849',  'ktp' => '95690'],
            2022 => ['pop' => '134412', 'wajib' => '96195',  'ktp' => '92459'],
            2021 => ['pop' => '130211', 'wajib' => '90846',  'ktp' => '90790'],
            2020 => ['pop' => '101745', 'wajib' => '88327',  'ktp' => '88289'],
            2019 => ['pop' => '123296', 'wajib' => '85296',  'ktp' => '85454'],
        ];

        $html = '<thead>' . "\n";
        $html .= '<tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">' . "\n";
        $html .= '        <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Jumlah Penduduk</div><div class="italic font-normal text-[11px] sm:text-xs">Number of Population</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Wajib KTP</div><div class="italic font-normal text-[11px] sm:text-xs">Must Have ID</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Memiliki KTP Elektronik</div><div class="italic font-normal text-[11px] sm:text-xs">Have Electronic ID</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '<tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(2)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(3)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(4)</th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '</thead>' . "\n";
        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";

        // 3 Baris Kecamatan (colspan="2", rapi tanpa ghost column)
        $districts = [
            '01. GUGUK PANJANG',
            '02. MANDIANGIN KOTO SELAYAN',
            '03. AUR BIRUGO TIGO BALEH',
        ];

        foreach ($districts as $idx => $dName) {
            $popVal = $fmt($kecValues[$idx]['pop'] ?? null);
            $wajibVal = $fmt($kecValues[$idx]['wajib'] ?? null);
            $ktpVal = $fmt($kecValues[$idx]['ktp'] ?? null);

            $html .= '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">' . $dName . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $popVal . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $wajibVal . '</td>' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $ktpVal . '</td>' . "\n";
            $html .= '</tr>' . "\n";
        }

        // 6 Baris Historis Jumlah / Total [year, year-1, ..., year-5]
        for ($i = 0; $i < 6; $i++) {
            $y = $year - $i;
            $tot = $knownTotals[$y] ?? null;
            $popVal = $tot ? $fmt($tot['pop']) : $dash;
            $wajibVal = $tot ? $fmt($tot['wajib']) : $dash;
            $ktpVal = $tot ? $fmt($tot['ktp']) : $dash;

            if ($i === 0) {
                $html .= '<tr class="bg-[#fed7aa] font-bold">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" rowspan="6">' . "\n";
                $html .= '        Jumlah / <span class="italic font-bold">Total</span>' . "\n";
                $html .= '    </td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $y . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $popVal . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $wajibVal . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $ktpVal . '</td>' . "\n";
                $html .= '</tr>' . "\n";
            } else {
                $html .= '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $y . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $popVal . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $wajibVal . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $ktpVal . '</td>' . "\n";
                $html .= '</tr>' . "\n";
            }
        }

        $html .= '</tbody>';
        return $html;
    }

    /**
     * Membangun HTML bersih dan akurat untuk Tabel 3.2.8 (Disnaker - Pencari Kerja Menurut Tingkat Pendidikan)
     * dengan rentang 6 tahun historis pada bagian Jumlah: [year, year-1, ..., year-5]
     */
    private function buildTabel328Html(int $year, ?string $existingHtml = null): string
    {
        $dash = '<span class="text-slate-400 font-normal">-</span>';

        $fmt = function($val) use ($dash) {
            if ($val === null || $val === '' || $val === '-') return $dash;
            $str = (string) $val;
            $clean = preg_replace('/[^\d]/', '', $str);
            if ($clean === '') return $dash;
            return number_format((float)$clean, 0, ',', '.');
        };

        $knownEduByYear = [
            2025 => [
                0 => [5, 0, 5, 7, 0, 7, 1, 0, 1, 2, 0, 2],
                1 => [281, 142, 423, 139, 127, 266, 23, 6, 29, 90, 32, 122],
                2 => [125, 208, 333, 58, 65, 123, 11, 17, 28, 45, 49, 94],
                3 => [284, 551, 835, 68, 162, 230, 19, 21, 40, 55, 130, 185],
            ],
        ];

        $eduValues = $knownEduByYear[$year] ?? [
            0 => array_fill(0, 12, null),
            1 => array_fill(0, 12, null),
            2 => array_fill(0, 12, null),
            3 => array_fill(0, 12, null),
        ];

        $knownTotals = [
            2025 => [695, 901, 1596, 272, 354, 626, 54, 44, 98, 192, 211, 403],
            2024 => [647, 777, 1424, 336, 376, 712, 127, 98, 225, 181, 257, 438],
            2023 => [658, 784, 1442, 302, 423, 725, 102, 206, 308, 161, 211, 372],
            2022 => [619, 778, 1397, 362, 541, 903, 103, 120, 223, 619, 778, 1397],
            2021 => [520, 624, 1144, 269, 301, 572, 229, 295, 524, 520, 624, 1144],
            2020 => [649, 798, 1447, 188, 285, 473, 211, 483, 692, 649, 798, 1447],
        ];

        if ($existingHtml) {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $existingHtml . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);
            $rows = $xpath->query('//tbody/tr');
            $eIdx = 0;
            foreach ($rows as $tr) {
                $tds = $xpath->query('td', $tr);
                if ($tds->length === 0) continue;
                $firstText = trim($tds->item(0)->textContent);
                if (preg_match('/^(0[1-4])\./', $firstText)) {
                    $vals = [];
                    for ($c = 1; $c < $tds->length; $c++) {
                        $txt = trim($tds->item($c)->textContent);
                        if ($txt !== '' && $txt !== '-') {
                            $vals[] = preg_replace('/[^\d]/', '', $txt);
                        } else {
                            $vals[] = null;
                        }
                    }
                    if (count($vals) >= 12 && $eIdx < 4) {
                        $eduValues[$eIdx] = array_slice($vals, 0, 12);
                    }
                    $eIdx++;
                } elseif (preg_match('/\b(20\d{2}|19\d{2})\b/', $firstText, $m) || ($tds->length > 1 && preg_match('/\b(20\d{2}|19\d{2})\b/', trim($tds->item(1)->textContent), $m))) {
                    $yVal = (int)$m[1];
                    $startCol = (preg_match('/\b(20\d{2}|19\d{2})\b/', $firstText)) ? 1 : 2;
                    $vals = [];
                    for ($c = $startCol; $c < $tds->length; $c++) {
                        $txt = trim($tds->item($c)->textContent);
                        if ($txt !== '' && $txt !== '-') {
                            $vals[] = preg_replace('/[^\d]/', '', $txt);
                        } else {
                            $vals[] = null;
                        }
                    }
                    if (count($vals) >= 12 && !isset($knownTotals[$yVal])) {
                        $knownTotals[$yVal] = array_slice($vals, 0, 12);
                    }
                }
            }
        }

        $html = '<thead>' . "\n";
        $html .= '<tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="2">' . "\n";
        $html .= '        <div>Pendidikan Ditamatkan</div><div class="italic font-normal text-[11px] sm:text-xs">Educational Attainment</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">' . "\n";
        $html .= '        <div>Belum Ditempatkan Tahun Ini</div><div class="italic font-normal text-[11px] sm:text-xs">Not Placed This Year Yet</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">' . "\n";
        $html .= '        <div>Terdaftar</div><div class="italic font-normal text-[11px] sm:text-xs">Registered</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">' . "\n";
        $html .= '        <div>Ditempatkan Tahun Ini</div><div class="italic font-normal text-[11px] sm:text-xs">Placed This Year</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">' . "\n";
        $html .= '        <div>Dihapuskan Tahun Ini</div><div class="italic font-normal text-[11px] sm:text-xs">Cleared This Year</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '<tr class="bg-[#f95a00] text-white text-center font-bold text-xs">' . "\n";
        for ($k = 0; $k < 4; $k++) {
            $html .= '    <th class="py-2 px-3 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>' . "\n";
            $html .= '    <th class="py-2 px-3 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>' . "\n";
            $html .= '    <th class="py-2 px-3 border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>' . "\n";
        }
        $html .= '</tr>' . "\n";
        $html .= '<tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>' . "\n";
        for ($col = 2; $col <= 13; $col++) {
            $html .= '    <th class="py-1 px-3 border border-slate-700">(' . $col . ')</th>' . "\n";
        }
        $html .= '</tr>' . "\n";
        $html .= '</thead>' . "\n";
        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";

        $eduLabels = [
            '01. SD/SLTP',
            '02. SLTA',
            '03. Akademik',
            '04. Perguruan Tinggi',
        ];

        foreach ($eduLabels as $idx => $label) {
            $html .= '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
            $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">' . $label . '</td>' . "\n";
            for ($c = 0; $c < 12; $c++) {
                $val = $eduValues[$idx][$c] ?? null;
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $fmt($val) . '</td>' . "\n";
            }
            $html .= '</tr>' . "\n";
        }

        // 6 Baris Historis Jumlah / Total [year, year-1, ..., year-5]
        for ($i = 0; $i < 6; $i++) {
            $y = $year - $i;
            $tot = $knownTotals[$y] ?? null;

            if ($i === 0) {
                $html .= '<tr class="bg-[#fed7aa] font-bold">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" rowspan="6">' . "\n";
                $html .= '        Jumlah / <span class="italic font-bold">Total</span>' . "\n";
                $html .= '    </td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $y . '</td>' . "\n";
                for ($c = 0; $c < 12; $c++) {
                    $val = $tot[$c] ?? null;
                    $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $fmt($val) . '</td>' . "\n";
                }
                $html .= '</tr>' . "\n";
            } else {
                $html .= '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $y . '</td>' . "\n";
                for ($c = 0; $c < 12; $c++) {
                    $val = $tot[$c] ?? null;
                    $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $fmt($val) . '</td>' . "\n";
                }
                $html .= '</tr>' . "\n";
            }
        }

        $html .= '</tbody>';
        return $html;
    }
}
