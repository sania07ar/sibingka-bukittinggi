<?php

namespace App\Http\Controllers;

use App\Models\TabelData;
use App\Models\TabelMetadata;
use App\Models\TabelComment;
use Illuminate\Http\Request;

class TabelOpdController extends Controller
{
    /**
     * Tampilkan Halaman Tabel OPD dengan Data dari Database
     */
    /**
     * Pastikan opd_code selaras dengan tabel resmi Daerah Dalam Angka
     */
    protected function normalizeOpdCode(string $tableCode, string $opdCode): string
    {
        return match ($tableCode) {
            '4.1.24' => '11', // Dinas Perpustakaan dan Kearsipan
            '4.1.20' => '10', // Dinas Pemuda dan Olahraga
            '4.3.4'  => '09', // Badan Penanggulangan Bencana Daerah
            '4.3.5', '4.3.6', '4.3.7', '4.3.8' => '15', // Dinas Pemadam Kebakaran dan Penyelamatan
            default  => $opdCode,
        };
    }

    public function index(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
        $year = (int) $request->query('year', 2025);
        $type = $request->query('type', 'opd');

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year);
        $sourceTypes = match($type) {
            'instansi' => ['custom_instansi'],
            'bps' => ['custom_bps', 'bps'],
            default => ['custom', 'custom_opd']
        };
        $dbCustomTables = TabelMetadata::whereIn('source_type', $sourceTypes)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();

