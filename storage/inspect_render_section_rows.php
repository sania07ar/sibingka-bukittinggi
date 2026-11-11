<?php
$f = 'C:/Users/DELL/.gemini/antigravity/brain/de71657f-5309-45ec-9a62-5b9c374026f2/.system_generated/steps/27148/output.txt';
$c = file_get_contents($f);

$posRender = strpos($c, '$renderSectionRows = function');
echo substr($c, $posRender, 1500);

