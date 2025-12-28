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
            <li class="active">RD A/C List</li>
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
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> RD A/C List
                        </h3>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="{{TRANSACTION_URL_RD_AC}}create"><i class="fa fa-plus-circle"></i> Create New RD</a>
                        </div>
                    </div>
                    
                    <div class="portlet-body">
<div class="row">
    <div class="col-md-12">
    <form class="form-horizontal" action="{{TRANSACTION_URL_RD_AC}}" method="get">
        {{csrf_field()}}

        <div class="col-md-4">
            <label class="col-md-6 control-label" for="email">Member Type</label>
            <div class="col-md-6">
                <select name="member" class="form-control">
                    @foreach($members as $val)
                    <option value="{{$val->id}}" {{@$member == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <label class="col-md-6 control-label" for="email">A/C</label>
            <div class="col-md-6">
                <input class="form-control" value="{{@$account}}" name="account" placeholder="Account no.">
            </div>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> Search</button>
        </div>
    </form>    
    </div>
    </div>                        
                        @include('mylayout.ajax-msg')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">A/C</th>
                                        <th scope="col">RD No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father</th>
                                        <th scope="col">RD Amount <small>(Rs.)</small></th>
                                        <th scope="col">RD Dated</th>
                                        <th scope="col">Matuarity Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($items as $item)
                                  <tr id="product{{$item->id}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$item->account_no}}</td>
                                    <td>{{$item->rd_no}}</td>
                                    <td>{{@$item->open_new_ac_model->full_name}}</td>
                                    <td>{{@$item->open_new_ac_model->father_name}}</td>
                                    <td>{{number_format($item->amount,2)}}</td>
                                    <td>{{@$item->transaction_date}}</td>
                                    <td>{{@$item->maturity_date}}</td>
                                    <td>
                                      @if($item->status == 1)
                                      <span class="text text-success">Active</span>
                                      @else
                                      <span class="text text-danger">Matured</span>
                                      @endif
                                    </td>
                                    <td>
                                        @if(!$CheckLock)
                                        <a href="{{TRANSACTION_URL_RD_AC.''.$item->id}}/edit" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{TRANSACTION_URL_RD_AC.'installment/'.$item->id.'/'.$item->token}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Installment"><i class="fa fa-ticket"></i></a>
                                    <a href="{{TRANSACTION_URL_RD_AC.''.$item->id}}/matured" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Mature">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                        @endif
                                    </td>
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