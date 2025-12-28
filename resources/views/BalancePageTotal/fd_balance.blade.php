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
            <li class="active">FD Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Report of FD A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="{{ route('balance.report.page.total.fixed.deposit') }}" method="get">
                        {{csrf_field()}}
                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="control-label" for="email">As On</label>
                                <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" placeholder="Check-In Date">

                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="email">Branch</label>
                                <select name="branch" class="form-control">
                                    <option value="">All</option>
                                    @foreach($branches as $val)
                                    <option value="{{$val->id}}" {{@$branch == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>

                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="email">Member Type</label>
                             <select name="member_type" class="form-control">
                                    <option value="">All</option>
                                    @foreach($members as $val)
                                    <option value="{{$val->id}}" {{@$member_type == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="email">Order By</label>
                            <select name="orderBy" class="form-control">
                                <option value="">All</option>
                                    <option value="1" {{ request()->get('orderBy') == 1 ? 'selected' : ''}}>Account No</option>
                                    <option value="2" {{ request()->get('orderBy') == 2 ? 'selected' : ''}}>FD No</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="email">Deposit Type</label>
                                <select name="deposit_type" class="form-control">
                                    <option value="">All</option>
                                    @foreach(TypeOfDeposit() as $val)
                                    <option value="{{$val['name']}}" {{request()->deposit_type == $val['name'] ? 'selected' : ''}}>{{$val['name']}}</option>
                                    @endforeach
                                </select>
                                <br>
                                <input type="checkbox" name="wp" {{request()->wp == TRUE ? 'checked' : ''}}>
                            <label class="control-label" for="email">Without Payble</label>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>

                    </div>

                    </div>
                    </form>
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
                                                FD Balance Report as on {{date('d-M-Y',strtotime($from_date))}}
                                            </h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>FD No.</th>
                                    <th>FD Dated</th>
                                    <th>FD Amount</th>
                                    @if(request()->wp == FALSE)
                                    <th>Payble Int</th>
                                    @endif
                                    <th>Maturity Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rec = 0;
                                    $srn = 0;
                                    $trec = 0;
                                    $pageTotalFd = 0;
                                    $pageTotalPayInt = 0;
                                    $grandTotalFd = 0;
                                    $grandTotalPayInt = 0;
                                    $totalFd = 0;
                                    $totalPayInt = 0;
                                @endphp
                                @foreach($items as $item)
@php
$to = \Carbon\Carbon::createFromFormat('Y-m-d', $item->int_run_from);
$from = \Carbon\Carbon::createFromFormat('Y-m-d', $from_date);
$diff_in_days = $to->diffInDays($from);
switch ($item->interest_type) {
    case "Simple Interest":
        $intr = ($item->amount * $diff_in_days * $item->int_rate) / 36500;
        break;
    case "Quarterly Interest":
        $z = ($diff_in_days / 360) * 4;
        $intr = ((pow((((400 +  $item->int_rate) / (400 * $item->amount)) * $item->amount), $z)) * $item->amount) - $item->amount;
        break;
    case "Yearly Interest":
        $z = ($diff_in_days / 360);
        $intr = ((pow((((100 +  $item->int_rate) / (100 * $item->amount)) * $item->amount), $z)) * $item->amount) - $item->amount;
        break;
}
$intr = round($intr);

$paidIntrQuery = App\interest_on_fd_tbl::where('fd_ac_model_id',$item->id)->whereDate('paid_on','<=',$from_date)->sum('interest_amt');
$rec++;
$srn++;
$trec++;
$pageTotalFd += ($item->amount + $paidIntrQuery);
$pageTotalPayInt += $intr;
@endphp
                                @if(count($items) > 32)
                                    @if($rec == 1)
                                    <tr>
                                        <td colspan="5"><strong>Previous Total</strong></td>
                                        <td class="align_right"><strong>{{number_format(0,2,'.','')}}</td>
                                        @if(request()->wp == FALSE)
                                        <td class="align_right"><strong>{{number_format(0,2,'.','')}}</td>
                                        @endif
                                        <td class="align_right"></td>
                                    </tr>
                                    @endif
                                @endif
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{str_limit(trim(@$item->open_new_ac_model->full_name),13)}}  {{ $item->lf_no ?? '' }}</td>
                                    <td>{{$item->account_no}}</td>
                                    <td>{{$item->fd_no}}</td>
                                    <td class="align_right">{{date('d/m/Y',strtotime($item->int_run_from))}}</td>
                                    <td class="align_right">{{number_format($item->amount + $paidIntrQuery,2,'.','')}}</td>
                                    @if(request()->wp == FALSE)
                                    <td class="align_right">{{number_format($intr,2,'.','')}}</td>
                                    @endif
                                    <td class="align_right">{{date('d/m/Y',strtotime($item->maturity_date))}}</td>
                                </tr>
                                @php
                                $totalFd = $totalFd + $item->amount + $paidIntrQuery;
                                $totalPayInt = $totalPayInt + $intr;
                                @endphp
@if($srn == 32)
    @php
        $grandTotalFd += $pageTotalFd;
        $grandTotalPayInt += $pageTotalPayInt;
    @endphp
    <tr>
        <td colspan="5"><strong>Page Total</strong></td>
        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($pageTotalFd,2,'.','')}}</strong></td>
        @if(request()->wp == FALSE)
        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($pageTotalPayInt,2,'.','')}}</strong></td>
        @endif
        <td></td>
    </tr>
    <tr>
        <td colspan="5"><strong>Grand Total</strong></td>
        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($grandTotalFd,2,'.','')}}</strong></td>
        @if(request()->wp == FALSE)
        <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($grandTotalPayInt,2,'.','')}}</strong></td>
        @endif
        <td></td>
    </tr>
                                        @if(count($items) > $trec)
                                            <tr>
                                                <td colspan="5"><strong>Previous Total</strong></td>
                                                <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($grandTotalFd,2,'.','')}}</strong></td>
                                                @if(request()->wp == FALSE)
                                                <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($grandTotalPayInt,2,'.','')}}</strong></td>
                                                @endif
                                                <td></td>
                                            </tr>
                                        @endif
                                        @php
                                            $pageTotalFd = 0;
                                            $pageTotalPayInt = 0;
                                           $srn = 0;
                                        @endphp
                                    @else
                                        @if(count($items) == $trec)
                                            <tr>
                                                <td colspan="5"><strong>Page Total</strong></td>
                                                <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($pageTotalFd,2,'.','')}}</strong></td>
                                                @if(request()->wp == FALSE)
                                                <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($pageTotalPayInt,2,'.','')}}</strong></td>
                                                @endif
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><strong>Grand Total</strong></td>
                                                <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($totalFd,2,'.','')}}</strong></td>
                                                @if(request()->wp == FALSE)
                                                <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($totalPayInt,2,'.','')}}</strong></td>
                                                @endif
                                                <td></td>
                                            </tr>

                                        @endif
@endif
                                @endforeach
{{--                                <tr>--}}
{{--                                    <th colspan="5">Total</th>--}}
{{--                                    <th class="align_right">{{number_format($totalFd,2,'.','')}}</th>--}}
{{--                                    @if(request()->wp == FALSE)--}}
{{--                                    <th class="align_right">{{number_format($totalPayInt,2,'.','')}}</th>--}}
{{--                                    @endif--}}
{{--                                    <th></th>--}}
{{--                                </tr>--}}
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