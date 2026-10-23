<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TabelOpdTest extends TestCase
{
    public function test_tabel_opd_811_can_be_viewed_by_authenticated_user(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.1&opd=01&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi');
        $response->assertSee('tableNoteRow');
        $response->assertSee('tableNoteContent');
        $response->assertSee('isMultiYear: true');
        $response->assertSee('isExcludeSelectedYear: false');
        $response->assertSee('Tingkat Kewenangan Pemerintahan');
        $response->assertSee('1. Negara /');
        $response->assertSee('3. Kota /');
        $response->assertSee('1688/KPTS/M/2022');
        $response->assertSee('Public Works and Spatial Planning Services of Bukittinggi Municipality');
        $response->assertSee('11,75');
        $response->assertSee('180,17');
        $response->assertSee('198,3');
        $response->assertSee('saveGeneratedExcel');
        $response->assertSee('excelYearColMap');
        $response->assertSee('hasYearColumnsInExcel');
    }

    public function test_edit_tabel_opd_811_can_be_viewed(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/edit-tabel-opd?code=8.1.1&opd=01&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi');
        $response->assertSee('isMultiYear: true');
        $response->assertSee('tableNoteRow');
        $response->assertSee('dataStore');
        $response->assertSee('serverDbDataStore');
    }

    public function test_tabel_opd_811_year_2026_displays_database_numbers(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.1&opd=01&year=2026');

        $response->assertStatus(200);
        $response->assertSee('Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi');
        $response->assertSee('2021');
        $response->assertSee('2025');

        // Verify API for 2026 returns metadata and all numbers up to 2025
        $apiResponse = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->getJson('/api/tabel-opd/data?code=8.1.1&opd=01&year=2026');

        $apiResponse->assertStatus(200);
        $json = $apiResponse->json();
        $this->assertNotNull($json['metadata']);
        $this->assertEquals('Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi, 2022–2026', $json['metadata']['title_id']);
        $this->assertArrayHasKey(2025, $json['dataStore'] ?? []);
        $this->assertEquals('8,18', $json['dataStore'][2025]['negara']);
        $this->assertEquals('198,3', $json['dataStore'][2025]['kota']);
        $this->assertEquals('206,48', $json['dataStore'][2025]['total']);

        // Data 2026 memang belum ada jadi strip '-'
        $this->assertArrayHasKey(2026, $json['dataStore'] ?? []);
        $this->assertEquals('-', $json['dataStore'][2026]['negara']);
        $this->assertEquals('-', $json['dataStore'][2026]['provinsi']);
        $this->assertEquals('-', $json['dataStore'][2026]['kota']);
        $this->assertEquals('-', $json['dataStore'][2026]['total']);
    }

    public function test_tabel_opd_811_year_2024_includes_2019_as_empty_column(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.1&opd=01&year=2024');

        $response->assertStatus(200);
        $response->assertSee('Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi');
        $response->assertSee('2019');
        $response->assertSee('2023');
    }

    public function test_tabel_opd_811_year_2027_includes_2026_as_empty_column(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.1&opd=01&year=2027');

        $response->assertStatus(200);
        $response->assertSee('Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi');
        $response->assertSee('2022');
        $response->assertSee('2026');
    }

    public function test_api_tabel_opd_data_returns_database_records(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->getJson('/api/tabel-opd/data?code=8.1.1&opd=01&year=2025');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'table_code' => '8.1.1',
            'opd_code' => '01',
            'year' => 2025,
        ]);

        $json = $response->json();
        $this->assertArrayHasKey('dataStore', $json);
        $dataStore = $json['dataStore'];

        // Verifikasi data 2019 adalah strip '-' (belum ada data)
        $this->assertEquals('-', $dataStore[2019]['negara']);
        $this->assertEquals('-', $dataStore[2019]['provinsi']);
        $this->assertEquals('-', $dataStore[2019]['kota']);
        $this->assertEquals('-', $dataStore[2019]['total']);

        // Verifikasi data 2020-2022 adalah data riil resmi
        $this->assertEquals('11,75', $dataStore[2020]['negara']);
        $this->assertEquals('-', $dataStore[2020]['provinsi']);
        $this->assertEquals('180,17', $dataStore[2020]['kota']);
        $this->assertEquals('191,92', $dataStore[2020]['total']);

        // Verifikasi data 2021-2024 adalah data riil
        $this->assertEquals('11,75', $dataStore[2021]['negara']);
        $this->assertEquals('180,17', $dataStore[2021]['kota']);
        $this->assertEquals('8,18', $dataStore[2023]['negara']);
        $this->assertEquals('198,3', $dataStore[2023]['kota']);
        $this->assertEquals('206,48', $dataStore[2023]['total']);
        $this->assertEquals('8,18', $dataStore[2024]['negara']);
        $this->assertEquals('198,3', $dataStore[2024]['kota']);
    }

    public function test_api_tabel_opd_save_and_delete_operations(): void
    {
        $saveResponse = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->postJson('/api/tabel-opd/save', [
            'table_code' => '8.1.1',
            'opd_code' => '01',
            'year' => 2025,
            'table_html' => '<table><tbody><tr><td>Test Database Snapshot</td></tr></tbody></table>',
            'source_type' => 'manual',
            'rows_data' => [
                2024 => [
                    'negara' => '8,18',
                    'provinsi' => '-',
                    'kota' => '198,3',
                    'total' => '206,48'
                ]
            ]
        ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        // Verifikasi data tersimpan di tabel_opd_data
        $this->assertDatabaseHas('tabel_opd_data', [
            'table_code' => '8.1.1',
            'opd_code' => '01',
            'year' => 2024,
            'row_key' => 'kota',
            'value' => '198,3'
        ]);

        // Hapus snapshot custom
        $deleteResponse = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->postJson('/api/tabel-opd/delete', [
            'table_code' => '8.1.1',
            'opd_code' => '01',
            'year' => 2025
        ]);

        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJson(['success' => true]);
    }

    public function test_print_landscape_layout_is_configured_properly(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.1&opd=01&year=2025');

        $response->assertStatus(200);
        $response->assertSee('size: A4 landscape');
        $response->assertSee('printTableLandscape');
        $response->assertSee('BADAN PUSAT STATISTIK KOTA BUKITTINGGI');
        $response->assertSee('FORMAT EXCEL / PUBLIKASI LANDSCAPE');
        $response->assertSee('Dokumen PDF Resmi');
        $response->assertSee('Standar Publikasi Daerah Dalam Angka (DDA)');
    }

    public function test_export_excel_page_setup_configured_for_a4_fit_one_page(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.1&opd=01&year=2025');

        $response->assertStatus(200);
        $response->assertSee('fitToWidth: 1');
        $response->assertSee('paperSize: 9');
        $response->assertSee("orientation: 'landscape'", false);
        $response->assertSee('fitToPage: true');
    }

    public function test_tabel_opd_812_loads_with_paved_road_data_and_multi_year(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.2&opd=01&year=2024');

        $response->assertStatus(200);
        $response->assertSee('Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi');
        $response->assertSee('1. Aspal /');
        $response->assertSee('Paved');
        $response->assertSee('2. Kerikil /');
        $response->assertSee('3. Tanah /');
        $response->assertSee('4. Lainnya /');
        $response->assertSee('180,17');
        $response->assertSee('192,18');
        $response->assertSee('6,12');
        $response->assertSee('198,3');
    }

    public function test_edit_tabel_opd_812_loads_with_matching_paved_road_data(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/edit-tabel-opd?code=8.1.2&opd=01&year=2024');

        $response->assertStatus(200);
        $response->assertSee('Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi');
        $response->assertSee('1. Aspal /');
        $response->assertSee('Paved');
        $response->assertSee('180,17');
        $response->assertSee('192,18');
        $response->assertSee('6,12');
        $response->assertSee('198,3');
    }

    public function test_table_813_displays_official_road_condition_data(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.3&opd=01&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km)');
        $response->assertSee('1. Baik');
        $response->assertSee('2. Sedang');
        $response->assertSee('3. Rusak');
        $response->assertSee('4. Rusak Berat');
        $response->assertSee('94,34');
        $response->assertSee('151,56');
        $response->assertSee('131,05');
        $response->assertSee('198,3');
    }

    public function test_table_813_unentered_years_have_dashes(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.3&opd=01&year=2026');

        $response->assertStatus(200);
        $response->assertSee('y <= 2020 || y >= 2026', false);
    }

    public function test_api_save_table_813_for_year_2024(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->postJson('/api/tabel-opd/save', [
            'table_code' => '8.1.3',
            'opd_code' => '01',
            'year' => 2024,
            'source_type' => 'excel',
            'rows_data' => [
                2024 => [
                    'baik' => '134,92',
                    'sedang' => '47,02',
                    'rusak' => '11,01',
                    'rusak_berat' => '5,35',
                    'total' => '198,3'
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('tabel_opd_data', [
            'table_code' => '8.1.3',
            'opd_code' => '01',
            'year' => 2024,
            'row_key' => 'baik',
            'value' => '134,92'
        ]);
    }

    public function test_tabel_opd_supports_instansi_vertikal_navigation_and_breadcrumbs(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?type=instansi&opd=01&code=1.1.9&year=2025');

        $response->assertStatus(200);
        $response->assertSee('INSTANSI VERTIKAL');
        $response->assertSee('Daftar Instansi');
        $response->assertSee('Isi Data Instansi Vertikal');
        $response->assertSee('KANTOR PERTANAHAN KOTA BUKITTINGGI (BPN)');
        $response->assertSee('Jumlah Pencatatan Peralihan Hak Menurut Jenis Kepemilikan di Kota Bukittinggi');
    }

    public function test_edit_tabel_opd_supports_instansi_vertikal_navigation(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/edit-tabel-opd?type=instansi&opd=01&code=1.1.9&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Daftar Instansi');
        $response->assertSee('KANTOR PERTANAHAN KOTA BUKITTINGGI (BPN)');
        $response->assertSee('Jumlah Pencatatan Peralihan Hak Menurut Jenis Kepemilikan di Kota Bukittinggi');
    }

    public function test_tabel_opd_225_dprd_can_be_viewed(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'dprd_bukittinggi',
                'role' => 'opd',
                'displayName' => 'DPRD Kota Bukittinggi',
                'opdCode' => '03',
                'allowed_pages' => ['tabel-opd', 'edit-tabel-opd', 'isi-data-opd']
            ]
        ])->get('/tabel-opd?code=2.2.5&opd=03&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi');
        $response->assertSee('DPRD Kota Bukittinggi');
        $response->assertSee('Jenis Keputusan');
        $response->assertSee('01. Peraturan daerah');
        $response->assertSee('02. Keputusan DPRD');
        $response->assertSee('03. Keputusan Pimpinan');
        $response->assertSee('08. Rapat Paripurna Terbuka');
        $response->assertSee('12. Rapat Panitia / Badan Anggaran');
        $response->assertSee('Jumlah /');
    }

    public function test_edit_tabel_opd_225_dprd_can_be_viewed(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'dprd_bukittinggi',
                'role' => 'opd',
                'displayName' => 'DPRD Kota Bukittinggi',
                'opdCode' => '03',
                'allowed_pages' => ['tabel-opd', 'edit-tabel-opd', 'isi-data-opd']
            ]
        ])->get('/edit-tabel-opd?code=2.2.5&opd=03&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi');
        $response->assertSee('isMultiYear: true');
        $response->assertSee('Jenis Keputusan');
        $response->assertSee('01. Peraturan daerah');
    }

    public function test_api_tabel_opd_225_returns_seeded_data(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'dprd_bukittinggi',
                'role' => 'opd',
                'displayName' => 'DPRD Kota Bukittinggi',
                'opdCode' => '03'
            ]
        ])->getJson('/api/tabel-opd/data?code=2.2.5&opd=03&year=2025');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'table_code' => '2.2.5',
            'opd_code' => '03',
            'year' => 2025,
        ]);
        $this->assertNotEmpty($response->json('dataStore.2025.keputusan_dprd'));
        $this->assertNotEmpty($response->json('dataStore.2025.peraturan_daerah'));
        $this->assertStringContainsString('Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi', $response->json('metadata.title_id'));
    }

    public function test_api_save_tabel_opd_225(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'dprd_bukittinggi',
                'role' => 'opd',
                'displayName' => 'DPRD Kota Bukittinggi',
                'opdCode' => '03'
            ]
        ])->postJson('/api/tabel-opd/save', [
            'table_code' => '2.2.5',
            'opd_code' => '03',
            'year' => 2025,
            'title_id' => 'Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi, 2021–2025',
            'title_en' => 'Decrees and Results of Regional House of Representatives Working Meetings in Bukittinggi Municipality, 2021–2025',
            'source' => 'Sekretariat DPRD Kota Bukittinggi',
            'rows_data' => [
                2025 => [
                    'keputusan_dprd' => '28',
                    'keputusan_pimpinan' => '4'
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('tabel_opd_data', [
            'table_code' => '2.2.5',
            'opd_code' => '03',
            'year' => 2025,
            'row_key' => 'keputusan_dprd',
            'value' => '28',
            'satuan' => 'kegiatan'
        ]);
    }

    public function test_table_813_year_2030_uses_range_2026_to_2030_and_does_not_leak_2026_html(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=8.1.3&opd=01&year=2030');

        $response->assertStatus(200);

        // API get data test
        $apiResponse = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->getJson('/api/tabel-opd/data?code=8.1.3&opd=01&year=2030');

        $apiResponse->assertStatus(200);
        $apiData = $apiResponse->json();
        $this->assertEquals(2030, $apiData['year']);
        // Metadata must NOT be the 2026 record containing 2022-2026
        if ($apiData['metadata']) {
            $this->assertEquals(2030, $apiData['metadata']['year']);
        } else {
            $this->assertNull($apiData['metadata']);
        }
    }

    public function test_tabel_opd_231_can_be_viewed_by_authenticated_user(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=2.3.1&opd=04&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan');
        $response->assertSee('Pegawai Negeri Sipil');
        $response->assertSee('Pegawai Pemerintah dengan Perjanjian Kinerja');
        $response->assertSee('Aparatur Sipil Negara');
        $response->assertSee('Jabatan Pimpinan Tinggi Pratama');
        $response->assertSee('Administrator');
        $response->assertSee('Jabatan Fungsional Guru');
        $response->assertSee('Jabatan Fungsional Umum/Pelaksana');
        $response->assertSee('Badan Kepegawaian dan Pengembangan SDM');
    }

    public function test_edit_tabel_opd_231_can_be_viewed(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/edit-tabel-opd?code=2.3.1&opd=04&year=2025');

        $response->assertStatus(200);
        $response->assertSee('2.3.1');
        $response->assertSee('Jumlah Aparatur Sipil Negara (ASN)');
    }

    public function test_api_save_and_retrieve_tabel_231(): void
    {
        $payload = [
            'table_code' => '2.3.1',
            'opd_code' => '04',
            'year' => 2025,
            'table_html' => null,
            'title_id' => 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan, Jenis ASN, dan Jenis Kelamin (orang), 2025',
            'title_en' => 'Number of State Civil Apparatus (ASN) of Bukittinggi Municipal Government by Occupation, Type of ASN, and Sex (people), 2025',
            'source' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Bukittinggi',
            'source_type' => 'manual',
            'rows_data' => [
                2025 => [
                    'guru_pns_l' => '170',
                    'guru_pns_p' => '700',
                    'guru_pppk_l' => '50',
                    'guru_pppk_p' => '190',
                ]
            ]
        ];

        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->postJson('/api/tabel-opd/save', $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('tabel_opd_data', [
            'table_code' => '2.3.1',
            'opd_code' => '04',
            'year' => 2025,
            'row_key' => 'guru_pns_l',
            'value' => '170'
        ]);

        $this->assertDatabaseHas('tabel_opd_data', [
            'table_code' => '2.3.1',
            'opd_code' => '04',
            'year' => 2025,
            'row_key' => 'guru_pns_p',
            'value' => '700'
        ]);
    }

    public function test_tabel_232_renders_with_bilingual_headers_and_real_data(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=2.3.2&opd=04&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Tingkat Pendidikan', false);
        $response->assertSee('Educational Level', false);
        $response->assertSee('Pegawai Negeri Sipil', false);
        $response->assertSee('Sekolah Dasar (SD)', false);
        $response->assertSee('S1 / Sarjana', false);
        $response->assertSee('331', false);
    }

    public function test_api_save_table_232(): void
    {
        $payload = [
            'table_code' => '2.3.2',
            'opd_code' => '04',
            'year' => 2025,
            'title_id' => 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin (orang), 2025',
            'title_en' => 'Number of Civil Servant of Bukittinggi Municipal Government by Educational Level, Type of ASN, and Sex (people), 2025',
            'source' => 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi',
            'note' => 'Data per-31 Desember 2025',
            'source_type' => 'manual',
            'rows_data' => [
                2025 => [
                    's1_pns_l' => '350',
                    's1_pns_p' => '950',
                ]
            ]
        ];

        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->postJson('/api/tabel-opd/save', $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('tabel_opd_data', [
            'table_code' => '2.3.2',
            'opd_code' => '04',
            'year' => 2025,
            'row_key' => 's1_pns_l',
            'value' => '350'
        ]);
    }

    public function test_tabel_opd_233_can_be_viewed_with_hierarchy_data(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/tabel-opd?code=2.3.3&opd=04&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin');
        $response->assertSee('Golongan I');
        $response->assertSee('Juru Muda');
        $response->assertSee('Pembina');
        $response->assertSee('Pegawai Negeri Sipil');

        $apiResponse = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->getJson('/api/tabel-opd/data?code=2.3.3&opd=04&year=2025');

        $apiResponse->assertStatus(200);
        $json = $apiResponse->json();
        $this->assertNotNull($json['metadata']);
        $this->assertStringContainsString('Tingkat Kepangkatan', $json['metadata']['title_id']);
        $this->assertArrayHasKey(2025, $json['dataStore'] ?? []);
        $this->assertEquals('193', $json['dataStore'][2025]['12_iiid_l']);
        $this->assertEquals('468', $json['dataStore'][2025]['12_iiid_p']);
        $this->assertEquals('767', $json['dataStore'][2025]['total_l']);
        $this->assertEquals('1481', $json['dataStore'][2025]['total_p']);
        $this->assertEquals('2248', $json['dataStore'][2025]['total_jml']);
    }

    public function test_edit_tabel_opd_233_can_be_viewed(): void
    {
        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->get('/edit-tabel-opd?code=2.3.3&opd=04&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Tingkat Kepangkatan');
        $response->assertSee('serverDbDataStore');
    }

    public function test_tabel_opd_233_can_be_saved(): void
    {
        $payload = [
            'table_code' => '2.3.3',
            'opd_code' => '04',
            'year' => 2025,
            'title_id' => 'Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang), 2025',
            'title_en' => 'Number of Bukittinggi Municipality Government’s Civil Servants by Hierarchy and Sex (people), 2025',
            'source' => 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi',
            'note' => 'Data per-31 Desember 2025',
            'source_type' => 'manual',
            'rows_data' => [
                2025 => [
                    '12_iiid_l' => '195',
                    '12_iiid_p' => '470',
                ]
            ]
        ];

        $response = $this->withSession([
            'user' => [
                'username' => 'admin_bps',
                'role' => 'admin',
                'displayName' => 'Admin BPS Bukittinggi'
            ]
        ])->postJson('/api/tabel-opd/save', $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('tabel_opd_data', [
            'table_code' => '2.3.3',
            'opd_code' => '04',
            'year' => 2025,
            'row_key' => '12_iiid_l',
            'value' => '195'
        ]);

        // Restore original values
        \App\Models\TabelData::where([
            'table_code' => '2.3.3',
            'opd_code' => '04',
            'year' => 2025,
            'row_key' => '12_iiid_l'
        ])->update(['value' => '193']);
        \App\Models\TabelData::where([
            'table_code' => '2.3.3',
            'opd_code' => '04',
            'year' => 2025,
            'row_key' => '12_iiid_p'
        ])->update(['value' => '468']);
    }
}



