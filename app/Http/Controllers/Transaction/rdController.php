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
use App\rd_model;
use App\rd_installment_model;
use App\tbl_ledger_model;
use App\company_address_model;
use Auth;
use DB;
use Response;
use PDF;

class rdController extends Controller
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

    public function printPDF($id)
    {
       // This  $data array will be passed to our PDF blade

        $data['item'] = rd_model::with('member_type_model')->find($id);

        $data['customer'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $deposite_bal = rd_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',1)->sum('amount');

        $withdraw_bal = rd_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',0)->sum('amount');

        $data['balance'] = $deposite_bal - $withdraw_bal;
        return view(TRANSACTION_RD_AC.'pdf_view',compact(['data']));
    }

    public function index(Request $request)
    {
        $items_obj = rd_model::select('id','open_new_ac_model_id','account_no','rd_no','amount','transaction_date','maturity_date','status','token')
                ->with('open_new_ac_model')
                ->orderBy('status','desc')
                ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
                ->where('account_no',$request->account)
                ->where('member_type_model_id',$request->member);
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
        ]; 
        
        return view(TRANSACTION_RD_AC.'list')->with($data);
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

        $data['view_ac_url'] = url('transaction/recurring-deposite/show').'/'.$request->member_id.'/'.$this->ac_no.'/'.$request->_token;

        $deposite_bal = rd_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('status',1)->sum('amount');

        $withdraw_bal = rd_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('status',0)->sum('amount');

        $data['balance'] = $deposite_bal - $withdraw_bal;
        $data['base_url'] = url('/');
        $items = rd_model::where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->get();
        
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
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter','Others'];
        $data['auto_id'] = rd_model::orderBy('rd_no','desc')->first();
        return view(TRANSACTION_RD_AC."create")->with($data);
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
            'rd_no' => 'bail|required|numeric',
            'amount' => 'bail|required|numeric',
            'interest_rate' => 'bail|required|numeric',
            'rd_date' => 'bail|required',
            'period_of_rd' => 'bail|required|numeric',
            'maturity_date' => 'bail|required',
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
                        
        ]);

        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
            $member_detail = open_new_ac_model::where('account_no',$request->account_no)->where('member_type_model_id',$request->member_type_model_id)->first();   

            $item = new rd_model();
            
                $item->open_new_ac_model_id = $request->open_ac_id;
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->member_type_model_id = $request->member_type_model_id;
                $item->account_no = $this->ac_no;
                $item->rd_no = $request->rd_no;
                $item->amount = $request->amount;
                $item->int_rate = $request->interest_rate;
                $item->transaction_date = $request->rd_date;
                $item->period_rd = $request->period_of_rd;
                $item->maturity_date = $request->maturity_date;
                $item->matured_on_date = $request->matured_on_date;
                $item->maturity_amount = $request->maturity_amount;

                $item->nominee_name = $request->nominee_name;
                $item->nominee_relation = $request->nominee_relation;
                $item->lf_no = $request->lf_no;
                $item->session_year = '2019-2020';
                $item->token = $request->_token;
                $item->save();
// SMS sending Code start

