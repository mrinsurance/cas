<?php

namespace App\Http\Controllers\Ledger;

use App\fd_ac_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\branch_model;
use App\company_address_model;
use App\tbl_ledger_model;
use App\group_master_model;
use App\subgroup_master_model;
use App\member_type_model;
use App\open_new_ac_model;
use App\share_ac_model;
use App\saving_ac_model;
use App\loan_ac_model;
use App\tbl_loan_return_model;
use DB;

class reportController extends Controller
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

    public function printPersonalLedger(Request $request)
    {

    	/*if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
		$_lists = [];*/
        $shareData = share_ac_model::with('open_new_ac_model')->where('member_type_model_id',$request->member_type)->select('account_no','open_new_ac_model_id')
            ->orderByRaw('CAST(account_no AS UNSIGNED)')
            ->groupBy(DB::raw('CAST(account_no AS UNSIGNED)'))
            ->paginate(50);
//        dd($shareData->toArray());
    	$data = [
            '_members' => member_type_model::orderBy('name','asc')->get(),
    		'company_address' => company_address_model::first(),
            '_holder' => open_new_ac_model::where('account_no',$request->account)
                            ->where('member_type_model_id',$request->member_type)
                            ->first(),
            'shareData' =>$shareData,
    	];
        return view(LEDGER_REPORT.'/print-personal_ledger')->with($data);
    }

    public function personalLedger(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
        $_lists = [];
// Share
        $_share = DB::table('share_ac_models')
            ->select(
                "share_ac_models.date_of_transaction as dt",
                "share_ac_models.amount as share_amt",
                "share_ac_models.type_of_transaction as share_mode",
                DB::raw("NULL as loan"),
                DB::raw("NULL as loan_r"),
                DB::raw("NULL as intr"),
                DB::raw("NULL as saving_amt"),
                DB::raw("NULL as saving_mode"))
            ->where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->whereBetween('date_of_transaction',[$this->from,$this->toDate]);
// Loan Advance
        $_loan_model = DB::table("loan_ac_models")
            ->select(
                "loan_ac_models.date_of_advance as dt",
                DB::raw("NULL as share_amt"),
                DB::raw("NULL as share_mode"),
                "loan_ac_models.amount as loan",
                DB::raw("NULL as loan_r"),
                DB::raw("NULL as intr"),
                DB::raw("NULL as saving_amt"),
                DB::raw("NULL as saving_mode"))
            ->where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->whereBetween('date_of_advance',[$this->from,$this->toDate]);
// Loan Return
        $_loan_return = DB::table('tbl_loan_return_models')
            ->select(
                "tbl_loan_return_models.received_date as dt",
                DB::raw("NULL as share_amt"),
                DB::raw("NULL as share_mode"),
                DB::raw("NULL as loan"),
                "tbl_loan_return_models.received_principal as loan_r",
                "tbl_loan_return_models.received_interest as intr",
                DB::raw("NULL as saving_amt"),
                DB::raw("NULL as saving_mode"))
            ->where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->whereBetween('received_date',[$this->from,$this->toDate]);
// Saving
        $_saving = DB::table("saving_ac_models")
            ->select(
                "saving_ac_models.date_of_transaction as dt",
                DB::raw("NULL as share_amt"),
                DB::raw("NULL as share_mode"),
                DB::raw("NULL as loan"),
                DB::raw("NULL as loan_r"),
                DB::raw("NULL as intr"),
                "saving_ac_models.amount as saving_amt",
                "saving_ac_models.type_of_transaction as saving_mode")
            ->where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
            ->unionAll($_loan_model)
            ->unionAll($_loan_return)
            ->unionAll($_share)
            ->orderBy('dt','asc')
            ->get();

// Share
        $_opening_share_dr = share_ac_model::where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->where('type_of_transaction','Deposit')
            ->where('date_of_transaction','<',$this->from)
            ->sum('amount');
        $_opening_share_cr = share_ac_model::where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->where('type_of_transaction','Withdrawal')
            ->where('date_of_transaction','<',$this->from)
            ->sum('amount');

// Saving
        $_opening_saving_dr = saving_ac_model::where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->where('type_of_transaction','Deposit')
            ->where('date_of_transaction','<',$this->from)
            ->sum('amount');

        $_opening_saving_cr = saving_ac_model::where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->where('type_of_transaction','Withdrawal')
            ->where('date_of_transaction','<',$this->from)
            ->sum('amount');

// Loan Advance
        $_opening_loan_dr = loan_ac_model::where('account_no',$request->account)
            ->where('member_type_model_id',$request->member_type)
            ->where('date_of_advance','<',$this->from)
            ->sum('amount');

// Loan Return
        $_opening_loan_cr = tbl_loan_return_model::where('account_no',$request->account)
            ->where('received_date','<',$this->from)
            ->sum('received_principal');


        $data = [
            'from_date' => $this->from,
            'to_date' => $this->toDate,
            'member_type' => $request->member_type,
            '_members' => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            '_holder' => open_new_ac_model::where('account_no',$request->account)
                ->where('member_type_model_id',$request->member_type)
                ->first(),
            '_ledger' => $_saving,
            '_opening_share_bal' => ($_opening_share_dr - $_opening_share_cr),
            '_opening_loan_bal' => ($_opening_loan_dr - $_opening_loan_cr),
            '_opening_saving_bal' => ($_opening_saving_dr - $_opening_saving_cr),
        ];





        return view(LEDGER_REPORT.'/personal_ledger')->with($data);
    }

    public function fdLedger(Request $request)
    {
        $toDate = $request->to_date ?: date('Y-m-d');

        $fdLedgers = fd_ac_model::query()
            ->where('account_no', $request->account)
            ->where('member_type_model_id', $request->member_type)
            ->whereDate('transaction_date', '<=', $toDate)
            ->orderBy('transaction_date')
            ->get();

        return view('Ledger.fd-ledger')->with([
            'to_date' => $toDate,
            'member_type' => $request->member_type,
            '_members' => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            '_holder' => open_new_ac_model::where('account_no', $request->account)
                ->where('member_type_model_id', $request->member_type)
                ->first(),
            '_fd_ledgers' => $fdLedgers
        ]);
    }


    public function printFdLedger(Request $request)
    {
        $toDate = $request->to_date;
        $memberType = $request->member_type;

        // Step 1: Get all unique accounts with FD under this member type
        $accounts = fd_ac_model::query()
            ->where('member_type_model_id', $memberType)
            ->when($toDate, fn ($q) => $q->whereDate('transaction_date', '<=', $toDate))
            ->select('account_no')
            ->distinct()
            ->pluck('account_no');

        // Step 2: Process each account separately
        $allLedgers = [];

        foreach ($accounts as $accountNo) {
            $holder = open_new_ac_model::where('account_no', $accountNo)
                ->where('member_type_model_id', $memberType)
                ->first();

            if (!$holder) {
                continue;
            }

            $ledgers = fd_ac_model::query()
                ->where('account_no', $accountNo)
                ->where('member_type_model_id', $memberType)
                ->when($toDate, fn ($q) => $q->whereDate('transaction_date', '<=', $toDate))
                ->orderBy('transaction_date')
                ->get();

            if ($ledgers->isNotEmpty()) {
                $allLedgers[] = [
                    'holder' => $holder,
                    'ledgers' => $ledgers,
                ];
            }
        }

        return view('Ledger.print-fd-ledger', [
            'to_date' => $toDate,
            'company_address' => company_address_model::first(),
            'allLedgers' => $allLedgers,
            '_members' => member_type_model::orderBy('name', 'asc')->get(),
        ]);
    }



    public function headLedger(Request $request)
    {
    	if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }

             $sname = subgroup_master_model::select('id','name');
            if($request->subgroup)
            {
                $sname = $sname->where('id',$request->subgroup);
            }
            $sname = $sname->first();

			$openingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
				->where('main_head',$sname->name)
				->where('type_of_transaction','Dr')
				->where('date_of_transaction' ,'<', $this->from)
				->sum('amount');
			$openingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
				->where('main_head',$sname->name)
				->where('type_of_transaction','Cr')
				->where('date_of_transaction' ,'<', $this->from)
				->sum('amount');
			
			$closingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
				->where('main_head',$sname->name)
				->where('type_of_transaction','Dr')
				->where('date_of_transaction' ,'<=', $this->toDate)
				->sum('amount');
			$closingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
				->where('main_head',$sname->name)
				->where('type_of_transaction','Cr')
				->where('date_of_transaction' ,'<=', $this->toDate)
				->sum('amount');
           

			
    	$data = [
    		'branch' => $request->branch,
            'subgroup' => $request->subgroup,
    		'from_date' => $this->from,
    		'to_date' => $this->toDate,
    		'branches' => branch_model::orderBy('name','asc')->get(),
            'groups' => group_master_model::orderBy('name','asc')->get(),
            'subgroups' => subgroup_master_model::orderBy('name','asc')->get(),
            'subname' =>$sname,
    		'company_address' => company_address_model::first(),
    		'tblLedgers' => tbl_ledger_model::select('id','amount','main_head','account_no','particular','date_of_transaction','type_of_transaction')
    			->where('main_head',$sname->name)
    			->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->orderBy('date_of_transaction','asc')
    			->get(),
    		'openingDrSum' => $openingDrSum,
			'openingCrSum' => $openingCrSum,
			'opening' => $openingCrSum - $openingDrSum,
			'closingDrSum' => $closingDrSum,
			'closingCrSum' => $closingCrSum,
			'closing' => $closingCrSum - $closingDrSum,
    	];
        return view(LEDGER_REPORT.'/head_ledger')->with($data);
    }

    public function generalLedger(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }

        $sname = subgroup_master_model::select('id','name');
        if($request->subgroup)
        {
            $sname = $sname->where('id',$request->subgroup);
        }
        $sname = $sname->first();

        $openingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head',$sname->name)
            ->where('type_of_transaction','Dr')
            ->where('date_of_transaction' ,'<', $this->from)
            ->sum('amount');
        $openingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head',$sname->name)
            ->where('type_of_transaction','Cr')
            ->where('date_of_transaction' ,'<', $this->from)
            ->sum('amount');

        $closingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head',$sname->name)
            ->where('type_of_transaction','Dr')
            ->where('date_of_transaction' ,'<=', $this->toDate)
            ->sum('amount');
        $closingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head',$sname->name)
            ->where('type_of_transaction','Cr')
            ->where('date_of_transaction' ,'<=', $this->toDate)
            ->sum('amount');



        $data = [
            'branch' => $request->branch,
            'subgroup' => $request->subgroup,
            'from_date' => $this->from,
            'to_date' => $this->toDate,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'groups' => group_master_model::orderBy('name','asc')->get(),
            'subgroups' => subgroup_master_model::orderBy('name','asc')->get(),
            'subname' =>$sname,
            'company_address' => company_address_model::first(),
            'tblLedgers' => tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                ->groupBy('date_of_transaction')
                ->where('main_head',$sname->name)
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->orderBy('date_of_transaction','asc')
                ->get(),
            'openingDrSum' => $openingDrSum,
            'openingCrSum' => $openingCrSum,
            'opening' => $openingCrSum - $openingDrSum,
            'closingDrSum' => $closingDrSum,
            'closingCrSum' => $closingCrSum,
            'closing' => $closingCrSum - $closingDrSum,
        ];
        return view(LEDGER_REPORT.'/general_ledger')->with($data);
    }


    public function generalLedgerAll(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }

        $sname = subgroup_master_model::select('id','name');
        if($request->subgroup)
        {
            $sname = $sname->where('id',$request->subgroup);
        }
        $sname = $sname->first();


        $openingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head',$sname->name)
            ->where('type_of_transaction','Dr')
            ->where('date_of_transaction' ,'<', $this->from)
            ->sum('amount');
        $openingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head',$sname->name)
            ->where('type_of_transaction','Cr')
            ->where('date_of_transaction' ,'<', $this->from)
            ->sum('amount');

        $closingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head',$sname->name)
            ->where('type_of_transaction','Dr')
            ->where('date_of_transaction' ,'<=', $this->toDate)
            ->sum('amount');
        $closingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->where('main_head',$sname->name)
            ->where('type_of_transaction','Cr')
            ->where('date_of_transaction' ,'<=', $this->toDate)
            ->sum('amount');



        $data = [
            'branch' => $request->branch,
            'subgroup' => $request->subgroup,
            'from_date' => $this->from,
            'to_date' => $this->toDate,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'groups' => group_master_model::orderBy('name','asc')->get(),
            'subgroups' => subgroup_master_model::orderBy('name','asc')->get(),
            'subname' =>$sname,
            'company_address' => company_address_model::first(),
            'tblLedgers' => tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                ->groupBy('date_of_transaction')
                ->where('main_head',$sname->name)
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->orderBy('date_of_transaction','asc')
                ->get(),
            'openingDrSum' => $openingDrSum,
            'openingCrSum' => $openingCrSum,
            'opening' => $openingCrSum - $openingDrSum,
            'closingDrSum' => $closingDrSum,
            'closingCrSum' => $closingCrSum,
            'closing' => $closingCrSum - $closingDrSum,
        ];
        return view(LEDGER_REPORT.'/general_ledger')->with($data);
    }
}
