<?php
$index = file_get_contents('resources/views/tabel/index.blade.php');

// Search for 4.2.14 or contenteditable or input generation in index.blade.php
preg_match_all('/(?:4\.2\.14|<input|contenteditable|table-edit-input|ondblclick|addEventListener\(\'click\')/i', $index, $m);
print_r(array_count_values($m[0]));

$pos = strpos($index, '4.2.14');
while ($pos !== false) {
    echo "Found 4.2.14 at $pos:\n";
    echo substr($index, max(0, $pos - 100), 400) . "\n---\n";
    $pos = strpos($index, '4.2.14', $pos + 1);
}
