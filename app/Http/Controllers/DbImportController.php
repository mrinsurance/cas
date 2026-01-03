<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbImportController extends Controller
{
    public function run(Request $request)
    {
        if ($request->query('secret') !== config('db_importer.secret')) {
            abort(403);
        }

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $databases = config('db_importer.databases');
        $path      = config('db_importer.path');

        $progressFile = storage_path('db-import-progress.txt');
        $index = file_exists($progressFile)
            ? (int) file_get_contents($progressFile)
            : 0;

        if (!isset($databases[$index])) {
            @unlink($progressFile);
            return response()->json(['status' => 'completed']);
        }

        $db   = $databases[$index];
        $file = "{$path}/{$db}.sql.gz";

        if (!file_exists($file)) {
            abort(500, "Missing file: {$file}");
        }

        // switch DB safely
        config(['database.connections.mysql.database' => $db]);
        DB::purge('mysql');
        DB::reconnect('mysql');

        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        $fp = gzopen($file, 'r');
        $query = '';

        while (!gzeof($fp)) {
            $line = trim(gzgets($fp));

            if ($line === '' || str_starts_with($line, '--') || str_starts_with($line, '/*')) {
                continue;
            }

            $query .= $line . ' ';

            if (str_ends_with($line, ';')) {
                DB::unprepared($query);
                $query = '';
            }
        }

        gzclose($fp);

        DB::statement("SET FOREIGN_KEY_CHECKS=1");

        file_put_contents($progressFile, $index + 1);

        return response()->json([
            'status'   => 'imported',
            'database' => $db,
            'next'     => url('/db-import/run?secret=' . $request->query('secret')),
        ]);
    }
}
