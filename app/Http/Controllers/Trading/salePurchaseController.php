<?php

namespace App\Http\Controllers\Trading;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\branch_model;
use App\company_address_model;
use App\product_master_tbl;
use App\sale_detail_tbl;
use App\purchase_detail_tbl;
use App\product_type_master_tbl;

use DB;
class salePurchaseController extends Controller
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
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
        $productList = [];
        if ($request->from_date)
        {
            $productList= product_master_tbl::select();
            if ($request->order_by)
            {
                if ($request->order_by == 'id')
                {
                    $productList->orderBy(DB::raw('CAST(id AS UNSIGNED), id'));
                }
                if ($request->order_by == 'name')
                {
                    $productList->orderBy(DB::raw('CAST(name AS UNSIGNED), name'));
                }
            }
                $productList->orderBy(DB::raw('CAST(id AS UNSIGNED), id'));
            if($request->producttype == true)
            {
                $productList= $productList->where('product_type_master_tbl_id', $request->producttype);
            }
            $productList = $productList->get();
        }


         $data = [
            'branch' => $request->branch,
            'from_date' => $this->from,
            'to_date' => $this->toDate,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'productstype' => product_type_master_tbl::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            //'productList' => product_master_tbl::orderBy(DB::raw('CAST(id AS UNSIGNED), id'))->get(),
            'productList' => $productList,

        ];
        return view(TRADING_SALE_PURCHASE_PATH.'/index')->with($data);
    }

    public function StockReport(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
        $productList = [];
        if ($request->from_date)
        {
            $productList= product_master_tbl::orderBy(DB::raw('CAST(id AS UNSIGNED), id'));
            if($request->producttype == true)
            {
                $productList= $productList->where('product_type_master_tbl_id', $request->producttype);
            }
            $productList = $productList->get();
        }

        return view(TRADING_SALE_PURCHASE_PATH.'/stock-report',compact(['productList']));
    }
}
