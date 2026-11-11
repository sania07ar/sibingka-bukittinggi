<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TabelMetadata;

echo "=== Data 4.1.18 per Instansi (Year 2025) ===\n";
for ($i = 5; $i <= 23; $i++) {
    $opd = str_pad($i, 2, '0', STR_PAD_LEFT);
    $meta = TabelMetadata::where('table_code', '4.1.18')
        ->where('opd_code', $opd)
        ->where('year', 2025)
        ->first();
    if ($meta) {
        $hasHtml = !empty($meta->table_html);
        $len = strlen($meta->table_html ?? '');
        echo "Instansi $opd: Title='{$meta->title_id}', Source='{$meta->source}', Saved={$meta->is_saved}, HtmlLen={$len}\n";
    } else {
        echo "Instansi $opd: NOT FOUND IN DB\n";
    }
}

echo "\n=== Data 4.1.19 per Instansi (Year 2025) ===\n";
for ($i = 5; $i <= 23; $i++) {
    $opd = str_pad($i, 2, '0', STR_PAD_LEFT);
    $meta = TabelMetadata::where('table_code', '4.1.19')
        ->where('opd_code', $opd)
        ->where('year', 2025)
        ->first();
    if ($meta) {
        $hasHtml = !empty($meta->table_html);
        $len = strlen($meta->table_html ?? '');
        echo "Instansi $opd: Title='{$meta->title_id}', Source='{$meta->source}', Saved={$meta->is_saved}, HtmlLen={$len}\n";
    } else {
        echo "Instansi $opd: NOT FOUND IN DB\n";
    }
}

