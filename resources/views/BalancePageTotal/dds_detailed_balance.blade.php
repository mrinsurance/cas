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
        <h1>Detailed Balance Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">DDS Detailed Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Detailed Balance Report of DDS A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="{{D_BALANCE_REPORT_URL_DDS}}" method="get">
                    <div class="row">
                    <div class="col-md-12">
                        {{csrf_field()}}
                        <div class="col-md-6">
                            <label class="col-md-2 control-label" for="email">From</label>
                            <div class="col-md-4">
                                <input class="form-control" value="{{$from_date}}" name="from_date" id="from_date" placeholder="From" readonly>
                            </div>
                            <label class="col-md-2 control-label" for="email">To</label>
                            <div class="col-md-4">
                                <input class="form-control" value="{{$to_date}}" name="to_date" id="to_date" placeholder="To" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-3 control-label" for="email">Branch</label>
                            <div class="col-md-3">
                                <select name="branch" class="form-control">
                                    <option value="">All</option>
                                    @foreach($branches as $val)
                                    <option value="{{$val->id}}" {{@$branch == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-md-3 control-label" for="email">Member Type</label>
                            <div class="col-md-3">
                                <select name="member_type" class="form-control">
                                    <option value="">All</option>
                                    @foreach($members as $val)
                                    <option value="{{$val->id}}" {{@$member_type == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
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
                                                DDS Balance Report from <strong>{{date('d-M-Y',strtotime($from_date))}}</strong> to <strong> {{date('d-M-Y',strtotime($to_date))}}</strong>
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>Opening</th>
                                    <th>Deposit</th>
                                    <th>Withdrawal</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                $sr = 0; 
                                $t1 = 0;    
                                $t2 = 0;    
                                $t3 = 0;    
                                $t4 = 0;    
                                @endphp
                                @foreach($ac_holders as $val)
                                @php

                               $deposit = \App\dds_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<',$from_date)->sum('amount');

                               $withdraw = \App\dds_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<',$from_date)->sum('amount');

                               $deposit_trans = \App\dds_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','>=',$from_date)->where('date_of_transaction','<=',$to_date)->sum('amount');

                               $withdraw_trans = \App\dds_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','>=',$from_date)->where('date_of_transaction','<=',$to_date)->sum('amount');

                               $opening_balance = ($deposit - $withdraw);
                                 $balance = ($opening_balance + ($deposit_trans - $withdraw_trans));
                                @endphp
                               @if($opening_balance <> 0 || $deposit_trans <> 0 || $withdraw_trans <> 0)
                               @php 
                                    $sr++; 
                                    $t1 += $opening_balance;
                                    $t2 += $deposit_trans;
                                    $t3 += $withdraw_trans;
                                    $t4 += $balance; 
                                @endphp
                                <tr>
                                    <td>{{$sr}}</td>
                                    <td>{{$val->full_name}}</td>
                                    <td>{{$val->account_no}}</td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i> {{number_format($opening_balance,2)}}
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i> 
                                        {{number_format($deposit_trans,2)}}
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i> 
                                        {{number_format($withdraw_trans,2)}}
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   {{number_format($balance,2)}}
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                 <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t1,2)}}</strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t2,2)}}</strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t3,2)}}</strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t4,2)}}</strong>
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