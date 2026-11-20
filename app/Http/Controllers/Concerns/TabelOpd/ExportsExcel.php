<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

use App\Models\TabelMetadata;
use App\Exports\TableOpdExport;
use App\Exports\AgencyTablesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

/**
 * Trait untuk fungsionalitas ekspor tabel ke Excel (.xlsx).
 */
trait ExportsExcel
{
    /**
     * Export Tabel OPD ke Microsoft Excel (.xlsx) menggunakan Laravel Excel (Maatwebsite\Excel)
     */
    public function exportExcel(Request $request)
    {
        $tableCode = $request->query('code', $request->query('table', '8.1.1'));
        $opdCode = $request->query('opd', '01');
        $year = (int) $request->query('year', 2025);
        $type = $request->query('type', 'opd');
        $isTemplate = (bool) $request->query('template', 0);

        [$opdCode, $type] = $this->normalizeAgency($tableCode, $opdCode, $type);

        $meta = $this->getOrCreateMetadata($tableCode, $opdCode, $year, $type);
        if (!$meta || empty($meta->table_html) || str_contains($meta->table_html, 'Indicator Details')) {
            $fallback = TabelMetadata::where('table_code', $tableCode)
                ->whereNotNull('table_html')
                ->where('table_html', '!=', '')
                ->where('table_html', 'not like', '%Indicator Details%')
                ->where('table_html', 'not like', '%Belum ada data untuk tabel ini%')
                ->orderByRaw("ABS(year - {$year}) ASC")
                ->first();
            if ($fallback) {
                $meta = $fallback;
            }
        }

        $cleanTableCode = str_replace('.', '_', $tableCode);
        $fileName = ($isTemplate ? "Template_Tabel_{$cleanTableCode}_{$year}.xlsx" : "Tabel_{$cleanTableCode}_{$year}.xlsx");

        return Excel::download(
            new TableOpdExport(
                $tableCode,
                $opdCode,
                $year,
                $meta?->title_id,
                $meta?->title_en,
                $meta?->source,
                $meta?->note,
                $meta?->table_html,
                $isTemplate
            ),
            $fileName
        );
    }

    /**
     * Export Seluruh Tabel milik sebuah OPD / Instansi ke dalam 1 berkas Excel (.xlsx) dengan multi-sheet
     */
    public function exportAgencyExcel(Request $request)
    {
        $opdCode = $request->query('opd', $request->query('code', '01'));
        $year = (int) $request->query('year', date('Y'));
        $type = $request->query('type', 'opd');
        $isTemplate = (bool) $request->query('template', 0);

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);

        // 1. Ambil daftar kode tabel resmi khusus untuk tipe dan kode OPD/Instansi ini
        $catalog = config("sibingka_tables.{$type}", []);
        $officialTables = $catalog[$cleanOpd] ?? [];

        // Map seluruh tabel resmi dari kategori lain untuk mencegah kontaminasi silang
        $allOfficialBpsTables = [];
        foreach (config('sibingka_tables.bps', []) as $tbls) {
            foreach ($tbls as $t) $allOfficialBpsTables[$t] = true;
        }

        $allOfficialInstansiTables = [];
        foreach (config('sibingka_tables.instansi', []) as $tbls) {
            foreach ($tbls as $t) $allOfficialInstansiTables[$t] = true;
        }

        $allOfficialOpdTables = [];
        foreach (config('sibingka_tables.opd', []) as $c => $tbls) {
            foreach ($tbls as $t) $allOfficialOpdTables[$t] = true;
        }

        // 2. Ambil tabel dinamis / kustom murni milik instansi ini
        $customTablesQuery = TabelMetadata::where('opd_code', $cleanOpd)
            ->where('year', $year)
            ->where('source_type', '!=', 'deleted');

        if ($type === 'opd') {
            $customTablesQuery->where(function($q) {
                $q->where('source_type', 'like', '%opd%')
                  ->orWhereNull('source_type');
            })
            ->where('source_type', 'not like', '%bps%')
            ->where('source_type', 'not like', '%instansi%');
        } elseif ($type === 'instansi') {
            $customTablesQuery->where('source_type', 'like', '%instansi%')
                ->where('source_type', 'not like', '%bps%');
        } elseif ($type === 'bps') {
            $customTablesQuery->where('source_type', 'like', '%bps%');
        }

