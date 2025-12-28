<?php

namespace App\Http\Controllers\Balance;

use App\saving_ac_model;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\branch_model;
use App\bank_model;
use App\loan_model;
use App\open_new_ac_model;
use App\session_master_model;
use App\share_ac_model;
use App\dds_ac_model;
use App\company_address_model;
use App\fd_ac_model;
use App\rd_model;
use App\rd_installment_model;
use App\drd_model;
use App\drd_installment_model;
use App\mis_model;
use App\mis_installment_model;
use App\bank_fd_ac_model;
use App\member_type_model;
use App\loan_ac_model;
use App\loan_ac_installment;
use App\tbl_loan_return_model;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportBalanceBook;

class balanceController extends Controller
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

    // Share Balance
    public function index(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        $open_new_ac_model = open_new_ac_model::with('share_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }
        if($request->from_date){
            $ac_holders = $open_new_ac_model->paginate(500);
        }else{
            $ac_holders = [];
        }
        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];
        return view(BALANCE_REPORT.'share_balance')->with($data);
    }
    // DDS Balance
    public function ddsBalance(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        $open_new_ac_model = open_new_ac_model::with('dds_ac_model')
            ->whereHas('dds_ac_model', function($q){
                $q->groupBy('open_new_ac_model_id');
            })->orderBy('account_no','asc');
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }
        if($request->from_date){
            $ac_holders = $open_new_ac_model->paginate(300);
        }else{
            $ac_holders =[];
        }

        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];

        return view(BALANCE_REPORT.'dds_balance')->with($data);
    }

// Saving Balance
    public function UpdateSavingBalance()
    {
        $openModel = open_new_ac_model::select('member_type_model_id','account_no','id')->get();
        foreach($openModel as $model)
        {
            saving_ac_model::whereMemberTypeModelId($model->member_type_model_id)->whereAccountNo($model->account_no)->update(['open_new_ac_model_id'=>$model->id]);
        }

    }
// Share Balance
    public function UpdateShareBalance()
    {
        $openModel = open_new_ac_model::select('member_type_model_id','account_no','id')->get();
        foreach($openModel as $model)
        {
            share_ac_model::whereMemberTypeModelId($model->member_type_model_id)->whereAccountNo($model->account_no)->update(['open_new_ac_model_id'=>$model->id]);
        }

    }
// Update Loan Return Member Type
    public function UpdateLoanReturnMemberType()
    {
        $openModel = loan_ac_model::select('member_type_model_id','account_no','id')->get();
        foreach($openModel as $model)
        {
            tbl_loan_return_model::whereLoanAcModelId($model->id)->update(['member_type_model_id'=>$model->member_type_model_id]);
        }

    }
    public function savingBalance(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }


        $open_new_ac_model = open_new_ac_model::with('saving_ac_model')->whereHas('saving_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }
        if($request->from_date){
            $ac_holders = $open_new_ac_model->get();
        }else{
            $ac_holders =[];
        }
        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];

        return view(BALANCE_REPORT.'saving_balance')->with($data);
    }
    public function savingBalancePaginate(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
            $data = [
                'branch'        => '',
                'member_type'   => '',
                'from_date'     => '',
                'branches'      => branch_model::orderBy('name','asc')->get(),
                'members'       => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'ac_holders'    => [],
            ];
            return view(BALANCE_REPORT.'saving_balance_paginate')->with($data);

        }
        else
        {
            $this->from = $request->from_date;
        }


        $open_new_ac_model = open_new_ac_model::with('saving_ac_model')->whereHas('saving_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }
        $ac_holders = $open_new_ac_model->paginate(320);

        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];

        return view(BALANCE_REPORT.'saving_balance_paginate')->with($data);
    }
// Detailed Balance Report
    // Share Balance
    public function detailShareBal(Request $request){
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
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->to_date;
        }
        $data['branch'] = $request->branch;
        $data['member_type'] = $request->member_type;
        // return $this->from;
        $data['from_date'] = $this->from;
        $data['to_date'] = $this->to;

        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['members'] = member_type_model::orderBy('name','asc')->get();

        $open_new_ac_model = open_new_ac_model::with('share_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy('account_no','asc');
        if($data['branch'])
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$data['branch']);
        }
        if($data['member_type'])
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$data['member_type']);
        }
        $data['ac_holders'] = $open_new_ac_model->get();
        $data['company_address'] = company_address_model::first();

        return view(BALANCE_REPORT.'share_detailed_balance')->with($data);
    }
