<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tabel_opd_data', function (Blueprint $table) {
            $table->id();
            $table->string('table_code', 50)->index();
            $table->string('opd_code', 50)->index();
            $table->integer('year')->index();
            $table->string('row_key', 100);
            $table->string('row_label', 255);
            $table->string('value', 100)->nullable()->default('-');
            $table->string('satuan', 50)->nullable()->default('km');
            $table->integer('order_index')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['table_code', 'opd_code', 'year', 'row_key'], 'uniq_tbl_opd_yr_row');
        });

        Schema::create('tabel_opd_metadata', function (Blueprint $table) {
            $table->id();
            $table->string('table_code', 50)->index();
            $table->string('opd_code', 50)->index();
            $table->integer('year')->index();
            $table->string('title_id', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->text('source')->nullable();
            $table->text('note')->nullable();
            $table->longText('table_html')->nullable();
            $table->string('source_type', 50)->default('database');
            $table->boolean('is_saved')->default(true);
            $table->timestamps();

            $table->unique(['table_code', 'opd_code', 'year'], 'uniq_tbl_opd_yr_meta');
        });

        // Seed data riil resmi BPS Bukittinggi untuk Tabel 8.1.1
        $tableCode = '8.1.1';
        $opdCode = '01';
        $now = now();

        $rowsConfig = [
            ['key' => 'negara', 'label' => '1. Negara / State', 'order' => 1],
            ['key' => 'provinsi', 'label' => '2. Provinsi / Province', 'order' => 2],
            ['key' => 'kota', 'label' => '3. Kota / Municipality', 'order' => 3],
            ['key' => 'total', 'label' => 'Jumlah / Total', 'order' => 4],
        ];

        // Data riil angka-angka lengkap:
        // 2019-2020: Belum ada data / belum dicatat -> '-'
        // 2021-2022: 11,75 | - | 180,17 | 191,92
        // 2023-2025: 8,18 | - | 198,3 | 206,48 (Berdasarkan SK Menteri PUPR No. 1688/KPTS/M/2022)
        $historicalData = [
            2019 => ['negara' => '-',     'provinsi' => '-', 'kota' => '-',      'total' => '-',      'note' => 'Belum ada data pendataan (Tahun 2019 belum ada)'],
            2020 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92', 'note' => 'Data resmi BPS Kota Bukittinggi'],
            2021 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92', 'note' => 'Data resmi BPS Kota Bukittinggi'],
            2022 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92', 'note' => 'Data resmi BPS Kota Bukittinggi'],
            2023 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48', 'note' => 'Berdasarkan Keputusan Menteri PUPR No. 1688/KPTS/M/2022'],
            2024 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48', 'note' => 'Hasil data penetapan tahun sebelumnya (SK Kemen PUPR No. 1688/KPTS/M/2022)'],
            2025 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48', 'note' => 'Hasil data penetapan tahun sebelumnya (SK Kemen PUPR No. 1688/KPTS/M/2022)'],
            2026 => ['negara' => '-',     'provinsi' => '-', 'kota' => '-',      'total' => '-',      'note' => 'Belum ada data pendataan (Tahun 2026 belum ada)'],
        ];

        $insertData = [];
        $insertMeta = [];

        $defaultSource = 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>';
        $defaultNote = '<div class="space-y-1"><div>1. Data tidak termasuk panjang jalan tol / <span class="italic text-slate-500">Excluding toll road</span></div><div>2. Data tahun 2023 berdasarkan Keputusan Menteri Pekerjaan Umum dan Perumahan Rakyat No. 1688/KPTS/M/2022 / <span class="italic text-slate-500">Data of 2023 based on Public Works and Public Housing Ministerial Decree No. 1688/KPTS/M/2022</span></div></div>';

        foreach ($historicalData as $year => $values) {
            foreach ($rowsConfig as $row) {
                $k = $row['key'];
                $insertData[] = [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                    'row_key' => $k,
                    'row_label' => $row['label'],
                    'value' => $values[$k] ?? '-',
                    'satuan' => 'km',
                    'order_index' => $row['order'],
                    'keterangan' => $values['note'] ?? null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            $insertMeta[] = [
                'table_code' => $tableCode,
                'opd_code' => $opdCode,
                'year' => $year,
                'title_id' => "Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi, " . ($year - 5) . "–" . ($year - 1),
                'title_en' => "Length of Road by Level of Government Authority in Bukittinggi Municipality (Km), " . ($year - 5) . "–" . ($year - 1),
                'source' => $defaultSource,
                'note' => $defaultNote,
                'table_html' => null,
                'source_type' => 'database',
                'is_saved' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Meta tahun 2026 (periode 2021-2025)
        $insertMeta[] = [
            'table_code' => $tableCode,
            'opd_code' => $opdCode,
            'year' => 2026,
            'title_id' => "Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi, 2021–2025",
            'title_en' => "Length of Road by Level of Government Authority in Bukittinggi Municipality (Km), 2021–2025",
            'source' => $defaultSource,
            'note' => $defaultNote,
            'table_html' => null,
            'source_type' => 'database',
            'is_saved' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('tabel_opd_data')->insert($insertData);
        DB::table('tabel_opd_metadata')->insert($insertMeta);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_opd_data');
        Schema::dropIfExists('tabel_opd_metadata');
    }
};
