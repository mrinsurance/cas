<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\loan_model;
use Auth;
use DB;
use Response;
use PDF;

class loanController extends Controller
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
        $items = loan_model::orderBy('name','asc')->get();
        return view(MASTER_LOAN_MASTER.'list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['loan_interest'] = ['Reducing','Flat'];
        return view(MASTER_LOAN_MASTER."create")->with($data);
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
            'name' => 'required',
            'interest' => 'bail|required|numeric',
            'penalty_interest' => 'bail|required|numeric',
            'additional_interest' => 'bail|nullable|numeric',
            'month' => 'bail|required|numeric',
            'term_of_loan' => 'bail|required',
            'loan_of_interest' => 'bail|required',

        ]);

        if ($validator->passes()) {
            $item = new loan_model();

                $item->name = $request->name;
                $item->int_at = $request->interest;
                $item->panelty_in_at = $request->penalty_interest;
                $item->additional_interest = $request->additional_interest;
                $item->loan_month = $request->month;
                $item->term_of_loan = $request->term_of_loan;
                $item->loan_intr_type = $request->loan_of_interest;
                $item->token = $request->_token;
                $item->save();

            $return_url = url(MASTER_URL_LOAN);
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
        $data['item'] = loan_model::find($id);
        // dd($roles);
        $data['loan_interest'] = ['Reducing','Flat'];
        return view(MASTER_LOAN_MASTER.'edit')->with($data);
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
            'name' => 'required',
            'interest' => 'bail|required|numeric',
            'penalty_interest' => 'bail|required|numeric',
            'additional_interest' => 'bail|nullable|numeric',
            'month' => 'bail|required|numeric',
            'term_of_loan' => 'bail|required',
            'loan_of_interest' => 'bail|required',

        ]);

        if ($validator->passes()) {

            $item = loan_model::find($id);
            $item->name = $request->name;
                $item->int_at = $request->interest;
                $item->panelty_in_at = $request->penalty_interest;
                $item->additional_interest = $request->additional_interest;
                $item->loan_month = $request->month;
                $item->loan_intr_type = $request->loan_of_interest;
                $item->term_of_loan = $request->term_of_loan;
                $item->token = $request->_token;

            if($item->save())
            {
               $return_url = url(MASTER_URL_LOAN);
                return response()->json(['success'=>'<li><span>Success!</span> Record Successfully Updated..</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
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
    /*public function destroy($id)
    {
        $item = loan_model::find($id);
        if($item->delete())
        {
           return response()->json(['success'=>'done']);
        }
        else
        {
           return response()->json(['error'=>'Failed']);
        }
    }*/


}
