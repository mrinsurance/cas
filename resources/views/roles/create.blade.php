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
  <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
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
            <li>
                <a href="{{ROLES}}"> Role Management </a>
            </li>
            <li class="active">Create New Role</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Create New Role
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{ROLES}}" id="post_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                    {{csrf_field()}}
                            <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Name <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                     <span class="color-pwd" id="name"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Permission <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        @foreach($permission as $value)
                                            <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                            {{ $value->name }}</label>
                                        <br/>
                                        @endforeach
                                     <span class="color-pwd" id="permission"></span>
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
                                    <button type="submit" class="btn btn-success btn_sizes">Submit</button>
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