<?php

namespace App\Http\Controllers;

use App\Models\TabelData;
use App\Models\TabelMetadata;
use App\Models\TabelComment;
use App\Exports\TableOpdExport;
use App\Imports\TableOpdImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\TabelOpd\ResolvesAgencies;
use App\Http\Controllers\Concerns\TabelOpd\HandlesExcel;
use App\Http\Controllers\Concerns\TabelOpd\AdjustsTemplateYears;
use App\Http\Controllers\Concerns\TabelOpd\ManagesCustomCatalog;
use App\Http\Controllers\Concerns\TabelOpd\ManagesComments;
use App\Http\Controllers\Concerns\TabelOpd\ManagesVerification;
use App\Http\Controllers\Concerns\TabelOpd\ManagesTableMetadata;
use App\Http\Controllers\Concerns\TabelOpd\BuildsBab1Templates;
use App\Http\Controllers\Concerns\TabelOpd\BuildsBab3Templates;
use App\Http\Controllers\Concerns\TabelOpd\BuildsBab4Templates;
use App\Http\Controllers\Concerns\TabelOpd\BuildsBab9Templates;

class TabelOpdController extends Controller
{
    use ResolvesAgencies,
        HandlesExcel,
        AdjustsTemplateYears,
        ManagesCustomCatalog,
        ManagesComments,
        ManagesVerification,
        ManagesTableMetadata,
        BuildsBab1Templates,
        BuildsBab3Templates,
        BuildsBab4Templates,
        BuildsBab9Templates;

    public function index(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $year = (int) $request->query('year', 2025);
        $type = $request->query('type', 'opd');

        [$opdCode, $type] = $this->normalizeAgency($tableCode, $opdCode, $type);

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $opdName = $this->getAgencyName($opdCode, $type);
        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year, $type);

        $dbFallbackMetadata = null;
        if ((!$dbMetadata || empty($dbMetadata->table_html) || str_contains($dbMetadata->table_html, 'Indicator Details')) && $opdCode !== '35' && $tableCode !== '8.2.7') {
            $fallbackQuery = TabelMetadata::where('table_code', $tableCode)
                ->whereNotNull('table_html')
                ->where('table_html', '!=', '')
                ->where('table_html', 'not like', '%Indicator Details%')
                ->where('table_html', 'not like', '%Belum ada data untuk tabel ini%')
                ->orderByRaw("CASE WHEN source_type NOT IN ('template') THEN 0 ELSE 1 END ASC, ABS(year - {$year}) ASC");
            if ($type === 'bps') {
                $fallbackQuery->where(function($q) use ($opdCode, $cleanOpd) {
                    $q->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
                      ->orWhere('source_type', 'like', '%bps%');
                });
            } elseif ($type === 'instansi') {
                $fallbackQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
            } else {
                $fallbackQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
            }
            $dbFallbackMetadata = $fallbackQuery->first();
            if ($dbFallbackMetadata) {
                $dbFallbackMetadata->opd_code = $opdCode;
            }
        }

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
            'opdName' => $opdName,
            'dbDataStore' => $dbDataStore,
            'dbMetadata' => $dbMetadata,
            'dbFallbackMetadata' => $dbFallbackMetadata,
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
        $year = (int) $request->query('year', 2025);
        $type = $request->query('type', 'opd');

