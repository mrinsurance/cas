<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\open_new_ac_model;
use App\state_model;
use App\district_model;
use App\branch_model;
use App\member_type_model;
use App\drd_model;
use App\drd_installment_model;
use App\tbl_ledger_model;
use Auth;
use DB;
use Response;

class drd_Controller extends Controller
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

    public function index()
    {
        $items_obj = drd_model::with('open_new_ac_model')->orderBy(DB::raw('LENGTH(account_no), account_no'))->orderBy('updated_at','desc');
        if(Auth::user()->staff_type == 'Agent')
        {
            $items_obj = $items_obj->where('agent_id',Auth()->user()->id);
        }
        $data['items'] = $items_obj->get();
        return view(TRANSACTION_DRD_AC.'list')->with($data);
    }

    public function accountdetail(Request $request)
    {
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
        $deposite_bal = drd_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('transaction_date','Deposit')->sum('amount');

        $withdraw_bal = drd_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('transaction_date','Withdrawal')->sum('amount');

        $data = [
          'open_ac_id' => $item->id,
          'full_name' => $item->full_name,
          'father_name' => $item->father_name != '' ? $item->father_name : 'N/a',
          'address' => $item->village.' '.$item->post_office.' '.@$item->district_model->name.' - ('.@$item->state_model->name.')',
          'branch' => @$item->branch_model->name,
          'priview' => url(PREFIX1).''.$item->file,
          'signature' => url(PREFIX1).''.$item->signature,
          'view_ac_url' => url(TRANSACTION_URL_SAVING_AC).''.$item->id,
          'balance' => $deposite_bal - $withdraw_bal,
        ];
      return response()->json(['success'=>$data]);
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
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter','Others'];
        $data['auto_id'] = drd_model::orderBy('drd_no','desc')->first();
        return view(TRANSACTION_DRD_AC."create")->with($data);
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
            'account_no' => 'bail|required|numeric',
            'drd_no' => 'bail|required|numeric',
            'amount' => 'bail|required|numeric',
            'interest_rate' => 'bail|required|numeric',
            'drd_date' => 'bail|required',
            'period_of_drd' => 'bail|required|numeric',
            'maturity_date' => 'bail|required',
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
                        
        ]);

        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
            $member_detail = open_new_ac_model::where('account_no',$request->account_no)->where('member_type_model_id',$request->member_type_model_id)->first();   

            $item = new drd_model();
            
                $item->open_new_ac_model_id = $request->open_ac_id;
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->member_type_model_id = $request->member_type_model_id;
                $item->account_no = $this->ac_no;
                $item->drd_no = $request->drd_no;
                $item->amount = $request->amount;
                $item->int_rate = $request->interest_rate;
                $item->transaction_date = $request->drd_date;
                $item->period_drd = $request->period_of_drd;
                $item->maturity_date = $request->maturity_date;
                $item->matured_on_date = $request->matured_on_date;
                $item->maturity_amount = $request->maturity_amount;

                $item->nominee_name = $request->nominee_name;
                $item->nominee_relation = $request->nominee_relation;
                $item->session_year = '2019-2020';
                $item->token = $request->_token;
                $item->save();
// SMS sending Code start

$mobile1 = $member_detail->contact_no;                
$message = "Dear Customer your DRD with the account no. (". $item->account_no .") has been created on ". date('d-M-Y', strtotime($item->transaction_date)) ." daily installment Rs.". $item->amount."/- interest @".$item->int_rate."% for ". $item->period_drd ." days.";
sendSms($mobile1, $message);