// DDS Balance
    public function detailDDSBal(Request $request){
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
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->to_date;
        }
        $data['branch'] = $request->branch;
        $data['member_type'] = $request->member_type;
        // return $this->from;
        $data['from_date'] = $this->from;
        $data['to_date'] = $this->to;

        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['members'] = member_type_model::orderBy('name','asc')->get();

        $open_new_ac_model = open_new_ac_model::with('dds_ac_model')->whereHas('dds_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy('account_no','asc');
        if($data['branch'])
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$data['branch']);
        }
        if($data['member_type'])
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$data['member_type']);
        }
        $data['ac_holders'] = $open_new_ac_model->get();
        $data['company_address'] = company_address_model::first();

        return view(BALANCE_REPORT.'dds_detailed_balance')->with($data);
    }
// Saving Balance
    public function detailSavingBal(Request $request){
        if($request->from_date == "")
        {
            $this->from = '';
        }
        else
        {
            $this->from = $request->from_date;
        }
        if($request->to_date == "")
        {
            $this->to = '';
        }
        else
        {
            $this->to = $request->to_date;
        }
        $data['branch'] = $request->branch;
        $data['member_type'] = $request->member_type;
        // return $this->from;
        $data['from_date'] = $this->from;
        $data['to_date'] = $this->to;

        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['members'] = member_type_model::orderBy('name','asc')->get();
        if($data['from_date'] !='' && $data['to_date']!=''){
            $open_new_ac_model = open_new_ac_model::with('saving_ac_model')->whereHas('saving_ac_model', function($q){
                $q->groupBy('open_new_ac_model_id');
            })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
            if($data['branch'])
            {
                $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$data['branch']);
            }
            if($data['member_type'])
            {
                $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$data['member_type']);
            }
            $data['ac_holders'] = $open_new_ac_model->paginate(100)->appends([
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'branch' => $request->branch,
                'member_type' => $request->member_type,
            ]);

        }else{
            $data['ac_holders'] = [];
        }
        $data['company_address'] = company_address_model::first();

        return view(BALANCE_REPORT.'saving_detailed_balance')->with($data);
    }
// FD Balance
    public function fdBalance(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $this->member = $request->member_type;
        $this->DT = $request->deposit_type;

        $data['branch'] = $request->branch;
        $data['member_type'] = $request->member_type;
        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['members'] = member_type_model::orderBy('name','asc')->get();
        $data['company_address'] = company_address_model::first();
        $data['type_of_deposite'] = ["FIXED DEPOSIT","LONG TERM DEPOSIT","SHORT TERM DEPOSIT"];
        // return $this->from;
        $data['from_date'] = $this->from;

        $items = fd_ac_model::with('open_new_ac_model');
        if($request->orderBy == 1)
        {
            $items->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        }
        else
        {
            $items->orderBy(DB::raw('CAST(fd_no AS UNSIGNED), fd_no'));
        }

        $items->where(function($query){
            $query->where('transaction_date', '<=', $this->from);
            if($this->member)
            {
                $query->where('member_type_model_id',$this->member);
            }
            if($this->DT)
            {
                $query->where('type_of_deposite',$this->DT);
            }
            $query->where('status',1);
        })->orWhere(function($query){
            $query->where('transaction_date', '<=', $this->from)
                ->where('matured_on_date', '>', $this->from)
                ->where('status',0);
            if($this->member)
            {
                $query->where('member_type_model_id',$this->member);
            }
            if($this->DT)
            {
                $query->where('type_of_deposite',$this->DT);
            }
        });
        if($request->from_date){
            $data['items'] = $items->get();
        }else{
            $data['items'] = [];
        }
        return view(BALANCE_REPORT.'fd_balance')->with($data);
    }
