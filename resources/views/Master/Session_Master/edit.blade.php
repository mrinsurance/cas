@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
<link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
<link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
<link href="{{ASSETS_CSS}}pages/form2.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ASSETS_CSS}}bootstrap-datepicker3.css">
@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
    <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}edit-record.js"></script>
      <script type="text/javascript" src="{{ASSETS_JS}}bootstrap-datepicker.min.js"></script>
  <script>
// Date Picker
  $(document).ready(function(){
      var date_input=$('#date_start'); //our date input has the name "date"
      var date_input2=$('#date_end'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'yyyy-mm-dd',

        container: container,

        todayHighlight: true,

        autoclose: true,

        calendarWeeks: true,
   
      startView: 2
      };
      date_input.datepicker(options);
      date_input2.datepicker(options);

    })
</script>
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
                <a href="{{MASTER_URL_SESSION}}">
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
                            Master / Seesion / Edit
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{MASTER_URL_SESSION.''.$item->id}}" id="edit_frm" class="form-horizontal form-label-left">
  {{csrf_field()}}
  {{method_field('PUT')}}
                            <fieldset>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Start Date</label>
                                    <div class="col-md-9">
                                        <input type="text" name="start_date" placeholder="yyyy-mm-dd" required="required" class="date-picker form-control col-md-7 col-xs-12" id="date_start" readonly value="{{$item->start_date}}">
                                        <span class="color-pwd padding" id="start_date"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">End Date</label>
                                    <div class="col-md-9">
                                        <input type="text" name="end_date" placeholder="yyyy-mm-dd" required="required" class="form-control col-md-7 col-xs-12" id="date_end" readonly value="{{$item->end_date}}">
                                        <span class="color-pwd padding" id="end_date"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Status</label>
                                    <div class="col-md-9">
                                        <select name="status" required="required" class="form-control col-md-7 col-xs-12">
                                          <option value="1" {{$item->status == 1 ? 'selected' : ''}}>Active</option>
                                          <option value="0" {{$item->status == 0 ? 'selected' : ''}}>InActive</option>
                                        </select>
                                        <span class="color-pwd padding" id="status"></span>
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