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
        <h1>Balance Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">RD Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Report of RD A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="{{BALANCE_REPORT_URL_RD}}" method="get">
                        {{csrf_field()}}
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">As On</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" placeholder="Check-In Date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Branch</label>
                            <div class="col-md-8">
                                <select name="branch" class="form-control">
                                    <option value="">All</option>
                                    @foreach($branches as $val)
                                    <option value="{{$val->id}}" {{@$branch == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Type</label>
                            <div class="col-md-8">
                                <select name="member_type" class="form-control">
                                    <option value="">All</option>
                                    @foreach($members as $val)
                                    <option value="{{$val->id}}" {{@$member_type == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <input type="checkbox" name="wp" {{request()->wp == TRUE ? 'checked' : ''}}>
                            <label class="control-label" for="email">Without Payable</label>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </form>
                    </div>
                    </div>
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        <div class="prnt" id="record">

                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="8">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h4>
@foreach($members as $val)
@if($val->id == $member_type)
{{$val->name}}
@endif
@endforeach
                                                RD Balance Report as on {{date('d-M-Y',strtotime($from_date))}}
                                            </h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>RD No.</th>
                                    <th>RD Dated</th>
                                    <th>RD Amount</th>
                                    @if(request()->wp == false)
                                        <th>Payable Int</th>
                                    @endif
                                    <th>Maturity Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $totalFd = 0;
                                $totalPayble = 0;
                                @endphp
                                @foreach($items as $item)
                                @php
    $totall = \App\rd_installment_model::where('rd_model_id',$item->id)
    ->where('installment_date','<=',$from_date)
    ->sum('amount');

    $installment = ($totall / $item->amount);


$principal = $item->amount;
$interest_rate = ($item->int_rate / 100);

$matured_amount = 0;
$n = $installment / 4;
for ($i = $installment; $i >=1 ; $i--) {
$matured_amount = $matured_amount + ($principal * pow(1+$interest_rate/$n, $n*$i/12));
}
$maturity_amount = round($matured_amount);


                                @endphp

                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td> {{str_limit($item->open_new_ac_model->full_name,15)}} </td>
                                    <td>{{$item->account_no}}</td>
                                    <td>{{$item->rd_no}}</td>
                                    <td class="align_right">{{date('d/m/Y',strtotime($item->transaction_date))}}</td>
                                    <td class="align_right">
                                            {{number_format($totall,2,'.','')}}
                                    </td>
                                    @if(request()->wp == false)
                                    <td class="align_right">{{number_format($maturity_amount - $totall,2,'.','')}}</td>
                                    @endif
                                    <td class="align_right">{{date('d/m/Y',strtotime($item->maturity_date))}}</td>
                                </tr>
                                @php
                                $totalFd = $totalFd + $totall;
                                $totalPayble = ($totalPayble + ($maturity_amount - $totall));
                                @endphp
                                @endforeach
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th class="align_right"> {{number_format($totalFd,2,'.','')}}</th>
                                    @if(request()->wp == false)
                                        <th class="align_right">{{number_format($totalPayble,2,'.','')}}</th>
                                    @endif
                                    <th></th>
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