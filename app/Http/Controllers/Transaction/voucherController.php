<?php
namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\session_master_model;
use App\branch_model;
use App\group_master_model;
use App\subgroup_master_model;
use App\voucher_detail_model;
use App\voucher_model;
use App\tbl_ledger_model;
use Auth;
use DB;
use Response;
use App\User;

class voucherController extends Controller
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
        $data['items'] = voucher_model::with('branch_model')->get();
        return view(TRANSACTION_VOUCHER.'list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['groups'] = group_master_model::orderBy('name','asc')->get();
        $data['subGroups'] = subgroup_master_model::orderBy('name','asc')->get();
        $data['branch'] = branch_model::orderBy('name','asc')->get();
        $data['voucher_count'] = voucher_model::count();
        return view(TRANSACTION_VOUCHER."create")->with($data);
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
            'branch_name' => 'required',
            'voucher_no' => 'required',
            'date' => 'required',
        ]);

        if ($validator->passes()) {
            
            // return $request->all();
            $totalDebit = $request->total_debit;
            $totalCredit = $request->total_credit;
            if($totalDebit != $totalCredit)
            {
                return response()->json(['sec_key'=>'','error_msg'=>'Debit & Credit amount not equal']);
                    exit;
            }
            $item = new voucher_model();
            
            $item->user_id = Auth::user()->id;
            $item->branch_model_id = $request->branch_name;
            $item->voucher_no = $request->voucher_no;
            $item->cheque_no = $request->cheque_no;
            $item->voucher_date = $request->date;
            $item->amount = $totalDebit;
            $item->voucher_desc = $request->voucher_description;
            $item->session_year = '2019-2020';
            $item->token = $request->_token;

            $create = date('Y-m-d h:m:i');
            $update = date('Y-m-d h:m:i');
            $main_group = $request->main_group;
            $sub_group = $request->sub_group;
            $debit = $request->debit;
            $credit = $request->credit;
            $remark = $request->remark;
            if($item->save())    
            {
// Start Voucher Detail table entry detail                
                $voucher_detail = new voucher_detail_model();
                $voucher_items = array();
                if(count($main_group) >= 1)
                {
                    for($i = 0; $i < count($main_group); $i++){
                        $arr[] = array(                        
                        'voucher_model_id' => $item->id,
                        'group_master_model_id' => $main_group[$i],
                        'subgroup_master_model_id' => $sub_group[$i],
                        'dr_amount' => $debit[$i],
                        'cr_amount' => $credit[$i],
                        'remarks' => $remark[$i],
                        'created_at'=>$create,
                        'updated_at'=>$update,
                        );
                    }
                    $voucher_items = $arr;
                    $voucher_detail->insert($voucher_items);
                   
                }
// Start Voucher TBL Ledger table entry detail                
                $tbl_item = new tbl_ledger_model();
                $tbl_items = array();
                if(count($sub_group) >= 1)
                {
                    for($i = 0; $i < count($sub_group); $i++){
                        $group_name = group_master_model::find($main_group[$i]);
                        $subgroup_name = subgroup_master_model::find($sub_group[$i]);
                        if ($debit[$i] != '' && $debit[$i] != 0) {
                            $type_of_tr = 'Dr';
                            $amt = $debit[$i];
                        }
                        else
                        {
                            $type_of_tr = 'Cr';
                            $amt = $credit[$i];
                        }
                        $arr2[] = array(                        
                        'gtype' => $group_name->name,
                        'stype' => $subgroup_name->name,
                        'date_of_transaction' => $request->date,
                        'account_head' => 'General Voucher',
                        'entry_type' => $subgroup_name->name,
                        'type_of_transaction' => $type_of_tr,
                        'amount' => $amt,
                        'particular' => $subgroup_name->name.' '.$remark[$i],
                        'branch_model_id' => $request->branch_name,
                        'voucher_model_id' => $item->id,
                        'main_head' => $subgroup_name->name,
                        'form_name' => 'General Voucher',
                        'token' => $request->_token,
                        'user_id' => Auth::user()->id,
                        'session_year' => '2019-2020',
                        'created_at'=>$create,
                        'updated_at'=>$update,
                        );
                    }
                    $tbl_items = $arr2;
                    $tbl_item->insert($tbl_items);

                    $voucher_id = DB::getPDO()->lastInsertId();
                    $voucher = date('ymd').''.$voucher_id;
                    DB::table('tbl_ledger_models')->where('voucher_model_id',$item->id)->update(['voucher_no'=>$voucher]);
                                       
                }                
                $return_url = url(TRANSACTION_URL_VOUCHER);
                return response()->json(['success'=>'<li>Voucher Successfully Generated</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
            }
        }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['item'] = voucher_model::with('branch_model')->findOrFail($id);
        $data['voucher_list'] = voucher_detail_model::with('group_master_model','subgroup_master_model')->where('voucher_model_id',$id)->get();
        
        // dd($data['voucher_list']);
        return view(TRANSACTION_VOUCHER.'view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['groups'] = group_master_model::orderBy('name','asc')->get();
        $data['subGroups'] = subgroup_master_model::orderBy('name','asc')->get();
        $data['branch'] = branch_model::orderBy('name','asc')->get();
        $data['item'] = voucher_model::findOrFail($id);
        $data['voucher_list'] = voucher_detail_model::where('voucher_model_id',$id)->get();
        $data['tbl_ledger_list'] = tbl_ledger_model::select('id','voucher_model_id')->where('voucher_model_id',$id)->get();
        // dd($data['tbl_ledger_list']);
        return view(TRANSACTION_VOUCHER.'edit')->with($data);
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
            'branch_name' => 'required',
            'voucher_no' => 'required',
            'date' => 'required',
        ]);

        if ($validator->passes()) {
            
            // return $request->all();
            $totalDebit = $request->total_debit;
            $totalCredit = $request->total_credit;
            if($totalDebit != $totalCredit)
            {
                return response()->json(['sec_key'=>'','error_msg'=>'Debit & Credit amount not equal']);
                    exit;
            }
            $item = voucher_model::findOrFail($id);
            
            $item->user_id = Auth::user()->id;
            $item->branch_model_id = $request->branch_name;
            $item->cheque_no = $request->cheque_no;
            $item->voucher_date = $request->date;
            $item->amount = $totalDebit;
            $item->voucher_desc = $request->voucher_description;
            $item->session_year = '2019-2020';

            $voucher_detail_id = $request->voucher_detail_id;
            $voucher_ledger_id = $request->voucher_ledger_id;
            $update = date('Y-m-d h:m:i');
            $main_group = $request->main_group;
            $sub_group = $request->sub_group;
            $debit = $request->debit;
            $credit = $request->credit;
            $remark = $request->remark;
            if($item->save())    
            {
// Start Voucher Detail table entry detail                
                
                for($i = 0; $i < count($main_group); $i++){
                    $voucher_detail = voucher_detail_model::where('id',$voucher_detail_id[$i]);
                    $voucher_detail->update([
                        'group_master_model_id' => $main_group[$i],
                        'subgroup_master_model_id' => $sub_group[$i],
                        'dr_amount' => $debit[$i],
                        'cr_amount' => $credit[$i],
                        'remarks' => $remark[$i],
                        'updated_at'=>$update
                    ]);
                }
                    
               
// Start Voucher TBL Ledger table entry detail                
                for($i = 0; $i < count($sub_group); $i++){
                    $tbl_item = tbl_ledger_model::where('id',$voucher_ledger_id[$i]);
                    $group_name = group_master_model::find($main_group[$i]);
                    $subgroup_name = subgroup_master_model::find($sub_group[$i]);
                    if ($debit[$i] != '' && $debit[$i] != 0) {
                        $type_of_tr = 'Dr';
                        $amt = $debit[$i];
                    }
                    else
                    {
                        $type_of_tr = 'Cr';
                        $amt = $credit[$i];
                    }
                    $tbl_item->update([
                        'gtype' => $group_name->name,
                        'stype' => $subgroup_name->name,
                        'date_of_transaction' => $request->date,
                        'account_head' => 'General Voucher',
                        'entry_type' => $subgroup_name->name,
                        'type_of_transaction' => $type_of_tr,
                        'amount' => $amt,
                        'particular' => $subgroup_name->name.' '.$remark[$i],
                        'branch_model_id' => $request->branch_name,
                        'main_head' => $subgroup_name->name,
                        'form_name' => 'General Voucher',
                        'user_id' => Auth::user()->id,
                        'session_year' => '2019-2020',
                        'updated_at'=>$update,
                    ]);
                    
                }
                            
                $return_url = url(TRANSACTION_URL_VOUCHER);
                return response()->json(['success'=>'<li>Voucher Successfully Updated</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
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
        // return $id;
        voucher_model::findOrFail($id)->delete();
        voucher_detail_model::whereIn('voucher_model_id',[$id])->delete();
        tbl_ledger_model::whereIn('voucher_model_id',[$id])->delete();
        
          return response()->json(['success'=>'done']);
    }

     public function getSubGroup($id)
    {
        $subGroups = subgroup_master_model::select('id','name')->where('group_master_model_id',$id)->get();
        return Response()->json([$subGroups]);
    }
    public function getUpdateSubGroup($iid = null, $id)
    {
        $subGroups = subgroup_master_model::select('id','name')->where('group_master_model_id',$id)->get();
        return Response()->json([$subGroups]);
    }


}
