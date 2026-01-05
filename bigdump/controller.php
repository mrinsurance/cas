<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$config = require __DIR__ . '/config.php';

echo "<pre>";
var_dump($_GET['secret'] ?? 'NO_SECRET');
var_dump($config['secret'] ?? 'NO_CONFIG_SECRET');
exit;

if ($_GET['secret'] ?? '' !== $config['secret']) {
    http_response_code(403);
    exit('Forbidden');
}

$progressFile = __DIR__ . '/progress.json';
$progress = file_exists($progressFile)
    ? json_decode(file_get_contents($progressFile), true)
    : ['index' => 0];

$index = $progress['index'];

if (!isset($config['databases'][$index])) {
    echo "✅ ALL DATABASES IMPORTED SUCCESSFULLY";
    unlink($progressFile);
    exit;
}

$dbName = $config['databases'][$index];
$sqlFile = $config['sql_path'] . "/{$dbName}.sql.gz";

if (!file_exists($sqlFile)) {
    exit("❌ Missing SQL file: {$sqlFile}");
}

/**
 * Generate dynamic BigDump config
 */
file_put_contents(__DIR__ . '/bigdump-runtime.php', <<<PHP
<?php
\$db_server   = '{$config['db_server']}';
\$db_username = '{$config['db_username']}';
\$db_password = '{$config['db_password']}';
\$db_name     = '{$dbName}';
\$filename    = '{$sqlFile}';
\$use_gzip    = true;
\$auto_proceed = true;
PHP
);

/**
 * Move pointer to next DB BEFORE import
 * (safe even if page refreshes)
 */
file_put_contents($progressFile, json_encode([
    'index' => $index + 1
]));

/**
 * Redirect to BigDump
 */
header("Location: bigdump.php");
exit;
