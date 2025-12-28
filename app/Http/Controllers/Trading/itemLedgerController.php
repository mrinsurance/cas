<?php

namespace App\Http\Controllers\Trading;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\branch_model;
use App\company_address_model;
use App\product_master_tbl;
use App\sale_detail_tbl;
use App\purchase_detail_tbl;
use App\product_type_master_tbl;

use DB;
class itemLedgerController extends Controller
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
    protected $from, $toDate, $branch, $financial_year;
    private $allValues2 = [];

   public function index(Request $request)
{
    $from = $request->from ? Carbon::parse($request->from)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
    $to = $request->to ? Carbon::parse($request->to)->format('Y-m-d') : Carbon::now()->format('Y-m-d');

    $arr = [
        'from' => $from,
        'to' => $to,
        'product_name' => $request->product_name,
        'branch' => $request->branch,
    ];

    // Calculate the opening balance
    $SumOfOpenPurchaseQuantity = SumOfPurchaseItemQuantity($arr);
    $SumOfOpenSaleQuantity = SumOfSaleItemQuantity($arr);
    $sumOfOpenQuantity = $SumOfOpenPurchaseQuantity - $SumOfOpenSaleQuantity;

    // Fetch the ledger data and ensure it is sorted by date
    $ledgerDate = SumOfPurchaseSaleQuantity($arr)->sortBy('date_of_transaction');

    // Fetch product list if needed
    $productList = product_master_tbl::where('product_type_master_tbl_id', $request->product_party)
        ->orderBy(DB::raw('CAST(id AS UNSIGNED), id'))->get();

    // Prepare the data to be sent to the view
    $data = [
        'from' => $from,
        'to' => $to,
        'productList' => $productList,
        'sumOfOpenQuantity' => $sumOfOpenQuantity,
        'ledgerDate' => $ledgerDate,
    ];

    return view(TRADING_ITEM_LEDGER_PATH . 'index')->with($data);
}


}
