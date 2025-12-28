<?php

namespace App\Http\Controllers\Daily_Report;

use App\bank_fd_ac_model;
use App\company_address_model;
use App\fd_ac_model;
use App\member_type_model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\tbl_ledger_model;
use App\branch_model;
use App\designation_model;
use App\shadow_model;
use App\saving_ac_model;
use App\dds_ac_model;
use App\rd_installment_model;
use App\drd_installment_model;
use App\tbl_loan_return_model;
use App\User;
use Auth;
use DB;

class dcrController extends Controller
{
	 protected $form, $to, $bank;
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
        if($request->from_date == "" && $request->to_date == "")
        {
            $this->from = date('Y-m-d');
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
            $this->to = $request->to_date;
        }
        // return $this->from;
        $data['from_date'] = $this->from;
        $data['to_date'] = $this->to;

// For Receipt        
        $data['gtype_groups'] = tbl_ledger_model::groupBy('gtype')->whereBetween('date_of_transaction', array($this->from, $this->to))->whereNotin('gtype',['Cash'])->get();

        $query = tbl_ledger_model::whereBetween('date_of_transaction', array($this->from, $this->to));
// With Branch
        if($request->branch)
        {
        	$data['search_branch'] = $request->branch;
        	$data['branch_name'] = branch_model::find($request->branch);
        	$query->where('branch_model_id',$request->branch);
        }
// With User Type
        if($request->user_type)
        {
        	$data['search_user'] = $request->user_type;
        	$data['user_name'] = User::find($request->user_type);
        	$query->where('user_id',$request->user_type);
        } 
        if(Auth::user()->staff_type == 'Agent')
        {
            $query->where('user_id',Auth::user()->id);
        }       
        $data['stypes'] = $query->get();
       
    	$data['branches'] = branch_model::all();
    	$data['users'] = User::with('designation_model')->get();
    	
