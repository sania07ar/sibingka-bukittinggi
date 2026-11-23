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

        $exportHtml = $meta?->table_html;
        if (empty($exportHtml) || str_contains($exportHtml, 'Indicator Details') || str_contains($exportHtml, 'Belum ada data untuk tabel ini')) {
            $exportHtml = $this->getDefaultHtmlForTable($tableCode, $year);
        }

        return Excel::download(
            new TableOpdExport(
                $tableCode,
                $opdCode,
                $year,
                $meta?->title_id,
                $meta?->title_en,
                $meta?->source,
                $meta?->note,
                $exportHtml,
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

        $bpsDatasets = [
            '01' => ['short' => 'PODES', 'name' => 'Potensi Desa / Kelurahan'],
            '02' => ['short' => 'PENDUDUK', 'name' => 'Statistik Kependudukan & Proyeksi'],
            '03' => ['short' => 'SUSENAS', 'name' => 'Survei Sosial Ekonomi Nasional'],
            '04' => ['short' => 'SAKERNAS', 'name' => 'Survei Angkatan Kerja Nasional'],
            '05' => ['short' => 'HORTI', 'name' => 'Statistik Pertanian & Hortikultura'],
            '06' => ['short' => 'IMK', 'name' => 'Industri Mikro dan Kecil'],
            '07' => ['short' => 'HOTEL', 'name' => 'Statistik Perhotelan & Pariwisata'],
            '08' => ['short' => 'IHK & INFLASI', 'name' => 'Indeks Harga Konsumen / Inflasi'],
            '09' => ['short' => 'PDRB LAPUS', 'name' => 'PDRB Menurut Lapangan Usaha'],
            '10' => ['short' => 'PDRB PENGELUARAN', 'name' => 'PDRB Menurut Pengeluaran'],
        ];

        $isAllBps = ($type === 'bps' && ($opdCode === 'all' || empty($opdCode)));
        $cleanOpd = $isAllBps ? 'all' : str_pad($opdCode, 2, '0', STR_PAD_LEFT);

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

        if ($type === 'bps') {
            if ($isAllBps) {
                $agencyName = "Seluruh Data BPS";
                $cleanAgencyName = "Seluruh_Data_BPS";
                $officialTables = array_keys($allOfficialBpsTables);
                $customTables = TabelMetadata::where(function($q) {
                        $q->where('source_type', 'like', '%bps%')
                          ->orWhereIn('source_type', ['custom_bps', 'bps']);
                    })
                    ->where('year', $year)
                    ->where('source_type', '!=', 'deleted')
                    ->pluck('table_code')
                    ->toArray();
            } else {
                $dsInfo = $bpsDatasets[$cleanOpd] ?? null;
                $dsShort = $dsInfo['short'] ?? "Dataset_{$cleanOpd}";
                $agencyName = "BPS " . $dsShort;
                $cleanAgencyName = "BPS_" . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $dsShort);
                $catalog = config("sibingka_tables.bps", []);
                $officialTables = $catalog[$cleanOpd] ?? [];
                $customTables = TabelMetadata::where('opd_code', $cleanOpd)
                    ->where('year', $year)
                    ->where(function($q) {
                        $q->where('source_type', 'like', '%bps%')
                          ->orWhereIn('source_type', ['custom_bps', 'bps']);
                    })
                    ->where('source_type', '!=', 'deleted')
                    ->pluck('table_code')
                    ->toArray();
            }
        } elseif ($type === 'instansi') {
            $catalog = config("sibingka_tables.instansi", []);
            $officialTables = $catalog[$cleanOpd] ?? [];
            $customTablesQuery = TabelMetadata::where('opd_code', $cleanOpd)
                ->where('year', $year)
                ->where('source_type', '!=', 'deleted')
                ->where('source_type', 'like', '%instansi%')
                ->where('source_type', 'not like', '%bps%');
            $customTables = $customTablesQuery->pluck('table_code')->toArray();
            $customTables = array_filter($customTables, function($t) use ($allOfficialBpsTables, $allOfficialOpdTables, $officialTables) {
                if (in_array($t, $officialTables, true)) return true;
                if (isset($allOfficialBpsTables[$t]) || isset($allOfficialOpdTables[$t])) return false;
                return true;
            });
            $instansiList = config('sibingka.instansi_list', []);
            $agencyInfo = $instansiList[$cleanOpd] ?? null;
            $agencyName = $agencyInfo['short_name'] ?? ($agencyInfo['name'] ?? "Instansi_{$cleanOpd}");
            $cleanAgencyName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $agencyName);
        } else {
            $catalog = config("sibingka_tables.opd", []);
            $officialTables = $catalog[$cleanOpd] ?? [];
            $customTablesQuery = TabelMetadata::where('opd_code', $cleanOpd)
                ->where('year', $year)
                ->where('source_type', '!=', 'deleted')
                ->where(function($q) {
                    $q->where('source_type', 'like', '%opd%')
                      ->orWhereNull('source_type');
                })
                ->where('source_type', 'not like', '%bps%')
                ->where('source_type', 'not like', '%instansi%');
            $customTables = $customTablesQuery->pluck('table_code')->toArray();
            $customTables = array_filter($customTables, function($t) use ($allOfficialBpsTables, $allOfficialInstansiTables, $officialTables) {
                if (in_array($t, $officialTables, true)) return true;
                if (isset($allOfficialBpsTables[$t]) || isset($allOfficialInstansiTables[$t])) return false;
                return true;
            });
            $opdList = config('sibingka.opd_list', []);
            $agencyInfo = $opdList[$cleanOpd] ?? null;
            $agencyName = $agencyInfo['short_name'] ?? ($agencyInfo['name'] ?? "OPD_{$cleanOpd}");
            $cleanAgencyName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $agencyName);
        }

        $allTableCodes = array_values(array_unique(array_merge($officialTables, $customTables)));
        natsort($allTableCodes);

        $sheets = [];

        foreach ($allTableCodes as $tableCode) {
            $tableOpdCode = $cleanOpd;
            if ($isAllBps) {
                $tableOpdCode = '01';
                foreach (config('sibingka_tables.bps', []) as $dsCode => $tbls) {
                    if (in_array($tableCode, $tbls, true)) {
                        $tableOpdCode = $dsCode;
                        break;
                    }
                }
            }

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
            } elseif ($type === 'bps') {
                $metaQuery->where(function($q) use ($tableOpdCode, $isAllBps) {
                    if (!$isAllBps) {
                        $q->where('opd_code', $tableOpdCode)
                          ->orWhere('source_type', 'like', '%bps%');
                    } else {
                        $q->where('source_type', 'like', '%bps%')
                          ->orWhereIn('source_type', ['custom_bps', 'bps'])
                          ->orWhere('opd_code', $tableOpdCode);
                    }
                });
            } else {
                $metaQuery->where('opd_code', $cleanOpd);
            }

            $meta = $metaQuery->first();

            // 1. Jika belum ada di tahun terpilih, coba buatkan template resmi untuk tahun tersebut lebih dulu
            if (!$meta || empty($meta->table_html) || str_contains($meta->table_html, 'Indicator Details')) {
                $createdMeta = $this->getOrCreateMetadata($tableCode, $tableOpdCode, $year, $type);
                if ($createdMeta && !empty($createdMeta->table_html) && !str_contains($createdMeta->table_html, 'Indicator Details')) {
                    $meta = $createdMeta;
                }
            }

            // 2. Jika masih belum ada di tahun terpilih, cari fallback snapshot dari tahun terdekat
            $isFallback = false;
            $sourceYear = $year;
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
                } elseif ($type === 'bps') {
                    $fallbackQuery->where(function($q) {
                        $q->where('source_type', 'like', '%bps%')
                          ->orWhereIn('source_type', ['custom_bps', 'bps']);
                    });
                }

                $fallbackMeta = $fallbackQuery->orderByRaw("ABS(year - {$year}) ASC")->first();
                if ($fallbackMeta) {
                    $meta = $fallbackMeta;
                    $isFallback = true;
                    $sourceYear = (int)$fallbackMeta->year;
                }
            }

            // 3. Jika masih belum ada di database, buat template resmi
            if (!$meta || empty($meta->table_html)) {
                $meta = $this->getOrCreateMetadata($tableCode, $tableOpdCode, $year, $type);
            }

            $defaultHtml = $this->getDefaultHtmlForTable($tableCode, $year);
            $exportHtml = $meta?->table_html;
            if ($defaultHtml && (empty($exportHtml) || str_contains($exportHtml, 'Belum ada data untuk tabel ini'))) {
                $exportHtml = $defaultHtml;
            }

            $titleId = $meta?->title_id;
            $titleEn = $meta?->title_en;

            // Jika data menggunakan fallback dari tahun lain ($sourceYear !== $year):
            // Sesuaikan tahun pada judul, tahun header, dan kosongkan angka tahun lama agar tidak rancu
            if ($isFallback && $sourceYear !== $year) {
                if ($titleId) {
                    $titleId = $this->adjustYearInTitle($titleId, $sourceYear, $year);
                }
                if ($titleEn) {
                    $titleEn = $this->adjustYearInTitle($titleEn, $sourceYear, $year);
                }
                if ($exportHtml) {
                    $exportHtml = $this->adjustYearInHtml($exportHtml, $sourceYear, $year);
                    $exportHtml = $this->buildEmptyTemplateFromHtml($exportHtml);
                }
            }

            $sheets[] = new TableOpdExport(
                $tableCode,
                $tableOpdCode,
                $year,
                $titleId,
                $titleEn,
                $meta?->source ?? 'BPS Kota Bukittinggi',
                $meta?->note,
                $exportHtml,
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

    /**
     * Dapatkan struktur HTML tabel resmi bawaan untuk tabel-tabel multi-tahun saat diekspor
     */
    protected function getDefaultHtmlForTable(string $tableCode, int $year): ?string
    {
        if ($tableCode === '2.2.5') {
            $p = ($year >= 2026) ? range($year - 4, $year) : [2021, 2022, 2023, 2024, 2025];
            $yearsHeaders = '';
            $numHeaders = '';
            foreach ($p as $idx => $y) {
                $yearsHeaders .= "<th class=\"py-3 px-4 border border-slate-700 text-center font-bold bg-[#f95a00] text-white\">{$y}</th>";
                $numHeaders .= "<th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs bg-[#fed7aa] text-slate-900\">(" . ($idx + 2) . ")</th>";
            }

            $rows = [
                '01. Peraturan daerah', '02. Keputusan DPRD', '03. Keputusan Pimpinan',
                '04. Pernyataan', '05. Pernyataan Pendapat', '06. Resolusi',
                '07. Dengar Pendapat dengan Pemerintah', '08. Rapat Paripurna Terbuka',
                '09. Rapat Paripurna Istimewa', '10. Rapat Panitia Musyawarah',
                '11. Rapat Badan Kehormatan', '12. Rapat Panitia / Badan Anggaran',
                '13. Rapat Panitia Khusus', '14. Rapat Gabungan Komisi',
                '15. Rapat Komisi', '16. Turun ke Lapangan ke Kelurahan',
                '17. Keluar Daerah', '18. Rapat Kerja', '19. Penyampaian Aspirasi',
                '20. Study Banding', '21. Reses', '22. Kunker Komisi'
            ];

            $tbodyHtml = '';
            foreach ($rows as $rLabel) {
                $tbodyHtml .= "<tr><td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\">{$rLabel}</td>";
                foreach ($p as $y) {
                    $tbodyHtml .= "<td class=\"py-2 px-3 text-center border border-slate-700\">-</td>";
                }
                $tbodyHtml .= "</tr>\n";
            }

            return "<thead>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
        <th class=\"py-3 px-4 font-bold border border-slate-700 text-left align-middle min-w-[280px]\">
            <div>Jenis Keputusan</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Type Of Decision</div>
        </th>
        {$yearsHeaders}
    </tr>
    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
        <th class=\"py-1 px-3 border border-slate-700 text-center\">(1)</th>
        {$numHeaders}
    </tr>
</thead>
<tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
    {$tbodyHtml}
</tbody>";
        }

        if ($tableCode === '8.1.4') {
            $p = ($year >= 2026) ? range($year, $year - 4) : [2025, 2024, 2023, 2022, 2021];
            $jumlahRowsHtml = '';
            foreach ($p as $idx => $y) {
                $jumlahRowsHtml .= '<tr>';
                if ($idx === 0) {
                    $spanCount = count($p);
                    $jumlahRowsHtml .= "<td class=\"py-2.5 px-4 font-bold border border-slate-700 text-center align-middle bg-amber-50/70\" rowspan=\"{$spanCount}\">
                        <div>Jumlah</div>
                        <div class=\"italic font-normal text-xs text-slate-600\">Total</div>
                    </td>";
                }
                $jumlahRowsHtml .= "<td class=\"py-2 px-3 font-bold border border-slate-700 text-center\">{$y}</td>
                    <td class=\"py-2 px-3 text-center border border-slate-700\">-</td>
                    <td class=\"py-2 px-3 text-center border border-slate-700\">-</td>
                </tr>\n";
            }

            return "<thead>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
        <th class=\"py-3 px-4 font-bold border border-slate-700 w-[50%]\" colspan=\"2\" rowspan=\"2\">
            <div>Kecamatan</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">District</div>
        </th>
        <th class=\"py-2.5 px-4 font-bold border border-slate-700 text-center w-[50%]\" colspan=\"2\">
            <div>Jembatan</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Bridge</div>
        </th>
    </tr>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
        <th class=\"py-2 px-3 font-bold border border-slate-700 w-[25%]\">
            <div>Banyaknya</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Number</div>
        </th>
        <th class=\"py-2 px-3 font-bold border border-slate-700 w-[25%]\">
            <div>Panjang</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Length</div>
        </th>
    </tr>
    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
        <th class=\"py-1 px-3 border border-slate-700 text-center\" colspan=\"2\">(1)</th>
        <th class=\"py-1 px-3 border border-slate-700 text-center\">(2)</th>
        <th class=\"py-1 px-3 border border-slate-700 text-center\">(3)</th>
    </tr>
</thead>
<tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\" colspan=\"2\">01. GUGUK PANJANG</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">-</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">-</td>
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\" colspan=\"2\">02. MANDIANGIN KOTO SELAYAN</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">-</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">-</td>
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\" colspan=\"2\">03. AUR BIRUGO TIGO BALEH</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">-</td>
        <td class=\"py-2.5 px-4 text-center border border-slate-700\">-</td>
    </tr>
    {$jumlahRowsHtml}
</tbody>";
        }

        return null;
    }
}