$mobile1 = $member_detail->contact_no;                
$message = "Dear Customer your RD with the account no. (". $item->account_no .") has been created on ". date('d-M-Y', strtotime($item->transaction_date)) ." monthly installment Rs.". $item->amount."/- interest @".$item->int_rate."% for ". $item->period_rd ." months.";
sendSms($mobile1, $message);
// Sms sending Code End 
                $return_url = url(TRANSACTION_URL_RD_AC);
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
    public function show(Request $request, $member_id = null, $account_id = null)
    {
        // return "Welcome = ".$member_id;
        $items = rd_model::orderBy('updated_at','asc')->where('member_type_model_id',$member_id)->where('account_no',$account_id)->get();
        // dd($items);
        return view(TRANSACTION_RD_AC.'list',compact(['items']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $count = rd_installment_model::where('rd_model_id',$id)->count();
        $data['item'] = rd_model::find($id);
        $data['user_detail'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter','Others'];
        // if ($count > 0) {
        //     return back();
        // }
        
        return view(TRANSACTION_RD_AC.'edit')->with($data);
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
            'rd_date' => 'bail|required',
            'period_of_rd' => 'bail|required|numeric',
            'maturity_date' => 'bail|required',
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
                        
        ]);

        if ($validator->passes()) {
                $item = rd_model::find($id);
                
                $member_detail = open_new_ac_model::where('account_no',$item->account_no)->where('member_type_model_id',$item->member_type_model_id)->first();   

                $item->open_new_ac_model_id = $member_detail->id;
                $item->amount = $request->amount;
                $item->int_rate = $request->interest_rate;
                $item->transaction_date = $request->rd_date;
                $item->period_rd = $request->period_of_rd;
                $item->maturity_date = $request->maturity_date;
                $item->matured_on_date = $request->matured_on_date;
                $item->maturity_amount = $request->maturity_amount;

                $item->nominee_name = $request->nominee_name;
                $item->nominee_relation = $request->nominee_relation;
                $item->lf_no = $request->lf_no;
                $item->session_year = '2019-2020';
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->token = $request->_token;

                $item->save();

                $return_url = url(TRANSACTION_URL_RD_AC);
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
        $data['item'] = rd_model::with('member_type_model')->find($id);
        $data['ac_holder'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();
        $data['installs'] = rd_installment_model::where('rd_model_id',$id)
        ->orderBy('installment_date','asc')
        ->get();

        $total_paid_install = 0;

        foreach($data['installs'] as $val)
        {

            $total_paid_install = ($total_paid_install + ($val->amount / $data['item']->amount));
        }
        $data['total_paid_install'] = $total_paid_install;
        return view(TRANSACTION_RD_AC."installment")->with($data);
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
            $item = new rd_installment_model();
            
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->rd_model_id = $request->rd_id;
                $item->member_type_model_id = $request->member_type_id;
                $item->account_no = $request->account_no;
                $item->rd_no = $request->rd_no;
                $item->amount = $request->amount;
                $item->installment_date = $request->installment_date;
                $item->session_year = '2019-2020';
                $item->token = $request->_token;
                if (Auth::user()->staff_type == 'Agent') {
                  $item->shadow = 0;
                }

                $paid_install = $request->paid_install;
                $no_of_installment = $request->no_of_installment;
                $period_rd = $request->period_rd;
                $count_install = ($paid_install + $no_of_installment);
                if ($count_install > $period_rd) {
                    return response()->json(['sec_key'=>$request->all(),'error_msg'=>'Your Recurring Installment is over!']);
                    exit;
                }
                if($item->save())
                {
               $memebr_item =  member_type_model::where('id',$request->member_type_id)->first();
// SMS sending Code start
$mobile1 = $member_detail->contact_no;                
$message = "Dear Customer Rs.".$item->amount."/- installment amount deposited in your RD account no. (". $item->account_no .") on ". date('d-M-Y', strtotime($item->installment_date));
sendSms($mobile1, $message);
// Sms sending Code End                
// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name. ' RD';
                   $tbl_item->stype = $memebr_item->name.' RD';

                   $tbl_item->date_of_transaction = $request->installment_date;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'RD';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = $member_detail->full_name .' RD NO '. $request->rd_no;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->rd_model_id = $item->id;
                   $tbl_item->mode_of_transaction = "Cash";
                   $tbl_item->main_head = $memebr_item->name.' RD';
                   $tbl_item->form_name = 'RD';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                    $tbl_item->agent_id = $member_detail->agent_name;
                   $tbl_item->member_type_model_id = $request->member_type_id;
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
                
                   $cash_tbl_item->date_of_transaction = $request->installment_date;
                   $cash_tbl_item->account_no = $request->account_no;
                   $cash_tbl_item->account_head = 'RD';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->particular = $member_detail->full_name .' RD NO '. $request->rd_no;
                   $cash_tbl_item->rd_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = "Cash";
                   $cash_tbl_item->form_name = 'RD';
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

    public function editMaturedRd($id)
    {
        $data['item'] = rd_model::with('open_new_ac_model')->find($id);
        $data['received_amt'] = rd_installment_model::where('rd_model_id',$data['item']->id)->sum('amount');
        return view(TRANSACTION_RD_AC.'matured')->with($data);
    }

    public function updateMaturedRd(Request $request, $id)
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

            $item = rd_model::find($id);
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
                        tbl_ledger_model::whereIn('rd_mature_status',[$item->id])->delete();
                    }
                    else{


                $memebr_item =  member_type_model::where('id',$item->member_type_model_id)->first();

// ********************
        // Head entry single matuare                   
// ********************
// Member type
                if($request->mtr == 'sm')
                {
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' RD';
                   $tbl_item->stype = $memebr_item->name.' RD';

                   $tbl_item->rd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'RD';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $request->received_amount;
                   $tbl_item->particular = $member_detail->full_name .' RD No '. $request->rd_no;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->rd_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $memebr_item->name.' RD';
                   $tbl_item->form_name = 'RD';
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
               }
// ********************
        // Head entry double matuare                   
// ********************
// Member type
                if($request->mtr == 'dm')
                {
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' RD';
                   $tbl_item->stype = $memebr_item->name.' RD';

                   $tbl_item->rd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'RD';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->amount = ($request->maturity_amount - $request->received_amount);
                   $tbl_item->particular = $member_detail->full_name .' RD No '. $request->rd_no;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->rd_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $memebr_item->name.' RD';
                   $tbl_item->form_name = 'RD';
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

// =======
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' RD';
                   $tbl_item->stype = $memebr_item->name.' RD';

                   $tbl_item->rd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'RD';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                    $tbl_item->amount = $request->maturity_amount;
                   $tbl_item->particular = $member_detail->full_name .' RD No '. $request->rd_no;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->rd_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $memebr_item->name.' RD';
                   $tbl_item->form_name = 'RD';
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
               }
// ********************
        // Interest entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = 'INTEREST PAID';
                   $tbl_item->stype = 'INTEREST PAID ON '.$memebr_item->name.' RD';

                   $tbl_item->rd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'RD';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = ($request->maturity_amount - $request->received_amount);
                   $tbl_item->particular = $member_detail->full_name .' RD No '. $request->rd_no;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->rd_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = 'INTEREST PAID ON '.$memebr_item->name.' RD';
                   $tbl_item->form_name = 'RD';
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
                    $cash_tbl_item->rd_mature_status = $item->id;
                   $cash_tbl_item->date_of_transaction = $request->matured_on_date;
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->account_no = $item->account_no;
                   $cash_tbl_item->account_head = 'RD';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->amount = $request->maturity_amount;
                   $cash_tbl_item->particular = $member_detail->full_name .' RD No '. $request->rd_no;
                   $cash_tbl_item->rd_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->form_name = 'RD';
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
                   $return_url = url(TRANSACTION_URL_RD_AC);
                    return response()->json(['success'=>'<li><span>Success!</span> Reocrd Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }

    public function printRD(Request $request, $id = null)
    {
        $item = rd_installment_model::with('rd_model')->where('id',$id)->first();
        $data = [
            'item' => $item,
            'voucher' => tbl_ledger_model::where('rd_model_id',$item->id)->first(),
            'company_profile' => company_address_model::first(),

        ];             
        return view(TRANSACTION_RD_AC.'rd-installment-print')->with($data);
        
    }

    public function destroy($id)
    {
        $item = DB::table("rd_installment_models")->where('id',$id);
        if($item->delete())
        {
            tbl_ledger_model::whereIn('rd_model_id',[$id])->delete();
           return response()->json(['success'=>'done']);
        } 
        else
        {
           return response()->json(['error'=>'Failed']); 
        }
    }

    public function rdInstallmentCreate(Request $request)
    {
        $rdNo = $request->get('rdNo');
        $data = ['transactionList'=>[]];

        if ($rdNo)
        {
            $rdData = rd_model::whereRdNo($rdNo)->first();
//            dd($rdData);
            $openAccount = open_new_ac_model::whereAccountNo($rdData->account_no)->first();
            $fullAddress = getFullAddressById($openAccount->id);
            $rdInstallmentData = getRdInstallmentModelDataByRdModelId($rdData->id);
            $data = [
                'accountNo'=>$rdData->account_no,
                'amount'=>$rdData->amount,
                'memberType'=>$rdData->member_type_model->name,
                'branch'=>$openAccount->branch_model->name,
                'memberName'=>$openAccount->full_name,
                'fatherName'=>$openAccount->father_name,
                'address'=>$fullAddress,
                'rdAmount'=>$rdData->amount,
                'interestRate'=>$rdData->int_rate,
                'rdDate'=>$rdData->transaction_date,
                'periodOfRd'=>$rdData->period_rd,
                'maturityDate'=>$rdData->maturity_date,
                'maturedOnDate'=>$rdData->matured_on_date,
                'maturityAmount'=>$rdData->maturity_amount,
                'transactionList'=>$rdInstallmentData,
            ];
        }
        return view("Transaction.RD_Ac.rd-installment")->with($data);
    }
    public function rdInstallmentRecord(Request $request)
    {
        $rdNo = $request->get('rd_no');
        $rdData = rd_model::whereRdNo($rdNo)->first();
        if ($rdData)
        {
            $openAccount = open_new_ac_model::whereAccountNo($rdData->account_no)->first();
            $fullAddress = getFullAddressById($openAccount->id);
            $rdInstallmentData = getRdInstallmentModelDataByRdModelId($rdData->id);
            return response()->json([
                'accountNo'=>$rdData->account_no,
                'amount'=>$rdData->amount,
                'memberType'=>$rdData->member_type_model->name,
                'branch'=>$openAccount->branch_model->name,
                'memberName'=>$openAccount->full_name,
                'fatherName'=>$openAccount->father_name,
                'address'=>$fullAddress,
                'rdAmount'=>$rdData->amount,
                'interestRate'=>$rdData->int_rate,
                'rdDate'=>$rdData->transaction_date,
                'periodOfRd'=>$rdData->period_rd,
                'maturityDate'=>$rdData->maturity_date,
                'maturedOnDate'=>$rdData->matured_on_date,
                'maturityAmount'=>$rdData->maturity_amount,
                'maturity_status'=>$rdData->status,
                'transactionList'=>$rdInstallmentData,
                'status'=>200,
            ]);
        }
        else{
            return response()->json(['status'=>201]);
        }

    }

    public function rdInstallmentRecordSubmit(Request $request)
    {
//         return $request->all();
        $validator = Validator::make($request->all(), [
            'rd_no' => 'required',
            'amount' => 'bail|required|numeric',
            'date_of_transaction' => 'bail|required',
            'transaction_particular' => 'bail|required',
        ]);

        if ($validator->passes()) {
// Member detail
            $rdNo = $request->rd_no;
            $rdData = rd_model::whereRdNo($rdNo)->first();
            if ($rdData)
            {
                $member_detail = open_new_ac_model::whereAccountNo($rdData->account_no)->first();
                $item = new rd_installment_model();
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->rd_model_id = $rdData->id;
                $item->member_type_model_id = $rdData->member_type_model_id;
                $item->account_no = $rdData->account_no;
                $item->rd_no = $rdData->rd_no;
                $item->amount = $request->amount;
                $item->installment_date = $request->date_of_transaction;
                $item->session_year = '2019-2020';
                $item->token = $request->_token;
                if (Auth::user()->staff_type == 'Agent') {
                    $item->shadow = 0;
                }
//                $paid_install = $request->paid_install;
//                $no_of_installment = $request->no_of_installment;
//                $period_rd = $request->period_rd;
//                $count_install = ($paid_install + $no_of_installment);
//                if ($count_install > $period_rd) {
//                    return response()->json(['sec_key'=>$request->all(),'error_msg'=>'Your Recurring Installment is over!']);
//                    exit;
//                }
                if($item->save())
                {

// SMS sending Code start
                    $mobile1 = $member_detail->contact_no;
                    $message = "Dear Customer Rs.".$item->amount."/- installment amount deposited in your RD account no. (". $item->account_no .") on ". date('d-M-Y', strtotime($item->installment_date));
                    sendSms($mobile1, $message);
// Sms sending Code End
// ********************
                    // Head entry
// ********************
// Member type

                    $tbl_item = new tbl_ledger_model();

                    $tbl_item->gtype = $request->memberType. ' RD';
                    $tbl_item->stype = $request->memberType.' RD';

                    $tbl_item->date_of_transaction = $request->date_of_transaction;
                    $tbl_item->account_no = $rdData->account_no;
                    $tbl_item->account_head = 'RD';
                    $tbl_item->entry_type = 'Cash';
                    $tbl_item->type_of_transaction = 'Cr';
                    $tbl_item->amount = $request->amount;
                    $tbl_item->particular = $member_detail->full_name .' RD NO '. $rdNo;
                    $tbl_item->branch_model_id = $member_detail->branch_model_id;
                    $tbl_item->rd_model_id = $item->id;
                    $tbl_item->mode_of_transaction = "Cash";
                    $tbl_item->main_head = $request->memberType.' RD';
                    $tbl_item->form_name = 'RD';
                    $tbl_item->token = $request->_token;
                    $tbl_item->user_id = Auth::user()->id;
                    $tbl_item->agent_id = $member_detail->agent_name;
                    $tbl_item->member_type_model_id = null;
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

                    $cash_tbl_item->date_of_transaction = $request->date_of_transaction;
                    $cash_tbl_item->account_no = $rdData->account_no;
                    $cash_tbl_item->account_head = 'RD';
                    $cash_tbl_item->entry_type = 'Cash';
                    $cash_tbl_item->type_of_transaction = 'Dr';
                    $cash_tbl_item->amount = $request->amount;
                    $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                    $cash_tbl_item->particular = $member_detail->full_name .' RD NO '. $rdNo;
                    $cash_tbl_item->rd_model_id = $item->id;
                    $cash_tbl_item->mode_of_transaction = "Cash";
                    $cash_tbl_item->form_name = 'RD';
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

                    $return_url = route('transaction.rd.installment',['rdNo'=>$rdNo,'date_of_transaction'=>$request->date_of_transaction]);
                    return response()->json(['success'=>'<li><span>Thanks!</span> Installment Received Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
                }
            }

        }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
        //Auth::login($user);
    }
   
}
