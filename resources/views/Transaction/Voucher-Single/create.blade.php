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
  <link href="{{ASSETS_VENDORS}}modal/css/component.css" rel="stylesheet" />
  <link href="{{ASSETS_CSS}}pages/advmodals.css" rel="stylesheet" />

@endpush

@push('extra_js')
  <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
  <script src="{{ASSETS_JS}}pages/form_layouts.js"></script>
  <!-- <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script> -->
  <script src="{{ASSETS_JS}}change-groups.js"></script>
  <script src="{{ASSETS_JS}}change-subgroups.js"></script>
  <script src="{{ASSETS_JS}}jquery.validate.js"></script>
  <script src="{{ASSETS_JS}}voucher.js"></script>
  <script>

    var max_count =2;
    $('.add-voucher').click(function() {
      max_count++;
  var divmain = '<div class="row remove-area"><div class="col-md-12"><div class="form-body"><div class="form-group"><div class="col-md-2"><select name="main_group[]"  class="form-control groupchange" id="groupchange'+max_count+'"><option value="">--- Select ---</option>@foreach($groups as $val)<option value="{{$val->id}}">{{$val->name}}</option>@endforeach  </select><span class="color-pwd main_error" id="main_group'+max_count+'"></span></div><div class="col-md-2"><select name="sub_group[]"  class="form-control subgroupchange'+max_count+'" id="subgroupchange'+max_count+'"><option value="">--- Select ---</option></select><span class="color-pwd sub_error" id="sub_group'+max_count+'"></span></div><div class="col-md-2"><input type="text" name="debit[]" class="form-control text-right drAmount" value="0" id="drAmount'+max_count+'" placeholder="Debit"><span class="color-pwd" id="debit"></span></div><div class="col-md-2"><input type="text" name="credit[]" class="form-control text-right crAmount" value="0" id="crAmount'+max_count+'" placeholder="Credit"><span class="color-pwd" id="credit"></span></div><div class="col-md-3"><textarea name="remark[]" class="form-control" placeholder="Remark" rows="1"></textarea><span class="color-pwd" id="remark"></span></div><div class="col-md-1"><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></div></div></div></div></div>';
  $(".block").append(divmain);
});

$(document).on('click','.remove',function() {
  $(this).parents('.remove-area').remove();
  calculateDrSum();
  calculateCrSum();
});
// only numeric value
function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
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
            <li>
                <a href="{{TRANSACTION_URL_VOUCHER_SINGLE}}"> A/C List </a>
            </li>
            <li class="active">Create</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Add New
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{TRANSACTION_URL_POST_VOUCHER_SINGLE}}" id="post_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-12 alert-cyan">
                        <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                      <span class="text-dark">Branch</span>
                                        <select name="branch_name" class="form-control" required="">
                                        @foreach($branch as $val)
                                          <option value="{{$val->id}}">{{$val->name}}</option>
                                        @endforeach  
                                      </select>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Voucher no</span>
                                      <input type="text" name="voucher_no" class="form-control" placeholder="Voucher no" readonly value="{{$voucher_count + 1}}">
                                     <span class="color-pwd" id="voucher_no"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Cheque no</span>
                                      <input type="text" name="cheque_no" class="form-control" placeholder="Cheque no">
                                     <span class="color-pwd" id="cheque_no"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Date</span>
                                      <input type="date" name="date" placeholder="YYYY-MM-DD" class="form-control" value="{{date('Y-m-d')}}" data-error="Voucher date is required">
                                     <span class="color-pwd" id="date"></span>
                                    </div>
                            </div>
                          </div>
                      </div>

                    </div>
  <hr>
                    <div class="row">
                      <div class="col-md-6">  
                        <span class="text-danger font-20">Dr</span>
                      </div>
                      <div class="col-md-6">  
                       <span class="text-danger font-20">Cr</span>
                      </div>
                      <div class="col-md-6">
                        <div class="form-body">
                             <!-- Form Group  For head entry -->
                                <div class="form-group">
                                    <div class="col-md-6">
                                      <span class="text-dark">Main Group</span>
                                        <select name="main_group[]"  class="form-control groupchange" id="groupchange0">
                                          <option value="">--- Select ---</option>
                                        @foreach($groups as $val)
                                          <option value="{{$val->id}}">{{$val->name}}</option>
                                        @endforeach  
                                      </select>
                                     <span class="color-pwd main_error" id="main_group0"></span>
                                    </div>
                                    <div class="col-md-6">
                                      <span class="text-dark">Sub Group</span>
                                        <select name="sub_group[]"  class="form-control subgroupchange0" id="subgroupchange0">
                                          <option value="">--- Select ---</option>
                                      </select>
                                     <span class="color-pwd" id="sub_group0"></span>
                                    </div>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-body">
                             <!-- Form Group  For head entry -->
                                <div class="form-group">
                                    <div class="col-md-6">
                                      <span class="text-dark">Main Group</span>
                                        <select name="main_group[]"  class="form-control groupchange" id="groupchange1">
                                          <option value="">--- Select ---</option>
                                        @foreach($groups as $val)
                                          <option value="{{$val->id}}">{{$val->name}}</option>
                                        @endforeach  
                                      </select>
                                     <span class="color-pwd main_error" id="main_group1"></span>
                                    </div>
                                    <div class="col-md-6">
                                      <span class="text-dark">Sub Group</span>
                                        <select name="sub_group[]"  class="form-control subgroupchange1" id="subgroupchange1">
                                          <option value="">--- Select ---</option>
                                      </select>
                                     <span class="color-pwd" id="sub_group1"></span>
                                    </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    
                    <div class="block"></div>
                    
                    <div class="row">
                      <div class="col-md-1 text-right">
                          <strong>Amount </strong>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="total_debit" class="form-control text-right" onkeypress="return isNumberKey(event)">
                      </div>
                      <div class="col-md-3">
                        <textarea name="voucher_description" rows="1" class="form-control" placeholder="Voucher Remarks"></textarea>
                      </div>
                    </div> 
                    <hr>
                    <div class="row">
                      <div class="col-md-6 col-md-offset-3">
                        @include('mylayout.ajax-msg')
                      </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-offset-3 col-md-6 text-center btn-group-md">
                            @if(!$CheckLock)
                            <button type="submit" class="btn btn-success btn_sizes">Submit</button>
                            @endif
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