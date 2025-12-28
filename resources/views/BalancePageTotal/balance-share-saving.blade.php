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
        <h1>Balance (Share + Saving)</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Balance of Share & Saving</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Book
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="{{BALANCE_REPORT_URL_BALANCE_SHARE_SAVING}}" method="get">
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
                                    @foreach($members as $val)
                                    <option value="{{$val->id}}" {{@$member_type == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="submit" value="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

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
                                    <td colspan="6">
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
                                                SHARE & SAVING BALANCE AS ON {{date('d-M-Y',strtotime($from_date))}}
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>Share</th>
                                    <th>Saving</th>
                                    <th>Confirmation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $rec = 0; 
                                    $share_prv_total = 0; 
                                    $share_grand_total = 0;
                                    $saving_prv_total = 0;
                                    $saving_grand_total = 0;

                                    $total_of_balance = 0;
                                    $total_recover_int = 0;

                                @endphp
                                @foreach($ac_holders as $val)

                                @php
 //Share Balance
                               $share_deposit = BalanceShareSum($val->id, 'Deposit',$from_date);
                               $share_withdraw = BalanceShareSum($val->id, 'Withdrawal',$from_date);

                               $share_balance = ($share_deposit - $share_withdraw);
                               $share_grand_total = ($share_grand_total + $share_balance);
// Saving Balance
                                $saving_deposit = BalanceSavingSum($val->id, 'Deposit',$from_date);
                                $saving_withdraw = BalanceSavingSum($val->id, 'Withdrawal',$from_date);

                               $saving_balance = ($saving_deposit - $saving_withdraw);
                               $saving_grand_total = ($saving_grand_total + $saving_balance);

                                @endphp

                                @if($share_balance != 0 || $saving_balance != 0)
                                <tr>
                                    <td>{{ $rec++ }}</td>
                                    <td>{{str_limit(trim($val->full_name),13)}}</td>
                                    <td>{{$val->account_no}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($share_balance,2)}}</td>

                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($saving_balance,2)}}</td>
                                    <td>
                                        @php
                                          $status_data =  DB::table('balance_book_status')->where(['ac_holder_id'=>$val->id])->first();
                                        @endphp
                                        @if(@$status_data->status==1) Yes @endif @if(@$status_data->status==2) No @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                <tr>
                                    <td colspan="1"><strong>Total</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($share_grand_total,2)}}</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saving_grand_total,2)}}</strong></td>
                                    <td></td>
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