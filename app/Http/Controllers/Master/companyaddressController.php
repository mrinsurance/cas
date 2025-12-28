<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\company_address_model;
use App\state_model;
use App\district_model;
use Auth;
use DB;
use Response;

class companyaddressController extends Controller
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
        $items = company_address_model::orderBy('name','asc')->get();
        return view(MASTER_COMPANY_ADDR.'list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['state'] = state_model::orderBy('name','asc')->get();
        return view(MASTER_COMPANY_ADDR."create")->with($data);
    }

     public function updatelocation(Request $request,$id = null)
    {
        // return $id;
        $id = $request->id;
        $data = district_model::select('id','state_model_id','name')->orderBy('name','asc')->where('state_model_id',$id)->get();
        return Response()->json([$data]);
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
            'company_name' => 'required',
            'state' => 'required',
            'district' => 'required',
            'tehsil' => 'required',
            'address' => 'required',
            'pin_code' => 'bail|required|numeric|digits:6',
            'mobile' => 'bail|required|numeric|digits:10',
            'email' => 'nullable|email',

        ]);

        if ($validator->passes()) {
            $item = new company_address_model();

            $item->name = $request->company_name;
            $item->token = $request->_token;
            $item->state_model_id = $request->state;
            $item->district_model_id = $request->district;
            $item->tehsil = $request->tehsil;
            $item->address = $request->address;
            $item->pin_code = $request->pin_code;
            $item->mobile = $request->mobile;
            $item->email = $request->email;
            $item->save();

            $return_url = url(MASTER_URL_COMPANY_ADDR);
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
        $data['item'] = company_address_model::find($id);
        $data['state'] = state_model::orderBy('name','asc')->get();
        $data['districts'] = district_model::orderBy('name','asc')->where('state_model_id',$data['item']->state_model_id)->get();
        return view(MASTER_COMPANY_ADDR.'edit')->with($data);
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
            'company_name' => 'required',
            'state' => 'required',
            'district' => 'required',
            'tehsil' => 'required',
            'address' => 'required',
            'pin_code' => 'bail|required|numeric|digits:6',
            'mobile' => 'bail|required|numeric|digits:10',
            'email' => 'nullable|email',

        ]);

        if ($validator->passes()) {

            $item = company_address_model::find($id);
            $item->name = $request->company_name;
            $item->token = $request->_token;
            $item->state_model_id = $request->state;
            $item->district_model_id = $request->district;
            $item->tehsil = $request->tehsil;
            $item->address = $request->address;
            $item->pin_code = $request->pin_code;
            $item->mobile = $request->mobile;
            $item->email = $request->email;
            $item->gst_number = $request->gstNumber;

            if($item->save())
            {
               $return_url = url(MASTER_URL_COMPANY_ADDR);
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
   /* public function destroy($id)
    {
        $item = company_address_model::find($id);
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
