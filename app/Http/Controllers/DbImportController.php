<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbImportController extends Controller
{
    public function run(Request $request)
    {
        // 🔐 Secret check
        if ($request->query('secret') !== config('db_importer.secret')) {
            abort(403);
        }

        file_put_contents(
    storage_path('step1.txt'),
    "Reached run()\n",
    FILE_APPEND
);


        // prevent timeout / memory crash
        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $databases = config('db_importer.databases');
        $basePath  = config('db_importer.path');

        // ✅ FILE-BASED PROGRESS (instead of Cache)
        $progressFile = storage_path('db-import-progress.txt');
        $currentIndex = file_exists($progressFile)
            ? (int) file_get_contents($progressFile)
            : 0;

            

        if (!isset($databases[$currentIndex])) {
            return response()->json([
                'status' => 'completed',
                'message' => 'All databases imported',
            ]);
        }

        $db = $databases[$currentIndex];

       $file = "{$basePath}/{$db}.sql";

              try {
    DB::statement("USE `$db`");
    file_put_contents(storage_path('step3.txt'), "DB USE OK: $db\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents(storage_path('db_error.txt'), $e->getMessage());
    exit('DB PERMISSION ERROR');
}

        if (!file_exists($file)) {
            abort(500, "SQL file missing for {$db}");
        }

        

        // 🔍 DB permission test
        DB::statement("USE `$db`");
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        // ✅ STREAM SQL FILE (NO MEMORY ISSUE)
        $handle = fopen($file, 'r');
        $query = '';

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);

            // skip comments / empty lines
            if ($line === '' || str_starts_with($line, '--')) {
                continue;
            }

            $query .= $line . "\n";

            if (substr($line, -1) === ';') {
                DB::unprepared($query);
                $query = '';
            }
        }

        fclose($handle);

        DB::statement("SET FOREIGN_KEY_CHECKS=1");

        // update progress
        file_put_contents($progressFile, $currentIndex + 1);

        return response()->json([
            'status' => 'imported',
            'database' => $db,
            'next' => url('/db-import/run?secret=' . $request->query('secret')),
        ]);
    }
}
