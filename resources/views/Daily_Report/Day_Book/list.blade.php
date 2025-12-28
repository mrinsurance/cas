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
         table.report-container
        {
            page-break-after: always;
        }
        thead.report-header{
            display: table-header-group;
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
@endpush

@section('body')

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Day Book</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Day Book</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <form class="form-horizontal" action="{{DAILY_REPORT_URL_DAY_BOOK}}" method="get">
                        {{csrf_field()}}
                        <fieldset>
                            <!-- Name input-->
                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="email">From</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i>
                                                </div>
                                                <input type="date" name="from_date" class="form-control"  value="{{old(date('Y-m-d'),@$from_date)}}">

                                                <!-- <input class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" id="from_date" placeholder="Check-In Date" readonly> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-md-offset-1">
                                    <div class="form-group">
                                       <button class="btn btn-danger" name="pre" value="next"> < Previous</button>
                                       <button class="btn btn-success" name="next" value="next">Next ></button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="email">To</label>
                                        <div class="col-md-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i>
                                            </div>
                                            <input type="date" name="to_date" class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}">

                                            <!-- <input class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}" name="to_date" id="to_date" placeholder="Check Out Date" readonly> -->
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12 text-left">

                                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                                            <a href="{{url('daily-report/day-book/print-pdf/'.old(date('Y-m-d'),@$from_date).'/'.old(date('Y-m-d'),@$to_date))}}" target="_blank" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="portlet-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered report-container">
                                <thead>
                                    <tr class="bg-grey">
                                        <th>
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Receipt
                                                </div>
                                            </div>
                                        </th>
                                        <!-- <th>Type</th> -->
                                        <th>
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Payment
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="table table-bordered report-container">
                                <thead>
                                    <tr class="bg-grey">
                                        <th>Date</th>
                                        <!-- <th>Type</th> -->
                                        <th>A/C No</th>
                                        <th>Particular</th>
                                        <th>Amount</th>
                                        <th>Total </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{date('d-m',strtotime(@$from_date))}}</td>
                                        <td colspan="3">Opening Cash In Hand</td>
                                        <td class="text-danger must-right"><i class="fa fa-inr"></i> {{number_format($opening_cash_in_hand,2)}}</td>
                                    </tr>
                                    @php
                                        $bal = 0;
                                        $receipt_total = 0;
                                        $payment_total = 0;
                                    @endphp

                                    @foreach($gtype_groups as $group)
                                    <tr>
                                        <td colspan="6"><strong>{{$group->gtype}}</strong></td>
                                    </tr>
                                    @php
                                        $total = 0;
                                        $i = 0;
                                    @endphp

                                    @foreach($stypes->whereIn('gtype',[$group->gtype,strtoupper($group->gtype)])->where('type_of_transaction','Cr') as $stype)
                                    @php
                                        $i++;
                                        $total += $stype->amount;
                                        $x = count($stypes->whereIn('gtype',[$group->gtype,strtoupper($group->gtype)])->where('type_of_transaction','Cr'));
                                        $bal += $stype->amount;
                                    @endphp
                                    <tr>
                                        <td>{{date('d-m',strtotime($stype->date_of_transaction))}}</td>
                                        <!-- <td>{{$stype->entry_type}}</td> -->
                                        <td>{{$stype->account_no}}</td>
                                        <!-- str_limit($string, $limit = 150, $end = '...') -->
                                        <!-- <td>{{wordwrap($stype->particular,15)}}</td> -->
                                        <td>{{str_limit($stype->particular,$limit=100,$end = '...')}}</td>
                                        <td class=" must-right"><i class="fa fa-inr"></i> {{number_format($stype->amount,2)}}</td>
                                        <td class="@if($i == $x) text-danger must-right @endif"> @if($i == $x) <i class="fa fa-inr"></i> {{number_format($total,2)}} @endif</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                    @php
                                        $receipt_total = ($bal + $opening_cash_in_hand);
                                    @endphp
                                </tbody>
                            </table>
                                        </td>
                                        <td>
                                            <table class="table table-bordered report-container">
                                <thead>
                                    <tr class="bg-grey">
                                        <th>Date</th>
                                        <!-- <th>Type</th> -->
                                        <th>A/C No</th>
                                        <th>Particular</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $bal = 0; @endphp
<!-- Group type loop                                     -->
                                    @foreach($payment_gtype_groups as $group)
                                    <tr>
                                        <td colspan="6"><strong>{{$group->gtype}}</strong></td>
                                    </tr>
                                    @php $total = 0; $i = 0; $x = 0; @endphp
<!-- Subgroup type loop                                     -->
                                    @foreach($payment_stypes->whereIn('gtype',[$group->gtype,strtoupper($group->gtype)])->where('type_of_transaction','Dr') as $stype)
                                    @php
                                    $i++;
                                    $total += $stype->amount;

                                    $x = count($payment_stypes->whereIn('gtype',[$group->gtype,strtoupper($group->gtype)])->where('type_of_transaction','Dr'));
                                    $bal += $stype->amount;
                                    @endphp
                                    <tr>
                                        <td>{{date('d-m',strtotime($stype->date_of_transaction))}}</td>
                                        <!-- <td>{{$stype->entry_type}}</td> -->
                                        <td>{{$stype->account_no}}</td>
                                        <td>{{str_limit($stype->particular,$limit=100,$end = '...')}}</td>
                                        <td class=" must-right"><i class="fa fa-inr"></i> {{number_format($stype->amount,2)}}</td>
                                        <td class="@if($i == $x) text-danger must-right @endif"> @if($i == $x) <i class="fa fa-inr"></i> {{number_format($total,2)}} @endif</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                    @php $payment_total = $bal; @endphp

                                </tbody>
                            </table>
                                        </td>
                                    </tr>
                                    <tr class="bg-grey">
                                        <td class="must-right"><strong>Total = {{number_format(($receipt_total - $opening_cash_in_hand),2)}}</strong></td>
                                        <td class="must-right"><strong>Total = {{number_format(($payment_total),2)}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="must-right text-danger"><strong>Cash In Hand = </strong> <strong><i class="fa fa-inr"></i> {{number_format(($receipt_total - $payment_total),2)}}</strong></td>
                                    </tr>
                                    <tr class="bg-grey">
                                        <td class="must-right">Grand Total = <i class="fa fa-inr"></i> {{number_format(($receipt_total),2)}}</td>
                                        <td class="must-right">Grand Total = <i class="fa fa-inr"></i> {{number_format(($bal + ($receipt_total - $payment_total)),2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
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