// Bank FD Balance
    public function bankFDBalance(Request $request){
        // return $request->all();
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $this->bank_id = $request->bank;

        $items = bank_fd_ac_model::orderBy('int_run_from','asc')
            ->where(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('status',1);
                if($this->bank_id)
                {
                    $query->where('bank_model_id',$this->bank_id);
                }
            })->orWhere(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('matured_on_date', '>', $this->from)
                    ->where('status',0);
                if($this->bank_id)
                {
                    $query->where('bank_model_id',$this->bank_id);
                }
            });
        if($request->from_date){
            $items = $items->get();
        }else{
            $items =[];
        }


        $data = [
            'branch' => $request->branch,
            'bank' => $request->bank,
            'member_type' => $request->member_type,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'banks' => bank_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'from_date' => $this->from,
            'items' => $items,
        ];
        return view(BALANCE_REPORT.'bank_fd_balance')->with($data);
    }
// Bank FD By Day Balance
    public function bankFDByDayBalance(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $this->bank_id = $request->bank;

        $items = bank_fd_ac_model::orderBy('int_run_from','asc')
            ->where(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('status',1);
                if($this->bank_id)
                {
                    $query->where('bank_model_id',$this->bank_id);
                }
            })->orWhere(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('matured_on_date', '>', $this->from)
                    ->where('status',0);
                if($this->bank_id)
                {
                    $query->where('bank_model_id',$this->bank_id);
                }
            });
        if($request->from_date){
            $items = $items->get();
        }else{
            $items = [];
        }
        $data = [
            'branch' => $request->branch,
            'bank' => $request->bank,
            'member_type' => $request->member_type,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'banks' => bank_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'from_date' => $this->from,
            'items' => $items,
        ];
        return view(BALANCE_REPORT.'by-day-bank-fd-balance')->with($data);
    }
// RD Balance
    public function rdBalance(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $this->member = $request->member_type;
        $items = rd_model::with('open_new_ac_model')
            ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->where(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('status',1);
                if($this->member)
                {
                    $query->where('member_type_model_id',$this->member);
                }
            })->orWhere(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('matured_on_date', '>', $this->from)
                    ->where('status',0);
                if($this->member)
                {
                    $query->where('member_type_model_id',$this->member);
                }
            });
        if($request->from_date){
            $items = $items->get();
        }else{
            $items = [];
        }


        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'from_date'     => $this->from,
            'items'         => $items,
        ];

        return view(BALANCE_REPORT.'rd_balance')->with($data);
    }
// DRD Balance
    public function drdBalance(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $this->member = $request->member_type;
        $items = drd_model::with('open_new_ac_model')->orderBy('transaction_date','asc')
            ->where(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('status',1);
                if ($this->member)
                {
                    $query->where('member_type_model_id',$this->member);
                }
            })->orWhere(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('matured_on_date', '>', $this->from)
                    ->where('status',0);
                if ($this->member)
                {
                    $query->where('member_type_model_id',$this->member);
                }
            });

        $items = $items->get();
        $data = [
            'branch' => $request->branch,
            'member_type' => $request->member_type,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'members' => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'from_date' => $this->from,
            'items' => $items,
        ];
        return view(BALANCE_REPORT.'drd_balance')->with($data);
    }
// MIS Balance
    public function misBalance(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        $items = mis_model::with('open_new_ac_model')->orderBy('start_date','asc')
            ->where(function($query){
                $query->where('start_date', '<=', $this->from)
                    ->where('status',1);
            })->orWhere(function($query){
                $query->where('start_date', '<=', $this->from)
                    ->where('matured_on_date', '>', $this->from)
                    ->where('status',0);
            });
        if ($request->member_type) {
            $items = $items->where('member_type_model_id',$request->member_type);
        }
        $items = $items->get();
        $data = [
            'branch' => $request->branch,
            'member_type' => $request->member_type,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'members' => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'from_date' => $this->from,
            'items' => $items,
        ];
        return view(BALANCE_REPORT.'mis_balance')->with($data);
    }
    // Balance book saving and share
    //
    public function balancesharesaving(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
            $data = [
                'branch'        => '',
                'member_type'   => '',
                'from_date'     => '',
                'branches'      => branch_model::orderBy('name','asc')->get(),
                'members'       => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'ac_holders'    =>[],
            ];
            return view(BALANCE_REPORT.'balance-share-saving')->with($data);
        }
        else
        {
            $this->from = $request->from_date;
        }

        $open_new_ac_model = open_new_ac_model::with('share_ac_model','loan_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }

        $ac_holders = $open_new_ac_model->get();

        if($request->submit)
        {
            $ac_holders = $ac_holders;
        }
        else{
            $ac_holders = [];
        }
        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];
        return view(BALANCE_REPORT.'balance-share-saving')->with($data);
    }
