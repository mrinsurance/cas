<?php

namespace App\Http\Controllers\Additional;

use App\session_master_model;
use App\subgroup_master_model;
use App\tbl_ledger_model;
use App\year_end_tbl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\branch_model;
use App\bank_model;
use App\open_new_ac_model;
use App\share_ac_model;
use App\company_address_model;
use DB;

class WardReportCtrl extends Controller
{
    protected $defaulter_year, $from, $member, $DT, $bank_id;
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
    public function index(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        
        $open_new_ac_model = open_new_ac_model::with('share_ac_model')->where('status',TRUE)->where('member_type_model_id',1)->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->ward)
        {
            $open_new_ac_model = $open_new_ac_model->where('ward',$request->ward);
        }
        if($request->gender)
        {
            $open_new_ac_model = $open_new_ac_model->where('gender',$request->gender);
        }if($request->category)
        {
            $open_new_ac_model = $open_new_ac_model->where('category',$request->category);
        }
        if ($request->_token)
        {
            $ac_holders = $open_new_ac_model->get();
        }
        else{
            $ac_holders = [];
        }

        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];
        return view(ADDITIONAL_REPORT.'ward-report')->with($data);
    }

    public function SocietyStatus(Request $request)
    {

        if($request->date == "")
        {
            $this->date = date('Y-m-d');
        }
        else
        {
            $this->date = $request->date;
        }

        $this->financial_year = $request->financial_year;
        $session_years = session_master_model::orderBy('start_date','asc')->get();
        $branches = branch_model::orderBy('name','asc')->get();
        if(!$this->financial_year)
        {
            $subgroupTbl = subgroup_master_model::all();
            foreach($subgroupTbl as $data)
            {
                DB::table('tbl_ledger_models')
                    ->where('main_head', $data->name)
                    ->update(['bal_sheet_head_model_id' => $data->bal_sheet_head_model_id]);
            }
            $data = [
                'session_years' => $session_years,
                'branches' => $branches,
            ];
            return view('Additional.society-status')->with($data);
            exit();
        }

        $tblLedgers = tbl_ledger_model::with('bal_sheet_head_model')->select('id','main_head','date_of_transaction','bal_sheet_head_model_id')
            ->orderBy('bal_sheet_head_model_id','asc')
            ->groupBy('bal_sheet_head_model_id')
            ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
            ->whereNotNull('bal_sheet_head_model_id')
            ->where('date_of_transaction','<=',$this->date)
            ->get();

        $netProfit = year_end_tbl::where('session_master_model_id','<',$this->financial_year)->sum('net_profit');
        $lastYearCr = tbl_ledger_model::select('id','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head','LAST YEAR PROFIT')
            ->where('date_of_transaction','<=',$this->date)
            ->where('type_of_transaction','Cr')
            ->sum('amount');
        $lastYearDr = tbl_ledger_model::select('id','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head','LAST YEAR PROFIT')
            ->where('date_of_transaction','<=',$this->date)
            ->where('type_of_transaction','Dr')
            ->sum('amount');


        $data = [
            'session_years' => $session_years,
            'branches' => $branches,
            'company_address' => company_address_model::first(),
            'tblLedgers' => $tblLedgers,
            'yearEndTblData' => year_end_tbl::where('session_master_model_id',$this->financial_year)->first(),
            'lastYrProfit' => ($netProfit + ($lastYearCr - $lastYearDr)),
        ];
        return view('Additional.society-status-report')->with($data);
    }
}
