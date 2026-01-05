<?php

/* ================== CONFIG ================== */

// secret token
$SECRET = 'hp20nbd';

// databases to import (MASTER LIST)
$ALL_DATABASES = [
    'casadarsh',
    'casbalduhak',
    'casbara',
];

// DB credentials
$DB_SERVER = 'localhost';
$DB_USER   = 'himachal';
$DB_PASS   = '6nwf6ji1w6yn';

/* ================== SECURITY ================== */
if (!isset($_GET['secret']) || $_GET['secret'] !== $SECRET) {
    http_response_code(403);
    exit('Forbidden');
}

/* ================== FILES ================== */
$queueFile     = __DIR__ . '/queue.txt';
$runtimeFile   = __DIR__ . '/bigdump-runtime.php';
$completedFile = __DIR__ . '/.completed';
$lockFile      = __DIR__ . '/.running';

/* ================== RESET MODE ================== */
if (isset($_GET['reset']) && $_GET['reset'] == '1') {
    @unlink($queueFile);
    @unlink($completedFile);
}

/* ================== LOCK PROTECTION ================== */
if (file_exists($lockFile)) {
    echo "⛔ Import already running. Please wait until it finishes.";
    exit;
}
file_put_contents($lockFile, time());

/* ================== STOP IF ALREADY DONE ================== */
if (file_exists($completedFile)) {
    @unlink($lockFile);
    echo "✅ Import already completed today.<br>
          To run again, open:<br>
          <code>?secret={$SECRET}&reset=1</code>";
    exit;
}

/* ================== INIT QUEUE ================== */
if (!file_exists($queueFile)) {
    file_put_contents($queueFile, implode("\n", $ALL_DATABASES));
}

/* ================== READ QUEUE ================== */
$dbs = file($queueFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

/* ================== ALL DONE ================== */
if (!$dbs || count($dbs) === 0) {
    @unlink($runtimeFile);
    @unlink($lockFile);
    file_put_contents($completedFile, date('Y-m-d H:i:s'));
    echo "✅ ALL DATABASES IMPORTED SUCCESSFULLY. PROCESS STOPPED.";
    exit;
}

/* ================== NEXT DATABASE ================== */
$db = array_shift($dbs);
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
