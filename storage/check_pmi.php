<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$metas = \App\Models\TabelMetadata::where('opd_code', '25')->select('table_code', 'title_id')->distinct()->get();
foreach ($metas as $m) {
    echo "OPD 25 Table: {$m->table_code} - {$m->title_id}\n";
}
