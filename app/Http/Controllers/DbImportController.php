<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DbImportController extends Controller
{
    public function run(Request $request)
    {
        // Secret check
        if ($request->query('secret') !== config('db_importer.secret', 'changeme123')) {
            abort(403, 'Invalid secret');
        }

        // Very important on GoDaddy shared → log everything
        Log::channel('single')->info('DB import started', ['time' => now()]);

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $databases = config('db_importer.databases', []);
        $basePath  = config('db_importer.path', storage_path('sql'));

        $progressFile = storage_path('db-import-progress.txt');
        $currentIndex = file_exists($progressFile) ? (int)file_get_contents($progressFile) : 0;

        if (!isset($databases[$currentIndex])) {
            @unlink($progressFile); // clean up when done
            return response()->json(['status' => 'completed']);
        }

        $db = $databases[$currentIndex];
        $file = "{$basePath}/{$db}.sql";

        if (!file_exists($file)) {
            Log::error("SQL file missing", ['file' => $file]);
            abort(500, "SQL file missing: {$file}");
        }

        // ────────────────────────────────────────────────
        // Critical fix #1: Do NOT use DB::statement("USE `$db`")
        // Most GoDaddy users can't switch DB like that
        // ────────────────────────────────────────────────
        // Solution A: Add USE `$db`; at the very top of your .sql file
        // Solution B: Change Laravel connection on-the-fly (safer)

        config(['database.connections.mysql.database' => $db]);
        DB::purge('mysql');           // important!
        DB::reconnect('mysql');       // force new connection

        Log::info("Switched to database", ['db' => $db]);

        // Test connection
        try {
            DB::connection()->getPdo();
            Log::info("DB connection OK");
        } catch (\Exception $e) {
            Log::error("DB connection failed", ['error' => $e->getMessage()]);
            abort(500, "Cannot connect to {$db}: " . $e->getMessage());
        }

        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        DB::statement("SET SESSION sql_mode=''"); // sometimes helps with strict mode

        $handle = @fopen($file, 'r');
        if (!$handle) {
            abort(500, "Cannot open file: {$file}");
        }

        $query = '';
        $lineCount = 0;
        $queryCount = 0;

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            $lineCount++;

            if ($line === '' || str_starts_with($line, '--') || str_starts_with($line, '/*')) {
                continue;
            }

            $query .= $line . ' ';

            if (str_ends_with(trim($line), ';')) {
                try {
                    DB::unprepared($query);
                    $queryCount++;
                } catch (\Exception $e) {
                    Log::error("Query failed", [
                        'line'   => $lineCount,
                        'query'  => substr($query, 0, 300) . '...',
                        'error'  => $e->getMessage()
                    ]);
                    // You can decide: continue or abort
                    // abort(500, "Query failed at line {$lineCount}");
                }
                $query = '';
            }

            // Safety break — prevent infinite loop or too long request
            if ($lineCount > 500_000) { // adjust
                break;
            }
        }

        fclose($handle);

        DB::statement("SET FOREIGN_KEY_CHECKS=1");

        file_put_contents($progressFile, $currentIndex + 1);

        Log::info("Imported part", ['db' => $db, 'queries' => $queryCount]);

        return response()->json([
            'status'   => 'imported',
            'database' => $db,
            'progress' => $currentIndex + 1,
            'next'     => url('/db-import/run?secret=' . $request->query('secret')),
        ]);
    }
}