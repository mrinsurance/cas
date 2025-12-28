<?php

namespace App\Http\Controllers\FinancialYear;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\session_master_model;
use App\year_end_tbl;
use Auth;
use DB;
use Response;

class yearEndController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $items = year_end_tbl::latest()->get();
        return view(FINANCIAL_YEAR_END_FOLDER.'list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'session_years' => session_master_model::orderBy('start_date','asc')->get(),
        ];
        return view(FINANCIAL_YEAR_END_FOLDER."create")->with($data);
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
            'financial_year' => 'required',   
        ]);

        if ($validator->passes()) {
            $item = new year_end_tbl();
            
                $item->user_id = Auth::user()->id;
                $item->session_master_model_id = $request->financial_year;
                $item->opening_stock_depot1 = $request->opening_stock_depot1;
                $item->opening_stock_depot2 = $request->opening_stock_depot2;
                $item->opening_stock_depot3 = $request->opening_stock_depot3;
                $item->closing_stock_depot1 = $request->closing_stock_depot1;
                $item->closing_stock_depot2 = $request->closing_stock_depot2;
                $item->closing_stock_depot3 = $request->closing_stock_depot3;
                $item->npa_amount = $request->npa_amount;
                $item->npa_int = $request->npa_int;
                $item->int_payble_fd = $request->int_payble_fd;
                $item->int_payble_rd = $request->int_payble_rd;
                $item->int_recover_loan = $request->int_recover_loan;
                $item->int_recover_bank_fd = $request->int_recover_bank_fd;
                $item->int_recover_bank_rd = $request->int_recover_bank_rd;
                $item->net_profit = $request->net_profit;
                $item->net_loss = $request->net_loss;
                $item->save();    
           
            $return_url = url(FINANCIAL_YEAR_END_URL);
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
        $item = year_end_tbl::find($id);
        $data = [
            'session_years' => session_master_model::orderBy('start_date','asc')->get(),
            'item' => $item,
        ];
        return view(FINANCIAL_YEAR_END_FOLDER.'edit')->with($data);
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
            'financial_year' => 'required',   
        ]);

        if ($validator->passes()) {
            $item = year_end_tbl::findOrFail($id);            
            $item->session_master_model_id = $request->financial_year;
            $item->opening_stock_depot1 = $request->opening_stock_depot1;
            $item->opening_stock_depot2 = $request->opening_stock_depot2;
            $item->opening_stock_depot3 = $request->opening_stock_depot3;
            $item->closing_stock_depot1 = $request->closing_stock_depot1;
            $item->closing_stock_depot2 = $request->closing_stock_depot2;
            $item->closing_stock_depot3 = $request->closing_stock_depot3;
            $item->npa_amount = $request->npa_amount;
            $item->npa_int = $request->npa_int;
            $item->int_payble_fd = $request->int_payble_fd;
            $item->int_payble_rd = $request->int_payble_rd;
            $item->int_recover_loan = $request->int_recover_loan;
            $item->int_recover_bank_fd = $request->int_recover_bank_fd;
            $item->int_recover_bank_rd = $request->int_recover_bank_rd;
            $item->net_profit = $request->net_profit;
            $item->net_loss = $request->net_loss;
            $item->save();  
    
            $return_url = url(FINANCIAL_YEAR_END_URL);
            return response()->json(['success'=>'<li><span>Success!</span> Record Successfully Updated..</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);      
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
        $item = year_end_tbl::find($id);
        if($item->delete())
        {
           return response()->json(['success'=>'done']);
        } 
        else
        {
           return response()->json(['error'=>'Failed']); 
        }
    }
}