    	return view(DAILY_REPORT_DCR.'list')->with($data);
    }

    public function shadowFunc()
    {
        if(Auth::user()->hasAnyRole('ACCOUNTANT'))
        {
            $data['items'] = User::where('staff_type','Agent')->orderBy('name','asc')->get();
            return view(DAILY_REPORT_SHADOW.'list')->with($data);
        }
        else
        {
            return redirect(url('/'));
        }
    }
    public function edit($id)
    {
        if(Auth::user()->hasAnyRole('ACCOUNTANT'))
        {
            $data['item'] = User::findOrFail($id);

            $received_pay = tbl_ledger_model::where('main_head','!=','Cash')->where('type_of_transaction','Cr')->where('shadow','0')->where('user_id',$id)->sum(DB::raw('amount + additional_amt'));

            $payment_rec = tbl_ledger_model::where('main_head','!=','Cash')->where('type_of_transaction','Dr')->where('shadow','0')->where('user_id',$id)->sum(DB::raw('amount + additional_amt'));
            $data['due_bal'] = ($received_pay - $payment_rec);
            return view(DAILY_REPORT_SHADOW.'edit')->with($data); 
        }
        else
        {
            return redirect(url('/'));
        }
        
    }

    public function update(Request $request, $id)
    {
        
        saving_ac_model::where('user_id', $id)->update(['shadow' => '1']);
        dds_ac_model::where('user_id', $id)->update(['shadow' => '1']);
        rd_installment_model::where('user_id', $id)->update(['shadow' => '1']);
        drd_installment_model::where('user_id', $id)->update(['shadow' => '1']);
        tbl_loan_return_model::where('user_id', $id)->update(['shadow' => '1']);
        tbl_ledger_model::where('user_id', $id)->update(['shadow' => '1']);

        $item = new shadow_model();
        $item->user_id = Auth::user()->id;
        $item->agent_id = $id;
        $item->amount = $request->due_bal;
        if($item->save())
        {
           $return_url = url(DAILY_REPORT_URL_SHADOW);
            return response()->json(['success'=>'<li><span>Success!</span> Payment received</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
        }
        
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }


    public function FdStatusReport(Request $request){
        if($request->fromDate == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->fromDate;
        }
        if($request->toDate == "")
        {
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->toDate;
        }
        $this->member = $request->member_type;
        $this->DT = $request->deposit_type;
        $data['items'] = [];
        $data['branch'] = $request->branch;
        $data['member_type'] = $request->member_type;
        $data['report'] = $request->report;
        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['members'] = member_type_model::orderBy('name','asc')->get();
        $data['company_address'] = company_address_model::first();
        $data['type_of_deposite'] = ["FIXED DEPOSIT","LONG TERM DEPOSIT","SHORT TERM DEPOSIT"];
        // return $this->from;
        $data['from_date'] = $this->from;
        if ($request->report == 'Payable')
        {
            $items = fd_ac_model::with('open_new_ac_model')
                //->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
                ->orderBy('transaction_date', 'asc')
                ->where(function($query){
                    $query->where('transaction_date', '<=', $this->to)->whereBetween('maturity_date',[$this->from, $this->to]);
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
                    $query->where('transaction_date', '<=', $this->to)
                        ->where('matured_on_date', '>', $this->to)
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
            if($request->fromDate){
                $data['items'] = $items->get();
            }else{
                $data['items'] = [];
            }
        }
        if ($request->report == 'Paid')
        {
            $items = fd_ac_model::with('open_new_ac_model')
                //->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
                ->orderBy('matured_on_date', 'asc')
                ->where(function($query){
                    $query->where('transaction_date', '<=', $this->to)->whereBetween('matured_on_date',[$this->from, $this->to]);
                    if($this->member)
                    {
                        $query->where('member_type_model_id',$this->member);
                    }
                    if($this->DT)
                    {
                        $query->where('type_of_deposite',$this->DT);
                    }

                    $query->where('status',0);
                });
            if($request->fromDate){
                $data['items'] = $items->get();
            }else{
                $data['items'] = [];
            }
        }
        if ($request->report == 'Deposit')
        {
            $items = fd_ac_model::with('open_new_ac_model')
                //->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
                ->orderBy('transaction_date', 'asc')
                ->where(function($query){
                    $query->where('transaction_date', '<=', $this->to)->whereBetween('transaction_date',[$this->from, $this->to]);
                    if($this->member)
                    {
                        $query->where('member_type_model_id',$this->member);
                    }
                    if($this->DT)
                    {
                        $query->where('type_of_deposite',$this->DT);
                    }
                });
            if($request->fromDate){
                $data['items'] = $items->get();
            }else{
                $data['items'] = [];
            }
        }

        return view('Daily_Report.fd-status-report')->with($data);
    }

    public function BankFdStatusReport(Request $request){
        if($request->fromDate == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->fromDate;
        }
        if($request->toDate == "")
        {
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->toDate;
        }


        $data['items'] = [];
        $data['branch'] = $request->branch;
        $data['bank'] = $request->bank;
        $data['report'] = $request->report;
        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['company_address'] = company_address_model::first();
        $data['type_of_deposite'] = ["FIXED DEPOSIT","LONG TERM DEPOSIT","SHORT TERM DEPOSIT"];
        // return $this->from;
        $data['from_date'] = $this->from;
        $this->bank = $request->bank;
        if ($request->report == 'Recoverable')
        {
            $items = bank_fd_ac_model::with('bank_model')
                //->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
                ->orderBy('maturity_date', 'asc')
                ->where(function($query){
                    $query->whereBetween('maturity_date',[$this->from, $this->to]);
                    if($this->bank)
                    {
                        $query->where('bank_model_id',$this->bank);
                    }


                    $query->where('status',1);
                })->orWhere(function($query){
                    $query->where('maturity_date', '<=', $this->to)
                        ->where('matured_on_date', '>', $this->to)
                        ->where('status',0);
                    if($this->bank)
                    {
                        $query->where('bank_model_id',$this->bank);
                    }

                });
            if($request->fromDate){
                $data['items'] = $items->get();
            }else{
                $data['items'] = [];
            }
        }
        if ($request->report == 'Deposit')
        {
            $items = bank_fd_ac_model::with('bank_model')
                //->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
                ->orderBy('transaction_date', 'asc')
                ->where(function($query){
                    $query->whereBetween('transaction_date',[$this->from, $this->to]);
                    if($this->bank)
                    {
                        $query->where('bank_model_id',$this->bank);
                    }

                });
            if($request->fromDate){
                $data['items'] = $items->get();
            }else{
                $data['items'] = [];
            }
        }
        if ($request->report == 'Received')
        {
            $items = bank_fd_ac_model::with('bank_model')
                //->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
                ->orderBy('matured_on_date', 'asc')->whereStatus(0)
                ->where(function($query){
                    $query->whereBetween('matured_on_date',[$this->from, $this->to]);
                    if($this->bank)
                    {
                        $query->where('bank_model_id',$this->bank);
                    }

                });
            if($request->fromDate){
                $data['items'] = $items->get();
            }else{
                $data['items'] = [];
            }
        }

        return view('Daily_Report.bank-fd-status-report')->with($data);
    }

    public function LoanRecoveryReport(Request $request)
    {
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
        if ($request->get('from_date'))
        {
            $from = Carbon::parse($request->get('from_date'))->format('Y-m-d');
        }
        if ($request->get('to_date'))
        {
            $to = Carbon::parse($request->get('to_date'))->format('Y-m-d');
        }

        $loan = tbl_loan_return_model::whereBetween('received_date',[$from,$to])->orderBy('received_date','asc')->get();

        return view('Daily_Report.loan-recovery-report',compact(['from','to','loan']));

    }
}
