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
    <script src="{{ASSETS_JS}}day_book.js"></script></script>
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
                    <form class="form-horizontal" action="" method="get">
                        {{csrf_field()}}
                        <input type="hidden" value="{{ route('purchase.product.get.name') }}" id="getProduct">
                        <div class="col-md-2">
                            <span>From</span>
                            <input type="date" class="form-control" value="{{ request()->get('from') ? request()->get('from') : \Carbon\Carbon::now()->format('Y-m-d') }}" name="from" placeholder="Check-In Date">
                        </div>
                        <div class="col-md-2">
                            <span>To</span>
                            <input type="date" class="form-control" value="{{ request()->get('to') ? request()->get('to') : \Carbon\Carbon::now()->format('Y-m-d') }}" name="to">
                        </div>

                        <div class="col-md-2">
                            <span>Product Type</span>
                            <select name="product_party" class="form-control">
                                <option value="">All</option>
                                @foreach(GetMasterOfProductType() as $val)
                                <option value="{{$val->id}}" {{ request()->get('product_party') == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>Item Name</span>
                            <select name="product_name" class="form-control select2">
                                <option value="">All</option>
                                @foreach($productList as $list)
                                <option value="{{$list->id}}" {{ request()->get('product_name') == $list->id ? 'selected' : ''}}>{{$list->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>Branch</span>
                            <select name="branch" class="form-control">
                                <option value="">All</option>
                                @foreach(SocietyBranch() as $val)
                                <option value="{{$val->id}}" {{ request()->get('branch') == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                @endforeach
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
                                {{CompanyAddress()->name}}
                            </h3>
                                {{CompanyAddress()->address}}
                            <h4>
                            Item Ledger Report of  
                            @foreach($productList as $list)
                                {{ request()->get('product_name') == $list->id ? $list->name : ''}}
                            @endforeach 
                            from
                                {{ $from }}
                                to
                                {{ $to }}
                            </h4>
                        </div>
                    </div>
                    <div class="table-scrollable">
                        
                        
<table class="table table-bordered table-hover" id="mytable_css">
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">DATE</th>
            <th colspan="2">OPENING STOCK</th>
            <th colspan="2">PURCHASE</th>
            <th colspan="2">SALE</th>
            <th rowspan="2">BALANCE</th>
        </tr>
        <tr>
            <th>Qty</th>
            <th>AMOUNT</th>
            <th>QTY</th>
            <th>AMOUNT</th>
            <th>QTY</th>
            <th>AMOUNT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-right">0</td>
            <td>Opening Stock</td>
            <td class="text-right"> {{ number_format($sumOfOpenQuantity,3) }}</td>
            <td>0</td>
            <td colspan="4"></td>
            <td class="text-right"> {{ number_format($sumOfOpenQuantity,3) }}</td>
        </tr>

        @php
            $balanceQty = $sumOfOpenQuantity;
            $balanceAmount = 0; // Adjust if you have an initial amount
        @endphp

        @foreach($ledgerDate as $list)
            @php
                $isPurchase = !empty($list->purchase_quantity);
                $isSale = !empty($list->sale_quantity);

                if ($isPurchase) {
                    $balanceQty += $list->purchase_quantity;
                    $balanceAmount += $list->purchase_amount;
                }

                if ($isSale) {
                    $balanceQty -= $list->sale_quantity;
                    $balanceAmount -= $list->sale_amount;
                }
            @endphp

            <tr>
                <td class="text-right">{{ $loop->index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($list->date_of_transaction)->format('d-M-Y') }}</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
                <td class="text-right">{{ number_format($list->purchase_quantity,3) ?? 0 }}</td>
                <td class="text-right">{{ number_format($list->purchase_amount,2) ?? 0.00 }}</td>
                <td class="text-right">{{ number_format($list->sale_quantity,3) ?? 0 }}</td>
                <td class="text-right">{{ number_format($list->sale_amount,2) ?? 0.00 }}</td>
                <td class="text-right">{{ number_format($balanceQty,3) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

    
    
                            {{--<table class="table table-bordered table-hover" id="mytable_css">
                             <thead>
                                 <tr>
                                     <th rowspan="2">#</th>
    
                                     <th rowspan="2">DATE</th>
                                     <th colspan="2">OPENING STOCK</th>
                                     <th colspan="2">PURCHASE</th>
                                     <th colspan="2">SALE</th>
                                     <th rowspan="2">BALANCE</th>
                                 </tr>
                                 <tr>
                                     <th>Qty</th>
                                     <th>AMOUNT</th>
                                     <th>QTY</th>
                                     <th>AMOUNT</th>
                                     <th>QTY</th>
                                     <th>AMOUNT</th>
                                 </tr>
    
                                 @php
                                     $TradingSalePurchase = TradingPurchaseDetailByProductId(request()->get('from_date'),request()->get('to_date'),request()->get('product'),request()->get('branch'));
                                 @endphp
    
                             </thead>
                             <tbody>
                             <tr>
                                 <td class="text-right"></td>
                                 <td></td>
                                 <td>{{ $sumOfOpenQuantity }}</td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
    
                             </tr>
    
                                 @foreach($ledgerDate as $list)
                                     <tr>
                                         <td class="text-right">{{ $loop->index + 1 }}</td>
                                         <td>{{ \Carbon\Carbon::parse($list->date_of_transaction)->format('d-M-Y') }}</td>
                                         <td class="text-right"></td>
                                         <td class="text-right"></td>
                                         <td class="text-right">{{ $list->purchase_quantity ?? 0 }}</td>
                                         <td class="text-right">{{ $list->purchase_amount ?? 0.00 }}</td>
                                         <td class="text-right">{{ $list->sale_quantity ?? 0 }}</td>
                                         <td class="text-right">{{ $list->sale_amount ?? 0.00 }}</td>
                                         <td class="text-right"></td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>--}}
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
