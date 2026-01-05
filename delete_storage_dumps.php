<?php

$dir = __DIR__ . '/storage/db-imports';
$deleted = 0;

foreach (glob($dir . '/*.sql.gz') as $file) {
    if (is_file($file)) {
        unlink($file);
        $deleted++;
    }
}

echo "✅ Deleted {$deleted} .sql.gz files from storage/db-imports";
