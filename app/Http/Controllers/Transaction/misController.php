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
use App\mis_model;
use App\mis_installment_model;
use App\tbl_ledger_model;
use App\saving_ac_model;
use App\company_address_model;
use Auth;
use DB;
use Response;
use PDF;

class misController extends Controller
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
        $items_obj = mis_model::orderBy(DB::raw('LENGTH(account_no), account_no'))->orderBy('updated_at','desc');
        if(Auth::user()->staff_type == 'Agent')
        {
            $items_obj = $items_obj->where('agent_id',Auth()->user()->id);
        }
        $data['items'] = $items_obj->get();
        return view(TRANSACTION_MIS_AC.'list')->with($data);
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
            $data['priview'] = url('public/storage/member-photo/thumbnail/').'/'.$item->file;
        }
        else
        {
            $data['priview'] = url('assets/images/user.png');
        }
        if($item->signature != '')
        {
            $data['signature'] = url('public/storage/member-signature/thumbnail/').'/'.$item->signature;
        }
        else
        {
            $data['signature'] = url('assets/images/signature.png');
        }

        $data['view_ac_url'] = url('transaction/recurring-deposite/show').'/'.$request->member_id.'/'.$this->ac_no.'/'.$request->_token;

        $deposite_bal = mis_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('status',1)->sum('amount');

        $withdraw_bal = mis_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('status',0)->sum('amount');

        $data['balance'] = $deposite_bal - $withdraw_bal;
        $data['base_url'] = url('/');
        $items = mis_model::where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->get();
        
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
        $data['auto_id'] = mis_model::orderBy('mis_no','desc')->first();
        return view(TRANSACTION_MIS_AC."create")->with($data);
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
            'mis_no' => 'bail|required|numeric',
            'amount' => 'bail|required|numeric',
            'interest_rate' => 'bail|required|numeric',
            'mis_date' => 'bail|required',
            'period_of_mis' => 'bail|required|numeric',
            'maturity_date' => 'bail|required',
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
            'total_interest' => 'bail|required|numeric',
            'monthly_installment' => 'bail|required|numeric',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
                        
        ]);

        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
            $member_detail = open_new_ac_model::where('account_no',$request->account_no)->where('member_type_model_id',$request->member_type_model_id)->first();   

            $item = new mis_model();
            
                $item->user_id = Auth::user()->id;
                $item->agent_id = $member_detail->agent_name;
                $item->open_new_ac_model_id = $request->open_ac_id;
                $item->member_type_model_id = $request->member_type_model_id;
                $item->account_no = $this->ac_no;
                $item->mis_no = $request->mis_no;
                $item->amount = $request->amount;
                $item->int_rate = $request->interest_rate;
                $item->start_date = $request->mis_date;
                $item->period_of_mis = $request->period_of_mis;
                $item->maturity_date = $request->maturity_date;
                $item->matured_on_date = $request->matured_on_date;
                $item->maturity_amount = $request->maturity_amount;
                $item->total_interest = $request->total_interest;
                $item->monthly_installment = $request->monthly_installment;
                $item->nominee_name = $request->nominee_name;
                $item->nominee_relation = $request->nominee_relation;
                $item->session_year = '2019-2020';
                $item->token = $request->_token;
                if($item->save())
                {
               $memebr_item =  member_type_model::where('id',$request->member_type_model_id)->first();
               $mis_model = mis_model::where('id',$item->mis_model_id)->first();
// Loan Installment query               
            $mis_item = new mis_installment_model();
            $mis_model_id = $item->id;
            $open_new_ac_model_id = $member_detail->id;
            $user_id = Auth::user()->id;
            $agent_id = $member_detail->agent_name;
            $member_type_model_id = $request->member_type_model_id;
            $account_no = $this->ac_no;
            $installment_date = $request->loop_date;
            $monthly_installment = $request->loop_principal;
            $session_year = '2019-2020';
            if (Auth::user()->staff_type == 'Agent') {
                  $shadow = 0;
                }
                $shadow = 1;
            $token = $request->_token;
            $create = date('Y-m-d h:m:i');
            $update = date('Y-m-d h:m:i');
            $mis_items = array();
            if(count($installment_date) >= 1)
            {
                for($i = 0; $i < count($installment_date); $i++){
                    $arr[] = array(
                        'mis_model_id'=>$mis_model_id,
                        'open_new_ac_model_id'=>$open_new_ac_model_id,
                        'user_id'=>$user_id,
                        'agent_id'=>$agent_id,
                        'member_type_model_id'=>$member_type_model_id,
                        'account_no'=>$account_no,
                        'installment_date'=>$installment_date[$i],
                        'monthly_installment'=>$monthly_installment[$i],
                        'session_year'=>$session_year,
                        'shadow'=>$shadow,
                        'token'=>$token,
                        'created_at'=>$create,
                        'updated_at'=>$update,
                        );
                }
                $mis_items = $arr;
                $mis_item->insert($mis_items);
                
            }
// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $memebr_item->name.' MIS';
                   $tbl_item->stype = $memebr_item->name.' MIS';

                   $tbl_item->date_of_transaction = $request->mis_date;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'MIS';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = 'MIS of '.$member_detail->full_name;
                   $tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $tbl_item->mis_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $memebr_item->name.' MIS';
                   $tbl_item->form_name = 'MIS';
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
                                 
                   $cash_tbl_item->date_of_transaction = $request->mis_date;
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->account_no = $request->account_no;
                   $cash_tbl_item->account_head = 'MIS';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $member_detail->branch_model_id;
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->particular = 'MIS of '.$member_detail->full_name;
                   $cash_tbl_item->mis_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->form_name = 'MIS';
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
                
                   
                   $return_url = url(TRANSACTION_URL_MIS_AC);
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
    public function show($id)
    {
        $data['item'] = mis_model::find($id);
        $data['user_detail'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();
        $data['mis_installments'] = mis_installment_model::where('mis_model_id',$data['item']->id)->orderBy('installment_date','asc')->get();

        $data['membertypes'] = member_type_model::orderBy('name','asc')->get();
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter','Others'];
        $data['date'] = date('Y-m-d');
        return view(TRANSACTION_MIS_AC.'edit')->with($data);
    }

    public function printPDF($id)
    {
       // This  $data array will be passed to our PDF blade

        $data['item'] = mis_model::with('member_type_model')->find($id);

        $data['customer'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $data['balance'] = mis_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',1)->sum('amount');
        $data['company_profile'] = company_address_model::first();
        // dd($data['company_profile']);
        return view(TRANSACTION_MIS_AC.'pdf_view',compact(['data']));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
                // 
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $item_mis_model = mis_model::find($id);
        $item_mis_installment = mis_installment_model::where('mis_model_id',$id)->get();
        $item_tbl_ledger = tbl_ledger_model::where('mis_model_id',$id)->get();

        if($item_mis_installment->each->delete())
        {
            $item_tbl_ledger->each->delete();
            $item_mis_model->delete();
            return response()->json(['success'=>'done']);
        } 
        else
        {
           return response()->json(['error'=>'Failed']); 
        }
    }

    public function editMaturedMis($id)
    {
        $data['item'] = mis_model::with('open_new_ac_model','member_type_model')->find($id);        
        $data['mis_installments'] = mis_installment_model::where('mis_model_id',$data['item']->id)->orderBy('installment_date','asc')->get();

        return view(TRANSACTION_MIS_AC.'matured')->with($data);
    }

    public function updateMaturedMis(Request $request, $id)
    {
         // return $request->all();
        $validator = Validator::make($request->all(), [
            // 'matured_on_date' => 'bail|required',
        ]);

        if ($validator->passes()) {
            
            $item = mis_model::with('open_new_ac_model')->find($id);
// Member detail            
            
                $item->matured_on_date = $request->matured_on_date;
                $item->user_id = Auth::user()->id;
                $item->status = $request->fdStatus;
                
                if($item->save())
                {
                    if($request->fdStatus == 1)
                    {
                        tbl_ledger_model::whereIn('mis_mature_status',[$item->id])->delete();
                    }
                    else{
                
// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = $item->member_type_model->name.' MIS';
                   $tbl_item->stype = $item->member_type_model->name.' MIS';

                   $tbl_item->mis_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'MIS';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $item->amount;
                   $tbl_item->particular = 'MIS of '.$item->open_new_ac_model->full_name;
                   $tbl_item->branch_model_id = $item->open_new_ac_model->branch_model_id;
                   $tbl_item->mis_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = $item->member_type_model->name.' MIS';
                   $tbl_item->form_name = 'MIS';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->agent_id = $item->agent_id;
                   $tbl_item->member_type_model_id = $item->member_type_model_id;
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
                    $cash_tbl_item->mis_mature_status = $item->id;
                   $cash_tbl_item->date_of_transaction = $request->matured_on_date;
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->account_no = $item->account_no;
                   $cash_tbl_item->account_head = 'MIS';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $item->open_new_ac_model->branch_model_id;
                   $cash_tbl_item->amount = $request->maturity_amount;
                   $cash_tbl_item->particular = 'MIS of '.$item->open_new_ac_model->full_name;
                   $cash_tbl_item->mis_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->form_name = 'MIS';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->agent_id = $item->agent_id;
                   $cash_tbl_item->member_type_model_id = $item->member_type_model_id;
                   $cash_tbl_item->session_year = '2019-2020';
                   
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();                
                   }
                   $return_url = url(TRANSACTION_URL_MIS_AC);
                    return response()->json(['success'=>'<li>Reocrd Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }

    public function storeInterestToSavinAndTbl(Request $request)
    {

            $intallmentID = mis_installment_model::findOrFail($request->installment_id);

            $paidOn = $request->paid_date;
            $dividendAmt = $intallmentID->monthly_installment;
            $branch = $request->branch;
            $Membertype = $request->member_type;
// Saving table entry start
            $savingItem[] = [
                'open_new_ac_model_id' => $request->accound_id,
                'user_id' => Auth::user()->id,
                'agent_id' => Auth::user()->id,
                'member_type_model_id' => $Membertype,
                'account_no' => $request->account_no,
                'amount' => $dividendAmt,
                'date_of_transaction' => $paidOn,
                'mode_of_transaction' => 'Cash',
                'type_of_transaction' => 'Deposit',
                'particular' => 'Interest Paid On MIS',
                'session_year' => '2019-2020',
                'token' => $request->_token,
            ];         
       
        saving_ac_model::insert($savingItem);

// Ledger table entry 
        // ********************
        // Head entry                    
// ********************
// Member type
                    $MemberName = member_type_model::findOrFail($Membertype);
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = 'INTEREST PAID';
                   $tbl_item->stype = 'INTEREST PAID ON '.$MemberName->name.' MIS';
                   $tbl_item->account_no = $request->account_no;

                   $tbl_item->date_of_transaction = $paidOn;
                   $tbl_item->account_head = 'INTEREST PAID ON MIS';
                   $tbl_item->entry_type = 'TRANSFER';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $dividendAmt;
                   $tbl_item->particular = 'MIS INTEREST PAID TO '.$request->holder_name;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = 'INTEREST PAID ON '.$MemberName->name.' MIS';
                   $tbl_item->form_name = 'Saving';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->branch_model_id = $branch;
                   $tbl_item->member_type_model_id = $Membertype;
                    $tbl_item->agent_id = Auth::user()->id;
                   $tbl_item->member_type_model_id = 1;
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
                   $cash_tbl_item->gtype = $MemberName->name.' SAVING';
                   $cash_tbl_item->stype = $MemberName->name.' SAVING';
                   $cash_tbl_item->account_no = $request->account_no;

                   $cash_tbl_item->date_of_transaction = $paidOn;
                   $cash_tbl_item->account_head = 'SAVING';
                   $cash_tbl_item->entry_type = 'TRANSFER';
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->amount = $dividendAmt;
                   $cash_tbl_item->particular = $request->holder_name.' SAVING';
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->main_head = $MemberName->name.' SAVING';
                   $cash_tbl_item->form_name = 'Saving';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $tbl_item->branch_model_id = $branch;
                   $tbl_item->member_type_model_id = $Membertype;
                    $cash_tbl_item->agent_id = Auth::user()->id;
                   $cash_tbl_item->member_type_model_id = 1;
                   $cash_tbl_item->session_year = '2019-2020';
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save(); 
        mis_installment_model::where('id',$request->installment_id)->update(['status'=>1]);              
        $return_url = url(TRANSACTION_URL_MIS_AC);
        return back()->with('success','Interest Paid Successfully.');            
    }
   
}