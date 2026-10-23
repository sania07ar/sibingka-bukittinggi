<?php

namespace App\Http\Controllers;

use App\Models\TabelData;
use App\Models\TabelMetadata;
use Illuminate\Http\Request;

class TabelOpdController extends Controller
{
    /**
     * Tampilkan Halaman Tabel OPD dengan Data dari Database
     */
    public function index(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $year = (int) $request->query('year', 2025);
        $type = $request->query('type', 'opd');

        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year);

        return view('tabel.index', [
            'currentTableCode' => $tableCode,
            'currentOpdCode' => $opdCode,
            'currentYear' => $year,
            'currentType' => $type,
            'dbDataStore' => $dbDataStore,
            'dbMetadata' => $dbMetadata,
            'dbFallbackMetadata' => null,
        ]);
    }

    /**
     * Tampilkan Halaman Edit Tabel OPD dengan Data dari Database
     */
    public function edit(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $year = (int) $request->query('year', 2025);
        $type = $request->query('type', 'opd');

        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year);

        return view('tabel.edit', [
            'currentTableCode' => $tableCode,
            'currentOpdCode' => $opdCode,
            'currentYear' => $year,
            'currentType' => $type,
            'dbDataStore' => $dbDataStore,
            'dbMetadata' => $dbMetadata,
            'dbFallbackMetadata' => null,
        ]);
    }

    /**
     * API JSON: Ambil Data dari Database berdasarkan Kode Tabel & OPD
     */
    public function apiGetData(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $year = (int) $request->query('year', 2025);

        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year);

        return response()->json([
            'success' => true,
            'table_code' => $tableCode,
            'opd_code' => $opdCode,
            'year' => $year,
            'dataStore' => $dbDataStore,
            'metadata' => $dbMetadata,
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

        if ($dbMetadata && !empty($dbMetadata->table_html)) {
            // Untuk tabel multi-tahun (8.1.x, 2.2.5, 1.1.10), pastikan table_html memuat tahun awal dan tahun akhir rentang 5 tahun
            $isMultiYear = str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['2.2.5', '1.1.10']);
            if ($isMultiYear) {
                $startYr = (string)($year - 4);
                $endYr = (string)$year;
                if (!str_contains($dbMetadata->table_html, $startYr) || !str_contains($dbMetadata->table_html, $endYr)) {
                    return null;
                }
            }
            return $dbMetadata;
        }

        // Tabel multi-tahun (8.1.1, 8.1.2, 8.1.3, 8.1.4, 8.1.5, 2.2.5, 1.1.10) membangun rentang 5 tahun secara dinamis.
        // Jangan pernah meminjam metadata/HTML dari tahun lain karena kolom tahunnya akan keliru.
        if (str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['2.2.5', '1.1.10'])) {
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
        $year = (int) $request->input('year', 2025);
        $tableHtml = $request->input('table_html');
        $titleId = $request->input('title_id');
        $titleEn = $request->input('title_en');
        $source = $request->input('source');
        $note = $request->input('note');
        $sourceType = $request->input('source_type', 'database');
        $rowsData = $request->input('rows_data'); // format: [year => [row_key => value]]

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
        if ($tableHtml && !str_starts_with($tableCode, '8.1.') && !in_array($tableCode, ['1.1.10', '2.2.5'])) {
            $this->syncTemplateToOtherYears($tableCode, $opdCode, $year, $tableHtml, $titleId, $titleEn, $source, $note);
        }

        // Jika multi-tahun, tandai juga tahun-tahun lain yang ada datanya dengan range tahun yang sesuai
        if (is_array($rowsData)) {
            foreach (array_keys($rowsData) as $otherYear) {
                $oYear = (int) $otherYear;
                if ($oYear > 0 && $oYear !== $year) {
                    $oTitleId = $titleId;
                    $oTitleEn = $titleEn;
                    if (str_starts_with($tableCode, '8.1.') && $oTitleId) {
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
                // Lindungi label tahun (misal: 2024, 2025, 2022(SIUP)) agar tidak diubah menjadi '-'
                if (preg_match('/^(19|20)\d{2}(\s*\(SIUP\))?$/', $rawText)) continue;
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

        // 1. Cek jika ada nama bulan sebelum tahun (misal: "Desember 2021" -> "Desember 2019")
        $monthPattern = '/\b(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|May|June|July|August|October|December)\s+' . $sourceYear . '\b/i';
        if (preg_match($monthPattern, $title)) {
            return preg_replace_callback($monthPattern, function($m) use ($targetYear) {
                $words = preg_split('/\s+/', $m[0]);
                return $words[0] . ' ' . $targetYear;
            }, $title);
        }

        // 2. Pola tahun di akhir: ", 2021" -> ", 2019"
        $pattern = '/,\s*' . $sourceYear . '\s*$/';
        if (preg_match($pattern, $title)) {
            return preg_replace($pattern, ", {$targetYear}", $title);
        }

        // 3. Ganti tahun 4 digit sumber jika cocok
        return str_replace((string)$sourceYear, (string)$targetYear, $title);
    }

    private function adjustYearInHtml(string $html, int $sourceYear, int $targetYear): string
    {
        return preg_replace_callback('/<th([^>]*)>(.*?)<\/th>/is', function ($matches) use ($sourceYear, $targetYear) {
            $attr = $matches[1];
            $inner = $matches[2];
            $regex = '/\b' . $sourceYear . '\b/';
            $newInner = preg_replace($regex, (string)$targetYear, $inner);
            return "<th{$attr}>{$newInner}</th>";
        }, $html);
    }

    private function adjustYearInNote(?string $note, int $sourceYear, int $targetYear): ?string
    {
        if (!$note) return $note;
        return str_replace((string)$sourceYear, (string)$targetYear, $note);
    }
}
