<?php

$config = require __DIR__ . '/config.php';

if (!isset($_GET['secret']) || $_GET['secret'] !== $config['secret']) {
    http_response_code(403);
    exit('Forbidden');
}

$progressFile = __DIR__ . '/.progress';
$index = file_exists($progressFile) ? (int) file_get_contents($progressFile) : 0;

$databases = $config['databases'];

if (!isset($databases[$index])) {
    @unlink($progressFile);
    @unlink(__DIR__ . '/bigdump-runtime.php');
    echo "✅ ALL DATABASES IMPORTED";
    exit;
}

$dbName = $databases[$index];

// 🔥 CREATE bigdump-runtime.php HERE
file_put_contents(__DIR__ . '/bigdump-runtime.php', <<<PHP
<?php
\$db_server   = '127.0.0.1';
\$db_name     = '{$dbName}';
\$db_username = '{$config['db_username']}';
\$db_password = '{$config['db_password']}';
\$filename    = '{$dbName}.sql.gz';
\$use_gzip    = true;
\$ajax        = true;
PHP
);

// Save progress
file_put_contents($progressFile, $index + 1);

// Redirect to BigDump
header("Location: bigdump.php?start=1&fn={$dbName}.sql.gz");
exit;
