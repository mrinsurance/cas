<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Now you can call Laravel DB facade safely
use Illuminate\Support\Facades\DB;

$databases = config('dbcleaner.databases', []);
foreach ($databases as $db) {
    echo "Cleaning $db...\n";
    DB::statement("USE `$db`");
    $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = ?", [$db]);
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    foreach ($tables as $t) {
        DB::statement("TRUNCATE TABLE `$t->table_name`");
    }
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
}

echo "Done.\n";
