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
                <a href="{{MASTER_URL_GROUP}}">
                    List
                </a>
            </li>
            <li class="active">Create</li>
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
                            Master / Groups / Create
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{MASTER_URL_POST_GROUP}}" id="post_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                            <fieldset>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Group</label>
                                    <div class="col-md-9">
                                        <textarea name="name" cols="20" rows="5" required="required" class="form-control col-md-7 col-xs-12"></textarea>
                                        <span class="color-pwd padding" id="name"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Visibiity On Balance Sheet</label>
                                    <div class="col-md-9">
                                        <select name="visibiity" required="required" class="form-control col-md-7 col-xs-12">
                                          <option value="1">Yes</option>
                                          <option value="0">No</option>
                                        </select> 
                                        <span class="color-pwd padding" id="visibiity"></span>
                                    </div>
                                </div>
                                                                                                                                
                                <!-- Form actions -->
                                <div class="form-group">
                                  <div class="col-md-9 col-md-offset-3">
                                    @include('mylayout.ajax-msg')
                                  </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-responsive btn-primary btn-sm">Submit</button>
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