        $customTables = $customTablesQuery->pluck('table_code')->toArray();

        // Filter ketat: buang tabel yang merupakan milik BPS atau kategori lain
        if ($type === 'opd') {
            $customTables = array_filter($customTables, function($t) use ($allOfficialBpsTables, $allOfficialInstansiTables, $officialTables) {
                if (in_array($t, $officialTables, true)) return true;
                if (isset($allOfficialBpsTables[$t]) || isset($allOfficialInstansiTables[$t])) return false;
                return true;
            });
        } elseif ($type === 'instansi') {
            $customTables = array_filter($customTables, function($t) use ($allOfficialBpsTables, $allOfficialOpdTables, $officialTables) {
                if (in_array($t, $officialTables, true)) return true;
                if (isset($allOfficialBpsTables[$t]) || isset($allOfficialOpdTables[$t])) return false;
                return true;
            });
        }

        $allTableCodes = array_values(array_unique(array_merge($officialTables, $customTables)));
        natsort($allTableCodes);

        $opdList = config('sibingka.opd_list', []);
        $instansiList = config('sibingka.instansi_list', []);
        
        $agencyInfo = $type === 'instansi' 
            ? ($instansiList[$cleanOpd] ?? null) 
            : ($opdList[$cleanOpd] ?? null);
            
        $agencyName = $agencyInfo['short_name'] ?? ($agencyInfo['name'] ?? "OPD_{$cleanOpd}");
        $cleanAgencyName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $agencyName);

        $sheets = [];

        foreach ($allTableCodes as $tableCode) {
            $metaQuery = TabelMetadata::where('table_code', $tableCode)
                ->where('year', $year);

            if ($type === 'opd') {
                $metaQuery->where(function($q) use ($cleanOpd) {
                    $q->where('opd_code', $cleanOpd)
                      ->orWhere('source_type', 'like', '%opd%');
                })
                ->where('source_type', 'not like', '%bps%')
                ->where('source_type', 'not like', '%instansi%');
            } elseif ($type === 'instansi') {
                $metaQuery->where('opd_code', $cleanOpd)
                    ->where('source_type', 'not like', '%bps%');
            } else {
                $metaQuery->where('opd_code', $cleanOpd);
            }

            $meta = $metaQuery->first();

            // Jika belum ada di tahun terpilih, cari fallback snapshot dari tahun terdekat
            if (!$meta || empty($meta->table_html) || str_contains($meta->table_html, 'Indicator Details')) {
                $fallbackQuery = TabelMetadata::where('table_code', $tableCode)
                    ->whereNotNull('table_html')
                    ->where('table_html', '!=', '')
                    ->where('table_html', 'not like', '%Indicator Details%')
                    ->where('table_html', 'not like', '%Belum ada data untuk tabel ini%');

                if ($type === 'opd') {
                    $fallbackQuery->where('source_type', 'not like', '%bps%')
                        ->where('source_type', 'not like', '%instansi%');
                } elseif ($type === 'instansi') {
                    $fallbackQuery->where('source_type', 'not like', '%bps%');
                }

                $meta = $fallbackQuery->orderByRaw("ABS(year - {$year}) ASC")->first();
            }

            // Jika masih belum ada di database, buat template resmi
            if (!$meta || empty($meta->table_html)) {
                $meta = $this->getOrCreateMetadata($tableCode, $cleanOpd, $year, $type);
            }

            $sheets[] = new TableOpdExport(
                $tableCode,
                $cleanOpd,
                $year,
                $meta?->title_id,
                $meta?->title_en,
                $meta?->source,
                $meta?->note,
                $meta?->table_html,
                $isTemplate
            );
        }

        if (empty($sheets)) {
            $sheets[] = new TableOpdExport(
                '0',
                $cleanOpd,
                $year,
                "Belum Ada Tabel Terdaftar",
                null,
                'BPS Kota Bukittinggi',
                null,
                '<table><tr><td>Belum ada data tabel yang terdaftar untuk ' . htmlspecialchars($agencyName) . ' pada tahun ' . $year . '</td></tr></table>',
                true
            );
        }

        $fileName = ($isTemplate ? "Template_Excel_{$cleanAgencyName}_{$year}.xlsx" : "Data_Excel_{$cleanAgencyName}_{$year}.xlsx");

        return Excel::download(
            new AgencyTablesExport($sheets),
            $fileName
        );
    }
}
