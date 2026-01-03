<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbCleanerController extends Controller
{
    public function run(Request $request)
    {
        // 🔐 Secret check
        if ($request->query('secret') !== env('DB_CLEANER_SECRET')) {
            abort(403, 'Invalid secret');
        }

        $databases = [
            'casamned',
            'casansui',
            // all 60 DB names
        ];

        $result = [];

        foreach ($databases as $db) {
            try {
                DB::statement("USE `$db`");

                $tables = DB::select("
                    SELECT table_name 
                    FROM information_schema.tables 
                    WHERE table_schema = ?
                ", [$db]);

                DB::statement('SET FOREIGN_KEY_CHECKS=0');

                foreach ($tables as $table) {
                    DB::statement("TRUNCATE TABLE `$table->table_name`");
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');

                $result[$db] = 'emptied';

            } catch (\Throwable $e) {
                $result[$db] = 'failed: ' . $e->getMessage();
            }
        }

        return response()->json([
            'status' => 'completed',
            'databases' => $result,
        ]);
    }
}
