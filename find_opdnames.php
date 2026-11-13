<?php
$content = file_get_contents(__DIR__ . '/public/js/tabel/table-index.js');
$lines = explode("\n", $content);
foreach ($lines as $i => $l) {
    if (strpos($l, 'const opdNames') !== false || strpos($l, 'const instansiNames') !== false) {
        echo ($i + 1) . ": " . trim($l) . "\n";
    }
}

