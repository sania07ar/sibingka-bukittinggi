<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TabelMetadata;

$m05 = TabelMetadata::where('table_code', '4.1.18')->where('opd_code', '05')->where('year', 2025)->first();
echo "=== Instansi 05 (PGSD UNP) 4.1.18 ===\n";
echo $m05->table_html . "\n\n";

$m06 = TabelMetadata::where('table_code', '4.1.18')->where('opd_code', '06')->where('year', 2025)->first();
echo "=== Instansi 06 (Psikologi UNP) 4.1.18 ===\n";
echo $m06->table_html . "\n";
