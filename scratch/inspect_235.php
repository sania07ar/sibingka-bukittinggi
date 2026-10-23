<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$metas = DB::table('tabel_opd_metadata')->where('table_code', '2.3.5')->get();
echo "=== METADATA COUNT: " . $metas->count() . " ===\n";
foreach ($metas as $m) {
    echo "Year: {$m->year} | Title: {$m->title_id} | HTML len: " . strlen($m->table_html ?? '') . "\n";
    if (strlen($m->table_html ?? '') > 0) {
        echo "HTML start: " . substr(strip_tags($m->table_html), 0, 200) . "\n";
    }
}

$dataCount = DB::table('tabel_opd_data')->where('table_code', '2.3.5')->count();
echo "\n=== DATA COUNT: {$dataCount} ===\n";
$sampleData = DB::table('tabel_opd_data')->where('table_code', '2.3.5')->where('year', 2025)->take(15)->get();
foreach ($sampleData as $d) {
    echo "Row key: {$d->row_key} | Label: {$d->row_label} | Value: {$d->value}\n";
}
