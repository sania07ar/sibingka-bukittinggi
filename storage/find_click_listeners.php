<?php
$index = file_get_contents('resources/views/tabel/index.blade.php');

$pos = 0;
while (($pos = strpos($index, "addEventListener('click'", $pos + 1)) !== false) {
    echo "Click listener at $pos:\n" . substr($index, max(0, $pos - 100), 400) . "\n---\n";
}
while (($pos = strpos($index, 'onclick', $pos + 1)) !== false) {
    echo "onclick at $pos:\n" . substr($index, max(0, $pos - 50), 200) . "\n---\n";
}
