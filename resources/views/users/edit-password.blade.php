@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
  <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet">
  <link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
  <link href="{{ASSETS_CSS}}pages/form_layouts.css" rel="stylesheet" type="text/css" />
  <link href="{{ASSETS_CSS}}pages/form2.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ASSETS_CSS}}jquery-ui.css" />
@endpush

@push('extra_js')
  <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
  <script src="{{ASSETS_JS}}pages/form_layouts.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}edit-record.js"></script>
@endpush

@section('body')
 <!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>{{Auth::user()->name}}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{USERS}}"> Users Management </a>
            </li>
            <li class="active">Edit Password</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Edit Password
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{USERS.'/password/'.$user->id}}" id="edit_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                            <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                       Password <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                       <input type="password" name="password" placeholder="Password" class="form-control" autocomplete="off">
                                       <span class="color-pwd" id="password"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Confirm Password <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                       <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control" autocomplete="off">
                                       <span class="color-pwd" id="confirm-password"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-md-6 col-md-offset-3">
                                    @include('mylayout.ajax-msg')
                                  </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="col-md-offset-3 col-md-6 text-center btn-group-lg">
                                    <button type="submit" class="btn btn-success btn_sizes">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
</aside>
@endsection