<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\tbl_ledger_model;
use Auth;
use DB;
use Response;

class updateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth'); 
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {

        return view(MASTER_UPDATE_MASTER.'edit-tbl-ledger');
    }

    public function update(Request $request)
    {
// For Gtype column
            DB::table('tbl_ledger_models')->where('gtype', 'Non Member Fixed Deposit')->update(['gtype' => 'NOMINAL MEMBER FIXED DEPOSIT']);
            DB::table('tbl_ledger_models')->where('gtype', 'Non Member RD')->update(['gtype' => 'NOMINAL MEMBER RD']);
            DB::table('tbl_ledger_models')->where('gtype', 'Non Member Saving')->update(['gtype' => 'NOMINAL MEMBER SAVING']);
            DB::table('tbl_ledger_models')->where('gtype', 'Non Member MIS')->update(['gtype' => 'NOMINAL MEMBER MIS']);
            DB::table('tbl_ledger_models')->where('gtype', 'Interest Paid On Non Member Fixed Deposit')->update(['gtype' => 'INTEREST PAID ON NOMINAL MEMBER FIXED DEPOSIT']);
            DB::table('tbl_ledger_models')->where('gtype', 'Interest Paid On Non Member Rd')->update(['gtype' => 'INTEREST PAID ON NOMINAL MEMBER RD']);
            DB::table('tbl_ledger_models')->where('gtype', 'INTEREST PAID ON NON MEMBER MIS')->update(['gtype' => 'INTEREST PAID ON NOMINAL MEMBER MIS']);
            DB::table('tbl_ledger_models')->where('gtype', 'INTEREST PAID ON NON MEMBER SAVING')->update(['gtype' => 'INTEREST PAID ON NOMINAL MEMBER SAVING']);

// For stype column
            DB::table('tbl_ledger_models')->where('stype', 'Non Member Fixed Deposit')->update(['stype' => 'NOMINAL MEMBER FIXED DEPOSIT']);
            DB::table('tbl_ledger_models')->where('stype', 'Non Member RD')->update(['stype' => 'NOMINAL MEMBER RD']);
            DB::table('tbl_ledger_models')->where('stype', 'Non Member Saving')->update(['stype' => 'NOMINAL MEMBER SAVING']);
            DB::table('tbl_ledger_models')->where('stype', 'Non Member MIS')->update(['stype' => 'NOMINAL MEMBER MIS']);
            DB::table('tbl_ledger_models')->where('stype', 'Interest Paid On Non Member Fixed Deposit')->update(['stype' => 'INTEREST PAID ON NOMINAL MEMBER FIXED DEPOSIT']);
            DB::table('tbl_ledger_models')->where('stype', 'Interest Paid On Non Member Rd')->update(['stype' => 'INTEREST PAID ON NOMINAL MEMBER RD']);
            DB::table('tbl_ledger_models')->where('stype', 'INTEREST PAID ON NON MEMBER MIS')->update(['stype' => 'INTEREST PAID ON NOMINAL MEMBER MIS']);
            DB::table('tbl_ledger_models')->where('stype', 'INTEREST PAID ON NON MEMBER SAVING')->update(['stype' => 'INTEREST PAID ON NOMINAL MEMBER SAVING']);
// For Main Head column
            DB::table('tbl_ledger_models')->where('main_head', 'Non Member Fixed Deposit')->update(['main_head' => 'NOMINAL MEMBER FIXED DEPOSIT']);
            DB::table('tbl_ledger_models')->where('main_head', 'Non Member RD')->update(['main_head' => 'NOMINAL MEMBER RD']);
            DB::table('tbl_ledger_models')->where('main_head', 'Non Member Saving')->update(['main_head' => 'NOMINAL MEMBER SAVING']);
            DB::table('tbl_ledger_models')->where('main_head', 'Non Member MIS')->update(['main_head' => 'NOMINAL MEMBER MIS']);
            DB::table('tbl_ledger_models')->where('main_head', 'Interest Paid On Non Member Fixed Deposit')->update(['main_head' => 'INTEREST PAID ON NOMINAL MEMBER FIXED DEPOSIT']);
            DB::table('tbl_ledger_models')->where('main_head', 'Interest Paid On Non Member Rd')->update(['main_head' => 'INTEREST PAID ON NOMINAL MEMBER RD']);
            DB::table('tbl_ledger_models')->where('main_head', 'INTEREST PAID ON NON MEMBER MIS')->update(['main_head' => 'INTEREST PAID ON NOMINAL MEMBER MIS']);
            DB::table('tbl_ledger_models')->where('main_head', 'INTEREST PAID ON NON MEMBER SAVING')->update(['main_head' => 'INTEREST PAID ON NOMINAL MEMBER SAVING']);            
            
               $return_url = '';
                return response()->json(['success'=>'<li><span>Success!</span> Record Successfully Updated..</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
            
    }
}
