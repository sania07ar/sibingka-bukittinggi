<?php
$f = 'storage/app/tables/table_opd_13_4.2.14_2023.json';
$data = json_decode(file_get_contents($f), true);
$html = $data['table_html'] ?? '';

$pos = strpos($html, '47.43');
if ($pos !== false) {
    echo "Found 47.43 at pos $pos:\n";
    echo substr($html, max(0, $pos - 300), 600) . "\n";
} else {
    echo "47.43 not found\n";
}
