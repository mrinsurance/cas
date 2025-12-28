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
            border-bottom: 0px solid #ccc !important;
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
        <h1>Trading & PL A/C</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Trading & PL A/C</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Trading & PL A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="{{AUDIT_REPORT_URL_TRADING_PL}}" method="get">
                        {{csrf_field()}}
                        <div class="col-md-2">                            
                            <span class="text-dark">From</span>
                            <input type="date" class="form-control" value="{{$from_date ? $from_date : date('Y-m-d')}}" name="from_date" required>                           
                        </div>
                        <div class="col-md-2">
                            <span class="text-dark">To</span>
                            <input type="date" class="form-control" value="{{$to_date ? $to_date : date('Y-m-d')}}" name="to_date" required>
                        </div>
                        <div class="col-md-2">
                            <span class="text-dark">Financial Year</span>
                            <select name="financial_year" class="form-control" required>
                                <option value="">--- Select ---</option>
                                @foreach($session_years as $list)
                                    <option value="{{$list->id}}" {{$financial_year == $list->id ? 'selected' : ''}}>{{date('Y', strtotime($list->start_date))}} - {{date('Y', strtotime($list->end_date))}}</option>
                                @endforeach    
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span class="text-dark">Branch</span>
                            <select name="branch" class="form-control">
                                <option value="">All</option>
                                @foreach($branches as $val)
                                <option value="{{$val->id}}" {{@$branch == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>
                        </div>
                        <div class="col-md-2">
                            <!-- <a href="{{url()->full()}}&p=1">print</a> -->
                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </form>    
                    </div>
                    </div>
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
                                Trading Account From {{date('d-M-Y',strtotime($from_date))}} To {{date('d-M-Y',strtotime($to_date))}}
                            </h4>    
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2" width="50%">CREDIT</th>
                                    <th scope="col" colspan="2">DEBIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICUALR</th>
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
@php
$gl = 0;
$gp = 0;
@endphp

                                                @foreach($crTblLedgers->where('gtype','SALES ACCOUNT') as $drList)
                                                @php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');
                                                  
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach($crTblLedgers->where('gtype','DIRECT INCOME') as $drList)
                                                @php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');
                                                   
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td>CLOSING STOCK</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($closingStock,2)}}</td>
                                                </tr>
                                                @if($drTotal > $crTotal)
                                                @php $gl = ($drTotal - $crTotal); @endphp
                                                <tr>
                                                    <td><strong>GROSS LOSS</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($gl,2)}}</td>
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
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
                                                <tr>
                                                    <td>OPENING STOCK</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($openingStock,2)}}</td>
                                                </tr>
                                               
                                                @foreach($drTblLedgers->where('gtype','PURCHASE ACCOUNT') as $drList)
                                                @php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');
                                                  
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach($drTblLedgers->where('gtype','DIRECT EXPENSES') as $drList)
                                                @php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');
                                                   
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                @if($crTotal > $drTotal)
                                                @php $gp = ($crTotal - $drTotal); @endphp
                                                <tr>
                                                    <td><strong>GROSS PROFIT</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($gp,2)}}</td>
                                                </tr>
                                                @endif                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    @if($drTotal > $crTotal)
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($crTotal + ($drTotal - $crTotal),2)}}</td>
                                    @else
                                        <td class="text-right"  colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($crTotal,2)}}</td>
                                    @endif

                                    @if($crTotal > $drTotal)
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($drTotal + ($crTotal - $drTotal),2)}}</td>
                                    @else
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($drTotal,2)}}</td>
                                    @endif  
                                </tr>
                            </tbody>
                        </table>
                        </div>
<!-- Profit and loss account  -->
@php
$plcrTotal = $plcrTotal + $gp;
$pldrTotal = $pldrTotal + $gl;

$pldrTotal = ($pldrTotal + $npaAmt + $npaIntr + $intrFd + $intrRd);
$plcrTotal = ($plcrTotal + $intrLoan + $intrBankFd + $intrBankRd);

$lbspldrTotal = ($lbsintrLoan + $lbsintrBankFd + $lbsintrBankRd);
$lbsplcrTotal = ($lbsintrFd + $lbsintrRd);

$lbsNpa = ($lbsnpaAmt + $lbsnpaIntr);

$pldrTotal = ($pldrTotal + $lbspldrTotal);
$plcrTotal = ($plcrTotal + $lbsplcrTotal + $lbsNpa);

