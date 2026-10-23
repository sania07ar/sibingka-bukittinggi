<?php

namespace Database\Seeders;

use App\Models\TabelData;
use App\Models\TabelMetadata;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TabelOpdSeeder extends Seeder
{
    /**
     * Seed all numbers for Table 8.1.1 and Table 1.1.6 into the database.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $tableCode = '8.1.1';
        $opdCode = '01';

        $rowsConfig = [
            ['key' => 'negara', 'label' => '1. Negara / State', 'order' => 1],
            ['key' => 'provinsi', 'label' => '2. Provinsi / Province', 'order' => 2],
            ['key' => 'kota', 'label' => '3. Kota / Municipality', 'order' => 3],
            ['key' => 'total', 'label' => 'Jumlah / Total', 'order' => 4],
        ];

        // Seluruh data riil angka-angka untuk Tabel 8.1.1:
        // Dari berkas template Excel & publikasi resmi BPS Kota Bukittinggi:
        // 2019-2020: Belum ada pendataan (-)
        // 2021-2022: 11,75 | - | 180,17 | 191,92
        // 2023-2025: 8,18  | - | 198,3  | 206,48 (Berdasarkan SK Menteri PUPR No. 1688/KPTS/M/2022)
        $allHistoricalData = [
            2019 => ['negara' => '-',     'provinsi' => '-', 'kota' => '-',      'total' => '-',      'note' => 'Belum ada data pendataan (Tahun 2019 belum ada)'],
            2020 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92', 'note' => 'Data resmi BPS Kota Bukittinggi'],
            2021 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92', 'note' => 'Data resmi BPS Kota Bukittinggi'],
            2022 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92', 'note' => 'Data resmi BPS Kota Bukittinggi'],
            2023 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48', 'note' => 'Berdasarkan Keputusan Menteri PUPR No. 1688/KPTS/M/2022'],
            2024 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48', 'note' => 'Hasil data penetapan tahun sebelumnya (SK Kemen PUPR No. 1688/KPTS/M/2022)'],
            2025 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48', 'note' => 'Hasil data penetapan tahun sebelumnya (SK Kemen PUPR No. 1688/KPTS/M/2022)'],
            2026 => ['negara' => '-',     'provinsi' => '-', 'kota' => '-',      'total' => '-',      'note' => 'Belum ada data pendataan (Tahun 2026 belum ada)'],
        ];

        foreach ($allHistoricalData as $year => $vals) {
            foreach ($rowsConfig as $rc) {
                TabelData::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                        'row_key' => $rc['key'],
                    ],
                    [
                        'row_label' => $rc['label'],
                        'value' => $vals[$rc['key']] ?? '-',
                        'satuan' => 'km',
                        'order_index' => $rc['order'],
                        'keterangan' => $vals['note'] ?? null,
                    ]
                );
            }
        }

        $defaultSource = 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>';
        $defaultNote = '<div class="space-y-1"><div>1. Data tidak termasuk panjang jalan tol / <span class="italic text-slate-500">Excluding toll road</span></div><div>2. Data tahun 2023 berdasarkan Keputusan Menteri Pekerjaan Umum dan Perumahan Rakyat No. 1688/KPTS/M/2022 / <span class="italic text-slate-500">Data of 2023 based on Public Works and Public Housing Ministerial Decree No. 1688/KPTS/M/2022</span></div></div>';

        // Metadata Tabel 8.1.1 untuk Setiap Tahun Publikasi (rentang 5 tahun [yr-4, yr])
        foreach (array_keys($allHistoricalData) as $yr811) {
            $rangeText = ($yr811 - 4) . '–' . $yr811;
            TabelMetadata::updateOrCreate(
                ['table_code' => $tableCode, 'opd_code' => $opdCode, 'year' => $yr811],
                [
                    'title_id' => "Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi, {$rangeText}",
                    'title_en' => "Length of Road by Level of Government Authority in Bukittinggi Municipality (Km), {$rangeText}",
                    'source' => $defaultSource,
                    'note' => $defaultNote,
                    'source_type' => 'database',
                    'is_saved' => true,
                ]
            );
        }

        // Metadata & Data Riil Tabel 1.1.6 untuk Tahun 2023 & 2024 (dari inputan & berkas Excel pengguna)
        $tabel116Years = [2023, 2024, 2025];
        $tabel116Data = [
            ['key' => 'batang_tambuo', 'label' => '01. Batang Tambuo', 'val' => '5–7', 'order' => 1],
            ['key' => 'batang_sianok', 'label' => '02. Batang Sianok', 'val' => '12–15', 'order' => 2],
        ];

        foreach ($tabel116Years as $yr) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '1.1.6', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => "Nama Sungai/Batang, Lebar dan Kecamatan yang Dilalui di Kota Bukittinggi, {$yr}",
                    'title_en' => "Name, Width of The River and District Its Pass in Bukittinggi, {$yr}",
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'excel',
                    'is_saved' => true,
                ]
            );

            foreach ($tabel116Data as $row) {
                TabelData::updateOrCreate(
                    [
                        'table_code' => '1.1.6',
                        'opd_code' => '01',
                        'year' => $yr,
                        'row_key' => $row['key'],
                    ],
                    [
                        'row_label' => $row['label'],
                        'value' => $row['val'],
                        'satuan' => 'm',
                        'order_index' => $row['order'],
                    ]
                );
            }
        }

        // Metadata & Data Tabel 8.1.2 (Panjang Jalan Menurut Jenis Permukaan Jalan)
        $tabel812YearlyData = [
            2020 => ['aspal' => '180,17', 'kerikil' => '-', 'tanah' => '-',    'lainnya' => '-', 'total' => '180,17'],
            2021 => ['aspal' => '180,17', 'kerikil' => '-', 'tanah' => '-',    'lainnya' => '-', 'total' => '180,17'],
            2022 => ['aspal' => '180,17', 'kerikil' => '-', 'tanah' => '-',    'lainnya' => '-', 'total' => '180,17'],
            2023 => ['aspal' => '192,18', 'kerikil' => '-', 'tanah' => '6,12', 'lainnya' => '-', 'total' => '198,3'],
            2024 => ['aspal' => '192,18', 'kerikil' => '-', 'tanah' => '6,12', 'lainnya' => '-', 'total' => '198,3'],
            2025 => ['aspal' => '192,18', 'kerikil' => '-', 'tanah' => '6,12', 'lainnya' => '-', 'total' => '198,3'],
            2026 => ['aspal' => '-',     'kerikil' => '-', 'tanah' => '-',    'lainnya' => '-', 'total' => '-'],
        ];

        $tabel812RowDefs = [
            'aspal'   => ['label' => '1. Aspal / Paved',   'order' => 1],
            'kerikil' => ['label' => '2. Kerikil / Gravel', 'order' => 2],
            'tanah'   => ['label' => '3. Tanah / Soil',     'order' => 3],
            'lainnya' => ['label' => '4. Lainnya / Others', 'order' => 4],
            'total'   => ['label' => 'Jumlah / Total',      'order' => 5],
        ];

        foreach ($tabel812YearlyData as $yr => $data) {
            $rangeText = ($yr - 4) . '–' . $yr;
            $title812Id = "Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi (km), {$rangeText}";
            $title812En = "Length of Roads by Type of Road Surface in Bukittinggi Municipality (km), {$rangeText}";
            TabelMetadata::updateOrCreate(
                ['table_code' => '8.1.2', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => $title812Id,
                    'title_en' => $title812En,
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'database',
                    'is_saved' => true,
                    'table_html' => null,
                ]
            );

            foreach ($data as $key => $val) {
                TabelData::updateOrCreate(
                    [
                        'table_code' => '8.1.2',
                        'opd_code' => '01',
                        'year' => $yr,
                        'row_key' => $key,
                    ],
                    [
                        'row_label' => $tabel812RowDefs[$key]['label'],
                        'value' => $val,
                        'satuan' => 'km',
                        'order_index' => $tabel812RowDefs[$key]['order'],
                        'keterangan' => 'Data riil Dinas PUPR Kota Bukittinggi (Excel)',
                    ]
                );
            }
        }

        $tabel812OldYears = [2015, 2016, 2017, 2018, 2019];
        foreach ($tabel812OldYears as $yr) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '8.1.2', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => 'Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi (km)',
                    'title_en' => 'Length of Roads by Type of Road Surface in Bukittinggi Municipality (km)',
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'database',
                    'is_saved' => true,
                    'table_html' => null,
                ]
            );

            foreach ($tabel812RowDefs as $key => $r) {
                TabelData::updateOrCreate(
                    [
                        'table_code' => '8.1.2',
                        'opd_code' => '01',
                        'year' => $yr,
                        'row_key' => $key,
                    ],
                    [
                        'row_label' => $r['label'],
                        'value' => '-',
                        'satuan' => 'km',
                        'order_index' => $r['order'],
                        'keterangan' => 'Belum ada data',
                    ]
                );
            }
        }

        // Metadata & Data Tabel 8.1.3 (Panjang Jalan Menurut Kondisi Jalan)
        $tabel813YearlyData = [
            2021 => ['baik' => '94,34',  'sedang' => '69,37', 'rusak' => '15,83', 'rusak_berat' => '0,63', 'total' => '180,17'],
            2022 => ['baik' => '98,56',  'sedang' => '66,66', 'rusak' => '14,52', 'rusak_berat' => '0,43', 'total' => '180,17'],
            2023 => ['baik' => '151,56', 'sedang' => '29,78', 'rusak' => '8,44',  'rusak_berat' => '8,52', 'total' => '198,3'],
            2024 => ['baik' => '134,92', 'sedang' => '47,02', 'rusak' => '11,01', 'rusak_berat' => '5,35', 'total' => '198,3'],
            2025 => ['baik' => '131,05', 'sedang' => '49,25', 'rusak' => '12,87', 'rusak_berat' => '5,13', 'total' => '198,3'],
            2026 => ['baik' => '-',      'sedang' => '-',     'rusak' => '-',     'rusak_berat' => '-',    'total' => '-'],
        ];

        $tabel813RowDefs = [
            'baik'        => ['label' => '1. Baik / Good',                       'order' => 1],
            'sedang'      => ['label' => '2. Sedang / Moderate',                 'order' => 2],
            'rusak'       => ['label' => '3. Rusak / Damage',                    'order' => 3],
            'rusak_berat' => ['label' => '4. Rusak Berat / Severely Damage',     'order' => 4],
            'total'       => ['label' => 'Jumlah / Total',                       'order' => 5],
        ];

        foreach ($tabel813YearlyData as $yr => $data) {
            $rangeText = ($yr - 4) . '–' . $yr;
            $titleId = "Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km), {$rangeText}";
            $titleEn = "Length of Road by Condition of Road in Bukittinggi Municipality (km), {$rangeText}";
            $tableHtml = $this->buildTable813Html($yr, $tabel813YearlyData);

            TabelMetadata::updateOrCreate(
                ['table_code' => '8.1.3', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'excel',
                    'is_saved' => true,
                    'table_html' => $tableHtml,
                ]
            );

            foreach ($data as $key => $val) {
                TabelData::updateOrCreate(
                    [
                        'table_code' => '8.1.3',
                        'opd_code' => '01',
                        'year' => $yr,
                        'row_key' => $key,
                    ],
                    [
                        'row_label' => $tabel813RowDefs[$key]['label'],
                        'value' => $val,
                        'satuan' => 'km',
                        'order_index' => $tabel813RowDefs[$key]['order'],
                        'keterangan' => 'Data riil Dinas PUPR Kota Bukittinggi (Excel 2021-2025)',
                    ]
                );
            }
        }

        $tabel813OldYears = [2015, 2016, 2017, 2018, 2019, 2020];
        foreach ($tabel813OldYears as $yr) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '8.1.3', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => 'Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km)',
                    'title_en' => 'Length of Road by Condition of Road in Bukittinggi Municipality (km)',
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'database',
                    'is_saved' => true,
                    'table_html' => null,
                ]
            );

            foreach ($tabel813RowDefs as $key => $def) {
                TabelData::updateOrCreate(
                    [
                        'table_code' => '8.1.3',
                        'opd_code' => '01',
                        'year' => $yr,
                        'row_key' => $key,
                    ],
                    [
                        'row_label' => $def['label'],
                        'value' => '-',
                        'satuan' => 'km',
                        'order_index' => $def['order'],
                        'keterangan' => 'Belum ada data',
                    ]
                );
            }
        }

        // ==========================================
        // TABEL 8.1.4: Banyak dan Panjang Jembatan, Panjang Trotoar
        // ==========================================
        $tabel814Years = [2021, 2022, 2023, 2024, 2025, 2026];
        $tabel814OldYears = [2015, 2016, 2017, 2018, 2019, 2020];

        $tabel814Data2025 = [
            'guguk_panjang_unit' => ['label' => '01. Guguk Panjang (Banyaknya)', 'val' => '11', 'satuan' => 'unit', 'order' => 1],
            'guguk_panjang_panjang' => ['label' => '01. Guguk Panjang (Panjang)', 'val' => '75,5', 'satuan' => 'm', 'order' => 2],
            'mandiangin_koto_selayan_unit' => ['label' => '02. Mandiangin Koto Selayan (Banyaknya)', 'val' => '17', 'satuan' => 'unit', 'order' => 3],
            'mandiangin_koto_selayan_panjang' => ['label' => '02. Mandiangin Koto Selayan (Panjang)', 'val' => '113', 'satuan' => 'm', 'order' => 4],
            'aur_birugo_tigo_baleh_unit' => ['label' => '03. Aur Birugo Tigo Baleh (Banyaknya)', 'val' => '10', 'satuan' => 'unit', 'order' => 5],
            'aur_birugo_tigo_baleh_panjang' => ['label' => '03. Aur Birugo Tigo Baleh (Panjang)', 'val' => '108,4', 'satuan' => 'm', 'order' => 6],
            'total_unit' => ['label' => 'Jumlah / Total (Banyaknya)', 'val' => '38', 'satuan' => 'unit', 'order' => 7],
            'total_panjang' => ['label' => 'Jumlah / Total (Panjang)', 'val' => '296,9', 'satuan' => 'm', 'order' => 8],
        ];

        $tabel814Totals = [
            2019 => ['unit' => '32', 'len' => '239'],
            2020 => ['unit' => '32', 'len' => '239'],
            2021 => ['unit' => '34', 'len' => '242,12'],
            2022 => ['unit' => '34', 'len' => '242,12'],
            2023 => ['unit' => '37', 'len' => '258,9'],
            2024 => ['unit' => '37', 'len' => '258,9'],
            2025 => ['unit' => '38', 'len' => '296,9'],
            2026 => ['unit' => '-', 'len' => '-'],
        ];

        $tabel814KecPerYear = [
            2025 => [
                'guguk_panjang_unit'          => ['val' => '11',    'satuan' => 'unit', 'order' => 1, 'label' => '01. Guguk Panjang (Banyaknya)'],
                'guguk_panjang_panjang'       => ['val' => '75,5',  'satuan' => 'm',    'order' => 2, 'label' => '01. Guguk Panjang (Panjang)'],
                'mandiangin_koto_selayan_unit' => ['val' => '17',   'satuan' => 'unit', 'order' => 3, 'label' => '02. Mandiangin Koto Selayan (Banyaknya)'],
                'mandiangin_koto_selayan_panjang' => ['val' => '113', 'satuan' => 'm', 'order' => 4, 'label' => '02. Mandiangin Koto Selayan (Panjang)'],
                'aur_birugo_tigo_baleh_unit'  => ['val' => '10',    'satuan' => 'unit', 'order' => 5, 'label' => '03. Aur Birugo Tigo Baleh (Banyaknya)'],
                'aur_birugo_tigo_baleh_panjang' => ['val' => '108,4','satuan' => 'm',  'order' => 6, 'label' => '03. Aur Birugo Tigo Baleh (Panjang)'],
            ],
            2024 => [
                'guguk_panjang_unit'          => ['val' => '11',    'satuan' => 'unit', 'order' => 1, 'label' => '01. Guguk Panjang (Banyaknya)'],
                'guguk_panjang_panjang'       => ['val' => '75,5',  'satuan' => 'm',    'order' => 2, 'label' => '01. Guguk Panjang (Panjang)'],
                'mandiangin_koto_selayan_unit' => ['val' => '9',    'satuan' => 'unit', 'order' => 3, 'label' => '02. Mandiangin Koto Selayan (Banyaknya)'],
                'mandiangin_koto_selayan_panjang' => ['val' => '75', 'satuan' => 'm',  'order' => 4, 'label' => '02. Mandiangin Koto Selayan (Panjang)'],
                'aur_birugo_tigo_baleh_unit'  => ['val' => '17',   'satuan' => 'unit', 'order' => 5, 'label' => '03. Aur Birugo Tigo Baleh (Banyaknya)'],
                'aur_birugo_tigo_baleh_panjang' => ['val' => '108,4','satuan' => 'm',  'order' => 6, 'label' => '03. Aur Birugo Tigo Baleh (Panjang)'],
            ],
            2023 => [
                'guguk_panjang_unit'          => ['val' => '11',    'satuan' => 'unit', 'order' => 1, 'label' => '01. Guguk Panjang (Banyaknya)'],
                'guguk_panjang_panjang'       => ['val' => '75,5',  'satuan' => 'm',    'order' => 2, 'label' => '01. Guguk Panjang (Panjang)'],
                'mandiangin_koto_selayan_unit' => ['val' => '9',    'satuan' => 'unit', 'order' => 3, 'label' => '02. Mandiangin Koto Selayan (Banyaknya)'],
                'mandiangin_koto_selayan_panjang' => ['val' => '75', 'satuan' => 'm',  'order' => 4, 'label' => '02. Mandiangin Koto Selayan (Panjang)'],
                'aur_birugo_tigo_baleh_unit'  => ['val' => '17',   'satuan' => 'unit', 'order' => 5, 'label' => '03. Aur Birugo Tigo Baleh (Banyaknya)'],
                'aur_birugo_tigo_baleh_panjang' => ['val' => '108,4','satuan' => 'm',  'order' => 6, 'label' => '03. Aur Birugo Tigo Baleh (Panjang)'],
            ],
        ];

        foreach ($tabel814Years as $yr) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '8.1.4', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => 'Banyak dan Panjang Jembatan, Panjang Trotoar Kota Bukittinggi',
                    'title_en' => 'Number and Length of Bridge, Length of Sidewalk in Bukittinggi',
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'database',
                    'is_saved' => ($yr >= 2021 && $yr <= 2025),
                    'table_html' => null,
                ]
            );

            if (isset($tabel814KecPerYear[$yr])) {
                foreach ($tabel814KecPerYear[$yr] as $k => $info) {
                    TabelData::updateOrCreate(
                        ['table_code' => '8.1.4', 'opd_code' => '01', 'year' => $yr, 'row_key' => $k],
                        [
                            'row_label' => $info['label'],
                            'value' => $info['val'],
                            'satuan' => $info['satuan'],
                            'order_index' => $info['order'],
                            'keterangan' => 'Data riil Dinas PUPR Kota Bukittinggi (Excel)',
                        ]
                    );
                }
            } else {
                $emptyKec = [
                    'guguk_panjang_unit'          => ['val' => '-', 'satuan' => 'unit', 'order' => 1, 'label' => '01. Guguk Panjang (Banyaknya)'],
                    'guguk_panjang_panjang'       => ['val' => '-', 'satuan' => 'm',    'order' => 2, 'label' => '01. Guguk Panjang (Panjang)'],
                    'mandiangin_koto_selayan_unit' => ['val' => '-', 'satuan' => 'unit', 'order' => 3, 'label' => '02. Mandiangin Koto Selayan (Banyaknya)'],
                    'mandiangin_koto_selayan_panjang' => ['val' => '-', 'satuan' => 'm', 'order' => 4, 'label' => '02. Mandiangin Koto Selayan (Panjang)'],
                    'aur_birugo_tigo_baleh_unit'  => ['val' => '-', 'satuan' => 'unit', 'order' => 5, 'label' => '03. Aur Birugo Tigo Baleh (Banyaknya)'],
                    'aur_birugo_tigo_baleh_panjang' => ['val' => '-', 'satuan' => 'm',  'order' => 6, 'label' => '03. Aur Birugo Tigo Baleh (Panjang)'],
                ];
                foreach ($emptyKec as $k => $info) {
                    TabelData::updateOrCreate(
                        ['table_code' => '8.1.4', 'opd_code' => '01', 'year' => $yr, 'row_key' => $k],
                        [
                            'row_label' => $info['label'],
                            'value' => $info['val'],
                            'satuan' => $info['satuan'],
                            'order_index' => $info['order'],
                            'keterangan' => 'Belum ada data',
                        ]
                    );
                }
            }

            $tot = $tabel814Totals[$yr] ?? ['unit' => '-', 'len' => '-'];
            TabelData::updateOrCreate(
                ['table_code' => '8.1.4', 'opd_code' => '01', 'year' => $yr, 'row_key' => 'total_unit'],
                [
                    'row_label' => 'Jumlah / Total (Banyaknya)',
                    'value' => $tot['unit'],
                    'satuan' => 'unit',
                    'order_index' => 7,
                    'keterangan' => 'Data riil Dinas PUPR Kota Bukittinggi (Excel)',
                ]
            );
            TabelData::updateOrCreate(
                ['table_code' => '8.1.4', 'opd_code' => '01', 'year' => $yr, 'row_key' => 'total_panjang'],
                [
                    'row_label' => 'Jumlah / Total (Panjang)',
                    'value' => $tot['len'],
                    'satuan' => 'm',
                    'order_index' => 8,
                    'keterangan' => 'Data riil Dinas PUPR Kota Bukittinggi (Excel)',
                ]
            );
        }

        foreach ($tabel814OldYears as $yr) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '8.1.4', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => 'Banyak dan Panjang Jembatan, Panjang Trotoar Kota Bukittinggi',
                    'title_en' => 'Number and Length of Bridge, Length of Sidewalk in Bukittinggi',
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'database',
                    'is_saved' => true,
                    'table_html' => null,
                ]
            );

            TabelData::updateOrCreate(
                ['table_code' => '8.1.4', 'opd_code' => '01', 'year' => $yr, 'row_key' => 'total_unit'],
                [
                    'row_label' => 'Jumlah / Total (Banyaknya)',
                    'value' => '-',
                    'satuan' => 'unit',
                    'order_index' => 7,
                    'keterangan' => 'Belum ada data',
                ]
            );
            TabelData::updateOrCreate(
                ['table_code' => '8.1.4', 'opd_code' => '01', 'year' => $yr, 'row_key' => 'total_panjang'],
                [
                    'row_label' => 'Jumlah / Total (Panjang)',
                    'value' => '-',
                    'satuan' => 'm',
                    'order_index' => 8,
                    'keterangan' => 'Belum ada data',
                ]
            );
        }

        // ==========================================
        // TABEL 8.1.5: Panjang Gorong-Gorong dan Panjang Drainase
        // ==========================================
        // Hanya tahun 2024 dan 2025 yang telah dimasukkan oleh pengguna.
        // Tahun lain yang belum dimasukkan dikosongkan (angka drainase '-') dan is_saved = false.
        $tabel815DataPerYear = [
            2025 => ['guguk_panjang' => '39013,13', 'mandiangin_koto_selayan' => '65078,7', 'aur_birugo_tigo_baleh' => '39474,49', 'total' => '143566,32'],
            2024 => ['guguk_panjang' => '38856,93', 'mandiangin_koto_selayan' => '64961,5', 'aur_birugo_tigo_baleh' => '39066,19', 'total' => '142884,62'],
        ];

        $tabel815RowDefs = [
            'guguk_panjang'           => ['label' => '01. Guguk Panjang',           'order' => 1],
            'mandiangin_koto_selayan' => ['label' => '02. Mandiangin Koto Selayan', 'order' => 2],
            'aur_birugo_tigo_baleh'   => ['label' => '03. Aur Birugo Tigo Baleh',   'order' => 3],
            'total'                   => ['label' => 'Jumlah / Total',              'order' => 4],
        ];

        foreach ($tabel815DataPerYear as $yr => $cells) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '8.1.5', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => 'Panjang Gorong–Gorong dan Panjang Drainase Kota Bukittinggi',
                    'title_en' => 'Length of Sewerage and Drainage in Bukittinggi',
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'database',
                    'is_saved' => true,
                ]
            );

            foreach ($cells as $k => $val) {
                TabelData::updateOrCreate(
                    ['table_code' => '8.1.5', 'opd_code' => '01', 'year' => $yr, 'row_key' => $k],
                    [
                        'row_label' => $tabel815RowDefs[$k]['label'],
                        'value' => $val,
                        'satuan' => 'm',
                        'order_index' => $tabel815RowDefs[$k]['order'],
                        'keterangan' => 'Data riil Dinas PUPR Kota Bukittinggi',
                    ]
                );
            }
        }

        $tabel815UnenteredYears = [2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2026, 2027, 2028, 2029, 2030];
        foreach ($tabel815UnenteredYears as $yr) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '8.1.5', 'opd_code' => '01', 'year' => $yr],
                [
                    'title_id' => 'Panjang Gorong–Gorong dan Panjang Drainase Kota Bukittinggi',
                    'title_en' => 'Length of Sewerage and Drainage in Bukittinggi',
                    'source' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                    'note' => null,
                    'source_type' => 'database',
                    'is_saved' => false,
                    'table_html' => null,
                ]
            );

            foreach ($tabel815RowDefs as $k => $def) {
                TabelData::updateOrCreate(
                    ['table_code' => '8.1.5', 'opd_code' => '01', 'year' => $yr, 'row_key' => $k],
                    [
                        'row_label' => $def['label'],
                        'value' => '-',
                        'satuan' => 'm',
                        'order_index' => $def['order'],
                        'keterangan' => 'Belum ada data',
                    ]
                );
            }
        }

        // =========================================================================
        // Tabel 2.2.5: Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi
        // OPD: 03 (Dewan Perwakilan Rakyat Daerah Kota Bukittinggi)
        // Multi-Year: 2021-2025
        // =========================================================================
        $tabel225RowDefs = [
            'peraturan_daerah' => ['label' => '01. Peraturan daerah', 'order' => 1],
            'keputusan_dprd' => ['label' => '02. Keputusan DPRD', 'order' => 2],
            'keputusan_pimpinan' => ['label' => '03. Keputusan Pimpinan', 'order' => 3],
            'pernyataan' => ['label' => '04. Pernyataan', 'order' => 4],
            'pernyataan_pendapat' => ['label' => '05. Pernyataan Pendapat', 'order' => 5],
            'resolusi' => ['label' => '06. Resolusi', 'order' => 6],
            'dengar_pendapat' => ['label' => '07. Dengar Pendapat dengan Pemerintah', 'order' => 7],
            'paripurna_terbuka' => ['label' => '08. Rapat Paripurna Terbuka', 'order' => 8],
            'paripurna_istimewa' => ['label' => '09. Rapat Paripurna Istimewa', 'order' => 9],
            'panitia_musyawarah' => ['label' => '10. Rapat Panitia Musyawarah', 'order' => 10],
            'badan_kehormatan' => ['label' => '11. Rapat Badan Kehormatan', 'order' => 11],
            'badan_anggaran' => ['label' => '12. Rapat Panitia / Badan Anggaran', 'order' => 12],
            'panitia_khusus' => ['label' => '13. Rapat Panitia Khusus', 'order' => 13],
            'gabungan_komisi' => ['label' => '14. Rapat Gabungan Komisi', 'order' => 14],
            'rapat_komisi' => ['label' => '15. Rapat Komisi', 'order' => 15],
            'turun_lapangan' => ['label' => '16. Turun ke Lapangan ke Kelurahan', 'order' => 16],
            'keluar_daerah' => ['label' => '17. Keluar Daerah', 'order' => 17],
            'rapat_kerja' => ['label' => '18. Rapat Kerja', 'order' => 18],
            'penyampaian_aspirasi' => ['label' => '19. Penyampaian Aspirasi', 'order' => 19],
            'study_banding' => ['label' => '20. Study Banding', 'order' => 20],
            'reses' => ['label' => '21. Reses', 'order' => 21],
            'kunker_komisi' => ['label' => '22. Kunker Komisi', 'order' => 22],
            'total' => ['label' => 'Jumlah / Total', 'order' => 23],
        ];

        TabelData::where('table_code', '2.2.5')->whereNotIn('row_key', array_keys($tabel225RowDefs))->delete();

        $tabel225HistoricalData = [
            2021 => [
                'peraturan_daerah' => '12',
                'keputusan_dprd' => '45',
                'keputusan_pimpinan' => '–',
                'pernyataan' => '–',
                'pernyataan_pendapat' => '–',
                'resolusi' => '–',
                'dengar_pendapat' => '–',
                'paripurna_terbuka' => '28',
                'paripurna_istimewa' => '9',
                'panitia_musyawarah' => '23',
                'badan_kehormatan' => '3',
                'badan_anggaran' => '75',
                'panitia_khusus' => '60',
                'gabungan_komisi' => '25',
                'rapat_komisi' => '70',
                'turun_lapangan' => '6',
                'keluar_daerah' => '–',
                'rapat_kerja' => '–',
                'penyampaian_aspirasi' => '5',
                'study_banding' => '12',
                'reses' => '3',
                'kunker_komisi' => '3',
                'total' => '379',
            ],
            2022 => [
                'peraturan_daerah' => '8',
                'keputusan_dprd' => '44',
                'keputusan_pimpinan' => '1',
                'pernyataan' => '–',
                'pernyataan_pendapat' => '–',
                'resolusi' => '–',
                'dengar_pendapat' => '3',
                'paripurna_terbuka' => '20',
                'paripurna_istimewa' => '5',
                'panitia_musyawarah' => '22',
                'badan_kehormatan' => '4',
                'badan_anggaran' => '36',
                'panitia_khusus' => '56',
                'gabungan_komisi' => '27',
                'rapat_komisi' => '26',
                'turun_lapangan' => '1',
                'keluar_daerah' => '8',
                'rapat_kerja' => '9',
                'penyampaian_aspirasi' => '21',
                'study_banding' => '5',
                'reses' => '3',
                'kunker_komisi' => '3',
                'total' => '322',
            ],
            2023 => [
                'peraturan_daerah' => '9',
                'keputusan_dprd' => '37',
                'keputusan_pimpinan' => '3',
                'pernyataan' => '–',
                'pernyataan_pendapat' => '–',
                'resolusi' => '–',
                'dengar_pendapat' => '–',
                'paripurna_terbuka' => '18',
                'paripurna_istimewa' => '5',
                'panitia_musyawarah' => '18',
                'badan_kehormatan' => '2',
                'badan_anggaran' => '80',
                'panitia_khusus' => '81',
                'gabungan_komisi' => '33',
                'rapat_komisi' => '12',
                'turun_lapangan' => '2',
                'keluar_daerah' => '–',
                'rapat_kerja' => '10',
                'penyampaian_aspirasi' => '9',
                'study_banding' => '23',
                'reses' => '3',
                'kunker_komisi' => '3',
                'total' => '348',
            ],
            2024 => [
                'peraturan_daerah' => '8',
                'keputusan_dprd' => '34',
                'keputusan_pimpinan' => '1',
                'pernyataan' => '–',
                'pernyataan_pendapat' => '–',
                'resolusi' => '–',
                'dengar_pendapat' => '–',
                'paripurna_terbuka' => '19',
                'paripurna_istimewa' => '8',
                'panitia_musyawarah' => '16',
                'badan_kehormatan' => '2',
                'badan_anggaran' => '50',
                'panitia_khusus' => '60',
                'gabungan_komisi' => '30',
                'rapat_komisi' => '10',
                'turun_lapangan' => '–',
                'keluar_daerah' => '–',
                'rapat_kerja' => '5',
                'penyampaian_aspirasi' => '8',
                'study_banding' => '20',
                'reses' => '3',
                'kunker_komisi' => '4',
                'total' => '278',
            ],
            2025 => [
                'peraturan_daerah' => '10',
                'keputusan_dprd' => '28',
                'keputusan_pimpinan' => '4',
                'pernyataan' => '–',
                'pernyataan_pendapat' => '–',
                'resolusi' => '–',
                'dengar_pendapat' => '–',
                'paripurna_terbuka' => '27',
                'paripurna_istimewa' => '6',
                'panitia_musyawarah' => '10',
                'badan_kehormatan' => '2',
                'badan_anggaran' => '51',
                'panitia_khusus' => '41',
                'gabungan_komisi' => '17',
                'rapat_komisi' => '13',
                'turun_lapangan' => '10',
                'keluar_daerah' => '–',
                'rapat_kerja' => '5',
                'penyampaian_aspirasi' => '12',
                'study_banding' => '3',
                'reses' => '3',
                'kunker_komisi' => '3',
                'total' => '245',
            ],
            2026 => [
                'peraturan_daerah' => '–',
                'keputusan_dprd' => '–',
                'keputusan_pimpinan' => '–',
                'pernyataan' => '–',
                'pernyataan_pendapat' => '–',
                'resolusi' => '–',
                'dengar_pendapat' => '–',
                'paripurna_terbuka' => '–',
                'paripurna_istimewa' => '–',
                'panitia_musyawarah' => '–',
                'badan_kehormatan' => '–',
                'badan_anggaran' => '–',
                'panitia_khusus' => '–',
                'gabungan_komisi' => '–',
                'rapat_komisi' => '–',
                'turun_lapangan' => '–',
                'keluar_daerah' => '–',
                'rapat_kerja' => '–',
                'penyampaian_aspirasi' => '–',
                'study_banding' => '–',
                'reses' => '–',
                'kunker_komisi' => '–',
                'total' => '–',
            ],
        ];

        $sourceDprd = 'DPRD Kota Bukittinggi / <span class="italic text-slate-500">Representative of Bukittinggi Municipality</span>';

        foreach ($tabel225HistoricalData as $yr => $dataRow) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '2.2.5', 'opd_code' => '03', 'year' => $yr],
                [
                    'title_id' => 'Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi',
                    'title_en' => 'Regional Representative Decision by Type of Decision in Bukittinggi Municipality',
                    'source' => $sourceDprd,
                    'note' => null,
                    'source_type' => 'database',
                    'is_saved' => ($yr <= 2025),
                ]
            );

            foreach ($dataRow as $k => $val) {
                TabelData::updateOrCreate(
                    ['table_code' => '2.2.5', 'opd_code' => '03', 'year' => $yr, 'row_key' => $k],
                    [
                        'row_label' => $tabel225RowDefs[$k]['label'],
                        'value' => $val,
                        'satuan' => 'kegiatan',
                        'order_index' => $tabel225RowDefs[$k]['order'],
                        'keterangan' => ($val === '–' || $val === '-') ? 'Belum ada data' : 'Data resmi Sekretariat DPRD Kota Bukittinggi',
                    ]
                );
            }
        }

        // ==========================================
        // SEED DATA TABEL 2.3.1 - BKPSDM KOTA BUKITTINGGI
        // ==========================================
        $data231Years = [
            2025 => [
                'jpt_utama'     => ['pns_l' => '0',   'pns_p' => '0',    'pppk_l' => '0',  'pppk_p' => '0'],
                'jpt_madya'     => ['pns_l' => '0',   'pns_p' => '0',    'pppk_l' => '0',  'pppk_p' => '0'],
                'jpt_pratama'   => ['pns_l' => '17',  'pns_p' => '5',    'pppk_l' => '0',  'pppk_p' => '0'],
                'administrator' => ['pns_l' => '62',  'pns_p' => '48',   'pppk_l' => '0',  'pppk_p' => '0'],
                'pengawas'      => ['pns_l' => '110', 'pns_p' => '140',  'pppk_l' => '0',  'pppk_p' => '0'],
                'eselon5'       => ['pns_l' => '0',   'pns_p' => '0',    'pppk_l' => '0',  'pppk_p' => '0'],
                'dosen'         => ['pns_l' => '0',   'pns_p' => '0',    'pppk_l' => '0',  'pppk_p' => '0'],
                'guru'          => ['pns_l' => '99',  'pns_p' => '469',  'pppk_l' => '60', 'pppk_p' => '201'],
                'medis'         => ['pns_l' => '28',  'pns_p' => '293',  'pppk_l' => '21', 'pppk_p' => '125'],
                'teknis'        => ['pns_l' => '76',  'pns_p' => '202',  'pppk_l' => '70', 'pppk_p' => '38'],
                'pelaksana'     => ['pns_l' => '375', 'pns_p' => '324',  'pppk_l' => '94', 'pppk_p' => '47'],
            ],
        ];

        $jabatanLabels = [
            'jpt_utama'     => 'Jabatan Pimpinan Tinggi Utama',
            'jpt_madya'     => 'Jabatan Pimpinan Tinggi Madya',
            'jpt_pratama'   => 'Jabatan Pimpinan Tinggi Pratama',
            'administrator' => 'Administrator',
            'pengawas'      => 'Pengawas',
            'eselon5'       => 'Eselon V',
            'dosen'         => 'Jabatan Fungsional Dosen',
            'guru'          => 'Jabatan Fungsional Guru',
            'medis'         => 'Jabatan Fungsional Medis',
            'teknis'        => 'Jabatan Fungsional Teknis',
            'pelaksana'     => 'Jabatan Fungsional Umum/Pelaksana',
        ];

        TabelData::where('table_code', '2.3.1')->delete();
        TabelMetadata::where('table_code', '2.3.1')->where('year', '!=', 2025)->delete();

        foreach ($data231Years as $yr => $jabRows) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '2.3.1', 'opd_code' => '04', 'year' => $yr],
                [
                    'title_id' => "Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan, Jenis ASN, dan Jenis Kelamin (orang), {$yr}",
                    'title_en' => "Number of State Civil Apparatus (ASN) of Bukittinggi Municipal Government by Occupation, Type of ASN, and Sex, {$yr}",
                    'source' => 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / Human Resources and Development Agency of Bukittinggi Municipality',
                    'note' => "Data per-31 Desember {$yr}",
                    'source_type' => 'database',
                    'is_saved' => true,
                    'table_html' => null,
                ]
            );

            $orderIdx = 1;
            $sumPnsL = 0; $sumPnsP = 0; $sumPnsJml = 0;
            $sumPppkL = 0; $sumPppkP = 0; $sumPppkJml = 0;
            $sumTotL = 0; $sumTotP = 0; $sumTotJml = 0;

            foreach ($jabRows as $jKey => $cols) {
                $pnsL = $cols['pns_l'];
                $pnsP = $cols['pns_p'];
                $pppkL = $cols['pppk_l'];
                $pppkP = $cols['pppk_p'];

                $nPnsL = is_numeric($pnsL) ? (float)$pnsL : 0;
                $nPnsP = is_numeric($pnsP) ? (float)$pnsP : 0;
                $nPppkL = is_numeric($pppkL) ? (float)$pppkL : 0;
                $nPppkP = is_numeric($pppkP) ? (float)$pppkP : 0;

                $pnsJml = ($pnsL !== '-' || $pnsP !== '-') ? (string)($nPnsL + $nPnsP) : '-';
                $pppkJml = ($pppkL !== '-' || $pppkP !== '-') ? (string)($nPppkL + $nPppkP) : '-';
                $totalL = ($pnsL !== '-' || $pppkL !== '-') ? (string)($nPnsL + $nPppkL) : '-';
                $totalP = ($pnsP !== '-' || $pppkP !== '-') ? (string)($nPnsP + $nPppkP) : '-';
                $totalJml = ($pnsJml !== '-' || $pppkJml !== '-') ? (string)((is_numeric($pnsJml)?$pnsJml:0) + (is_numeric($pppkJml)?$pppkJml:0)) : '-';

                $sumPnsL += $nPnsL; $sumPnsP += $nPnsP; $sumPnsJml += (is_numeric($pnsJml)?(float)$pnsJml:0);
                $sumPppkL += $nPppkL; $sumPppkP += $nPppkP; $sumPppkJml += (is_numeric($pppkJml)?(float)$pppkJml:0);
                $sumTotL += (is_numeric($totalL)?(float)$totalL:0); $sumTotP += (is_numeric($totalP)?(float)$totalP:0); $sumTotJml += (is_numeric($totalJml)?(float)$totalJml:0);

                $fields = [
                    'pns_l' => $pnsL, 'pns_p' => $pnsP, 'pns_jml' => $pnsJml,
                    'pppk_l' => $pppkL, 'pppk_p' => $pppkP, 'pppk_jml' => $pppkJml,
                    'total_l' => $totalL, 'total_p' => $totalP, 'total_jml' => $totalJml,
                ];

                foreach ($fields as $fKey => $fVal) {
                    TabelData::updateOrCreate(
                        ['table_code' => '2.3.1', 'opd_code' => '04', 'year' => $yr, 'row_key' => "{$jKey}_{$fKey}"],
                        [
                            'row_label' => "{$jabatanLabels[$jKey]} - {$fKey}",
                            'value' => (string)$fVal,
                            'satuan' => 'orang',
                            'order_index' => $orderIdx++,
                            'keterangan' => 'Data resmi BKPSDM Kota Bukittinggi',
                        ]
                    );
                }
            }

            // Simpan baris total
            $totalFields = [
                'total_pns_l' => (string)$sumPnsL, 'total_pns_p' => (string)$sumPnsP, 'total_pns_jml' => (string)$sumPnsJml,
                'total_pppk_l' => (string)$sumPppkL, 'total_pppk_p' => (string)$sumPppkP, 'total_pppk_jml' => (string)$sumPppkJml,
                'total_total_l' => (string)$sumTotL, 'total_total_p' => (string)$sumTotP, 'total_total_jml' => (string)$sumTotJml,
            ];
            foreach ($totalFields as $tfKey => $tfVal) {
                TabelData::updateOrCreate(
                    ['table_code' => '2.3.1', 'opd_code' => '04', 'year' => $yr, 'row_key' => $tfKey],
                    [
                        'row_label' => "Jumlah / Total - {$tfKey}",
                        'value' => $tfVal,
                        'satuan' => 'orang',
                        'order_index' => $orderIdx++,
                        'keterangan' => 'Data resmi BKPSDM Kota Bukittinggi',
                    ]
                );
            }
        }

        // ==========================================
        // SEED DATA TABEL 2.3.2 - BKPSDM KOTA BUKITTINGGI
        // (Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin)
        // ==========================================
        $data232Years = [
            2025 => [
                'sd'    => ['pns_l' => '37',  'pns_p' => '0',   'pppk_l' => '4',   'pppk_p' => '1'],
                'smp'   => ['pns_l' => '19',  'pns_p' => '2',   'pppk_l' => '1',   'pppk_p' => '0'],
                'sma'   => ['pns_l' => '151', 'pns_p' => '53',  'pppk_l' => '116', 'pppk_p' => '44'],
                'di'    => ['pns_l' => '0',   'pns_p' => '0',   'pppk_l' => '0',   'pppk_p' => '0'],
                'dii'   => ['pns_l' => '5',   'pns_p' => '4',   'pppk_l' => '0',   'pppk_p' => '0'],
                'diii'  => ['pns_l' => '54',  'pns_p' => '258', 'pppk_l' => '21',  'pppk_p' => '74'],
                'div'   => ['pns_l' => '37',  'pns_p' => '30',  'pppk_l' => '0',   'pppk_p' => '4'],
                's1'    => ['pns_l' => '331', 'pns_p' => '939', 'pppk_l' => '101', 'pppk_p' => '288'],
                's2'    => ['pns_l' => '133', 'pns_p' => '194', 'pppk_l' => '2',   'pppk_p' => '0'],
                's3'    => ['pns_l' => '0',   'pns_p' => '1',   'pppk_l' => '0',   'pppk_p' => '0'],
            ],
            2024 => [
                'sd'    => ['pns_l' => '41',  'pns_p' => '0',   'pppk_l' => '0',  'pppk_p' => '0'],
                'smp'   => ['pns_l' => '18',  'pns_p' => '2',   'pppk_l' => '0',  'pppk_p' => '0'],
                'sma'   => ['pns_l' => '171', 'pns_p' => '64',  'pppk_l' => '34', 'pppk_p' => '5'],
                'di'    => ['pns_l' => '0',   'pns_p' => '1',   'pppk_l' => '0',  'pppk_p' => '0'],
                'dii'   => ['pns_l' => '7',   'pns_p' => '8',   'pppk_l' => '0',  'pppk_p' => '0'],
                'diii'  => ['pns_l' => '58',  'pns_p' => '277', 'pppk_l' => '18', 'pppk_p' => '72'],
                'div'   => ['pns_l' => '30',  'pns_p' => '23',  'pppk_l' => '0',  'pppk_p' => '4'],
                's1'    => ['pns_l' => '331', 'pns_p' => '934', 'pppk_l' => '95', 'pppk_p' => '280'],
                's2'    => ['pns_l' => '128', 'pns_p' => '170', 'pppk_l' => '0',  'pppk_p' => '0'],
                's3'    => ['pns_l' => '0',   'pns_p' => '0',   'pppk_l' => '0',  'pppk_p' => '0'],
            ],
        ];

        $pendidikanLabels = [
            'sd'    => 'Sekolah Dasar (SD)',
            'smp'   => 'Sekolah Menengah Pertama (SMP)',
            'sma'   => 'Sekolah Menengah Atas (SMA)',
            'di'    => 'Diploma I / Akta I',
            'dii'   => 'Diploma II / Akta II',
            'diii'  => 'Diploma III / Akta III',
            'div'   => 'Diploma IV / Akta IV',
            's1'    => 'S1 / Sarjana',
            's2'    => 'S2 / Pasca Sarjana',
            's3'    => 'S3 / Doktor/Ph.D',
        ];

        TabelData::where('table_code', '2.3.2')->delete();
        TabelMetadata::where('table_code', '2.3.2')->delete();

        foreach ($data232Years as $yr => $pendRows) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '2.3.2', 'opd_code' => '04', 'year' => $yr],
                [
                    'title_id' => "Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin (orang), {$yr}",
                    'title_en' => "Number of Civil Servant of Bukittinggi Municipal Government by Educational Level, Type of ASN, and Sex (people), {$yr}",
                    'source' => 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / Human Resources and Development Agency of Bukittinggi Municipality',
                    'note' => "Data per-31 Desember {$yr}",
                    'source_type' => 'database',
                    'is_saved' => true,
                    'table_html' => null,
                ]
            );

            $orderIdx = 1;
            $sumPnsL = 0; $sumPnsP = 0; $sumPnsJml = 0;
            $sumPppkL = 0; $sumPppkP = 0; $sumPppkJml = 0;
            $sumTotL = 0; $sumTotP = 0; $sumTotJml = 0;

            foreach ($pendRows as $pKey => $cols) {
                $pnsL = $cols['pns_l'];
                $pnsP = $cols['pns_p'];
                $pppkL = $cols['pppk_l'];
                $pppkP = $cols['pppk_p'];

                $nPnsL = is_numeric($pnsL) ? (float)$pnsL : 0;
                $nPnsP = is_numeric($pnsP) ? (float)$pnsP : 0;
                $nPppkL = is_numeric($pppkL) ? (float)$pppkL : 0;
                $nPppkP = is_numeric($pppkP) ? (float)$pppkP : 0;

                $pnsJml = ($pnsL !== '-' || $pnsP !== '-') ? (string)($nPnsL + $nPnsP) : '-';
                $pppkJml = ($pppkL !== '-' || $pppkP !== '-') ? (string)($nPppkL + $nPppkP) : '-';
                $totalL = ($pnsL !== '-' || $pppkL !== '-') ? (string)($nPnsL + $nPppkL) : '-';
                $totalP = ($pnsP !== '-' || $pppkP !== '-') ? (string)($nPnsP + $nPppkP) : '-';
                $totalJml = ($pnsJml !== '-' || $pppkJml !== '-') ? (string)((is_numeric($pnsJml)?$pnsJml:0) + (is_numeric($pppkJml)?$pppkJml:0)) : '-';

                $sumPnsL += $nPnsL; $sumPnsP += $nPnsP; $sumPnsJml += (is_numeric($pnsJml)?(float)$pnsJml:0);
                $sumPppkL += $nPppkL; $sumPppkP += $nPppkP; $sumPppkJml += (is_numeric($pppkJml)?(float)$pppkJml:0);
                $sumTotL += (is_numeric($totalL)?(float)$totalL:0); $sumTotP += (is_numeric($totalP)?(float)$totalP:0); $sumTotJml += (is_numeric($totalJml)?(float)$totalJml:0);

                $fields = [
                    'pns_l' => $pnsL, 'pns_p' => $pnsP, 'pns_jml' => $pnsJml,
                    'pppk_l' => $pppkL, 'pppk_p' => $pppkP, 'pppk_jml' => $pppkJml,
                    'total_l' => $totalL, 'total_p' => $totalP, 'total_jml' => $totalJml,
                ];

                foreach ($fields as $fKey => $fVal) {
                    TabelData::updateOrCreate(
                        ['table_code' => '2.3.2', 'opd_code' => '04', 'year' => $yr, 'row_key' => "{$pKey}_{$fKey}"],
                        [
                            'row_label' => "{$pendidikanLabels[$pKey]} - {$fKey}",
                            'value' => (string)$fVal,
                            'satuan' => 'orang',
                            'order_index' => $orderIdx++,
                            'keterangan' => 'Data resmi BKPSDM Kota Bukittinggi',
                        ]
                    );
                }
            }

            // Simpan baris total
            $totalFields = [
                'total_pns_l' => (string)$sumPnsL, 'total_pns_p' => (string)$sumPnsP, 'total_pns_jml' => (string)$sumPnsJml,
                'total_pppk_l' => (string)$sumPppkL, 'total_pppk_p' => (string)$sumPppkP, 'total_pppk_jml' => (string)$sumPppkJml,
                'total_total_l' => (string)$sumTotL, 'total_total_p' => (string)$sumTotP, 'total_total_jml' => (string)$sumTotJml,
            ];
            foreach ($totalFields as $tfKey => $tfVal) {
                TabelData::updateOrCreate(
                    ['table_code' => '2.3.2', 'opd_code' => '04', 'year' => $yr, 'row_key' => $tfKey],
                    [
                        'row_label' => "Jumlah / Total - {$tfKey}",
                        'value' => $tfVal,
                        'satuan' => 'orang',
                        'order_index' => $orderIdx++,
                        'keterangan' => 'Data resmi BKPSDM Kota Bukittinggi',
                    ]
                );
            }
        }

        // ==========================================
        // SEED DATA TABEL 2.3.3 - BKPSDM KOTA BUKITTINGGI
        // (Menurut Tingkat Kepangkatan dan Jenis Kelamin)
        // ==========================================
        $data233Years = [
            2025 => [
                '1_ia'   => ['l' => '0',   'p' => '0'],
                '2_ib'   => ['l' => '0',   'p' => '0'],
                '3_ic'   => ['l' => '1',   'p' => '0'],
                '4_id'   => ['l' => '5',   'p' => '0'],
                '5_iia'  => ['l' => '43',  'p' => '2'],
                '6_iib'  => ['l' => '5',   'p' => '1'],
                '7_iic'  => ['l' => '41',  'p' => '80'],
                '8_iid'  => ['l' => '57',  'p' => '54'],
                '9_iiia' => ['l' => '103', 'p' => '117'],
                '10_iiib'=> ['l' => '91',  'p' => '220'],
                '11_iiic'=> ['l' => '98',  'p' => '212'],
                '12_iiid'=> ['l' => '193', 'p' => '468'],
                '13_iva' => ['l' => '68',  'p' => '167'],
                '14_ivb' => ['l' => '37',  'p' => '103'],
                '15_ivc' => ['l' => '24',  'p' => '57'],
                '16_ivd' => ['l' => '1',   'p' => '0'],
                '17_ive' => ['l' => '0',   'p' => '0'],
            ],
            2024 => [
                '1_ia'   => ['l' => '0',   'p' => '0'],
                '2_ib'   => ['l' => '0',   'p' => '0'],
                '3_ic'   => ['l' => '2',   'p' => '0'],
                '4_id'   => ['l' => '15',  'p' => '1'],
                '5_iia'  => ['l' => '36',  'p' => '1'],
                '6_iib'  => ['l' => '5',   'p' => '1'],
                '7_iic'  => ['l' => '57',  'p' => '93'],
                '8_iid'  => ['l' => '57',  'p' => '51'],
                '9_iiia' => ['l' => '107', 'p' => '114'],
                '10_iiib'=> ['l' => '86',  'p' => '246'],
                '11_iiic'=> ['l' => '91',  'p' => '177'],
                '12_iiid'=> ['l' => '197', 'p' => '480'],
                '13_iva' => ['l' => '68',  'p' => '142'],
                '14_ivb' => ['l' => '39',  'p' => '117'],
                '15_ivc' => ['l' => '23',  'p' => '56'],
                '16_ivd' => ['l' => '1',   'p' => '0'],
                '17_ive' => ['l' => '0',   'p' => '0'],
            ],
        ];

        $pangkatLabels = [
            '1_ia'   => '1. I / A (Juru Muda)',
            '2_ib'   => '2. I / B (Juru Muda Tingkat I)',
            '3_ic'   => '3. I / C (Juru)',
            '4_id'   => '4. I / D (Juru Tingkat I)',
            '5_iia'  => '5. II / A (Pengatur Muda)',
            '6_iib'  => '6. II / B (Pengatur Muda Tingkat I)',
            '7_iic'  => '7. II / C (Pengatur)',
            '8_iid'  => '8. II / D (Pengatur Tingkat I)',
            '9_iiia' => '9. III / A (Penata Muda)',
            '10_iiib'=> '10. III / B (Penata Muda Tingkat I)',
            '11_iiic'=> '11. III / C (Penata)',
            '12_iiid'=> '12. III / D (Penata Tingkat I)',
            '13_iva' => '13. IV / A (Pembina)',
            '14_ivb' => '14. IV / B (Pembina Tingkat I)',
            '15_ivc' => '15. IV / C (Pembina Utama Muda)',
            '16_ivd' => '16. IV / D (Pembina Utama Madya)',
            '17_ive' => '17. IV / E (Pembina Utama)',
        ];

        TabelData::where('table_code', '2.3.3')->delete();
        TabelMetadata::where('table_code', '2.3.3')->delete();

        foreach ($data233Years as $yr => $rows233) {
            TabelMetadata::updateOrCreate(
                ['table_code' => '2.3.3', 'opd_code' => '04', 'year' => $yr],
                [
                    'title_id' => "Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang), {$yr}",
                    'title_en' => "Number of Bukittinggi Municipality Government’s Civil Servants by Hierarchy and Sex (people), {$yr}",
                    'source' => 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / Human Resources and Development Agency of Bukittinggi Municipality',
                    'note' => "Data per-31 Desember {$yr}",
                    'source_type' => 'database',
                    'is_saved' => true,
                    'table_html' => null,
                ]
            );

            $orderIdx = 1;
            $sumL = 0; $sumP = 0; $sumJml = 0;

            foreach ($rows233 as $key => $cols) {
                $lVal = $cols['l'];
                $pVal = $cols['p'];
                $nL = is_numeric($lVal) ? (float)$lVal : 0;
                $nP = is_numeric($pVal) ? (float)$pVal : 0;
                $jmlVal = ($lVal !== '-' || $pVal !== '-') ? (string)($nL + $nP) : '-';

                $sumL += $nL;
                $sumP += $nP;
                $sumJml += (is_numeric($jmlVal) ? (float)$jmlVal : 0);

                foreach (['l' => $lVal, 'p' => $pVal, 'jml' => $jmlVal] as $colKey => $val) {
                    TabelData::updateOrCreate(
                        ['table_code' => '2.3.3', 'opd_code' => '04', 'year' => $yr, 'row_key' => "{$key}_{$colKey}"],
                        [
                            'row_label' => "{$pangkatLabels[$key]} - {$colKey}",
                            'value' => (string)$val,
                            'satuan' => 'orang',
                            'order_index' => $orderIdx++,
                            'keterangan' => 'Data resmi BKPSDM Kota Bukittinggi',
                        ]
                    );
                }
            }

            // Simpan baris total
            foreach (['total_l' => (string)$sumL, 'total_p' => (string)$sumP, 'total_jml' => (string)$sumJml] as $tfKey => $tfVal) {
                TabelData::updateOrCreate(
                    ['table_code' => '2.3.3', 'opd_code' => '04', 'year' => $yr, 'row_key' => $tfKey],
                    [
                        'row_label' => "Jumlah / Total - {$tfKey}",
                        'value' => $tfVal,
                        'satuan' => 'orang',
                        'order_index' => $orderIdx++,
                        'keterangan' => 'Data resmi BKPSDM Kota Bukittinggi',
                    ]
                );
            }
        }
    }

    private function buildTable813Html(int $year, array $yearlyData): string
    {
        $years = [$year - 4, $year - 3, $year - 2, $year - 1, $year];

        $thYearCols = '';
        $thNumCols = '';
        foreach ($years as $idx => $y) {
            $activeClass = ($y === $year) ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : '';
            $thYearCols .= "<th class=\"py-2 px-3 border border-slate-700 {$activeClass}\">{$y}</th>";
            $colNum = $idx + 2;
            $thNumCols .= "<th class=\"py-1 px-3 border border-slate-700\">({$colNum})</th>";
        }

        $thead = "<thead>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
                <th class=\"py-3 px-4 font-bold border border-slate-700\" rowspan=\"2\">
                    <div>Kondisi Jalan</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Road Condition</div>
                </th>
                <th class=\"py-2 px-3 font-bold border border-slate-700\" colspan=\"5\">
                    <div>Tahun (km)</div>
                    <div class=\"italic font-normal text-[11px] sm:text-xs\">Year (km)</div>
                </th>
            </tr>
            <tr class=\"bg-[#f95a00] text-white text-center font-bold text-xs sm:text-sm\">
                {$thYearCols}
            </tr>
            <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
                <th class=\"py-1 px-3 border border-slate-700\">(1)</th>
                {$thNumCols}
            </tr>
        </thead>";

        $rowDefs = [
            ['key' => 'baik', 'label' => '1. Baik / <span class="italic font-normal text-slate-700">Good</span>', 'isTotal' => false],
            ['key' => 'sedang', 'label' => '2. Sedang / <span class="italic font-normal text-slate-700">Moderate</span>', 'isTotal' => false],
            ['key' => 'rusak', 'label' => '3. Rusak / <span class="italic font-normal text-slate-700">Damage</span>', 'isTotal' => false],
            ['key' => 'rusak_berat', 'label' => '4. Rusak Berat / <span class="italic font-normal text-slate-700">Severely Damage</span>', 'isTotal' => false],
            ['key' => 'total', 'label' => 'Jumlah / <span class="italic font-bold">Total</span>', 'isTotal' => true],
        ];

        $tbody = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
        foreach ($rowDefs as $row) {
            $trClass = $row['isTotal'] ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
            $tdLabelClass = $row['isTotal'] ? 'py-2.5 px-4 font-semibold border border-slate-700 text-left' : 'py-2.5 px-4 font-semibold border border-slate-700 text-left';

            $tbody .= "<tr class=\"{$trClass}\">";
            $tbody .= "<td class=\"{$tdLabelClass}\">{$row['label']}</td>";

            foreach ($years as $y) {
                $val = $yearlyData[$y][$row['key']] ?? '-';
                $isActive = ($y === $year);
                $activeTdClass = $isActive ? ($row['isTotal'] ? 'font-extrabold bg-amber-200/80' : 'font-bold bg-amber-100/60') : ($row['isTotal'] ? 'font-extrabold' : '');
                $displayVal = ($val === '-' || $val === '–' || $val === '') ? '<span class="text-slate-400 font-normal">-</span>' : htmlspecialchars($val);
                $tbody .= "<td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle {$activeTdClass}\">{$displayVal}</td>";
            }
            $tbody .= "</tr>";
        }
        $tbody .= '</tbody>';

        return $thead . $tbody;
    }
}
