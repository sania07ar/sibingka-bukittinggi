<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$meta2025 = DB::table('tabel_opd_metadata')->where('table_code', '2.3.5')->where('year', 2025)->first();
$meta2024 = DB::table('tabel_opd_metadata')->where('table_code', '2.3.5')->where('year', 2024)->first();

echo "=== 2025 Unit Kerja List ===\n";
if ($meta2025 && preg_match_all('/<tr.*?>(.*?)<\/tr>/is', $meta2025->table_html, $matches)) {
    foreach ($matches[1] as $idx => $trInner) {
        if (str_contains($trInner, '<th')) continue; // skip header
        preg_match_all('/<td.*?>(.*?)<\/td>/is', $trInner, $tdMatches);
        $cells = array_map(function($c) { return trim(strip_tags($c)); }, $tdMatches[1]);
        if (count($cells) >= 4) {
            echo sprintf("%-60s | PNS: %-6s | PPPK: %-6s | JML: %-6s\n", $cells[0], $cells[1], $cells[2], $cells[3]);
        }
    }
}
