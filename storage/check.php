<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$metas = \App\Models\TabelMetadata::where('table_code', '4.1.18')
    ->where('opd_code', '07')
    ->orderBy('year', 'desc')
    ->get();

foreach ($metas as $m) {
    echo "ID: {$m->id} | Year: {$m->year} | Title: {$m->title_id}\n";
}
