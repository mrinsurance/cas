<?php

namespace App\Http\Controllers\Calculation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\open_new_ac_model;
use App\session_master_model;
use App\dividend_tbl;
use App\company_address_model;
use App\saving_ac_model;
use App\tbl_ledger_model;
use App\branch_model;
use App\member_type_model;
use DB;
use Auth;

class dividendController extends Controller
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
        $this->maximum_share = $request->maximum_share;
        $this->session_year = $request->session_year;
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

        $open_new_ac_model = open_new_ac_model::with('share_ac_model')->whereHas('share_ac_model', function($q){
            $q->groupBy('open_new_ac_model_id');
        })->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->where('status',1)
            ->where('member_type_model_id',1)
            ->where('ac_opening_date','<=',$this->from)
            ->paginate(100); 
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
            'ac_holders'    => $open_new_ac_model,
            'company_address' => company_address_model::first(),  
            'session_list' => session_master_model::orderBy('start_date','asc')->get(),
            'session_year' => $this->session,    
            'maximum_share' => @$request->maximum_share,        
        ];
        return view(CALCULATION_PATH.'dividend-calculation')->with($data);
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
          
            $items = dividend_tbl::select()
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
                $items =  $items->paginate(100);    
                   $sum = dividend_tbl::select('dividend_amt');
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
              
        return view(CALCULATION_PATH.'dividend-list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $validator = Validator::make($request->all(), [
            'dividend_at' => 'required',          
        ]);
        $session_year = session_master_model::first();

        if ($validator->passes()) {
            for ($i = 0; $i < count($request->account_no); $i++) {
            $records = [
                'open_new_ac_model_id' => $request->account_id[$i],
                'account_no' => $request->account_no[$i],
                'holder_name' => $request->full_name[$i],
                'branch_model_id' => $request->branch[$i],
                'member_type_model_id' => $request->member_type[$i],
                'share' => $request->balance[$i],
                'share_on' => $request->share_on,
                'paid_on' => $request->paid_on,
                'dividend_amt' => $request->dividend_balance[$i],
                'dividend_at' => $request->dividend_at,
                'session_master_model_id' => ($request->session_year)?$request->session_year:$session_year->id,
                'created_at' => date('Y-m-d h:m:i'),
                'updated_at' => date('Y-m-d h:m:i'),
                's_no_id' =>@$request->s_no_id[$i],
            ];
        
        $item = dividend_tbl::where('share_on','>=',$request->share_on)->where('s_no_id',@$request->s_no_id[$i])->first();
       
        if($item)
        {    return redirect()->back()->with('errors','Dividend already calculated upto '.$item->share_on);
            return response()->json(['sec_key'=>$request->all(),'error_msg'=>'Dividend already calculated upto '.$item->share_on]);
                    exit();
        }
        else
        {
            dividend_tbl::insert($records);

        }
        }
        return redirect()->back()->with('success','The New Record Inserted Successfully.');
            $return_url = url(DIVIDEND_CALCULATION_URL);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = dividend_tbl::findOrFail($id);
        $data = [
            'item' => $item,
        ];
        return view(CALCULATION_PATH.'edit-dividend')->with($data);
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
        $item = dividend_tbl::findOrFail($id);
        $item->dividend_amt = $request->dividend_amount;
        $item->save();
        $return_url = url(DIVIDEND_LIST_URL);
        return response()->json(['success'=>'<li>Successfully Updated</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
               
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
        dividend_tbl::whereIn('id', $cb)->update(['status'=>1]);
       
        $dividendItems = dividend_tbl::whereIn('id', $cb)->get();
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
                'member_type_model_id' => 1,
                'account_no' => $dividendItem->account_no,
                'amount' => $dividendItem->dividend_amt,
                'date_of_transaction' => $dividendItem->paid_on,
                'mode_of_transaction' => 'Cash',
                'type_of_transaction' => 'Deposit',
                'particular' => 'Dividend Paid Upto'.$dividendItem->share_on,
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
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = 'LAST YEAR PROFIT';
                   $tbl_item->stype = 'LAST YEAR PROFIT';

                   $tbl_item->date_of_transaction = $paidOn;
                   $tbl_item->account_head = 'LAST YEAR PROFIT';
                   $tbl_item->entry_type = 'TRANSFER';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $dividendAmt;
                   $tbl_item->particular = 'DIVIDEND PAID TO MEMBER';
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = 'LAST YEAR PROFIT';
                   $tbl_item->form_name = 'Saving';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->branch_model_id = $branch;
                   $tbl_item->member_type_model_id = $Membertype;
                    $tbl_item->agent_id = Auth::user()->id;
                   $tbl_item->member_type_model_id = 1;
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
                   $cash_tbl_item->gtype = 'MEMBER SAVING';
                   $cash_tbl_item->stype = 'MEMBER SAVING';

                   $cash_tbl_item->date_of_transaction = $paidOn;
                   $cash_tbl_item->account_head = 'MEMBER SAVING';
                   $cash_tbl_item->entry_type = 'TRANSFER';
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->amount = $dividendAmt;
                   $cash_tbl_item->particular = 'MEMBER SAVING';
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->main_head = 'MEMBER SAVING';
                   $cash_tbl_item->form_name = 'Saving';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $tbl_item->branch_model_id = $branch;
                   $tbl_item->member_type_model_id = $Membertype;
                    $cash_tbl_item->agent_id = Auth::user()->id;
                   $cash_tbl_item->member_type_model_id = 1;
                   $cash_tbl_item->session_year = $sessionYear;
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save(); 
        $return_url = url(DIVIDEND_LIST_URL);
        return redirect()->back()->with('success','Successfully Updated');
        return response()->json(['success'=>'<li>Successfully Updated</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
