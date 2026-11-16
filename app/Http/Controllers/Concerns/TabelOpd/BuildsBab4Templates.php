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
 * Template HTML tabel kode 431, 434, 435, 4120, dan 4124.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait BuildsBab4Templates
{
    /**
     * Membangun HTML bersih dan berformat BPS untuk Tabel 4.3.1 (Disdukcapil - Penduduk Menurut Agama yang Dianut)
     */
    private function buildTabel431Html(int $year, ?string $existingHtml = null): string
    {
        $dash = '<span class="text-slate-400 font-normal">-</span>';

        $fmt = function($val) use ($dash) {
            if ($val === null || $val === '' || $val === '-' || $val === '–' || $val === '—') return $dash;
            $str = trim((string) $val);
            if ($str === '0') return '0';
            $clean = preg_replace('/[^\d]/', '', $str);
            if ($clean === '') return $dash;
            return number_format((float)$clean, 0, ',', '.');
        };

        $rowsDef = [
            // 01. GUGUK PANJANG
            ['key' => '01_total', 'label' => '01. GUGUK PANJANG', 'isKec' => true],
            ['key' => '01_01', 'label' => '1. Tarok Dipo'],
            ['key' => '01_02', 'label' => '2. Bukik Cangang Kayu Ramang'],
            ['key' => '01_03', 'label' => '3. Pakan Kurai'],
            ['key' => '01_04', 'label' => '4. Aur Tajungkang Tengah Sawah'],
            ['key' => '01_05', 'label' => '5. Benteng Pasar Atas'],
            ['key' => '01_06', 'label' => '6. Kayu Kubu'],
            ['key' => '01_07', 'label' => '7. Bukik Apit Puhun'],
            // 02. MANDIANGIN KOTO SELAYAN
            ['key' => '02_total', 'label' => '02. MANDIANGIN KOTO SELAYAN', 'isKec' => true],
            ['key' => '02_01', 'label' => '1. Campago Guguk Bulek'],
            ['key' => '02_02', 'label' => '2. Campago Ipuh'],
            ['key' => '02_03', 'label' => '3. Puhun Tembok'],
            ['key' => '02_04', 'label' => '4. Kubu Gulai Bancah'],
            ['key' => '02_05', 'label' => '5. Puhun Pintu Kabun'],
            ['key' => '02_06', 'label' => '6. Pulai Anak Air'],
            ['key' => '02_07', 'label' => '7. Koto Selayan'],
            ['key' => '02_08', 'label' => '8. Garegeh'],
            ['key' => '02_09', 'label' => '9. Manggis Ganting'],
            // 03. AUR BIRUGO TIGO BALEH
            ['key' => '03_total', 'label' => '03. AUR BIRUGO TIGO BALEH', 'isKec' => true],
            ['key' => '03_01', 'label' => '1. Aur Kuning'],
            ['key' => '03_02', 'label' => '2. Birugo'],
            ['key' => '03_03', 'label' => '3. Belakang Balok'],
            ['key' => '03_04', 'label' => '4. Sapiran'],
            ['key' => '03_05', 'label' => '5. Kubu Tanjung'],
            ['key' => '03_06', 'label' => '6. Pakan Labuah'],
            ['key' => '03_07', 'label' => '7. Parit Antang'],
            ['key' => '03_08', 'label' => '8. Ladang Cakiah'],
            // TOTAL
            ['key' => 'total', 'label' => 'Jumlah / Total', 'isTotal' => true],
        ];

        $knownData = [
            2025 => [
                '01_total' => ['islam' => '48867', 'protestan' => '656', 'katholik' => '579', 'hindu' => '5', 'budha' => '103', 'lainnya' => '0'],
                '01_01'    => ['islam' => '18160', 'protestan' => '535', 'katholik' => '322', 'hindu' => '5', 'budha' => '4',   'lainnya' => '0'],
                '01_02'    => ['islam' => '2543',  'protestan' => '22',  'katholik' => '30',  'hindu' => '0', 'budha' => '2',   'lainnya' => '0'],
                '01_03'    => ['islam' => '7853',  'protestan' => '12',  'katholik' => '0',   'hindu' => '0', 'budha' => '7',   'lainnya' => '0'],
                '01_04'    => ['islam' => '8481',  'protestan' => '20',  'katholik' => '21',  'hindu' => '0', 'budha' => '3',   'lainnya' => '0'],
                '01_05'    => ['islam' => '1144',  'protestan' => '26',  'katholik' => '197', 'hindu' => '0', 'budha' => '87',  'lainnya' => '0'],
                '01_06'    => ['islam' => '4346',  'protestan' => '6',   'katholik' => '3',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '01_07'    => ['islam' => '6340',  'protestan' => '35',  'katholik' => '6',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '02_total' => ['islam' => '59317', 'protestan' => '1559', 'katholik' => '494', 'hindu' => '0', 'budha' => '25', 'lainnya' => '0'],
                '02_01'    => ['islam' => '8168',  'protestan' => '605', 'katholik' => '124', 'hindu' => '0', 'budha' => '1',   'lainnya' => '0'],
                '02_02'    => ['islam' => '11942', 'protestan' => '74',  'katholik' => '3',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '02_03'    => ['islam' => '6657',  'protestan' => '13',  'katholik' => '15',  'hindu' => '0', 'budha' => '3',   'lainnya' => '0'],
                '02_04'    => ['islam' => '7273',  'protestan' => '22',  'katholik' => '12',  'hindu' => '0', 'budha' => '6',   'lainnya' => '0'],
                '02_05'    => ['islam' => '8330',  'protestan' => '13',  'katholik' => '8',   'hindu' => '0', 'budha' => '7',   'lainnya' => '0'],
                '02_06'    => ['islam' => '6647',  'protestan' => '298', 'katholik' => '161', 'hindu' => '0', 'budha' => '8',   'lainnya' => '0'],
                '02_07'    => ['islam' => '1996',  'protestan' => '0',   'katholik' => '0',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '02_08'    => ['islam' => '3236',  'protestan' => '14',  'katholik' => '5',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '02_09'    => ['islam' => '5068',  'protestan' => '520', 'katholik' => '166', 'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '03_total' => ['islam' => '31749', 'protestan' => '184', 'katholik' => '53',  'hindu' => '0', 'budha' => '4',   'lainnya' => '0'],
                '03_01'    => ['islam' => '8062',  'protestan' => '8',   'katholik' => '0',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '03_02'    => ['islam' => '6986',  'protestan' => '49',  'katholik' => '6',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '03_03'    => ['islam' => '3036',  'protestan' => '47',  'katholik' => '27',  'hindu' => '0', 'budha' => '4',   'lainnya' => '0'],
                '03_04'    => ['islam' => '3691',  'protestan' => '80',  'katholik' => '20',  'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '03_05'    => ['islam' => '2046',  'protestan' => '0',   'katholik' => '0',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '03_06'    => ['islam' => '3830',  'protestan' => '0',   'katholik' => '0',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '03_07'    => ['islam' => '1681',  'protestan' => '0',   'katholik' => '0',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                '03_08'    => ['islam' => '2417',  'protestan' => '0',   'katholik' => '0',   'hindu' => '0', 'budha' => '0',   'lainnya' => '0'],
                'total'    => ['islam' => '139933','protestan' => '2399','katholik' => '1126','hindu' => '5', 'budha' => '132', 'lainnya' => '0'],
            ],
            2024 => [
                '01_total' => ['islam' => '48238', 'protestan' => '649', 'katholik' => '617', 'hindu' => '5', 'budha' => '105', 'lainnya' => '-'],
                '01_01'    => ['islam' => '18026', 'protestan' => '523', 'katholik' => '345', 'hindu' => '5', 'budha' => '4',   'lainnya' => '-'],
                '01_02'    => ['islam' => '2486',  'protestan' => '23',  'katholik' => '32',  'hindu' => '-', 'budha' => '2',   'lainnya' => '-'],
                '01_03'    => ['islam' => '7709',  'protestan' => '12',  'katholik' => '5',   'hindu' => '-', 'budha' => '7',   'lainnya' => '-'],
                '01_04'    => ['islam' => '8280',  'protestan' => '21',  'katholik' => '24',  'hindu' => '-', 'budha' => '4',   'lainnya' => '-'],
                '01_05'    => ['islam' => '1145',  'protestan' => '24',  'katholik' => '202', 'hindu' => '-', 'budha' => '88',  'lainnya' => '-'],
                '01_06'    => ['islam' => '4307',  'protestan' => '6',   'katholik' => '3',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '01_07'    => ['islam' => '6285',  'protestan' => '40',  'katholik' => '6',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '02_total' => ['islam' => '58704', 'protestan' => '1540', 'katholik' => '481', 'hindu' => '-', 'budha' => '26', 'lainnya' => '-'],
                '02_01'    => ['islam' => '8080',  'protestan' => '603', 'katholik' => '132', 'hindu' => '-', 'budha' => '1',   'lainnya' => '-'],
                '02_02'    => ['islam' => '11879', 'protestan' => '72',  'katholik' => '2',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '02_03'    => ['islam' => '6619',  'protestan' => '13',  'katholik' => '15',  'hindu' => '-', 'budha' => '4',   'lainnya' => '-'],
                '02_04'    => ['islam' => '7144',  'protestan' => '22',  'katholik' => '12',  'hindu' => '-', 'budha' => '7',   'lainnya' => '-'],
                '02_05'    => ['islam' => '8269',  'protestan' => '12',  'katholik' => '8',   'hindu' => '-', 'budha' => '6',   'lainnya' => '-'],
                '02_06'    => ['islam' => '6582',  'protestan' => '291', 'katholik' => '162', 'hindu' => '-', 'budha' => '8',   'lainnya' => '-'],
                '02_07'    => ['islam' => '1930',  'protestan' => '2',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '02_08'    => ['islam' => '3242',  'protestan' => '29',  'katholik' => '4',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '02_09'    => ['islam' => '4959',  'protestan' => '496', 'katholik' => '146', 'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_total' => ['islam' => '31205', 'protestan' => '178', 'katholik' => '52',  'hindu' => '-', 'budha' => '4',   'lainnya' => '-'],
                '03_01'    => ['islam' => '7980',  'protestan' => '9',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_02'    => ['islam' => '6831',  'protestan' => '44',  'katholik' => '7',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_03'    => ['islam' => '2989',  'protestan' => '45',  'katholik' => '25',  'hindu' => '-', 'budha' => '4',   'lainnya' => '-'],
                '03_04'    => ['islam' => '3561',  'protestan' => '79',  'katholik' => '20',  'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_05'    => ['islam' => '1989',  'protestan' => '-',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_06'    => ['islam' => '3742',  'protestan' => '-',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_07'    => ['islam' => '1675',  'protestan' => '-',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_08'    => ['islam' => '2438',  'protestan' => '1',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                'total'    => ['islam' => '138147','protestan' => '2367','katholik' => '1150','hindu' => '5', 'budha' => '135', 'lainnya' => '-'],
            ],
            2023 => [
                '01_total' => ['islam' => '47227', 'protestan' => '642', 'katholik' => '633', 'hindu' => '5', 'budha' => '111', 'lainnya' => '-'],
                '01_01'    => ['islam' => '17608', 'protestan' => '518', 'katholik' => '358', 'hindu' => '5', 'budha' => '5',   'lainnya' => '-'],
                '01_02'    => ['islam' => '2414',  'protestan' => '21',  'katholik' => '33',  'hindu' => '-', 'budha' => '2',   'lainnya' => '-'],
                '01_03'    => ['islam' => '7538',  'protestan' => '12',  'katholik' => '5',   'hindu' => '-', 'budha' => '7',   'lainnya' => '-'],
                '01_04'    => ['islam' => '8093',  'protestan' => '21',  'katholik' => '22',  'hindu' => '-', 'budha' => '4',   'lainnya' => '-'],
                '01_05'    => ['islam' => '1141',  'protestan' => '24',  'katholik' => '206', 'hindu' => '-', 'budha' => '93',  'lainnya' => '-'],
                '01_06'    => ['islam' => '4223',  'protestan' => '6',   'katholik' => '3',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '01_07'    => ['islam' => '6210',  'protestan' => '40',  'katholik' => '6',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '02_total' => ['islam' => '57382', 'protestan' => '1488', 'katholik' => '473', 'hindu' => '-', 'budha' => '28', 'lainnya' => '-'],
                '02_01'    => ['islam' => '7844',  'protestan' => '583', 'katholik' => '130', 'hindu' => '-', 'budha' => '1',   'lainnya' => '-'],
                '02_02'    => ['islam' => '11617', 'protestan' => '70',  'katholik' => '2',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '02_03'    => ['islam' => '6486',  'protestan' => '13',  'katholik' => '15',  'hindu' => '-', 'budha' => '5',   'lainnya' => '-'],
                '02_04'    => ['islam' => '7003',  'protestan' => '22',  'katholik' => '12',  'hindu' => '-', 'budha' => '7',   'lainnya' => '-'],
                '02_05'    => ['islam' => '8079',  'protestan' => '11',  'katholik' => '8',   'hindu' => '-', 'budha' => '7',   'lainnya' => '-'],
                '02_06'    => ['islam' => '6424',  'protestan' => '284', 'katholik' => '156', 'hindu' => '-', 'budha' => '8',   'lainnya' => '-'],
                '02_07'    => ['islam' => '1899',  'protestan' => '2',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '02_08'    => ['islam' => '3168',  'protestan' => '28',  'katholik' => '4',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '02_09'    => ['islam' => '4862',  'protestan' => '475', 'katholik' => '146', 'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_total' => ['islam' => '30328', 'protestan' => '162', 'katholik' => '51',  'hindu' => '-', 'budha' => '4',   'lainnya' => '-'],
                '03_01'    => ['islam' => '7731',  'protestan' => '9',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_02'    => ['islam' => '6665',  'protestan' => '37',  'katholik' => '7',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_03'    => ['islam' => '2913',  'protestan' => '39',  'katholik' => '24',  'hindu' => '-', 'budha' => '4',   'lainnya' => '-'],
                '03_04'    => ['islam' => '3426',  'protestan' => '76',  'katholik' => '20',  'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_05'    => ['islam' => '1958',  'protestan' => '-',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_06'    => ['islam' => '3662',  'protestan' => '-',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_07'    => ['islam' => '1633',  'protestan' => '-',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                '03_08'    => ['islam' => '2340',  'protestan' => '1',   'katholik' => '-',   'hindu' => '-', 'budha' => '-',   'lainnya' => '-'],
                'total'    => ['islam' => '134937','protestan' => '2292','katholik' => '1157','hindu' => '5', 'budha' => '143', 'lainnya' => '-'],
            ],
        ];

        $rowData = $knownData[$year] ?? [];

        // Parse existingHtml jika ada
        if ($existingHtml) {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $existingHtml . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);
            $trs = $xpath->query('//tbody/tr');
            $rIdx = 0;
            foreach ($trs as $tr) {
                if ($rIdx >= count($rowsDef)) break;
                $tds = $xpath->query('td', $tr);
                if ($tds->length >= 7) {
                    $targetKey = $rowsDef[$rIdx]['key'];
                    $rowData[$targetKey] = [
                        'islam'     => trim($tds->item(1)->textContent),
                        'protestan' => trim($tds->item(2)->textContent),
                        'katholik'  => trim($tds->item(3)->textContent),
                        'hindu'     => trim($tds->item(4)->textContent),
                        'budha'     => trim($tds->item(5)->textContent),
                        'lainnya'   => trim($tds->item(6)->textContent),
                    ];
                }
                $rIdx++;
            }
        }

        $html = '<thead>' . "\n";
        $html .= '<tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Islam</div><div class="italic font-normal text-[11px] sm:text-xs">Moslem</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Protestan</div><div class="italic font-normal text-[11px] sm:text-xs">Protestant</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Katholik</div><div class="italic font-normal text-[11px] sm:text-xs">Catholic</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Hindu</div><div class="italic font-normal text-[11px] sm:text-xs">Hindu</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Budha</div><div class="italic font-normal text-[11px] sm:text-xs">Buddha</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '    <th class="py-3 px-4 font-bold border border-slate-700">' . "\n";
        $html .= '        <div>Lainnya</div><div class="italic font-normal text-[11px] sm:text-xs">Other</div>' . "\n";
        $html .= '    </th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '<tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(1)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(2)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(3)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(4)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(5)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(6)</th>' . "\n";
        $html .= '    <th class="py-1 px-3 border border-slate-700">(7)</th>' . "\n";
        $html .= '</tr>' . "\n";
        $html .= '</thead>' . "\n";
        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";

        foreach ($rowsDef as $r) {
            $k = $r['key'];
            $d = $rowData[$k] ?? [];
            $isKec = !empty($r['isKec']);
            $isTot = !empty($r['isTotal']);

            $vIslam     = $fmt($d['islam'] ?? null);
            $vProtestan = $fmt($d['protestan'] ?? null);
            $vKatholik  = $fmt($d['katholik'] ?? null);
            $vHindu     = $fmt($d['hindu'] ?? null);
            $vBudha     = $fmt($d['budha'] ?? null);
            $vLainnya   = $fmt($d['lainnya'] ?? null);

            if ($isTot) {
                $html .= '<tr class="bg-[#fed7aa] font-bold">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total</span></td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $vIslam . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $vProtestan . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $vKatholik . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $vHindu . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $vBudha . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">' . $vLainnya . '</td>' . "\n";
                $html .= '</tr>' . "\n";
            } elseif ($isKec) {
                $html .= '<tr class="bg-amber-100/80 font-bold">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-bold align-top">' . $r['label'] . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">' . $vIslam . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">' . $vProtestan . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">' . $vKatholik . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">' . $vHindu . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">' . $vBudha . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">' . $vLainnya . '</td>' . "\n";
                $html .= '</tr>' . "\n";
            } else {
                $html .= '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-left font-medium align-top pl-8">' . $r['label'] . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $vIslam . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $vProtestan . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $vKatholik . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $vHindu . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $vBudha . '</td>' . "\n";
                $html .= '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">' . $vLainnya . '</td>' . "\n";
                $html .= '</tr>' . "\n";
            }
        }

        $html .= '</tbody>';
        return $html;
    }

    private function buildTabel434Html(int $year, ?string $existingHtml = null): string
    {
        $officialData = [
            2023 => [
                'gp' => ['kejadian' => '38', 'korban' => '297', 'rumah' => '0', 'lainnya' => '1'],
                'mks' => ['kejadian' => '48', 'korban' => '561', 'rumah' => '2', 'lainnya' => '1'],
                'abtb' => ['kejadian' => '23', 'korban' => '98', 'rumah' => '1', 'lainnya' => '0'],
                'total' => ['kejadian' => '109', 'korban' => '956', 'rumah' => '3', 'lainnya' => '2'],
            ],
            2024 => [
                'gp' => ['kejadian' => '45', 'korban' => '249', 'rumah' => '8', 'lainnya' => '0'],
                'mks' => ['kejadian' => '31', 'korban' => '694', 'rumah' => '0', 'lainnya' => '0'],
                'abtb' => ['kejadian' => '17', 'korban' => '712', 'rumah' => '50', 'lainnya' => '1'],
                'total' => ['kejadian' => '93', 'korban' => '1655', 'rumah' => '58', 'lainnya' => '1'],
            ],
            2025 => [
                'gp' => ['kejadian' => '21', 'korban' => '130', 'rumah' => '33', 'lainnya' => '6'],
                'mks' => ['kejadian' => '42', 'korban' => '74', 'rumah' => '20', 'lainnya' => '8'],
                'abtb' => ['kejadian' => '4', 'korban' => '0', 'rumah' => '1', 'lainnya' => '1'],
                'total' => ['kejadian' => '67', 'korban' => '204', 'rumah' => '54', 'lainnya' => '15'],
            ],
        ];

        $dataForYear = $officialData[$year] ?? [];

        $dists = [
            ['key' => 'guguk_panjang', 'label' => '01. GUGUK PANJANG', 'def' => 'gp'],
            ['key' => 'mandiangin_koto_selayan', 'label' => '02. MANDIANGIN KOTO SELAYAN', 'def' => 'mks'],
            ['key' => 'aur_birugo_tigo_baleh', 'label' => '03. AUR BIRUGO TIGO BALEH', 'def' => 'abtb'],
        ];

        $dbRecords = TabelData::where('table_code', '4.3.4')
            ->where('opd_code', '09')
            ->where('year', $year)
            ->pluck('value', 'row_key')
            ->toArray();

        $cols = ['kejadian', 'korban', 'rumah', 'lainnya'];
        $rowsHtml = '';
        foreach ($dists as $d) {
            $vals = [];
            foreach ($cols as $c) {
                $k = "{$d['key']}_{$c}";
                $vals[] = $dbRecords[$k] ?? ($dataForYear[$d['def']][$c] ?? '-');
            }

            $rowsHtml .= "
            <tr class=\"hover:bg-amber-100/60 transition-colors\" data-key=\"{$d['key']}\">
                <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left align-top\">{$d['label']}</td>
                <td class=\"py-2.5 px-4 text-center border border-slate-700 align-top\">{$vals[0]}</td>
                <td class=\"py-2.5 px-4 text-center border border-slate-700 align-top\">{$vals[1]}</td>
                <td class=\"py-2.5 px-4 text-center border border-slate-700 align-top\">{$vals[2]}</td>
                <td class=\"py-2.5 px-4 text-center border border-slate-700 align-top\">{$vals[3]}</td>
            </tr>";
        }

        $totVals = [];
        foreach ($cols as $c) {
            $k = "total_{$c}";
            $totVals[] = $dbRecords[$k] ?? ($dataForYear['total'][$c] ?? '-');
        }

        return "<thead>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                <th class=\"py-3 px-4 font-bold border border-slate-700\" rowspan=\"2\">
                    <div>Kecamatan</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">District</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\" rowspan=\"2\">
                    <div>Jumlah Kejadian Bencana Alam</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Number of Natural Disaster</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\" rowspan=\"2\">
                    <div>Jumlah Korban Terdampak</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Number of Victims Affected</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\" colspan=\"2\">
                    <div>Jumlah Kerusakan Bangunan</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Amount of Damage to Buildings</div>
                </th>
            </tr>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Rumah</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">House</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Lainnya</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Other</div>
                </th>
            </tr>
            <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
                <th class=\"py-1 px-3 border border-slate-700\">(1)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(2)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(3)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(4)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(5)</th>
            </tr>
        </thead>
        <tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
            {$rowsHtml}
            <tr class=\"bg-[#fed7aa] font-bold\" data-key=\"total\">
                <td class=\"py-2.5 px-4 border border-slate-700 text-left font-extrabold align-top\">Jumlah / <span class=\"italic font-bold\">Total</span></td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold\">{$totVals[0]}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold\">{$totVals[1]}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold\">{$totVals[2]}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold\">{$totVals[3]}</td>
            </tr>
        </tbody>";
    }

    /**
     * Membangun HTML bersih untuk Tabel 4.3.5 (Dinas Pemadam Kebakaran - Jumlah Kejadian Kebakaran Menurut Bulan)
     * Menggunakan rentang 5 tahun dinamis: [year-4, year-3, year-2, year-1, year]
     */
    private function buildTabel435Html(int $year, ?string $existingHtml = null): string
    {
        $years = [$year - 4, $year - 3, $year - 2, $year - 1, $year];

        $months = [
            ['key' => 'januari', 'label' => '01. Januari / <span class="italic font-normal text-slate-700">January</span>'],
            ['key' => 'februari', 'label' => '02. Februari / <span class="italic font-normal text-slate-700">February</span>'],
            ['key' => 'maret', 'label' => '03. Maret / <span class="italic font-normal text-slate-700">March</span>'],
            ['key' => 'april', 'label' => '04. April / <span class="italic font-normal text-slate-700">April</span>'],
            ['key' => 'mei', 'label' => '05. Mei / <span class="italic font-normal text-slate-700">May</span>'],
            ['key' => 'juni', 'label' => '06. Juni / <span class="italic font-normal text-slate-700">June</span>'],
            ['key' => 'juli', 'label' => '07. Juli / <span class="italic font-normal text-slate-700">July</span>'],
            ['key' => 'agustus', 'label' => '08. Agustus / <span class="italic font-normal text-slate-700">August</span>'],
            ['key' => 'september', 'label' => '09. September / <span class="italic font-normal text-slate-700">September</span>'],
            ['key' => 'oktober', 'label' => '10. Oktober / <span class="italic font-normal text-slate-700">October</span>'],
            ['key' => 'november', 'label' => '11. November / <span class="italic font-normal text-slate-700">November</span>'],
            ['key' => 'desember', 'label' => '12. Desember / <span class="italic font-normal text-slate-700">December</span>'],
            ['key' => 'total', 'label' => 'Jumlah / <span class="italic font-bold">Total</span>', 'isTotal' => true],
        ];

        // Ambil data jika ada dari TabelData
        $dbRecords = TabelData::where('table_code', '4.3.5')
            ->whereIn('year', $years)
            ->get();
        $dbStore = [];
        foreach ($dbRecords as $r) {
            if ($r->value !== null && $r->value !== '' && $r->value !== '-') {
                $dbStore[(int)$r->year][$r->row_key] = $r->value;
            }
        }

        $thYearCols = '';
        $thIndexCols = '';
        foreach ($years as $idx => $y) {
            $isCur = ($y === $year);
            $thBg = $isCur ? 'bg-[#ea580c] font-black' : '';
            $thYearCols .= "<th class=\"py-2 px-3 border border-slate-700 text-center {$thBg}\">{$y}</th>";
            $colNum = $idx + 2;
            $thIndexCols .= "<th class=\"py-1 px-3 border border-slate-700 text-center\">({$colNum})</th>";
        }

        $thead = "<thead>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                <th class=\"py-3 px-4 font-bold border border-slate-700 align-middle\" rowspan=\"2\">
                    <div>Bulan</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Month</div>
                </th>
                <th class=\"py-2 px-4 font-bold border border-slate-700 text-center\" colspan=\"5\">
                    <div>Kejadian Kebakaran</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Fire Incident</div>
                </th>
            </tr>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                {$thYearCols}
            </tr>
            <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
                <th class=\"py-1 px-3 border border-slate-700\">(1)</th>
                {$thIndexCols}
            </tr>
        </thead>";

        $tbody = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
        foreach ($months as $m) {
            $isTot = !empty($m['isTotal']);
            $rowCls = $isTot ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
            $tdCls = $isTot ? 'font-bold' : '';

            $tbody .= "<tr class=\"{$rowCls}\" data-key=\"{$m['key']}\">";
            $tbody .= "<td class=\"py-2 px-4 border border-slate-700 text-left align-middle {$tdCls}\">{$m['label']}</td>";

            foreach ($years as $y) {
                $val = '-';
                if (isset($dbStore[$y][$m['key']]) && $dbStore[$y][$m['key']] !== '') {
                    $val = $dbStore[$y][$m['key']];
                }
                $isCurrentCol = ($y === $year);
                $colBg = $isCurrentCol ? 'bg-amber-100/60 font-bold' : '';
                $valDisplay = ($val === '' || $val === '-') ? '<span class="text-slate-400 font-normal">-</span>' : e($val);
                $tbody .= "<td class=\"py-2 px-3 border border-slate-700 text-center align-middle {$colBg} {$tdCls}\">{$valDisplay}</td>";
            }
            $tbody .= '</tr>';
        }
        $tbody .= '</tbody>';

        return $thead . $tbody;
    }

    /**
     * Build HTML untuk Tabel 4.1.20 (Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi)
     * Format multi-tahun 4 tahun berurutan [year-3, year-2, year-1, year]
     */
    private function buildTabel4120Html(int $year, ?string $existingHtml = null): string
    {
        $y1 = $year - 3;
        $y2 = $year - 2;
        $y3 = $year - 1;
        $y4 = $year;
        $targetYears = [$y1, $y2, $y3, $y4];

        $sportsList = array (
  0 => 
  array (
    'name' => '01. Sepak Bola / Soccer',
    2022 => '3',
    2023 => '3',
    2024 => '3',
    2025 => '3',
  ),
  1 => 
  array (
    'name' => '02. Bola Volly / Volley Ball',
    2022 => '16',
    2023 => '16',
    2024 => '5',
    2025 => '5',
  ),
  2 => 
  array (
    'name' => '03. Bola Basket / Basket Ball',
    2022 => '17',
    2023 => '17',
    2024 => '18',
    2025 => '18',
  ),
  3 => 
  array (
    'name' => '04. Bulu Tangkis / Badminton',
    2022 => '7',
    2023 => '7',
    2024 => '7',
    2025 => '7',
  ),
  4 => 
  array (
    'name' => '05. Tenis Meja / Table Tennis',
    2022 => '3',
    2023 => '3',
    2024 => '3',
    2025 => '3',
  ),
  5 => 
  array (
    'name' => '06. Atletik / Atletic',
    2022 => '3',
    2023 => '3',
    2024 => '3',
    2025 => '3',
  ),
  6 => 
  array (
    'name' => '07. Tenis / Tennis',
    2022 => '7',
    2023 => '7',
    2024 => '6',
    2025 => '6',
  ),
  7 => 
  array (
    'name' => '08. Catur / Chess',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  8 => 
  array (
    'name' => '09. Bridge / Bridge',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  9 => 
  array (
    'name' => '10. Bola Sodok / Billiards',
    2022 => '1',
    2023 => '1',
    2024 => '3',
    2025 => '3',
  ),
  10 => 
  array (
    'name' => '11. Renang / Swimming',
    2022 => '6',
    2023 => '6',
    2024 => '6',
    2025 => '6',
  ),
  11 => 
  array (
    'name' => '12. Karate / Karate',
    2022 => '2',
    2023 => '2',
    2024 => '2',
    2025 => '2',
  ),
  12 => 
  array (
    'name' => '13. Silat / Self Defence',
    2022 => '26',
    2023 => '26',
    2024 => '26',
    2025 => '26',
  ),
  13 => 
  array (
    'name' => '14. Gulat / Wrestler',
    2022 => '2',
    2023 => '2',
    2024 => '2',
    2025 => '2',
  ),
  14 => 
  array (
    'name' => '15. Aero Sport / Aero Sport',
    2022 => '1',
    2023 => '1',
    2024 => '3',
    2025 => '3',
  ),
  15 => 
  array (
    'name' => '16. Kempo / Kempo',
    2022 => '5',
    2023 => '5',
    2024 => '5',
    2025 => '5',
  ),
  16 => 
  array (
    'name' => '17. Wushu / Wushu',
    2022 => '3',
    2023 => '3',
    2024 => '3',
    2025 => '3',
  ),
  17 => 
  array (
    'name' => '18. Hoki / Hockey',
    2022 => '1',
    2023 => '1',
    2024 => '2',
    2025 => '2',
  ),
  18 => 
  array (
    'name' => '19. Menembak dan Berburu / Shooting',
    2022 => '2',
    2023 => '2',
    2024 => '2',
    2025 => '2',
  ),
  19 => 
  array (
    'name' => '20. Senam / Exercise',
    2022 => '4',
    2023 => '4',
    2024 => '1',
    2025 => '1',
  ),
  20 => 
  array (
    'name' => '21. Panahan / Archery',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  21 => 
  array (
    'name' => '22. Balap Motor / Road Race',
    2022 => '1',
    2023 => '1',
    2024 => '5',
    2025 => '5',
  ),
  22 => 
  array (
    'name' => '23. Sepau Roda / Roller sports',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  23 => 
  array (
    'name' => '24. Tarung Derajat / Tarung Derajat',
    2022 => '6',
    2023 => '6',
    2024 => '6',
    2025 => '6',
  ),
  24 => 
  array (
    'name' => '25. Tinju / Boxing',
    2022 => '7',
    2023 => '7',
    2024 => '6',
    2025 => '6',
  ),
  25 => 
  array (
    'name' => '26. Muaythai / Muaythai',
    2022 => '3',
    2023 => '3',
    2024 => '2',
    2025 => '2',
  ),
  26 => 
  array (
    'name' => '27. Taekwondo / Taekwondo',
    2022 => '3',
    2023 => '3',
    2024 => '3',
    2025 => '3',
  ),
  27 => 
  array (
    'name' => '28. Dayung / Rowing',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  28 => 
  array (
    'name' => '29. Balap Sepeda / Bike Racing',
    2022 => '5',
    2023 => '5',
    2024 => '5',
    2025 => '5',
  ),
  29 => 
  array (
    'name' => '30. Panjat Tebing / Rock Climbing',
    2022 => '3',
    2023 => '3',
    2024 => '1',
    2025 => '1',
  ),
  30 => 
  array (
    'name' => '31. Gate Ball / Gate Ball',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  31 => 
  array (
    'name' => '32. Hapkido / Hapkido',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  32 => 
  array (
    'name' => '33. Bola Tangan / Hand Ball',
    2022 => '1',
    2023 => '1',
    2024 => '3',
    2025 => '3',
  ),
  33 => 
  array (
    'name' => '34. Kriket / Cricket',
    2022 => '1',
    2023 => '1',
    2024 => '2',
    2025 => '2',
  ),
  34 => 
  array (
    'name' => '35. Beladiri Amatir / Mix Martial Arts',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  35 => 
  array (
    'name' => '36. Kick Boxing / Kick Boxing',
    2022 => '1',
    2023 => '1',
    2024 => '2',
    2025 => '2',
  ),
  36 => 
  array (
    'name' => '37. Binaraga / Bodybuilding',
    2022 => '5',
    2023 => '5',
    2024 => '5',
    2025 => '5',
  ),
  37 => 
  array (
    'name' => '38. Angkat Berat / Powerlifting',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  38 => 
  array (
    'name' => '39. Petanque / Petanque',
    2022 => '1',
    2023 => '1',
    2024 => '2',
    2025 => '2',
  ),
  39 => 
  array (
    'name' => '40. Sambo / Sambo',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  40 => 
  array (
    'name' => '41. Angkat Besi / Weightlifting',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  41 => 
  array (
    'name' => '42. E–Sport / E–Sport',
    2022 => '1',
    2023 => '1',
    2024 => '1',
    2025 => '1',
  ),
  42 => 
  array (
    'name' => '43. PJSI / Persatuan Judo Seluruh Indonesia',
    2022 => '-',
    2023 => '-',
    2024 => '1',
    2025 => '1',
  ),
  43 => 
  array (
    'name' => '44. PORDASI / Persatuan Olahraga Berkuda Seluruh Indonesia',
    2022 => '-',
    2023 => '-',
    2024 => '1',
    2025 => '1',
  ),
  44 => 
  array (
    'name' => '45. PSTI / Persatuan Sepak Takrau Indonesia',
    2022 => '-',
    2023 => '-',
    2024 => '1',
    2025 => '1',
  ),
  45 => 
  array (
    'name' => '46. PTMSI / Persatuan Tenis Meja Seluruh Indoneisa',
    2022 => '-',
    2023 => '-',
    2024 => '1',
    2025 => '1',
  ),
);

        // Muat data dari tabel_opd_data jika ada
        $dbRecords = TabelData::where('table_code', '4.1.20')
            ->where('opd_code', '10')
            ->whereIn('year', $targetYears)
            ->get();
        $dbStore = [];
        foreach ($dbRecords as $r) {
            $dbStore[(int)$r->year][$r->row_key] = $r->value;
        }

        $thead = '<thead>
            <tr class="bg-[#f95a00] text-white text-center font-bold">
                <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle">
                    <div>Jenis Olahraga</div>
                    <div class="italic font-normal text-[11px] sm:text-xs">Kind of Sport</div>
                </th>';
        foreach ($targetYears as $y) {
            $activeClass = ($y === $year) ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : '';
            $thead .= "<th class=\"py-3 px-4 border border-slate-700 text-center {$activeClass}\"><div>{$y}</div></th>";
        }
        $thead .= '</tr>
            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>';
        foreach ($targetYears as $idx => $y) {
            $colNum = $idx + 2;
            $thead .= "<th class=\"py-1 px-3 border border-slate-700 text-center\">()</th>";
        }
        $thead .= '</tr></thead>';

        $tbody = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
        foreach ($sportsList as $idx => $sport) {
            $orderIdx = $idx + 1;
            $rowKey = 'sport_' . $orderIdx;
            $rawName = $sport['name'];

            $nameHtml = e($rawName);
            if (str_contains($rawName, '/')) {
                $parts = explode('/', $rawName);
                $nameHtml = e(trim($parts[0])) . ' / <span class="italic text-slate-600">' . e(trim($parts[1] ?? '')) . '</span>';
            }

            $tbody .= "<tr class=\"hover:bg-amber-100/60 transition-colors\" data-key=\"{$rowKey}\">";
            $tbody .= "<td class=\"py-2 px-4 font-semibold border border-slate-700 text-left align-middle\">{$nameHtml}</td>";

            foreach ($targetYears as $y) {
                $val = '-';
                if (isset($dbStore[$y][$rowKey]) && $dbStore[$y][$rowKey] !== '') {
                    $val = $dbStore[$y][$rowKey];
                } elseif (isset($sport[(string)$y]) && $sport[(string)$y] !== '') {
                    $val = $sport[(string)$y];
                }
                $isCurrentCol = ($y === $year);
                $colBg = $isCurrentCol ? 'bg-amber-100/60 font-bold' : '';
                $valDisplay = ($val === '' || $val === '-') ? '<span class="text-slate-400 font-normal">-</span>' : e($val);
                $tbody .= "<td class=\"py-2 px-3 border border-slate-700 text-center align-middle {$colBg}\">{$valDisplay}</td>";
            }
            $tbody .= '</tr>';
        }
        $tbody .= '</tbody>';

        return $thead . $tbody;
    }

    /**
     * Build HTML untuk Tabel 4.1.24 (Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi)
     */
    private function buildTabel4124Html(int $year, ?string $existingHtml = null, string $opdCode = '10'): string
    {
        $isFuture = ($year > 2025);
        $rows = [
            ['key' => 'umum', 'label' => 'Umum / <span class="italic font-normal text-slate-700">General</span>', 'def' => [21, 38460, 52776, 24123]],
            ['key' => 'sd_mi', 'label' => 'SD / <span class="italic font-normal text-slate-700">MI / Primary School</span>', 'def' => [62, 309610, 4341086, 387320]],
            ['key' => 'smp_mts', 'label' => 'SMP / <span class="italic font-normal text-slate-700">MTs / Junior High School</span>', 'def' => [19, 52104, 567268, 173524]],
            ['key' => 'sma_smk_ma', 'label' => 'SMA / <span class="italic font-normal text-slate-700">SMK/MA / Senior High School</span>', 'def' => [26, 44085, 714152, 34782]],
            ['key' => 'perguruan_tinggi', 'label' => 'Perguruan Tinggi / <span class="italic font-normal text-slate-700">College</span>', 'def' => [19, 25103, 15721, 10926]],
            ['key' => 'taman_bacaan', 'label' => 'Taman Bacaan / <span class="italic font-normal text-slate-700">Perpustakaan Masyarakat / Public Library</span>', 'def' => [11, 872, 1245, 2764]],
            ['key' => 'total', 'label' => 'Jumlah / <span class="italic font-bold">Total</span>', 'isTotal' => true, 'def' => [158, 470234, 5692248, 633439]]
        ];

        // Load data from tabel_opd_data
        $dbRecords = TabelData::where('table_code', '4.1.24')
            ->where('year', $year)
            ->get();
        $dbStore = [];
        foreach ($dbRecords as $r) {
            $dbStore[$r->row_key] = $r->value;
        }

        $thead = '<thead>
            <tr class="bg-[#f95a00] text-white text-center font-bold">
                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                    <div>Jenis Perpustakaan</div>
                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Library</div>
                </th>
                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                    <div>Jumlah Perpustakaan</div>
                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Library</div>
                </th>
                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                    <div>Jumlah Koleksi</div>
                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Collection</div>
                </th>
                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                    <div>Jumlah Pengunjung</div>
                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Visitor</div>
                </th>
            </tr>
            <tr class="bg-[#f95a00] text-white text-center font-bold">
                <th class="py-2 px-3 font-bold border border-slate-700">
                    <div>Judul</div>
                    <div class="italic font-normal text-[11px] sm:text-xs">Title</div>
                </th>
                <th class="py-2 px-3 font-bold border border-slate-700">
                    <div>Eksemplar</div>
                    <div class="italic font-normal text-[11px] sm:text-xs">Copies</div>
                </th>
            </tr>
            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                <th class="py-1 px-3 border border-slate-700">(1)</th>
                <th class="py-1 px-3 border border-slate-700">(2)</th>
                <th class="py-1 px-3 border border-slate-700">(3)</th>
                <th class="py-1 px-3 border border-slate-700">(4)</th>
                <th class="py-1 px-3 border border-slate-700">(5)</th>
            </tr>
        </thead>';

        $tbody = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
        $cols = ['perpus', 'judul', 'eksemplar', 'pengunjung'];

        foreach ($rows as $item) {
            $isTot = !empty($item['isTotal']);
            $rowCls = $isTot ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
            $tdCls = $isTot ? 'font-bold' : '';

            $tbody .= "<tr class=\"{$rowCls}\" data-key=\"{$item['key']}\">";
            $tbody .= "<td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle\">{$item['label']}</td>";

            for ($c = 0; $c < 4; $c++) {
                $dbKey = "{$item['key']}_{$cols[$c]}";
                $val = '-';
                if (isset($dbStore[$dbKey]) && $dbStore[$dbKey] !== '') {
                    $val = $dbStore[$dbKey];
                } elseif (!$isFuture && $year == 2025) {
                    $val = $item['def'][$c];
                }
                $valDisplay = ($val === '' || $val === '-') ? '<span class="text-slate-400 font-normal">-</span>' : e($val);
                $tbody .= "<td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle {$tdCls}\">{$valDisplay}</td>";
            }
            $tbody .= '</tr>';
        }
        $tbody .= '</tbody>';

        return $thead . $tbody;
    }

    /**
     * Build atau perbaiki struktur HTML bersih dan presisi untuk tabel 3-in-1 pendidikan (Sekolah, Guru, Murid)
     * Meliputi tabel: 4.1.1, 4.1.3 s.d. 4.1.17
     */
    public function build3in1EducationHtml(int $year, ?string $existingHtml = null): string
    {
        $y1 = ($year - 3) . '/' . ($year - 2);
        $y2 = ($year - 2) . '/' . ($year - 1);
        $y3 = ($year - 1) . '/' . ($year);

        $districts = [
            '01. Guguk Panjang',
            '02. Mandiangin Koto Selayan',
            '03. Aur Birugo Tigo Baleh',
            'Bukittinggi'
        ];

        // Format cell value
        $formatVal = function($v) {
            $vStr = trim((string)$v);
            if ($vStr === '' || $vStr === '-' || $vStr === '–' || $vStr === '—') {
                return '<span class="text-slate-400 font-normal">-</span>';
            }
            return htmlspecialchars($vStr, ENT_QUOTES, 'UTF-8');
        };

        // Ekstrak baris data aktual dari existingHtml jika ada
        $extractedRows = [];
        if (!empty($existingHtml)) {
            if (preg_match('/<tbody[^>]*>(.*?)<\/tbody>/is', $existingHtml, $mTb)) {
                $tbHtml = $mTb[1];
            } else {
                $tbHtml = $existingHtml;
            }

            preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $tbHtml, $trs);
            foreach ($trs[1] as $tr) {
                // Lewati baris subheader di dalam tbody
                if (preg_match('/(?:Guru|Teachers|Murid|Students|Sekolah|Schools|Negeri|Public|Swasta|Private|subtable-)/i', $tr)) {
                    continue;
                }
                preg_match_all('/<(?:td|th)[^>]*>(.*?)<\/(?:td|th)>/is', $tr, $cells);
                if (empty($cells[1])) continue;
                $texts = array_map(function($c) { return trim(strip_tags($c)); }, $cells[1]);
                $first = $texts[0] ?? '';

                if (preg_match('/^\s*0?\d\./', $first) || str_starts_with($first, 'Bukittinggi')) {
                    $vals = array_slice($texts, 1);
                    // Jika data Excel hanya 6 kolom (Negeri 3, Swasta 3), hitung otomatis 3 kolom Jumlah (Negeri + Swasta)
                    if (count($vals) >= 6 && count($vals) < 9) {
                        for ($k = 0; $k < 3; $k++) {
                            $cleanN = str_replace(['.', ','], '', trim($vals[$k] ?? ''));
                            $cleanS = str_replace(['.', ','], '', trim($vals[$k + 3] ?? ''));
                            $hasN = is_numeric($cleanN);
                            $hasS = is_numeric($cleanS);
                            if (!$hasN && !$hasS) {
                                $vals[6 + $k] = '-';
                            } else {
                                $sum = ($hasN ? (int)$cleanN : 0) + ($hasS ? (int)$cleanS : 0);
                                $vals[6 + $k] = number_format($sum, 0, ',', '.');
                            }
                        }
                    }
                    // Pastikan panjang nilai minimal 9 kolom
                    while (count($vals) < 9) {
                        $vals[] = '-';
                    }
                    $extractedRows[] = [
                        'label' => $first,
                        'values' => array_slice($vals, 0, 9)
                    ];
                }
            }
        }

        // Siapkan 12 baris data: 0..3 Sekolah, 4..7 Guru, 8..11 Murid
        $finalDataRows = [];
        for ($i = 0; $i < 12; $i++) {
            $distIdx = $i % 4;
            $defaultLabel = $districts[$distIdx];

            if (isset($extractedRows[$i])) {
                $finalDataRows[$i] = [
                    'label' => $defaultLabel,
                    'values' => $extractedRows[$i]['values']
                ];
            } else {
                $finalDataRows[$i] = [
                    'label' => $defaultLabel,
                    'values' => array_fill(0, 9, '-')
                ];
            }
        }

        $html = '<thead>' . "\n";
        $html .= '    <tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">' . "\n";
        $html .= '            <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">' . "\n";
        $html .= '            <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">' . "\n";
        $html .= '            <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '    </tr>' . "\n";
        $html .= '    <tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">' . "\n";
        $html .= '            <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">' . "\n";
        $html .= '            <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '    </tr>' . "\n";
        $html .= '    <tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        for ($i = 0; $i < 3; $i++) {
            $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\"><div>{$y1}</div></th>\n";
            $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\"><div>{$y2}</div></th>\n";
            $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700\"><div>{$y3}</div></th>\n";
        }
        $html .= '    </tr>' . "\n";
        $html .= '    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' . "\n";
        for ($i = 1; $i <= 10; $i++) {
            $html .= "        <th class=\"py-1 px-3 border border-slate-700\">({$i})</th>\n";
        }
        $html .= '    </tr>' . "\n";
        $html .= '</thead>' . "\n";

        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";

        $renderDataSection = function($startIndex, $sectionTitle, $sectionTitleEn) use (&$html, $finalDataRows, $formatVal, $y1, $y2, $y3) {
            if ($startIndex > 0) {
                // Baris pemisah antar sub-tabel
                $html .= "    <tr class=\"subtable-spacer-row pointer-events-none select-none\">\n";
                $html .= "        <td colspan=\"10\" class=\"h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center\">&nbsp;</td>\n";
                $html .= "    </tr>\n";

                // Subheader Judul Bagian (Guru / Murid)
                $html .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold subtable-header-title\">\n";
                $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" rowspan=\"3\">\n";
                $html .= "            <div>Kecamatan</div><div class=\"italic font-normal text-[11px] sm:text-xs\">District</div>\n";
                $html .= "        </th>\n";
                $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"6\">\n";
                $html .= "            <div>{$sectionTitle}</div><div class=\"italic font-normal text-[11px] sm:text-xs\">{$sectionTitleEn}</div>\n";
                $html .= "        </th>\n";
                $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" rowspan=\"2\" colspan=\"3\">\n";
                $html .= "            <div>Jumlah</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Total</div>\n";
                $html .= "        </th>\n";
                $html .= "    </tr>\n";

                // Subheader Status (Negeri / Swasta)
                $html .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle\">\n";
                $html .= "        <th class=\"py-2.5 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"3\">\n";
                $html .= "            <div>Negeri</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Public</div>\n";
                $html .= "        </th>\n";
                $html .= "        <th class=\"py-2.5 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"3\">\n";
                $html .= "            <div>Swasta</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Private</div>\n";
                $html .= "        </th>\n";
                $html .= "    </tr>\n";

                // Subheader Tahun Ajaran (3 kolom x 3)
                $html .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years\">\n";
                for ($i = 0; $i < 3; $i++) {
                    $html .= "        <th class=\"py-2 px-3 font-bold border border-slate-700 text-center align-middle text-xs\"><div>{$y1}</div></th>\n";
                    $html .= "        <th class=\"py-2 px-3 font-bold border border-slate-700 text-center align-middle text-xs\"><div>{$y2}</div></th>\n";
                    $html .= "        <th class=\"py-2 px-3 font-bold border border-slate-700 text-center align-middle text-xs\"><div>{$y3}</div></th>\n";
                }
                $html .= "    </tr>\n";

                // Subheader Penomoran Kolom (1) s.d. (10)
                $html .= "    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering\">\n";
                for ($i = 1; $i <= 10; $i++) {
                    $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">({$i})</th>\n";
                }
                $html .= "    </tr>\n";
            }

            // 4 Baris Data Kecamatan & Bukittinggi
            for ($r = 0; $r < 4; $r++) {
                $rowIdx = $startIndex + $r;
                $row = $finalDataRows[$rowIdx];
                $isTotal = ($r === 3);

                $trClass = $isTotal 
                    ? 'bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700 hover:bg-amber-200/60 transition-colors' 
                    : 'hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium';
                $tdLabelClass = $isTotal 
                    ? 'py-2.5 px-4 border border-slate-700 text-left font-bold align-middle' 
                    : 'py-2 px-4 border border-slate-700 text-left font-semibold align-middle';
                $tdValClass = $isTotal 
                    ? 'py-2.5 px-3 border border-slate-700 text-center font-bold align-middle' 
                    : 'py-2 px-3 border border-slate-700 text-center align-middle';

                $html .= "    <tr class=\"{$trClass}\">\n";
                $html .= "        <td class=\"{$tdLabelClass}\">{$row['label']}</td>\n";
                for ($c = 0; $c < 9; $c++) {
                    $v = $row['values'][$c] ?? '-';
                    $html .= "        <td class=\"{$tdValClass}\">" . $formatVal($v) . "</td>\n";
                }
                $html .= "    </tr>\n";
            }
        };

        $renderDataSection(0, 'Sekolah', 'Schools');
        $renderDataSection(4, 'Guru', 'Teachers');
        $renderDataSection(8, 'Murid', 'Students');

        $html .= '</tbody>';
        return $html;
    }
}
