<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$records = DB::table('tabel_opd_metadata')->whereNotNull('note')->where('note', '!=', '')->get();
$count = 0;

foreach ($records as $rec) {
    if (preg_match('/(31\s+Desember\s+)\b(19|20)\d{2}\b/i', $rec->note)) {
        $correctedNote = preg_replace('/(31\s+Desember\s+)\b(19|20)\d{2}\b/i', '${1}' . $rec->year, $rec->note);
        if ($correctedNote !== $rec->note) {
            DB::table('tabel_opd_metadata')->where('id', $rec->id)->update(['note' => $correctedNote]);
            echo "Updated table {$rec->table_code} year {$rec->year}: {$correctedNote}\n";
            $count++;
        }
    }
}

echo "Total updated: {$count}\n";
