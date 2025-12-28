<?php

namespace App\Http\Controllers\Additional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\tbl_ledger_model;
use App\branch_model;
use App\designation_model;
use App\shadow_model;
use App\saving_ac_model;
use App\dds_ac_model;
use App\rd_installment_model;
use App\drd_installment_model;
use App\tbl_loan_return_model;
use App\open_new_ac_model;
use App\User;
use Auth;
use DB;

class agentAcController extends Controller
{
     protected $form, $to;
     function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {

        $items_obj = open_new_ac_model::select(
            'id',
            'member_type_model_id',
            'account_no',
            'full_name',
            'father_name',
            'contact_no',
            'status'
        )->with('member_type_model')
        ->orderBy('member_type_model_id','asc')
        ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->agent_name)
        {
            $items_obj = $items_obj->where('agent_name',$request->agent_name);
            $data['agent_name'] = $request->agent_name;
        }if($request->branch)
        {
            $items_obj = $items_obj->where('branch_model_id',$request->branch);
            $data['branch'] = $request->branch;
        }
        if ($request->_token)
        {
            $data['items'] = $items_obj->get();
        }
        else{
            $data['items'] = [];
        }
        $data['branches'] = branch_model::all();
        $data['users'] = User::with('designation_model')->where('staff_type','Agent')->get();
        
        return view(ADDITIONAL_REPORT.'agent-report')->with($data);

    }
}

