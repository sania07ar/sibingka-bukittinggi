<?php
$index = file_get_contents('resources/views/tabel/index.blade.php');
$pos = strpos($index, 'renderCellCommentBadges() {');
echo substr($index, $pos + 2500, 3000);
