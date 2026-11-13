<?php
$cat = file_get_contents('public/sibingka-catalogs.js');
$pos = strpos($cat, 'const instansiTablesCatalog = {');
$posEnd = strpos($cat, '};', $pos);
$section = substr($cat, $pos, $posEnd - $pos + 2);

preg_match_all('/[\'"](\d+)[\'"]\s*:\s*\[(.*?)\]/s', $section, $matches, PREG_SET_ORDER);
foreach ($matches as $match) {
    $opd = $match[1];
    preg_match_all('/code:\s*[\'"]([^\'"]+)[\'"],\s*title:\s*[\'"]([^\'"]+)[\'"]/', $match[2], $codeMatches, PREG_SET_ORDER);
    echo "Instansi $opd:\n";
    foreach ($codeMatches as $cm) {
        echo "  - {$cm[1]}: {$cm[2]}\n";
    }
}
