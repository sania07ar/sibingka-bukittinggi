<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$meta2025 = DB::table('tabel_opd_metadata')->where('table_code', '2.3.5')->where('year', 2025)->first();
$meta2024 = DB::table('tabel_opd_metadata')->where('table_code', '2.3.5')->where('year', 2024)->first();

function extractRows($html) {
    $rows = [];
    if ($html && preg_match_all('/<tr.*?>(.*?)<\/tr>/is', $html, $matches)) {
        foreach ($matches[1] as $trInner) {
            if (str_contains($trInner, '<th')) continue;
            preg_match_all('/<td.*?>(.*?)<\/td>/is', $trInner, $tdMatches);
            $cells = array_map(function($c) { return trim(strip_tags($c)); }, $tdMatches[1]);
            if (count($cells) >= 4) {
                $rows[] = $cells;
            }
        }
    }
    return $rows;
}

$rows2025 = extractRows($meta2025 ? $meta2025->table_html : '');
$rows2024 = extractRows($meta2024 ? $meta2024->table_html : '');

echo "<?php\n\n\$units = [\n";
foreach ($rows2025 as $idx => $r) {
    if ($idx >= 84) break; // last is total
    $name = $r[0];
    // make clean key
    $cleanName = preg_replace('/^\d+\.\s*/', '', $name);
    $key = 'unit_' . ($idx + 1);
    $pns2025 = $r[1];
    $pppk2025 = $r[2];
    $pns2024 = isset($rows2024[$idx]) ? $rows2024[$idx][1] : '0';
    $pppk2024 = isset($rows2024[$idx]) ? $rows2024[$idx][2] : '0';
    echo "    ['key' => '$key', 'no' => " . ($idx + 1) . ", 'name' => " . var_export($name, true) . ", 'pns25' => '$pns2025', 'pppk25' => '$pppk2025', 'pns24' => '$pns2024', 'pppk24' => '$pppk2024'],\n";
}
echo "];\n";
