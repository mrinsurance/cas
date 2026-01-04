<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbExportController extends Controller
{
    public function run(Request $request)
    {
        try {
            // 🔐 Secret check (JSON only)
            if ($request->query('secret') !== config('db_exporter.secret')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid secret'
                ], 403);
            }

            ini_set('memory_limit', '512M');
            set_time_limit(0);

            $databases  = config('db_exporter.databases');
            $exportPath = config('db_exporter.path');

            if (empty($databases)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No databases configured'
                ], 500);
            }

            if (!is_dir($exportPath)) {
                mkdir($exportPath, 0755, true);
            }

            if (!is_writable($exportPath)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Export path not writable: ' . $exportPath
                ], 500);
            }

            $progressFile = storage_path('db-export-progress.txt');
            $index = file_exists($progressFile)
                ? (int) file_get_contents($progressFile)
                : 0;

            if (!isset($databases[$index])) {
                @unlink($progressFile);
                return response()->json(['status' => 'completed']);
            }

            $db   = $databases[$index];
            $file = "{$exportPath}/{$db}.sql.gz";

            // Switch DB
            config(['database.connections.mysql.database' => $db]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            $fp = gzopen($file, 'w9');
            if (!$fp) {
                throw new \Exception("Cannot create file: {$file}");
            }

            gzwrite($fp, "-- Database: {$db}\n");
            gzwrite($fp, "-- Exported at: " . date('Y-m-d H:i:s') . "\n\n");
            gzwrite($fp, "SET FOREIGN_KEY_CHECKS=0;\n\n");

            $tables = DB::select('SHOW TABLES');

            foreach ($tables as $tableObj) {
                $table = array_values((array)$tableObj)[0];

                $create = DB::select("SHOW CREATE TABLE `$table`")[0]->{'Create Table'};
                gzwrite($fp, "DROP TABLE IF EXISTS `$table`;\n");
                gzwrite($fp, $create . ";\n\n");

                DB::table($table)->orderByRaw('1')->chunk(200, function ($rows) use ($fp, $table) {
                    foreach ($rows as $row) {
                        $values = array_map(function ($value) {
                            return is_null($value)
                                ? 'NULL'
                                : "'" . addslashes($value) . "'";
                        }, (array)$row);

                        gzwrite(
                            $fp,
                            "INSERT INTO `$table` VALUES (" . implode(',', $values) . ");\n"
                        );
                    }
                });

                gzwrite($fp, "\n");
            }

            gzwrite($fp, "SET FOREIGN_KEY_CHECKS=1;\n");
            gzclose($fp);

            file_put_contents($progressFile, $index + 1);

            return response()->json([
                'status'   => 'exported',
                'database' => $db,
                'file'     => $file
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
