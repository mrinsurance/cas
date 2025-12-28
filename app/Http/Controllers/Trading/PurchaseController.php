<?php

namespace App\Http\Controllers\Trading;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\branch_model;
use App\group_master_model;
use App\subgroup_master_model;
use App\purchase_party_tbl;
use App\product_type_master_tbl;
use App\product_master_tbl;
use App\tax_master_tbl;
use App\purchase_tbl;
use App\purchase_detail_tbl;
use App\tbl_ledger_model;
use App\company_address_model;
use Auth;
use DB;
use Response;
use App\User;

class PurchaseController extends Controller
{
    private $delID;
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

         if (Schema::hasTable('tbl_ledger_models')) {
            Schema::table('tbl_ledger_models', function (Blueprint $table) {
              if (!Schema::hasColumn('tbl_ledger_models', 'purchase_tbl_id')) {
                $table->integer('purchase_tbl_id');
              }
            });
          } 
          if (Schema::hasTable('purchase_detail_tbls')) {
            Schema::table('purchase_detail_tbls', function (Blueprint $table) {
              if (!Schema::hasColumn('purchase_detail_tbls', 'branch_model_id')) {
                $table->integer('branch_model_id')->default(1);
              }if (!Schema::hasColumn('purchase_detail_tbls', 'purchase_by')) {
                $table->string('purchase_by')->nullable();
              }if (!Schema::hasColumn('purchase_detail_tbls', 'igst')) {
                $table->double('igst')->default(0);
              }if (!Schema::hasColumn('purchase_detail_tbls', 'taxable_value')) {
                $table->double('taxable_value')->default(0);
              }
            });
          } 
          if (Schema::hasTable('purchase_tbls')) {
            Schema::table('purchase_tbls', function (Blueprint $table) {
              if (!Schema::hasColumn('purchase_tbls', 'purchase_by')) {
                $table->string('purchase_by')->nullable();
              }if (!Schema::hasColumn('purchase_tbls', 'apr_status')) {
                $table->integer('apr_status')->default(0);
              } if (!Schema::hasColumn('purchase_tbls', 'bill_type')) {
                $table->integer('bill_type')->default(1);
              }
            });
          }
    }

    public function index()
    {
        $data['items'] = purchase_tbl::orderBy('date_of_transaction','desc')->get();
        return view(TRADING_PURCHASE_PATH.'list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $invoice = $request->inv;
        
        $data['branch'] = branch_model::orderBy('name','asc')->get();
        $data['purchasePartyList'] = purchase_party_tbl::orderBy('name','asc')->get();
        $data['productTypeList'] = product_type_master_tbl::orderBy('name','asc')->get();

        $data['taxList'] = tax_master_tbl::latest()->get();
        $purchaseTbl = purchase_tbl::where('invoice_no',$invoice)->first();
        $data['purchaseDetail'] = purchase_detail_tbl::where('purchase_tbl_id',@$purchaseTbl->id)->get();
        $data['invoice'] = $invoice;
        $data['bill'] = $request->bl;
        $data['date'] = $request->dt;
        $data['billDate'] = $request->bdt;
        $data['purchaseParty'] = $request->pp;
        $data['productParty'] = $request->pr;
        $data['branchName'] = $request->br;
        return view(TRADING_PURCHASE_PATH."create")->with($data);
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
            'bill_no' => 'required',
            'branch_name' => 'required',
            'date' => 'required',
            'purchase_by' => 'required',
            'product_party' => 'required',
            'product_name' => 'required',
            'quantity' => 'required',
            'total_amount' => 'required',
            'tax' => 'required',
            'rate' => 'required',
            'cgst' => 'required',
            'sgst' => 'required',
            
        ]);

        if ($validator->passes()) {
            
            if(!$request->invoice_no)
            {
                $inv = purchase_tbl::orderBy('id','desc')->first();
                if($inv)
                {
                    $invoice = 'P'.$inv->id.''.date('d/m');
                }
                else
                {
                    $invoice = 'P1'.date('d/m');
                }
            }
            else
            {
                $invoice = $request->invoice_no;
            }

            $item = purchase_tbl::firstOrNew(array('invoice_no' => $request->invoice_no));  
            // $type = resource_type::firstOrNew(array('name' => $value->type));          
            $item->user_id = Auth::user()->id;
            $item->invoice_no = $invoice;
            $item->bill_no = $request->bill_no;
            $item->bill_type = $request->billType;
            $item->date_of_transaction = $request->date;
            $item->billing_date = $request->bill_date;
            $item->purchase_party_tbl_id = $request->purchase_party;
            $item->product_type_master_tbl_id = $request->product_party;
            $item->branch_model_id = $request->branch_name;
            $item->purchase_by = $request->purchase_by;
            $item->session_year = '2019-2020';
            $item->token = $request->_token;
            if($item->save())    
            {
// Start Purchase Detail table entry detail                
                $purchase_detail = new purchase_detail_tbl();
                $purchase_detail->purchase_tbl_id = $item->id;
                $purchase_detail->product_master_tbl_id = $request->product_name;
                $purchase_detail->quantity = $request->quantity;
                if ($request->includingGst)
                {
                    $purchase_detail->amount = $request->total_amount;
                }
                else{
                    $purchase_detail->amount = $request->total_amount + $request->cgst + $request->sgst + $request->igst;
                }
                $purchase_detail->tax = $request->tax;
                $purchase_detail->rate = $request->rate;
                $purchase_detail->cgst = $request->cgst;
                $purchase_detail->sgst = $request->sgst;
                $purchase_detail->igst = $request->igst;
                $purchase_detail->taxable_value = $request->total_amount - ($request->cgst + $request->sgst + $request->igst);
                $purchase_detail->date_of_transaction = $request->date;
                $purchase_detail->branch_model_id = $request->branch_name;
                $purchase_detail->save();                   
            }
                 $return_url = url(TRADING_URL_PURCHASE).'/create?inv='.$invoice.'&bl='.$request->bill_no.'&dt='.$request->date.'&bdt='.$request->bill_date.'&pp='.$request->purchase_party.'&pr='.$request->product_party.'&br='.$request->branch_name;            
                return redirect($return_url)->with(["success" => "Item saved successfully!"]);
            }
       return redirect()->back()->with(['error' => 'Something went wrong!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = purchase_tbl::findOrFail($id);
        $data['item'] = $item;
        $data['branch'] = branch_model::orderBy('name','asc')->get();
        $data['purchasePartyList'] = purchase_party_tbl::orderBy('name','asc')->get();
        $data['productTypeList'] = product_type_master_tbl::orderBy('name','asc')->get();
        $data['purchaseDetail'] = purchase_detail_tbl::where('purchase_tbl_id',$item->id)->get();
        $data['company_address'] = company_address_model::select()->first();

        return view(TRADING_PURCHASE_PATH.'view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = purchase_tbl::findOrFail($id);
        $data['item'] = $item;
        $data['branch'] = branch_model::orderBy('name','asc')->get();
        $data['purchasePartyList'] = purchase_party_tbl::orderBy('name','asc')->get();
        $data['productTypeList'] = product_type_master_tbl::orderBy('name','asc')->get();
        $data['productMasterList'] = product_master_tbl::orderBy('name','asc')->get();
        $data['taxList'] = tax_master_tbl::latest()->get();
        $data['purchaseDetail'] = purchase_detail_tbl::where('purchase_tbl_id',$item->id)->get();
        // dd($item);
        return view(TRADING_PURCHASE_PATH.'edit')->with($data);
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
            'bill_no' => 'required',
            'branch_name' => 'required',
            'date' => 'required',
            'purchase_party' => 'required',
            'purchase_by' => 'required',
            'product_party' => 'required',
            'product_name' => 'nullable',
            'quantity' => 'nullable',
            'total_amount' => 'nullable',
            'tax' => 'nullable',
            'rate' => 'nullable',
            'cgst' => 'nullable',
            'sgst' => 'nullable',
            
        ]);

        if ($validator->passes()) {
            
            if(!$request->invoice_no)
            {
                $inv = purchase_tbl::orderBy('id','desc')->first();
                if($inv)
                {
                    $invoice = 'P'.$inv->id.''.date('d/m');
                }
                else
                {
                    $invoice = 'P1'.date('d/m');
                }
            }
            else
            {
                $invoice = $request->invoice_no;
            }

            $item = purchase_tbl::findOrFail($id);  
            // $type = resource_type::firstOrNew(array('name' => $value->type));          
            $item->user_id = Auth::user()->id;
            $item->invoice_no = $invoice;
            $item->bill_no = $request->bill_no;
            $item->bill_type = $request->billType;
            $item->date_of_transaction = $request->date;
            $item->billing_date = $request->bill_date;
            $item->purchase_party_tbl_id = $request->purchase_party;
            $item->purchase_by = $request->purchase_by;
            $item->product_type_master_tbl_id = $request->product_party;
            $item->branch_model_id = $request->branch_name;
            $item->session_year = '2019-2020';
            $item->token = $request->_token;
            if($item->save())    
            {
// Start Purchase Detail table entry detail 
            if ($request->button1 == 0) {               
                $purchase_detail = new purchase_detail_tbl();
                $purchase_detail->purchase_tbl_id = $item->id;
                $purchase_detail->product_master_tbl_id = $request->product_name;
                $purchase_detail->quantity = $request->quantity;
                if ($request->includingGst)
                {
                    $purchase_detail->amount = $request->total_amount;
                }
                else{
                    $purchase_detail->amount = $request->total_amount + $request->cgst + $request->sgst + $request->igst;
                }

                $purchase_detail->tax = $request->tax;
                $purchase_detail->rate = $request->rate;
                $purchase_detail->cgst = $request->cgst;
                $purchase_detail->sgst = $request->sgst;
                $purchase_detail->igst = $request->igst;
                $purchase_detail->taxable_value = $request->total_amount - ($request->cgst + $request->sgst + $request->igst);
                $purchase_detail->date_of_transaction = $request->date;
                $purchase_detail->branch_model_id = $request->branch_name;
                $purchase_detail->save(); 
                }                  
            }
                             
                return redirect()->back()->with(["success" => "Item saved successfully!"]);
            }
         
       return redirect()->back()->with(['error' => 'Something went wrong!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
    }

    public function deleteItem($id)
    {
        $this->delID = $id;
        
        $del = purchase_detail_tbl::findOrFail($this->delID)->delete();        
        if ($del) {
                 
                return redirect()->back()->with(["success" => "Item deleted successfully!"]);
            }
       return redirect()->back()->with(['error' => 'Something went wrong!']);

    }

     public function getUnit($id)
    {
        $subGroups = product_master_tbl::findOrFail($id);
        return Response()->json(['unit' => @$subGroups->unit_master_tbl->name, 'tax' => @$subGroups->tax_master_tbl->name]);
    }
    public function getUpdateSubGroup($iid = null, $id)
    {
        $subGroups = subgroup_master_model::select('id','name')->where('group_master_model_id',$id)->get();
        return Response()->json([$subGroups]);
    }

    public function aprovedItem(Request $request)
    {       

// ********************
// Head entry                    
// ********************
            if($request->aprBtn == 'ap')
            {            
            DB::table('purchase_tbls')
            ->where('id', $request->item_id)
            ->update(['apr_status' => 1]);
                    $tbl_item = tbl_ledger_model::firstOrNew(array('purchase_tbl_id' => $request->item_id, 'type_of_transaction' => 'Dr'));

                   $tbl_item->gtype = 'PURCHASE ACCOUNT';
                   $tbl_item->stype = 'PURCHASE '.$request->product;

                   $tbl_item->date_of_transaction = $request->date;
                   $tbl_item->account_head = 'PURCHASE';
                   $tbl_item->entry_type = 'Cash';
                   $tbl_item->branch_model_id = $request->branch;
                   $tbl_item->type_of_transaction = 'Dr';
                   $tbl_item->amount = $request->taxValue;
                   $tbl_item->particular = 'PURCHASE FROM '.$request->party;
                   $tbl_item->purchase_tbl_id = $request->item_id;
                   $tbl_item->mode_of_transaction = 'Cash';
                   $tbl_item->main_head = 'PURCHASE '.$request->product;
                   $tbl_item->form_name = 'PURCHASE';
                   $tbl_item->token = $request->_token;
                   $tbl_item->user_id = Auth::user()->id;
                   $tbl_item->session_year = '2019-2020';
                   $tbl_item->save();


                $update_tbl_ledger_model = tbl_ledger_model::find($tbl_item->id);
                $voucher = date('ymd').''.$update_tbl_ledger_model->id;
                $update_tbl_ledger_model->voucher_no = $voucher;
                $update_tbl_ledger_model->save();
// SGST
                $sgst = tbl_ledger_model::firstOrNew(array('purchase_tbl_id' => $request->item_id, 'type_of_transaction' => 'Cr'));

                    $sgst->gtype = 'GST';
                    $sgst->stype = 'SGST';
                    $sgst->main_head = 'SGST';
                $sgst->date_of_transaction = $request->date;
                $sgst->account_head = 'SGST';
                $sgst->entry_type = 'Cash';
                $sgst->branch_model_id = $request->branch;
                $sgst->type_of_transaction = 'Dr';
                $sgst->amount = $request->sgst;
                $sgst->particular = 'SGST PURCHASE FROM '.$request->party;
                $sgst->purchase_tbl_id = $request->item_id;
                $sgst->mode_of_transaction = 'Cash';

                $sgst->form_name = 'PURCHASE';
                $sgst->token = $request->_token;
                $sgst->user_id = Auth::user()->id;
                $sgst->session_year = '2019-2020';
                $sgst->remarks = $request->remarks;
                $sgst->voucher_no = $voucher;
                $sgst->save();
// CGST
                $cgst = tbl_ledger_model::firstOrNew(array('purchase_tbl_id' => $request->item_id, 'type_of_transaction' => 'Cr'));

                $cgst->gtype = 'GST';
                $cgst->stype = 'CGST';
                $cgst->main_head = 'CGST';
                $cgst->date_of_transaction = $request->date;
                $cgst->account_head = 'CGST';
                $cgst->entry_type = 'Cash';
                $cgst->branch_model_id = $request->branch;
                $cgst->type_of_transaction = 'Dr';
                $cgst->amount = $request->cgst;
                $cgst->particular = 'CGST PURCHASE FROM '.$request->party;
                $cgst->purchase_tbl_id = $request->item_id;
                $cgst->mode_of_transaction = 'Cash';
                $cgst->form_name = 'PURCHASE';
                $cgst->token = $request->_token;
                $cgst->user_id = Auth::user()->id;
                $cgst->session_year = '2019-2020';
                $cgst->remarks = $request->remarks;
                $cgst->voucher_no = $voucher;
                $cgst->save();
// ********************
        // Cash entry                    
// ********************


                $cash_tbl_item = tbl_ledger_model::firstOrNew(array('purchase_tbl_id' => $request->item_id, 'type_of_transaction' => 'Cr'));
if($request->purchase_by == 'CASH')
{
    $cash_tbl_item->gtype = $request->purchase_by;
    $cash_tbl_item->stype = $request->purchase_by;
    $cash_tbl_item->main_head = $request->purchase_by;     
}
else
{
    $cash_tbl_item->gtype = 'SUNDRY CREDITOR';
    $cash_tbl_item->stype = $request->purchase_by;
    $cash_tbl_item->main_head = $request->purchase_by;     
}                

                    // $cash_tbl_item->gtype = 'SUNDRY CREDITORS';
                    // $cash_tbl_item->stype = $request->party;
                    // $cash_tbl_item->main_head = $request->party;               
                 
                   $cash_tbl_item->date_of_transaction = $request->date;
                   $cash_tbl_item->account_head = 'PURCHASE';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $request->branch;
                   $cash_tbl_item->type_of_transaction = 'Cr';
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->particular = 'PURCHASE FROM '.$request->party;
                   $cash_tbl_item->purchase_tbl_id = $request->item_id;
                   $cash_tbl_item->mode_of_transaction = 'Cash';
                   
                   $cash_tbl_item->form_name = 'PURCHASE';
                   $cash_tbl_item->token = $request->_token;
                   $cash_tbl_item->user_id = Auth::user()->id;
                   $cash_tbl_item->session_year = '2019-2020';
                   $cash_tbl_item->remarks = $request->remarks;
                   $cash_tbl_item->voucher_no = $voucher;


                   if($cash_tbl_item->save())
                   {
                        return redirect()->back()->with(["success" => "Item saved successfully!"]);
                   }
               }
               if($request->aprBtn == 'unap')
               {
                    DB::table('purchase_tbls')
                      ->where('id', $request->item_id)
                      ->update(['apr_status' => 0]);
                    tbl_ledger_model::where('purchase_tbl_id',$request->item_id)->delete();
                    return redirect()->back()->with(["success" => "Item unapproved successfully!"]);
               }
                       return redirect()->back()->with(['error' => 'Something went wrong!']);
    }

    public function getProductName(Request $request, $id = null)
    {
       return product_master_tbl::orderBy('name','asc')->where('product_type_master_tbl_id',$id)->get();
    }


}
