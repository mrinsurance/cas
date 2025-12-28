@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
<link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
<link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
<link href="{{ASSETS_CSS}}pages/form2.css" rel="stylesheet"/>
@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
    <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}edit-record.js"></script>

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
                <a href="{{MASTER_URL_PRODUCTS}}">
                    List
                </a>
            </li>
            <li class="active">Edit</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <div class="row">
            <!--row starts-->
            <div class="col-md-6 col-md-offset-3">
                <!--lg-6 starts-->
                <!--basic form starts-->
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Master / Products / Edit
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{MASTER_URL_PRODUCTS.'/'.$item->id}}" id="edit_frm" class="form-horizontal form-label-left">
  {{csrf_field()}}
  {{method_field('PUT')}}
                            <fieldset>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Product Name</label>
                                    <div class="col-md-9">
                                       <input type="text" name="name" required="required" class="form-control col-md-7 col-xs-12" value="{{$item->name}}">
                                        <span class="color-pwd padding" id="name"></span>
                                    </div>
                                </div>

                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Purchase Rate</label>
                                    <div class="col-md-9">
                                       <input type="text" name="purchase_rate" required="required" class="form-control col-md-7 col-xs-12" value="{{$item->purchase_rate}}">
                                        <span class="color-pwd padding" id="purchase_rate"></span>
                                    </div>
                                </div>

                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Sale Rate</label>
                                    <div class="col-md-9">
                                       <input type="text" name="sale_rate" required="required" class="form-control col-md-7 col-xs-12" value="{{$item->sale_rate}}">
                                        <span class="color-pwd padding" id="sale_rate"></span>
                                    </div>
                                </div>

                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Product Type</label>
                                    <div class="col-md-9">
                                        <select name="product_type" class="form-control" required>
                                            <option value="">--- Select ---</option>
                                            @foreach($prd_types as $list)
                                                <option value="{{$list->id}}" {{$list->id == $item->product_type_master_tbl_id ? 'selected' : ''}}>{{$list->name}}</option>
                                            @endforeach    
                                        </select>
                                        <span class="color-pwd padding" id="product_type"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Unit</label>
                                    <div class="col-md-9">
                                        <select name="unit" class="form-control" required>
                                            <option value="">--- Select ---</option>
                                            @foreach($units as $list)
                                                <option value="{{$list->id}}" {{$list->id == $item->unit_master_tbl_id ? 'selected' : ''}}>{{$list->name}}</option>
                                            @endforeach    
                                        </select>
                                        <span class="color-pwd padding" id="unit"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Tax</label>
                                    <div class="col-md-9">
                                        <select name="tax" class="form-control" required>
                                            <option value="">--- Select ---</option>
                                            @foreach($taxes as $list)
                                                <option value="{{$list->id}}" {{$list->id == $item->tax_master_tbl_id ? 'selected' : ''}}>{{$list->name}}</option>
                                            @endforeach    
                                        </select>
                                        <span class="color-pwd padding" id="tax"></span>
                                    </div>
                                </div>
                                
                                <!-- Form actions -->
                                <div class="form-group">
                                  <div class="col-md-9 col-md-offset-3">
                                    @include('mylayout.ajax-msg')
                                  </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-responsive btn-primary btn-sm">Update</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        <!--main content ends--> 
      </section>
    <!-- content --> 
  </aside>
<!-- right-side -->
@endsection