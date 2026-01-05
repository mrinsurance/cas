<?php

if ($_GET['secret'] !== 'hp20nbd') {
    http_response_code(403);
    exit('Forbidden');
}

$queueFile = __DIR__ . '/queue.txt';

if (!file_exists($queueFile)) {
    file_put_contents($queueFile, implode("\n", [
        'casadarsh',
        'casbalduhak',
        'casbara'
    ]));
}

$dbs = file($queueFile, FILE_IGNORE_NEW_LINES);
$db  = array_shift($dbs);

file_put_contents($queueFile, implode("\n", $dbs));

file_put_contents(__DIR__.'/bigdump-runtime.php', <<<PHP
<?php
\$db_server   = '127.0.0.1';
\$db_username = 'himachal';
\$db_password = '6nwf6ji1w6yn';
\$db_name     = '{$db}';
\$filename    = '{$db}.sql.gz';
\$ajax        = true;
PHP);

header("Location: bigdump.php?start=1&fn={$db}.sql.gz");
exit;
