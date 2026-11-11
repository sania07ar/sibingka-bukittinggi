<?php
$edit = file_get_contents('resources/views/tabel/edit.blade.php');

$pos = strpos($edit, 'function renderEditPage()');
if ($pos !== false) {
    echo substr($edit, $pos, 4000);
}

