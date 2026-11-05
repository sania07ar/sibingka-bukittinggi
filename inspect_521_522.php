<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

foreach (['5.2.1', '5.2.2'] as $tc) {
    echo "================= TABLE $tc =================\n";
    $r = DB::table('tabel_opd_metadata')
        ->where('table_code', $tc)
        ->where('year', 2025)
        ->first();
    if ($r) {
        echo "Title ID: {$r->title_id}\n";
        echo "Title EN: {$r->title_en}\n";
        echo "HTML:\n{$r->table_html}\n";
    } else {
        echo "No 2025 record found.\n";
    }
}

