<?php
$index = file_get_contents('resources/views/tabel/index.blade.php');

// Let's search for cell click or comment or dblclick or prompt or input
preg_match_all('/(?:data-cell-key|openCellCommentDrawer|click|dblclick|editCell|input)/i', $index, $m);
print_r(array_count_values($m[0]));

// Let's search for openCellCommentDrawer or renderCellCommentBadges in index.blade.php
$pos = strpos($index, 'renderCellCommentBadges');
if ($pos !== false) {
    echo "renderCellCommentBadges at $pos:\n";
    echo substr($index, $pos, 2000) . "\n---\n";
}
