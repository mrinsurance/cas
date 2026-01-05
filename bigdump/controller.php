<?php

// ===== SECURITY (OPTIONAL BUT RECOMMENDED) =====
if (!isset($_GET['secret']) || $_GET['secret'] !== 'hp20nbd') {
    http_response_code(403);
    exit('Forbidden');
}

$queueFile   = __DIR__ . '/queue.txt';
$runtimeFile = __DIR__ . '/bigdump-runtime.php';

// ===== READ QUEUE =====
$dbs = file($queueFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!$dbs || count($dbs) === 0) {
    echo "✅ ALL DATABASES IMPORTED SUCCESSFULLY";
    @unlink($runtimeFile);
    exit;
}

// ===== GET NEXT DATABASE =====
$db = array_shift($dbs);

// Save remaining queue
file_put_contents($queueFile, implode("\n", $dbs));

// ===== WRITE RUNTIME CONFIG =====
file_put_contents($runtimeFile, <<<PHP
<?php
\$db_server   = 'localhost';
\$db_name     = '{$db}';
\$db_username = 'himachal';
\$db_password = '6nwf6ji1w6yn';

\$filename = '{$db}.sql.gz';
\$ajax     = true;
PHP
);

// ===== REDIRECT TO BIGDUMP =====
header("Location: bigdump.php?start=1&fn={$db}.sql.gz");
exit;
