<?php

$dir = __DIR__;
$files = glob($dir . '/*.sql.gz');

if (empty($files)) {
    die('❌ No .sql.gz files found');
}

echo "<h2>Download Database Dumps (.sql.gz)</h2>";
echo "<p><b>Tip:</b> Select all links → Right-click → Open in new tabs → Allow downloads</p>";
echo "<hr>";

foreach ($files as $file) {
    $name = basename($file);
    echo "<a href='{$name}' download>{$name}</a><br>";
}
