<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$records = DB::table('tabel_opd_metadata')
    ->where('table_code', '4.2.22')
    ->get(['id', 'opd_code', 'year', 'table_code', 'table_html']);

echo "Found records for 4.2.22: " . count($records) . PHP_EOL;
foreach ($records as $r) {
    echo "ID: {$r->id}, OPD: {$r->opd_code}, Year: {$r->year}\n";
    // Check tbody rows
    if (preg_match('/<tbody[^>]*>(.*?)<\/tbody>/is', $r->table_html, $m)) {
        preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $m[1], $rows);
        echo "  Rows count: " . count($rows[0]) . "\n";
        foreach ($rows[0] as $idx => $row) {
            strip_tags($row);
            $clean = trim(preg_replace('/\s+/', ' ', strip_tags($row)));
            echo "    Row {$idx}: {$clean}\n";
        }
    }
}

$records21 = DB::table('tabel_opd_metadata')
    ->where('table_code', '4.2.21')
    ->where('opd_code', '26')
    ->get(['id', 'opd_code', 'year', 'table_code', 'table_html']);

echo "\nFound records for 4.2.21 (opd 26): " . count($records21) . PHP_EOL;
foreach ($records21 as $r) {
    echo "ID: {$r->id}, OPD: {$r->opd_code}, Year: {$r->year}\n";
    if (preg_match('/<tbody[^>]*>(.*?)<\/tbody>/is', $r->table_html, $m)) {
        preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $m[1], $rows);
        echo "  Rows count: " . count($rows[0]) . "\n";
        foreach ($rows[0] as $idx => $row) {
            $clean = trim(preg_replace('/\s+/', ' ', strip_tags($row)));
            echo "    Row {$idx}: {$clean}\n";
        }
    }
}