        [$opdCode, $type] = $this->normalizeAgency($tableCode, $opdCode, $type);

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $opdName = $this->getAgencyName($opdCode, $type);
        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year, $type);

        $dbFallbackMetadata = null;
        if ((!$dbMetadata || empty($dbMetadata->table_html) || str_contains($dbMetadata->table_html, 'Indicator Details')) && $opdCode !== '35' && $tableCode !== '8.2.7') {
            $fallbackQuery = TabelMetadata::where('table_code', $tableCode)
                ->whereNotNull('table_html')
                ->where('table_html', '!=', '')
                ->where('table_html', 'not like', '%Indicator Details%')
                ->where('table_html', 'not like', '%Belum ada data untuk tabel ini%')
                ->orderByRaw("CASE WHEN source_type NOT IN ('template') THEN 0 ELSE 1 END ASC, ABS(year - {$year}) ASC");
            if ($type === 'bps') {
                $fallbackQuery->where(function($q) use ($opdCode, $cleanOpd) {
                    $q->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
                      ->orWhere('source_type', 'like', '%bps%');
                });
            } elseif ($type === 'instansi') {
                $fallbackQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
            } else {
                $fallbackQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
            }
            $dbFallbackMetadata = $fallbackQuery->first();
            if ($dbFallbackMetadata) {
                $dbFallbackMetadata->opd_code = $opdCode;
            }
        }

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
            'opdName' => $opdName,
            'dbDataStore' => $dbDataStore,
            'dbMetadata' => $dbMetadata,
            'dbFallbackMetadata' => $dbFallbackMetadata,
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
        $type = $request->query('type', 'opd');
        if ($type !== 'bps' && $type !== 'instansi') {
            $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
        }
        $year = (int) $request->query('year', 2025);

        $dbDataStore = $this->loadDbDataStore($tableCode, $opdCode);
        $dbMetadata = $this->getOrCreateMetadata($tableCode, $opdCode, $year, $type);

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $dbFallbackMetadata = null;
        if ((!$dbMetadata || empty($dbMetadata->table_html) || str_contains($dbMetadata->table_html, 'Indicator Details')) && $opdCode !== '35' && $tableCode !== '8.2.7') {
            $fallbackQuery = TabelMetadata::where('table_code', $tableCode)
                ->whereNotNull('table_html')
                ->where('table_html', '!=', '')
                ->where('table_html', 'not like', '%Indicator Details%')
                ->where('table_html', 'not like', '%Belum ada data untuk tabel ini%')
                ->orderByRaw("CASE WHEN source_type NOT IN ('template') THEN 0 ELSE 1 END ASC, ABS(year - {$year}) ASC");
            if ($type === 'bps') {
                $fallbackQuery->where(function($q) use ($opdCode, $cleanOpd) {
                    $q->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
                      ->orWhere('source_type', 'like', '%bps%');
                });
            } elseif ($type === 'instansi') {
                $fallbackQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
            } else {
                $fallbackQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
            }
            $dbFallbackMetadata = $fallbackQuery->first();
            if ($dbFallbackMetadata) {
                $dbFallbackMetadata->opd_code = $opdCode;
            }
        }

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
            'fallbackMetadata' => $dbFallbackMetadata,
        ]);
    }

    /**
     * API POST: Simpan Perubahan Data / Hasil Upload Excel ke Database
     */
    public function apiSaveData(Request $request)
    {
        $tableCode = $request->input('table_code', '8.1.1');
        $opdCode = $request->input('opd_code', '01');
        $type = $request->input('type', 'opd');
        [$opdCode, $type] = $this->normalizeAgency($tableCode, $opdCode, $type);
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
        $defaultSourceType = match($type) {
            'bps' => 'custom_bps',
            'instansi' => 'custom_instansi',
            default => 'database'
        };
        $sourceType = $request->input('source_type', $defaultSourceType);
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
            // Koreksi otomatis jika Kolom 6 muncul pada tabel kecamatan (seperti 9.4, 5.1.18, dll)
            if (str_contains($tableHtml, 'Kolom 6') || str_contains($tableHtml, 'kolom 6')) {
                if ($tableCode === '2.2.2') {
                    $tableHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>', $tableHtml);
                    $tableHtml = preg_replace('/<th([^>]*)>\s*Kolom\s*6\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>', $tableHtml);
                    $tableHtml = preg_replace('/>\s*Kolom\s*6\s*</i', '>S2/S3<', $tableHtml);
                } elseif ($tableCode === '8.1.6') {
                    $tableHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Taksi</div><div class="italic font-normal text-[11px] sm:text-xs">Taxi</div></th>', $tableHtml);
                    $tableHtml = preg_replace('/<th([^>]*)>\s*Kolom\s*6\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Taksi</div><div class="italic font-normal text-[11px] sm:text-xs">Taxi</div></th>', $tableHtml);
                    $tableHtml = preg_replace('/>\s*Kolom\s*6\s*</i', '>Taksi<', $tableHtml);
                } elseif (in_array($tableCode, ['9.4', '5.1.18']) || str_contains($tableHtml, 'Mandiangin') || str_contains($tableHtml, 'Guguk Panjang')) {
                    $tableHtml = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Aur Birugo Tigo Baleh</div></th>', $tableHtml);
                    $tableHtml = preg_replace('/<th([^>]*)>\s*Kolom\s*6\s*<\/th>/i', '<th$1>Aur Birugo Tigo Baleh</th>', $tableHtml);
                    $tableHtml = preg_replace('/>\s*Kolom\s*6\s*</i', '>Aur Birugo Tigo Baleh<', $tableHtml);
                }
            }

            // Koreksi otomatis jika Tabel 4.3.3 memuat baris Catatan di tbody
            if ($tableCode === '4.3.3') {
                if (str_contains($tableHtml, 'Transmigrasi') || str_contains($tableHtml, 'pencacahan') || str_contains($tableHtml, 'Catatan')) {
                    $tableHtml = preg_replace('/<tr[^>]*>\s*<td[^>]*>\s*(?:Catatan|&nbsp;|\-)?[\s\S]*?(?:Transmigrasi|pencacahan|Periode tahun)[\s\S]*?<\/tr>/i', '', $tableHtml);
                }
                $tableHtml = str_replace('Aur Birugo Tigo baleh', 'Aur Birugo Tigo Baleh', $tableHtml);
                if (empty($note) || strlen($note) < 50 || !str_contains($note, 'Transmigrasi')) {
                    $note = '<div class="space-y-1"><div><sup>1</sup> Desa pada tabel ini termasuk Unit Permukiman Transmigrasi (UPT) yang masih dibina oleh kementerian terkait dan nagari di Provinsi Sumatera Barat / <span class="italic text-slate-500">Villages in this table are included in Transmigration Settlement Unit which is still fostered by the relevant ministries and the nagari in the Province of Sumatera Barat</span></div><div><sup>2</sup> Kejadian dalam setahun sebelum tahun pencacahan / <span class="italic text-slate-500">Occurred during the last one year before the enumeration years</span></div><div><sup>3</sup> Periode tahun 2024 adalah Januari - April / <span class="italic text-slate-500">2024 Period is January-April</span></div></div>';
                }
            }
            $tableHtml = $this->cleanExcelDateSerials($tableHtml);
            $tableHtml = $this->formatFinancialHtml($tableHtml, $opdCode, $tableCode);

            // Pastikan tidak ada tag input formulir yang tertinggal di tableHtml yang disimpan
            if (str_contains($tableHtml, '<input')) {
                $tableHtml = preg_replace('/<input[^>]*value=["\']([^"\']*)["\'][^>]*>/i', '$1', $tableHtml);
                $tableHtml = preg_replace('/<input[^>]*>/i', '', $tableHtml);
                $tableHtml = preg_replace('/<div[^>]*class=["\'][^"\']*flex items-center justify-center[^"\']*["\'][^>]*>(.*?)<\/div>/is', '$1', $tableHtml);
            }
        }

        if (is_array($rowsData)) {
            foreach ($rowsData as $yr => &$rowMap) {
                if (is_array($rowMap)) {
                    foreach ($rowMap as $k => &$v) {
                        if (is_string($v)) {
                            $v = $this->cleanExcelDateSerials($v);
                        }
                    }
                }
            }
            unset($rowMap, $v);
        }

        $existingMeta = TabelMetadata::where('table_code', $tableCode)
            ->where('opd_code', $opdCode)
            ->where('year', $year)
            ->first();

        if ($existingMeta && in_array($existingMeta->source_type, ['custom_bps', 'custom_instansi', 'custom', 'custom_opd'])) {
            $sourceType = $existingMeta->source_type;
        } elseif ($type === 'bps') {
            $sourceType = 'custom_bps';
        } elseif ($type === 'instansi') {
            $sourceType = 'custom_instansi';
        }

        // File-based snapshot storage (resilient backup saat MySQL InnoDB dalam mode read-only / recovery)
        try {
            $cacheDir = storage_path('app/tables');
            if (!is_dir($cacheDir)) {
                @mkdir($cacheDir, 0777, true);
            }
            $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            $scopedCacheFile = "{$cacheDir}/table_{$type}_{$cleanOpd}_{$tableCode}_{$year}.json";
            $payload = json_encode([
                'table_code' => $tableCode,
                'opd_code' => $opdCode,
                'year' => $year,
                'type' => $type,
                'title_id' => $titleId ?: ($existingMeta?->title_id),
                'title_en' => $titleEn ?: ($existingMeta?->title_en),
                'source' => $source ?: ($existingMeta?->source),
                'note' => $note !== null ? $note : ($existingMeta?->note),
                'table_html' => $tableHtml ?: ($existingMeta?->table_html),
                'source_type' => $sourceType,
                'is_saved' => true,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            @file_put_contents($scopedCacheFile, $payload);
            if ($type !== 'instansi') {
                @file_put_contents("{$cacheDir}/table_{$tableCode}_{$year}.json", $payload);
            }
        } catch (\Throwable $ex) {}

        // Simpan metadata dan data nilai sel ke Database MySQL
        $dbSaved = true;
        try {
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

            // Otomatis sinkronkan template kosong ke tahun-tahun lain agar saat pengguna berpindah tahun, format tabel langsung menyesuaikan (kecuali RRI 8.2.7 yang strukturnya unik tiap tahun)
            if (!empty($tableHtml) && $opdCode !== '35' && $tableCode !== '8.2.7') {
                $this->syncTemplateToOtherYears(
                    $tableCode,
                    $opdCode,
                    $year,
                    $tableHtml,
                    $titleId ?: ($existingMeta?->title_id),
                    $titleEn ?: ($existingMeta?->title_en),
                    $source ?: ($existingMeta?->source),
                    $note !== null ? $note : ($existingMeta?->note),
                    $sourceType,
                    $type
                );
            }

            // Jika multi-tahun, tandai juga tahun-tahun lain yang ada datanya dengan range tahun yang sesuai
            if (is_array($rowsData) && (str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['8.2.2', '2.2.5', '1.1.10', '9.1', '9.3', '2.4.3', '2.4.1', '2.4.2']))) {
                foreach (array_keys($rowsData) as $otherYear) {
                    $oYear = (int) $otherYear;
                    if ($oYear > 0 && $oYear !== $year) {
                        $oTitleId = $titleId;
                        $oTitleEn = $titleEn;
                        if ((str_starts_with($tableCode, '8.1.') || in_array($tableCode, ['8.2.2', '2.2.5', '1.1.10', '9.1', '2.4.3', '2.4.1', '2.4.2'])) && $oTitleId) {
                            $span = ($tableCode === '9.3') ? 6 : (($tableCode === '2.4.1' || $tableCode === '2.4.2') ? 3 : 4);
                            $oRange = ($oYear - $span) . '–' . $oYear;
                            $cleanId = preg_replace('/([,\s]*)(?:(?:19|20)\d{2}|\d{3,4})[\s–\-]*(?:19|20)\d{2}(?:[\s–\-]*(?:19|20)\d{2})*\s*$/u', '', $titleId);
                            $oTitleId = rtrim(trim($cleanId), ',') . ", {$oRange}";
                            if ($oTitleEn) {
                                $cleanEn = preg_replace('/([,\s]*)(?:(?:19|20)\d{2}|\d{3,4})[\s–\-]*(?:19|20)\d{2}(?:[\s–\-]*(?:19|20)\d{2})*\s*$/u', '', $titleEn);
                                $oTitleEn = rtrim(trim($cleanEn), ',') . ", {$oRange}";
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
        } catch (\Throwable $e) {
            $dbSaved = false;
            \Log::warning("Peringatan apiSaveData tabel {$tableCode} (database read-only atau error): " . $e->getMessage());
        }

        // db_saved = false berarti data hanya tersimpan di cadangan file, belum masuk database.
        // Tombol di halaman memakai nilai ini agar tidak menampilkan "berhasil" dan tidak mengirim data ke Monitoring.
        return response()->json([
            'success' => true,
            'db_saved' => $dbSaved,
            'message' => $dbSaved
                ? "Data Tabel {$tableCode} Tahun {$year} berhasil disimpan permanen di database!"
                : "Data Tabel {$tableCode} Tahun {$year} belum masuk database (hanya tersimpan di cadangan file). Hubungi administrator.",
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
        $type = $request->input('type', 'opd');
        $defaultHtml = $request->input('default_html');

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $opdCodes = array_values(array_unique([$opdCode, $cleanOpd, ltrim($opdCode, '0')]));

        // Hapus file-based snapshot jika ada
        @unlink(storage_path("app/tables/table_{$type}_{$cleanOpd}_{$tableCode}_{$year}.json"));
        if ($type !== 'instansi') {
            @unlink(storage_path("app/tables/table_{$tableCode}_{$year}.json"));
        }

        // Hapus custom data baris jika ada
        TabelData::where('table_code', $tableCode)
            ->whereIn('opd_code', $opdCodes)
            ->where('year', $year)
            ->delete();

        $targetSourceType = match($type) {
            'bps' => 'custom_bps',
            'instansi' => 'custom_instansi',
            default => 'template'
        };

        // Update TabelMetadata ke nilai default resmi
        if (!empty($defaultHtml)) {
            // Pastikan defaultHtml bersih dari elemen input formulir
            $defaultHtml = preg_replace('/<input[^>]*value=["\']([^"\']*)["\'][^>]*>/i', '$1', $defaultHtml);
            $defaultHtml = preg_replace('/<input[^>]*>/i', '', $defaultHtml);
            $defaultHtml = preg_replace('/<div[^>]*class=["\'][^"\']*flex items-center justify-center[^"\']*["\'][^>]*>(.*?)<\/div>/is', '$1', $defaultHtml);

            TabelMetadata::where('table_code', $tableCode)
                ->whereIn('opd_code', $opdCodes)
                ->where('year', $year)
                ->update([
                    'table_html' => $defaultHtml,
                    'source_type' => $targetSourceType,
                    'is_saved' => false,
                ]);
        } else {
            // Jika tidak ada schema bawaan di frontend, bersihkan nilai data tbody ke '-' tanpa merusak struktur header/kolom
            $metaQuery = TabelMetadata::where('table_code', $tableCode)->where('year', $year);
            if ($type === 'bps') {
                $metaQuery->where(function($q) use ($opdCodes) {
                    $q->whereIn('opd_code', $opdCodes)->orWhere('source_type', 'like', '%bps%');
                });
            } else {
                $metaQuery->whereIn('opd_code', $opdCodes);
            }
            $meta = $metaQuery->first();

            if ($meta && !empty($meta->table_html)) {
                $cleanHtml = $this->buildEmptyTemplateFromHtml($meta->table_html);
                $meta->update([
                    'table_html' => $cleanHtml,
                    'source_type' => $targetSourceType,
                    'is_saved' => false,
                ]);
            }
        }

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
}
