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

        .font-weight-bold{
            font-weight: bold;
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
                   
                    <form class="form-horizontal" action="#" method="get">
                        {{csrf_field()}}
                    <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">From </label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($from)->format('Y-m-d') }}" name="from_date" id="from_date" placeholder="Check-In Date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">To</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($to)->format('Y-m-d') }}" name="to_date" id="to_date" placeholder="Check-In Date">
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
                                    <td colspan="7">
                                        <div class="col-md-12 text-center">
                                            @php
                                                $company_address = CompanyAddress();

                                            @endphp
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h4>
                                                Loan Recovery Report
                                            <br>
                                                FROM {{ \Carbon\Carbon::parse($from)->format('d-M-Y') }} To  {{ \Carbon\Carbon::parse($to)->format('d-M-Y') }}
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>A/c No.</th>
                                    <th>Name</th>
                                    <th>PL</th>
                                    <th>Interest</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $plTotal = 0;
                            $interestTotal = 0;

                            @endphp
                            @foreach($loan as $list)
                                @php
                                    $openAc = getAccountDetailByAcNo($list->account_no);
                                    $plTotal = $plTotal + $list->received_principal;
                                    $interestTotal = $interestTotal + $list->received_interest;

                                @endphp
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $list->received_date }}</td>
                                    <td>{{ $list->account_no }}</td>
                                    <td>{{ ucwords($openAc->full_name) }}</td>
                                    <td class="text-right">{{ number_format($list->received_principal,2,'.','') }}</td>
                                    <td class="text-right">{{ number_format($list->received_interest,2,'.','') }}</td>
                                    <td class="text-right">{{ number_format(($list->received_interest + $list->received_principal),2,'.','') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold">Total</td>
                                <td class="text-right font-weight-bold">{{ number_format($plTotal,2,'.','') }}</td>
                                <td class="text-right font-weight-bold">{{ number_format($interestTotal,2,'.','') }}</td>
                                <td class="text-right font-weight-bold">{{ number_format(($plTotal + $interestTotal),2,'.','') }}</td>
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