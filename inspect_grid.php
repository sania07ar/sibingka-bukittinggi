<?php
$content = file_get_contents(__DIR__ . '/public/js/tabel/table-editor.js');
$lines = explode("\n", $content);
foreach ($lines as $i => $l) {
    if (strpos($l, 'function transformToEditableGrid') !== false) {
        echo "transformToEditableGrid at line " . ($i + 1) . "\n";
        for ($j = $i; $j < $i + 60; $j++) {
            if (isset($lines[$j])) echo ($j + 1) . ": " . $lines[$j] . "\n";
        }
        break;
    }
}

