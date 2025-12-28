<?php

namespace App\Http\Controllers\Transaction;

use App\saving_ac_model;
use App\share_ac_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\open_new_ac_model;
use App\state_model;
use App\district_model;
use App\branch_model;
use App\member_type_model;
use App\loan_ac_model;
use App\loan_ac_installment;
use App\tbl_ledger_model;
use App\loan_model;
use App\loanpurpose_model;
use App\tbl_loan_return_model;
use App\company_address_model;
use Auth;
use DB;
use Response;
use PDF;
use URL;

class loanController extends Controller
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
    }

    public function index(Request $request)
    {
        if($request->cur_date)
        {
            $cur_date = $request->cur_date;
        }
        else
        {
            $cur_date = date('Y-m-d');
        }

        $items_obj = loan_ac_model::with('open_new_ac_model','member_type_model')
            ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->orderBy('date_of_advance','desc')
            ->where('member_type_model_id',$request->member)
            ->where('account_no',$request->account);
            if(Auth::user()->staff_type == 'Agent')
            {
                $items_obj = $items_obj->where('agent_id',Auth()->user()->id);
            }
            $items_obj = $items_obj->get();

        $data = [
            'items' => $items_obj,
            'members' => member_type_model::orderBy('name','asc')->get(),
            'account' => $request->account,
            'member' => $request->member,
            'cur_date' => $cur_date,
        ];         
        return view(TRANSACTION_LOAN_AC.'list')->with($data);
    }

    public function accountdetail(Request $request)
    {
        $this->ac_no = $request->ac_no;
        $item = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$this->ac_no)->where('member_type_model_id',$request->member_id)->first();
        if($item){
        $data['open_ac_id'] = $item->id;
        $data['full_name'] = $item->full_name;
        $data['father_name'] = $item->father_name != '' ? $item->father_name : 'N/a';
        $data['address'] = $item->village.' '.$item->post_office.' '.$item->district_model->name.' - ('.$item->state_model->name.')';
        $data['branch'] = @$item->branch_model->name;
        if($item->file != '')
        {
            $data['priview'] = url('public').'/'.$item->file;
        }
        else
        {
            $data['priview'] = url('assets/images/profile.jpg');
        }
        if($item->signature != '')
        {
            $data['signature'] = url('public').'/'.$item->signature;
        }
        else
        {
            $data['signature'] = url('assets/images/signature.png');
        }

        $data['view_ac_url'] = url('transaction/loan/show').'/'.$request->member_id.'/'.$this->ac_no.'/'.$request->_token;

        $deposite_bal = loan_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('status',1)->sum('amount');

        $withdraw_bal = loan_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('status',0)->sum('amount');

        $data['balance'] = $deposite_bal - $withdraw_bal;

        //Share Balance
            $share_deposite_bal = share_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('type_of_transaction','Deposit')->sum('amount');

            $share_withdraw_bal = share_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('type_of_transaction','Withdrawal')->sum('amount');
        $data['share_balance'] = $share_deposite_bal - $share_withdraw_bal;
        // Share Balance

        $data['lf_no'] = $item->lf_no;
        $data['base_url'] = url('/');
        
        $items = loan_ac_model::where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->get();

        return response()->json(['list'=>$items,'success'=>$data]);

        }
        else
        {
            return response()->json(['error'=>'A/c detail not found!']);
        }
    }
    public function getcheckguarantor(Request $request){
         $guarantor_one = trim($_REQUEST['guarantor_one']);
        $data = "";
        $i=1;
        $html = '';
        $data = loan_ac_model::select()
            ->where('guarnter_one',$guarantor_one)->orWhere('guarnter_two',$guarantor_one)
            ->get();

        foreach($data as $item){ 
            $tbl_loan_return_model_sum = \App\tbl_loan_return_model::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(tbl_loan_return_models.received_principal),0) total_received_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->first();
            if(($item->amount - $tbl_loan_return_model_sum->total_received_principal) > 0){
            $status = '<i class="fa fa-check text-success"></i>';
            }else {
                $status = '<i class="fa fa-times text-danger"></i>';
            }
        // $OutsourcePerson = DB::table('uppcl_outsourced_persons')->where('id',$val)->first(); 
         $html.='<tr>';
         $html.='<td><center>'.@$item->account_no.'</center></td>';
         $html.='<td><center>'.@$item->open_new_ac_model->full_name.'</center></td>';
         $html.='<td><center>'.@$item->open_new_ac_model->father_name.'</center></td>';
         $html.='<td><center>'.@number_format(@$item->amount).'</center></td>';
         $html.='<td><center>'.@$status.'</center></td>';
         $html.='</tr>';
           $i++;
     }
      return $html;
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
         $data['loan_terms'] = ['Daily','Monthly','Quarterly','Half Yearly'];
        $data['loan_types'] = loan_model::orderBy('name','asc')->get();
        $data['loan_purpose'] = loanpurpose_model::orderBy('name','asc')->get();
        $data['guarenter_first'] = open_new_ac_model::where('member_type_model_id',1)
        ->orderBy('full_name','asc')
        ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
        ->get(['id','full_name','account_no','father_name']);
        $data['loan_interest'] = ['Reducing','Flat'];
       // echo '<pre>'; print_r($data['guarenter_first']);die;
        return view(TRANSACTION_LOAN_AC."create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parnoteNo' => 'bail|required|numeric',
            'loan_type' => 'bail|required',
            'term' => 'bail|required',
            'month_value' => 'bail|required|numeric',
            'interest' => 'bail|required|numeric',
            'pannelty_interest' => 'bail|required||numeric',
            'additional_interest' => 'bail|nullable|numeric',
            'loan_purpose' => 'bail|required',
            'date_of_transaction' => 'bail|required',
            'member_type_model_id' => 'bail|required',
            'account_no' => 'bail|required',
            'mode_of_transaction' => 'required',
            'cheque_date' => 'bail|sometimes',
            'cheque_number' => 'bail|sometimes',
            'amount' => 'bail|required|numeric',
        ]);

        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
