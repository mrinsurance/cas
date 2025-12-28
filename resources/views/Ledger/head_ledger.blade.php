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
        <h1>Ledger Account Report</h1>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Ledger Account Report
                    </div>
                </div>
                <div class="portlet-body">
                   
                    <form class="form-horizontal" action="{{LEDGER_REPORT_URL_HEAD_LEDGER}}" method="get">
                        {{csrf_field()}}
                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">From</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" id="from_date" placeholder="Check-In Date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">To</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}" name="to_date" id="to_date" placeholder="Check-In Date">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Sub Group</label>
                            <div class="col-md-8">
                                <select name="subgroup" class="form-control">
                                    @foreach($subgroups as $val)
                                    <option value="{{$val->id}}" {{@$subgroup == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Without Opening</label>
                            <div class="col-md-8">
                                <input type="checkbox" name="wtopen" value="1" {{ request()->get('wtopen') == true ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12 col-md-offset-5">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </div>
                    </div>
                    </form>    
                    
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        <div class="prnt" id="record">
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="6">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h5>
                                                LEDGER REPORT OF {{$subname->name}} 
                                            <br>
                                                FROM {{date('d-M-Y',strtotime($from_date))}} To  {{date('d-M-Y',strtotime($to_date))}}
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Particular</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
@php
    $i = 1;
    $opnbalcr = 0;
    $opnbaldr = 0;
    $totalDr = 0;
    $totalCr = 0;
    $totalbal = 0;

@endphp
@if(request()->get('wtopen') == false)
    @php
      $totalbal = $opening;
@endphp
<tr>
    <td>{{$i++}}</td>
    <td>{{date('d-m-Y',strtotime($from_date))}}</td>
    <td>{{'OPENING'}}</td>
    @if($opening >= 0)
        @php
            $opnbalcr=$opening;
        @endphp
        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($opening,2)}}</strong></td>
        <td class="align_right"><i class="fa fa-inr"></i> {{number_format(0,2)}}</td>
        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($opening,2)}}{{'Cr'}}</strong></td>
    @endif
    @if($opening < 0)
        @php
            $opnbaldr=$opening*-1;
        @endphp
        <td class="align_right"><i class="fa fa-inr"></i> {{number_format(0,2)}}</td>
        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($opnbaldr,2)}}</strong></td>
        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($opening*-1,2)}}{{'Dr'}}</strong></td>
    @endif
</tr>
@else
    @php
    $opnbalcr = 0;
    $opnbaldr = 0;
    $totalbal = 0;
    @endphp
@endif
<!-- $totalbal -->

                                @foreach($tblLedgers as $mainHead)
<!-- @php
 $crSum = \App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
->where('main_head',$mainHead->main_head)
->where('type_of_transaction','Cr')
->whereBetween('date_of_transaction',[$from_date,$to_date])
->sum('amount');

 $drSum = \App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
->where('main_head',$mainHead->main_head)
->where('type_of_transaction','Dr')
->whereBetween('date_of_transaction',[$from_date,$to_date])
->sum('amount');

@endphp   -->                              
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{date('d-m-Y',strtotime($mainHead->date_of_transaction))}}</td>
                                    <td>{{$mainHead->particular.' - '.$mainHead->account_no}}</td>
                                    @if($mainHead->type_of_transaction=='Cr')
                                    
                                       <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mainHead->amount,2)}}</td>
                                       <td class="align_right"><i class="fa fa-inr"></i> {{number_format(0,2)}}</td>
                                    @php
                                    $totalbal=$totalbal+$mainHead->amount;
                                    $totalCr=$totalCr+$mainHead->amount
                                    @endphp
                                    @endif

                                    @if($mainHead->type_of_transaction=='Dr')
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(0,2)}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mainHead->amount,2)}}</td>
                                    @php
                                    $totalbal=$totalbal-$mainHead->amount;
                                    $totalDr=$totalDr+$mainHead->amount;
                                    @endphp
                                    @endif

                                    @if($totalbal>0)
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($totalbal,2)}}{{'Cr'}}</td>
                                    @endif
                                    @if($totalbal<0)
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($totalbal*-1,2)}}{{'Dr'}}</td>
                                    @endif

                                </tr>

                                @endforeach
<!-- total without opening --><tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{'TOTAL WITHOUT OPENING'}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($totalCr,2)}}</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($totalDr,2)}}</strong></td>
                                    <td></td>
                                </tr>       
 <!-- total with opening -->        
                                    <td></td>
                                    <td></td>
                                    <td>{{'TOTAL WITH OPENING'}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($totalCr+$opnbalcr,2)}}</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($totalDr+$opnbaldr,2)}}</strong></td>
                                    @if(($totalCr+$opnbalcr)-($totalDr+$opnbaldr)>0)
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format(($totalCr+$opnbalcr)-($totalDr+$opnbaldr),2)}}{{'Cr'}}</strong></td>
                                    @endif @if(($totalCr+$opnbalcr)-($totalDr+$opnbaldr)<0)
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format((($totalCr+$opnbalcr)-($totalDr+$opnbaldr))*-1,2)}}{{'Dr'}}</strong></td>
                                    @endif
                                    
                                    
                                    
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