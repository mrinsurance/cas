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
    <link rel="stylesheet" href="{{ASSETS_CSS}}pages/buttons.css" />
@endpush

@push('extra_js')
  <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
  <script src="{{ASSETS_JS}}pages/form_layouts.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}edit-record.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}open_new_ac.js"></script></script>
@endpush

@section('body')
 <!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Interest on Saving Calculation</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{INTEREST_ON_SAVING_LIST_URL}}">
                    Interest on Saving List
                </a>
            </li>
            <li class="active">Interest on Saving Calculation</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Edit Record
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{INTEREST_ON_SAVING_LIST_URL.'/'.$item->id}}" id="edit_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                            <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        A/C No.
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{$item->account_no}}" disabled>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        A/C Holder Name
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{$item->holder_name}}" disabled>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Interest Amount <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="dividend_amount" class="form-control" value="{{$item->dividend_amt}}" onkeypress="return isNumAndDecimalKey(event)" required>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                
                            </div>
                            <div class="form-actions">
                                <div class="col-md-offset-3 col-md-6 text-center btn-group-md">
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