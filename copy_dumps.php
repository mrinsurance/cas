<?php

$src = __DIR__ . '/storage/db-imports';
$dst = __DIR__ . '/bigdump';

foreach (glob($src . '/*.sql.gz') as $file) {
    copy($file, $dst . '/' . basename($file));
}

echo "✅ All database files copied successfully";
