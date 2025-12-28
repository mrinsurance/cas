@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
@endpush

@push('extra_js')
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
            <li class="active">Account List</li>
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

                            Total Account Holders -> {{ $items->firstItem() }} - {{ $items->lastItem() }} of {{ $items->total() }} (for page {{ $items->currentPage() }} )
                        </h3>
                        @can('product-create')
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="{{TRANSACTION_URL_OPEN_NEW_AC}}create" target="_new"><i class="fa fa-plus-circle"></i> Create Account</a>
                        </div>
                        @endcan
                    </div>


                    <div class="portlet-body">
                        <div class="row pt-0 pb-0">
                        <div class="col-md-3 pull-right">
                            <form action="{{TRANSACTION_URL_OPEN_NEW_AC}}" method="get" role="search">
                              {{csrf_field()}}
                             <div class="form-group row">
                              <div class="col-sm-8">
                                  <input type="text" name="search" value="{{old('search',@$search)}}" class="form-control">
                                </div>
                              <div class="col-sm-4">
                                  <button type="submit" class="btn btn-warning">Search</button>
                                </div>
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
                                        <th scope="col">Member Type</th>
                                        <th scope="col">Account No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father Name</th>
                                        <th scope="col">Village</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($items as $item)
                                  <tr id="product{{$item->id}}">
                                    <td>{{$loop->index + $items->firstItem()}}</td>
                                    <td>{{@$item->member_type_model->name}}</td>
                                    <td>{{$item->account_no}}</td>
                                    <td>{{$item->full_name}}</td>
                                    <td>{{@$item->father_name}}</td>
                                    <td>{{ $item->village }}</td>
                                    <td>{{@$item->contact_no}}</td>
                                    <td><center>
                                      @if($item->status == 1)
                                      <i class="fa fa-fw fa-check text-success"></i>
                                      @else
                                        <i class="fa fa-fw fa-times text-danger"></i>
                                      @endif
                                  </center>
                                    </td>
                                    <td>
                                        @if(!$CheckLock)
                                    @can('product-edit')
                                      <a href="{{TRANSACTION_URL_OPEN_NEW_AC.''.$item->id}}/edit" data-toggle="tooltip" title="Edit" target="_new" class="mr-10"><i class="fa fa-edit text-warning"></i></a>
                                    @endcan

                                      <a href="{{TRANSACTION_URL_OPEN_NEW_AC.''.$item->id}}" data-toggle="tooltip" title="View" target="_new" class="mr-10"><i class="fa fa-eye text-success"></i></a>

                                      <a href="{{TRANSACTION_URL_OPEN_NEW_AC.'print/'.$item->id}}" data-toggle="tooltip" title="Print" target="_new"><i class="fa fa-print text-danger"></i></a>
                                        @endif
                                    </td>
                                  </tr>
                                @endforeach

                                </tbody>
                            </table>
                       <center> {{$items->links()}} </center>
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