// Member detail 

            $member_detail = open_new_ac_model::where('account_no',$this->ac_no)->where('member_type_model_id',$request->member_type_model_id)->first();            
            $item = new loan_ac_model();
            
                $item->open_new_ac_model_id = $request->open_ac_id;
                $item->user_id = Auth::user()->id;
                $item->parnote_no = $request->parnoteNo;
                $item->agent_id = $member_detail->agent_name;
                $item->member_type_model_id = $request->member_type_model_id;
                $item->loan_type = $request->loan_type;
                $item->term = $request->term;
                $item->months = $request->month_value;
                $item->interest = $request->interest;
                $item->pannelty_int = $request->pannelty_interest;
                $item->additional_int = $request->additional_interest;
                $item->type_of_interest = $request->type_of_interest;
                $item->loan_purpose = $request->loan_purpose;
                $item->date_of_advance = $request->date_of_transaction;
                $item->account_no = $this->ac_no;
                $item->mode_of_payment = $request->mode_of_transaction;
                $item->amount = $request->amount;
                $item->inst_amt = $request->loop_net[0];
                $item->guarnter_one = $request->guarantor_one;
                $item->guarnter_two = $request->guarantor_two;
                $item->cheque_date = $request->cheque_date;
                $item->cheque_no = $request->cheque_number;
                $item->session_year = '2019-2020';
                if (Auth::user()->staff_type == 'Agent') {
                  $item->shadow = 0;
                }
                $item->token = $request->_token;

                if($item->save())
                {
               $memebr_item =  member_type_model::where('id',$request->member_type_model_id)->first();
               $loan_model = loan_model::where('id',$request->loan_type)->first();
// Loan Installment query               
            $loan_item = new loan_ac_installment();
            $loan_ac_model_id = $item->id;
            $open_new_ac_model_id = $member_detail->id;
            $user_id = Auth::user()->id;
            $agent_id = $member_detail->agent_name;
            $member_type_model_id = $request->member_type_model_id;
            $account_no = $this->ac_no;
            $installment_date = $request->loop_date;
            $principal = $request->loop_principal;
            $recoberable_intr = $request->loop_recoberable_int;
            $net_amt = $request->loop_net;
            $session_year = '2019-2020';
            if (Auth::user()->staff_type == 'Agent') {
                  $shadow = 0;
                }
                $shadow = 1;
            $token = $request->_token;
            $create = date('Y-m-d h:m:i');
            $update = date('Y-m-d h:m:i');
            $loan_items = array();
            if(count($installment_date) >= 1)
            {
                for($i = 0; $i < count($installment_date); $i++){
                    $arr[] = array(
                        'loan_ac_model_id'=>$loan_ac_model_id,
                        'open_new_ac_model_id'=>$open_new_ac_model_id,
                        'user_id'=>$user_id,
                        'agent_id'=>$agent_id,
                        'member_type_model_id'=>$member_type_model_id,
                        'account_no'=>$account_no,
                        'installment_date'=>$installment_date[$i],
                        'principal'=>$principal[$i],
                        'recoberable_intr'=>$recoberable_intr[$i],
                        'net_amt'=>$net_amt[$i],
                        'session_year'=>$session_year,
                        'shadow'=>$shadow,
                        'token'=>$token,
                        'created_at'=>$create,
                        'updated_at'=>$update,
                        );
                }
                $loan_items = $arr;
                $loan_item->insert($loan_items);
            }
// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();                   
                   $tbl_item->gtype = $loan_model->name;
                   $tbl_item->stype = $memebr_item->name.' LOAN '.$loan_model->name;
                   $tbl_item->date_of_transaction = $request->date_of_transaction;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'LOAN';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = 'LOAN TO '.$member_detail->full_name;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->loan_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->main_head = $memebr_item->name.' LOAN '.$loan_model->name;
                   $tbl_item->form_name = 'LOAN';
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
                 
                   $cash_tbl_item->date_of_transaction = $request->date_of_transaction;
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->account_no = $request->account_no;
                   $cash_tbl_item->account_head = 'LOAN';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->particular = 'LOAN TO '.$member_detail->full_name;
                   $cash_tbl_item->loan_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->form_name = 'LOAN';
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
                   
                   $return_url = url(TRANSACTION_URL_LOAN_AC);
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
        $items = loan_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$member_id)->where('account_no',$account_id)->get();
        // dd($items);
        return view(TRANSACTION_LOAN_AC.'list',compact(['items']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['item'] = loan_ac_model::find($id);
        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['type_of_interest'] = ["Simple Interest","Quarterly Interest","Yearly Interest"];
        $data['type_of_deposite'] = ["Fixed Deposit","Long Term Deposit","Short Term Deposit"];
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter'];
        $data['customer'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $deposite_bal = loan_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',1)->sum('amount');

        $withdraw_bal = loan_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',0)->sum('amount');

        $data['balance'] = $deposite_bal - $withdraw_bal;
        return view(TRANSACTION_LOAN_AC.'edit')->with($data);
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
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'amount' => 'bail|required|numeric',
            'interest_rate' => 'bail|required|numeric',
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
            
            $item = loan_ac_model::find($id);
// Member detail            
            $member_detail = open_new_ac_model::where('account_no',$item->account_no)->where('member_type_model_id',$item->member_type_model_id)->first();            
                $item->amount = $request->amount;
                $item->int_rate = $request->interest_rate;
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
                
                   $tbl_item = tbl_ledger_model::where('loan_ac_model_id',$id)->where('account_head','Fixed Deposite')->where('entry_type','Cash')->where('stype',$memebr_item->name.' '.$request->type_of_deposit)->first();                   
                   $tbl_item->gtype = $memebr_item->name. ' Fixed Deposite';
                   $tbl_item->stype = $memebr_item->name.' '.$request->type_of_deposit;
                   $tbl_item->date_of_transaction = $request->transaction_date;
                   $tbl_item->account_head = 'Fixed Deposite';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->loan_ac_model_id = $item->id;
                    $tbl_item->particular = $member_detail->full_name .' FD No '. $request->fd_no;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->main_head = $memebr_item->name.' '.$request->type_of_deposit;
                   $tbl_item->form_name = 'Fixed Deposite';
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

                $cash_tbl_item = tbl_ledger_model::where('loan_ac_model_id',$id)->where('account_head','Fixed Deposite')->where('entry_type','Cash')->where('stype','Cash')->first();
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
                    $tbl_item->particular = $member_detail->full_name .' FD No '. $request->fd_no;
                   $cash_tbl_item->account_head = 'Fixed Deposite';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->loan_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->form_name = 'Fixed Deposite';
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
                   
                   $return_url = url(TRANSACTION_URL_LOAN_AC);
                    return response()->json(['success'=>'<li><span>Success!</span> Reocrd Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }
    public function updateGaurntor(Request $request, $id)
    {

            $item = loan_ac_model::find($id);            
                $item->guarnter_one = $request->guarantor_one;
                $item->guarnter_two = $request->guarantor_two;                
                $item->loan_purpose = $request->loan_purpose;                
                $item->parnote_no = $request->parnote;
                if($item->save())
                {                   
                   $return_url = url($request->pageurl);
                    return response()->json(['success'=>'<li><span>Success!</span> The New Record Inserted Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
         //Auth::login($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function loandetail(Request $request)
    {
        $data = loan_model::find($request->id);
        return response()->json(['success'=>$data]);
    }
    public function loanrecover(Request $request, $id, $token, $rec_date = null)
    {
        $data['item'] = loan_ac_model::findOrFail($id);
        $deposite_bal = saving_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('type_of_transaction','Deposit')->sum('amount');

        $withdraw_bal = saving_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('type_of_transaction','Withdrawal')->sum('amount');
        $data['saving_balance'] = $deposite_bal - $withdraw_bal;

        $data['loan_type'] = loan_model::where('id',$data['item']->loan_type)->first();
        $data['loan_installments'] = loan_ac_installment::orderBy('installment_date','asc')->where('loan_ac_model_id',$id)->get();
        $data['loan_returns'] = tbl_loan_return_model::where('loan_ac_model_id',$data['item']->id)->orderBy('received_date','asc')->get();

        $data['loan_returns_last'] = tbl_loan_return_model::where('loan_ac_model_id',$data['item']->id)->orderBy('received_date','desc')->first();

        $data['total_received_amt'] = tbl_loan_return_model::where('loan_ac_model_id',$data['item']->id)->sum('received_principal');        

        if($rec_date == '')
        {
            $data['rec_date'] = $token;
        }
        else{
            $data['rec_date'] = $rec_date;
        }

        $total_recoverable_int = 0;
        $diff_in_days = '';
        $total_add_int = 0;
        $n = 0;
        if($data['loan_returns_last'])
        {
           $interest_cal_date = $data['loan_returns_last']->received_date; 
        }
        else{
        $interest_cal_date = $data['item']->date_of_advance;

        }
        
        foreach($data['loan_installments'] as $total_recover_int)
        {
            $fdate=date('Y-m-d',strtotime($interest_cal_date));
            $tdate=date('Y-m-d',strtotime($data['rec_date']));

            $to = \Carbon\Carbon::createFromFormat('Y-m-d', $fdate);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $tdate);
            $diff_in_days = $to->diffInDays($from);
            $cint = 0;
            $aint = 0;
            if($data['item']->type_of_interest == 'Reducing')
            {
            if($tdate <= $total_recover_int->installment_date)
            {
              $cint = ((($total_recover_int->principal - $total_recover_int->received_principal) * $diff_in_days * $data['item']->interest) / 36500);
              if(($total_recover_int->principal - $total_recover_int->received_principal) == 0)
              {
                $cint = 0;
              }

              $aint = ((($total_recover_int->principal - $total_recover_int->received_principal) * $diff_in_days * $data['item']->additional_int) / 36500);
              if(($total_recover_int->principal - $total_recover_int->received_principal) == 0)
              {
                $aint = 0;
              }
            }
            else{
              $cint = ((($total_recover_int->principal - $total_recover_int->received_principal) * $diff_in_days * $data['item']->pannelty_int) / 36500);

              $aint = ((($total_recover_int->principal - $total_recover_int->received_principal) * $diff_in_days * $data['item']->additional_int) / 36500);
            }
        }
else{
    // $n = ($diff_in_days / 30) / 12;
    $n =  $data['item']->months / 12;
    if($interest_cal_date < $total_recover_int->installment_date)
    {
        if($tdate >= $total_recover_int->installment_date)
            {
              $cint = ((($total_recover_int->principal - $total_recover_int->received_principal) * $data['item']->interest * $n) / 100);
              if(($total_recover_int->principal - $total_recover_int->received_principal) == 0)
              {
                $cint = 0;
              }

              $aint = ((($total_recover_int->principal - $total_recover_int->received_principal) * $data['item']->additional_int * $n) / 100);
              if(($total_recover_int->principal - $total_recover_int->received_principal) == 0)
              {
                $aint = 0;
              }
            }
            else{
              $cint = 0;
              $aint = 0;
            }
    }
    else{
        $cint = 0;
        $aint = 0;
    }
}
        
            $total_recoverable_int += $cint;
            $total_add_int += $aint;
        }
        $data['total_add_int'] = $total_add_int;
        $data['total_recoverable_int'] = $total_recoverable_int;
        $data['diff_in_days'] = $diff_in_days;
        $data['interest_cal_date'] = $interest_cal_date;
        $data['guarenter_first'] = open_new_ac_model::where('member_type_model_id',1)->get();
        $data['loan_purpose'] = loanpurpose_model::orderBy('name','asc')->get();
        return view(TRANSACTION_LOAN_AC."recovery")->with($data);
    }

    public function recoverpayment(Request $request)
    {

//         return $request->all();
        $validator = Validator::make($request->all(), [
            'receiving_date' => 'bail|required',
            'interest_recover' => 'bail|required|numeric',
            'principal_recover' => 'bail|required|numeric',
            'total_received' => 'bail|required||numeric',
                                                
        ]);
// return $request->interest_recover;
// exit;
        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
            

// Member detail            
            $member_detail = open_new_ac_model::where('account_no',$this->ac_no)->where('member_type_model_id',$request->member_type_model)->first();            
                $item = new tbl_loan_return_model();
                
                $item->loan_ac_model_id = $request->loan_ac_model;
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->account_no = $this->ac_no;
                $item->received_date = $request->receiving_date;
                $item->member_type_model_id = $request->member_type_model;

                if((($request->interest_recover + $request->pending_interest) - $request->total_received) > 0)
                {
                $item->pending_intr = (($request->interest_recover + $request->pending_interest) - $request->total_received);
                $item->received_interest = $request->total_received - $request->add_recover;
                }
                else
                {
                // $item->received_interest = $request->int_recover + $request->pending_interest;    
                $item->received_interest = $request->interest_recover + $request->pending_interest - $request->add_recover;    
                }
                $item->rec_add_int = $request->add_recover;
                $item->received_principal = $request->principal_received;
                $item->mode_of_payment = $request->mode_of_transaction;
                
                $item->session_year = '2019-2020';
                if (Auth::user()->staff_type == 'Agent') {
                  $item->shadow = 0;
                }
                $item->token = $request->_token;

                if($item->save())
                {
// Total Return Loan Principal amount                    
                  $total_received_principal =   tbl_loan_return_model::where('loan_ac_model_id',$item->loan_ac_model_id)->sum('received_principal');

                $loan_installment_item = loan_ac_installment::where('loan_ac_model_id',$item->loan_ac_model_id)->orderBy('installment_date','asc')->get();
             // print_r($loan_installment_item);
            $cnt = count($loan_installment_item);
           
            
            if($cnt >= 1)
            {
                foreach($loan_installment_item as $val)
                {
                    if($total_received_principal <= $val->principal)
                    {
                        $loan_received = loan_ac_installment::where('id',$val->id)->orderBy('installment_date','asc')->first();
                        $loan_received->received_principal = $total_received_principal;
                        $loan_received->save();
                        $total_received_principal = 0;
                    }
                    else{
                        $loan_received = loan_ac_installment::where('id',$val->id)->orderBy('installment_date','asc')->first();
                        $loan_received->received_principal = $val->principal;
                        $loan_received->save();
                        $total_received_principal = $total_received_principal - $val->principal;
                    }
                }
            }
               $memebr_item =  member_type_model::where('id',$request->member_type_model)->first();
               $loan_model = loan_ac_model::where('id',$request->loan_ac_model)->first();

// ********************
        // Head entry first                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   $tbl_item->gtype = $request->loan_type;
                   $tbl_item->stype = $memebr_item->name.' LOAN '.$request->loan_type;
                   $tbl_item->date_of_transaction = $request->receiving_date;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'principal';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->amount = $request->principal_received;
                   $tbl_item->additional_amt = 0;
                   $tbl_item->particular = $member_detail->full_name;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->loan_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->main_head = $memebr_item->name.' LOAN '.$request->loan_type;
                   $tbl_item->form_name = 'Loan Recovery';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                    $tbl_item->agent_id = $member_detail->agent_name;
                   $tbl_item->member_type_model_id = $request->member_type_model;
                   $tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $tbl_item->shadow = 0;
                    }
                   
                   $tbl_item->save();
                   $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);
                   $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                   $update_tbl_ledger_model->voucher_no = $voucher;
                   $update_tbl_ledger_model->save();
// Member type
// ********************
        // Head entry Second                   
// ********************
                
                   $tbl_item = new tbl_ledger_model();
                   $tbl_item->gtype = 'INTEREST RECEIVED';
                   $tbl_item->stype = 'INTEREST RECEIVED ON '.$request->loan_type;
                   $tbl_item->date_of_transaction = $request->receiving_date;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'Interest';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Cr';

                   if((($request->interest_recover + $request->pending_interest) - $request->total_received) > 0)
                    {
                        $tbl_item->amount = $request->total_received - $request->add_recover;
                    }
                    else
                    {
                        $tbl_item->amount = $request->interest_recover + $request->pending_interest - $request->add_recover;    
                    }

                   $tbl_item->additional_amt = $request->add_recover;
                   $tbl_item->particular = $member_detail->full_name;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->loan_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->main_head = 'INTEREST RECEIVED ON '.$request->loan_type;
                   $tbl_item->form_name = 'Loan Recovery';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->agent_id = $member_detail->agent_name;
                   $tbl_item->member_type_model_id = $request->member_type_model;
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
                    $cash_tbl_item->gtype = 'SAVING';
                    $cash_tbl_item->stype = 'MEMBER SAVING';
                    $cash_tbl_item->main_head = 'MEMBER SAVING';
                    // saving account model start
                    $item = new saving_ac_model();

                    $item->open_new_ac_model_id = $member_detail->id;
                    $item->user_id = Auth::user()->id;
                    $item->agent_id = $member_detail->agent_name;
                    $item->member_type_model_id = 1;
                    $item->account_no = $member_detail->account_no;
                    $item->amount = $request->total_received;
                    $item->date_of_transaction = $request->receiving_date;
                    $item->mode_of_transaction = 'Transfer';
                    $item->type_of_transaction = 'Withdrawal';
                    $item->particular = 'Loan Installment';
                    $item->remarks = 'Withdrawal for Loan';
                    $item->session_year = '2022-2023';
                    $item->save();
                    // saving account model end
                }
                 
                   $cash_tbl_item->date_of_transaction = $request->receiving_date;
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->account_no = $request->account_no;
                   $cash_tbl_item->account_head = 'LOAN';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->amount = $request->total_received;
                   $cash_tbl_item->particular = $member_detail->full_name;
                   $cash_tbl_item->loan_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->form_name = 'Loan Recovery';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                    $cash_tbl_item->agent_id = $member_detail->agent_name;
                   $cash_tbl_item->member_type_model_id = $request->member_type_model;
                   $cash_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $cash_tbl_item->shadow = 0;
                    }
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();
                
                
                   
                   $return_url = $request->return_url;

                    return response()->json(['success'=>'<li>Payment successfully recovored</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
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
    public function destroy($id)
    {
        $loan_ac_model = loan_ac_model::find($id);
        $loan_installment = loan_ac_installment::where('loan_ac_model_id',$id)->get();
        $tbl_loan_return = tbl_loan_return_model::where('loan_ac_model_id',$id)->get();
        $tbl_ledger = tbl_ledger_model::where('loan_ac_model_id',$id)->whereFormName('LOAN')->get();
        if(count($tbl_loan_return) <= 0)
        {
           if($loan_ac_model->delete())
            {
                $tbl_loan_return->each->delete();
                $tbl_ledger->each->delete();
                $loan_installment->each->delete();                
               return response()->json(['success'=>'done']);
            }  
        }
        else
        {
           return response()->json(['error'=>'Failed']); 
        }
    }

    public function deleteRecoverPayment($id,$did,$tdate)
    {

        // return $id;
        $tbl_loan_return_model = tbl_loan_return_model::findOrFail($id);
        $tbl_loan_return_model->delete();
        $tbl_ledger = tbl_ledger_model::where('loan_ac_model_id', $id)->where('form_name','Loan Recovery')->whereDateOfTransaction($tdate)->delete();
        if($tbl_ledger)
        {
            $total_received_principal =  tbl_loan_return_model::where('loan_ac_model_id',$did)->sum('received_principal');

            $loan_installment_item = loan_ac_installment::where('loan_ac_model_id',$did)->orderBy('installment_date','asc')->get();
            // print_r($loan_installment_item);

            loan_ac_installment::where('loan_ac_model_id',$tbl_loan_return_model->loan_ac_model_id)->update(array('received_principal' => 0));
           
                if(count($loan_installment_item) >= 1)
                {
                    foreach($loan_installment_item as $val)
                    {
                        
                        if($total_received_principal <= $val->principal)
                        {
                            $loan_received = loan_ac_installment::where('id',$val->id)->orderBy('installment_date','asc')->first();
                            $loan_received->received_principal = $total_received_principal;
                            $loan_received->save();
                            $total_received_principal = 0;
                        }
                        else{
                            $loan_received = loan_ac_installment::where('id',$val->id)->orderBy('installment_date','asc')->first();
                            $loan_received->received_principal = $val->principal;
                            $loan_received->save();
                            $total_received_principal = $total_received_principal - $val->principal;
                        }
                    }
                }
               return response()->json(['success'=>'done']);
            }  
        
        else
        {
           return response()->json(['error'=>'Failed']); 
        }        
    }

    public function printPDF(Request $request,$id,$token,$pt,$pr,$doa)
    {
       // This  $data array will be passed to our PDF blade
        $item = loan_ac_model::with('member_type_model')->find($id);

        $customer = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$item->account_no)->where('member_type_model_id',$item->member_type_model_id)->first();
        $guarantor_one = open_new_ac_model::where('id',$item->guarnter_one)->first();
        $guarantor_two = open_new_ac_model::where('id',$item->guarnter_two)->first();

        $balance = loan_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$item->member_type_model_id)->where('account_no',$item->account_no)->where('status',1)->sum('amount');
        $company_profile = company_address_model::first();
        $data = [
            'item' => $item,
            'customer' => $customer,
            'balance' => $balance,
            'company_profile' => $company_profile,
            'notice_data' => $token,
            'pt' => $pt,
            'pr' => $pr,
            'doa' => $doa,
            'guarantor_one' => $guarantor_one,
            'guarantor_two' => $guarantor_two,
        ];
        // dd($data['company_profile']);
        if($request->page == 'notice')
        {
            return view(TRANSACTION_LOAN_AC.'notice')->with($data);
        }
        if($request->page == 'election')
        {
            return view(TRANSACTION_LOAN_AC.'notice-election')->with($data);
        }
        return view(TRANSACTION_LOAN_AC.'notice')->with($data);
    }

    public function LoanEdit(Request $request)
    {
        $data['loan'] = loan_ac_model::whereId($request->id)->first();
        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['type_of_interest'] = ["Simple Interest","Quarterly Interest","Yearly Interest"];
        $data['loan_types'] = loan_model::orderBy('name','asc')->get();
        $data['loan_purpose'] = loanpurpose_model::orderBy('name','asc')->get();
        $data['guarenter_first'] = open_new_ac_model::where('member_type_model_id',1)
            ->orderBy('full_name','asc')
            ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->get(['id','full_name','account_no']);
        $data['loan_interest'] = ['Reducing','Flat'];
        return view('Transaction.LOAN_Ac.loan-edit')->with($data);
    }

    public function LoanUpdate(Request $request, $id = null)
    {

        $validator = Validator::make($request->all(), [
            'member_type_model_id' => 'bail|required',
            'account_no' => 'bail|required',
            'date_of_transaction' => 'bail|required',
            'loan_purpose' => 'bail|required',
            'amount' => 'bail|required|numeric',
            'loan_type' => 'bail|required',
            'term' => 'bail|required',
            'month_value' => 'bail|required|numeric',
            'interest' => 'bail|required|numeric',
            'pannelty_interest' => 'bail|required||numeric',
            'additional_interest' => 'bail|nullable|numeric',

        ]);

        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
// Member detail

            $member_detail = open_new_ac_model::where('account_no',$this->ac_no)->where('member_type_model_id',$request->member_type_model_id)->first();
            $item = loan_ac_model::where('open_new_ac_model_id',$member_detail->account_no)->first();

            $item->open_new_ac_model_id = $request->open_ac_id;
            $item->user_id = Auth::user()->id;
            $item->agent_id = $member_detail->agent_name;
            $item->member_type_model_id = $request->member_type_model_id;
            $item->loan_type = $request->loan_type;
            $item->term = $request->term;
            $item->months = $request->month_value;
            $item->interest = $request->interest;
            $item->pannelty_int = $request->pannelty_interest;
            $item->additional_int = $request->additional_interest;
            $item->type_of_interest = $request->type_of_interest;
            $item->loan_purpose = $request->loan_purpose;
            $item->date_of_advance = $request->date_of_transaction;
            $item->account_no = $this->ac_no;
            $item->mode_of_payment = $request->mode_of_transaction;
            $item->amount = $request->amount;
            $item->inst_amt = $request->loop_net[0];
            $item->guarnter_one = $request->guarantor_one;
            $item->guarnter_two = $request->guarantor_two;
            $item->cheque_date = $request->cheque_date;
            $item->cheque_no = $request->cheque_number;
            $item->session_year = '2019-2020';
            if (Auth::user()->staff_type == 'Agent') {
                $item->shadow = 0;
            }
            $item->token = $request->_token;

            if($item->save())
            {
                $memebr_item =  member_type_model::where('id',$request->member_type_model_id)->first();
                $loan_model = loan_model::where('id',$request->loan_type)->first();
// Loan Installment query

                $loan_ac_model_id = $item->id;
                $open_new_ac_model_id = $member_detail->id;
                $user_id = Auth::user()->id;
                $agent_id = $member_detail->agent_name;
                $member_type_model_id = $request->member_type_model_id;
                $account_no = $this->ac_no;
                $installment_date = $request->loop_date;
                $principal = $request->loop_principal;
                $recoberable_intr = $request->loop_recoberable_int;
                $net_amt = $request->loop_net;
                $session_year = '2019-2020';
                if (Auth::user()->staff_type == 'Agent') {
                    $shadow = 0;
                }
                $shadow = 1;
                $token = $request->_token;
                $create = date('Y-m-d h:m:i');
                $update = date('Y-m-d h:m:i');
                loan_ac_installment::whereIn('account_no',[$member_detail->account_no])->delete();
                $loan_item = new loan_ac_installment();

                $loan_items = array();
                if(count($installment_date) >= 1)
                {
                    for($i = 0; $i < count($installment_date); $i++){

                        $arr[] = array(
                            'loan_ac_model_id'=>$loan_ac_model_id,
                            'open_new_ac_model_id'=>$open_new_ac_model_id,
                            'user_id'=>$user_id,
                            'agent_id'=>$agent_id,
                            'member_type_model_id'=>$member_type_model_id,
                            'account_no'=>$account_no,
                            'installment_date'=>$installment_date[$i],
                            'principal'=>$principal[$i],
                            'recoberable_intr'=>$recoberable_intr[$i],
                            'net_amt'=>$net_amt[$i],
                            'session_year'=>$session_year,
                            'shadow'=>$shadow,
                            'token'=>$token,
                            'updated_at'=>$update,
                        );
                    }

                    $temp = $loan_item->insert($arr);
                }

                $return_url = url(TRANSACTION_URL_LOAN_AC);
                return response()->json(['success'=>'<li><span>Success!</span> Update Record Inserted Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
            }

        }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
        //Auth::login($user);
    }

}
