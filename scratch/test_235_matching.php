<?php

require __DIR__ . '/units_235.php';

echo "Total units: " . count($units) . "\n";

// Test matching by leading number
$success = 0;
foreach ($units as $u) {
    if (preg_match('/^\s*0?(\d{1,2})\./', $u['name'], $m)) {
        $num = (int) $m[1];
        if ($num >= 1 && $num <= 84) {
            $success++;
        }
    }
}
echo "Matched by number: $success / " . count($units) . "\n";
