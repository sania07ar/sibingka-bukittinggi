<?php
$index = file_get_contents('resources/views/tabel/index.blade.php');

$posBtn = strpos($index, 'btnResetTableOriginal');
if ($posBtn !== false) {
    echo "=== btnResetTableOriginal in index.blade.php ===\n";
    echo substr($index, max(0, $posBtn - 300), 800) . "\n\n";
}

$posFn = strpos($index, 'function resetTableOriginal');
if ($posFn !== false) {
    echo "=== function resetTableOriginal in index.blade.php ===\n";
    echo substr($index, $posFn, 1500) . "\n\n";
}
