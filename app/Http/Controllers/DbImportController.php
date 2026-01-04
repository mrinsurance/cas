<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbImportController extends Controller
{
    public function run(Request $request)
    {
        try {
            // 🔐 Secret check (JSON only)
            if ($request->query('secret') !== config('db_exporter.secret')) {
                return response()->json([
                    'status'  => 'error',
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

            // ✅ All databases imported
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
                    'status'  => 'error',
                    'message' => "Missing file: {$db}.sql.gz",
                ], 500);
            }

            // 🔄 Switch DB safely
            config(['database.connections.mysql.database' => $db]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            // Defensive DB session setup
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::statement("SET SESSION sql_mode=''");

            // 🔥 Open gzip stream
            $fp = gzopen($file, 'r');
            if (!$fp) {
                throw new \Exception("Cannot open file {$file}");
            }

            $query = '';
            $queryCount = 0;

            while (!gzeof($fp)) {
                $line = trim(gzgets($fp));

                // Skip comments / empty
                if (
                    $line === '' ||
                    strpos($line, '--') === 0 ||
                    strpos($line, '/*') === 0
                ) {
                    continue;
                }

                $query .= $line . ' ';

                if (substr($line, -1) === ';') {
                    try {
                        DB::unprepared($query);
                        $queryCount++;
                    } catch (\Throwable $e) {
                        // ❗ Do NOT break the import
                        // Log and continue
                        file_put_contents(
                            storage_path('db-import-errors.txt'),
                            "[{$db}] Query failed: " . substr($query, 0, 300) . "\n" . $e->getMessage() . "\n\n",
                            FILE_APPEND
                        );
                    }

                    $query = '';
                }

                // 🧯 Safety flush (avoid huge memory build-up)
                if (strlen($query) > 1024 * 1024) { // 1MB
                    $query = '';
                }
            }

            gzclose($fp);

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // Save progress
            file_put_contents($progressFile, $index + 1);

            return response()->json([
                'status'      => 'imported',
                'database'    => $db,
                'queries_run' => $queryCount,
            ]);

        } catch (\Throwable $e) {
            // 🚨 ALWAYS JSON — NEVER HTML
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
