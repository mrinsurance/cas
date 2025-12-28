<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\tax_master_tbl;
use App\unit_master_tbl;
use App\product_type_master_tbl;
use App\product_master_tbl;
use Auth;
use DB;
use Response;

class productController extends Controller
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
        $items = product_master_tbl::orderBy('name','asc')->get();
        return view(MASTER_PRODUCTS_MASTER.'list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'taxes' => tax_master_tbl::orderBy('name','asc')->get(),
            'units' => unit_master_tbl::orderBy('name','asc')->get(),
            'prd_types' => product_type_master_tbl::orderBy('name','asc')->get(),
        ];
        return view(MASTER_PRODUCTS_MASTER."create")->with($data);
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
            'purchase_rate' => 'required',            
            'sale_rate' => 'required',            
            'product_type' => 'required',            
            'unit' => 'required',            
            'tax' => 'required',            
        ]);

        if ($validator->passes()) {
            $item = new product_master_tbl();
            
                $item->name = $request->name;
                $item->purchase_rate = $request->purchase_rate;
                $item->sale_rate = $request->sale_rate;
                $item->product_type_master_tbl_id = $request->product_type;
                $item->tax_master_tbl_id = $request->tax;
                $item->unit_master_tbl_id = $request->unit;
                $item->save();    
           
            $return_url = url(MASTER_URL_PRODUCTS);
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
        $item = product_master_tbl::find($id);
        // dd($roles);
        $data = [
            'taxes' => tax_master_tbl::orderBy('name','asc')->get(),
            'units' => unit_master_tbl::orderBy('name','asc')->get(),
            'prd_types' => product_type_master_tbl::orderBy('name','asc')->get(),
            'item' => $item,
        ];
        return view(MASTER_PRODUCTS_MASTER.'edit')->with($data);
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
            'purchase_rate' => 'required',            
            'sale_rate' => 'required',            
            'product_type' => 'required',            
            'unit' => 'required',            
            'tax' => 'required',          
        ]);

        if ($validator->passes()) {
            
            $item = product_master_tbl::find($id);
            $item->name = $request->name;
            $item->purchase_rate = $request->purchase_rate;
            $item->sale_rate = $request->sale_rate;
            $item->product_type_master_tbl_id = $request->product_type;
            $item->tax_master_tbl_id = $request->tax;
            $item->unit_master_tbl_id = $request->unit;
            
            if($item->save())
            {
               $return_url = url(MASTER_URL_PRODUCTS);
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
    public function destroy($id)
    {
        $item = product_master_tbl::find($id);
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
