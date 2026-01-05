<?php

$dir = __DIR__ . '/bigdump';
$deleted = 0;

foreach (glob($dir . '/*.sql.gz') as $file) {
    if (is_file($file)) {
        unlink($file);
        $deleted++;
    }
}

echo "✅ Deleted {$deleted} .sql.gz files from /bigdump";
