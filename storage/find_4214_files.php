<?php
$files = scandir('storage/app/tables');
foreach ($files as $f) {
    if (strpos($f, '4.2.14') !== false) {
        echo "Found $f (" . filesize("storage/app/tables/$f") . " bytes)\n";
        $data = json_decode(file_get_contents("storage/app/tables/$f"), true);
        echo "HTML:\n" . substr($data['table_html'] ?? '', 0, 1000) . "\n---\n";
    }
}