// Loan Balance
    public function loanBalance(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        $items = loan_ac_model::orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->orderBy('date_of_advance','asc')
            ->where('date_of_advance','<=',$this->from);
        if($request->member_type)
        {
            $items = $items->where('member_type_model_id',$request->member_type);
        }
        if($request->loan_type)
        {
            $items = $items->where('loan_type',$request->loan_type);
        }
        if($request->from_date){
            $items = $items->get();
        }else{
            $items = [];
        }


        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'loan_type'     => $request->loan_type,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'loan_types'    => loan_model::all(),
            'from_date'     => $this->from,
            'items'         => $items,
        ];
        // dd($data['items']);
        return view(BALANCE_REPORT.'loan_balance')->with($data);
    }
// Loan Balance 2
    public function loanBalanceSecond(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        $items = loan_ac_model::orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->orderBy('date_of_advance','asc')
            ->where('date_of_advance','<=',$this->from);
        if($request->member_type)
        {
            $items = $items->where('member_type_model_id',$request->member_type);
        }
        if($request->loan_type)
        {
            $items = $items->where('loan_type',$request->loan_type);
        }
        if($request->from_date){
            $items = $items->get();
        }else{
            $items = [];
        }


        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'loan_type'     => $request->loan_type,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'loan_types'    => loan_model::all(),
            'from_date'     => $this->from,
            'items'         => $items,
        ];
        // dd($data['items']);
        return view(BALANCE_REPORT.'loan_balance2')->with($data);
    }


// Balance Book Status
    public function balanceBookStatuspost(Request $request){
        $input = $request->all();
        $data['ac_holder_id'] = $input['ac_holder_id'];
        $data['status'] = $input['status'];
        $data['session_id'] = $input['session'];
        $check = DB::table('balance_book_status')->where(['ac_holder_id'=>$data['ac_holder_id'],'session_id'=>$data['session_id']])->first();
        if(@$check->id){
            DB::table('balance_book_status')->where(['ac_holder_id'=>$data['ac_holder_id'],'session_id'=>$data['session_id']])->update($data);
            echo 1;
            exit;
        }
        if(DB::table('balance_book_status')->insert($data)){
            echo 1;
        }else{
            echo 0;
        }

    }

    public function updateOpenTableField(Request $request)
    {
        $validatedData = $request->validate([
            'field' => 'required|string|in:father_name,village,ward',
            'value' => 'nullable|string',
            'ac_holder_id' => 'required|integer'
        ]);

        $field = $validatedData['field'];
        $value = $validatedData['value'];
        $acHolderId = $validatedData['ac_holder_id'];

        try {
            $result = DB::table('open_new_ac_models')
                ->updateOrInsert(
                    ['id' => $acHolderId],
                    [$field => $value]
                );

            return response()->json([
                'success' => true,
                'message' => ucfirst(str_replace('_', ' ', $field)) . ' updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update ' . ucfirst(str_replace('_', ' ', $field)) . '. Please try again.'
            ]);
        }
    }


    public function balanceBookStatus(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
            $data = [
                'session_list' => session_master_model::orderBy('start_date','asc')->get(),
                'branch'        => '',
                'member_type'   => '',
                'from_date'     => '',
                'branches'      => branch_model::orderBy('name','asc')->get(),
                'members'       => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'ac_holders'    =>[],
            ];
            return view(BALANCE_REPORT.'balance-book-status')->with($data);
        }
        else
        {
            $this->from = $request->from_date;
        }

        $open_new_ac_model = open_new_ac_model::with('share_ac_model','loan_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }

        $ac_holders = $open_new_ac_model->get();

        if($request->submit)
        {
            $ac_holders = $ac_holders;
        }
        else{
            $ac_holders = [];
        }
        $data = [
            'session_list' => session_master_model::orderBy('start_date','asc')->get(),
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];
        // echo '<pre>'; print_r($data['ac_holders']);die;
        return view(BALANCE_REPORT.'balance-book-status')->with($data);
    }

    // Balance Book List
    public function balanceBookList(Request $request){

        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
            $data = [
                'session_list' => session_master_model::orderBy('start_date','asc')->get(),
                'branch'        => '',
                'member_type'   => '',
                'from_date'     => '',
                'branches'      => branch_model::orderBy('name','asc')->get(),
                'members'       => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'ac_holders'    =>[],
            ];
            return view('Balance.balance-book-list')->with($data);
        }
        else
        {
            $this->from = $request->from_date;
        }

        $open_new_ac_model = open_new_ac_model::with('share_ac_model','loan_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }

        $ac_holders = $open_new_ac_model->get();

        if($request->submit)
        {
            $ac_holders = $ac_holders;
        }
        else{
            $ac_holders = [];
        }
        $data = [
            'session_list' => session_master_model::orderBy('start_date','asc')->get(),
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];
        // echo '<pre>'; print_r($data['ac_holders']);die;
        return view('Balance.balance-book-list')->with($data);
    }
