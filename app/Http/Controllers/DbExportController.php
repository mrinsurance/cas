<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbExportController extends Controller
{
    public function run(Request $request)
    {
        if ($request->query('secret') !== config('db_importer.secret')) {
            abort(403);
        }

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $databases  = config('db_importer.databases');
        $exportPath = config('db_importer.path');

        if (!is_dir($exportPath)) {
            mkdir($exportPath, 0755, true);
        }

        $progressFile = storage_path('db-export-progress.txt');
        $index = file_exists($progressFile)
            ? (int) file_get_contents($progressFile)
            : 0;

        if (!isset($databases[$index])) {
            @unlink($progressFile);
            return response()->json(['status' => 'completed']);
        }

        $db = $databases[$index];
        $file = "{$exportPath}/{$db}.sql.gz";

        // Switch DB safely
        config(['database.connections.mysql.database' => $db]);
        DB::purge('mysql');
        DB::reconnect('mysql');

        // 🔥 OPEN GZIP FILE
        $fp = gzopen($file, 'w9');

        gzwrite($fp, "-- Database: {$db}\n");
        gzwrite($fp, "-- Exported at: " . now() . "\n\n");
        gzwrite($fp, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $tableObj) {
            $table = array_values((array)$tableObj)[0];

            // Structure
            $create = DB::select("SHOW CREATE TABLE `$table`")[0]->{'Create Table'};
            gzwrite($fp, "DROP TABLE IF EXISTS `$table`;\n");
            gzwrite($fp, $create . ";\n\n");

            // Data
            DB::table($table)->orderByRaw('1')->chunk(500, function ($rows) use ($fp, $table) {
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

        gzwrite($fp, "\nSET FOREIGN_KEY_CHECKS=1;\n");
        gzclose($fp);

        file_put_contents($progressFile, $index + 1);

        return response()->json([
            'status'   => 'exported',
            'database' => $db,
            'file'     => $file,
            'next'     => url('/db-export/run?secret=' . $request->query('secret')),
        ]);
    }
}
