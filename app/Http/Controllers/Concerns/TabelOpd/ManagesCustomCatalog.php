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
 * Katalog tabel buatan sendiri (custom) milik dinas/instansi.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait ManagesCustomCatalog
{
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

        // Ambil daftar kode tabel yang telah dihapus
        $deletedQuery = TabelMetadata::where('source_type', 'deleted');
        if ($opdCode) {
            $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            $deletedQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
        }
        $deletedCodes = $deletedQuery->pluck('table_code')->unique()->values()->toArray();

        return response()->json([
            'success' => true,
            'tables' => $tables,
            'deleted_tables' => $deletedCodes,
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

        // Hapus penanda 'deleted' jika tabel dengan kode ini pernah dihapus
        TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $rawOpdCode]))
            ->where('source_type', 'deleted')
            ->delete();

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
                    'source_type' => 'template',
                    'table_html' => $starterHtml,
                    'is_saved' => false,
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
     * API POST: Hapus tabel (kustom maupun tabel bawaan) dari katalog database (HANYA ADMINISTRATOR BPS / WALIDATA)
     */
    public function apiDeleteCustomCatalog(Request $request)
    {
        // Pastikan Administrator BPS atau Walidata yang berwenang
        $role = session('user.role');
        if (!in_array($role, ['admin', 'walidata'])) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak: Hanya Administrator yang berwenang menghapus tabel.',
            ], 403);
        }

        $tableCode = trim((string)$request->input('table_code'));
        $opdCode = trim((string)$request->input('opd_code'));
        $type = $request->input('type', 'opd');

        if ($tableCode && $opdCode) {
            $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            $opdList = array_unique([$opdCode, $cleanOpd]);

            // Hapus seluruh metadata tabel di semua tahun
            TabelMetadata::where('table_code', $tableCode)
                ->whereIn('opd_code', $opdList)
                ->delete();

            // Hapus seluruh data angka tabel di semua tahun
            TabelData::where('table_code', $tableCode)
                ->whereIn('opd_code', $opdList)
                ->delete();

            // Simpan penanda bahwa tabel ini telah dihapus (tombstone)
            TabelMetadata::create([
                'table_code' => $tableCode,
                'opd_code' => $cleanOpd,
                'year' => 0,
                'title_id' => 'Deleted Table',
                'title_en' => 'Deleted Table',
                'source_type' => 'deleted',
                'is_saved' => false,
            ]);

            // Hapus file snapshot cache di storage
            try {
                $cacheFiles = glob(storage_path("app/tables/table_*_{$cleanOpd}_{$tableCode}_*.json")) ?: [];
                foreach ($cacheFiles as $cf) {
                    @unlink($cf);
                }
            } catch (\Throwable $e) {}
        }

        return response()->json([
            'success' => true,
            'message' => "Tabel [{$tableCode}] berhasil dihapus.",
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
}
