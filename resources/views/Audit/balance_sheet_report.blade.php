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
          height:auto;
          padding:1px 2px;
          border-top: 0px;
          line-height: 1.20 !important;
        }
        #mytable_css >thead>tr>th{
            border-bottom: 1px solid #ccc !important;
            padding: 3px 5px !important;
            line-height: 1.20 !important;
        }
        .text-right{
            text-align: right !important;
        }
        .border-left-0{
            border-left: 0px !important;
        }
        .border-right-0{
            border-right: 0px !important;
        }
        @media print {
            .border-left-0{
                border-left: 0px !important;
            }
            .printme, .printme * {
                visibility: visible;
            }
            .printme {
                position: absolute;
                left: 0;
                top: 0;
            }
            .printme, .printme:last-child {
                page-break-after: avoid;
            }

            .display-none-on, .display-none-on * {
                display: none !important;
            }
            html, body {
                height: auto;
                font-size: 7pt; /* changing to 10pt has no impact */
            }
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
        <h1>Balance Sheet</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">RD</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Sheet
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="{{AUDIT_REPORT_URL_BALANCE_SHEET}}" method="get">
                        {{csrf_field()}}
                        <div class="col-md-2">
                            <span>Financial Year</span>
                            <select name="financial_year" class="form-control" required>
                                <option value="">--- Select ---</option>
                                @foreach($session_years as $list)
                                    <option value="{{$list->id}}" {{request()->financial_year == $list->id ? 'selected' : ''}}>{{date('Y', strtotime($list->start_date))}} - {{date('Y', strtotime($list->end_date))}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>As On</span>
                            <input type="date" class="form-control" value="{{request()->date ? request()->date : date('Y-m-d')}}" name="date" placeholder="Check-In Date">
                        </div>
                        <div class="col-md-2">
                            <span>Branch</span>
                            <select name="branch" class="form-control">
                                <option value="">All</option>
                                @foreach($branches as $val)
                                <option value="{{$val->id}}" {{request()->branch == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>


                            <!-- <a href="{{AUDIT_REPORT_URL_BALANCE_SHEET.'pdf/'.request()->date.'/'.request()->financial_year.'/'.request()->branch}}" class="btn btn-danger btn_sizes"><i class="fa fa-fw fa-print"></i> PDF</a> -->


                        </div>
                    </form>
                    </div>
                    </div>
                     <!-- Print view                         -->
                        <div class="prnt print printme" id="record">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>
                                {{$company_address->name}}
                            </h3>
                            <h5>
                                {{$company_address->address}}
                            </h5>
                            <h4>
                                Balance Sheet As On {{date('d-M-Y',strtotime(request()->date))}}
                            </h4>
                        </div>
                    </div>
<!-- Table start -->
                    <div class="table-scrollable">
                        <!-- Print view                         -->


                           <table width="100%" class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2" width="50%">LIABILITIES</th>
                                    <th scope="col" colspan="2">ASSETS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <table width="100%"  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICULAR</th>
                                                    <th>&nbsp;</th>
                                                    <th class="text-right">AMOUNT ( <i class="fa fa-inr"></i> )</th>
                                                </tr>
@php
 $Total = 0;
 $AssetTotal = 0;
@endphp

@foreach($tblLedgers as $list)
@php
    $balHeadTotalCr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
    ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
    ->whereNotNull('bal_sheet_head_model_id')
    ->where('type_of_transaction','Cr')
    ->where('date_of_transaction','<=',request()->date)
    ->sum('amount');

    $balHeadTotalDr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
        ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
        ->whereNotNull('bal_sheet_head_model_id')
        ->where('type_of_transaction','Dr')
        ->where('date_of_transaction','<=',request()->date)
        ->sum('amount');
    $balHeadAmt =  $balHeadTotalCr - $balHeadTotalDr;

@endphp
@if($balHeadAmt > 0)
<tr>
    <th>{{@$list->bal_sheet_head_model->name}}</th>
    <th></th>
    <th class="text-right">{{number_format($balHeadAmt,2)}}</th>
</tr>
    @php
    $Total += $balHeadAmt;
        $mainHeadGroup = App\tbl_ledger_model::select('id','main_head','bal_sheet_head_model_id')
        ->where('bal_sheet_head_model_id',$list->bal_sheet_head_model_id)
        ->groupBy('main_head')
        ->where('date_of_transaction','<=',request()->date)
        ->get();
    @endphp
   @foreach($mainHeadGroup as $groupName)
   @php
        $tblLedgersCr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
        ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
        ->where('date_of_transaction','<=',request()->date)
        ->where('main_head',$groupName->main_head)
        ->where('type_of_transaction','Cr')
        ->sum('amount');

        $tblLedgersDr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
            ->where('date_of_transaction','<=',request()->date)
            ->where('main_head',$groupName->main_head)
            ->where('type_of_transaction','Dr')
            ->sum('amount');
        $Amt =  $tblLedgersCr - $tblLedgersDr;
   @endphp
       @if($Amt)
            <tr>
                <td>{{$groupName->main_head}}</td>
                <td class="text-right">{{number_format($Amt,2)}}</td>
                <td></td>
            </tr>
        @endif
    @endforeach
@endif
@endforeach
<!-- PAYABLE INTEREST -->
@if(@$yearEndTblData->int_payble_fd || $yearEndTblData->int_payble_rd)
<tr>
    <th>PAYABLE INTEREST</th>
    <th></th>
    <th class="text-right">{{number_format((@$yearEndTblData->int_payble_fd + @$yearEndTblData->int_payble_rd),2)}}</th>
</tr>
@endif
@if(@$yearEndTblData->int_payble_fd)
<tr>
    <td>INTEREST PAYABLE ON FD</td>
    <td class="text-right">{{number_format(@$yearEndTblData->int_payble_fd,2)}}</td>
    <td></td>
</tr>
@endif
@if($yearEndTblData->int_payble_rd)
<tr>
    <td>INTEREST PAYABLE ON RD</td>
    <td class="text-right">{{number_format(@$yearEndTblData->int_payble_rd,2)}}</td>
    <td></td>
</tr>
@endif
<!-- NPA -->
@if($yearEndTblData->npa_amount || $yearEndTblData->npa_int)
<tr>
    <th>NPA</th>
    <th></th>
    <th class="text-right">{{number_format((@$yearEndTblData->npa_amount + @$yearEndTblData->npa_int),2)}}</th>
</tr>
@endif
@if($yearEndTblData->npa_amount)
<tr>
    <td>NPA PRINCIPAL</td>
    <td class="text-right">{{number_format(@$yearEndTblData->npa_amount,2)}}</td>
    <td></td>
</tr>
@endif
@if($yearEndTblData->npa_int)
<tr>
    <td>NPA INTEREST</td>
    <td class="text-right">{{number_format(@$yearEndTblData->npa_int,2)}}</td>
    <td></td>
</tr>
@endif
<!-- PROFIT -->
@if($yearEndTblData->net_profit || $lastYrProfit)
<tr>
    <th>PROFIT</th>
    <th></th>
    <th class="text-right">{{number_format((@$yearEndTblData->net_profit + @$lastYrProfit),2)}}</th>
</tr>
@endif
@if($lastYrProfit)
<tr>
    <td>LAST YEAR PROFIT</td>
    <td class="text-right">{{number_format(@$lastYrProfit,2)}}</td>
    <td></td>
</tr>
@endif
@if($yearEndTblData->net_profit)
<tr>
    <td>CURRENT YEAR PROFIT</td>
    <td class="text-right">{{number_format(@$yearEndTblData->net_profit,2)}}</td>
    <td></td>
</tr>
@endif



                                            </tbody>
                                        </table>
                                    </td>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICULAR</th>
                                                    <th>&nbsp;</th>
                                                    <th class="text-right">AMOUNT ( <i class="fa fa-inr"></i> )</th>
                                                </tr>
@foreach($tblLedgers as $list)
@php
    $balHeadTotalCr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
    ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
    ->whereNotNull('bal_sheet_head_model_id')
    ->where('bal_sheet_head_model_id','!=',0)
    ->where('type_of_transaction','Cr')
    ->where('date_of_transaction','<=',request()->date)
    ->sum('amount');

    $balHeadTotalDr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
        ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
        ->whereNotNull('bal_sheet_head_model_id')
        ->where('bal_sheet_head_model_id','!=',0)
        ->where('type_of_transaction','Dr')
        ->where('date_of_transaction','<=',request()->date)
        ->sum('amount');
    $balHeadAmt =  $balHeadTotalCr - $balHeadTotalDr;

@endphp
@if($balHeadAmt < 0)
@php
        $AssetTotal += ($balHeadAmt * -1);
       @endphp
<tr>
    <th>{{@$list->bal_sheet_head_model->name}}</th>
    <th></th>
    <th class="text-right">{{number_format($balHeadAmt * -1,2)}}</th>
</tr>
    @php
        $mainHeadGroup = App\tbl_ledger_model::select('id','main_head','bal_sheet_head_model_id')
        ->where('bal_sheet_head_model_id',$list->bal_sheet_head_model_id)
        ->groupBy('main_head')
        ->where('date_of_transaction','<=',request()->date)
        ->get();
    @endphp
   @foreach($mainHeadGroup as $groupName)
   @php
        $tblLedgersCr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
        ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
        ->where('date_of_transaction','<=',request()->date)
        ->where('main_head',$groupName->main_head)
        ->where('type_of_transaction','Cr')
        ->sum('amount');

        $tblLedgersDr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
            ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
            ->where('date_of_transaction','<=',request()->date)
            ->where('main_head',$groupName->main_head)
            ->where('type_of_transaction','Dr')
            ->sum('amount');
        $Amt =  $tblLedgersCr - $tblLedgersDr;
   @endphp
       @if($Amt)
            <tr>
                <td>{{$groupName->main_head}}</td>
                <td class="text-right">{{number_format($Amt * -1,2)}}</td>
                <td></td>
            </tr>
        @endif
    @endforeach
@endif
@endforeach
@if($yearEndTblData->int_recover_loan || $yearEndTblData->int_recover_bank_fd || $yearEndTblData->int_recover_bank_rd)
<tr>
    <th>RECOVERABLE INTEREST</th>
    <th></th>
    <th class="text-right">{{number_format((@$yearEndTblData->int_recover_loan + @$yearEndTblData->int_recover_bank_fd + @$yearEndTblData->int_recover_bank_rd),2)}}</th>
</tr>
@endif
                                                @if($yearEndTblData->int_recover_loan)
                                                <tr>
                                                    <td>INTEREST RECOVERABLE ON LOAN</td>
                                                    <td class="text-right">{{number_format(@$yearEndTblData->int_recover_loan,2)}}</td>
                                                    <td></td>
                                                </tr>
                                                @endif
                                                @if($yearEndTblData->int_recover_bank_fd)
                                                <tr>
                                                    <td>INTEREST RECOVERABLE ON BANK FD</td>
                                                    <td class="text-right">{{number_format(@$yearEndTblData->int_recover_bank_fd,2)}}</td>
                                                    <td></td>
                                                </tr>
                                                @endif
                                                @if($yearEndTblData->int_recover_bank_rd)
                                                <tr>
                                                    <td>INTEREST RECOVERABLE ON BANK RD</td>
                                                    <td class="text-right">{{number_format(@$yearEndTblData->int_recover_bank_rd,2)}}</td>
                                                    <td></td>
                                                </tr>
                                                @endif
                                                @if($yearEndTblData->closing_stock_depot1 || $yearEndTblData->closing_stock_depot2 || $yearEndTblData->closing_stock_depot3)
                                                <tr>
                                                    <th>CLOSING STOCK</th>
                                                    <td class="text-right">{{number_format((@$yearEndTblData->closing_stock_depot1 + @$yearEndTblData->closing_stock_depot2 + @$yearEndTblData->closing_stock_depot3),2)}}</td>
                                                    <th class="text-right">{{number_format((@$yearEndTblData->closing_stock_depot1 + @$yearEndTblData->closing_stock_depot2 + @$yearEndTblData->closing_stock_depot3),2)}}</th>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th scope="col" class="border-right-0">TOTAL:</th>
                                    <th scope="col" class="text-right border-left-0">{{number_format((@$yearEndTblData->int_payble_fd + @$yearEndTblData->int_payble_rd +
@$yearEndTblData->npa_amount + @$yearEndTblData->npa_int +
@$yearEndTblData->net_profit + @$lastYrProfit +
@$Total),2)}} </th>
<th scope="col" class="border-right-0">TOTAL:</th>
                                    <th scope="col" class="text-right border-left-0">{{number_format(($AssetTotal +
@$yearEndTblData->int_recover_loan + @$yearEndTblData->int_recover_bank_fd + @$yearEndTblData->int_recover_bank_rd +
@$yearEndTblData->closing_stock_depot1 + @$yearEndTblData->closing_stock_depot2 + @$yearEndTblData->closing_stock_depot3),2)}} </th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                            <div class="row">
                                <div class="col-12">
                                    <p>
                                        It is certified that I have audited the Accounts of {{$company_address->name}}, for the year ended {{ \Carbon\Carbon::parse(request()->date)->format('d-M-Y') }} and its Balance Sheet on same date as per relevant record & information produced before by the secretary. In my opinion as per best of my knowledge & belief the above balance sheet depicts true & fair financial view of the society subject to my separate report even attached.
                                    </p>
                                </div>
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