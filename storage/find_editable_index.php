<?php
$index = file_get_contents('resources/views/tabel/index.blade.php');

$pos = strpos($index, 'table-edit-input');
while ($pos !== false) {
    echo "Found table-edit-input at $pos:\n";
    echo substr($index, max(0, $pos - 200), 500) . "\n---\n";
    $pos = strpos($index, 'table-edit-input', $pos + 1);
}

$pos = strpos($index, 'contentEditable');
while ($pos !== false) {
    echo "Found contentEditable at $pos:\n";
    echo substr($index, max(0, $pos - 200), 500) . "\n---\n";
    $pos = strpos($index, 'contentEditable', $pos + 1);
}
