<?php
$index = file_get_contents('resources/views/tabel/index.blade.php');
$pos = strpos($index, "'4.2.14':");
if ($pos !== false) {
    echo substr($index, $pos, 2500);
}
