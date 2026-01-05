<?php

set_time_limit(0);

// directory containing dumps
$dir = __DIR__;

// get all sql / sql.gz files
$files = array_values(array_filter(scandir($dir), function ($file) {
    return preg_match('/\.(sql|sql\.gz)$/i', $file);
}));

if (empty($files)) {
    die('❌ No SQL files found');
}

// index from query string
$index = isset($_GET['i']) ? (int) $_GET['i'] : 0;

// finished
if (!isset($files[$index])) {
    echo "✅ All files downloaded";
    exit;
}

$file = $files[$index];
$path = $dir . '/' . $file;

// send headers for download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Content-Length: ' . filesize($path));
header('Cache-Control: no-cache');
header('Pragma: public');

// output file
readfile($path);

// auto-trigger next download
echo "<script>
    setTimeout(function () {
        window.location.href = '?i=" . ($index + 1) . "';
    }, 1500);
</script>";

exit;
