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
                        <div class="col-md-6 align_right">
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
                                                    <th>PARTICUALR</th>
                                                    <th>&nbsp;</th>
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
                                               
@foreach($tblLedgers as $list)
@php

$balHead = App\subgroup_master_model::where('name',$list->main_head)->first();             
$tblLedgersCr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
    ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED'])  
    ->where('date_of_transaction','<=',request()->date)
    ->where('main_head',$list->main_head)
    ->where('type_of_transaction','Cr')
    ->sum('amount');
$tblLedgersDr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
    ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED'])  
    ->where('date_of_transaction','<=',request()->date)
    ->where('main_head',$list->main_head)
    ->where('type_of_transaction','Dr')
    ->sum('amount');
$Amt = $tblLedgersCr - $tblLedgersDr;

$balHeadTotal = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')->where('bal_sheet_head_model_id',@$balHead->bal_sheet_head_model_id)->whereNotNull('bal_sheet_head_model_id')->sum('amount'); 

@endphp                                        
@if($Amt > 0) 
<tr>
    <td>{{$list->main_head}}</td>
    <td class="align_right">{{$Amt}}</td>
    <td>{{$balHeadTotal}}</td>
</tr> 

@endif                                                                                            
@endforeach
<tr>
    <td>INTEREST PAYABLE ON FD</td>
    <td class="align_right">{{@$yearEndTblData->int_payble_fd}}</td>
    <td></td>
</tr> 
<tr>
    <td>INTEREST PAYABLE ON RD</td>
    <td class="align_right">{{@$yearEndTblData->int_payble_rd}}</td>
    <td></td>
</tr> 
<tr>
    <td>NPA PRINCIPAL</td>
    <td class="align_right">{{@$yearEndTblData->npa_amount}}</td>
    <td></td>
</tr>   
<tr>
    <td>NPA INTEREST</td>
    <td class="align_right">{{@$yearEndTblData->npa_int}}</td>
    <td></td>
</tr> 
<tr>
    <td>LAST YEAR PROFIT</td>
    <td class="align_right">{{@$yearEndTblData->net_profit}}</td>
    <td></td>
</tr> <tr>
    <td>CURRENT YEAR PROFIT</td>
    <td class="align_right">{{@$yearEndTblData->net_profit}}</td>
    <td></td>
</tr>      

                                               
                                            </tbody>
                                        </table>
                                    </td>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICULAR</th>
                                                    <th>&nbsp;</th>
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
                                                @foreach($tblLedgers as $list)
@php                                                     
$tblLedgersCr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
    ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED'])  
    ->where('date_of_transaction','<=',request()->date)
    ->where('main_head',$list->main_head)
    ->where('type_of_transaction','Cr')
    ->sum('amount');
$tblLedgersDr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
    ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED'])  
    ->where('date_of_transaction','<=',request()->date)
    ->where('main_head',$list->main_head)
    ->where('type_of_transaction','Dr')
    ->sum('amount');
$Amt = $tblLedgersCr - $tblLedgersDr;  
@endphp                                        
@if($Amt < 0)    
                                                <tr>
                                                    <td>{{$list->main_head}}</td>
                                                    <td class="align_right">{{$Amt * -1}}</td>
                                                    <td>{{$tblLedgers->sum('amount')}}</td>
                                                </tr> 
@endif                                                                                            
                                                @endforeach 
                                               
                                                <tr>
                                                    <td>INTEREST RECOVERABLE ON LOAN</td>
                                                    <td class="align_right">{{@$yearEndTblData->int_recover_loan}}</td>
                                                    <td></td>
                                                </tr> 
                                                <tr>
                                                    <td>INTEREST RECOVERABLE ON BANK FD</td>
                                                    <td class="align_right">{{@$yearEndTblData->int_recover_bank_fd}}</td>
                                                    <td></td>
                                                </tr> 
                                                <tr>
                                                    <td>INTEREST RECOVERABLE ON BANK RD</td>
                                                    <td class="align_right">{{@$yearEndTblData->int_recover_bank_rd}}</td>
                                                    <td></td>
                                                </tr>   
                                                <tr>
                                                    <td>CLOSING STOCK</td>
                                                    <td class="align_right">{{@$yearEndTblData->closing_stock_depot1 + @$yearEndTblData->closing_stock_depot2 + @$yearEndTblData->closing_stock_depot3}}</td>
                                                    <td></td>
                                                </tr>                                  
                                               
                                            </tbody>
                                        </table>
                                    </td>
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