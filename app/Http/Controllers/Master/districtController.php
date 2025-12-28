<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\state_model;
use App\district_model;
use Auth;
use DB;
use Response;

class districtController extends Controller
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
        $items = district_model::with('state_model')->orderBy('name','asc')->get();
        return view(MASTER_DIST_MASTER.'list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = state_model::orderBy('name','asc')->get();
        return view(MASTER_DIST_MASTER."create",compact(['state']));
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
            'state' => 'required',
            'name' => 'required',
            
        ]);

        if ($validator->passes()) {
            $item = new district_model();
            $ids = explode("\n", str_replace("\r", "", $request->name));
            $token = $request->_token;
            $state = $request->state;
            $create = date('Y-m-d h:m:i');
            $update = date('Y-m-d h:m:i');
            $items = array();
            if(count($ids) > 1)
            {
                for($i = 0; $i < count($ids); $i++){
                    $arr[] = array(
                        'state_model_id'=>$state,
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
                $item->state_model_id = $request->state;
                $item->name = $request->name;
                $item->token = $request->_token;
                $item->save();    
            }
            $return_url = url(MASTER_URL_DIST);
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
        $state = state_model::orderBy('name','asc')->get();
        $item = district_model::find($id);
        return view(MASTER_DIST_MASTER.'edit', compact(['state','item']));
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
            'state' => 'required',
            'name' => 'required',
            
        ]);

        if ($validator->passes()) {
            
            $item = district_model::find($id);
            $item->state_model_id = $request->state;
            $item->name = $request->name;
            
            if($item->save())
            {
               $return_url = url(MASTER_URL_DIST);
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
        $item = district_model::find($id);
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
