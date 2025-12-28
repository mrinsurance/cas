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
            <li class="active">Loan A/C</li>
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
                            <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> List of Loan Accounts
                        </h3>
                        @can('product-create')
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="{{TRANSACTION_URL_LOAN_AC}}create"><i class="fa fa-plus-circle"></i> Loan Advancement</a>
                        </div>
                        @endcan
                    </div>

                    <div class="portlet-body">
<div class="row">
    <div class="col-md-12">
    <form class="form-horizontal" action="{{TRANSACTION_URL_LOAN_AC}}" method="get">
        {{csrf_field()}}
        <div class="col-md-3">
            <label class="col-md-6 control-label" for="email">Member Type</label>
            <div class="col-md-6">
                <select name="member" class="form-control">
                    @foreach($members as $val)
                    <option value="{{$val->id}}" {{@$member == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label class="col-md-6 control-label" for="email">A/C</label>
            <div class="col-md-6">
                <input class="form-control" value="{{@$account}}" name="account" placeholder="Account no.">
            </div>
        </div>
        <div class="col-md-3">
            <label class="col-md-3 control-label" for="email">Date</label>
            <div class="col-md-9">
                <input type="date" name="cur_date" class="form-control" value="{{@$cur_date}}">
            </div>
        </div>
        <div class="col-md-3">
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
                                        <th scope="col">A/C No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father</th>
                                        <th scope="col">Loan Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($items as $item)
@php
 //Sum of received principal from loan return table
                                $tbl_loan_return_model_sum = \App\tbl_loan_return_model::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(tbl_loan_return_models.received_principal),0) total_received_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->first();
@endphp
                                  <tr id="product{{$item->id}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$item->account_no}}</td>
                                    <td>{{@$item->open_new_ac_model->full_name}}</td>
                                    <td>{{@$item->open_new_ac_model->father_name}}</td>
                                    <td>{{ LoanType($item->loan_type)['name'] }}</td>
                                    <td>{{number_format(@$item->amount)}}</td>
                                    <td>{{@$item->date_of_advance}}</td>
                                    <td>
                                        <center>
                                      @if(($item->amount - $tbl_loan_return_model_sum->total_received_principal) > 0)
                                      <i class="fa fa-check text-success"></i>
                                      @else
                                        <i class="fa fa-times text-danger"></i>
                                      @endif
                                  </center>
                                    </td>
                                    <td>
                                        @if(!$CheckLock)
                                      <a href="{{TRANSACTION_URL_LOAN_AC.''.$item->id.'/'.$cur_date}}/recovery" class="btn btn-warning btn-sm">Recovery</a>
                                      @can('product-delete')
                                      <button type="button" class="btn btn-danger btn-sm delete-product" value="{{TRANSACTION_URL_LOAN_AC.''.$item->id}}"><i class="fa fa-trash"></i> Delete</button>
                                        <input type="hidden" id="prd_id" value="{{$item->id}}">
                                        @endcan
{{--                                        <a href="{{ route('transaction.loan.edit','id='.$item->id) }}" class="btn btn-primary btn-sm">Edit</a>--}}
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