<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$meta2025 = DB::table('tabel_opd_metadata')->where('table_code', '2.3.5')->where('year', 2025)->first();
if ($meta2025) {
    echo "=== HTML Thead 2025 ===\n";
    if (preg_match('/<thead.*?<\/thead>/is', $meta2025->table_html, $m)) {
        echo $m[0] . "\n";
    }

    echo "=== First 3 Rows Tbody 2025 ===\n";
    if (preg_match('/<tbody.*?>/is', $meta2025->table_html, $mb)) {
        $afterTbody = substr($meta2025->table_html, strpos($meta2025->table_html, $mb[0]));
        preg_match_all('/<tr.*?<\/tr>/is', $afterTbody, $rows);
        for ($i = 0; $i < min(5, count($rows[0])); $i++) {
            echo "Row $i:\n" . $rows[0][$i] . "\n";
        }
        echo "Total rows in tbody: " . count($rows[0]) . "\n";
        echo "Last row in tbody:\n" . end($rows[0]) . "\n";
    }
}
