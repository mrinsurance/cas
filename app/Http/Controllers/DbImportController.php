<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DbImportController extends Controller
{
    public function run(Request $request)
    {
        // 🔐 Secret check
        if ($request->query('secret') !== config('db_importer.secret')) {
            abort(403);
        }

        $databases = config('db_importer.databases');
        $basePath  = config('db_importer.path');

        // progress tracking (important)
        $currentIndex = Cache::get('db_import_index', 0);

        if (!isset($databases[$currentIndex])) {
            return response()->json([
                'status' => 'completed',
                'message' => 'All databases imported',
            ]);
        }

        $db = $databases[$currentIndex];
        $file = "{$basePath}/{$db}.sql";

        if (!file_exists($file)) {
            abort(500, "SQL file missing for {$db}");
        }

        DB::statement("USE `$db`");
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        // ⚡ FAST STREAM IMPORT
        $sql = '';
        foreach (file($file) as $line) {
            if (str_starts_with(trim($line), '--') || trim($line) === '') {
                continue;
            }

            $sql .= $line;

            if (str_ends_with(trim($line), ';')) {
                DB::unprepared($sql);
                $sql = '';
            }
        }

        DB::statement("SET FOREIGN_KEY_CHECKS=1");

        Cache::put('db_import_index', $currentIndex + 1);

        return response()->json([
            'status' => 'imported',
            'database' => $db,
            'next' => url('/db-import/run?secret='.$request->query('secret')),
        ]);
    }
}
