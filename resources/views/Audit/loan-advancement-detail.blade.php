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
        <h1>Loan Advancement Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Loan Advancement Detail</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Loan Advancement Detail
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="{{ route('audit.report.loan.advance.detail') }}" method="get">
                        {{csrf_field()}}
                    <div class="row">
                    <div class="col-md-12">                    
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">From</label>
                            <div class="col-md-8">
                                <!-- <input class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" id="from_date" placeholder="Check-In Date" readonly> -->
                                <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" placeholder="Check-In Date">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">To</label>
                            <div class="col-md-8">
                                <!-- <input class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}" name="to_date" id="to_date" placeholder="Check-In Date" readonly> -->
                                <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}" name="to_date">
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
                            <label class="col-md-4 control-label" for="email">Loan Type</label>
                            <div class="col-md-8">
                                <select name="loan_type" class="form-control">
                                    <option value="">All</option>
                                    @foreach($loan_types as $val)
                                    <option value="{{$val->id}}" {{@$loan_type == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 col-md-offset-5">                        
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
                                    <td colspan="11">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h4>
                                                Loan Advancement Report from  {{date('d-M-Y',strtotime($from_date))}}
                                                to 
                                                {{date('d-M-Y',strtotime($to_date))}}
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Date of Advance</th>
                                    <th>A/C No.</th>
                                    <th>Purpose</th>
                                    <th>Amount</th>
                                    <th>Month</th>
                                    <th>Interest</th>
                                    <th>Penalty</th>
                                    <th>Name</th>
                                    <th>Guarantor (A/C)</th>
                                </tr>
                            </thead>
                            <tbody>  
                            @foreach($_loanReport as $_loan)                             
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{date('d-M-Y',strtotime($_loan->date_of_advance))}}</td>
                                    <td>{{$_loan->account_no}}</td>
                                    <td>
                                        @php
                                            $purpose = DB::table('loanpurpose_models')->where('id',$_loan->loan_purpose)->first();
                                        @endphp
                                        {{$purpose->name}}
                                    </td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($_loan->amount)}}</td>
                                    <td class="align_right">{{ $_loan->months }}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($_loan->interest)}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($_loan->pannelty_int)}}</td>
                                    <td>{{@$_loan->open_new_ac_model->full_name}}</td>


                                    <td>
                                        @php
                                        $guarnter_one = DB::table('open_new_ac_models')->where('id',$_loan->guarnter_one)->first();
                                        $guarnter_two = DB::table('open_new_ac_models')->where('id',$_loan->guarnter_two)->first();
                                        @endphp
                                        {{@$guarnter_one->full_name}} ({{@$guarnter_one->account_no}})
                                        <br>{{@$guarnter_two->full_name}} ({{@$guarnter_two->account_no}})
                                    </td>
                                   
                                </tr>
                            @endforeach  
                                <tr>
                                    <td colspan="4" class="align_right"><strong>Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($_loanTotal)}}</strong></td>
                                    <td colspan="3" >&nbsp;</td>
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