<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\open_new_ac_model;
use App\state_model;
use App\district_model;
use App\branch_model;
use App\bank_model;
use App\bank_fd_ac_model;
use App\tbl_ledger_model;
use Auth;
use DB;
use Response;
use PDF;

class bankFdController extends Controller
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
        
        $data['items'] = bank_fd_ac_model::with('bank_model')->orderBy(DB::raw('LENGTH(account_no), account_no'))->orderBy('updated_at','desc')->get();
        return view(TRANSACTION_BANK_FD_AC.'list')->with($data);
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

        $data['view_ac_url'] = url('transaction/fixed-deposite/show').'/'.$request->member_id.'/'.$this->ac_no.'/'.$request->_token;

        $deposite_bal = bank_fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('status',1)->sum('amount');

        $withdraw_bal = bank_fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->where('status',0)->sum('amount');

        $data['balance'] = $deposite_bal - $withdraw_bal;
        $data['base_url'] = url('/');
        
        $items = bank_fd_ac_model::where('member_type_model_id',$request->member_id)->where('account_no',$this->ac_no)->get();

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
        $data['banks'] = bank_model::orderBy('name','asc')->get();
        $data['type_of_interest'] = ["Quarterly Interest"];
        $data['type_of_deposite'] = ["Fixed Deposit","Long Term Deposit","Short Term Deposit"];
        $data['auto_id'] = bank_fd_ac_model::orderBy('fd_no','desc')->first();
        $data['branches'] = branch_model::orderBy('name','asc')->get();
        return view(TRANSACTION_BANK_FD_AC."create")->with($data);
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
            'branch' => 'required',
            'bank' => 'required',
            'account_no' => 'bail|required',
            'fd_no' => 'bail|required|numeric',
            'amount' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'interest_rate' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'interest_run_from' => 'bail|required',
            'transaction_date' => 'bail|required',
            'period_of_fd' => 'bail|required|numeric',
            'maturity_date' => 'bail|required',
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'mode_of_transaction' => 'required',
            'cheque_date' => 'bail|sometimes',
            'cheque_number' => 'bail|sometimes',
            'type_of_deposit' => 'bail|required',                        
        ]);

        if ($validator->passes()) {
            $this->ac_no = $request->account_no;
            
            $item = new bank_fd_ac_model();
            
                $item->user_id = Auth::user()->id;
                $item->branch_model_id = $request->branch;
                $item->bank_model_id = $request->bank;
                $item->account_no = $this->ac_no;
                $item->fd_no = $request->fd_no;
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
                $item->session_year = '2019-2020';
                $item->token = $request->_token;
                
                if($item->save())
                {
                $bank_detail =  bank_model::where('id',$request->bank)->first();

// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();                   
                   $tbl_item->gtype = 'BANK FIXED DEPOSIT';
                   $tbl_item->stype = 'FIXED DEPOSIT WITH '.$bank_detail->name;

                   $tbl_item->date_of_transaction = $request->transaction_date;
                   $tbl_item->account_no = $request->account_no;
                   $tbl_item->account_head = 'BANK FIXED DEPOSIT';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = $bank_detail->name .' FD No '. $request->fd_no;
                   $tbl_item->branch_model_id = $request->branch;
                   $tbl_item->bank_fd_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->main_head = 'FIXED DEPOSIT WITH '.$bank_detail->name;
                   $tbl_item->form_name = 'BANK FIXED DEPOSIT';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->bank_model_id = $request->bank;
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
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->account_no = $request->account_no;
                   $cash_tbl_item->account_head = 'BANK FIXED DEPOSIT';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $request->branch;
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->particular = $bank_detail->name .' FD No '. $request->fd_no;
                   $cash_tbl_item->bank_fd_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->form_name = 'BANK FIXED DEPOSIT';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->bank_model_id = $request->bank;
                   $cash_tbl_item->session_year = '2019-2020';
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();
                
                   
                   $return_url = url(TRANSACTION_URL_BANK_FD_AC);
                    return response()->json(['success'=>'<li>Bank Fixed Deposit Successfully Created</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
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
        $items = bank_fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$member_id)->where('account_no',$account_id)->get();
        // dd($items);
        return view(TRANSACTION_BANK_FD_AC.'list',compact(['items']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['item'] = bank_fd_ac_model::find($id);
        $data['banks'] = bank_model::orderBy('name','asc')->get();
        $data['branches'] = branch_model::orderBy('name','asc')->get();
        $data['type_of_interest'] = ["Quarterly Interest"];
        $data['type_of_deposite'] = ["Fixed Deposit","Long Term Deposit","Short Term Deposit"];
        return view(TRANSACTION_BANK_FD_AC.'edit')->with($data);
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
            'amount' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'interest_rate' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
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
            'account_no' => 'bail|required',
            'fd_no' => 'bail|required',
        ]);

        if ($validator->passes()) {
            
            $item = bank_fd_ac_model::find($id);

                $item->amount = $request->amount;
                $item->bank_model_id = $request->bank;
                $item->fd_no = $request->fd_no;
                $item->int_rate = $request->interest_rate;
                $item->int_run_from = $request->interest_run_from;
                $item->transaction_date = $request->transaction_date;
                $item->period_fd = $request->period_of_fd;
                $item->maturity_date = $request->maturity_date;
                $item->matured_on_date = $request->matured_on_date;
                $item->interest_type = $request->type_of_interest;
                $item->maturity_amount = $request->maturity_amount;
                $item->account_no = $request->account_no;

                $item->mode_transaction = $request->mode_of_transaction;
                $item->cheque_date = $request->cheque_date;
                $item->cheque_no = $request->cheque_number;
                $item->type_of_deposite = $request->type_of_deposit;
                $item->session_year = '2019-2020';
                $item->user_id = Auth::user()->id;
                $item->token = $request->_token;
                
                if($item->save())
                {
               $bank_detail =  bank_model::where('id',$item->bank_model_id)->first();
// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = tbl_ledger_model::where('bank_fd_ac_model_id',$id)->where('account_head','BANK FIXED DEPOSIT')->where('entry_type','Cash')->first();
                   
                   $tbl_item->gtype = 'BANK FIXED DEPOSIT';
                   $tbl_item->stype = 'FIXED DEPOSIT WITH '.$bank_detail->name;

                   $tbl_item->date_of_transaction = $request->transaction_date;
                   
                   $tbl_item->account_head = 'BANK FIXED DEPOSIT';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->bank_fd_ac_model_id = $item->id;
                    $tbl_item->particular = $bank_detail->name .' FD No '. $request->fd_no;
                   $tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $tbl_item->main_head = 'FIXED DEPOSIT WITH '.$bank_detail->name;
                   $tbl_item->form_name = 'BANK FIXED DEPOSIT';
                   $tbl_item->token = $request->_token;
                   $tbl_item->bank_model_id = $request->bank;
                   $tbl_item->session_year = '2019-2020';
                   $tbl_item->user_id = Auth::user()->id;
                   
                   $tbl_item->save();

                   $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);

                   $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                   $update_tbl_ledger_model->voucher_no = $voucher;
                   $update_tbl_ledger_model->save();
// ********************
        // Cash entry                    
// ********************
// Member type
                

                $cash_tbl_item = tbl_ledger_model::where('bank_fd_ac_model_id',$id)->where('account_head','BANK FIXED DEPOSIT')->where('entry_type','Cash')->where('stype','Cash')->first();
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
                    $tbl_item->particular = $bank_detail->name .' FD No '. $request->fd_no;
                   $cash_tbl_item->account_head = 'BANK FIXED DEPOSIT';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->bank_fd_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = $request->mode_of_transaction;
                   $cash_tbl_item->form_name = 'BANK FIXED DEPOSIT';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->branch_model_id = $request->branch;
                   $cash_tbl_item->session_year = '2019-2020';
                   $cash_tbl_item->user_id = Auth::user()->id;
                   
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();
                
                   
                   $return_url = url(TRANSACTION_URL_BANK_FD_AC);
                    return response()->json(['success'=>'<li>Record Successfully Updated</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
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

        $data['item'] = bank_fd_ac_model::with('member_type_model')->find($id);

        $data['customer'] = open_new_ac_model::with('state_model','district_model','branch_model')->where('account_no',$data['item']->account_no)->where('member_type_model_id',$data['item']->member_type_model_id)->first();

        $deposite_bal = bank_fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',1)->sum('amount');

        $withdraw_bal = bank_fd_ac_model::orderBy('updated_at','asc')->where('member_type_model_id',$data['item']->member_type_model_id)->where('account_no',$data['item']->account_no)->where('status',0)->sum('amount');

        $data['balance'] = $deposite_bal - $withdraw_bal;
        return view(TRANSACTION_BANK_FD_AC.'pdf_view',compact(['data']));
        // $pdf = PDF::loadView(TRANSACTION_BANK_FD_AC.'pdf_view', $data);  
        // return $pdf->download('medium.pdf');
            // PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // // pass view file
            // $pdf = PDF::loadView(TRANSACTION_BANK_FD_AC.'pdf_view',compact(['data']));
            // // download pdf
            // $pdf->setPaper('A4', 'portrait');
            // return $pdf->download('medium.pdf',compact(['data']));
    }

    public static function convert_number_to_words($number) {

        $hyphen      = ' ';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . Self::convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Self::convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Self::convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Self::convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return ucwords($string);
    }

    public function editMatureBankFd($id)
    {
        $data['item'] = bank_fd_ac_model::with('bank_model','branch_model')->find($id);
        return view(TRANSACTION_BANK_FD_AC.'matured')->with($data);
    }

    public function updateMatureBankFd(Request $request, $id)
    {
      // return $request->all();
        $validator = Validator::make($request->all(), [
            'matured_on_date' => 'bail|required',
            'maturity_amount' => 'bail|required|numeric',
        ]);

        if ($validator->passes()) {
            
            $item = bank_fd_ac_model::find($id);
// Member detail            
            $member_detail = open_new_ac_model::where('account_no',$item->account_no)->where('member_type_model_id',$item->member_type_model_id)->first();            
                $item->matured_on_date = $request->matured_on_date;
                $item->maturity_amount = $request->maturity_amount;
                $item->user_id = Auth::user()->id;
                $item->status = $request->fdStatus;
                
                if($item->save())
                {
                    if($request->fdStatus == 1)
                    {
                        tbl_ledger_model::whereIn('bank_fd_mature_status',[$item->id])->delete();
                    }
                    else{

// ********************
        // Head entry                    
// ********************
// Member type
                
                   $tbl_item = new tbl_ledger_model();
                   
                   $tbl_item->gtype = 'BANK FIXED DEPOSIT';
                   $tbl_item->stype = 'FIXED DEPOSIT WITH '.$item->bank_model->name;

                   $tbl_item->bank_fd_mature_status = $item->id;
                   $tbl_item->date_of_transaction = $request->matured_on_date;
                   $tbl_item->account_no = $item->account_no;
                   $tbl_item->account_head = 'BANK FIXED DEPOSIT';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->type_of_transaction = 'Cr';
                   $tbl_item->amount = $request->amount;
                   $tbl_item->particular = $item->bank_model->name .' FD No '. $item->fd_no;
                   $tbl_item->branch_model_id = $item->branch_model_id;
                   $tbl_item->bank_fd_ac_model_id = $item->id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = 'FIXED DEPOSIT WITH '.$item->bank_model->name;
                   $tbl_item->form_name = 'BANK FIXED DEPOSIT';
                   $tbl_item->token = $request->_token;
                   $tbl_item->bank_model_id = $item->bank_model_id;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->session_year = '2019-2020';
                   $tbl_item->save();

                   $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);

                   $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                   $update_tbl_ledger_model->voucher_no = $voucher;
                   $update_tbl_ledger_model->save();
// ********************
        // Interest entry                    
// ********************
// Member type
                
                   $int_tbl_item = new tbl_ledger_model();
                   
                   $int_tbl_item->gtype = 'INTEREST RECEIVED';
                   $int_tbl_item->stype = 'INTEREST RECEIVED ON BANK FD';

                   $int_tbl_item->bank_fd_mature_status = $item->id;
                   $int_tbl_item->date_of_transaction = $request->matured_on_date;
                   $int_tbl_item->account_no = $item->account_no;
                   $int_tbl_item->account_head = 'BANK FIXED DEPOSIT';
                   $int_tbl_item->entry_type = 'Cash';
                   $int_tbl_item->type_of_transaction = 'Cr';
                   $int_tbl_item->amount = ($request->maturity_amount - $request->amount);
                   $int_tbl_item->particular = 'INTEREST RECEIVED FROM '.$item->bank_model->name;
                   $int_tbl_item->branch_model_id = $item->branch_model_id;
                   $int_tbl_item->bank_fd_ac_model_id = $item->id;
                   $int_tbl_item->mode_of_transaction = 'Cash';
                   $int_tbl_item->main_head = 'INTEREST RECEIVED ON BANK FD';
                   $int_tbl_item->form_name = 'BANK FIXED DEPOSIT';
                   $int_tbl_item->token = $request->_token;
                   $int_tbl_item->user_id = Auth::user()->id;
                   $int_tbl_item->bank_model_id = $item->bank_model_id;
                   $int_tbl_item->session_year = '2019-2020';
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
                    $cash_tbl_item->bank_fd_mature_status = $item->id;
                   $cash_tbl_item->date_of_transaction = $request->matured_on_date;
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->account_no = $item->account_no;
                   $cash_tbl_item->account_head = 'BANK FIXED DEPOSIT';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $item->branch_model_id;
                   $cash_tbl_item->amount = $request->maturity_amount;
                   $cash_tbl_item->particular = 'INTEREST RECEIVED FROM '.$item->bank_model->name;
                   $cash_tbl_item->bank_fd_ac_model_id = $item->id;
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   $cash_tbl_item->form_name = 'BANK FIXED DEPOSIT';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->bank_model_id = $item->bank_model_id;
                   $cash_tbl_item->session_year = '2019-2020';
                   $cash_tbl_item->voucher_no = $voucher;
                   $cash_tbl_item->save();                
                   }
                   $return_url = url(TRANSACTION_URL_BANK_FD_AC);
                    return response()->json(['success'=>'<li>Reocrd Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]); 
                }
            
    }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }
   
}
