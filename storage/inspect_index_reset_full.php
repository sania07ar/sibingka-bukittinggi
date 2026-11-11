<?php
$index = file_get_contents('resources/views/tabel/index.blade.php');
$posFn = strpos($index, 'function resetTableOriginal');
echo substr($index, $posFn + 800, 2500);
