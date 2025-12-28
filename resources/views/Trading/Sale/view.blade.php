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
  <style>
       
        .align_right{
            text-align: right !important;
        }
        .m-0{
          margin: 0px !important;
          border: 0px;
        }
    </style>
@endpush
@push('extra_js')
  <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
  <script src="{{ASSETS_JS}}pages/form_layouts.js"></script>
  <!-- <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script> -->
  <script src="{{ASSETS_JS}}get-unit-type.js"></script>
  <script src="{{ASSETS_JS}}change-subgroups.js"></script>
  <script src="{{ASSETS_JS}}jquery.validate.js"></script>
  <!-- <script src="{{ASSETS_JS}}voucher.js"></script></script> -->
    <script type="text/javascript" src="{{ASSETS_JS}}bootbox.js"></script>
        <script type="text/javascript">
    function printDiv(printRecord){
          var printContents = $('#record').html();
          var originalContents = document.body.innerHTML;      
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
    };
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
          <a href="{{TRADING_URL_SALE}}"> List </a>
        </li>
        <li class="active">View/Print</li>
      </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                      <h3 class="panel-title">
                          <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> View/Print
                      </h3>
                  </div>
                    <div class="panel-body">
                    <form method="post" action="#" class="form-horizontal form-label-left">
                      <div class="row mb-10">
                        <div class="col-md-12 text-center">
                          <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-default">Print</button>
                        </div>
                      </div>
                      <div class="prnt" id="record">
                        <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>
                                {{$company_address->name}}
                            </h3>
                                {{$company_address->address}}
                            <h4>
                                SALE BILL
                            </h4> 
                            <hr>   
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 alert-cyan">
                        <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Invoice no</span>
                                      <input type="text" name="invoice_no" class="form-control" placeholder="Invoice no" value="{{$item->invoice_no}}" readonly="">
                                     <span class="color-pwd" id="invoice_no"></span>
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Date</span>
                                      <input type="date" name="date" placeholder="YYYY-MM-DD" class="form-control" value="{{$item->date_of_transaction ? $item->date_of_transaction : date('Y-m-d')}}" data-error="Date is required">
                                     <span class="color-pwd" id="date"></span>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Bill Date</span>
                                      <input type="date" name="bill_date" placeholder="YYYY-MM-DD" class="form-control" value="{{$item->billing_date ? $item->billing_date : date('Y-m-d')}}" data-error="Bill date is required">
                                     <span class="color-pwd" id="bill_date"></span>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Client</span>
                                      <select name="client" class="form-control" required="">
                                        <option value="">Select</option>
                                        @foreach($clients as $list)
                                        <option value="{{$list->name}}" {{$item->client == $list->name ? 'selected' : ''}}>{{$list->name}}</option>
                                        @endforeach
                                      </select>
                                     <span class="color-pwd" id="client"></span>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Product Type</span>
                                      <select name="product_party" class="form-control" required="">
                                        <option value="">Select</option>
                                        @foreach($productTypeList as $list)
                                        <option value="{{$list->id}}" {{$item->product_type_master_tbl_id == $list->id ? 'selected' : ''}}>{{$list->name}}</option>
                                        @endforeach
                                      </select>
                                     <span class="color-pwd" id="product_party"></span>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Branch</span>
                                        <select name="branch_name" class="form-control" required="">
                                        @foreach($branch as $val)
                                          <option value="{{$val->id}}" {{$item->branch_model_id == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                        @endforeach  
                                      </select>
                                    </div>
                            </div>
                          </div>
                      </div>
                    </div>                    
                    </form>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="portlet-body">
                        @include('mylayout.ajax-msg')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">HSN No.</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Tax (%)</th>
                                        <th scope="col">SGST</th>
                                        <th scope="col">CGST</th>
                                        <th scope="col">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($saleDetail as $list)
                                  <tr id="product{{$list->id}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$list->product_master_tbl->name}}</td>
                                    <td>{{$list->product_master_tbl->hsn}}</td>
                                    <td>{{$list->quantity}} {{$list->product_master_tbl->unit_master_tbl->name}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($list->amount_without_tax,2)}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($list->tax,2)}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i>{{number_format($list->sgst,2)}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($list->cgst,2)}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($list->amount,2)}}</td>
                                    
                                  </tr>  
                                  @endforeach 
                                  <tr>
                                    <td colspan="5"><strong>Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saleDetail->sum('sgst'),2)}}</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saleDetail->sum('cgst'),2)}}</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{number_format($saleDetail->sum('amount'),2)}}</strong></td>
                                    
                                  </tr>                                 
                                </tbody>
                            </table>
                        </div>
                    </div>                       
                      </div>
                    </div> 
                    </div>                    
                 
                </div>
              </div>
          </div>
        </div>
    </section>
    <!-- content -->
</aside>
@endsection