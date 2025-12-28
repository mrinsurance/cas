<?php

namespace App\Http\Controllers\Trading;

use Carbon\Carbon;
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
use App\sale_tbl;
use App\sale_detail_tbl;
use App\tbl_ledger_model;
use App\company_address_model;
use Auth;
use DB;
use Response;
use App\User;

class saleController extends Controller
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

         if (Schema::hasTable('tbl_ledger_models')) {
            Schema::table('tbl_ledger_models', function (Blueprint $table) {
              if (!Schema::hasColumn('tbl_ledger_models', 'sale_tbl_id')) {
                $table->integer('sale_tbl_id');
              }
            });
          }
          if (Schema::hasTable('sale_detail_tbls')) {
            Schema::table('sale_detail_tbls', function (Blueprint $table) {
              if (!Schema::hasColumn('sale_detail_tbls', 'branch_model_id')) {
                $table->integer('branch_model_id')->default(1);
              }
                if (!Schema::hasColumn('sale_detail_tbls', 'amount_without_tax')) {
                    $table->double('amount_without_tax')->default(0);
                }
                if (!Schema::hasColumn('sale_detail_tbls', 'igst')) {
                    $table->double('igst')->default(0);
                }
            });
          }
          if (Schema::hasTable('sale_tbls')) {
            Schema::table('sale_tbls', function (Blueprint $table) {
              if (!Schema::hasColumn('sale_tbls', 'apr_status')) {
                $table->integer('apr_status')->default(0);
              }
            });
          }
    }

    public function index()
    {
        if(Auth::user()->staff_type == 'Staff')
        {
            $data['items'] = sale_tbl::orderBy('date_of_transaction','desc')->get();
        }
        else{
            $data['items'] = sale_tbl::orderBy('date_of_transaction','desc')->whereUserId(Auth::user()->id)->get();
        }
        return view(TRADING_SALE_PATH.'list')->with($data);
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

        $data['clients'] = subgroup_master_model::orderBy('name','asc')->where('group_master_model_id',29)->get();
        $data['SaleList'] = ['CASH','SUNDRY DEBTORS'];

        $data['productTypeList'] = product_type_master_tbl::orderBy('name','asc')->get();
        $data['productMasterList'] = product_master_tbl::orderBy('name','asc')->get();
        $data['taxList'] = tax_master_tbl::latest()->get();
        $saleTbl = sale_tbl::where('invoice_no',$invoice)->first();
        $data['saleDetail'] = sale_detail_tbl::where('sale_tbl_id',@$saleTbl->id)->get();

        return view(TRADING_SALE_PATH."create")->with($data);
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
            'date' => 'required',
            'sale_to' => 'required',
            'sale_by' => 'required',
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
              $inv = sale_tbl::orderBy('id','desc')->first();
                if($inv)
                {
                    $invId = $inv->id + 1;
                    $invoice = 'S'.$invId.''.date('d/m');
                }
                else
                {
                    $invoice = 'S1'.date('d/m');
                }
            }
            else
            {
                $invoice = $request->invoice_no;
            }

            $item = sale_tbl::firstOrNew(array('invoice_no' => $request->invoice_no));
            // $type = resource_type::firstOrNew(array('name' => $value->type));
            $item->user_id = Auth::user()->id;
            $item->invoice_no = $invoice;
            $item->date_of_transaction = $request->date;
            $item->billing_date = $request->bill_date;
            $item->client = $request->sale_to;
            $item->sale_by = $request->sale_by;
            $item->product_type_master_tbl_id = $request->product_party;
            $item->branch_model_id = $request->branch_name;
            $item->session_year = '2019-2020';
            $item->token = $request->_token;
            if($item->save())
            {
// Start Purchase Detail table entry detail
                $amountWithoutTax = $request->rate * $request->quantity;
                $purchase_detail = new sale_detail_tbl();
                $purchase_detail->sale_tbl_id = $item->id;
                $purchase_detail->product_master_tbl_id = $request->product_name;
                $purchase_detail->quantity = $request->quantity;
                $purchase_detail->amount = $request->total_amount;
                $purchase_detail->amount_without_tax = $amountWithoutTax;
                $purchase_detail->tax = $request->tax;
                $purchase_detail->rate = $request->rate;
                $purchase_detail->cgst = $request->cgst;
                $purchase_detail->sgst = $request->sgst;
                $purchase_detail->igst = $request->igst;
                $purchase_detail->date_of_transaction = $request->date;
                $purchase_detail->branch_model_id = $request->branch_name;
                $purchase_detail->save();
            }
                 $return_url = url(TRADING_URL_SALE).'/create?inv='.$invoice.'&dt='.$request->date.'&bdt='.$request->bill_date.'&st='.$request->sale_to.'&pr='.$request->product_party.'&sb='.$request->sale_by.'&br='.$request->branch_name;
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
        $item = sale_tbl::findOrFail($id);
        $data['item'] = $item;
        $data['branch'] = branch_model::orderBy('name','asc')->get();

        $data['clients'] = subgroup_master_model::orderBy('name','asc')->where('group_master_model_id',29)->get();
        $data['productTypeList'] = product_type_master_tbl::orderBy('name','asc')->get();

        $data['saleDetail'] = sale_detail_tbl::where('sale_tbl_id',$item->id)->get();
        $data['company_address'] = company_address_model::select()->first();
        return view(TRADING_SALE_PATH.'view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = sale_tbl::findOrFail($id);
        $data['item'] = $item;
        $data['branch'] = branch_model::orderBy('name','asc')->get();

        $data['clients'] = subgroup_master_model::orderBy('name','asc')->where('group_master_model_id',29)->get();
        $data['SaleList'] = ['CASH','SUNDRY DEBTORS'];
        $data['productTypeList'] = product_type_master_tbl::orderBy('name','asc')->get();
        $data['productMasterList'] = product_master_tbl::orderBy('name','asc')->get();
        $data['taxList'] = tax_master_tbl::latest()->get();
        $data['saleDetail'] = sale_detail_tbl::where('sale_tbl_id',$item->id)->get();
        return view(TRADING_SALE_PATH.'edit')->with($data);
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
            'date' => 'required',
            'sale_to' => 'required',
            'sale_by' => 'required',
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
                $inv = sale_tbl::orderBy('id','desc')->first();
                if($inv)
                {
                    $invoice = 'S'.$inv->id.''.date('d/m');
                }
                else
                {
                    $invoice = 'S1'.date('d/m');
                }
            }
            else
            {
                $invoice = $request->invoice_no;
            }

            $item = sale_tbl::findOrFail($id);
            $item->user_id = Auth::user()->id;
            $item->invoice_no = $invoice;
            $item->date_of_transaction = $request->date;
            $item->billing_date = $request->bill_date;
            $item->client = $request->sale_to;
            $item->sale_by = $request->sale_by;
            $item->product_type_master_tbl_id = $request->product_party;
            $item->branch_model_id = $request->branch_name;
            $item->session_year = '2019-2020';
            $item->token = $request->_token;
            $save = $item->save();
            if($save)
            {
                if ($request->button1 == 0) {
                // Start Purchase Detail table entry detail
                    $amountWithoutTax = $request->rate * $request->quantity;
                $purchase_detail = new sale_detail_tbl();
                $purchase_detail->sale_tbl_id = $item->id;
                $purchase_detail->product_master_tbl_id = $request->product_name;
                $purchase_detail->quantity = $request->quantity;
                $purchase_detail->amount = $request->total_amount;
                $purchase_detail->amount_without_tax = $amountWithoutTax;
                $purchase_detail->tax = $request->tax;
                $purchase_detail->rate = $request->rate;
                $purchase_detail->cgst = $request->cgst;
                $purchase_detail->sgst = $request->sgst;
                $purchase_detail->igst = $request->igst;
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

        $del = sale_detail_tbl::findOrFail($id)->delete();
        if ($del) {

                return redirect()->back()->with(["success" => "Item deleted successfully!"]);
            }
       return redirect()->back()->with(['error' => 'Something went wrong!']);

    }

     public function getUnit($id)
    {
        $subGroups = product_master_tbl::findOrFail($id);
        $stock = getProductStock($id);
        return Response()->json(['unit' => $subGroups->unit_master_tbl->name, 'tax' => $subGroups->tax_master_tbl->name, 'stock'=>$stock]);
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
           DB::table('sale_tbls')->where('id', $request->item_id)->update(['apr_status' => 1]);

                $SaleAccount = [
                    'gtype' => 'SALES ACCOUNT',
                    'stype' => 'SALE '.$request->product,
                    'date_of_transaction' => $request->date,
                    'account_head' => 'SALE',
                    'entry_type' => 'Cash',
                    'branch_model_id' => $request->branch,
                    'type_of_transaction' => 'Cr',
                    'amount' => $request->amount,
                    'particular' => 'SALE FROM '.$request->client,
                    'sale_tbl_id' => $request->item_id,
                    'mode_of_transaction' => 'Cash',
                    'main_head' => 'SALE '.$request->product,
                    'form_name' => 'SALE',
                    'token' => $request->_token,
                    'user_id' => Auth::user()->id,
                    'session_year' => '2019-2020',
                ];
            $tblLedgerModelId = DB::table('tbl_ledger_models')->insertGetId($SaleAccount);
            $update_tbl_ledger_model = tbl_ledger_model::find($tblLedgerModelId);
            $voucher = date('ymd').''.$update_tbl_ledger_model->id;
            $update_tbl_ledger_model->voucher_no = $voucher;
            $update_tbl_ledger_model->save();

//  SGST
            $sgst = [
                'gtype' => 'GST',
                'stype' => 'SGST',
                'main_head' => 'SGST',
                'date_of_transaction' => $request->date,
                'account_head' => 'SGST',
                'entry_type' => 'Cash',
                'branch_model_id' => $request->branch,
                'type_of_transaction' => 'Cr',
                'amount' => $request->sgst,
                'particular' => 'SGST SALE FROM '.$request->client,
                'sale_tbl_id' => $request->item_id,
                'mode_of_transaction' => 'Cash',
                'form_name' => 'SALE',
                'token' => $request->_token,
                'user_id' => Auth::user()->id,
                'session_year' => '2019-2020',
                'remarks' => $request->remarks,
                'voucher_no' => $voucher,
            ];
// CGST
            $cgst = [
                'gtype' => 'GST',
                'stype' => 'CGST',
                'main_head' => 'CGST',
                'date_of_transaction' => $request->date,
                'account_head' => 'CGST',
                'entry_type' => 'Cash',
                'branch_model_id' => $request->branch,
                'type_of_transaction' => 'Cr',
                'amount' => $request->cgst,
                'particular' => 'CGST SALE FROM '.$request->client,
                'sale_tbl_id' => $request->item_id,
                'mode_of_transaction' => 'Cash',
                'form_name' => 'SALE',
                'token' => $request->_token,
                'user_id' => Auth::user()->id,
                'session_year' => '2019-2020',
                'remarks' => $request->remarks,
                'voucher_no' => $voucher,
            ];

            DB::table('tbl_ledger_models')->insert($sgst);
            DB::table('tbl_ledger_models')->insert($cgst);

// ********************
        // Cash entry
// ********************
                $cash_tbl_item = tbl_ledger_model::firstOrNew(array('sale_tbl_id' => $request->item_id, 'type_of_transaction' => 'Dr'));
                if($request->client == 'CASH')
                {
                    $cash_tbl_item->gtype = 'CASH';
                    $cash_tbl_item->stype = 'CASH';
                    $cash_tbl_item->main_head = 'CASH';
                }
                else
                {
                    $cash_tbl_item->gtype = 'SUNDRY DEBTORS';
                    $cash_tbl_item->stype = $request->client;
                    $cash_tbl_item->main_head = $request->client;
                }

                   $cash_tbl_item->date_of_transaction = $request->date;
                   $cash_tbl_item->account_head = 'SALE';
                   $cash_tbl_item->entry_type = 'Cash';
                   $cash_tbl_item->branch_model_id = $request->branch;
                   $cash_tbl_item->type_of_transaction = 'Dr';
                   $cash_tbl_item->amount = $request->amount;
                   $cash_tbl_item->particular = 'SALE FROM '.$request->client;
                   $cash_tbl_item->sale_tbl_id = $request->item_id;
                   $cash_tbl_item->mode_of_transaction = 'Cash';

                   $cash_tbl_item->form_name = 'SALE';
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
                    DB::table('sale_tbls')
                      ->where('id', $request->item_id)
                      ->update(['apr_status' => 0]);
                    tbl_ledger_model::where('sale_tbl_id',$request->item_id)->delete();
                    return redirect()->back()->with(["success" => "Item unapproved successfully!"]);
               }
               return redirect()->back()->with(['error' => 'Something went wrong!']);
    }

    public function PrintSale(Request $request)
    {
        $id = $request->get('id');
        $item = sale_tbl::findOrFail($id);
        $data['item'] = $item;
        $data['branch'] = branch_model::orderBy('name','asc')->get();

        $data['clients'] = subgroup_master_model::orderBy('name','asc')->where('group_master_model_id',29)->get();
        $data['productTypeList'] = product_type_master_tbl::orderBy('name','asc')->get();

        $company_address = company_address_model::first();
        return view('Trading.Sale.print-sale', compact(['item','company_address']));
    }

    public function CollectionReport(Request $request)
    {
        $user = $request->get('user');
        if ($request->get('fromDate'))
        {
            $fromDate = $request->get('fromDate');
        }
        else{
            $fromDate = Carbon::now()->format('Y-m-d');
        }
        if ($request->get('toDate'))
        {
            $toDate = $request->get('toDate');
        }
        else{
            $toDate = Carbon::now()->format('Y-m-d');
        }
        $saleData = sale_tbl::latest();
        if($fromDate)
        {
            $saleData->where('date_of_transaction', '>=', $fromDate);
        }
        if($toDate)
        {
            $saleData->where('date_of_transaction', '<=', $toDate);
        }
        if($user)
        {
            $saleData->whereUserId($user);
        }
        $saleData = $saleData->get();
        return view('Trading.Sale.collection-report', compact(['fromDate','toDate','saleData']));
    }
}
