<?php

// ================= SECURITY =================
if (!isset($_GET['secret']) || $_GET['secret'] !== 'hp20nbd') {
    http_response_code(403);
    exit('Forbidden');
}

// ================= PATHS =================
$baseUrl   = 'https://casadarsh.himachalsoceity.com/bigdump';
$queueFile = __DIR__ . '/queue.txt';
$runtime   = __DIR__ . '/bigdump-runtime.php';

// ================= INITIAL QUEUE =================
if (!file_exists($queueFile)) {
    file_put_contents($queueFile, implode("\n", [
        'casadarsh',
        'casbalduhak',
        'casbara',
    ]));
}

// ================= READ QUEUE =================
$dbs = file($queueFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// ✅ ALL DONE
if (!$dbs || count($dbs) === 0) {
    @unlink($queueFile);
    echo "✅ ALL DATABASES IMPORTED SUCCESSFULLY";
    exit;
}

// ================= NEXT DB =================
$db = array_shift($dbs);
file_put_contents($queueFile, implode("\n", $dbs));

// ================= RUNTIME FILE =================
file_put_contents($runtime, <<<PHP
<?php
\$db_server   = '127.0.0.1';
\$db_username = 'himachal';
\$db_password = '6nwf6ji1w6yn';
\$db_name     = '{$db}';
\$filename    = '{$db}.sql.gz';
\$ajax        = true;
PHP
);

// ================= REDIRECT =================
header("Location: {$baseUrl}/bigdump.php?start=1&fn={$db}.sql.gz");
exit;
