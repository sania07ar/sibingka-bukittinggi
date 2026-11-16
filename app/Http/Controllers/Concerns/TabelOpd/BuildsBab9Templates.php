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
 * Template HTML tabel kode 91, 92, 93, dan 94.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait BuildsBab9Templates
{
    /**
     * Membangun HTML bersih dan akurat untuk Tabel 9.1 (Disnaker - Jumlah Koperasi Aktif Menurut Kecamatan)
     * Menggunakan rentang 5 tahun dinamis: [year-4, year-3, year-2, year-1, year]
     */
    private function buildTabel91Html(int $year, ?string $existingHtml = null): string
    {
        $years = [$year - 4, $year - 3, $year - 2, $year - 1, $year];
        $dash = '<span class="text-slate-400 font-normal">-</span>';

        $kecList = [
            'guguk_panjang' => '01. Guguk Panjang',
            'mandiangin_koto_selayan' => '02. Mandiangin Koto Selayan',
            'aur_birugo_tigo_baleh' => '03. Aur Birugo Tigo Baleh',
        ];

        // Ekstraksi data lama jika ada
        $extracted = [];
        if ($existingHtml) {
            preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $existingHtml, $trMatches);
            $existingYears = [];
            foreach ($trMatches[1] as $tr) {
                if (str_contains($tr, '<th')) {
                    preg_match_all('/<th[^>]*>.*?(\b(?:19|20)\d{2}\b).*?<\/th>/is', $tr, $thYears);
                    if (!empty($thYears[1])) {
                        foreach ($thYears[1] as $yVal) {
                            $existingYears[] = (int)$yVal;
                        }
                    }
                } elseif (str_contains($tr, '<td')) {
                    preg_match_all('/<td[^>]*>(.*?)<\/td>/is', $tr, $tdMatches);
                    $tds = $tdMatches[1];
                    if (count($tds) >= 2) {
                        $label = strip_tags($tds[0]);
                        $matchedKey = null;
                        if (stripos($label, 'guguk') !== false) $matchedKey = 'guguk_panjang';
                        elseif (stripos($label, 'mandiangin') !== false) $matchedKey = 'mandiangin_koto_selayan';
                        elseif (stripos($label, 'aur') !== false || stripos($label, 'birugo') !== false) $matchedKey = 'aur_birugo_tigo_baleh';
                        elseif (stripos($label, 'jumlah') !== false || stripos($label, 'total') !== false || stripos($label, 'bukittinggi') !== false) $matchedKey = 'total';

                        if ($matchedKey) {
                            for ($c = 1; $c < count($tds); $c++) {
                                $y = $existingYears[$c - 1] ?? null;
                                if ($y) {
                                    $val = trim(strip_tags($tds[$c]));
                                    if ($val !== '' && $val !== '-') {
                                        $extracted[$y][$matchedKey] = $val;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Ambil data dari TabelData jika ada
        $dbRecords = TabelData::where('table_code', '9.1')
            ->whereIn('year', $years)
            ->get();
        foreach ($dbRecords as $rec) {
            if ($rec->value !== null && $rec->value !== '' && $rec->value !== '-') {
                $extracted[(int)$rec->year][$rec->row_key] = $rec->value;
            }
        }

        $thYearCols = '';
        $thIndexCols = '';
        foreach ($years as $idx => $y) {
            $isCur = ($y === $year);
            $curCls = $isCur ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : '';
            $thYearCols .= "<th class=\"py-3 px-4 border border-slate-700 text-center {$curCls}\"><div>{$y}</div></th>";
            $thIndexCols .= "<th class=\"py-1 px-3 border border-slate-700 text-center\">(" . ($idx + 2) . ")</th>";
        }

        $tbodyHtml = '';
        foreach ($kecList as $kKey => $kLabel) {
            $tbodyHtml .= "<tr class=\"hover:bg-amber-100/60 transition-colors\">";
            $tbodyHtml .= "<td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\">{$kLabel}</td>";
            foreach ($years as $y) {
                $val = $extracted[$y][$kKey] ?? $dash;
                $isCur = ($y === $year);
                $curCls = $isCur ? 'font-bold bg-amber-100/60' : '';
                $tbodyHtml .= "<td class=\"py-2.5 px-3 text-center border border-slate-700 {$curCls}\">{$val}</td>";
            }
            $tbodyHtml .= "</tr>";
        }

        // Baris Jumlah / Total
        $tbodyHtml .= "<tr class=\"bg-[#fed7aa] font-bold\">";
        $tbodyHtml .= "<td class=\"py-2.5 px-4 font-extrabold border border-slate-700 text-left\">Jumlah / <span class=\"italic font-bold\">Total</span></td>";
        foreach ($years as $y) {
            $val = $extracted[$y]['total'] ?? $dash;
            $isCur = ($y === $year);
            $curCls = $isCur ? 'bg-amber-200/80 ring-1 ring-amber-400' : '';
            $tbodyHtml .= "<td class=\"py-2.5 px-3 text-center font-extrabold border border-slate-700 {$curCls}\">{$val}</td>";
        }
        $tbodyHtml .= "</tr>";

        return "<thead><tr class=\"bg-[#f95a00] text-white text-center font-bold\">
            <th class=\"py-3 px-4 font-bold border border-slate-700 text-left align-middle\">
                <div>Kecamatan</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Subdistrict</div>
            </th>
            {$thYearCols}
        </tr>
        <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
            <th class=\"py-1 px-3 border border-slate-700 text-center\">(1)</th>
            {$thIndexCols}
        </tr></thead>
        <tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">{$tbodyHtml}</tbody>";
    }

    private function buildTabel92Html(int $year, ?string $existingHtml = null): string
    {
        $officialData = [
            2023 => [
                'gp' => ['0', '13', '14', '25', '52'],
                'mks' => ['0', '4', '1', '10', '15'],
                'abtb' => ['1', '12', '3', '11', '27'],
                'total' => ['1', '29', '18', '46', '94']
            ],
            2024 => [
                'gp' => ['0', '13', '10', '34', '57'],
                'mks' => ['0', '4', '1', '20', '25'],
                'abtb' => ['1', '10', '6', '14', '31'],
                'total' => ['1', '27', '17', '68', '113']
            ],
            2025 => [
                'gp' => ['0', '29', '11', '22', '62'],
                'mks' => ['0', '4', '1', '25', '30'],
                'abtb' => ['1', '10', '6', '19', '36'],
                'total' => ['1', '43', '18', '66', '128']
            ]
        ];

        $dataForYear = $officialData[$year] ?? [];

        $dists = [
            ['key' => 'guguk_panjang', 'label' => 'Guguk Panjang', 'def' => 'gp'],
            ['key' => 'mandiangin_koto_selayan', 'label' => 'Mandiangin Koto Selayan', 'def' => 'mks'],
            ['key' => 'aur_birugo_tigo_baleh', 'label' => 'Aur Birugo Tigo Baleh', 'def' => 'abtb']
        ];

        $dbRecords = TabelData::where('table_code', '9.2')
            ->where('opd_code', '07')
            ->where('year', $year)
            ->pluck('value', 'row_key')
            ->toArray();

        $cols = ['kud', 'kpri', 'kopkar', 'lainnya', 'total'];
        $rowsHtml = '';
        foreach ($dists as $d) {
            $vals = [];
            foreach ($cols as $idx => $c) {
                $k = "{$d['key']}_{$c}";
                $vals[] = $dbRecords[$k] ?? ($dataForYear[$d['def']][$idx] ?? '-');
            }

            $rowsHtml .= "
            <tr class=\"hover:bg-amber-100/60 transition-colors\" data-key=\"{$d['key']}\">
                <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\">{$d['label']}</td>
                <td class=\"py-2.5 px-3 text-center border border-slate-700\">{$vals[0]}</td>
                <td class=\"py-2.5 px-3 text-center border border-slate-700\">{$vals[1]}</td>
                <td class=\"py-2.5 px-3 text-center border border-slate-700\">{$vals[2]}</td>
                <td class=\"py-2.5 px-3 text-center border border-slate-700\">{$vals[3]}</td>
                <td class=\"py-2.5 px-3 text-center border border-slate-700 font-semibold\">{$vals[4]}</td>
            </tr>";
        }

        $totVals = [];
        foreach ($cols as $idx => $c) {
            $k = "total_{$c}";
            $totVals[] = $dbRecords[$k] ?? ($dataForYear['total'][$idx] ?? '-');
        }

        return "<thead>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Kecamatan</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Subdistrict</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\"><div>KUD</div></th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\"><div>KPRI</div></th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\"><div>KOPKAR</div></th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Lainnya</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Other</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Jumlah</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Total</div>
                </th>
            </tr>
            <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
                <th class=\"py-1 px-3 border border-slate-700\">(1)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(2)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(3)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(4)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(5)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(6)</th>
            </tr>
        </thead>
        <tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
            {$rowsHtml}
            <tr class=\"bg-[#fed7aa] font-bold\" data-key=\"total\">
                <td class=\"py-2.5 px-4 border border-slate-700 text-left font-extrabold\">Jumlah / <span class=\"italic font-bold\">Total</span></td>
                <td class=\"py-2.5 px-3 border border-slate-700 text-center font-extrabold\">{$totVals[0]}</td>
                <td class=\"py-2.5 px-3 border border-slate-700 text-center font-extrabold\">{$totVals[1]}</td>
                <td class=\"py-2.5 px-3 border border-slate-700 text-center font-extrabold\">{$totVals[2]}</td>
                <td class=\"py-2.5 px-3 border border-slate-700 text-center font-extrabold\">{$totVals[3]}</td>
                <td class=\"py-2.5 px-3 border border-slate-700 text-center font-extrabold\">{$totVals[4]}</td>
            </tr>
        </tbody>";
    }

    private function buildTabel93Html(int $year, ?string $existingHtml = null): string
    {
        $startYear = $year - 6;
        $endYear = $year;
        $years = range($startYear, $endYear);

        // Data resmi historis BPS Kota Bukittinggi
        $officialData = [
            2017 => ['koperasi' => '92', 'anggota' => '15736', 'simpanan' => '177732269', 'volume_usaha' => '480543113', 'permodalan' => '272173141'],
            2018 => ['koperasi' => '92', 'anggota' => '15910', 'simpanan' => '212256371', 'volume_usaha' => '202499464', 'permodalan' => '310499179'],
            2019 => ['koperasi' => '93', 'anggota' => '15111', 'simpanan' => '183270080', 'volume_usaha' => '195793390', 'permodalan' => '291298760'],
            2020 => ['koperasi' => '94', 'anggota' => '14561', 'simpanan' => '210868800', 'volume_usaha' => '179916467', 'permodalan' => '300268854'],
            2021 => ['koperasi' => '95', 'anggota' => '14403', 'simpanan' => '202041670', 'volume_usaha' => '175575520', 'permodalan' => '304235940'],
            2022 => ['koperasi' => '94', 'anggota' => '14241', 'simpanan' => '183893370', 'volume_usaha' => '147951760', 'permodalan' => '276352910'],
            2023 => ['koperasi' => '94', 'anggota' => '14204', 'simpanan' => '116872110', 'volume_usaha' => '139303060', 'permodalan' => '221056024'],
            2024 => ['koperasi' => '113', 'anggota' => '13939', 'simpanan' => '133938170', 'volume_usaha' => '104568190', 'permodalan' => '183952529'],
            2025 => ['koperasi' => '128', 'anggota' => '14081', 'simpanan' => '137045463', 'volume_usaha' => '82924543', 'permodalan' => '185537956'],
        ];

        $extracted = [];
        foreach ($years as $y) {
            $extracted[$y] = $officialData[$y] ?? [
                'koperasi' => '-',
                'anggota' => '-',
                'simpanan' => '-',
                'volume_usaha' => '-',
                'permodalan' => '-',
            ];
        }

        // Ekstrak dari $existingHtml jika ada
        if (!empty($existingHtml)) {
            preg_match_all('/<tr[^>]*>(.*?)<\/tr>/s', $existingHtml, $trMatches);
            foreach ($trMatches[1] as $tr) {
                preg_match_all('/<td[^>]*>(.*?)<\/td>/s', $tr, $tdMatches);
                $cells = array_map(function($c) {
                    return trim(strip_tags($c));
                }, $tdMatches[1] ?? []);

                if (count($cells) >= 6) {
                    $rowYr = (int)$cells[0];
                    if (in_array($rowYr, $years)) {
                        if ($cells[1] !== '' && $cells[1] !== '-') $extracted[$rowYr]['koperasi'] = $cells[1];
                        if ($cells[2] !== '' && $cells[2] !== '-') $extracted[$rowYr]['anggota'] = $cells[2];
                        if ($cells[3] !== '' && $cells[3] !== '-') $extracted[$rowYr]['simpanan'] = $cells[3];
                        if ($cells[4] !== '' && $cells[4] !== '-') $extracted[$rowYr]['volume_usaha'] = $cells[4];
                        if ($cells[5] !== '' && $cells[5] !== '-') $extracted[$rowYr]['permodalan'] = $cells[5];
                    }
                }
            }
        }

        // Ambil data dari TabelData jika ada
        $dbRecords = TabelData::where('table_code', '9.3')
            ->whereIn('year', $years)
            ->get();
        foreach ($dbRecords as $rec) {
            if ($rec->value !== null && $rec->value !== '' && $rec->value !== '-') {
                $extracted[(int)$rec->year][$rec->row_key] = $rec->value;
            }
        }

        $tbodyHtml = '';
        foreach ($years as $y) {
            $isCur = ($y === $year);
            $curCls = $isCur ? 'font-bold bg-amber-100/60' : '';
            $rowCls = 'hover:bg-amber-100/60 transition-colors';

            $kop = $extracted[$y]['koperasi'] ?? '-';
            $ang = $extracted[$y]['anggota'] ?? '-';
            $sim = $extracted[$y]['simpanan'] ?? '-';
            $vol = $extracted[$y]['volume_usaha'] ?? '-';
            $per = $extracted[$y]['permodalan'] ?? '-';

            $tbodyHtml .= "<tr class=\"{$rowCls}\">
                <td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-top {$curCls}\">{$y}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$curCls}\">{$kop}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$curCls}\">{$ang}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$curCls}\">{$sim}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$curCls}\">{$vol}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$curCls}\">{$per}</td>
            </tr>";
        }

        return "<thead>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Tahun</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Year</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Jumlah Koperasi</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Number of Cooperative (Buah/Unit)</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Anggota</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Member (Orang/ Person)</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Simpanan</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Deposits (000)</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Volume Usaha</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Omsets (000)</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Permodalan</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Assets (000)</div>
                </th>
            </tr>
            <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
                <th class=\"py-1 px-3 border border-slate-700\">(1)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(2)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(3)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(4)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(5)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(6)</th>
            </tr>
        </thead>
        <tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
            {$tbodyHtml}
        </tbody>";
    }

    /**
     * Buat HTML Tabel 9.4 (Jumlah Koperasi Menurut Jenisnya per Kecamatan di Kota Bukittinggi)
     */
    private function buildTabel94Html(int $year, ?string $existingHtml = null): string
    {
        $categories = [
            // Koperasi Primer section
            ['is_header' => true, 'label' => 'Koperasi Primer', 'key' => 'primer_header'],
            ['key' => 'kop_pertanian', 'label' => '1. Kop. Pertanian', 'sub' => false],
            ['key' => 'kop_peternakan', 'label' => '2. Kop. Peternakan', 'sub' => false],
            ['key' => 'kop_serba_usaha', 'label' => '3. Kop. Serba Usaha', 'sub' => false],
            ['key' => 'kop_kerajinan', 'label' => '4. Kop. Kerajinan', 'sub' => false],
            ['key' => 'kop_simpan_pinjam', 'label' => '5. Kop. Simpan Pinjam', 'sub' => false],
            ['key' => 'kop_jasa_angkutan', 'label' => '6. Kop. Jasa / <span class="italic font-normal text-slate-700">Angkutan</span>', 'raw_label' => '6. Kop. Jasa / Angkutan', 'sub' => false],
            ['is_header' => true, 'label' => '7. Kop Menurut Golongan', 'key' => 'golongan_header'],
            ['key' => 'gol_pegawai_negeri', 'label' => '- Pegawai Negeri', 'sub' => true],
            ['key' => 'gol_angkatan_darat', 'label' => '- Angkatan Darat', 'sub' => true],
            ['key' => 'gol_polri', 'label' => '- Polri', 'sub' => true],
            ['key' => 'gol_karyawan_perum', 'label' => '- Karyawan / <span class="italic font-normal text-slate-700">Perum</span>', 'raw_label' => '- Karyawan / Perum', 'sub' => true],
            ['key' => 'gol_guru_swasta', 'label' => '- Guru Swasta', 'sub' => true],
            ['key' => 'gol_veteran', 'label' => '- Veteran', 'sub' => true],
            ['key' => 'gol_pensiun_abri', 'label' => '- Pensiun ABRI', 'sub' => true],
            ['key' => 'gol_pensiun_pn', 'label' => '- Pensiun PN', 'sub' => true],
            ['key' => 'gol_karyawan_bank', 'label' => '- Karyawan Bank', 'sub' => true],
            ['key' => 'gol_organisasi_wanita', 'label' => '- Organisasi Wanita', 'sub' => true],
            ['key' => 'kop_mahasiswa', 'label' => '8. Kop. Mahasiswa', 'sub' => false],
            ['key' => 'kop_sekolah', 'label' => '9. Kop. Sekolah', 'sub' => false],
            ['key' => 'koppas', 'label' => '10. Koppas', 'sub' => false],
            ['key' => 'kop_lainnya', 'label' => '11. Koperasi lainnya', 'sub' => false],
            // Koperasi Sekunder section
            ['is_header' => true, 'label' => 'Koperasi Sekunder', 'key' => 'sekunder_header'],
            ['key' => 'sek_pkppn', 'label' => '1. PKPPN', 'sub' => false],
            ['key' => 'sek_pusat_wanita', 'label' => '2. Pusat Koperasi Wanita', 'sub' => false],
        ];

        $officialDataByYear = [
            2025 => [
                'kop_pertanian' => ['0', '0', '1', '1'],
                'kop_peternakan' => ['0', '0', '0', '0'],
                'kop_serba_usaha' => ['12', '3', '3', '18'],
                'kop_kerajinan' => ['0', '0', '0', '0'],
                'kop_simpan_pinjam' => ['4', '4', '1', '9'],
                'kop_jasa_angkutan' => ['1', '0', '0', '1'],
                'gol_pegawai_negeri' => ['13', '4', '10', '27'],
                'gol_angkatan_darat' => ['0', '0', '2', '2'],
                'gol_polri' => ['0', '0', '1', '1'],
                'gol_karyawan_perum' => ['11', '1', '6', '18'],
                'gol_guru_swasta' => ['0', '0', '0', '0'],
                'gol_veteran' => ['1', '0', '0', '1'],
                'gol_pensiun_abri' => ['1', '0', '0', '1'],
                'gol_pensiun_pn' => ['0', '0', '0', '0'],
                'gol_karyawan_bank' => ['0', '0', '0', '0'],
                'gol_organisasi_wanita' => ['2', '1', '1', '4'],
                'kop_mahasiswa' => ['0', '0', '0', '0'],
                'kop_sekolah' => ['0', '0', '0', '0'],
                'koppas' => ['2', '1', '0', '3'],
                'kop_lainnya' => ['15', '16', '11', '42'],
                'sek_pkppn' => ['0', '0', '0', '0'],
                'sek_pusat_wanita' => ['0', '0', '0', '0'],
            ],
            2024 => [
                'kop_pertanian' => ['0', '0', '1', '1'],
                'kop_peternakan' => ['0', '0', '0', '0'],
                'kop_serba_usaha' => ['12', '3', '3', '18'],
                'kop_kerajinan' => ['1', '0', '0', '1'],
                'kop_simpan_pinjam' => ['12', '3', '3', '18'],
                'kop_jasa_angkutan' => ['1', '0', '0', '1'],
                'gol_pegawai_negeri' => ['12', '4', '10', '26'],
                'gol_angkatan_darat' => ['0', '0', '2', '2'],
                'gol_polri' => ['0', '0', '1', '1'],
                'gol_karyawan_perum' => ['11', '1', '6', '18'],
                'gol_guru_swasta' => ['0', '0', '0', '0'],
                'gol_veteran' => ['1', '0', '0', '1'],
                'gol_pensiun_abri' => ['1', '0', '0', '1'],
                'gol_pensiun_pn' => ['0', '0', '0', '0'],
                'gol_karyawan_bank' => ['0', '0', '0', '0'],
                'gol_organisasi_wanita' => ['0', '0', '0', '0'],
                'kop_mahasiswa' => ['0', '0', '0', '0'],
                'kop_sekolah' => ['0', '0', '0', '0'],
                'koppas' => ['2', '1', '-', '3'],
                'kop_lainnya' => ['4', '13', '5', '22'],
                'sek_pkppn' => ['-', '-', '-', '0'],
                'sek_pusat_wanita' => ['-', '-', '-', '0'],
            ],
            2023 => [
                'kop_pertanian' => ['-', '-', '1', '1'],
                'kop_peternakan' => ['-', '-', '-', '-'],
                'kop_serba_usaha' => ['13', '3', '4', '20'],
                'kop_kerajinan' => ['1', '-', '-', '1'],
                'kop_simpan_pinjam' => ['3', '2', '-', '5'],
                'kop_jasa_angkutan' => ['-', '-', '-', '-'],
                'gol_pegawai_negeri' => ['13', '4', '12', '29'],
                'gol_angkatan_darat' => ['1', '-', '-', '1'],
                'gol_polri' => ['-', '-', '1', '1'],
                'gol_karyawan_perum' => ['14', '1', '3', '18'],
                'gol_guru_swasta' => ['-', '-', '-', '-'],
                'gol_veteran' => ['-', '-', '-', '-'],
                'gol_pensiun_abri' => ['-', '1', '-', '1'],
                'gol_pensiun_pn' => ['-', '-', '-', '-'],
                'gol_karyawan_bank' => ['-', '-', '-', '-'],
                'gol_organisasi_wanita' => ['2', '-', '1', '3'],
                'kop_mahasiswa' => ['-', '-', '-', '-'],
                'kop_sekolah' => ['-', '-', '-', '-'],
                'koppas' => ['-', '-', '-', '-'],
                'kop_lainnya' => ['5', '4', '5', '14'],
                'sek_pkppn' => ['-', '-', '-', '-'],
                'sek_pusat_wanita' => ['-', '-', '-', '-'],
            ]
        ];

        $dataForYear = $officialDataByYear[$year] ?? [];

        // Ekstrak data dari existingHtml jika ada
        if (!empty($existingHtml)) {
            preg_match_all('/<tr[^>]*>(.*?)<\/tr>/s', $existingHtml, $trMatches);
            foreach ($trMatches[1] as $tr) {
                if (stripos($tr, '<th') !== false) continue;
                preg_match_all('/<td[^>]*>(.*?)<\/td>/s', $tr, $tdMatches);
                $cells = array_map(function($c) { return trim(strip_tags($c)); }, $tdMatches[1] ?? []);
                if (empty($cells)) continue;
                $label = strtolower($cells[0] ?? '');
                foreach ($categories as $cat) {
                    if (!empty($cat['is_header'])) continue;
                    $catClean = strtolower(preg_replace('/[^a-z0-9]/', '', $cat['label']));
                    $labelClean = preg_replace('/[^a-z0-9]/', '', $label);
                    if ($catClean && (str_contains($labelClean, $catClean) || str_contains($catClean, $labelClean))) {
                        $vals = array_slice($cells, 1);
                        if (count($vals) >= 4) {
                            $dataForYear[$cat['key']] = [
                                $vals[0] !== '' ? $vals[0] : '-',
                                $vals[1] !== '' ? $vals[1] : '-',
                                $vals[2] !== '' ? $vals[2] : '-',
                                $vals[3] !== '' ? $vals[3] : '-',
                            ];
                        }
                        break;
                    }
                }
            }
        }

        // Susun baris kategori
        $tbodyHtml = '';
        foreach ($categories as $cat) {
            if (!empty($cat['is_header'])) {
                $tbodyHtml .= "<tr class=\"hover:bg-amber-100/60 transition-colors\" data-key=\"{$cat['key']}\">
                    <td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-top\" colspan=\"2\">
                        {$cat['label']}
                    </td>
                    <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top\"><span class=\"text-slate-400 font-normal\">-</span></td>
                    <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top\"><span class=\"text-slate-400 font-normal\">-</span></td>
                    <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top\"><span class=\"text-slate-400 font-normal\">-</span></td>
                    <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top\"><span class=\"text-slate-400 font-normal\">-</span></td>
                </tr>";
            } else {
                $vals = $dataForYear[$cat['key']] ?? ['-', '-', '-', '-'];
                $gp = $vals[0] ?? '-';
                $mks = $vals[1] ?? '-';
                $abtb = $vals[2] ?? '-';
                $tot = $vals[3] ?? '-';
                $subCls = !empty($cat['sub']) ? 'pl-8' : '';

                $tbodyHtml .= "<tr class=\"hover:bg-amber-100/60 transition-colors\" data-key=\"{$cat['key']}\">
                    <td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-top {$subCls}\" colspan=\"2\">
                        {$cat['label']}
                    </td>
                    <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top\">{$gp}</td>
                    <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top\">{$mks}</td>
                    <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top\">{$abtb}</td>
                    <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top font-semibold\">{$tot}</td>
                </tr>";
            }
        }

        // Susun baris Jumlah / Total historis (6 tahun terakhir)
        $officialTotals = [
            2025 => ['gp' => '62', 'mks' => '30', 'abtb' => '36', 'total' => '128'],
            2024 => ['gp' => '57', 'mks' => '25', 'abtb' => '31', 'total' => '113'],
            2023 => ['gp' => '52', 'mks' => '15', 'abtb' => '27', 'total' => '94'],
            2022 => ['gp' => '53', 'mks' => '17', 'abtb' => '24', 'total' => '94'],
            2021 => ['gp' => '54', 'mks' => '17', 'abtb' => '24', 'total' => '95'],
            2020 => ['gp' => '54', 'mks' => '17', 'abtb' => '23', 'total' => '94'],
            2019 => ['gp' => '54', 'mks' => '17', 'abtb' => '23', 'total' => '94'],
            2018 => ['gp' => '54', 'mks' => '16', 'abtb' => '23', 'total' => '93'],
        ];

        $histYears = [$year, $year - 1, $year - 2, $year - 3, $year - 4, $year - 5];
        $totalRowsCount = count($histYears);

        foreach ($histYears as $idx => $hy) {
            $t = $officialTotals[$hy] ?? ['gp' => '-', 'mks' => '-', 'abtb' => '-', 'total' => '-'];
            $isCur = ($hy === $year);
            $trCls = $isCur ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
            $boldCls = $isCur ? 'font-extrabold' : '';

            $tbodyHtml .= "<tr class=\"{$trCls}\">";
            if ($idx === 0) {
                $tbodyHtml .= "<td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-top\" rowspan=\"{$totalRowsCount}\">
                    Jumlah / <span class=\"italic font-bold\">Total</span>
                </td>";
            }
            $tbodyHtml .= "<td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$boldCls}\">{$hy}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$boldCls}\">{$t['gp']}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$boldCls}\">{$t['mks']}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$boldCls}\">{$t['abtb']}</td>
                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top {$boldCls}\">{$t['total']}</td>
            </tr>";
        }

        return "<thead>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                <th class=\"py-3 px-4 font-bold border border-slate-700\" rowspan=\"2\" colspan=\"2\">
                    <div>Jenis Koperasi</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Kind of Cooperative</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\" colspan=\"3\">
                    <div>Kecamatan</div><div class=\"italic font-normal text-[11px] sm:text-xs\">District</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\" rowspan=\"2\">
                    <div>Jumlah</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Total</div>
                </th>
            </tr>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Guguk Panjang</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Mandiangin Koto Selayan</div>
                </th>
                <th class=\"py-3 px-4 font-bold border border-slate-700\">
                    <div>Aur Birugo Tigo Baleh</div>
                </th>
            </tr>
            <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
                <th class=\"py-1 px-3 border border-slate-700\" colspan=\"2\">(1)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(2)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(3)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(4)</th>
                <th class=\"py-1 px-3 border border-slate-700\">(5)</th>
            </tr>
        </thead>
        <tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
            {$tbodyHtml}
        </tbody>";
    }
}
