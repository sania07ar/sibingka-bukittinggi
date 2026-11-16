<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$m = \App\Models\TabelMetadata::find(1568);
echo "=== Year 2023 (ID: {$m->id}) ===\n";
preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $m->table_html, $trs);
foreach ($trs[1] as $tr) {
    preg_match_all('/<(?:td|th)[^>]*>(.*?)<\/(?:td|th)>/is', $tr, $cells);
    $texts = array_map(fn($c) => trim(strip_tags($c)), $cells[1]);
    $first = $texts[0] ?? '';
    if (preg_match('/(?:Jumlah|Total|19\d{2}|20\d{2}|Desember)/i', $first)) {
        echo "  " . implode(' | ', $texts) . "\n";
    }
}
