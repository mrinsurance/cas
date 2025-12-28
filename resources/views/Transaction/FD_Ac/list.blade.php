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
{{--<script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/jquery.dataTables.js"></script>--}}
{{--<script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/dataTables.bootstrap.js"></script>--}}
<script src="{{ASSETS_SRC_JS}}pages/table-responsive.js"></script>
<script type="text/javascript" src="{{ASSETS_JS}}bootbox.js"></script>
<script>
   function deleteFunction(val) { 
      if(confirm("Are You Sure to delete this"))
      {
        event.preventDefault();
        document.getElementById('delete-form-'+val).submit()
      }
        event.preventDefault();
  }
 </script>
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
            <li class="active">FD A/C List</li>
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
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> FD A/C List
                        </h3>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="{{TRANSACTION_URL_FD_AC}}create"><i class="fa fa-plus-circle"></i> Create New FD</a>
                        </div>
                    </div>
                    
                    <div class="portlet-body">
<div class="row">
    <form class="form-horizontal" action="{{TRANSACTION_URL_FD_AC}}" method="get">
        {{csrf_field()}}

        <div class="col-md-3">
            <label class="control-label" for="email">Member Type</label>
                <select name="member" class="form-control">
                    @foreach($members as $val)
                    <option value="{{$val->id}}" {{@$member == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="control-label" for="email">A/C</label>
            <input class="form-control" value="{{@$account}}" name="account" placeholder="Account no.">
        </div>
        <div class="col-md-3">
            <label class="control-label" for="">
                <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> Search</button>
            </label>
        </div>
    </form>
    </div>
                        @include('mylayout.ajax-msg')
                        @if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
  <strong>{{ $message }}</strong>
</div>
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
</div>
@endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">A/C</th>
                                        <th scope="col">FD No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father</th>
                                        <th scope="col">FD Amount <small>(Rs.)</small></th>
                                        <th scope="col">Paid Interest <small>(Rs.)</small></th>
                                        <th scope="col">Total <small>(Rs.)</small></th>
                                        <th scope="col">FD Dated</th>
                                        <th scope="col">Matuarity Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $amount = 0;
                                    $paidInt = 0;
                                    $amount = 0;
                                @endphp
                                  @foreach($items as $item)
                                      @php
                                          $InterestOnFd = getSumInterestOnFdById($item->id);
                                            if ($item->status == 1)
                                                {
                                                    $amount += $item->amount;
                                                    $paidInt += $InterestOnFd;
                                                }
                                      @endphp
                                  <tr id="product{{$item->id}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$item->account_no}}</td>
                                    <td>{{$item->fd_no}}</td>
                                    <td>{{@$item->open_new_ac_model->full_name}}</td>
                                    <td>{{@$item->open_new_ac_model->father_name}}</td>
                                    <td>{{number_format($item->amount,2,'.','')}}</td>
                                    <td>{{ number_format($InterestOnFd,2,'.','')}}</td>
                                    <td>{{ number_format($item->amount + $InterestOnFd,2,'.','')}}</td>
                                    <td>{{@$item->int_run_from}}</td>
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
                                            @if($item->status == 1)
                                            <a onclick="return deleteFunction({{$item->id}});" href="#" data-toggle="tooltip" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            <form id="delete-form-{{$item->id}}" action="{{TRANSACTION_URL_FD_AC.''.$item->id}}" method="POST" style="display: none;">
                                            @method('delete')
                                            @csrf
                                            </form>

                                            <a href="{{TRANSACTION_URL_FD_AC.''.$item->id}}/edit" class="ml-10" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit text-warning"></i>
                                            </a>
                                            <a href="{{TRANSACTION_URL_FD_AC.''.$item->id}}/matured" class="ml-10" data-toggle="tooltip" title="Mature">
                                                <i class="fa fa-arrow-right text-info"></i>
                                            </a>
                                            @else
                                            <a href="{{TRANSACTION_URL_FD_AC.''.$item->id}}/matured" data-toggle="tooltip" title="UnMature">
                                                <i class="fa fa-undo text-success"></i>
                                            </a>
                                            @endif
                                        @endif
                                    </td>
                                  </tr>
                                @endforeach
                                <tr>
                                    <td colspan="12" class="text-right text-danger">Balance FD Amount = {{ $amount + $paidInt }}</td>
                                </tr>
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