<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\open_new_ac_model;
use App\state_model;
use App\district_model;
use App\branch_model;
use App\member_type_model;
use App\fd_ac_model;
use App\tbl_ledger_model;
use App\company_address_model;
use App\interest_on_fd_tbl;
use Auth;
use DB;
use Response;
use PDF;

class fdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $ac_no, $user_id;
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
        if (Schema::hasTable('fd_ac_models')) {
            Schema::table('fd_ac_models', function (Blueprint $table) {
                if (!Schema::hasColumn('fd_ac_models', 'paid_interest')) {
                    $table->double('paid_interest')->default(0);
                }
            });
        }
    }

    public function index(Request $request)
    {
        $items_obj = BalanceFdAmount($request->all());

        $data = [
            'items' => $items_obj,
            'members' => member_type_model::orderBy('name','asc')->get(),
            'account' => $request->account,
            'member' => $request->member,
        ];
       return view(TRANSACTION_FD_AC.'list')->with($data);
    }

    public function accountdetail(Request $request)
    {
        $this->ac_no = $request->ac_no;
        $item = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$this->ac_no)->where('member_type_model_id',$request->member_id)->first();
        if($item){
        $data['open_ac_id'] = $item->id;
        $data['full_name'] = $item->full_name;
        $data['father_name'] = $item->father_name != '' ? $item->father_name : 'N/a';
        $data['address'] = $item->village.' '.$item->post_office.' '.@$item->district_model->name.' - ('.@$item->state_model->name.')';
        $data['branch'] = @$item->branch_model->name;
        if($item->file != '')
        {
            $data['priview'] = url('public').'/'.$item->file;
        }
        if($item->signature != '')
        {
            $data['signature'] = url('public').'/'.$item->signature;
        }

        $data['view_ac_url'] = url('transaction/fixed-deposite/show').'/'.$request->member_id.'/'.$this->ac_no.'/'.$request->_token;

             $balance = fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no);
            $data['balance'] = $balance->sum('amount');
            $activeFd = $balance->where('status',1)->first();

           $data['paid_interest'] = (getSumInterestOnFdById(@$activeFd->id) + $data['balance']);

        $data['base_url'] = url('/');
        
        $items = fd_ac_model::where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->get();

        return response()->json(['list'=>$items,'success'=>$data]);

        }
        else
        {
            return response()->json(['error'=>'A/c detail not found!']);
        }
        
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['type_of_interest'] = ["Simple Interest","Quarterly Interest","Yearly Interest"];

        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter'];
        $data['auto_id'] = fd_ac_model::orderBy('fd_no','desc')->first();
        return view(TRANSACTION_FD_AC."create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'member_type_model_id' => 'required',
            'account_no' => 'bail|required',
            'fd_no' => 'bail|required|numeric',
            'amount' => 'bail|required|numeric',
            'interest_rate' => 'bail|required|numeric',
            'PaidInterest' => 'bail|nullable|numeric',
            'interest_run_from' => 'bail|required',
            'transaction_date' => 'bail|required',
            'period_of_fd' => 'bail|required|numeric',
            'maturity_date' => 'bail|required',
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
            'mode_of_transaction' => 'required',
            'cheque_date' => 'bail|sometimes',
            'cheque_number' => 'bail|sometimes',
            'type_of_deposit' => 'bail|required',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
                        
        ]);

        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
