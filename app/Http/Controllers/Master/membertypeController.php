<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\member_type_model;
use Auth;
use DB;
use Response;
use Crypt;

class membertypeController extends Controller
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
        $items = member_type_model::orderBy('name','asc')->get();
        return view(MASTER_MEMBER_TYPE.'list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(MASTER_MEMBER_TYPE."create");
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
            'member_type' => 'required',
            
        ]);

        if ($validator->passes()) {
            $item = new member_type_model();
            $ids = explode("\n", str_replace("\r", "", $request->member_type));
            $token = $request->_token;
            $create = date('Y-m-d h:m:i');
            $update = date('Y-m-d h:m:i');
            $items = array();
            if(count($ids) > 1)
            {
                for($i = 0; $i < count($ids); $i++){
                    $arr[] = array(
                        'name'=>$ids[$i],
                        'token'=>$token,
                        'created_at'=>$create,
                        'updated_at'=>$update,
                        );
                }
                $items = $arr;
                $item->insert($items);
                
            }
            else
            {
                $item->name = $request->member_type;
                $item->token = $request->_token;
                $item->save();    
            }
            $return_url = url(MASTER_URL_MEMBER_TYPE);
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
        $item = member_type_model::find($id);
        // dd($roles);
        return view(MASTER_MEMBER_TYPE.'edit', compact(['item']));
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
            'member_type' => 'required',
            
        ]);

        if ($validator->passes()) {
            
            $item = member_type_model::find($id);
            $item->name = $request->member_type;
            
            if($item->save())
            {
               $return_url = url(MASTER_URL_MEMBER_TYPE);
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
    // public function destroy($id)
    // {
    //     $item = member_type_model::find($id);
    //     if($item->delete())
    //     {
    //        return response()->json(['success'=>'done']);
    //     } 
    //     else
    //     {
    //        return response()->json(['error'=>'Failed']); 
    //     }
    // }
}
