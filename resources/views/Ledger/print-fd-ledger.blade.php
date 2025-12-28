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
        @media print {
            .record {
                page-break-after: always;
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
    <script src="{{ASSETS_JS}}day_book.js"></script>
    <!-- end of page level js -->
    <script type="text/javascript">
        function printDiv(printRecord){
            var printContents = '';
            $('.record').each(function () {
                printContents += $(this).prop('outerHTML') + '<hr>';
            });

            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

    </script>
@endpush

@section('body')

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>FD Ledger Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">FD Ledger Report</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> FD Ledger Report
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="{{ route('ledger.print-fd-ledger') }}" method="get">
                    <div class="row">
                    <div class="col-md-12">
                    
                        {{csrf_field()}}

                        <div class="col-md-3">
                            <label class="col-md-3 control-label" for="asOn">As On</label>
                            <div class="col-md-9">
                                <!-- <input class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}" name="to_date" id="to_date" placeholder="Check-In Date" readonly> -->
                                 <input type="date" name="to_date" class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-5 control-label" for="email">Member Type</label>
                            <div class="col-md-7">
                                <select name="member_type" class="form-control">
                                    @foreach($_members as $val)
                                    <option value="{{$val->id}}" {{@$member_type == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-5 control-label" for="email">A/C no.</label>
                            <div class="col-md-7">
                                <input type="text" name="account" value="{{@$_holder->account_no}}" class="form-control">
                            </div>
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
                    @foreach($allLedgers as $group)
                        @php
                            $running_balance = 0;
                            $_holder = $group['holder'];
                        @endphp

                        <div class="table-scrollable page-break">
                            <div class="prnt record">
                            <table class="table table-bordered table-hover" id="mytable_css">
                                <thead>
                                <tr>
                                    <th colspan="14" class="text-center">
                                        <div class="row">
                                            <div class="col-md-14 text-center">
                                                <h3>
                                                    {{$company_address->name}}
                                                </h3>
                                                {{$company_address->address}}
                                                <br>
                                                FD Ledger Report
                                            </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="14">
                                        <strong>Member A/C no.:</strong> <em>{{ $_holder->account_no }}</em><br>
                                        <strong>Name:</strong> <em>{{ $_holder->full_name }}</em><br>
                                        <strong>Father Name:</strong> <em>{{ $_holder->father_name }}</em><br>
                                        <strong>As On:</strong> <em>{{ date('d-M-Y', strtotime($to_date)) }}</em>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date of Transaction</th>
                                    <th>FD No.</th>
                                    <th>Deposit Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Paid Interest</th>
                                    <th>Balance</th>
                                    <th>Interest Rate (%)</th>
                                    <th>Interest Run From</th>
                                    <th>Period of FD (Month)</th>
                                    <th>Maturity Date</th>
                                    <th>Matured on Date</th>
                                    <th>Type of Interest</th>
                                    <th>Maturity Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($group['ledgers'] as $ledger)
                                    @php
                                        $deposit_amount = (float) $ledger->amount;
                                        $maturity_amount = (float) $ledger->maturity_amount;
                                        $paid_amount = 0;
                                        $paid_interest = 0;
                                        $running_balance += $deposit_amount;
                                    @endphp

                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($ledger->transaction_date)->format('d-m-Y') }}</td>
                                        <td>{{ $ledger->fd_no }}</td>
                                        <td class="align_right">{{ number_format($deposit_amount, 2) }}</td>
                                        <td class="align_right"></td>
                                        <td class="align_right"></td>
                                        <td class="align_right">{{ number_format($running_balance, 2) }}</td>
                                        <td class="align_right">{{ $ledger->int_rate }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ledger->int_run_from)->format('d-m-Y') }}</td>
                                        <td>{{ $ledger->period_fd }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ledger->maturity_date)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ledger->matured_on_date)->format('d-m-Y') }}</td>
                                        <td>{{ $ledger->interest_type }}</td>
                                        <td class="align_right">{{ number_format($maturity_amount, 2) }}</td>
                                        <td>{{ $ledger->status == 1 ? 'Active' : 'Closed' }}</td>
                                    </tr>

                                    @if($ledger->status == 0 && \Carbon\Carbon::parse($ledger->matured_on_date)->lte($to_date))
                                        @php
                                            $paid_amount = $deposit_amount;
                                            $paid_interest = $maturity_amount - $deposit_amount;
                                            $running_balance -= $paid_amount;
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($ledger->matured_on_date)->format('d-m-Y') }}</td>
                                            <td>{{ $ledger->fd_no }}</td>
                                            <td class="align_right"></td>
                                            <td class="align_right">{{ number_format($paid_amount, 2) }}</td>
                                            <td class="align_right">{{ number_format($paid_interest, 2) }}</td>
                                            <td class="align_right"></td>
                                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>

                    @endforeach

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