// Member detail            
            $member_detail = open_new_ac_model::where('account_no',$this->ac_no)->where('member_type_model_id',$request->member_type_model_id)->first();            
            $item = new fd_ac_model();
            
                $item->open_new_ac_model_id = $request->open_ac_id;
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->member_type_model_id = $request->member_type_model_id;
                $item->account_no = $this->ac_no;
                $item->fd_no = $request->fd_no;
                $item->amount = $request->amount;
                $item->int_rate = $request->interest_rate;
                $item->paid_interest = $request->PaidInterest;
                $item->int_run_from = $request->interest_run_from;
                $item->transaction_date = $request->transaction_date;
                $item->period_fd = $request->period_of_fd;
                $item->maturity_date = $request->maturity_date;
                $item->matured_on_date = $request->matured_on_date;
                $item->interest_type = $request->type_of_interest;
                $item->maturity_amount = $request->maturity_amount;

                $item->mode_transaction = $request->mode_of_transaction;
                $item->cheque_date = $request->cheque_date;
                $item->cheque_no = $request->cheque_number;
                $item->type_of_deposite = $request->type_of_deposit;
                $item->nominee_name = $request->nominee_name;
                $item->nominee_relation = $request->nominee_relation;
                $item->lf_no = $request->lf_no;
                $item->status = 1;
                $item->session_year = '2019-2020';
                if (Auth::user()->staff_type == 'Agent') {
                  $item->shadow = 0;
                }
                $item->token = $request->_token;
                
                if($item->save())
                {
               $memebr_item =  member_type_model::where('id',$request->member_type_model_id)->first();

// SMS sending Code start
$mobile1 = $member_detail->contact_no;                
$message = "Dear Customer your FD with the account no. (". $item->account_no .") & FD no. (". $item->fd_no .") has been created on ". date('d-M-Y', strtotime($item->transaction_date)) ." of Rs.". $item->amount."/- interest @".$item->int_rate."% for ". $item->period_fd ." months.";
sendSms($mobile1, $message);

// Sms sending Code End 

// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' FIXED DEPOSIT';
                   $tbl_item->stype = $memebr_item->name.' '.$request->type_of_deposit;

                   $tbl_item->date_of_transaction = $request->transaction_date;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'FIXED DEPOSIT';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = $member_detail->full_name .' FD No '. $request->fd_no;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->fd_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->main_head = $memebr_item->name.' '.$request->type_of_deposit;
                   $tbl_item->form_name = 'FIXED DEPOSIT';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->agent_id = $member_detail->agent_name;
                   $tbl_item->member_type_model_id = $request->member_type_model_id;
                   $tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $tbl_item->shadow = 0;
                    }
                   
                   $tbl_item->save();

                   $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);

                   $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                   $update_tbl_ledger_model->voucher_no = $voucher;
                   $update_tbl_ledger_model->save();
// ********************
        // Cash entry                    
