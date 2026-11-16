<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$r = DB::table('tabel_opd_metadata')
    ->where('table_code', '4.2.22')
    ->where('year', 2023)
    ->first();

if ($r) {
    echo $r->table_html;
}
