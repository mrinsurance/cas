<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\open_new_ac_model;
use App\state_model;
use App\district_model;
use App\saving_ac_model;
use App\branch_model;
use App\member_type_model;
use App\tbl_ledger_model;
use App\company_address_model;
use Auth;
use DB;
use Response;

class saving_ac_Controller extends Controller
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

      if($request->ac_no == true && $request->member_id == true)
      {
      $cur_date = date('Y-m-d');
      $this->ac_no = $request->ac_no;
      $item = open_new_ac_model::with('state_model','district_model','branch_model')
        ->where('account_no',$this->ac_no)
        ->where('member_type_model_id',$request->member_id);
        if(Auth::user()->staff_type == 'Agent')
            {
                $item = $item->where('agent_name',Auth::user()->id);
            }
        $item = $item->first();

        $deposite_bal = saving_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('type_of_transaction','Deposit')->sum('amount');

        $withdraw_bal = saving_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('type_of_transaction','Withdrawal')->sum('amount');
        if ($item)
        {
            $items = saving_ac_model::orderBy('date_of_transaction','asc')
                ->where('account_no',$item->account_no)
                ->where('member_type_model_id',$item->member_type_model_id)
                ->get();
        }

        $data = [
          'membertypes' => member_type_model::orderBy('name','asc')->get(),
          'open_ac_id' => $item->id,
          'full_name' => $item->full_name,
          'father_name' => $item->father_name != '' ? $item->father_name : 'N/a',
          'address' => $item->village.' '.$item->post_office.' '.@$item->district_model->name.' - ('.@$item->state_model->name.')',
          'branch' => @$item->branch_model->name,
          'priview' => url(PREFIX1).''.$item->file,
          'signature' => url(PREFIX1).''.$item->signature,
          'view_ac_url' => url(TRANSACTION_URL_SAVING_AC).''.$item->id,
          'pl_url' => url(LEDGER_REPORT_URL_PERSONAL_LEDGER).'?_token=4eLSx7hR0YeCoXDlJtgE7fmwvKLcT7oky9c5qi8S&from_date='.$cur_date.'&to_date='.$cur_date.'&member_type='.$item->member_type_model_id.'&account='.$this->ac_no,
          'balance' => $deposite_bal - $withdraw_bal,
          'lf_no' => $item->lf_no,
            'items' => $items,
        ];
      }
      else
      {
        $data = [
          'membertypes' => member_type_model::orderBy('name','asc')->get(),
            'items' => [],
        ];
      }
      return view(TRANSACTION_SAVING_AC."create")->with($data);
    }

    public function accountdetail(Request $request)
    {
      $cur_date = date('Y-m-d');
      $this->ac_no = $request->ac_no;
      $item = open_new_ac_model::with('state_model','district_model','branch_model')
        ->where('account_no',$this->ac_no)
        ->where('member_type_model_id',$request->member_id);
        if(Auth::user()->staff_type == 'Agent')
            {
                $item = $item->where('agent_name',Auth::user()->id);
            }
        $item = $item->first();
      if($item)
      {
              $items = saving_ac_model::orderBy('date_of_transaction','asc')
                  ->where('account_no',$item->account_no)
                  ->where('member_type_model_id',$item->member_type_model_id)
                  ->get();

        $deposite_bal = saving_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('type_of_transaction','Deposit')->sum('amount');

        $withdraw_bal = saving_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('type_of_transaction','Withdrawal')->sum('amount');

        $data = [
          'open_ac_id' => $item->id,
          'full_name' => $item->full_name,
          'father_name' => $item->father_name != '' ? $item->father_name : 'N/a',
          'address' => $item->village.' '.$item->post_office.' '.@$item->district_model->name.' - ('.@$item->state_model->name.')',
          'branch' => @$item->branch_model->name,
          'priview' => url(PREFIX1).''.$item->file,
          'signature' => url(PREFIX1).''.$item->signature,
          'view_ac_url' => url(TRANSACTION_URL_SAVING_AC).''.$item->id,
          'pl_url' => url(LEDGER_REPORT_URL_PERSONAL_LEDGER).'?_token=4eLSx7hR0YeCoXDlJtgE7fmwvKLcT7oky9c5qi8S&from_date='.$cur_date.'&to_date='.$cur_date.'&member_type='.$item->member_type_model_id.'&account='.$this->ac_no,
          'balance' => $deposite_bal - $withdraw_bal,
          'lf_no' => $item->lf_no,
            'items' => $items,
        ];
      return response()->json(['success'=>$data,'status'=>200]);
      }
      else
      {
        return response()->json(['error'=>'A/c detail not found!','status'=>201]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$token)
    {
      //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         return $request->all();
        $validator = Validator::make($request->all(), [
           // 'open_ac_id' => 'required|numeric',
            'amount' => 'bail|required|numeric',
            'date_of_transaction' => 'required',
            'mode_of_transaction' => 'required',
            'cheque_date' => 'bail|sometimes',
            'cheque_number' => 'bail|sometimes',
            'type_of_transaction' => 'required',
            'transaction_particular' => 'required',
                        
        ]);

        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
// Member detail            
            $member_detail = open_new_ac_model::where('account_no',$this->ac_no)->where('member_type_model_id',$request->member_type_model_id)->first();            
                $item = new saving_ac_model();
            
                $item->open_new_ac_model_id = $request->open_ac_id;
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->member_type_model_id = $request->member_type_model_id;
                $item->account_no = $request->account_no;
                $item->amount = $request->amount;
                $item->date_of_transaction = $request->date_of_transaction;
                $item->mode_of_transaction = $request->mode_of_transaction;
                $item->cheque_date = $request->cheque_date;
                $item->cheque_no = $request->cheque_number;
                $item->sub_group = $request->subGroups;
                $item->type_of_transaction = $request->type_of_transaction;
                $item->particular = $request->transaction_particular;
                $item->remarks = $request->remarks;
                $item->session_year = '2019-2020';
                if(Auth::user()->staff_type == 'Agent')
                {
                    $item->shadow = 0;
                }                
                $item->session_year = '2019-2020';

                $item->token = $request->_token;
                
                $deposite_bal = saving_ac_model::where('open_new_ac_model_id',$request->open_ac_id)->where('type_of_transaction','Deposit')->sum('amount');

                $withdraw_bal = saving_ac_model::where('open_new_ac_model_id',$request->open_ac_id)->where('type_of_transaction','Withdrawal')->sum('amount');

                $balance = $deposite_bal - $withdraw_bal;
                if ($balance < $request->amount && $request->type_of_transaction == 'Withdrawal') {
                    return response()->json(['sec_key'=>$request->all(),'error_msg'=>'Your minimum balance is low ']);
                    exit;
                }
                if($item->save())
                {
               $memebr_item =  member_type_model::where('id',$request->member_type_model_id)->first();
// Extra code for SMS
$deposite_msg_bal = saving_ac_model::where('open_new_ac_model_id',$item->open_new_ac_model_id)->where('type_of_transaction','Deposit')->sum('amount');
$withdraw_msg_bal = saving_ac_model::where('open_new_ac_model_id',$item->open_new_ac_model_id)->where('type_of_transaction','Withdrawal')->sum('amount');

$msg_balance = ($deposite_msg_bal - $withdraw_msg_bal);               
if($request->type_of_transaction == 'Deposit') 
{
  $trans = 'Deposited in';
}              
else
{
  $trans = 'Withdrawal from';
}
// SMS sending Code start

$mobile1 = $member_detail->contact_no;                
$message = "Dear Customer, Rs.". $request->amount ."/- ". $trans ." your saving account no. (". $item->account_no .") on ". date('d-M-Y', strtotime($item->created_at)) ." Avl Bal is Rs.". $msg_balance ."/- ";
sendSms($mobile1, $message);
// Sms sending Code End                
// ********************
        // Head entry                    
// ********************
// Member type
                if ($request->type_of_transaction == 'Deposit') {
                    $type_of_transaction = 'Cr';
                }
                if ($request->type_of_transaction == 'Withdrawal') {
                    $type_of_transaction = 'Dr';
                }
                   $tbl_item = new tbl_ledger_model();
                   if($memebr_item->name == 'MEMBER JOINT')
                   {
                       $tbl_item->gtype = 'MEMBER SAVING';
                       $tbl_item->stype = 'MEMBER SAVING';
                   }
                   else{
                       $tbl_item->gtype = $memebr_item->name.' SAVING';
                       $tbl_item->stype = $memebr_item->name.' SAVING';
                   }

                   $tbl_item->date_of_transaction = $request->date_of_transaction;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'SAVING';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->type_of_transaction = $type_of_transaction;
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = $member_detail->full_name;
                   // $request->transaction_particular;
                   $tbl_item->saving_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->cheque_date = $request->cheque_date;
                   $tbl_item->cheque_no = $request->cheque_number;
                   $tbl_item->main_head = $memebr_item->name.' SAVING';
                   $tbl_item->form_name = 'SAVING';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                    $tbl_item->agent_id = $member_detail->agent_name;
                   $tbl_item->member_type_model_id = $request->member_type_model_id;
                   $tbl_item->session_year = '2019-2020';
                   $tbl_item->remarks = $request->remarks;
                   if(Auth::user()->staff_type == 'Agent')
                    {
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
                if ($request->type_of_transaction == 'Deposit') {
                    $cash_type_of_transaction = 'Dr';
                }
                if ($request->type_of_transaction == 'Withdrawal') {
                    $cash_type_of_transaction = 'Cr';
                }

                $cash_tbl_item = new tbl_ledger_model();
                if($request->mode_of_transaction == 'Cash')
                {
                    $cash_tbl_item->gtype = 'Cash';
                    $cash_tbl_item->stype = 'Cash';
                    $cash_tbl_item->main_head = 'Cash';
                    $cash_tbl_item->entry_type = 'Cash';
                    $cash_tbl_item->particular = $member_detail->full_name;
                }
                else{
                    $cash_tbl_item->gtype = 'BANK ACCOUNT';
                    $cash_tbl_item->stype = $request->subGroups;
                    $cash_tbl_item->main_head = $request->subGroups;
                    $cash_tbl_item->entry_type = 'Transfer';
                    $cash_tbl_item->particular = $request->subGroups;
                }
                 
                   $cash_tbl_item->date_of_transaction = $request->date_of_transaction;
                   $cash_tbl_item->account_no = $request->account_no;
                   $cash_tbl_item->account_head = 'SAVING';

                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->type_of_transaction = $cash_type_of_transaction;
                   $cash_tbl_item->amount = $request->amount;

                   // $request->transaction_particular;
                   $cash_tbl_item->saving_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->cheque_date = $request->cheque_date;
                   $cash_tbl_item->cheque_no = $request->cheque_number;
                   
                   $cash_tbl_item->form_name = 'SAVING';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                    $cash_tbl_item->agent_id = $member_detail->agent_name;
                   $cash_tbl_item->member_type_model_id = $request->member_type_model_id;
                   $cash_tbl_item->session_year = '2019-2020';
                   $cash_tbl_item->remarks = $request->remarks;
                   $cash_tbl_item->voucher_no = $voucher;
                       if(Auth::user()->staff_type == 'Agent')
                    {
                        $cash_tbl_item->shadow = 0;
                    } 
                   $cash_tbl_item->save();
                
                   
                   $return_url = url(TRANSACTION_URL_SAVING_AC.'account/'.$request->account_no.'/'.$request->member_type_model_id.'?date='.$request->date_of_transaction.'&open_ac_id='.@$request->open_ac_id);
                    return response()->json(['success'=>'<li><span>Success!</span> The New Record Inserted Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = open_new_ac_model::where('id',$id)->first();

        $data = [
              'profile' => $profile,
              'items' => saving_ac_model::orderBy('date_of_transaction','asc')
                        ->where('account_no',$profile->account_no)
                        ->where('member_type_model_id',$profile->member_type_model_id)
                        ->get(),
        ];


        return view(TRANSACTION_SAVING_AC.'transaction-list')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $token = null)
    {
        $data['item'] = saving_ac_model::with('member_type_model','open_new_ac_model')->find($id);

        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();

        $deposite_bal = saving_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('type_of_transaction','Deposit')->sum('amount');

        $withdraw_bal = saving_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('type_of_transaction','Withdrawal')->sum('amount');

        if ($data['item'])
        {
            $data['items'] = saving_ac_model::orderBy('date_of_transaction','asc')
                ->where('account_no',$data['item']->account_no)
                ->where('member_type_model_id',$data['item']->member_type_model_id)
                ->get();
        }
        else{
            $data['items'] = [];
        }

        $data['balance'] = $deposite_bal - $withdraw_bal;

        return view(TRANSACTION_SAVING_AC.'edit')->with($data);
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
//         return $request->all();
        $validator = Validator::make($request->all(), [
            'amount' => 'bail|required|numeric',
            'date_of_transaction' => 'required',
            'mode_of_transaction' => 'required',
            'cheque_date' => 'bail|sometimes',
            'cheque_number' => 'bail|sometimes',
            'type_of_transaction' => 'required',
            'transaction_particular' => 'required',
                        
        ]);

        if ($validator->passes()) {

            $item = saving_ac_model::find($id);
            
                $item->amount = $request->amount;
                $item->date_of_transaction = $request->date_of_transaction;
                $item->mode_of_transaction = $request->mode_of_transaction;
                $item->cheque_date = $request->cheque_date;
                $item->cheque_no = $request->cheque_number;
                $item->sub_group = $request->subGroups;
                $item->type_of_transaction = $request->type_of_transaction;
                $item->particular = $request->transaction_particular;
                $item->remarks = $request->remarks;
                $item->session_year = '2019-2020';
                $item->updated_by = Auth::user()->id;
                if(Auth::user()->staff_type == 'Agent')
                    {
                        $item->shadow = 0;
                    } 
                $item->token = $request->_token;
                
                $deposite_bal = saving_ac_model::where('account_no',$request->account_no)
                  ->where('member_type_model_id',$request->member_type)
                  ->where('type_of_transaction','Deposit')
                  ->sum('amount');
                
                $withdraw_bal = saving_ac_model::where('account_no',$request->account_no)
                  ->where('member_type_model_id',$request->member_type)
                  ->where('type_of_transaction','Withdrawal')
                  ->sum('amount');

                $balance = $deposite_bal - $withdraw_bal;
               
                if ($balance < $request->amount && $request->type_of_transaction == 'Withdrawal') {
                    return response()->json(['sec_key'=>$request->all(),'error_msg'=>'Your minimum balance is low ']);
                    exit;
                }
                if($item->save())
                {
               $memebr_item =  member_type_model::where('id',$item->member_type_model_id)->first();

// ********************
        // Head entry                    
// ********************
// Member type
                if ($request->type_of_transaction == 'Deposit') {
                    $type_of_transaction = 'Cr';
                }
                if ($request->type_of_transaction == 'Withdrawal') {
                    $type_of_transaction = 'Dr';
                }
                  $tbl_item = tbl_ledger_model::where('saving_ac_model_id',$id)->where('account_head','SAVING')->where('stype',$memebr_item->name.' SAVING')->first();

                    if($memebr_item->name == 'MEMBER JOINT')
                    {
                        $tbl_item->gtype = 'MEMBER SAVING';
                        $tbl_item->stype = 'MEMBER SAVING';
                    }
                    else{
                        $tbl_item->gtype = $memebr_item->name.' SAVING';
                        $tbl_item->stype = $memebr_item->name.' SAVING';
                    }

                   $tbl_item->date_of_transaction = $request->date_of_transaction;
                   $tbl_item->account_head = 'SAVING';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = $type_of_transaction;
                   $tbl_item->amount = $request->amount;
                   $tbl_item->saving_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->cheque_date = $request->cheque_date;
                   $tbl_item->cheque_no = $request->cheque_number;
                   $tbl_item->main_head = $memebr_item->name.' SAVING';
                   $tbl_item->form_name = 'SAVING';
                   $tbl_item->token = $request->_token;
                   $tbl_item->session_year = '2019-2020';
                   $tbl_item->user_id = Auth::user()->id;
                    $tbl_item->agent_id = $item->agent_id;
                   $tbl_item->remarks = $request->remarks;
                   if(Auth::user()->staff_type == 'Agent')
                    {
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
                if ($request->type_of_transaction == 'Deposit') {
                    $cash_type_of_transaction = 'Dr';
                }
                if ($request->type_of_transaction == 'Withdrawal') {
                    $cash_type_of_transaction = 'Cr';
                }

               $cash_tbl_item = tbl_ledger_model::where('saving_ac_model_id',$id);
                if($item->mode_of_transaction == 'Transfer')
                {
                    $cash_tbl_item->where('gtype','BANK ACCOUNT');
                }
                else{
                    $cash_tbl_item->where('account_head','SAVING')->where('entry_type','Cash')->where('stype','Cash');
                }
                    $cash_tbl_item =  $cash_tbl_item->first();
                if($request->mode_of_transaction == 'Cash')
                {
                    $cash_tbl_item->gtype = 'Cash';
                    $cash_tbl_item->stype = 'Cash';
                    $cash_tbl_item->main_head = 'Cash';
                    $cash_tbl_item->entry_type = 'Cash';

                }
                else{
                    $cash_tbl_item->gtype = 'BANK ACCOUNT';
                    $cash_tbl_item->stype = $request->subGroups;
                    $cash_tbl_item->main_head = $request->subGroups;
                    $cash_tbl_item->entry_type = 'Transfer';
                    $cash_tbl_item->particular = $request->subGroups;
                }
                 
                   $cash_tbl_item->date_of_transaction = $request->date_of_transaction;
                   $cash_tbl_item->account_head = 'SAVING';

                   $cash_tbl_item->type_of_transaction = $cash_type_of_transaction;
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->saving_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->cheque_date = $request->cheque_date;
                   $cash_tbl_item->cheque_no = $request->cheque_number;
                   
                   $cash_tbl_item->form_name = 'SAVING';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->session_year = '2019-2020';
                   $cash_tbl_item->remarks = $request->remarks;
                   $cash_tbl_item->user_id = Auth::user()->id;
                    $cash_tbl_item->agent_id = $item->agent_id;
                   if(Auth::user()->staff_type == 'Agent')
                    {
                        $cash_tbl_item->shadow = 0;
                    } 
                   $cash_tbl_item->save();

                   $cash_update_tbl_ledger_model = tbl_ledger_model::find($cash_tbl_item->id);
                   $cash_voucher = date('ymd').''.$cash_update_tbl_ledger_model->id;
                   $cash_update_tbl_ledger_model->voucher_no = $cash_voucher;
                   $cash_update_tbl_ledger_model->save();                   
                   
                   $return_url = url(TRANSACTION_URL_SAVING_AC.''.$item->open_new_ac_model_id);
                    return response()->json(['success'=>'<li><span>Success!</span> Record Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
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

    public function printRD(Request $request, $id = null)
      {
          $item = saving_ac_model::where('id',$id)->first();
          $data = [
              'item' => $item,
              'company_profile' => company_address_model::first(),
              'voucher' => tbl_ledger_model::where('saving_ac_model_id',$item->id)->first(),
          ];          
          return view(TRANSACTION_SAVING_AC.'saving-transaction-print')->with($data);
          
      }
   
}
