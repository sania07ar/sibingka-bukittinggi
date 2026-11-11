<?php
$f = 'storage/app/tables/table_opd_13_4.2.14_2023.json';
$data = json_decode(file_get_contents($f), true);
echo substr($data['table_html'] ?? '', 0, 3000);