// balance book
    public function balanceBook(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
            $data = [
                'branch'        => '',
                'member_type'   => '',
                'from_date'     => '',
                'branches'      => branch_model::orderBy('name','asc')->get(),
                'members'       => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'ac_holders'    =>[],
            ];
            return view(BALANCE_REPORT.'balance-book')->with($data);
        }
        else
        {
            $this->from = $request->from_date;
        }

        $open_new_ac_model = open_new_ac_model::with('share_ac_model','loan_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }

        $ac_holders = $open_new_ac_model->paginate(32);

        if($request->submit)
        {
            $ac_holders = $ac_holders;
        }
        else{
            $ac_holders = [];
        }
        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];
        return view(BALANCE_REPORT.'balance-book')->with($data);
    }

    public function productsExport(Request $request)
    {
        return Excel::download(new ExportBalanceBook, 'users.xlsx');
    }
    public function generatePDF(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        $open_new_ac_model = open_new_ac_model::with('share_ac_model','loan_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }

        $ac_holders = $open_new_ac_model->get();

        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];

        $pdf = PDF::loadView(BALANCE_REPORT.'balance-book-pdf', $data);

        return $pdf->download('itsolutionstuff.pdf');
    }

    public function balanceBookPaginate(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
            $data = [
                'branch'        => '',
                'member_type'   => '',
                'from_date'     => '',
                'branches'      => branch_model::orderBy('name','asc')->get(),
                'members'       => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'ac_holders'    =>[],
            ];
            return view(BALANCE_REPORT.'balance-book-paginate')->with($data);
        }
        else
        {
            $this->from = $request->from_date;
        }

        $open_new_ac_model = open_new_ac_model::with('share_ac_model','loan_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->branch)
        {
            $open_new_ac_model = $open_new_ac_model->where('branch_model_id',$request->branch);
        }
        if($request->member_type)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$request->member_type);
        }

        $ac_holders = $open_new_ac_model->paginate(320);

        if($request->submit)
        {
            $ac_holders = $ac_holders;
        }
        else{
            $ac_holders = [];
        }
        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'from_date'     => $this->from,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'ac_holders'    => $ac_holders,
        ];
        return view(BALANCE_REPORT.'balance-book-paginate')->with($data);
    }
    public function loanDefaulter(Request $request)
    {
        $this->defaulter_year = $request->defaulter_year;
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $ward = $request->ward;
        $items = loan_ac_model::with(['open_new_ac_model' => function($query) use ($ward) {
            if($ward == true)
            {
                $query->where('ward',$ward);
            }
        }])
            ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->orderBy('date_of_advance','asc')
            ->where('date_of_advance','<=',$this->from);
        if($request->member_type)
        {
            $items = $items->where('member_type_model_id',$request->member_type);
        }
        if($request->loan_type)
        {
            $items = $items->where('loan_type',$request->loan_type);
        }
        $items = $items->get();

        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'loan_type'     => $request->loan_type,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'loan_types'    => loan_model::all(),
            'from_date'     => $this->from,
            'items'         => $items,
            'years'         => range(1,20),
            'defaulter_year' => $this->defaulter_year,
            'userWard' => open_new_ac_model::groupBy('ward')->where('ward','!=','')->orderBy(DB::raw('CAST(ward AS UNSIGNED), ward'))->get(),
            'wardNo' => $ward,
        ];
        // dd($data['items']);
        return view(BALANCE_REPORT.'loan-defaulter')->with($data);
    }

    public function npaReport(Request $request)
    {
        $this->defaulter_year = $request->defaulter_year;
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        $items = loan_ac_model::with('open_new_ac_model')
            ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->orderBy('date_of_advance','asc')
            ->where('date_of_advance','<=',$this->from)
            ->whereNotIn('loan_type',[3]);
        if($request->member_type)
        {
            $items = $items->where('member_type_model_id',$request->member_type);
        }
        if($request->loan_type)
        {
            $items = $items->where('loan_type',$request->loan_type);
        }
        if($request->from_date){
            $items = $items->get();
        }else{
            $items = [];
        }

        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'loan_type'     => $request->loan_type,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'loan_types'    => loan_model::all(),
            'from_date'     => $this->from,
            'items'         => $items,
            'years'         => range(1,20),
            'defaulter_year' => $this->defaulter_year,
        ];

        return view(BALANCE_REPORT.'/npa')->with($data);
    }

    // Fixed Deposit Second
    public function fdBalanceSecond(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $this->member = $request->member_type;
        $this->DT = $request->deposit_type;

        $data['branch'] = $request->branch;
        $data['member_type'] = $request->member_type;
        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['members'] = member_type_model::orderBy('name','asc')->get();
        $data['company_address'] = company_address_model::first();
        $data['type_of_deposite'] = ["FIXED DEPOSIT","LONG TERM DEPOSIT","SHORT TERM DEPOSIT"];
        // return $this->from;
        $data['from_date'] = $this->from;

        $items = fd_ac_model::with('open_new_ac_model');
        if($request->orderBy == 1)
        {
            $items->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        }
        else
        {
            $items->orderBy(DB::raw('CAST(fd_no AS UNSIGNED), fd_no'));
        }

        $items->where(function($query){
            $query->where('transaction_date', '<=', $this->from);
            if($this->member)
            {
                $query->where('member_type_model_id',$this->member);
            }
            if($this->DT)
            {
                $query->where('type_of_deposite',$this->DT);
            }
            $query->where('status',1);
        })->orWhere(function($query){
            $query->where('transaction_date', '<=', $this->from)
                ->where('matured_on_date', '>', $this->from)
                ->where('status',0);
            if($this->member)
            {
                $query->where('member_type_model_id',$this->member);
            }
            if($this->DT)
            {
                $query->where('type_of_deposite',$this->DT);
            }
        });
        if($request->from_date){
            $data['items'] = $items->get();
        }else{
            $data['items'] = [];
        }
        return view(BALANCE_REPORT.'fd_balance_second')->with($data);
    }
    // RD Balance Second
    public function rdBalanceSecond(Request $request){
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }
        $this->member = $request->member_type;
        $items = rd_model::with('open_new_ac_model')
            ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->where(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('status',1);
                if($this->member)
                {
                    $query->where('member_type_model_id',$this->member);
                }
            })->orWhere(function($query){
                $query->where('transaction_date', '<=', $this->from)
                    ->where('matured_on_date', '>', $this->from)
                    ->where('status',0);
                if($this->member)
                {
                    $query->where('member_type_model_id',$this->member);
                }
            });
        if($request->from_date){
            $items = $items->get();
        }else{
            $items = [];
        }


        $data = [
            'branch'        => $request->branch,
            'member_type'   => $request->member_type,
            'branches'      => branch_model::orderBy('name','asc')->get(),
            'members'       => member_type_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'from_date'     => $this->from,
            'items'         => $items,
        ];

        return view(BALANCE_REPORT.'rd_balance_second')->with($data);
    }
}
