<?php

function validateJs($filePath) {
    echo "=== Validating $filePath ===\n";
    $content = file_get_contents($filePath);
    preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $content, $matches);
    $allJs = implode("\n;\n", $matches[1]);

    // Replace blade tags cleanly
    $allJs = preg_replace('/"\{\{.*?\}\}"/', '"dummy"', $allJs);
    $allJs = preg_replace('/\'\{\{.*?\}\}\'/', "'dummy'", $allJs);
    $allJs = preg_replace('/\{\{.*?\}\}/', 'dummy', $allJs);
    $allJs = preg_replace('/@json\(.*?\)/', '{}', $allJs);

    $testFile = __DIR__ . '/test_check.js';
    file_put_contents($testFile, $allJs);

    $cmd = 'node --check ' . escapeshellarg($testFile) . ' 2>&1';
    $output = shell_exec($cmd);
    if ($output) {
        echo "Error found:\n" . $output . "\n";
    } else {
        echo "OK! No syntax errors.\n";
    }
}

validateJs(__DIR__ . '/../resources/views/tabel/index.blade.php');
validateJs(__DIR__ . '/../resources/views/tabel/edit.blade.php');
