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
        <h1>Hello Admin</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Year End</li>
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
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Financial Year / Year End
                        </h3>
                        @can('product-create')
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="{{FINANCIAL_YEAR_END_URL}}/create"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                        @endcan
                    </div>
                    
                    <div class="portlet-body">
                        @include('mylayout.ajax-msg')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"   style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Added Date</th>
                                        <th scope="col">Financial Year</th>
                                        <th scope="col">Opening Stock Depot 1</th>
                                        <th scope="col">Opening Stock Depot 2</th>
                                        <th scope="col">Opening Stock Depot 3</th>
                                        <th scope="col">Closing Stock Depot 1</th>
                                        <th scope="col">Closing Stock Depot 2</th>
                                        <th scope="col">Closing Stock Depot 3</th>
                                        <th scope="col">NPA Amount</th>
                                        <th scope="col">NPA Interest</th>
                                        <th scope="col">Interest Payble On FD</th>
                                        <th scope="col">Interest Payble On RD</th>
                                        <th scope="col">Interest Recoverable On Loan</th>
                                        <th scope="col">Interest Recoverable On Bank FD</th>
                                        <th scope="col">Interest Recoverable On Bank RD</th>
                                        <th scope="col">NET Profit</th>
                                        <th scope="col">NET Loss</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($items as $item)
                                      <tr id="product{{$item->id}}">

                                        <td>{{$loop->index + 1}}</td>
                                        <td>
                                            <a href="{{FINANCIAL_YEAR_END_URL.'/'.$item->id.'/edit'}}" title="Edit">
                                                <i class="fa fa-pencil text-success"></i>
                                            </a>
                                            <button class="delete-product" value="{{FINANCIAL_YEAR_END_URL.'/'.$item->id}}" title="Delete"><i class="fa fa-trash text-danger" style="cursor: pointer;"></i> </button>
                                        <input type="hidden" id="prd_id" value="{{$item->id}}">

                                        </td>
                                        <td>{{date('d-M-Y, h:i:s A',strtotime($item->created_at))}}</td>
                                        <td>{{date('Y',strtotime(@$item->session_master_model->start_date))}} - {{date('Y',strtotime(@$item->session_master_model->end_date))}}</td>
                                        <td>{{$item->opening_stock_depot1}}</td>
                                        <td>{{$item->opening_stock_depot2}}</td>
                                        <td>{{$item->opening_stock_depot3}}</td>
                                        <td>{{$item->closing_stock_depot1}}</td>
                                        <td>{{$item->closing_stock_depot2}}</td>
                                        <td>{{$item->closing_stock_depot3}}</td>
                                        <td>{{$item->npa_amount}}</td>
                                        <td>{{$item->npa_int}}</td>
                                        <td>{{$item->int_payble_fd}}</td>
                                        <td>{{$item->int_payble_rd}}</td>
                                        <td>{{$item->int_recover_loan}}</td>
                                        <td>{{$item->int_recover_bank_fd}}</td>
                                        <td>{{$item->int_recover_bank_rd}}</td>
                                        <td>{{$item->net_profit}}</td>
                                        <td>{{$item->net_loss}}</td>
                                        
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