// ********************
// Member type
                

                $cash_tbl_item = new tbl_ledger_model();
                if($request->mode_of_transaction == 'Cash')
                {
                    $cash_tbl_item->gtype = 'Cash';
                    $cash_tbl_item->stype = 'Cash';
                    $cash_tbl_item->main_head = 'Cash';
                }
                else{
                    $cash_tbl_item->gtype = 'Transfer';
                    $cash_tbl_item->stype = 'Transfer';
                    $cash_tbl_item->main_head = 'Transfer';
                }
                 
                   $cash_tbl_item->date_of_transaction = $request->transaction_date;
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->account_no = $request->account_no;
                   $cash_tbl_item->account_head = 'FIXED DEPOSIT';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->particular = $member_detail->full_name .' FD No '. $request->fd_no;
                   $cash_tbl_item->fd_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->form_name = 'FIXED DEPOSIT';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->agent_id = $member_detail->agent_name;
                   $cash_tbl_item->member_type_model_id = $request->member_type_model_id;
                   $cash_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $cash_tbl_item->shadow = 0;
                    }
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();
                
                   
                   $return_url = url(TRANSACTION_URL_FD_AC);
                    return response()->json(['success'=>'<li><span>Success!</span> The New Record Inserted Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
         //Auth::login($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $member_id = null, $account_id = null)
    {
        // return "Welcome = ".$member_id;
        $items = fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$member_id)->where('account_no',$account_id)->get();
        // dd($items);
        return view(TRANSACTION_FD_AC.'list',compact(['items']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['item'] = fd_ac_model::find($id);
        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['type_of_interest'] = ["Simple Interest","Quarterly Interest","Yearly Interest"];

        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter'];
        $data['customer'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $data['balance'] = fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',1)->sum('amount');

        return view(TRANSACTION_FD_AC.'edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'bail|required|numeric',
            'interest_rate' => 'bail|required|numeric',
            'paid_interest' => 'bail|nullable|numeric',
            'interest_run_from' => 'bail|required',
            'transaction_date' => 'bail|required',
            'period_of_fd' => 'bail|required|numeric',
            'maturity_date' => 'bail|required',
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
            'mode_of_transaction' => 'required',
            'cheque_date' => 'bail|sometimes',
            'cheque_number' => 'bail|sometimes',
            'type_of_deposit' => 'bail|required',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
            'fd_no' => 'bail|required|numeric',

        ]);

        if ($validator->passes()) {
            
            $item = fd_ac_model::find($id);
// Member detail            
            $member_detail = open_new_ac_model::where('account_no',$item->account_no)->where('member_type_model_id',$item->member_type_model_id)->first();            
                $item->fd_no = $request->fd_no;
                $item->amount = $request->amount;
                $item->open_new_ac_model_id = $member_detail->id;
                $item->int_rate = $request->interest_rate;
                $item->paid_interest = $request->PaidInterest;
                $item->int_run_from = $request->interest_run_from;
                $item->transaction_date = $request->transaction_date;
                $item->period_fd = $request->period_of_fd;
                $item->maturity_date = $request->maturity_date;
                $item->matured_on_date = $request->matured_on_date;
                $item->interest_type = $request->type_of_interest;
                $item->maturity_amount = $request->maturity_amount;

                $item->mode_transaction = $request->mode_of_transaction;
                $item->cheque_date = $request->cheque_date;
                $item->cheque_no = $request->cheque_number;
                $item->type_of_deposite = $request->type_of_deposit;
                $item->nominee_name = $request->nominee_name;
                $item->nominee_relation = $request->nominee_relation;
                $item->lf_no = $request->lf_no;
                $item->session_year = '2019-2020';
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                if (Auth::user()->staff_type == 'Agent') {
                  $item->shadow = 0;
                }
                $item->token = $request->_token;
                
                if($item->save())
                {
               $memebr_item =  member_type_model::where('id',$item->member_type_model_id)->first();
// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = tbl_ledger_model::where('fd_ac_model_id',$id)->where('account_head','FIXED DEPOSIT')->where('stype',$memebr_item->name.' '.$request->type_of_deposit)->first();

                                      
                   $tbl_item->gtype = $memebr_item->name. ' FIXED DEPOSIT';
                   $tbl_item->stype = $memebr_item->name.' '.$request->type_of_deposit;

                   $tbl_item->date_of_transaction = $request->transaction_date;
                   
                   $tbl_item->account_head = 'FIXED DEPOSIT';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->fd_ac_model_id = $item->id;
                   $tbl_item->particular = $member_detail->full_name .' FD No '. $request->fd_no;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->main_head = $memebr_item->name.' '.$request->type_of_deposit;
                   $tbl_item->form_name = 'FIXED DEPOSIT';
                   $tbl_item->token = $request->_token;
                   $tbl_item->member_type_model_id = $request->member_type_model_id;
                   $tbl_item->session_year = '2019-2020';
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->agent_id = $member_detail->agent_name;
                   if (Auth::user()->staff_type == 'Agent') {
                      $tbl_item->shadow = 0;
                    }
                   
                   $tbl_item->save();

                   $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);

                   $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                   $update_tbl_ledger_model->voucher_no = $voucher;
                   $update_tbl_ledger_model->save();
// ********************
        // Cash entry                    
// ********************
// Member type
                

                $cash_tbl_item = tbl_ledger_model::where('fd_ac_model_id',$id)->where('account_head','FIXED DEPOSIT')->where('stype','Cash')->first();
                if($request->mode_of_transaction == 'Cash')
                {
                    $cash_tbl_item->gtype = 'Cash';
                    $cash_tbl_item->stype = 'Cash';
                    $cash_tbl_item->main_head = 'Cash';
                }
                else{
                    $cash_tbl_item->gtype = 'Transfer';
                    $cash_tbl_item->stype = 'Transfer';
                    $cash_tbl_item->main_head = 'Transfer';
                }
                 
                   $cash_tbl_item->date_of_transaction = $request->transaction_date;
                   $cash_tbl_item->particular = $member_detail->full_name .' FD No '. $request->fd_no;
                   $cash_tbl_item->account_head = 'FIXED DEPOSIT';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->fd_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->form_name = 'FIXED DEPOSIT';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->member_type_model_id = $request->member_type_model_id;
                   $cash_tbl_item->session_year = '2019-2020';
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->agent_id = $member_detail->agent_name;
                   if (Auth::user()->staff_type == 'Agent') {
                      $cash_tbl_item->shadow = 0;
                    }
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();
                
                   
                   $return_url = url(TRANSACTION_URL_FD_AC);
                    return response()->json(['success'=>'<li><span>Success!</span> Reocrd Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function printPDF($id)
    {
       // This  $data array will be passed to our PDF blade

        $data['item'] = fd_ac_model::with('member_type_model')->find($id);

        $data['customer'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $data['balance'] = fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',1)->sum('amount');
        $data['company_profile'] = company_address_model::first();
        // dd($data['company_profile']);
        return view(TRANSACTION_FD_AC.'pdf_view',compact(['data']));
    }



// Edit matured FD

public function editMatureFd($id)
    {
        $data['item'] = fd_ac_model::find($id);

        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['type_of_interest'] = ["Simple Interest","Quarterly Interest","Yearly Interest"];
        $data['type_of_deposite'] = ["FIXED DEPOSIT","LONG TERM DEPOSIT","SHORT TERM DEPOSIT"];
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter'];
        $data['customer'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();
        
       $data['balance'] = fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',1)->sum('amount');
       $data['intPaidLists'] = interest_on_fd_tbl::where('fd_ac_model_id',$data['item']->id)->sum('interest_amt');

        return view(TRANSACTION_FD_AC.'mature-fd')->with($data);
    }  

// Update matured FD
    public function matureFd(Request $request, $id)
    {

         // return $request->all();
        $validator = Validator::make($request->all(), [
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
        ]);

        if ($validator->passes()) {
            
            $item = fd_ac_model::with('open_new_ac_model')->where('id',$id)->first();
            
                $item->matured_on_date = $request->matured_on_date;
                $item->maturity_amount = $request->maturity_amount;
                $item->user_id = Auth::user()->id;
                $item->status = $request->fdStatus;
                
                if($item->save())
                {
                    if($request->fdStatus == 1)
                    {
                        tbl_ledger_model::whereIn('fd_mature_status',[$item->id])->delete();
                    }
                    else
                    {
                        $memebr_item =  member_type_model::where('id',$item->member_type_model_id)->first();

// ********************
        // Head entry  single matuare                  
// ********************
// Member type
                if($request->mtr == 'sm')
                {
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' FIXED DEPOSIT';
                   $tbl_item->stype = $memebr_item->name.' '.$item->type_of_deposite;

                   $tbl_item->fd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'FIXED DEPOSIT';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = $item->open_new_ac_model->full_name .' FD No '. $item->fd_no;
                   $tbl_item->branch_model_id = $item->open_new_ac_model->branch_model_id;
                   $tbl_item->fd_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $memebr_item->name.' '.$item->type_of_deposite;
                   $tbl_item->form_name = 'FIXED DEPOSIT';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->agent_id = $item->open_new_ac_model->agent_name;
                   $tbl_item->member_type_model_id = $item->member_type_model_id;
                   $tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $tbl_item->shadow = 0;
                    }
                   
                   $tbl_item->save();

                   $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);

                   $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                   $update_tbl_ledger_model->voucher_no = $voucher;
                   $update_tbl_ledger_model->save();
               }
// ********************
        // Head entry  double matuare                  
// ********************
// Member type
                if($request->mtr == 'dm')
                {
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' FIXED DEPOSIT';
                   $tbl_item->stype = $memebr_item->name.' '.$item->type_of_deposite;

                   $tbl_item->fd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'FIXED DEPOSIT';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->amount = ($request->maturity_amount - $request->amount);
                   $tbl_item->particular = $item->open_new_ac_model->full_name .' FD No '. $item->fd_no;
                   $tbl_item->branch_model_id = $item->open_new_ac_model->branch_model_id;
                   $tbl_item->fd_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $memebr_item->name.' '.$item->type_of_deposite;
                   $tbl_item->form_name = 'FIXED DEPOSIT';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->agent_id = $item->open_new_ac_model->agent_name;
                   $tbl_item->member_type_model_id = $item->member_type_model_id;
                   $tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $tbl_item->shadow = 0;
                    }
                   
                   $tbl_item->save();

                   $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);

                   $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                   $update_tbl_ledger_model->voucher_no = $voucher;
                   $update_tbl_ledger_model->save(); 
// =====                                     
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' FIXED DEPOSIT';
                   $tbl_item->stype = $memebr_item->name.' '.$item->type_of_deposite;

                   $tbl_item->fd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'FIXED DEPOSIT';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $request->maturity_amount;
                   $tbl_item->particular = $item->open_new_ac_model->full_name .' FD No '. $item->fd_no;
                   $tbl_item->branch_model_id = $item->open_new_ac_model->branch_model_id;
                   $tbl_item->fd_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $memebr_item->name.' '.$item->type_of_deposite;
                   $tbl_item->form_name = 'FIXED DEPOSIT';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->agent_id = $item->open_new_ac_model->agent_name;
                   $tbl_item->member_type_model_id = $item->member_type_model_id;
                   $tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $tbl_item->shadow = 0;
                    }
                   
                   $tbl_item->save();

                   $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);

                   $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                   $update_tbl_ledger_model->voucher_no = $voucher;
                   $update_tbl_ledger_model->save(); 
               }
// ********************
        // Interest entry                    
// ********************
// Member type
                
                   $int_tbl_item = new tbl_ledger_model();
                   
                   $int_tbl_item->gtype = 'INTEREST PAID';
                   $int_tbl_item->stype = 'INTEREST PAID ON '.$memebr_item->name.' '.$item->type_of_deposite;

                   $int_tbl_item->fd_mature_status = $item->id;
                   $int_tbl_item->date_of_transaction = $request->matured_on_date;
                   $int_tbl_item->account_no = $item->account_no;
                   $int_tbl_item->account_head = 'FIXED DEPOSIT';
                   $int_tbl_item->entry_type = 'Cash';
                   $int_tbl_item->type_of_transaction = 'Dr';
                   $int_tbl_item->amount = ($request->maturity_amount - $request->amount);
                   $int_tbl_item->particular = $item->open_new_ac_model->full_name .' FD No '. $item->fd_no;
                   $int_tbl_item->branch_model_id = $item->open_new_ac_model->branch_model_id;
                   $int_tbl_item->fd_ac_model_id = $item->id;
                   $int_tbl_item->mode_of_transaction = 'Cash';
                   $int_tbl_item->main_head = 'INTEREST PAID ON '.$memebr_item->name.' '.$item->type_of_deposite;
                   $int_tbl_item->form_name = 'FIXED DEPOSIT';
                   $int_tbl_item->token = $request->_token;
                   $int_tbl_item->user_id = Auth::user()->id;
                   $int_tbl_item->agent_id = $item->open_new_ac_model->agent_name;
                   $int_tbl_item->member_type_model_id = $item->member_type_model_id;
                   $int_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $int_tbl_item->shadow = 0;
                    }
                   
                   $int_tbl_item->voucher_no = $voucher;
                   $int_tbl_item->save();
// ********************
        // Cash entry                    
// ********************
// Member type
                

                $cash_tbl_item = new tbl_ledger_model();
               
                    $cash_tbl_item->gtype = 'Cash';
                    $cash_tbl_item->stype = 'Cash';
                    $cash_tbl_item->main_head = 'Cash';
                    $cash_tbl_item->fd_mature_status = $item->id;
                   $cash_tbl_item->date_of_transaction = $request->matured_on_date;
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->account_no = $item->account_no;
                   $cash_tbl_item->account_head = 'FIXED DEPOSIT';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $item->open_new_ac_model->branch_model_id;
                   $cash_tbl_item->amount = $request->maturity_amount;
                   $cash_tbl_item->particular = $item->open_new_ac_model->full_name .' FD No '. $item->fd_no;
                   $cash_tbl_item->fd_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->form_name = 'FIXED DEPOSIT';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->agent_id = $item->open_new_ac_model->agent_name;
                   $cash_tbl_item->member_type_model_id = $item->member_type_model_id;
                   $cash_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $cash_tbl_item->shadow = 0;
                    }
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();                
                   }
                   $return_url = url(TRANSACTION_URL_FD_AC);
                    return response()->json(['success'=>'<li><span>Success!</span> Reocrd Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    } 

// Renew FD & matured old automatic
    public function renewFd(Request $request, $id)
    {
      
        $voucher_matured = '';
        $validator = Validator::make($request->all(), [
            'renew_amount' => 'bail|required|numeric',
            'renew_interest_rate' => 'bail|required|numeric',
            'renew_period_of_fd' => 'bail|required|numeric',
            'renew_maturity_amount' => 'bail|required|numeric',
            'renew_type_of_deposit' => 'bail|required',
            'renew_nominee_name' => 'bail|required',
            'renew_nominee_relation' => 'bail|required',
        ]);

        if ($validator->passes()) {
            
// Member detail            
            
            $fdModel = fd_ac_model::find($id);
            $item = $fdModel->replicate();
            $item->user_id = Auth::user()->id;
            $item->amount = $request->renew_amount;
            $item->int_rate = $request->renew_interest_rate;
            $item->int_run_from = $request->renew_interest_run_from;
            $item->transaction_date = $request->renew_transaction_date;
            $item->period_fd = $request->renew_period_of_fd;
            $item->maturity_date = $request->renew_maturity_date;
            $item->matured_on_date = $request->renew_matured_on_date;
            $item->interest_type = $request->renew_type_of_interest;
            $item->maturity_amount = $request->renew_maturity_amount;

            $item->type_of_deposite = $request->renew_type_of_deposit;
            $item->nominee_name = $request->renew_nominee_name;
            $item->nominee_relation = $request->renew_nominee_relation;
            $item->session_year = '2019-2020';
            $item->status = 1;
            $item->token = $request->_token;
            if($item->save())
            {
                $new_item = fd_ac_model::with('open_new_ac_model')
                            ->where('id',$item->id)->first();
                $memebr_type =  member_type_model::where('id',$item->member_type_model_id)->first();

// ********************
        // Head entry                    
// ********************
// Member type
                
                   $head_tbl_item = new tbl_ledger_model();
                   
                   $head_tbl_item->gtype = $memebr_type->name.' FIXED DEPOSIT';
                   $head_tbl_item->stype = $memebr_type->name.' '.$request->renew_type_of_deposit;

                   $head_tbl_item->date_of_transaction = $request->renew_transaction_date;
                   $head_tbl_item->account_no = $item->account_no;
                   $head_tbl_item->account_head = 'FIXED DEPOSIT';
                   $head_tbl_item->entry_type = 'Transfer';
                   $head_tbl_item->type_of_transaction = 'Cr';
                   $head_tbl_item->amount = $request->renew_amount;
                   $head_tbl_item->particular = $new_item->open_new_ac_model->full_name .' FD No '. $request->renew_fd_no;
                   $head_tbl_item->branch_model_id = $new_item->open_new_ac_model->branch_model_id;
                   $head_tbl_item->fd_ac_model_id = $new_item->id;
                   $head_tbl_item->mode_of_transaction = $request->renew_mode_of_transaction;
                   $head_tbl_item->main_head = $memebr_type->name.' '.$request->renew_type_of_deposit;
                   $head_tbl_item->form_name = 'FIXED DEPOSIT';
                   $head_tbl_item->token = $request->_token;
                   $head_tbl_item->user_id = Auth::user()->id;
                   $head_tbl_item->agent_id = $new_item->open_new_ac_model->agent_name;
                   $head_tbl_item->member_type_model_id = $new_item->member_type_model_id;
                   $head_tbl_item->session_year = '2019-2020';
                   
                   $head_tbl_item->save();

                   $update_tbl_ledger_model2 = tbl_ledger_model::find($head_tbl_item->id);

                   $voucher = date('ymd').''.$update_tbl_ledger_model2->id;
                   $update_tbl_ledger_model2->voucher_no = $voucher;
                   $update_tbl_ledger_model2->save();
// ********************
        // Cash entry                    
// ********************
// Member type
                

                $cash_tbl_item = new tbl_ledger_model();
                
                    $cash_tbl_item->gtype = 'Cash';
                    $cash_tbl_item->stype = 'Cash';
                    $cash_tbl_item->main_head = 'Cash';
               
                 
                   $cash_tbl_item->date_of_transaction = $request->renew_transaction_date;
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->account_no = $item->account_no;
                   $cash_tbl_item->account_head = 'FIXED DEPOSIT';
                   $cash_tbl_item->entry_type = 'Transfer';
                   $cash_tbl_item->branch_model_id = $new_item->open_new_ac_model->branch_model_id;
                   $cash_tbl_item->amount = $request->renew_amount;
                   $cash_tbl_item->particular = $new_item->open_new_ac_model->full_name .' FD No '. $request->renew_fd_no;
                   $cash_tbl_item->fd_ac_model_id = $new_item->id;
                   $cash_tbl_item->mode_of_transaction = $request->renew_mode_of_transaction;
                   $cash_tbl_item->form_name = 'FIXED DEPOSIT';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->agent_id = $new_item->open_new_ac_model->agent_name;
                   $cash_tbl_item->member_type_model_id = $new_item->member_type_model_id;
                   $cash_tbl_item->session_year = '2019-2020';
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();

// Matured Old FD start                
                   $mature_memebr_item =  member_type_model::where('id',$new_item->member_type_model_id)->first();
                   $old_fd = fd_ac_model::findOrFail($id);

// Mature last FD Status
                        
                $old_fd->matured_on_date = $request->renew_transaction_date;
                $old_fd->maturity_amount = $request->old_maturity_amount;
                $old_fd->user_id = Auth::user()->id;
                $old_fd->status = 0; 
                $old_fd->save();                  

// ********************
        // Head entry single renew                   
// ********************
// Member type
               if($request->mtr == 'sm') 
               {
                   $head_matured_tbl_item = new tbl_ledger_model();
                   
                   $head_matured_tbl_item->gtype = $mature_memebr_item->name.' FIXED DEPOSIT';
                   $head_matured_tbl_item->stype = $mature_memebr_item->name.' '.$old_fd->type_of_deposite;

                   $head_matured_tbl_item->fd_mature_status = $id;
                   $head_matured_tbl_item->date_of_transaction = $request->renew_transaction_date;
                   $head_matured_tbl_item->account_no = $old_fd->account_no;
                   $head_matured_tbl_item->account_head = 'FIXED DEPOSIT';
                   $head_matured_tbl_item->entry_type = 'Transfer';
                   $head_matured_tbl_item->type_of_transaction = 'Dr';
                   $head_matured_tbl_item->amount = $request->old_amount;
                   $head_matured_tbl_item->particular = $old_fd->open_new_ac_model->full_name .' FD No '. $old_fd->fd_no;
                   $head_matured_tbl_item->branch_model_id = $old_fd->open_new_ac_model->branch_model_id;
                   $head_matured_tbl_item->fd_ac_model_id = $old_fd->id;
                   $head_matured_tbl_item->mode_of_transaction = 'Cash';
                   $head_matured_tbl_item->main_head = $mature_memebr_item->name.' '.$old_fd->type_of_deposite;
                   $head_matured_tbl_item->form_name = 'FIXED DEPOSIT';
                   $head_matured_tbl_item->token = $request->_token;
                   $head_matured_tbl_item->user_id = Auth::user()->id;
                   $head_matured_tbl_item->agent_id = $old_fd->agent_id;
                   $head_matured_tbl_item->member_type_model_id = $old_fd->member_type_model_id;
                   $head_matured_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $head_matured_tbl_item->shadow = 0;
                    }
                   
                   $head_matured_tbl_item->save();

                   $update_old_tbl_ledger_model = tbl_ledger_model::find($head_matured_tbl_item->id);

                   $voucher_matured = date('ymd').''.$update_old_tbl_ledger_model->id;
                   $update_old_tbl_ledger_model->voucher_no = $voucher_matured;
                   $update_old_tbl_ledger_model->save();
               }
// ********************
        // Head entry double renew                   
// ********************
// Member type
                if($request->mtr == 'dm')
                {
                   $head_matured_tbl_item = new tbl_ledger_model();
                   
                   $head_matured_tbl_item->gtype = $mature_memebr_item->name.' FIXED DEPOSIT';
                   $head_matured_tbl_item->stype = $mature_memebr_item->name.' '.$old_fd->type_of_deposite;

                   $head_matured_tbl_item->fd_mature_status = $id;
                   $head_matured_tbl_item->date_of_transaction = $request->renew_transaction_date;
                   $head_matured_tbl_item->account_no = $old_fd->account_no;
                   $head_matured_tbl_item->account_head = 'FIXED DEPOSIT';
                   $head_matured_tbl_item->entry_type = 'Transfer';
                   $head_matured_tbl_item->type_of_transaction = 'Cr';
                   $head_matured_tbl_item->amount = ($request->old_maturity_amount - $request->old_amount);
                   $head_matured_tbl_item->particular = $old_fd->open_new_ac_model->full_name .' FD No '. $old_fd->fd_no;
                   $head_matured_tbl_item->branch_model_id = $old_fd->open_new_ac_model->branch_model_id;
                   $head_matured_tbl_item->fd_ac_model_id = $old_fd->id;
                   $head_matured_tbl_item->mode_of_transaction = 'Cash';
                   $head_matured_tbl_item->main_head = $mature_memebr_item->name.' '.$old_fd->type_of_deposite;
                   $head_matured_tbl_item->form_name = 'FIXED DEPOSIT';
                   $head_matured_tbl_item->token = $request->_token;
                   $head_matured_tbl_item->user_id = Auth::user()->id;
                   $head_matured_tbl_item->agent_id = $old_fd->agent_id;
                   $head_matured_tbl_item->member_type_model_id = $old_fd->member_type_model_id;
                   $head_matured_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $head_matured_tbl_item->shadow = 0;
                    }
                   
                   $head_matured_tbl_item->save();

                   $update_old_tbl_ledger_model = tbl_ledger_model::find($head_matured_tbl_item->id);

                   $voucher_matured = date('ymd').''.$update_old_tbl_ledger_model->id;
                   $update_old_tbl_ledger_model->voucher_no = $voucher_matured;
                   $update_old_tbl_ledger_model->save();   
//  =======
                   $head_matured_tbl_item = new tbl_ledger_model();
                   
                   $head_matured_tbl_item->gtype = $mature_memebr_item->name.' FIXED DEPOSIT';
                   $head_matured_tbl_item->stype = $mature_memebr_item->name.' '.$old_fd->type_of_deposite;

                   $head_matured_tbl_item->fd_mature_status = $id;
                   $head_matured_tbl_item->date_of_transaction = $request->renew_transaction_date;
                   $head_matured_tbl_item->account_no = $old_fd->account_no;
                   $head_matured_tbl_item->account_head = 'FIXED DEPOSIT';
                   $head_matured_tbl_item->entry_type = 'Transfer';
                   $head_matured_tbl_item->type_of_transaction = 'Dr';
                   $head_matured_tbl_item->amount = $request->old_maturity_amount;
                   $head_matured_tbl_item->particular = $old_fd->open_new_ac_model->full_name .' FD No '. $old_fd->fd_no;
                   $head_matured_tbl_item->branch_model_id = $old_fd->open_new_ac_model->branch_model_id;
                   $head_matured_tbl_item->fd_ac_model_id = $old_fd->id;
                   $head_matured_tbl_item->mode_of_transaction = 'Cash';
                   $head_matured_tbl_item->main_head = $mature_memebr_item->name.' '.$old_fd->type_of_deposite;
                   $head_matured_tbl_item->form_name = 'FIXED DEPOSIT';
                   $head_matured_tbl_item->token = $request->_token;
                   $head_matured_tbl_item->user_id = Auth::user()->id;
                   $head_matured_tbl_item->agent_id = $old_fd->agent_id;
                   $head_matured_tbl_item->member_type_model_id = $old_fd->member_type_model_id;
                   $head_matured_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $head_matured_tbl_item->shadow = 0;
                    }
                   
                   $head_matured_tbl_item->save();

                  
                   $update_old_tbl_ledger_model->voucher_no = $voucher_matured;
                   $update_old_tbl_ledger_model->save();  
                   } 
// ********************
        // Interest entry                    
// ********************
// Member type
                
                   $int_matured_tbl_item = new tbl_ledger_model();
                   
                   $int_matured_tbl_item->gtype = 'INTEREST PAID';
                   $int_matured_tbl_item->stype = 'INTEREST PAID ON '.$mature_memebr_item->name.' '.$old_fd->type_of_deposite;

                   $int_matured_tbl_item->fd_mature_status = $old_fd->id;
                   $int_matured_tbl_item->date_of_transaction = $request->renew_transaction_date;
                   $int_matured_tbl_item->account_no = $old_fd->account_no;
                   $int_matured_tbl_item->account_head = 'FIXED DEPOSIT';
                   $int_matured_tbl_item->entry_type = 'Transfer';
                   $int_matured_tbl_item->type_of_transaction = 'Dr';
                   $int_matured_tbl_item->amount = ($request->old_maturity_amount - $request->old_amount);
                   $int_matured_tbl_item->particular = $old_fd->open_new_ac_model->full_name .' FD No '. $old_fd->fd_no;
                   $int_matured_tbl_item->branch_model_id = $old_fd->open_new_ac_model->branch_model_id;
                   $int_matured_tbl_item->fd_ac_model_id = $old_fd->id;
                   $int_matured_tbl_item->mode_of_transaction = 'Cash';
                   $int_matured_tbl_item->main_head = 'INTEREST PAID ON '.$mature_memebr_item->name.' '.$old_fd->type_of_deposite;
                   $int_matured_tbl_item->form_name = 'FIXED DEPOSIT';
                   $int_matured_tbl_item->token = $item->_token;
                   $int_matured_tbl_item->user_id = Auth::user()->id;
                   $int_matured_tbl_item->agent_id = $old_fd->agent_id;
                   $int_matured_tbl_item->member_type_model_id = $old_fd->member_type_model_id;
                   $int_matured_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $int_matured_tbl_item->shadow = 0;
                    }
                   
                   $int_matured_tbl_item->save();
                   $update_old_tbl_ledger_model = tbl_ledger_model::find($int_matured_tbl_item->id);

                   $voucher_matured = date('ymd').''.$update_old_tbl_ledger_model->id;
                   $update_old_tbl_ledger_model->voucher_no = $voucher_matured;
                   $update_old_tbl_ledger_model->save();

// ********************
        // Cash entry                    
// ********************
// Member type
                

                $matured_cash_tbl_item = new tbl_ledger_model();
               
                    $matured_cash_tbl_item->gtype = 'Cash';
                    $matured_cash_tbl_item->stype = 'Cash';
                    $matured_cash_tbl_item->main_head = 'Cash';
                    $matured_cash_tbl_item->fd_mature_status = $old_fd->id;
                   $matured_cash_tbl_item->date_of_transaction = $request->renew_transaction_date;
                   $matured_cash_tbl_item->type_of_transaction = 'Cr';
                   $matured_cash_tbl_item->account_no = $old_fd->account_no;
                   $matured_cash_tbl_item->account_head = 'FIXED DEPOSIT';
                   $matured_cash_tbl_item->entry_type = 'Transfer';
                   $matured_cash_tbl_item->branch_model_id = $new_item->open_new_ac_model->branch_model_id;
                   $matured_cash_tbl_item->amount = $request->old_maturity_amount;
                   $matured_cash_tbl_item->particular = $new_item->open_new_ac_model->full_name .' FD No '. $old_fd->fd_no;
                   $matured_cash_tbl_item->fd_ac_model_id = $old_fd->id;
                   $matured_cash_tbl_item->mode_of_transaction = 'Cash';
                   $matured_cash_tbl_item->form_name = 'FIXED DEPOSIT';
                   $matured_cash_tbl_item->token = $request->_token;
                   $matured_cash_tbl_item->user_id = Auth::user()->id;
                   $matured_cash_tbl_item->agent_id = $old_fd->agent_id;
                   $matured_cash_tbl_item->member_type_model_id = $old_fd->member_type_model_id;
                   $matured_cash_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $matured_cash_tbl_item->shadow = 0;
                    }

                   $matured_cash_tbl_item->voucher_no = $voucher_matured;
                   $matured_cash_tbl_item->save(); 
// Matured Old FD end                
                   
                   $return_url = url(TRANSACTION_URL_FD_AC);
                    return response()->json(['success'=>'<li>FD Successfully Matured & Renew.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
         //Auth::login($user);

    } 
    public function destroy($id)
    {
        $del = fd_ac_model::findOrFail($id)->delete();  

        if ($del) {
                tbl_ledger_model::whereIn('fd_ac_model_id',[$id])->delete(); 
                return redirect()->back()->with(["success" => "Item deleted successfully!"]);
            }
       return redirect()->back()->with(['error' => 'Something went wrong!']);
    }
   
}
