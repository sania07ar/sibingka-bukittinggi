<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

require __DIR__ . '/units_235.php';

$now = Carbon::now();

DB::table('tabel_opd_data')->where('table_code', '2.3.5')->delete();

$insertRows = [];

foreach ([2024, 2025] as $year) {
    $pnsKey = ($year === 2025) ? 'pns25' : 'pns24';
    $pppkKey = ($year === 2025) ? 'pppk25' : 'pppk24';

    $totPns = 0;
    $totPppk = 0;

    foreach ($units as $u) {
        $pns = (int) $u[$pnsKey];
        $pppk = (int) $u[$pppkKey];
        $jml = $pns + $pppk;

        $totPns += $pns;
        $totPppk += $pppk;

        // PNS
        $insertRows[] = [
            'table_code' => '2.3.5',
            'opd_code' => '04',
            'year' => $year,
            'row_key' => "{$u['key']}_pns",
            'row_label' => "{$u['name']} (PNS)",
            'value' => (string) $pns,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        // PPPK
        $insertRows[] = [
            'table_code' => '2.3.5',
            'opd_code' => '04',
            'year' => $year,
            'row_key' => "{$u['key']}_pppk",
            'row_label' => "{$u['name']} (PPPK)",
            'value' => (string) $pppk,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        // JML
        $insertRows[] = [
            'table_code' => '2.3.5',
            'opd_code' => '04',
            'year' => $year,
            'row_key' => "{$u['key']}_jml",
            'row_label' => "{$u['name']} (Jumlah)",
            'value' => (string) $jml,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    // Totals
    $insertRows[] = [
        'table_code' => '2.3.5',
        'opd_code' => '04',
        'year' => $year,
        'row_key' => 'total_pns',
        'row_label' => 'Jumlah / Total (PNS)',
        'value' => (string) $totPns,
        'created_at' => $now,
        'updated_at' => $now,
    ];
    $insertRows[] = [
        'table_code' => '2.3.5',
        'opd_code' => '04',
        'year' => $year,
        'row_key' => 'total_pppk',
        'row_label' => 'Jumlah / Total (PPPK)',
        'value' => (string) $totPppk,
        'created_at' => $now,
        'updated_at' => $now,
    ];
    $insertRows[] = [
        'table_code' => '2.3.5',
        'opd_code' => '04',
        'year' => $year,
        'row_key' => 'total_jml',
        'row_label' => 'Jumlah / Total (Jumlah)',
        'value' => (string) ($totPns + $totPppk),
        'created_at' => $now,
        'updated_at' => $now,
    ];

    echo "Year $year seeded: PNS = $totPns, PPPK = $totPppk, Total = " . ($totPns + $totPppk) . "\n";
}

foreach (array_chunk($insertRows, 200) as $chunk) {
    DB::table('tabel_opd_data')->insert($chunk);
}

echo "Total tabel_opd_data inserted for 2.3.5: " . count($insertRows) . "\n";
