<?php

set_time_limit(0);

/**
 * Folder that contains the .sql.gz files
 * Keep it as current folder (bigdump) for safety.
 */
$dir = __DIR__;

/**
 * Get only .sql.gz files (ignore .sql and everything else)
 */
$files = array_values(array_filter(scandir($dir), function ($file) use ($dir) {
    return is_file($dir . '/' . $file) && preg_match('/\.sql\.gz$/i', $file);
}));

// sort for predictable order
sort($files);

if (empty($files)) {
    die('❌ No .sql.gz files found in this directory.');
}

// index from query string
$index = isset($_GET['i']) ? (int) $_GET['i'] : 0;

// done
if (!isset($files[$index])) {
    echo "✅ All .sql.gz files downloaded.";
    exit;
}

$file = $files[$index];
$path = $dir . '/' . $file;

if (!is_readable($path)) {
    die("❌ File not readable: " . htmlspecialchars($file));
}

// Download headers
header('Content-Description: File Transfer');
header('Content-Type: application/gzip');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Content-Length: ' . filesize($path));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: public');

// Stream the file
readfile($path);

// After download starts, trigger next file download
echo "<script>
    setTimeout(function () {
        window.location.href = '?i=" . ($index + 1) . "';
    }, 1500);
</script>";

exit;
