<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbExportController extends Controller
{
    public function run(Request $request)
    {
        if ($request->query('secret') !== config('db_exporter.secret')) {
            return response()->json(['status' => 'error'], 403);
        }

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $databases  = config('db_exporter.databases', []);
        $exportPath = config('db_exporter.path');

        if (!is_dir($exportPath)) {
            mkdir($exportPath, 0755, true);
        }

        $progressFile = storage_path('db-export-progress.txt');
        $index = file_exists($progressFile) ? (int)file_get_contents($progressFile) : 0;

        // ✅ DONE
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

        gzwrite($fp, "-- Database: {$db}\n");
        gzwrite($fp, "-- Exported at: " . date('Y-m-d H:i:s') . "\n\n");
        gzwrite($fp, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $tableObj) {
            $table = array_values((array)$tableObj)[0];

            // Table structure
            $create = DB::select("SHOW CREATE TABLE `$table`")[0]->{'Create Table'};
            gzwrite($fp, "DROP TABLE IF EXISTS `$table`;\n{$create};\n\n");

            // Table data (LIMITED rows per request)
            $rows = DB::select("SELECT * FROM `$table` LIMIT 10000");

            foreach ($rows as $row) {
                $values = array_map(function ($v) {
                    return is_null($v) ? 'NULL' : "'" . addslashes($v) . "'";
                }, (array)$row);

                gzwrite($fp,
                    "INSERT INTO `$table` VALUES (" . implode(',', $values) . ");\n"
                );
            }

            gzwrite($fp, "\n");
        }

        gzwrite($fp, "SET FOREIGN_KEY_CHECKS=1;\n");
        gzclose($fp);

        // Move to next DB
        file_put_contents($progressFile, $index + 1);

        return response()->json([
            'status'   => 'exported',
            'database' => $db,
            'file'     => basename($file),
        ]);
    }
}
