<?php
$idx = file_get_contents('resources/views/tabel/index.blade.php');
if (preg_match_all('/localStorage\.(?:getItem|setItem|removeItem)\([^\)]+\)/', $idx, $m, PREG_OFFSET_CAPTURE)) {
    foreach ($m[0] as $match) {
        $offset = $match[1];
        $line = substr_count(substr($idx, 0, $offset), "\n") + 1;
        echo "Line $line: " . $match[0] . "\n";
    }
}
