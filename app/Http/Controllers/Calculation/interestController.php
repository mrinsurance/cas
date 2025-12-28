<?php

namespace App\Http\Controllers\Calculation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\open_new_ac_model;
use App\session_master_model;
use App\interest_on_saving_tbl;
use App\company_address_model;
use App\saving_ac_model;
use App\tbl_ledger_model;
use App\branch_model;
use App\member_type_model;
use DB;
use Auth;
use PDF;

class interestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $session, $from, $to, $dividend_at, $minimum_share, $branch, $memberType;
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
        $this->dividend_at = $request->dividend_at;
        $this->minimum_share = $request->minimum_share;
        $this->memberType = $request->member_type;

        if($request->share_as_on == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->share_as_on;
        }
        if($request->paid_on == "")
        {
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->paid_on;
        }
        // return $this->from;        

        $open_new_ac_model = open_new_ac_model::with('saving_ac_model')->whereHas('saving_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
        ->where('status',1);
        if($this->session)
        {
            $open_new_ac_model = $open_new_ac_model->where('session_master_model_id',$this->session);
        }
        if($this->memberType)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$this->memberType);
        }
            
          $open_new_ac_model = $open_new_ac_model->paginate(100); 

        
        if($request->view == 1)      
        {
            $open_new_ac_model = $open_new_ac_model;
        }
        else
        {
            $open_new_ac_model = [];
        }
        
        $data = [
            'share_as_on'   => $this->from,
            'paid_on'       => $this->to,
            'dividend_at'   => $this->dividend_at,
            'minimum_share'   => $this->minimum_share,
            'member_type'   => $this->memberType,
            'ac_holders'    => $open_new_ac_model,
            'company_address' => company_address_model::first(),            
            'memberLists' => member_type_model::orderBy('name','asc')->get(),  
            'session_list' => session_master_model::orderBy('start_date','asc')->get(),
            'session_year' => $this->session,
                   
        ];
        // echo '<pre>'; print_r($data);die;
        return view(CALCULATION_PATH.'interest-on-saving')->with($data);
    }
    public function printInterestOnsaving(Request $request)
    {
        $this->dividend_at = $request->dividend_at;
        $this->minimum_share = $request->minimum_share;
        $this->memberType = $request->member_type;

        if($request->share_as_on == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->share_as_on;
        }
        if($request->paid_on == "")
        {
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->paid_on;
        }
        // return $this->from;        

        $open_new_ac_model = open_new_ac_model::with('saving_ac_model')->whereHas('saving_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
        ->where('status',1);
        if($this->memberType)
        {
            $open_new_ac_model = $open_new_ac_model->where('member_type_model_id',$this->memberType);
        }
            
          $open_new_ac_model = $open_new_ac_model->get(); 

        
        if($request->view == 1)      
        {
            $open_new_ac_model = $open_new_ac_model;
        }
        else
        {
            $open_new_ac_model = [];
        }
        
        $data = [
            'share_as_on'   => $this->from,
            'paid_on'       => $this->to,
            'dividend_at'   => $this->dividend_at,
            'minimum_share'   => $this->minimum_share,
            'member_type'   => $this->memberType,
            'ac_holders'    => $open_new_ac_model,
            'company_address' => company_address_model::first(),            
            'memberLists' => member_type_model::orderBy('name','asc')->get(),            
        ];
       // echo '<pre>'; print_r($data);die;
        return view(CALCULATION_PATH.'interest-on-saving')->with($data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dividend_at' => 'required',          
        ]);
        $session_year = (isset($request->session_year))?$request->session_year:session_master_model::first(); 
        //echo '<pre>'; print_r($request->all());die;
        if ($validator->passes()) {
            for ($i = 0; $i < count($request->account_id); $i++) {
            $records = array(
                'open_new_ac_model_id' => @$request->account_id[$i],
                'account_no' => @$request->account_no[$i],
                'holder_name' => @$request->full_name[$i],
                'branch_model_id' => @$request->branch[$i],
                'member_type_model_id' => @$request->member_type[$i],
                'share' => $request->balance[$i],
                'share_on' => @$request->share_on,
                'paid_on' => @$request->paid_on,
                'dividend_amt' => @$request->dividend_balance[$i],
                'dividend_at' => @$request->dividend_at,
                'session_master_model_id' => @$session_year,
                'created_at' => date('Y-m-d h:m:i'),
                'updated_at' => date('Y-m-d h:m:i'),
                's_no_id' =>@$request->s_no_id[$i]
            ); 
            $item = interest_on_saving_tbl::where('share_on','>=',$request->share_on)->where('member_type_model_id',$request->member_type[$i])->where('s_no_id',@$request->s_no_id[$i])->first();
           
            if($item)
            {
                return redirect()->back()->with('errors','Interest already calculated upto '.$item->share_on);
                return response()->json(['sec_key'=>$request->all(),'error_msg'=>'Interest already calculated upto '.$item->share_on]);
                        exit();
            }else{
                interest_on_saving_tbl::insert($records);
            }
        } 
        

         return redirect()->back()->with('success','The New Record Inserted Successfully.');
            $return_url = url(INTEREST_ON_SAVING_URL);
                return response()->json(['success'=>'<li><span>Success!</span> The New Record Inserted Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
    }

        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
         //Auth::login($user);
    }

    public function dividendList(Request $request){
        $this->session = $request->session_year;
        $this->from = $request->share_on;
        $this->to = $request->paid_on;
        $this->branch = $request->branch;
        $this->memberType = $request->member_type;

        if($request->share_on == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->share_on;
        }
        if($request->paid_on == "")
        {
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->paid_on;
        }
          
            $items = interest_on_saving_tbl::select()
                ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
                if($this->session)
                {
                   $items = $items->where('session_master_model_id',$this->session);
                }
                if($this->from)
                {
                   $items = $items->where('share_on',$this->from);
                }
                if($this->to)
                {
                   $items = $items->where('paid_on',$this->to);
                }
                if($this->branch)
                {
                   $items = $items->where('branch_model_id',$this->branch);
                }
                if($this->memberType)
                {
                   $items = $items->where('member_type_model_id',$this->memberType);
                }
                    $items = $items->paginate(100);    
                    $sum = interest_on_saving_tbl::select('dividend_amt');
                    if($this->session)
                    {
                       $sum = $sum->where('session_master_model_id',$this->session);
                    }
                    if($this->from)
                    {
                       $sum = $sum->where('share_on',$this->from);
                    }
                    if($this->to)
                    {
                       $sum = $sum->where('paid_on',$this->to);
                    }
                    if($this->branch)
                    {
                       $sum = $sum->where('branch_model_id',$this->branch);
                    }
                    if($this->memberType)
                    {
                       $sum = $sum->where('member_type_model_id',$this->memberType);
                    }
                   $sum = $sum->sum('dividend_amt'); 
            if ($request->view == 1) {
               $items = $items;
            }                  
            else{
                $items = [];
            }  
            
            $data = [
                'items' => $items,
                'session_list' => session_master_model::orderBy('start_date','asc')->get(),
                'brancheLists' => branch_model::orderBy('name','asc')->get(),
                'memberLists' => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),    
                'session_year' => $this->session,
                'share_on' => $this->from,
                'paid_on' => $this->to,
                'branch' => $this->branch,
                'member_type' => $this->memberType,
                'divident_total'=>$sum
            ];
              
        return view(CALCULATION_PATH.'interest-on-saving-list')->with($data);
    }
    public function printdividendList(Request $request){
        $this->session = $request->session_year;
        $this->from = $request->share_on;
        $this->to = $request->paid_on;
        $this->branch = $request->branch;
        $this->memberType = $request->member_type;

        if($request->share_on == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->share_on;
        }
        if($request->paid_on == "")
        {
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->paid_on;
        }
          
            $items = interest_on_saving_tbl::select()
                ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
                if($this->session)
                {
                   $items = $items->where('session_master_model_id',$this->session);
                }
                if($this->from)
                {
                   $items = $items->where('share_on',$this->from);
                }
                if($this->to)
                {
                   $items = $items->where('paid_on',$this->to);
                }
                if($this->branch)
                {
                   $items = $items->where('branch_model_id',$this->branch);
                }
                if($this->memberType)
                {
                   $items = $items->where('member_type_model_id',$this->memberType);
                }
                    $items = $items->paginate(100);   
                    
            if ($request->view == 1) {
               $items = $items;
            }                  
            else{
                $items = [];
            }  
            
            $data = [
                'items' => $items,
                'session_list' => session_master_model::orderBy('start_date','asc')->get(),
                'brancheLists' => branch_model::orderBy('name','asc')->get(),
                'memberLists' => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),    
                'session_year' => $this->session,
                'share_on' => $this->from,
                'paid_on' => $this->to,
                'branch' => $this->branch,
                'member_type' => $this->memberType,
                
            ];
              
        return view(CALCULATION_PATH.'interest-on-saving-list')->with($data);
    }
    public function generatePDF(Request $request)
    {
        
        $this->session = $request->session_year;
        $this->from = $request->share_on;
        $this->to = $request->paid_on;
        $this->branch = $request->branch;
        $this->memberType = $request->member_type;

        if($request->share_on == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->share_on;
        }
        if($request->paid_on == "")
        {
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->to = $request->paid_on;
        }
          
            $items = interest_on_saving_tbl::select()
                ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
                if($this->session)
                {
                   $items = $items->where('session_master_model_id',$this->session);
                }
                if($this->from)
                {
                   $items = $items->where('share_on',$this->from);
                }
                if($this->to)
                {
                   $items = $items->where('paid_on',$this->to);
                }
                if($this->branch)
                {
                   $items = $items->where('branch_model_id',$this->branch);
                }
                if($this->memberType)
                {
                   $items = $items->where('member_type_model_id',$this->memberType);
                }
                    $items = $items->get();     
            if ($request->view == 1) {
               $items = $items;
            }                  
            else{
                $items = [];
            }  
            
            $data = [
                'items' => $items,
                'session_list' => session_master_model::orderBy('start_date','asc')->get(),
                'brancheLists' => branch_model::orderBy('name','asc')->get(),
                'memberLists' => member_type_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),    
                'session_year' => $this->session,
                'share_on' => $this->from,
                'paid_on' => $this->to,
                'branch' => $this->branch,
                'member_type' => $this->memberType,
            ];
        $pdf = PDF::loadView('Calculation.myPDF', $data);
  
        return $pdf->download('interest-on-saving-list.pdf');
    }

    public function storeDividendToSavinAndTbl(Request $request)
    {
        $cb = $request->input('cb');
        if(empty($cb)){
            return redirect()->back()->with('errors','Please select atleats one');
        }
        $cb = $cb == '' ? [] : $cb;
        $now = date('Y-m-d H:i:s');
        $savingItem = [];
        $paidOn = [];
        $sessionYear = [];
        $dividendAmt = 0;
        interest_on_saving_tbl::whereIn('id', $cb)->update(['status'=>1]);
       
        $dividendItems = interest_on_saving_tbl::whereIn('id', $cb)->get();
        foreach($dividendItems as $dividendItem)
        {
            $dividendAmt += $dividendItem->dividend_amt;
            $paidOn = $dividendItem->paid_on;
            $sessionYear = $dividendItem->session_master_model_id;
            $branch = $dividendItem->branch_model_id;
            $Membertype = $dividendItem->member_type_model_id;
// Saving table entry start
            $savingItem[] = [
                'open_new_ac_model_id' => $dividendItem->open_new_ac_model_id,
                'user_id' => Auth::user()->id,
                'agent_id' => Auth::user()->id,
                'member_type_model_id' => $Membertype,
                'account_no' => $dividendItem->account_no,
                'amount' => $dividendItem->dividend_amt,
                'date_of_transaction' => $dividendItem->paid_on,
                'mode_of_transaction' => 'Cash',
                'type_of_transaction' => 'Deposit',
                'particular' => 'Interest Paid Upto'.$dividendItem->share_on,
                'session_year' => $dividendItem->session_master_model_id,
                'token' => $request->_token,
                'created_at' => $now,
                'updated_at' => $now,
            ]; 
        }
       
        saving_ac_model::insert($savingItem);

// Ledger table entry 
        // ******************** 
        // Head entry                    
// ********************
// Member type
                    $MemberName = member_type_model::findOrFail($Membertype);
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = 'INTEREST PAID';
                   $tbl_item->stype = 'INTEREST PAID ON '.$MemberName->name;

                   $tbl_item->date_of_transaction = $paidOn;
                   $tbl_item->account_head = 'INTEREST PAID';
                   $tbl_item->entry_type = 'TRANSFER';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $dividendAmt;
                   $tbl_item->particular = 'INTEREST PAID ON '.$MemberName->name;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = 'INTEREST PAID ON '.$MemberName->name;
                   $tbl_item->form_name = 'Saving';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->branch_model_id = $branch;
                   $tbl_item->member_type_model_id = $Membertype;
                    $tbl_item->agent_id = Auth::user()->id;
                   $tbl_item->session_year = $sessionYear;                   
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

                   $cash_tbl_item->date_of_transaction = $paidOn;
                   $cash_tbl_item->account_head = 'SAVING';
                   $cash_tbl_item->entry_type = 'TRANSFER';
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->amount = $dividendAmt;
                   $cash_tbl_item->particular = $MemberName->name.' SAVING';
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->main_head = $MemberName->name.' SAVING';
                   $cash_tbl_item->form_name = 'Saving';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $tbl_item->branch_model_id = $branch;
                   $tbl_item->member_type_model_id = $Membertype;
                    $cash_tbl_item->agent_id = Auth::user()->id;
                   $cash_tbl_item->session_year = $sessionYear;
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save(); 
        $return_url = url(INTEREST_ON_SAVING_LIST_URL);
        return redirect()->back()->with('success','Successfully Updated');
        return response()->json(['success'=>'<li>Successfully Updated</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);            
    }

    public function edit($id)
    {
        $item = interest_on_saving_tbl::findOrFail($id);
        $data = [
            'item' => $item,
        ];
        return view(CALCULATION_PATH.'edit-interest-on-saving')->with($data);
    }
    public function getedit(){
        $item = interest_on_saving_tbl::findOrFail($_REQUEST['edit_id']);
        $data = [
            'item' => $item,
        ];
        return $data;
    }
    public function update(Request $request, $id)
    {  
        $item = interest_on_saving_tbl::findOrFail($id);
        $item->dividend_amt = $request->dividend_amount;
        $item->save();
        $return_url = url(INTEREST_ON_SAVING_LIST_URL);
        return response()->json(['success'=>'<li>Successfully Updated</li>','return_url'=>$return_url,'sec_key'=>$request->all(),'dividend_amt'=>$item->dividend_amt]); 
               
    }
}
