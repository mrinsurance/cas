<?php

$config = require __DIR__ . '/config.php';

/* ================= SECURITY ================= */
if (!isset($_GET['secret']) || $_GET['secret'] !== $config['secret']) {
    http_response_code(403);
    exit('Forbidden');
}

/* ================= FILES ================= */
$queueFile = __DIR__ . '/queue.txt';
$runtime   = __DIR__ . '/bigdump-runtime.php';

/* ================= INIT QUEUE ================= */
if (!file_exists($queueFile)) {
    file_put_contents($queueFile, implode("\n", $config['databases']));
}

/* ================= READ QUEUE ================= */
$dbs = file($queueFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!$dbs || count($dbs) === 0) {
    @unlink($queueFile);
    @unlink($runtime);
    echo "✅ ALL DATABASES IMPORTED SUCCESSFULLY";
    exit;
}

/* ================= NEXT DB ================= */
$db = array_shift($dbs);
file_put_contents($queueFile, implode("\n", $dbs));

$sqlFile = realpath($config['sql_path'] . "/{$db}.sql.gz");

if (!$sqlFile || !file_exists($sqlFile)) {
    exit("❌ SQL file not found for database: {$db}");
}

/* ================= RUNTIME CONFIG ================= */
file_put_contents($runtime, <<<PHP
<?php
\$db_server   = '{$config['db_server']}';
\$db_username = '{$config['db_username']}';
\$db_password = '{$config['db_password']}';
\$db_name     = '{$db}';
\$filename    = '{$db}.sql.gz';
\$ajax        = true;
\$auto_proceed = true;
PHP
);

/* ================= REDIRECT ================= */
header("Location: bigdump.php?start=1&fn={$db}.sql.gz");
exit;
