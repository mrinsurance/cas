<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Schema;



class DownloadsController extends Controller
{     function __construct()
    {
        $this->middleware('auth');
        
    }
    public function downloads()
    {   
        return view(MASTER.'download');
       
    }

}

