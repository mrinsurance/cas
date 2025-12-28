<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\interest_model;
use App\session_master_model;
use Auth;
use DB;
use Response;

class interestController extends Controller
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
        $items = interest_model::with('session_master_model')->orderBy('session_master_model_id','asc')->get();
        return view(MASTER_INTEREST_MASTER.'list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sessions = session_master_model::orderBy('start_date','asc')->get();
        return view(MASTER_INTEREST_MASTER."create",compact(['sessions']));
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
            'session_year' => 'required',
            'int_saving' => 'bail|required|numeric',
            'int_fd' => 'bail|required|numeric',
            'int_rd' => 'bail|required|numeric',
            'int_mis' => 'bail|required|numeric',
            'int_loan' => 'bail|required|numeric',
            'int_loan_deafaulter' => 'bail|required|numeric',
            
        ]);

        if ($validator->passes()) {
            $item = new interest_model();
            
                $item->session_master_model_id = $request->session_year;
                $item->saving_int = $request->int_saving;
                $item->fd_int = $request->int_fd;
                $item->rd_int = $request->int_rd;
                $item->mis_int = $request->int_mis;
                $item->loan_int = $request->int_loan;
                $item->loan_default_int = $request->int_loan_deafaulter;
                $item->token = $request->_token;
                $item->save();    
           
            $return_url = url(MASTER_URL_INTEREST);
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
        $sessions = session_master_model::orderBy('start_date','asc')->get();
        $item = interest_model::find($id);
        // dd($roles);
        return view(MASTER_INTEREST_MASTER.'edit', compact(['item','sessions']));
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
            'session_year' => 'required',
            'int_saving' => 'bail|required|numeric',
            'int_fd' => 'bail|required|numeric',
            'int_rd' => 'bail|required|numeric',
            'int_mis' => 'bail|required|numeric',
            'int_loan' => 'bail|required|numeric',
            'int_loan_deafaulter' => 'bail|required|numeric',
            
        ]);

        if ($validator->passes()) {
            
            $item = interest_model::find($id);
             $item->session_master_model_id = $request->session_year;
                $item->saving_int = $request->int_saving;
                $item->fd_int = $request->int_fd;
                $item->rd_int = $request->int_rd;
                $item->mis_int = $request->int_mis;
                $item->loan_int = $request->int_loan;
                $item->loan_default_int = $request->int_loan_deafaulter;
                $item->token = $request->_token;
            
            if($item->save())
            {
               $return_url = url(MASTER_URL_INTEREST);
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
        $item = interest_model::find($id);
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
