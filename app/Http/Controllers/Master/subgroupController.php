<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\group_master_model;
use App\subgroup_master_model;
use App\bal_sheet_head_model;
use Auth;
use DB;
use Response;

class subgroupController extends Controller
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
        $items = subgroup_master_model::with('group_master_model','bal_sheet_head_model')->orderBy('name','asc')->get();
        return view(MASTER_SUB_GROUP_MASTER.'list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Sub_Group_For_Arr = ['RD','Trading','Profit & Loss','Balance Sheet'];
        $group = group_master_model::orderBy('name','asc')->get();
        $balheads = bal_sheet_head_model::orderBy('name','asc')->get();
        return view(MASTER_SUB_GROUP_MASTER."create",compact(['group','balheads','Sub_Group_For_Arr']));
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
            'group' => 'required',
            'name' => 'required',
            'sub_group_for' => 'required',            
        ]);

        if ($validator->passes()) {
            $item = new subgroup_master_model();
            $ids = explode("\n", str_replace("\r", "", $request->name));
            $token = $request->_token;
            $group = $request->group;
            $head = $request->balance_head;
            $sub_group_for = $request->sub_group_for;
            $create = date('Y-m-d h:m:i');
            $update = date('Y-m-d h:m:i');
            $items = array();
            if(count($ids) > 1)
            {
                for($i = 0; $i < count($ids); $i++){
                    $arr[] = array(
                        'group_master_model_id'=>$group,
                        'bal_sheet_head_model_id'=>$head,
                        'name'=>$ids[$i],
                        'sub_group_for'=>$sub_group_for,
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
                $item->group_master_model_id = $request->group;
                $item->bal_sheet_head_model_id = $request->balance_head;
                $item->name = $request->name;
                $item->token = $request->_token;
                $item->save();    
            }
            $return_url = url(MASTER_URL_SUB_GROUP);
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
        $Sub_Group_For_Arr = ['RD','Trading','Profit & Loss','Balance Sheet'];
        $group = group_master_model::orderBy('name','asc')->get();
        $balheads = bal_sheet_head_model::orderBy('name','asc')->get();
        $item = subgroup_master_model::find($id);
        return view(MASTER_SUB_GROUP_MASTER.'edit', compact(['group','item','balheads','Sub_Group_For_Arr']));
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
           'group' => 'required',
           'name' => 'required',
           'sub_group_for' => 'required',
            
        ]);

        if ($validator->passes()) {
            
            $item = subgroup_master_model::find($id);
            $item->group_master_model_id = $request->group;
            $item->bal_sheet_head_model_id = $request->balance_head;
            $item->name = $request->name;
            $item->sub_group_for = $request->sub_group_for;
               
            if($item->save())
            {
               $return_url = url(MASTER_URL_SUB_GROUP);
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
        $item = subgroup_master_model::find($id);
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
