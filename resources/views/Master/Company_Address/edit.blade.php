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
      <script src="{{ASSETS_JS}}changestate.js"></script>
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
                <a href="{{MASTER_URL_COMPANY_ADDR}}">
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
            <div class="col-md-12">
                <!--lg-6 starts-->
                <!--basic form starts-->
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Master / Company Address / Edit
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{MASTER_URL_COMPANY_ADDR.''.$item->id}}" id="edit_frm" class="form-horizontal form-label-left">
                          {{csrf_field()}}
                          {{method_field('PUT')}}
                            <fieldset>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Company Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="company_name" required="required" class="form-control col-md-7 col-xs-12" value="{{$item->name}}">
                                        <span class="color-pwd padding" id="company_name"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">State</label>
                                    <div class="col-md-9">
                                        <select  name="state" class="form-control col-md-7 col-xs-12" id="mailstate">
                                          @foreach($state as $val)
                                                  <option value="{{$val->id}}" {{$val->id == $item->state_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                                @endforeach
                                        </select>
                                        <span class="color-pwd padding" id="state"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">District</label>
                                    <div class="col-md-9">
                                        <select  name="district" class="form-control col-md-7 col-xs-12" id="ajax_mailing_dist">
                                          <option value="">--- Select ---</option>
                                                @foreach($districts as $val)
                                                <option value="{{$val->id}}" {{$val->id == $item->district_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                                @endforeach
                                        </select>
                                        <span class="color-pwd padding" id="district"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Tehsil</label>
                                    <div class="col-md-9">
                                        <input type="text" name="tehsil" required="required" class="form-control col-md-7 col-xs-12" value="{{$item->tehsil}}">
                                        <span class="color-pwd padding" id="tehsil"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Address</label>
                                    <div class="col-md-9">
                                        <textarea name="address" required="required" class="form-control col-md-7 col-xs-12" cols="30" rows="3">{!! $item->address !!}</textarea>
                                        <span class="color-pwd padding" id="address"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="gstNumber">GST</label>
                                    <div class="col-md-9">
                                        <input type="text" name="gstNumber" maxlength="15" class="form-control col-md-7 col-xs-12" value="{{$item->gst_number ?? ''}}">
                                        <span class="color-pwd padding" id="gstNumber"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Pin Code</label>
                                    <div class="col-md-9">
                                        <input type="text" name="pin_code" required="required" class="form-control col-md-7 col-xs-12" value="{{$item->pin_code}}">
                                        <span class="color-pwd padding" id="pin_code"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Mobile</label>
                                    <div class="col-md-9">
                                        <input type="text" name="mobile" required="required" class="form-control col-md-7 col-xs-12" value="{{$item->mobile}}">
                                        <span class="color-pwd padding" id="mobile"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" name="email" class="form-control col-md-7 col-xs-12" value="{{$item->email}}">
                                        <span class="color-pwd padding" id="email"></span>
                                    </div>
                                </div>

                                <!-- Form actions -->
                                <div class="form-group">
                                  <div class="col-md-9 col-md-offset-3">
                                    @include('mylayout.ajax-msg')
                                  </div>
                                    <div class="col-md-12 text-center">
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
