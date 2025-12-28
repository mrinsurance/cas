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
        <h1>Ward Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Ward Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Ward Report
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="{{ADDITIONAL_WARD_AGENT}}" method="get">
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
                            <label class="col-md-4 control-label" for="email">Ward</label>
                            <div class="col-md-8">
                                <input type="text" name="ward" class="form-control" value="{{request()->ward}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Minimum Share</label>
                            <div class="col-md-8">
                                <input type="text" name="min_share" class="form-control" value="{{request()->min_share}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Gender</label>
                            <div class="col-md-8">
                                <select name="gender" class="form-control">
                                    <option value="">All</option>
                                    <option value="Male" {{request()->gender == 'Male' ? 'selected' : ''}}>Male</option>
                                    <option value="Female" {{request()->gender == 'Female' ? 'selected' : ''}}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Category</label>
                            <div class="col-md-8">
                                <select name="category" class="form-control">
                                    <option value="">All</option>
                                    <option value="General" {{request()->category == 'General' ? 'selected' : ''}}>General</option>
                                    <option value="OBC" {{request()->category == 'OBC' ? 'selected' : ''}}>OBC</option>
                                    <option value="SC" {{request()->category == 'SC' ? 'selected' : ''}}>SC</option> 
                                    <option value="ST" {{request()->category == 'ST' ? 'selected' : ''}}>ST</option> 
                                    <option value="Other" {{request()->category == 'Other' ? 'selected' : ''}}>Other</option>
                                </select>
                            </div>
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
                                    <td colspan="5">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h4>
                                                
                                                Ward {{request()->ward}} Report as on {{date('d-M-Y',strtotime($from_date))}} 
@if(request()->gender != '' && request()->gender == 'M')
(Male)
@endif
@if(request()->gender != '' && request()->gender == 'F')
(Female)
@endif
@if(request()->category)
({{request()->category}})
@endif

                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>A/C No.</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $rec = 0; 
                                    $prv_total = 0; 
                                    $page_total = 0;  
                                    $grand_total = 0; 
                                    $srn = 0; 
                                    $trec = 0;
                                @endphp
                                @foreach($ac_holders as $val)
                                @php
                               $deposit = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<=',$from_date)->sum('amount');

                               $withdraw = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<=',$from_date)->sum('amount');

                               $balance = ($deposit - $withdraw);


                               $page_total += $balance; 
                               $grand_total = ($grand_total + $balance); 
                               $trec++;

                                @endphp
                                @if($balance >= request()->min_share)
                                @php 
                                    $srn++;  
                                    $rec++;
                                @endphp
                                
                                <tr>
                                    <td>{{$rec}}</td>
                                    <td>{{$val->full_name}}</td>
                                    <td>{{$val->father_name}}</td>
                                    <td>{{$val->account_no}}</td>
                                    <td> {{$val->current_address_first}}</td>
                                </tr>
                                @endif
                                @endforeach
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