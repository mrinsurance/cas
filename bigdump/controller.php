<?php

/* ================== CONFIG ================== */

// 🔐 security token
$SECRET = 'hp20nbd';

// 🔁 databases to import (MASTER LIST – NEVER CHANGES)
$ALL_DATABASES = [
    'casadarsh',
    'casbalduhak',
    'casbara',
];

// DB credentials
$DB_SERVER   = 'localhost';
$DB_USER     = 'himachal';
$DB_PASS     = '6nwf6ji1w6yn';

/* ================== SECURITY ================== */
if (!isset($_GET['secret']) || $_GET['secret'] !== $SECRET) {
    http_response_code(403);
    exit('Forbidden');
}

/* ================== FILES ================== */
$queueFile   = __DIR__ . '/queue.txt';
$runtimeFile = __DIR__ . '/bigdump-runtime.php';

/* ================== INIT QUEUE ================== */
// If queue does not exist or is empty → rebuild automatically
if (!file_exists($queueFile) || trim(file_get_contents($queueFile)) === '') {
    file_put_contents($queueFile, implode("\n", $ALL_DATABASES));
}

/* ================== READ QUEUE ================== */
$dbs = file($queueFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// All done
if (!$dbs || count($dbs) === 0) {
    @unlink($runtimeFile);
    echo "✅ ALL DATABASES IMPORTED SUCCESSFULLY";
    exit;
}

/* ================== NEXT DATABASE ================== */
$db = array_shift($dbs);

// Save remaining DBs back to queue
file_put_contents($queueFile, implode("\n", $dbs));

/* ================== WRITE RUNTIME ================== */
file_put_contents($runtimeFile, <<<PHP
<?php
\$db_server   = '{$DB_SERVER}';
\$db_name     = '{$db}';
\$db_username = '{$DB_USER}';
\$db_password = '{$DB_PASS}';

\$filename = '{$db}.sql.gz';
\$ajax     = true;
PHP
);

/* ================== START BIGDUMP ================== */
header("Location: bigdump.php?start=1&fn={$db}.sql.gz&foffset=0&totalqueries=0");
exit;
