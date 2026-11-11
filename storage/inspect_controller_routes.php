<?php
$ctrl = file_get_contents('app/Http/Controllers/TabelOpdController.php');
$start = strpos($ctrl, 'function syncTemplateToOtherYears');
echo substr($ctrl, $start, 1200);