// Sms sending Code End 
                $return_url = url(TRANSACTION_URL_DRD_AC);
                return response()->json(['success'=>'<li><span>Success!</span> The New Record Inserted Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
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
    public function show($id)
    {
        $count = drd_installment_model::where('drd_model_id',$id)->count();
        $data['item'] = drd_model::find($id);
        $data['user_detail'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter','Others'];
        
        return view(TRANSACTION_DRD_AC.'show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $count = drd_installment_model::where('drd_model_id',$id)->count();
        $data['item'] = drd_model::find($id);
        $data['user_detail'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter','Others'];
        if ($count > 0) {
            return back();
        }
        return view(TRANSACTION_DRD_AC.'edit')->with($data);
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
            'drd_date' => 'bail|required',
            'period_of_drd' => 'bail|required|numeric',
            'maturity_date' => 'bail|required',
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
                        
        ]);

        if ($validator->passes()) {
                $item = drd_model::find($id);
            
                $item->amount = $request->amount;
                $item->int_rate = $request->interest_rate;
                $item->transaction_date = $request->drd_date;
                $item->period_drd = $request->period_of_drd;
                $item->maturity_date = $request->maturity_date;
                $item->matured_on_date = $request->matured_on_date;
                $item->maturity_amount = $request->maturity_amount;

                $item->nominee_name = $request->nominee_name;
                $item->nominee_relation = $request->nominee_relation;
                $item->session_year = '2019-2020';
                $item->user_id = Auth::user()->id;
                $item->token = $request->_token;

                $item->save();

                $return_url = url(TRANSACTION_URL_DRD_AC);
                return response()->json(['success'=>'<li><span>Success!</span> Record Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
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

    public function rdinstallment($id, $token)
    {
        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['item'] = drd_model::with('member_type_model')->find($id);
        $data['ac_holder'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();
        $data['installs'] = drd_installment_model::orderBy('installment_date','asc')->where('drd_model_id',$id)->get();

        $total_paid_install = 0;

        foreach($data['installs'] as $val)
        {

            $total_paid_install = ($total_paid_install + ($val->amount / $data['item']->amount));
        }
        $data['total_paid_install'] = $total_paid_install;
        return view(TRANSACTION_DRD_AC."installment")->with($data);
    }

    public function rdinstallmentPost(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'installment_date' => 'required',
            'amount' => 'bail|required|numeric',
            'no_of_installment' => 'bail|required|numeric',
        ]);

        if ($validator->passes()) {
// Member detail            
            $member_detail = open_new_ac_model::where('account_no',$request->account_no)->where('member_type_model_id',$request->member_type_id)->first();             
            $item = new drd_installment_model();
            
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->drd_model_id = $request->drd_id;
                $item->member_type_model_id = $request->member_type_id;
                $item->account_no = $request->account_no;
                $item->drd_no = $request->drd_no;
                $item->amount = $request->amount;
                $item->installment_date = $request->installment_date;
                $item->session_year = '2019-2020';
                if (Auth::user()->staff_type == 'Agent') {
                  $item->shadow = 0;
                }
                $item->token = $request->_token;

                $paid_install = $request->paid_install;
                $no_of_installment = $request->no_of_installment;
                $period_drd = $request->period_drd;
                $count_install = ($paid_install + $no_of_installment);
                if ($count_install > $period_drd) {
                    return response()->json(['sec_key'=>$request->all(),'error_msg'=>'Your DRD is over!']);
                    exit;
                }
                if($item->save())
                {
               $memebr_item =  member_type_model::where('id',$request->member_type_id)->first();
               
               $total_drd_bal = drd_installment_model::where('account_no',$request->account_no)->where('drd_no', $request->drd_no)->sum('amount');
// SMS sending Code start
$mobile1 = $member_detail->contact_no;                
$message = "Dear Customer Rs.".$item->amount."/- installment amount deposited in your DRD account no. (". $item->account_no .") on ". date('d-M-Y', strtotime($item->installment_date)) ." Avl Bal is Rs.". $total_drd_bal ."/- ";
sendSms($mobile1, $message);
// Sms sending Code End

// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' DRD';
                   $tbl_item->stype = $memebr_item->name.' DRD';

                   $tbl_item->date_of_transaction = $request->installment_date;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'DRD';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = $member_detail->full_name .' DRD NO '. $request->drd_no;
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->drd_model_id = $item->id;
                   $tbl_item->mode_of_transaction = "Cash";
                   $tbl_item->main_head = $memebr_item->name.' DRD';
                   $tbl_item->form_name = 'DRD';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->agent_id = $member_detail->agent_name;
                   $tbl_item->member_type_model_id = $request->member_type_id;
                   if (Auth::user()->staff_type == 'Agent') {
                      $tbl_item->shadow = 0;
                    }
                   $tbl_item->session_year = '2019-2020';
                   
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
                
                    $cash_tbl_item->gtype = 'Cash';
                    $cash_tbl_item->stype = 'Cash';
                    $cash_tbl_item->main_head = 'Cash';
                
                   $cash_tbl_item->date_of_transaction = $request->installment_date;
                   $cash_tbl_item->account_no = $request->account_no;
                   $cash_tbl_item->account_head = 'DRD';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->amount = $request->amount;
                   $tbl_item->particular = $member_detail->full_name .' DRD NO '. $request->drd_no;
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->drd_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = "Cash";
                   $cash_tbl_item->form_name = 'DRD';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->agent_id = $member_detail->agent_name;
                   $cash_tbl_item->member_type_model_id = $request->member_type_id;
                   $cash_tbl_item->session_year = '2019-2020';
                   if (Auth::user()->staff_type == 'Agent') {
                      $cash_tbl_item->shadow = 0;
                    }
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();

                $return_url = url($request->back_url);
                return response()->json(['success'=>'<li><span>Thanks!</span> Installment Received Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
            }
        }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
         //Auth::login($user);
    }

    public function editMaturedDRD($id)
    {
        $data['item'] = drd_model::with('open_new_ac_model')->find($id);
        $data['received_amt'] = drd_installment_model::where('drd_model_id',$data['item']->id)->sum('amount');
        return view(TRANSACTION_DRD_AC.'matured')->with($data);
    }

    public function updateMaturedDRD(Request $request, $id)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
        ]);

        if ($validator->passes()) {
            
            if($request->maturity_amount < $request->received_amount)
            {
                return response()->json(['sec_key'=>'','error_msg'=>'Your maturity amount is less than received amount. Please reset and try again!']);
                    exit;
            }

            $item = drd_model::find($id);
// Member detail            
            $member_detail = open_new_ac_model::where('account_no',$item->account_no)->where('member_type_model_id',$item->member_type_model_id)->first();            
                $item->matured_on_date = $request->matured_on_date;
                $item->maturity_amount = $request->maturity_amount;
                $item->user_id = Auth::user()->id;
                $item->status = $request->rdStatus;
                
                if($item->save())
                {
                    if($request->rdStatus == 1)
                    {
                        tbl_ledger_model::whereIn('drd_mature_status',[$item->id])->delete();
                    }
                    else{


                $memebr_item =  member_type_model::where('id',$item->member_type_model_id)->first();

// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' DRD';
                   $tbl_item->stype = $memebr_item->name.' DRD';

                   $tbl_item->drd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'DRD';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $request->received_amount;
                   $tbl_item->particular = $member_detail->full_name .' DRD No '. $request->rd_no;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->rd_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $memebr_item->name.' DRD';
                   $tbl_item->form_name = 'DRD';
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
        // Interest entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = 'INTEREST PAID';
                   $tbl_item->stype = 'INTEREST PAID ON '.$memebr_item->name.' DRD';

                   $tbl_item->drd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'DRD';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = ($request->maturity_amount - $request->received_amount);
                   $tbl_item->particular = $member_detail->full_name .' DRD No '. $request->rd_no;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->rd_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = 'INTEREST PAID ON '.$memebr_item->name.' DRD';
                   $tbl_item->form_name = 'DRD';
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
               
                    $cash_tbl_item->gtype = 'Cash';
                    $cash_tbl_item->stype = 'Cash';
                    $cash_tbl_item->main_head = 'Cash';
                    $cash_tbl_item->drd_mature_status = $item->id;
                   $cash_tbl_item->date_of_transaction = $request->matured_on_date;
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->account_no = $item->account_no;
                   $cash_tbl_item->account_head = 'DRD';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->amount = $request->maturity_amount;
                   $cash_tbl_item->particular = $member_detail->full_name .' DRD No '. $request->rd_no;
                   $cash_tbl_item->rd_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->form_name = 'DRD';
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
                   }
                   $return_url = url(TRANSACTION_URL_DRD_AC);
                    return response()->json(['success'=>'<li><span>Success!</span> Reocrd Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]); 
    }
   
}