$intrPaid = ($intrFd + $intrRd + $lbsintrLoan + $lbsintrBankFd + $lbsintrBankRd);
$intrRec = ($intrLoan + $intrBankFd + $intrBankRd + $lbsintrFd + $lbsintrRd);
$intrNpa = 0;
@endphp
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4>
                                Profit & Loss Account From {{date('d-M-Y',strtotime($from_date))}} To {{date('d-M-Y',strtotime($to_date))}}
                            </h4>    
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        
                            
                           <table width="60%" class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2" width="50%">INCOME</th>
                                    <th scope="col" colspan="2">EXPENSES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <table width="60%"  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICUALR</th>
                                                    <th>&nbsp;</th>
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
                                                @if($gp > 0)
                                                <tr>
                                                    <td>GROSS PROFIT</td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($gp,2)}}</td>
                                                </tr>
                                                @endif
                                                @foreach($plcrTblLedgers->where('gtype','INDIRECT INCOME') as $drList)
                                                @php
                                                   $plmHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');
                                                  
                                                @endphp
                                                <tr>
                                                    <td>{{($drList->main_head)}}</td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($plmHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach($plcrTblLedgers->where('gtype','INTEREST RECEIVED') as $drList)
                                                @php
                                                   $plmHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');
                                                   $intrRec = $intrRec + $plmHeadAmt;
                                                @endphp
                                                <tr>
                                                    <td>{{($drList->main_head)}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($plmHeadAmt,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                @endforeach
                                               <tr>
                                                    <td>{{("INTEREST RECOVERABLE ON LOAN")}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrLoan,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>{{("INTEREST RECOVERABLE ON BANK FD")}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrBankFd,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>{{("INTEREST RECOVERABLE ON BANK RD")}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrBankRd,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>{{("INTEREST PAYABLE LBS")}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($lbsplcrTotal,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>{{("INTEREST RECEIVED")}}</strong></td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(($intrRec),2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>NPA LBS</td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($lbsNpa,2)}}</td>
                                                    
                                                </tr>
                                                @if($pldrTotal > $plcrTotal)
                                                <tr>
                                                    <td><strong>NET LOSS</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(($pldrTotal - $plcrTotal),2)}}</td>
                                                    <td>&nbsp;</td>
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
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
                                                @if($gl > 0)
                                                <tr>
                                                    <td>GROSS LOSS</td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($gl,2)}}</td>
                                                </tr>
                                                @endif
                                                
                                               
                                                @foreach($pldrTblLedgers->where('gtype','INDIRECT EXPENSES') as $drList)
                                                @php
                                                   $plmHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');
                                                  
                                                @endphp
                                                <tr>
                                                    <td>{{($drList->main_head)}}</td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($plmHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach

                                                @foreach($pldrTblLedgers->where('gtype','INTEREST PAID') as $drList)
                                                @php
                                                   $plmHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');
                                                   $intrPaid = $intrPaid + $plmHeadAmt;
                                                @endphp
                                                
                                                <tr>
                                                    <td>{{($drList->main_head)}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($plmHeadAmt,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                @endforeach
                                                
                                                <tr>
                                                    <td>{{("INTEREST PAYBLE ON FD")}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrFd,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>{{("INTEREST PAYBLE ON RD")}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrRd,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>{{("INTEREST RECOVERABLE LBS")}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($lbspldrTotal,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>INTEREST PAID</strong></td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(($intrPaid),2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>NPA AMOUNT</td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($npaAmt,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>NPA INTEREST</td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($npaIntr,2)}}</td>
                                                </tr>

                                                @if($plcrTotal > $pldrTotal)
                                                <tr>
                                                    <td><strong>NET PROFIT</strong></td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(($plcrTotal - $pldrTotal),2)}}</td>
                                                </tr>
                                                @endif                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    @if($pldrTotal > $plcrTotal)
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($plcrTotal + ($pldrTotal - $plcrTotal),2)}}</td>
                                    @else
                                        <td class="text-right"  colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($plcrTotal,2)}}</td>
                                    @endif

                                    @if($plcrTotal > $pldrTotal)
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($pldrTotal + ($plcrTotal - $pldrTotal),2)}}</td>
                                    @else
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($pldrTotal,2)}}</td>
                                    @endif  
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