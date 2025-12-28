@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link rel="stylesheet" type="text/css" href="{{ASSETS_VENDORS}}datatables/css/dataTables.bootstrap.css" />
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
        <style>

        .align_right{
            text-align: right !important;
        }
    </style>
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
            <li class="active">Purchase</li>
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
                            <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Purchase List
                        </h3>
                        @can('product-create')
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="{{TRADING_URL_PURCHASE}}/create"><i class="fa fa-plus-circle"></i> Create New</a>
                        </div>
                        @endcan
                    </div>

                    <div class="portlet-body">
                        @include('mylayout.ajax-msg')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Invoice No</th>
                                        <th scope="col">Bill No</th>
                                        <th scope="col">Bill Date</th>
                                        <th scope="col">Purchase Date</th>
                                        <th scope="col">Bill Amount (<i class="fa fa-inr"></i>)</th>
                                        <th scope="col">Purchase Party</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($items as $item)
                                       @php
                                            $amount = App\purchase_detail_tbl::where('purchase_tbl_id',$item->id)->sum('amount');
                                       @endphp
                                  <tr id="product{{$item->id}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>
                                      <a href="{{TRADING_URL_PURCHASE.'/'.$item->id}}/edit" title="Edit"><i class="fa fa-edit text-danger"></i></a>
                                      <a href="{{TRADING_URL_PURCHASE.'/'.$item->id}}" title="View"><i class="fa fa-eye text-success"></i></a>
                                    </td>
                                    <td>
                                        @if($item->apr_status == TRUE)
                                            <span class="text-success">Approved</span>
                                        @else
                                            <span class="text-danger">UnApproved</span>
                                        @endif
                                    </td>
                                    <td>{{$item->invoice_no}}</td>
                                    <td>{{$item->bill_no}}</td>
                                    <td>{{$item->billing_date}}</td>
                                    <td>{{$item->date_of_transaction}}</td>
                                    <td class="text-right">{{ number_format($amount,2) }}</td>
                                    <td>{{@$item->purchase_party_tbl->name}}</td>

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