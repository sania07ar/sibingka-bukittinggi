<?php

require __DIR__ . '/units_235.php';

echo "const units235 = [\n";
foreach ($units as $u) {
    echo "    { key: '{$u['key']}', no: {$u['no']}, name: " . json_encode($u['name']) . ", pns25: '{$u['pns25']}', pppk25: '{$u['pppk25']}', pns24: '{$u['pns24']}', pppk24: '{$u['pppk24']}' },\n";
}
echo "];\n";
