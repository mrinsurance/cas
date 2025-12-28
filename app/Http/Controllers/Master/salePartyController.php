<?php

namespace App\Http\Controllers\Master;

use App\salePartyTbl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
use Response;

class salePartyController extends Controller
{
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
        $items = salePartyTbl::orderBy('name','asc')->get();
        return view('Master.Sale-Party.list',compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Master.Sale-Party.create");
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
        ]);

        if ($validator->passes()) {
            $item = new salePartyTbl();

            $item->name = $request->name;
            $item->address = $request->address;
            $item->save();

            $return_url = route('master.sale.party.index');
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
        $item = salePartyTbl::find($id);
        return view('Master.Sale-Party.edit')->with(['item'=>$item]);
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
        ]);

        if ($validator->passes()) {

            $item = salePartyTbl::find($id);
            $item->name = $request->name;
            $item->address = $request->address;
            if($item->save())
            {
                $return_url = route('master.sale.party.index');
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
        $item = salePartyTbl::find($id);
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