        return view('tabel.index', [
            'currentTableCode' => $tableCode,
            'currentOpdCode' => $opdCode,
            'currentYear' => $year,
            'currentType' => $type,
            'dbDataStore' => $dbDataStore,
            'dbMetadata' => $dbMetadata,
            'dbFallbackMetadata' => null,
            'dbCustomTables' => $dbCustomTables,
        ]);
    }

    /**
     * Tampilkan Halaman Edit Tabel OPD dengan Data dari Database
     */
    public function edit(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
        $year = (int) $request->query('year', 2025);
        $type = $request->query('type', 'opd');

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year);
        $sourceTypes = match($type) {
            'instansi' => ['custom_instansi'],
            'bps' => ['custom_bps', 'bps'],
            default => ['custom', 'custom_opd']
        };
        $dbCustomTables = TabelMetadata::whereIn('source_type', $sourceTypes)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();

        return view('tabel.edit', [
            'currentTableCode' => $tableCode,
            'currentOpdCode' => $opdCode,
            'currentYear' => $year,
            'currentType' => $type,
            'dbDataStore' => $dbDataStore,
            'dbMetadata' => $dbMetadata,
            'dbFallbackMetadata' => null,
            'dbCustomTables' => $dbCustomTables,
        ]);
    }

    /**
     * API JSON: Ambil Data dari Database berdasarkan Kode Tabel & OPD
     */
    public function apiGetData(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
        $year = (int) $request->query('year', 2025);

        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year);

        // Hitung status pengisian angka data riil
        $tabelDataCount = TabelData::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, str_pad($opdCode, 2, '0', STR_PAD_LEFT)]))
            ->where('year', $year)
            ->whereNotNull('value')
            ->where('value', '!=', '-')
            ->where('value', '!=', '–')
            ->where('value', '!=', '')
            ->count();

        $numericStatus = $dbMetadata 
            ? $dbMetadata->getNumericStatus($tabelDataCount) 
            : TabelMetadata::evaluateNumericStatus(null, $tabelDataCount);

        return response()->json([
            'success' => true,
            'table_code' => $tableCode,
            'opd_code' => $opdCode,
            'year' => $year,
            'dataStore' => $dbDataStore,
            'metadata' => $dbMetadata,
            'numeric_status' => $numericStatus,
            'fallbackMetadata' => null,
        ]);
    }

    /**
     * Ambil metadata tabel dari database, atau generate template kosong (dengan nilai '-') dan simpan langsung ke database
     */
    private function getOrCreateMetadata(string $tableCode, string $opdCode, int $year): ?TabelMetadata
    {
        $dbMetadata = TabelMetadata::where('table_code', $tableCode)
            ->where('opd_code', $opdCode)
            ->where('year', $year)
            ->first();

        // Khusus tabel-tabel sekolah (Dinas Pendidikan - 4.1.1 s.d. 4.1.17):
        // Di SiAngka, tahun ajaran terkininya adalah Tahun + 1 (misal tahun 2025 memuat 2023/2024, 2024/2025, 2025/2026 dengan judul berakhiran 2025/2026)
        // Col 1: (year-2)/(year-1), Col 2: (year-1)/year, Col 3: year/(year+1), Judul: year/(year+1)
        $schoolCodes = ['4.1.1', '4.1.2', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'];
        if (in_array($tableCode, $schoolCodes)) {
            $expectedY1 = ($year - 2) . '/' . ($year - 1);
            $expectedY2 = ($year - 1) . '/' . ($year);
            $expectedY3 = ($year) . '/' . ($year + 1);
            $expectedTitleEnd = ($year) . '/' . ($year + 1);

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsUpdate = false;
                $html = $dbMetadata->table_html;

                // Rapikan thead/header tahun ajaran berulang (Negeri, Swasta, Total) dengan urutan Y1, Y2, Y3
                if (preg_match('/\b\d{4}\s*\/\s*\d{4}\b/', $html)) {
                    $idx = 0;
                    $newHtml = preg_replace_callback('/\b\d{4}\s*\/\s*\d{4}\b/', function($matches) use (&$idx, $expectedY1, $expectedY2, $expectedY3) {
                        $col = $idx % 3;
                        $idx++;
                        if ($col === 0) return $expectedY1;
                        if ($col === 1) return $expectedY2;
                        return $expectedY3;
                    }, $html);

                    if ($newHtml !== $html) {
                        $html = $newHtml;
                        $needsUpdate = true;
                    }
                }

                // Cek judul
                if (!empty($dbMetadata->title_id) && !str_ends_with(trim($dbMetadata->title_id), $expectedTitleEnd)) {
                    $dbMetadata->title_id = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_id);
                    if (!str_contains($dbMetadata->title_id, $expectedTitleEnd)) {
                        $dbMetadata->title_id = preg_replace('/(,\s*|\s+)\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_id);
                    }
                    $needsUpdate = true;
                }

                if (!empty($dbMetadata->title_en) && !str_ends_with(trim($dbMetadata->title_en), $expectedTitleEnd)) {
                    $dbMetadata->title_en = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_en);
                    if (!str_contains($dbMetadata->title_en, $expectedTitleEnd)) {
                        $dbMetadata->title_en = preg_replace('/(,\s*|\s+)\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_en);
                    }
                    $needsUpdate = true;
                }

                if ($needsUpdate) {
                    $dbMetadata->table_html = $html;
                    $dbMetadata->save();
                }

                return $dbMetadata;
            }
        }

        // Khusus tabel 11.2 (Dinas PMPTSP - NIB menurut sektor), pastikan rentang tahun Jumlah valid [year, year-1, ..., year-5]
        if ($tableCode === '11.2') {
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasCurrentYear = str_contains($dbMetadata->table_html, (string)$year);
                $hasCorruptJumlah = str_contains($dbMetadata->table_html, 'Jumlah') && (str_contains($dbMetadata->table_html, '<span class="text-slate-400 font-normal">-</span>') && !str_contains($dbMetadata->table_html, "font-extrabold\">\n                                    {$year}\n") && !str_contains($dbMetadata->table_html, "font-extrabold\">\n        {$year}\n") && !str_contains($dbMetadata->table_html, "font-extrabold\">{$year}<"));
                $hasGhostRow = str_contains($dbMetadata->table_html, "-</span>\n                                </td>\n                            \n                                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top \">\n                                    2025");
                if ($hasCurrentYear && !$hasCorruptJumlah && !$hasGhostRow) {
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel112Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Tabel 11.2 Jumlah Nomor Induk Berusaha (NIB) yang Dikeluarkan Menurut Sektor di Kota Bukittinggi, {$year}";
            $titleEn = "Table 11.2 Number of Business Identification Numbers (NIB) Issued by Sector in Bukittinggi Municipality, {$year}";
            $source = 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kota Bukittinggi / <span class="italic text-slate-500">Bukittinggi Municipality Investment and One Stop Integrated Services Service</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => ($year === 2024 || $year === 2025) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 3.1.1 (Disdukcapil - Penduduk Menurut Kecamatan)
        if ($tableCode === '3.1.1') {
            $isKnownYear = in_array($year, [2024, 2025]);
            $isOldEmptyTemplate = $dbMetadata && !empty($dbMetadata->table_html) && $dbMetadata->source_type === 'template' && !str_contains($dbMetadata->table_html, '49.614') && !str_contains($dbMetadata->table_html, '50.210') && $isKnownYear;

            if (!$dbMetadata || empty($dbMetadata->table_html) || $isOldEmptyTemplate) {
                $html311 = $this->buildTabel311Html($year, $dbMetadata ? $dbMetadata->table_html : null);
                $titleId311 = "Jumlah Penduduk, Laju Pertumbuhan Penduduk, Distribusi Persentase Penduduk, Kepadatan Penduduk, Rasio Jenis Kelamin Penduduk Menurut Kecamatan di Kota Bukittinggi";
                $titleEn311 = "Population, Population Growth Rate, Percentage Distribution of Population, Population Density, and Population Sex Ratio by District in Bukittinggi Municipality";
                $source311 = 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>';
                
                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId311,
                        'title_en' => $titleEn311,
                        'source' => $source311,
                        'note' => '',
                        'table_html' => $html311,
                        'source_type' => $isKnownYear ? 'excel' : 'template',
                        'is_saved' => true,
                    ]
                );
            }
            return $dbMetadata;
        }

        // Khusus tabel 3.1.2 (Disdukcapil - Penduduk Menurut Kelompok Umur & Jenis Kelamin)
        if ($tableCode === '3.1.2') {
            $is2025 = ($year === 2025);
            $isOldUnformattedOrEmpty = $dbMetadata && !empty($dbMetadata->table_html) && $is2025 && (!str_contains($dbMetadata->table_html, '5.203') || !str_contains($dbMetadata->table_html, '71.987'));

            if (!$dbMetadata || empty($dbMetadata->table_html) || $isOldUnformattedOrEmpty) {
                $html312 = $this->buildTabel312Html($year, $dbMetadata ? $dbMetadata->table_html : null);
                $titleId312 = "Penduduk Menurut Golongan Umur dan Jenis Kelamin di Kota Bukittinggi";
                $titleEn312 = "Population by Age Group and Sex in Bukittinggi Municipality";
                $source312 = 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>';
                
                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId312,
                        'title_en' => $titleEn312,
                        'source' => $source312,
                        'note' => '',
                        'table_html' => $html312,
                        'source_type' => $is2025 ? 'excel' : 'template',
                        'is_saved' => true,
                    ]
                );
            }
            return $dbMetadata;
        }

        // Khusus tabel 3.1.8 (Disdukcapil - Penduduk Wajib KTP & KTP Elektronik)
        // Memastikan 6 tahun historis pada Jumlah dinamis [year, year-1, ..., year-5] dan tanpa ghost cell
        if ($tableCode === '3.1.8') {
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasCurrentYear = str_contains($dbMetadata->table_html, (string)$year);
                $hasGhostRowspan = str_contains($dbMetadata->table_html, 'rowspan="3"');
                $hasYearInJumlah = preg_match('/<td[^>]*>\s*' . $year . '\s*<\/td>/i', $dbMetadata->table_html);
                if ($hasCurrentYear && !$hasGhostRowspan && $hasYearInJumlah) {
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel318Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Jumlah Penduduk Wajib KTP (Kartu Tanda Penduduk) dan yang Telah Memiliki KTP dirinci Menurut Kecamatan di Kota Bukittinggi, {$year}";
            $titleEn = "Number of Population Owner Identity Card and Be Possessed Identity Card Already by District in Bukittinggi Municipality, {$year}";
            $source = 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => ($year === 2025 || $year === 2024) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 4.3.1 (Disdukcapil - Penduduk Menurut Agama yang Dianut)
        if ($tableCode === '4.3.1') {
            $isKnownYear = in_array($year, [2023, 2024, 2025]);
            $isOldUnformatted = $dbMetadata && !empty($dbMetadata->table_html) && (
                !str_contains($dbMetadata->table_html, '.') || str_contains($dbMetadata->table_html, '(8)')
            );

            if (!$dbMetadata || empty($dbMetadata->table_html) || ($isKnownYear && $isOldUnformatted)) {
                $html431 = $this->buildTabel431Html($year, $dbMetadata ? $dbMetadata->table_html : null);
                $titleId431 = "Jumlah Penduduk Menurut Agama yang Dianut di Kota Bukittinggi, {$year}";
                $titleEn431 = "Number of Population by Religion in Bukittinggi, {$year}";
                $source431 = 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>';

                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId431,
                        'title_en' => $titleEn431,
                        'source' => $source431,
                        'note' => '',
                        'table_html' => $html431,
                        'source_type' => $isKnownYear ? 'excel' : 'template',
                        'is_saved' => true,
                    ]
                );
            }
            return $dbMetadata;
        }

        // Khusus tabel 3.2.8 (Dinas Koperasi, UKM dan Tenaga Kerja - Pencari Kerja Menurut Tingkat Pendidikan)
        if ($tableCode === '3.2.8') {
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasCurrentYear = str_contains($dbMetadata->table_html, (string)$year);
                $hasCol13 = str_contains($dbMetadata->table_html, '(13)');
                $hasYearInJumlah = preg_match('/<td[^>]*>\s*' . $year . '\s*<\/td>/i', $dbMetadata->table_html);
                if ($hasCurrentYear && $hasCol13 && $hasYearInJumlah) {
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel328Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Jumlah Pencari Kerja yang Terdaftar Menurut Tingkat Pendidikan yang Ditamatkan di Kota Bukittinggi, {$year}";
            $titleEn = "Number of Job Seeker Registered by Educational Attainment in Bukittinggi Municipality, {$year}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => in_array($year, [2020, 2021, 2022, 2023, 2024, 2025]) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 9.1 (Dinas Koperasi, UKM dan Tenaga Kerja - Jumlah Koperasi Aktif Menurut Kecamatan)
        if ($tableCode === '9.1') {
            $startYr = (string)($year - 4);
            $endYr = (string)$year;
            $rangeLabel = "{$startYr}–{$endYr}";
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasStartYr = str_contains($dbMetadata->table_html, $startYr);
                $hasEndYr = str_contains($dbMetadata->table_html, $endYr);
                $hasCol6 = str_contains($dbMetadata->table_html, '(6)');
                if ($hasStartYr && $hasEndYr && $hasCol6) {
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel91Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Jumlah Koperasi Aktif Menurut Kecamatan di Kota Bukittinggi, {$rangeLabel}";
            $titleEn = "Number of Active Cooperative in Bukittinggi Municipality, {$rangeLabel}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 9.3 (Dinas Koperasi, UKM dan Tenaga Kerja - Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha)
        if ($tableCode === '9.3') {
            $startYr = (string)($year - 6);
            $endYr = (string)$year;
            $rangeLabel = "{$startYr}–{$endYr}";
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasStartYr = str_contains($dbMetadata->table_html, $startYr);
                $hasEndYr = str_contains($dbMetadata->table_html, $endYr);
                $hasCol6 = str_contains($dbMetadata->table_html, '(6)');
                if ($hasStartYr && $hasEndYr && $hasCol6) {
                    $cleanTitleId = "Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha di Kota Bukittinggi, {$year}";
                    $cleanTitleEn = "Growth of Cooperative by Member, Deposite and Omset in Bukittinggi, {$year}";
                    if ($dbMetadata->title_id !== $cleanTitleId || $dbMetadata->title_en !== $cleanTitleEn) {
                        $dbMetadata->title_id = $cleanTitleId;
                        $dbMetadata->title_en = $cleanTitleEn;
                        $dbMetadata->save();
                    }
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel93Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha di Kota Bukittinggi, {$year}";
            $titleEn = "Growth of Cooperative by Member, Deposite and Omset in Bukittinggi, {$year}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => true,
                ]
            );
        }

                // Khusus tabel 4.1.20 (Dinas Pemuda dan Olahraga - Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi)
        if ($tableCode === '4.1.20') {
            $y1 = $year - 3;
            $y4 = $year;
            $rangeLabel = "{$y1}–{$y4}";
            $cleanTitleId = "Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi, {$rangeLabel}";
            $cleanTitleEn = "Number of Sport Club in Bukittinggi, {$rangeLabel}";
            $source = 'Dinas Pemuda dan Olahraga Kota Bukittinggi / <span class="italic text-slate-500">Youth and Sports Agency of Bukittinggi Municipality</span>';

            $hasGapInHeaders = $dbMetadata && !empty($dbMetadata->table_html) && str_contains($dbMetadata->table_html, '2022') && str_contains($dbMetadata->table_html, (string)$year) && $year >= 2026;
            $isCorruptTitle = $dbMetadata && str_contains($dbMetadata->title_id ?? '', 'Number of Sport');

            if ($dbMetadata && !empty($dbMetadata->table_html) && !$hasGapInHeaders && !$isCorruptTitle) {
                $needsSave = false;
                if ($dbMetadata->title_id !== $cleanTitleId) {
                    $dbMetadata->title_id = $cleanTitleId;
                    $needsSave = true;
                }
                if ($dbMetadata->title_en !== $cleanTitleEn) {
                    $dbMetadata->title_en = $cleanTitleEn;
                    $needsSave = true;
                }
                if ($needsSave) {
                    $dbMetadata->save();
                }
                return $dbMetadata;
            }

            $fixedHtml = $this->buildTabel4120Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => in_array($year, [2022, 2023, 2024, 2025]) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

                // Khusus tabel 4.1.24 (Dinas Perpustakaan dan Kearsipan - Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi)
        if ($tableCode === '4.1.24') {
            $cleanTitleId = "Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi, {$year}";
            $cleanTitleEn = "Number of Library Institutions, Collections, and Library Visitors in the City of Bukittinggi, {$year}";
            $source = 'Dinas Perpustakaan dan Kearsipan Kota Bukittinggi / <span class="italic text-slate-500">Library and Archives Service of Bukittinggi Municipality</span>';

            $fixedHtml = $this->buildTabel4124Html($year, $dbMetadata ? $dbMetadata->table_html : null, $opdCode);

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => ($year == 2025) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 4.3.4 (Badan Penanggulangan Bencana Daerah / BPBD - Jumlah Kejadian Bencana Alam di Kota Bukittinggi Menurut Kecamatan)
        if ($tableCode === '4.3.4') {
            $cleanTitleId = "Jumlah Kejadian Bencana Alam di Kota Bukittinggi Menurut Kecamatan, {$year}";
            $cleanTitleEn = "Number of Natural Disasters in Bukittinggi Municipality by District, {$year}";
            $source = 'Badan Penanggulangan Bencana Daerah (BPBD) Kota Bukittinggi / <span class="italic text-slate-500">Regional Agency for Disaster Management of Bukittinggi Municipality</span>';

            $fixedHtml = $this->buildTabel434Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsSave = false;
                if ($dbMetadata->title_id !== $cleanTitleId) {
                    $dbMetadata->title_id = $cleanTitleId;
                    $needsSave = true;
                }
                if ($dbMetadata->title_en !== $cleanTitleEn) {
                    $dbMetadata->title_en = $cleanTitleEn;
                    $needsSave = true;
                }
                if ($needsSave) {
                    $dbMetadata->save();
                }
                return $dbMetadata;
            }

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => in_array($year, [2023, 2024, 2025]),
                ]
            );
        }

        // Khusus tabel 4.3.5 (Dinas Pemadam Kebakaran dan Penyelamatan - Jumlah Kejadian Kebakaran Menurut Bulan)
        if ($tableCode === '4.3.5') {
            $y1 = $year - 4;
            $y5 = $year;
            $rangeLabel = "{$y1}–{$y5}";
            $cleanTitleId = "Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Bulan, {$rangeLabel}";
            $cleanTitleEn = "Number of Fire Incident in Bukittinggi Municipality by Month, {$rangeLabel}";
            $source = 'Dinas Pemadam Kebakaran dan Penyelamatan Kota Bukittinggi / <span class="italic text-slate-500">Fire and Rescue Service of Bukittinggi Municipality</span>';

            $isWrongLibrary = $dbMetadata && !empty($dbMetadata->table_html) && (
                str_contains($dbMetadata->table_html, 'Perpustakaan') ||
                str_contains($dbMetadata->table_html, 'Library') ||
                str_contains($dbMetadata->title_id ?? '', 'Perpustakaan')
            );

            if ($dbMetadata && !empty($dbMetadata->table_html) && !$isWrongLibrary) {
                return $dbMetadata;
            }

            $fixedHtml = $this->buildTabel435Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => '15',
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => false,
                ]
            );
        }

        // Khusus tabel 9.2 (Dinas Koperasi, UKM dan Tenaga Kerja - Jumlah Koperasi Menurut Jenis Koperasi dan Kecamatan)
        if ($tableCode === '9.2') {
            $cleanTitleId = "Jumlah Koperasi Menurut Jenis Koperasi dan Kecamatan di Kota Bukittinggi, {$year}";
            $cleanTitleEn = "Number of Cooperative by Kind of Cooperative and Subdistrict in Bukittinggi Municipality, {$year}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            $fixedHtml = $this->buildTabel92Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsSave = false;
                if ($dbMetadata->title_id !== $cleanTitleId) {
                    $dbMetadata->title_id = $cleanTitleId;
                    $needsSave = true;
                }
                if ($dbMetadata->title_en !== $cleanTitleEn) {
                    $dbMetadata->title_en = $cleanTitleEn;
                    $needsSave = true;
                }
                if ($needsSave) {
                    $dbMetadata->save();
                }
                return $dbMetadata;
            }

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => in_array($year, [2023, 2024, 2025]),
                ]
            );
        }

        // Khusus tabel 9.4 (Dinas Koperasi, UKM dan Tenaga Kerja - Jumlah Koperasi Menurut Jenisnya per Kecamatan)
        if ($tableCode === '9.4') {
            $cleanTitleId = "Jumlah Koperasi Menurut Jenisnya per Kecamatan di Kota Bukittinggi, {$year}";
            $cleanTitleEn = "Number of Cooperation by Kind in District in Bukittinggi, {$year}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            $fixedHtml = $this->buildTabel94Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsSave = false;
                if ($dbMetadata->title_id !== $cleanTitleId) {
                    $dbMetadata->title_id = $cleanTitleId;
                    $needsSave = true;
                }
                if ($dbMetadata->title_en !== $cleanTitleEn) {
                    $dbMetadata->title_en = $cleanTitleEn;
                    $needsSave = true;
                }
                if (str_contains($dbMetadata->table_html, 'Kolom 6') || !str_contains($dbMetadata->table_html, (string)$year)) {
                    $dbMetadata->table_html = $fixedHtml;
                    $needsSave = true;
                }
                if ($needsSave) {
                    $dbMetadata->save();
                }
                return $dbMetadata;
            }

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => true,
                ]
            );
        }

        if ($dbMetadata && !empty($dbMetadata->table_html)) {
            // Untuk tabel multi-tahun (8.1.x, 2.2.5, 1.1.10, 9.1, 9.3), pastikan table_html memuat tahun awal dan tahun akhir rentang
            $isMultiYear = str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['2.2.5', '1.1.10', '9.1', '9.3']);
            if ($isMultiYear) {
                $span = ($tableCode === '9.3') ? 6 : 4;
                $startYr = (string)($year - $span);
                $endYr = (string)$year;
                if (!str_contains($dbMetadata->table_html, $startYr) || !str_contains($dbMetadata->table_html, $endYr)) {
                    return null;
                }
            }
            return $dbMetadata;
        }

        // Tabel multi-tahun (8.1.1, 8.1.2, 8.1.3, 8.1.4, 8.1.5, 2.2.5, 1.1.10, 9.1, 9.3) membangun rentang secara dinamis.
        // Jangan pernah meminjam metadata/HTML dari tahun lain karena kolom tahunnya akan keliru.
        if (str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['2.2.5', '1.1.10', '9.1', '9.3'])) {
            return $dbMetadata;
        }

        // Cari struktur tabel dari tahun lain sebagai sumber (hanya untuk tabel non-multi-tahun)
        $sourceMeta = TabelMetadata::where('table_code', $tableCode)
            ->where('opd_code', $opdCode)
            ->whereNotNull('table_html')
            ->where('table_html', '!=', '')
            ->orderByRaw("ABS(year - {$year}) ASC")
            ->first();

        if (!$sourceMeta) {
            return $dbMetadata;
        }

        $cleanHtml = $this->buildEmptyTemplateFromHtml($sourceMeta->table_html);
        $yHtml = $this->adjustYearInHtml($cleanHtml, (int)$sourceMeta->year, $year);
        $yTitleId = $this->adjustYearInTitle($sourceMeta->title_id, (int)$sourceMeta->year, $year);
        $yTitleEn = $this->adjustYearInTitle($sourceMeta->title_en, (int)$sourceMeta->year, $year);
        $yNote = $this->adjustYearInNote($sourceMeta->note, (int)$sourceMeta->year, $year);

        // Khusus tabel sekolah jika dicopy dari tahun lain
        if (in_array($tableCode, ['4.1.1', '4.1.2', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'])) {
            $expectedY1 = ($year - 2) . '/' . ($year - 1);
            $expectedY2 = ($year - 1) . '/' . ($year);
            $expectedY3 = ($year) . '/' . ($year + 1);
            $expectedTitleEnd = ($year) . '/' . ($year + 1);

            if (preg_match('/\b\d{4}\s*\/\s*\d{4}\b/', $yHtml)) {
                $idx = 0;
                $yHtml = preg_replace_callback('/\b\d{4}\s*\/\s*\d{4}\b/', function($matches) use (&$idx, $expectedY1, $expectedY2, $expectedY3) {
                    $col = $idx % 3;
                    $idx++;
                    if ($col === 0) return $expectedY1;
                    if ($col === 1) return $expectedY2;
                    return $expectedY3;
                }, $yHtml);
            }
            if (!empty($yTitleId)) {
                $yTitleId = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $yTitleId);
            }
            if (!empty($yTitleEn)) {
                $yTitleEn = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $yTitleEn);
            }
        }

        return TabelMetadata::updateOrCreate(
            [
                'table_code' => $tableCode,
                'opd_code' => $opdCode,
                'year' => $year,
            ],
            [
                'title_id' => $yTitleId,
                'title_en' => $yTitleEn,
                'source' => $sourceMeta->source,
                'note' => $yNote,
                'table_html' => $yHtml,
                'source_type' => 'template',
                'is_saved' => true,
            ]
        );
    }

    /**
     * API POST: Simpan Perubahan Data / Hasil Upload Excel ke Database
     */
    public function apiSaveData(Request $request)
    {
        $tableCode = $request->input('table_code', '8.1.1');
        $opdCode = $request->input('opd_code', '01');
        $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
        $year = (int) $request->input('year', 2025);
        $tableHtml = $request->input('table_html');
        $titleId = $request->input('title_id');
        $titleEn = $request->input('title_en');
        $source = $request->input('source');
        if ($source) {
            $source = preg_replace('/^\s*(?:sumber\s*[\/:]\s*source|sumber\s*[\/:]|source\s*[\/:]|sumber|source)\s*:\s*/i', '', $source);
            $source = trim($source);
        }
        $note = $request->input('note');
        $sourceType = $request->input('source_type', 'database');
        $rowsData = $request->input('rows_data'); // format: [year => [row_key => value]]

        // Pisahkan jika title_id memuat baris ganda (Indonesia & Inggris tergabung dengan newline)
        if ($titleId && str_contains($titleId, "\n")) {
            $tLines = array_values(array_filter(array_map('trim', explode("\n", $titleId))));
            if (count($tLines) >= 2) {
                $titleId = $tLines[0];
                if (empty($titleEn) || strtolower($titleEn) === 'table' || $titleEn === $tLines[1]) {
                    $titleEn = $tLines[1];
                }
            }
        }

        // Auto-swap jika title_id bahasa Inggris dan title_en bahasa Indonesia
        if ($titleId && $titleEn) {
            $idHasEnglish = preg_match('/\b(Actual|Number|Length|Population|Government|Expenditures|Revenues|Percentage|District|Kind of)\b/i', $titleId);
            $enHasIndo = preg_match('/\b(Realisasi|Jumlah|Panjang|Penduduk|Pemerintah|Belanja|Pendapatan|Menurut|Jenis|Kecamatan|Banyaknya)\b/i', $titleEn);
            if ($idHasEnglish && $enHasIndo) {
                $temp = $titleId;
                $titleId = $titleEn;
                $titleEn = $temp;
            }
        }

        // Koreksi khusus tabel 2.4.2 jika kolom masih bertuliskan Jenis Pendapatan
        if ($tableCode === '2.4.2' && $tableHtml) {
            $tableHtml = str_ireplace('Jenis Pendapatan', 'Jenis Belanja', $tableHtml);
            $tableHtml = str_ireplace('Kind of Revenues', 'Kind of Expenditures', $tableHtml);
        }

        if ($tableHtml) {
            $tableHtml = $this->formatFinancialHtml($tableHtml, $opdCode, $tableCode);
        }

        $existingMeta = TabelMetadata::where('table_code', $tableCode)
            ->where('opd_code', $opdCode)
            ->where('year', $year)
            ->first();

        // 1. Simpan metadata snapshot tabel untuk tahun aktif
        TabelMetadata::updateOrCreate(
            [
                'table_code' => $tableCode,
                'opd_code' => $opdCode,
                'year' => $year,
            ],
            array_filter([
                'title_id' => $titleId ?: ($existingMeta?->title_id),
                'title_en' => $titleEn ?: ($existingMeta?->title_en),
                'source' => $source ?: ($existingMeta?->source),
                'note' => $note !== null ? $note : ($existingMeta?->note),
                'table_html' => $tableHtml ?: ($existingMeta?->table_html),
                'source_type' => $sourceType,
                'is_saved' => true,
            ], fn($v) => $v !== null)
        );

        // Otomatis sinkronkan template struktur ke tahun-tahun lain (2021-2036) di database jika belum memiliki data
        if ($tableHtml && !str_starts_with($tableCode, '8.1.') && !in_array($tableCode, ['1.1.10', '2.2.5', '9.1', '9.3', '9.4'])) {
            $this->syncTemplateToOtherYears($tableCode, $opdCode, $year, $tableHtml, $titleId, $titleEn, $source, $note);
        }

        // Jika multi-tahun, tandai juga tahun-tahun lain yang ada datanya dengan range tahun yang sesuai
        if (is_array($rowsData) && (str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['2.2.5', '1.1.10', '9.1', '9.3']))) {
            foreach (array_keys($rowsData) as $otherYear) {
                $oYear = (int) $otherYear;
                if ($oYear > 0 && $oYear !== $year) {
                    $oTitleId = $titleId;
                    $oTitleEn = $titleEn;
                    if ((str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['2.2.5', '1.1.10', '9.1'])) && $oTitleId) {
                        $oRange = ($oYear - 4) . '–' . $oYear;
                        $oTitleId = preg_replace('/(,\s*|\s+)(19|20)\d{2}(\s*[–\-]\s*(19|20)\d{2})?/', "$1{$oRange}", $titleId);
                        if ($oTitleEn) {
                            $oTitleEn = preg_replace('/(,\s*|\s+)(19|20)\d{2}(\s*[–\-]\s*(19|20)\d{2})?/', "$1{$oRange}", $titleEn);
                        }
                    }
                    TabelMetadata::updateOrCreate(
                        [
                            'table_code' => $tableCode,
                            'opd_code' => $opdCode,
                            'year' => $oYear,
                        ],
                        [
                            'title_id' => $oTitleId,
                            'title_en' => $oTitleEn,
                            'source' => $source,
                            'note' => $note,
                            'source_type' => $sourceType,
                            'is_saved' => true,
                        ]
                    );
                }
            }
        }

        // 2. Simpan nilai sel data ke tabel_opd_data jika dikirimkan
        if (is_array($rowsData)) {
            foreach ($rowsData as $y => $cells) {
                if (!is_array($cells)) continue;
                $yNum = (int) $y;
                foreach ($cells as $rKey => $val) {
                    $rowLabel = match ($rKey) {
                        'negara' => '1. Negara / State',
                        'provinsi' => '2. Provinsi / Province',
                        'kota' => '3. Kota / Municipality',
                        'aspal' => '1. Aspal / Paved',
                        'kerikil' => '2. Kerikil / Gravel',
                        'tanah' => '3. Tanah / Soil',
                        'lainnya' => '4. Lainnya / Others',
                        'baik' => '1. Baik / Good',
                        'sedang' => '2. Sedang / Moderate',
                        'rusak' => '3. Rusak / Damage',
                        'rusak_ringan' => '3. Rusak / Damage',
                        'rusak_berat' => '4. Rusak Berat / Severely Damage',
                        'total' => 'Jumlah / Total',
                        'batang_tambuo' => '01. Batang Tambuo',
                        'batang_sianok' => '02. Batang Sianok',
                        'guguk_panjang_unit' => '01. Guguk Panjang (Banyaknya)',
                        'guguk_panjang_panjang' => '01. Guguk Panjang (Panjang)',
                        'mandiangin_koto_selayan_unit' => '02. Mandiangin Koto Selayan (Banyaknya)',
                        'mandiangin_koto_selayan_panjang' => '02. Mandiangin Koto Selayan (Panjang)',
                        'aur_birugo_tigo_baleh_unit' => '03. Aur Birugo Tigo Baleh (Banyaknya)',
                        'aur_birugo_tigo_baleh_panjang' => '03. Aur Birugo Tigo Baleh (Panjang)',
                        'total_unit' => 'Jumlah / Total (Banyaknya)',
                        'total_panjang' => 'Jumlah / Total (Panjang)',
                        'guguk_panjang' => '01. Guguk Panjang',
                        'mandiangin_koto_selayan' => '02. Mandiangin Koto Selayan',
                        'aur_birugo_tigo_baleh' => '03. Aur Birugo Tigo Baleh',
                        'peraturan_daerah' => '01. Peraturan daerah',
                        'keputusan_dprd' => '02. Keputusan DPRD',
                        'keputusan_pimpinan' => '03. Keputusan Pimpinan',
                        'pernyataan' => '04. Pernyataan',
                        'pernyataan_pendapat' => '05. Pernyataan Pendapat',
                        'resolusi' => '06. Resolusi',
                        'dengar_pendapat' => '07. Dengar Pendapat dengan Pemerintah',
                        'paripurna_terbuka' => '08. Rapat Paripurna Terbuka',
                        'paripurna_istimewa' => '09. Rapat Paripurna Istimewa',
                        'panitia_musyawarah' => '10. Rapat Panitia Musyawarah',
                        'badan_kehormatan' => '11. Rapat Badan Kehormatan',
                        'badan_anggaran' => '12. Rapat Panitia / Badan Anggaran',
                        'panitia_khusus' => '13. Rapat Panitia Khusus',
                        'gabungan_komisi' => '14. Rapat Gabungan Komisi',
                        'rapat_komisi' => '15. Rapat Komisi',
                        'turun_lapangan' => '16. Turun ke Lapangan ke Kelurahan',
                        'keluar_daerah' => '17. Keluar Daerah',
                        'rapat_kerja' => '18. Rapat Kerja',
                        'penyampaian_aspirasi' => '19. Penyampaian Aspirasi',
                        'study_banding' => '20. Study Banding',
                        'reses' => '21. Reses',
                        'kunker_komisi' => '22. Kunker Komisi',
                        default => ucwords(str_replace('_', ' ', $rKey)),
                    };

                    $satuan = match($tableCode) {
                        '1.1.6' => 'm',
                        '8.1.4' => (str_ends_with($rKey, '_unit') ? 'unit' : 'm'),
                        '8.1.5' => 'm',
                        '2.2.5' => 'kegiatan',
                        '2.3.1', '2.3.2', '2.3.3' => 'orang',
                        '4.3.4' => 'kejadian',
                        '9.1' => 'koperasi',
                        '9.2' => 'koperasi',
                        '9.4' => 'unit',
                        '9.3' => match($rKey) {
                            'koperasi' => 'unit',
                            'anggota' => 'orang',
                            default => '000 Rp',
                        },
                        default => 'km',
                    };

                    $valStr = trim((string) $val);

                    // Validasi pengaman: Jika nilai yang dikirim sama dengan label baris atau berisi teks kategori
                    // (misal akibat salah geser kolom saat edit), jangan simpan ke database agar tidak merusak data numerik
                    if ($valStr === $rowLabel || 
                        str_contains($valStr, 'Negara / State') || 
                        str_contains($valStr, 'Provinsi / Province') || 
                        str_contains($valStr, 'Kota / Municipality') ||
                        str_contains($valStr, 'Kewenangan')) {
                        continue;
                    }

                    TabelData::updateOrCreate(
                        [
                            'table_code' => $tableCode,
                            'opd_code' => $opdCode,
                            'year' => $yNum,
                            'row_key' => $rKey,
                        ],
                        [
                            'row_label' => $rowLabel,
                            'value' => $valStr,
                            'satuan' => $satuan,
                        ]
                    );
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Data Tabel {$tableCode} Tahun {$year} berhasil disimpan permanen di database!",
        ]);
    }

    /**
     * API POST: Hapus Data Excel / Reset ke Default di Database
     */
    public function apiDeleteData(Request $request)
    {
        $tableCode = $request->input('table_code', '8.1.1');
        $opdCode = $request->input('opd_code', '01');
        $year = (int) $request->input('year', 2025);

        // Hapus snapshot custom HTML pada metadata
        TabelMetadata::where('table_code', $tableCode)
            ->where('opd_code', $opdCode)
            ->where('year', $year)
            ->update([
                'table_html' => null,
                'source_type' => 'database',
            ]);

        // Jika Tabel 8.1.1 direset/dihapus, kembalikan data ke nilai resmi BPS asli
        if ($tableCode === '8.1.1') {
            $officialData = [
                2020 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92'],
                2021 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92'],
                2022 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92'],
                2023 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48'],
                2024 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48'],
                2025 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48'],
            ];

            $labels = [
                'negara' => '1. Negara / State',
                'provinsi' => '2. Provinsi / Province',
                'kota' => '3. Kota / Municipality',
                'total' => 'Jumlah / Total',
            ];

            foreach ($officialData as $y => $row) {
                foreach ($row as $k => $v) {
                    TabelData::updateOrCreate(
                        ['table_code' => '8.1.1', 'opd_code' => $opdCode, 'year' => $y, 'row_key' => $k],
                        ['row_label' => $labels[$k], 'value' => $v, 'satuan' => 'km']
                    );
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Data Tabel {$tableCode} tahun {$year} berhasil dikembalikan ke data default resmi.",
        ]);
    }

    /**
     * Helper: Memuat Data Store dari Database MySQL
     */
    private function loadDbDataStore(string $tableCode, string $opdCode): array
    {
        $records = TabelData::where('table_code', $tableCode)
            ->where('opd_code', $opdCode)
            ->orderBy('year')
            ->orderBy('order_index')
            ->get();

        $store = [];
        foreach ($records as $rec) {
            $y = (int) $rec->year;
            if (!isset($store[$y])) {
                $store[$y] = [];
            }
            $store[$y][$rec->row_key] = $rec->value;
        }

        return $store;
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
            $intPart = substr($intPart, 1);
        }

        $len = strlen($intPart);
        if ($len > 3) {
            $reversed = strrev($intPart);
            $chunks = str_split($reversed, 3);
            $formattedInt = strrev(implode('.', $chunks));
        } else {
            $formattedInt = $intPart;
        }

        return $sign . $formattedInt . $decPart;
    }

    /**
     * Otomatis membuat template kosong pada tahun-tahun lain di database jika belum ada data tersimpan
     */
    private function syncTemplateToOtherYears(string $tableCode, string $opdCode, int $sourceYear, string $html, ?string $titleId, ?string $titleEn, ?string $source, ?string $note): void
    {
        if ($source) {
            $source = preg_replace('/^\s*(?:sumber\s*[\/:]\s*source|sumber\s*[\/:]|source\s*[\/:]|sumber|source)\s*:\s*/i', '', $source);
            $source = trim($source);
        }
        $years = range(2021, 2036);
        $cleanHtml = $this->buildEmptyTemplateFromHtml($html);

        foreach ($years as $targetYear) {
            if ($targetYear === $sourceYear) continue;

            $existing = TabelMetadata::where('table_code', $tableCode)
                ->where('opd_code', $opdCode)
                ->where('year', $targetYear)
                ->first();

            // Jika belum ada data atau table_html kosong, isi template
            if (!$existing || empty($existing->table_html) || $existing->source_type === 'template') {
                $yHtml = $this->adjustYearInHtml($cleanHtml, $sourceYear, $targetYear);
                $yTitleId = $this->adjustYearInTitle($titleId, $sourceYear, $targetYear);
                $yTitleEn = $this->adjustYearInTitle($titleEn, $sourceYear, $targetYear);
                $yNote = $this->adjustYearInNote($note, $sourceYear, $targetYear);

                TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $targetYear,
                    ],
                    [
                        'title_id' => $yTitleId,
                        'title_en' => $yTitleEn,
                        'source' => $source,
                        'note' => $yNote,
                        'table_html' => $yHtml,
                        'source_type' => 'template',
                        'is_saved' => true,
                    ]
                );
            }
        }
    }

    private function buildEmptyTemplateFromHtml(string $html): string
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $xpath = new \DOMXPath($dom);
        $tbodyRows = $xpath->query('//tbody/tr');

        foreach ($tbodyRows as $tr) {
            $tds = $xpath->query('td', $tr);
            foreach ($tds as $cIdx => $td) {
                if ($cIdx === 0) continue;
                $colspan = (int) $td->getAttribute('colspan');
                $rawText = trim($td->textContent);
                if ($colspan >= 2 && preg_match('/[a-zA-Z]{3,}/', $rawText)) continue;
                if ($td->hasAttribute('rowspan') && preg_match('/[a-zA-Z]{3,}/', $rawText)) continue;
                // Lindungi label tahun khusus (misal: 2022(SIUP)) agar tidak diubah menjadi '-'
                if (preg_match('/^(19|20)\d{2}\s*\(SIUP\)$/', $rawText)) continue;
                $isPureNumberOrDash = preg_match('/^[\d.,\s\-%–—()]+$/', $rawText) || $rawText === '';
                if ($isPureNumberOrDash) {
                    while ($td->hasChildNodes()) {
                        $td->removeChild($td->firstChild);
                    }
                    $span = $dom->createElement('span', '-');
                    $span->setAttribute('class', 'text-slate-400 font-normal');
                    $td->appendChild($span);
                    $cls = $td->getAttribute('class');
                    $cls = preg_replace('/\btext-(left|right)\b/', '', $cls) . ' text-center align-middle';
                    $td->setAttribute('class', trim($cls));
                }
            }
        }

        $div = $xpath->query('/div')->item(0);
        $clean = '';
        if ($div) {
            foreach ($div->childNodes as $child) {
                $clean .= $dom->saveHTML($child);
            }
        }
        return $clean ?: $html;
    }

    /**
     * Membangun HTML bersih dan akurat untuk Tabel 11.2 (Dinas PMPTSP - NIB Menurut Sektor)
     * dengan rentang 6 tahun historis pada bagian Jumlah: [year, year-1, ..., year-5]
     */
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

    private function adjustYearInTitle(?string $title, int $sourceYear, int $targetYear): ?string
    {
        if (!$title) return $title;

        // Jika memuat newline, pisahkan dan proses tiap baris
        if (str_contains($title, "\n")) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $title))));
            $adjusted = array_map(function($line) use ($sourceYear, $targetYear) {
                return $this->adjustYearInTitle($line, $sourceYear, $targetYear);
            }, $lines);
            return implode("\n", $adjusted);
        }

        $delta = $targetYear - $sourceYear;

        // 1. Pola tahun ajaran sekolah (misal: "2024/2025" -> "2025/2026")
        if (preg_match('/\b(19\d{2}|20\d{2})\s*\/\s*(19\d{2}|20\d{2})\b/', $title)) {
            return preg_replace_callback('/\b(19\d{2}|20\d{2})\s*\/\s*(19\d{2}|20\d{2})\b/', function($m) use ($delta) {
                $y1 = (int)$m[1] + $delta;
                $y2 = (int)$m[2] + $delta;
                return "{$y1}/{$y2}";
            }, $title);
        }

        // 2. Pola rentang multi-tahun (misal: "2021–2025" atau "2021-2025")
        if (preg_match('/\b(19\d{2}|20\d{2})\s*[–\-]\s*(19\d{2}|20\d{2})\b/u', $title)) {
            return preg_replace_callback('/\b(19\d{2}|20\d{2})\s*[–\-]\s*(19\d{2}|20\d{2})\b/u', function($m) use ($delta) {
                $y1 = (int)$m[1] + $delta;
                $y2 = (int)$m[2] + $delta;
                return "{$y1}–{$y2}";
            }, $title);
        }

        // 3. Nama bulan sebelum tahun (misal: "Desember 2025" -> "Desember 2026")
        $monthPattern = '/\b(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|May|June|July|August|October|December)\s+' . $sourceYear . '\b/i';
        if (preg_match($monthPattern, $title)) {
            return preg_replace_callback($monthPattern, function($m) use ($targetYear) {
                $words = preg_split('/\s+/', $m[0]);
                return $words[0] . ' ' . $targetYear;
            }, $title);
        }

        // 4. Pola tahun tunggal di akhir: ", 2025" -> ", 2026"
        $pattern = '/,\s*' . $sourceYear . '\s*$/';
        if (preg_match($pattern, $title)) {
            return preg_replace($pattern, ", {$targetYear}", $title);
        }

        // 5. Ganti tahun 4 digit sumber jika cocok
        return str_replace((string)$sourceYear, (string)$targetYear, $title);
    }

    private function adjustYearInHtml(string $html, int $sourceYear, int $targetYear): string
    {
        $delta = $targetYear - $sourceYear;

        return preg_replace_callback('/<th([^>]*)>(.*?)<\/th>/is', function ($matches) use ($sourceYear, $targetYear, $delta) {
            $attr = $matches[1];
            $inner = $matches[2];

            // 1. Tahun ajaran: 2022/2023 -> 2023/2024
            if (preg_match('/\b(19\d{2}|20\d{2})\s*\/\s*(19\d{2}|20\d{2})\b/', $inner)) {
                $newInner = preg_replace_callback('/\b(19\d{2}|20\d{2})\s*\/\s*(19\d{2}|20\d{2})\b/', function($m) use ($delta) {
                    $y1 = (int)$m[1] + $delta;
                    $y2 = (int)$m[2] + $delta;
                    return "{$y1}/{$y2}";
                }, $inner);
                return "<th{$attr}>{$newInner}</th>";
            }

            // 2. Rentang tahun: 2021–2025 -> 2022–2026
            if (preg_match('/\b(19\d{2}|20\d{2})\s*[–\-]\s*(19\d{2}|20\d{2})\b/u', $inner)) {
                $newInner = preg_replace_callback('/\b(19\d{2}|20\d{2})\s*[–\-]\s*(19\d{2}|20\d{2})\b/u', function($m) use ($delta) {
                    $y1 = (int)$m[1] + $delta;
                    $y2 = (int)$m[2] + $delta;
                    return "{$y1}–{$y2}";
                }, $inner);
                return "<th{$attr}>{$newInner}</th>";
            }

            // 3. Tahun tunggal 4 digit di dalam <th>
            if (preg_match('/\b(19\d{2}|20\d{2})\b/', $inner, $m)) {
                $newInner = preg_replace_callback('/\b(19\d{2}|20\d{2})\b/', function($m) use ($delta) {
                    $y = (int)$m[0] + $delta;
                    return (string)$y;
                }, $inner);
                return "<th{$attr}>{$newInner}</th>";
            }

            return "<th{$attr}>{$inner}</th>";
        }, $html);
    }

    private function adjustYearInNote(?string $note, int $sourceYear, int $targetYear): ?string
    {
        if (!$note) return $note;
        return str_replace((string)$sourceYear, (string)$targetYear, $note);
    }

    /**
     * API JSON: Ambil daftar tabel kustom yang ditambahkan pengguna
     */
    public function apiGetCustomCatalog(Request $request)
    {
        $opdCode = $request->query('opd');
        $type = $request->query('type', 'opd');
        $sourceTypes = match($type) {
            'instansi' => ['custom_instansi'],
            'bps' => ['custom_bps', 'bps'],
            default => ['custom', 'custom_opd']
        };

        $query = TabelMetadata::whereIn('source_type', $sourceTypes);
        if ($opdCode) {
            $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            $query->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
        }

        $tables = $query->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();

        return response()->json([
            'success' => true,
            'tables' => $tables,
        ]);
    }

    /**
     * API POST: Simpan tabel kustom baru ke database (HANYA ADMINISTRATOR BPS)
     */
    public function apiSaveCustomCatalog(Request $request)
    {
        // Pastikan hanya Administrator BPS yang dapat menambahkan tabel baru
        if (session('user.role') !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak: Hanya Administrator BPS yang berwenang menambahkan tabel baru.',
            ], 403);
        }

        $request->validate([
            'table_code' => 'required|string|max:50',
            'opd_code' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
        ]);

        $tableCode = trim($request->input('table_code'));
        $rawOpdCode = trim($request->input('opd_code'));
        $opdCode = str_pad($rawOpdCode, 2, '0', STR_PAD_LEFT);
        $titleId = trim($request->input('title'));
        $titleEn = trim($request->input('title_en')) ?: $titleId;
        $type = $request->input('type', 'opd');
        $sourceType = match($type) {
            'instansi' => 'custom_instansi',
            'bps' => 'custom_bps',
            default => 'custom'
        };

        $years = [2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028];
        foreach ($years as $yr) {
            $starterHtml = $this->buildStarterCustomTableHtml($yr);

            TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $yr,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source_type' => $sourceType,
                    'table_html' => $starterHtml,
                    'is_saved' => true,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Tabel baru berhasil ditambahkan oleh Administrator BPS.',
            'table' => [
                'code' => $tableCode,
                'opd_code' => $opdCode,
                'title' => $titleId,
                'titleEn' => $titleEn,
                'isCustom' => true,
                'type' => $type,
            ],
        ]);
    }

    /**
     * Generate HTML tabel awal standar BPS untuk tabel kustom baru
     */
    private function buildStarterCustomTableHtml(int $year): string
    {
        return '<table class="w-full text-left text-xs sm:text-sm border-collapse table-custom-border" id="dataDisplayTable">' .
            '<thead>' .
                '<tr class="bg-[#f95a00] text-white text-center font-bold">' .
                    '<th class="py-3 px-4 font-bold border border-slate-700 w-16">No</th>' .
                    '<th class="py-3 px-4 font-bold border border-slate-700 text-left">' .
                        '<div>Rincian Indikator / Kategori Data</div>' .
                        '<div class="italic font-normal text-[11px] sm:text-xs">Indicator Details / Data Category</div>' .
                    '</th>' .
                    '<th class="py-3 px-4 font-bold border border-slate-700 w-44">' .
                        '<div>Capaian Nilai (' . $year . ')</div>' .
                        '<div class="italic font-normal text-[11px] sm:text-xs">Achievement Value (' . $year . ')</div>' .
                    '</th>' .
                    '<th class="py-3 px-4 font-bold border border-slate-700 w-32">' .
                        '<div>Satuan</div>' .
                        '<div class="italic font-normal text-[11px] sm:text-xs">Unit</div>' .
                    '</th>' .
                '</tr>' .
                '<tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' .
                    '<th class="py-1 px-3 border border-slate-700">(1)</th>' .
                    '<th class="py-1 px-3 border border-slate-700 text-left">(2)</th>' .
                    '<th class="py-1 px-3 border border-slate-700">(3)</th>' .
                    '<th class="py-1 px-3 border border-slate-700">(4)</th>' .
                '</tr>' .
            '</thead>' .
            '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' .
                '<tr>' .
                    '<td class="py-2.5 px-4 text-center border border-slate-700 font-bold">1</td>' .
                    '<td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Indikator 1</td>' .
                    '<td class="py-2.5 px-4 text-center border border-slate-700">-</td>' .
                    '<td class="py-2.5 px-4 text-center border border-slate-700">-</td>' .
                '</tr>' .
            '</tbody>' .
        '</table>';
    }

    /**
     * API POST: Hapus tabel kustom dari katalog database (HANYA ADMINISTRATOR BPS)
     */
    public function apiDeleteCustomCatalog(Request $request)
    {
        // Pastikan hanya Administrator BPS yang dapat menghapus tabel
        if (session('user.role') !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak: Hanya Administrator BPS yang berwenang menghapus tabel.',
            ], 403);
        }

        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $type = $request->input('type', 'opd');
        $sourceTypes = match($type) {
            'instansi' => ['custom_instansi'],
            'bps' => ['custom_bps', 'bps'],
            default => ['custom', 'custom_opd']
        };

        if ($tableCode && $opdCode) {
            $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            TabelMetadata::where('table_code', $tableCode)
                ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
                ->whereIn('source_type', $sourceTypes)
                ->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Tabel kustom berhasil dihapus.',
        ]);
    }

    /**
     * API GET: Ambil daftar catatan / komentar rincian data tabel
     */
    public function apiGetComments(Request $request)
    {
        $tableCode = $request->query('table_code');
        $opdCode = $request->query('opd_code');
        $year = (int) $request->query('year');

        $query = TabelComment::query();

        if ($tableCode) {
            $query->where('table_code', $tableCode);
        }
        if ($opdCode) {
            $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            $query->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
        }
        if ($year) {
            $query->where('year', $year);
        }

        $comments = $query->orderBy('created_at', 'asc')->get();
        $grouped = $comments->groupBy('cell_key');

        return response()->json([
            'status' => 'success',
            'comments' => $comments,
            'grouped' => $grouped,
            'count' => $comments->count(),
        ]);
    }

    /**
     * API POST: Tambah catatan / komentar baru pada rincian data tertentu
     */
    public function apiSaveComment(Request $request)
    {
        $request->validate([
            'table_code' => 'required|string',
            'opd_code' => 'required|string',
            'year' => 'required|integer',
            'cell_key' => 'required|string',
            'comment' => 'required|string|max:2000',
        ]);

        $userName = session('user.displayName') 
            ?? session('user.name') 
            ?? session('user.roleLabel') 
            ?? 'Pengguna';
            
        $userRole = session('user.role', 'opd');

        $comment = TabelComment::create([
            'table_code' => $request->table_code,
            'opd_code' => $request->opd_code,
            'year' => (int) $request->year,
            'cell_key' => $request->cell_key,
            'cell_label' => $request->cell_label ?? $request->cell_key,
            'cell_value' => $request->cell_value,
            'user_name' => $userName,
            'user_role' => $userRole,
            'comment' => trim($request->comment),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Catatan berhasil ditambahkan.',
            'data' => $comment,
        ]);
    }

    /**
     * API DELETE: Hapus catatan
     */
    public function apiDeleteComment($id)
    {
        $comment = TabelComment::find($id);
        if (!$comment) {
            return response()->json(['status' => 'error', 'message' => 'Catatan tidak ditemukan.'], 404);
        }

        $comment->delete();
        return response()->json(['status' => 'success', 'message' => 'Catatan berhasil dihapus.']);
    }

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

    /**
     * Workflow Verifikasi: Dinas Mengajukan Data Tabel ke BPS
     */
    public function apiSubmitVerification(Request $request)
    {
        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $year = (int) $request->input('year', 2025);
        $type = $request->input('type', 'opd');

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->where('year', $year)
            ->first();

        if (!$meta) {
            $meta = $this->getOrCreateMetadata($tableCode, $opdCode, $year);
        }

        if ($meta) {
            $meta->verification_status = 'submitted';
            $meta->is_saved = true;
            $meta->rejection_notes = null;
            $meta->save();
        }

        // Sinkronisasi otomatis ke Tahap 3 (Verifikasi BPS) di Monitoring
        if (in_array($type, ['opd', 'instansi'])) {
            \App\Models\MonitoringStage::updateOrCreate(
                [
                    'agency_type' => $type,
                    'agency_code' => $cleanOpd,
                    'year' => $year,
                ],
                [
                    'stage' => 3,
                    'status_text' => 'Verifikasi',
                    'notes' => 'Tabel ' . $tableCode . ' diajukan oleh dinas untuk diverifikasi BPS.',
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Data tabel berhasil diajukan! Status kini "Menunggu Verifikasi BPS".',
            'status' => 'submitted',
        ]);
    }

    /**
     * Workflow Verifikasi: Admin BPS Menyetujui (ACC) Data Tabel
     */
    public function apiApproveVerification(Request $request)
    {
        if (session('user.role') !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya Admin BPS yang berhak menyetujui (ACC) data tabel.'], 403);
        }

        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $year = (int) $request->input('year', 2025);
        $type = $request->input('type', 'opd');

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->where('year', $year)
            ->first();

        if (!$meta) {
            $meta = $this->getOrCreateMetadata($tableCode, $opdCode, $year);
        }

        $adminName = session('user.displayName', 'Admin BPS Bukittinggi');
        if ($meta) {
            $meta->verification_status = 'verified';
            $meta->is_locked = true;
            $meta->verified_at = now();
            $meta->verified_by = $adminName;
            $meta->rejection_notes = null;
            $meta->save();
        }

        // Sinkronisasi otomatis ke Tahap 4 (Validasi BPS Selesai / Siap Integrasi) di Monitoring
        if (in_array($type, ['opd', 'instansi'])) {
            \App\Models\MonitoringStage::updateOrCreate(
                [
                    'agency_type' => $type,
                    'agency_code' => $cleanOpd,
                    'year' => $year,
                ],
                [
                    'stage' => 4,
                    'status_text' => 'Validasi BPS',
                    'notes' => 'Tabel ' . $tableCode . ' telah disetujui (ACC) oleh ' . $adminName . '.',
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Data tabel berhasil di-ACC dan dikunci!',
            'status' => 'verified',
            'verified_by' => $adminName,
            'verified_at' => now()->translatedFormat('d F Y H:i'),
        ]);
    }

    /**
     * Workflow Verifikasi: Admin BPS Meminta Revisi / Catatan Perbaikan
     */
    public function apiRejectVerification(Request $request)
    {
        if (session('user.role') !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya Admin BPS yang berhak meminta revisi data tabel.'], 403);
        }

        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $year = (int) $request->input('year', 2025);
        $type = $request->input('type', 'opd');
        $notes = $request->input('notes', 'Mohon periksa kembali kelengkapan dan kewajaran angka pada tabel ini.');

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->where('year', $year)
            ->first();

        if (!$meta) {
            $meta = $this->getOrCreateMetadata($tableCode, $opdCode, $year);
        }

        if ($meta) {
            $meta->verification_status = 'revision';
            $meta->is_locked = false;
            $meta->rejection_notes = $notes;
            $meta->save();
        }

        // Sinkronisasi otomatis ke Tahap 2 (Input Data / Perlu Revisi) di Monitoring
        if (in_array($type, ['opd', 'instansi'])) {
            \App\Models\MonitoringStage::updateOrCreate(
                [
                    'agency_type' => $type,
                    'agency_code' => $cleanOpd,
                    'year' => $year,
                ],
                [
                    'stage' => 2,
                    'status_text' => 'Perlu Revisi',
                    'notes' => $notes,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Catatan revisi berhasil dikirim ke dinas!',
            'status' => 'revision',
            'rejection_notes' => $notes,
        ]);
    }

    /**
     * Workflow Verifikasi: Admin BPS Membuka Kunci (Unlock) Tabel
     */
    public function apiUnlockTable(Request $request)
    {
        if (session('user.role') !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya Admin BPS yang berhak membuka kunci tabel.'], 403);
        }

        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $year = (int) $request->input('year', 2025);

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->where('year', $year)
            ->first();

        if ($meta) {
            $meta->is_locked = false;
            $meta->verification_status = 'draft';
            $meta->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Kunci tabel berhasil dibuka! Dinas dapat mengedit kembali.',
            'status' => 'draft',
            'is_locked' => false,
        ]);
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
}
