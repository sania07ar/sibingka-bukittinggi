<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$meta2024 = DB::table('tabel_opd_metadata')->where('table_code', '2.3.5')->where('year', 2024)->first();

echo "=== 2024 Unit Kerja List ===\n";
if ($meta2024 && preg_match_all('/<tr.*?>(.*?)<\/tr>/is', $meta2024->table_html, $matches)) {
    $rows = [];
    foreach ($matches[1] as $idx => $trInner) {
        if (str_contains($trInner, '<th')) continue;
        preg_match_all('/<td.*?>(.*?)<\/td>/is', $trInner, $tdMatches);
        $cells = array_map(function($c) { return trim(strip_tags($c)); }, $tdMatches[1]);
        if (count($cells) >= 4) {
            $rows[] = $cells;
        }
    }
    echo "Total rows: " . count($rows) . "\n";
    for ($i = 0; $i < min(5, count($rows)); $i++) {
        echo sprintf("%-60s | PNS: %-6s | PPPK: %-6s | JML: %-6s\n", $rows[$i][0], $rows[$i][1], $rows[$i][2], $rows[$i][3]);
    }
    echo "Last row:\n";
    $last = end($rows);
    echo sprintf("%-60s | PNS: %-6s | PPPK: %-6s | JML: %-6s\n", $last[0], $last[1], $last[2], $last[3]);
}
