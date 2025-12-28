@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
    <link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ASSETS_CSS}}jquery-ui.css" />
    <style>
        #mytable_css >tbody>tr>td{
          height:20px;
          padding:1px 2px;
          border-top: 0px;
        }
        #mytable_css >thead>tr>th{
            border-bottom: 1px solid #ccc !important;
        }
        .align_right{
            text-align: right !important;
        }
    </style>
@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
    <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
    <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
    <script src="{{ASSETS_JS}}day_book.js"></script>
    <!-- end of page level js -->
    <script type="text/javascript">
    function printDiv(printRecord){
          var printContents = $('#record').html();
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
    };
    </script>
@endpush

@section('body')

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Sale & Purchase Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Sale & Purchase</li>
        </ol>
    </section>
    <!--section ends-->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet box primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Sale & Purchase
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="{{TRADING_URL_SALE_PURCHASE_REPORT}}" method="get">
                        {{csrf_field()}}
                        <div class="col-md-2">
                            <span>From</span>
                            <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" placeholder="Check-In Date">
                        </div>
                        <div class="col-md-2">
                            <span>To</span>
                            <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}" name="to_date">
                        </div>

                        <div class="col-md-2">
                            <span>Product Type</span>
                            <select name="producttype" class="form-control">
                                <option value="">All</option>
                                @foreach($productstype as $val)
                                <option value="{{$val->id}}" {{@$producttype == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <span>Branch</span>
                            <select name="branch" class="form-control">
                                <option value="">All</option>
                                @foreach($branches as $val)
                                <option value="{{$val->id}}" {{@$branch == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <span>Order By</span>
                            <select name="order_by" class="form-control">
                                <option value="id">Item Code</option>
                                <option value="name">Item Name</option>
                            </select>
                        </div>

                        <div class="col-md-4 align_right">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </form>
                    </div>
                    </div>
                     <!-- Print view                         -->
                        <div class="prnt" id="record">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>
                                {{$company_address->name}}
                            </h3>
                                {{$company_address->address}}
                            <h4>


                      Sale & Purchase Report from
                                {{date('d-M-Y',strtotime($from_date))}}
                                to
                                {{date('d-M-Y',strtotime($to_date))}}
                            </h4>
                        </div>
                    </div>
                    <div class="table-scrollable">

                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">ITEM CODE</th>
                                    <th rowspan="2">ITEM NAME</th>
                                    <th colspan="3">OPENING</th>
                                    <th colspan="2">PURCHASE</th>
                                    <th rowspan="2">TOTAL</th>
                                    <th colspan="2">SALE</th>
                                    <th colspan="3">CLOSING STOCK</th>
                                </tr>
                                <tr>
                                    <th>RATE</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                    <th>RATE</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
@php
$openTotalAmt = 0;
$purchaseTotalAmt = 0;
$saleTotalAmt = 0;
$closingTotalAmt = 0;
@endphp
                              @foreach($productList as $list)
@php
// Purchase Data

    $Purchase = PurchaseDetailByProductId($from_date,$to_date,$list->id,$branch);

    $PurchaseOpeningQuantity = $Purchase['PurchaseOpeningQuantity'];
    $PurchaseQuantity = $Purchase['PurchaseQuantity'];
    $PurchaseAmount = $Purchase['PurchaseAmountSum'];
// Sale Data
    $Sale = SaleDetailByProductId($from_date,$to_date,$list->id,$branch);

    $SaleOpeningQuantity = $Sale['SaleOpeningQuantity'];
    $SaleQuantity = $Sale['SaleQuantity'];
    $SaleAmountSum = $Sale['SaleAmountSum'];

$lastPurchaseDate = App\purchase_detail_tbl::orderBy('date_of_transaction','desc')->where('date_of_transaction','<=',$from_date)->where('product_master_tbl_id',$list->id);
if($branch)
{
$lastPurchaseDate->where('branch_model_id',$branch);
}
$lastPurchaseDate = $lastPurchaseDate->first();

$firstPurchaseDate = App\purchase_detail_tbl::orderBy('date_of_transaction','desc')->where('date_of_transaction','<=',$to_date)->where('product_master_tbl_id',$list->id);

if($branch)
{
$firstPurchaseDate->where('branch_model_id',$branch);
}
$firstPurchaseDate = $firstPurchaseDate->first();

$openQty = $PurchaseOpeningQuantity - $SaleOpeningQuantity;

$closeQty = ((($PurchaseOpeningQuantity - $SaleOpeningQuantity) + $PurchaseQuantity) - $SaleQuantity);

$openingAmt = @$lastPurchaseDate->rate * $openQty;
$purchaseAmt = $PurchaseAmount;
$saleAmt = $SaleAmountSum;
$closingAmt = @$firstPurchaseDate->rate * $closeQty;

$openTotalAmt += $openingAmt;
$purchaseTotalAmt += $purchaseAmt;
$saleTotalAmt += $saleAmt;
$closingTotalAmt += $closingAmt;
@endphp
                                <tr>
                                    <td class="text-right">{{$loop->index + 1}}</td>
                                    <td class="text-right">{{@$list->id}}</td>
                                    <td>{{@$list->name}}</td>
                                    <td class="text-right"> {{number_format( @$lastPurchaseDate->rate,2,'.','')}}</td>
                                    <td class="text-right">{{ number_format($openQty,3,'.','') }}
                                    </td>
                                    <td class="text-right"> {{ number_format($openingAmt,2,'.','') }}</td>
                                    <td class="text-right">{{ number_format($PurchaseQuantity,3,'.','') }}</td>
                                    <td class="text-right"> {{ number_format($purchaseAmt,2,'.','') }} </td>
                                    <td class="text-right">{{ number_format(($openQty + $PurchaseQuantity),3,'.','') }}</td>
                                    <td class="text-right">{{number_format($SaleQuantity,3,'.','')}}</td>
                                    <td class="text-right"> {{ number_format($saleAmt,2,'.','') }}</td>
                                    <td class="text-right">{{number_format(@$firstPurchaseDate->rate,2,'.','')}}</td>
                                    <td class="text-right">{{ number_format($closeQty,3,'.','') }}</td>
                                    <td class="text-right"> {{ number_format($closingAmt,2,'.','') }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th></th>
                                    <th class="text-right" colspan="2">Total</th>

                                    <th></th>
                                    <th></th>
                                    <th class="text-right"> {{ number_format($openTotalAmt,2,'.','') }}</th>
                                    <th></th>
                                    <th class="text-right"> {{ number_format($purchaseTotalAmt,2,'.','') }}</th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right"> {{ number_format($saleTotalAmt,2,'.','') }}</th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right"> {{ number_format($closingTotalAmt,2,'.','') }}</th>
                                </tr>

                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>
</section>
    <!-- content -->
</aside>
<!-- right-side -->
@endsection
