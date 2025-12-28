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

class BalanceReportPageTotal extends Controller
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
        return view('BalancePageTotal.fd_balance')->with($data);
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
            return view('BalancePageTotal.balance-book')->with($data);
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
        return view('BalancePageTotal.balance-book')->with($data);
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

        return view('BalancePageTotal.rd_balance')->with($data);
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
        return view('BalancePageTotal.bank_fd_balance')->with($data);
    }
    public function loanAdvanceReport(Request $request)
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
        $_loanReport = loan_ac_model::select('id','parnote_no','date_of_advance','account_no','open_new_ac_model_id','amount','loan_purpose','guarnter_one','guarnter_two')
            ->with('open_new_ac_model')
            ->orderBy('date_of_advance','asc')
            ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->whereBetween('date_of_advance',[$this->from,$this->toDate]);
        if($request->loan_type)
        {
            $_loanReport = $_loanReport->where('loan_type',$request->loan_type);
        }
        $_loanReport = $_loanReport->get();

        $_loanTotal = loan_ac_model::select('id','date_of_advance','amount')
            ->with('open_new_ac_model')
            ->whereBetween('date_of_advance',[$this->from,$this->toDate]);
        if ($request->loan_type) {
            $_loanTotal = $_loanTotal->where('loan_type',$request->loan_type);
        }

        $_loanTotal = $_loanTotal->sum('amount');

        $data = [
            'branch' => $request->branch,
            'loan_type' => $request->loan_type,
            'from_date' => $this->from,
            'to_date' => $this->toDate,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'loan_types'    =>  loan_model::all(),
            '_loanReport' => $_loanReport,
            '_loanTotal' => $_loanTotal,
        ];

        return view('BalancePageTotal.loan-advancement')->with($data);
    }
}
