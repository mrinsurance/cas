<?php

if (!isset($_GET['secret']) || $_GET['secret'] !== 'hp20nbd') {
    http_response_code(403);
    exit('Forbidden');
}

$queueFile   = __DIR__ . '/queue.txt';
$runtimeFile = __DIR__ . '/bigdump-runtime.php';

$dbs = file($queueFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!$dbs) {
    echo "✅ ALL DATABASES IMPORTED SUCCESSFULLY";
    @unlink($runtimeFile);
    exit;
}

$db = array_shift($dbs);
file_put_contents($queueFile, implode("\n", $dbs));

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

header("Location: bigdump.php?start=1&fn={$db}.sql.gz&foffset=0&totalqueries=0");
exit;
