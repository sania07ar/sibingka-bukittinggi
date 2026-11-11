<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TabelMetadata;

echo "--- Check 4.1.18 in TabelMetadata ---\n";
$m4118 = TabelMetadata::where('table_code', '4.1.18')->get(['id', 'opd_code', 'year', 'source_type', 'is_saved', 'title_id']);
echo "Total records for 4.1.18: " . $m4118->count() . "\n";
foreach ($m4118 as $r) {
    echo "ID: {$r->id}, OPD: '{$r->opd_code}', Year: {$r->year}, Title: " . substr($r->title_id ?? '', 0, 45) . "\n";
}

echo "\n--- Check 4.1.19 in TabelMetadata ---\n";
$m4119 = TabelMetadata::where('table_code', '4.1.19')->get(['id', 'opd_code', 'year', 'source_type', 'is_saved', 'title_id']);
echo "Total records for 4.1.19: " . $m4119->count() . "\n";
foreach ($m4119 as $r) {
    echo "ID: {$r->id}, OPD: '{$r->opd_code}', Year: {$r->year}, Title: " . substr($r->title_id ?? '', 0, 45) . "\n";
}

