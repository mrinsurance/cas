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
  <script src="{{ASSETS_JS}}edit-voucher.js"></script>
  <script>

$(document).on('click','.remove',function() {
  $(this).parents('.remove-area').remove();
  calculateDrSum();
  calculateCrSum();
});

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
                <a href="{{TRANSACTION_URL_VOUCHER}}"> Voucher List </a>
            </li>
            <li class="active">Edit Voucher</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Edit
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{TRANSACTION_URL_POST_VOUCHER.'/'.$item->id}}" id="edit_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="row">
                      <div class="col-md-12 alert-cyan">
                        <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                      <span class="text-dark">Branch</span>
                                        <select name="branch_name" class="form-control" required="">
                                          <option value="">--- Select ---</option>
                                        @foreach($branch as $val)
                                          <option value="{{$val->id}}" {{$item->branch_model_id == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                        @endforeach  
                                      </select>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Voucher no</span>
                                      <input type="text" name="voucher_no" class="form-control" placeholder="Voucher no" readonly value="{{$item->voucher_no}}">
                                     <span class="color-pwd" id="voucher_no"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Cheque no</span>
                                      <input type="text" name="cheque_no" class="form-control" placeholder="Cheque no" value="{{$item->cheque_no}}">
                                     <span class="color-pwd" id="cheque_no"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Date</span>
                                      <input type="text" name="date" placeholder="YYYY-MM-DD" class="form-control" id="voucher_date" value="{{$item->voucher_date}}" data-error="Voucher date is required" readonly>
                                     <span class="color-pwd" id="date"></span>
                                    </div>
                            </div>
                          </div>
                      </div>

                    </div>
  <hr>
  <div class="row">
                      <div class="col-md-12">
                        <div class="form-body">
                            
                             <!-- Form Group  For head entry -->
                                <div class="form-group">
                                    <div class="col-md-2">
                                      <span class="text-dark">Main Group</span>
                                        
                                    </div>
                                    <div class="col-md-2">
                                      <span class="text-dark">Sub Group</span>
                                        
                                    </div>
                                    <div class="col-md-2">
                                      <span class="text-dark">Debit <small>(Payment)</small></span>
                                      
                                    </div>
                                    <div class="col-md-2">
                                      <span class="text-dark">Credit <small>(Receipt)</small></span>
                                      
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Remark</span>
                                      
                                    </div>
                            </div>
                          </div>
                      </div>
                    </div>
@foreach($tbl_ledger_list as $ledgerItem)                    
<input type="hidden" name="voucher_ledger_id[]" value="{{$ledgerItem->id}}">
@endforeach
  @php $i = 0; @endphp
    @foreach($voucher_list as $voucherItem)
    <input type="hidden" name="voucher_detail_id[]" value="{{$voucherItem->id}}">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-body">
                            
                             <!-- Form Group  For head entry -->
                                <div class="form-group">
                                    <div class="col-md-2">
                                     
                                        <select name="main_group[]"  class="form-control groupchange" id="groupchange{{$i}}">
                                          <option value="">--- Select ---</option>
                                        @foreach($groups as $val)
                                          <option value="{{$val->id}}" {{$val->id == $voucherItem->group_master_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                        @endforeach  
                                      </select>
                                     <span class="color-pwd main_error" id="main_group0"></span>
                                    </div>
                                    <div class="col-md-2">
                                      
                                        <select name="sub_group[]"  class="form-control subgroupchange{{$i}}" id="subgroupchange{{$i}}">
                                          <option value="">--- Select ---</option>
                                          @foreach($subGroups->where('group_master_model_id',$voucherItem->group_master_model_id) as $val)
                                          <option value="{{$val->id}}" {{$val->id == $voucherItem->subgroup_master_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                        @endforeach  
                                      </select>
                                     <span class="color-pwd" id="sub_group{{$i}}"></span>
                                    </div>
                                    <div class="col-md-2">
                                      
                                      <input type="text" name="debit[]" class="form-control text-right drAmount" id="drAmount{{$i}}" placeholder="Debit" value="{{$voucherItem->dr_amount}}">
                                     <span class="color-pwd sub_error" id="debit"></span>
                                    </div>
                                    <div class="col-md-2">
                                      
                                      <input type="text" name="credit[]" class="form-control text-right crAmount" id="crAmount{{$i}}" placeholder="Credit" value="{{$voucherItem->cr_amount}}">
                                     <span class="color-pwd" id="credit"></span>
                                    </div>
                                    <div class="col-md-3">
                                      
                                      <textarea name="remark[]" class="form-control" placeholder="Remark" rows="1">{{$voucherItem->remarks}}</textarea>
                                      <span class="color-pwd" id="remark"></span>
                                    </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    @php $i++; @endphp
                    @endforeach
                    
                    <div class="row">
                      <div class="col-md-2 col-md-offset-2 text-right">
                          <strong>Total </strong>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="total_debit" class="form-control text-right" id="sumDr" value="{{$item->amount}}" readonly>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="total_credit" class="form-control text-right" id="sumCr" value="{{$item->amount}}" readonly>
                      </div>
                      <div class="col-md-3">
                        <textarea name="voucher_description" rows="1" class="form-control" placeholder="Voucher Description">{!! $item->voucher_desc !!}</textarea>
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
                            <button type="submit" class="btn btn-success btn_sizes">Update</button>
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