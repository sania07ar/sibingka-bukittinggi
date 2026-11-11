<?php
$c = file_get_contents('app/Http/Controllers/TabelOpdController.php');

$pos = strpos($c, 'function apiDeleteData');
if ($pos !== false) {
    echo substr($c, $pos, 2000);
}
