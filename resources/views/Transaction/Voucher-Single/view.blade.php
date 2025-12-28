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
            <li class="active">View Voucher</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> View Voucher
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="#" class="form-horizontal form-label-left">
                    <div class="row">
                      <div class="col-md-12 alert-cyan">
                        <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                      <span class="text-dark">Branch</span>
                                        <select class="form-control" disabled>
                                          <option value="">{{$item->branch_model->name}}</option> 
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Voucher no</span>
                                      <input type="text" class="form-control" placeholder="Voucher no" value="{{$item->voucher_no}}" disabled>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Cheque no</span>
                                      <input type="text" class="form-control" placeholder="Cheque no" value="{{$item->cheque_no}}" disabled="">
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Date</span>
                                      <input type="text" class="form-control" value="{{$item->voucher_date}}" disabled="">
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
  @php $i = 0; @endphp
    @foreach($voucher_list as $voucherItem)
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-body">                            
                             <!-- Form Group  For head entry -->
                                <div class="form-group">
                                    <div class="col-md-2">              
                                        <select class="form-control" disabled="">
                                            <option value="">{{@$voucherItem->group_master_model->name}}</option>
                                      </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" disabled="">
                                          <option value="">{{@$voucherItem->subgroup_master_model->name}}</option>
                                      </select>
                                    </div>
                                    <div class="col-md-2">
                                      <input type="text" class="form-control text-right" placeholder="Debit" value="{{$voucherItem->dr_amount}}" disabled="">
                                    </div>
                                    <div class="col-md-2">
                                      <input type="text" class="form-control text-right" placeholder="Credit" value="{{$voucherItem->cr_amount}}" disabled="">
                                    </div>
                                    <div class="col-md-3">
                                      <textarea class="form-control" placeholder="Remark" rows="1" disabled="">{{$voucherItem->remarks}}</textarea>
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
                          <input type="text" class="form-control text-right" value="{{$item->amount}}" disabled>
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control text-right" value="{{($item->amount)}}" disabled>
                      </div>
                      <div class="col-md-3">
                        <textarea rows="1" class="form-control" placeholder="Voucher Description" disabled>{!! $item->voucher_desc !!}</textarea>
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