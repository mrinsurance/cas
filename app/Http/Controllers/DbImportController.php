<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbImportController extends Controller
{
    public function run(Request $request)
    {
        try {
            // 🔐 Secret check
            if ($request->query('secret') !== config('db_exporter.secret')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid secret',
                ], 403);
            }

            ini_set('memory_limit', '512M');
            set_time_limit(0);

            $databases = config('db_exporter.databases', []);
            $path      = config('db_exporter.path');

            // Progress file
            $progressFile = storage_path('db-import-progress.txt');
            $index = file_exists($progressFile)
                ? (int) file_get_contents($progressFile)
                : 0;

            // All done
            if (!isset($databases[$index])) {
                @unlink($progressFile);
                return response()->json([
                    'status' => 'completed',
                ]);
            }

            $db   = $databases[$index];
            $file = "{$path}/{$db}.sql.gz";

            if (!file_exists($file)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Missing file: {$db}.sql.gz",
                ], 500);
            }

            // Switch DB safely
            config(['database.connections.mysql.database' => $db]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // 🔥 Stream SQL.GZ
            $fp = gzopen($file, 'r');
            if (!$fp) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unable to open SQL file',
                ], 500);
            }

            $query = '';

            while (!gzeof($fp)) {
                $line = trim(gzgets($fp));

                // Skip comments
                if ($line === '' ||
                    strpos($line, '--') === 0 ||
                    strpos($line, '/*') === 0
                ) {
                    continue;
                }

                $query .= $line . ' ';

                if (substr($line, -1) === ';') {
                    DB::unprepared($query);
                    $query = '';
                }
            }

            gzclose($fp);

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // Save progress
            file_put_contents($progressFile, $index + 1);

            return response()->json([
                'status'   => 'imported',
                'database' => $db,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
