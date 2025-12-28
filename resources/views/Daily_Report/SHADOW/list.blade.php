@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link rel="stylesheet" type="text/css" href="{{ASSETS_VENDORS}}datatables/css/dataTables.bootstrap.css" />
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
@endpush

@push('extra_js')
  <script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/dataTables.bootstrap.js"></script>
  <script src="{{ASSETS_SRC_JS}}pages/table-responsive.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}bootbox.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}deleteconfirm.js"></script>
@endpush

@section('body')

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Login with {{Auth::user()->name.' '.Auth::user()->last_name}}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Shadow List</li>
        </ol>
    </section>
    <!--section ends-->
        <section class="content">
        <div class="row">
            <div class="col-md-12">

                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="panel-heading portlet-title">
                        <h3 class="panel-title pull-left add_remove_title">
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Shadow List
                        </h3>
                    </div>
                    
                    <div class="portlet-body">
                        @include('mylayout.ajax-msg')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Agent Code</th>
                                        <th scope="col">Agent Name</th>
                                        <th scope="col">Received (Rs.)</th>
                                        <th scope="col">Payment (Rs.)</th>
                                        <th scope="col">Due Balance (Rs.)</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($items as $item)
                                  @php
                                  $received_pay = \App\tbl_ledger_model::where('main_head','!=','Cash')->where('type_of_transaction','Cr')->where('shadow','0')->where('user_id',$item->id)->sum(DB::raw('amount + additional_amt'));

                                  $payment_rec = \App\tbl_ledger_model::where('main_head','!=','Cash')->where('type_of_transaction','Dr')->where('shadow','0')->where('user_id',$item->id)->sum(DB::raw('amount + additional_amt'));

                                  @endphp
                                  <tr id="product{{$item->id}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->employee_code}}</td>
                                    <td>{{number_format($received_pay,2)}}</td>
                                    <td>{{number_format($payment_rec,2)}}</td>
                                    <td>{{number_format($received_pay - $payment_rec,2)}}</td>
                                    <td><a href="{{DAILY_REPORT_URL_SHADOW.''.$item->id}}/edit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Approved</a></td>
                                  </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
    </section>
    <!-- content -->
</aside>
<!-- right-side -->
@endsection