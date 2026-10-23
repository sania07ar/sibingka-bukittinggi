<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

require __DIR__ . '/units_235.php';

function buildHtml235($year, $units) {
    $pnsKey = ($year === 2025) ? 'pns25' : 'pns24';
    $pppkKey = ($year === 2025) ? 'pppk25' : 'pppk24';

    $totPns = 0;
    $totPppk = 0;
    $rowsHtml = '';

    foreach ($units as $u) {
        $pns = (int) $u[$pnsKey];
        $pppk = (int) $u[$pppkKey];
        $jml = $pns + $pppk;
        $totPns += $pns;
        $totPppk += $pppk;

        $rowsHtml .= "<tr data-key=\"{$u['key']}\" class=\"hover:bg-amber-100/60 transition-colors\">\n" .
            "    <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left align-top\">{$u['name']}</td>\n" .
            "    <td class=\"py-2.5 px-4 text-center border border-slate-700 align-top\">{$pns}</td>\n" .
            "    <td class=\"py-2.5 px-4 text-center border border-slate-700 align-top\">{$pppk}</td>\n" .
            "    <td class=\"py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-100/70 align-top\">{$jml}</td>\n" .
            "</tr>\n";
    }

    $totJml = $totPns + $totPppk;
    $rowsHtml .= "<tr data-total=\"true\" class=\"bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700\">\n" .
        "    <td class=\"py-2.5 px-4 font-bold border border-slate-700 text-left\">\n" .
        "        <div>Jumlah</div>\n" .
        "        <div class=\"italic font-normal text-xs text-slate-700\">Total</div>\n" .
        "    </td>\n" .
        "    <td class=\"py-2.5 px-4 text-center border border-slate-700 font-bold\">{$totPns}</td>\n" .
        "    <td class=\"py-2.5 px-4 text-center border border-slate-700 font-bold\">{$totPppk}</td>\n" .
        "    <td class=\"py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-200\">{$totJml}</td>\n" .
        "</tr>\n";

    return "<thead>\n" .
        "    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">\n" .
        "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-left w-[55%]\">\n" .
        "            <div>Unit Kerja</div>\n" .
        "            <div class=\"italic font-normal text-[11px] sm:text-xs\">Placement</div>\n" .
        "        </th>\n" .
        "        <th class=\"py-3 px-4 font-bold border border-slate-700 w-[15%]\">\n" .
        "            <div>PNS</div>\n" .
        "            <div class=\"italic font-normal text-[11px] sm:text-xs\">Civil Servant</div>\n" .
        "        </th>\n" .
        "        <th class=\"py-3 px-4 font-bold border border-slate-700 w-[15%]\">\n" .
        "            <div>PPPK</div>\n" .
        "            <div class=\"italic font-normal text-[11px] sm:text-xs\">Employment Agreement</div>\n" .
        "        </th>\n" .
        "        <th class=\"py-3 px-4 font-bold border border-slate-700 bg-amber-600 font-extrabold w-[15%]\">\n" .
        "            <div>Jumlah</div>\n" .
        "            <div class=\"italic font-normal text-[11px] sm:text-xs\">Total</div>\n" .
        "        </th>\n" .
        "    </tr>\n" .
        "    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">\n" .
        "        <th class=\"py-1 px-3 border border-slate-700 text-left\">(1)</th>\n" .
        "        <th class=\"py-1 px-3 border border-slate-700 text-center\">(2)</th>\n" .
        "        <th class=\"py-1 px-3 border border-slate-700 text-center\">(3)</th>\n" .
        "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold bg-amber-200/60\">(4)</th>\n" .
        "    </tr>\n" .
        "</thead>\n" .
        "<tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">\n" .
        $rowsHtml .
        "</tbody>";
}

foreach ([2024, 2025] as $year) {
    $html = buildHtml235($year, $units);
    $titleId = "Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi, {$year}";
    $titleEn = "Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement, {$year}";
    $source = 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / <span class="italic text-slate-500">Human Resources and Development Agency of Bukittinggi Municipality</span>';
    $note = "<div>Data per-31 Desember {$year}</div>";

    DB::table('tabel_opd_metadata')->updateOrInsert(
        [
            'table_code' => '2.3.5',
            'opd_code' => '04',
            'year' => $year,
        ],
        [
            'title_id' => $titleId,
            'title_en' => $titleEn,
            'source' => $source,
            'note' => $note,
            'table_html' => $html,
            'source_type' => 'database',
            'is_saved' => 1,
            'updated_at' => Carbon::now(),
        ]
    );

    echo "Metadata for 2.3.5 year $year updated successfully!\n";
}
