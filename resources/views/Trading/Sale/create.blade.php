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
                          <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Sale Party
                      </h3>
                  </div>
                    <div class="panel-body">
                        <form method="post" action="{{TRADING_URL_SALE}}" id="post_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                          <input type="hidden" value="{{TRADING_URL_SALE}}/create" id="getUrl">
                            <input type="hidden" value="{{ route('purchase.product.get.name') }}" id="getProduct">
                    {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-12 alert-cyan">
                        <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <span class="text-dark">Bill Type</span>
                                        <select name="billType" class="form-control" onchange="saleCalculateRate();">
                                            @foreach(BillTypeArray() as $list)
                                                <option value="{{ $list['id'] }}">{{ $list['label'] }}</option>
                                            @endforeach
                                        </select>
                                        <span class="color-pwd" id="billType"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Invoice no</span>
                                      <input type="text" name="invoice_no" class="form-control" placeholder="Invoice no" value="{{request()->inv}}" readonly="">
                                     <span class="color-pwd" id="invoice_no"></span>
                                    </div>

                                    <div class="col-md-3">
                                      <span class="text-dark">Date</span>
                                      <input type="date" name="date" placeholder="YYYY-MM-DD" class="form-control" value="{{request()->dt == TRUE ? request()->dt : date('Y-m-d')}}" data-error="Date is required">
                                     <span class="color-pwd" id="date"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Bill Date</span>
                                      <input type="date" name="bill_date" placeholder="YYYY-MM-DD" class="form-control" value="{{request()->bdt == TRUE ? request()->bdt : date('Y-m-d')}}" data-error="Bill date is required">
                                     <span class="color-pwd" id="bill_date"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Sale To</span>
                                      <select name="sale_to" class="form-control" required="">
                                        <option value="">Select</option>
                                        @foreach(getSaleParty() as $list)
                                        <option value="{{$list['id']}}" {{ request()->st == $list['id'] ? 'selected' : ''}}>{{$list['name']}}</option>
                                        @endforeach
                                      </select>
                                        <a href="{{ route('master.sale.party.create') }}" target="_new" class="btn btn-default btn-sm">Add Sale Client</a>
                                     <span class="color-pwd" id="sale_by"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Product Type</span>
                                      <select name="product_party" class="form-control" required="">
                                        <option value="">Select</option>
                                        @foreach($productTypeList as $list)
                                        <option value="{{$list->id}}" {{request()->pr == $list->id ? 'selected' : ''}}>{{$list->name}}</option>
                                        @endforeach
                                      </select>
                                     <span class="color-pwd" id="product_party"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Sale By</span>
                                      <select name="sale_by" class="form-control" required="">
                                        <option value="">Select</option>
                                        @foreach($SaleList as $list)
                                        <option value="{{$list}}" {{request()->sb == $list ? 'selected' : ''}}>{{$list}}</option>
                                        @endforeach
                                      </select>
                                     <span class="color-pwd" id="sale_by"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Branch</span>
                                        <select name="branch_name" class="form-control" required="">
                                        @foreach($branch as $val)
                                          <option value="{{$val->id}}" {{request()->br == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-body">
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ $message }}</strong>
</div>
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
</div>
@endif
                             <!-- Form Group  For head entry -->
                                <div class="row">
                                    <div class="col-md-2">
                                      <span class="text-dark">Product Name</span>
                                        <select name="product_name" class="form-control" id="product_name">
                                          <option value="">--- Select ---</option>
                                            @foreach(getProductNameByTypeId(request()->pr) as $list)
                                                <option value="{{$list['id']}}">{{$list['name'].' - '.$list['id']}}</option>
                                            @endforeach
                                      </select>
                                     <span class="color-pwd" id="product_name"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="text-dark">Product Stock</span>
                                        <input type="text" name="productStock" class="form-control text-right" readonly>
                                    </div>
                                    <div class="col-md-2">
                                      <span class="text-dark">Quantity <span id="unit_text"></span></span>
                                      <input type="text" name="quantity" class="form-control text-right" placeholder="Quantity" id="quantity_id" onblur="saleCalculateRate();">
                                     <span class="color-pwd sub_error" id="quantity"></span>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="text-dark">Total Cost</span>
                                        <input type="text" name="total_cost" class="form-control text-right" placeholder="Total Cost" onblur="totalCost(this.value);">
                                        <span class="color-pwd sub_error" id="total_cost"></span>
                                    </div>

                                    <div class="col-md-2">
                                      <span class="text-dark">Cost</span>
                                      <input type="text" name="cost" class="form-control text-right" placeholder="Cost" id="cost_id" onblur="saleCalculateRate();">
                                     <span class="color-pwd" id="cost"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="text-dark includeGstLabel">Including GST</span>
                                        <input type="checkbox" name="includingGst" class="form-control" placeholder="Including GST" onchange="saleCalculateRate();" checked>
                                        <span class="color-pwd" id="includingGst"></span>
                                    </div>
                                </div>
                                   <div class="row">

                                    <div class="col-md-2">
                                      <span class="text-dark">Tax</span>
                                      <input name="tax" id="tax_id" class="form-control" readonly />
                                     <span class="color-pwd" id="tax"></span>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="text-dark">Rate</span>
                                        <input type="text" name="rate" class="form-control text-right" placeholder="Rate" id="rate_id">
                                        <span class="color-pwd" id="rate"></span>
                                    </div>

                                    <div class="col-md-2">
                                      <span class="text-dark">CGST</span>
                                      <input type="text" name="cgst" class="form-control text-right" placeholder="CGST" id="cgst_id">
                                     <span class="color-pwd" id="cgst"></span>
                                    </div>
                                    <div class="col-md-2">
                                      <span class="text-dark">SGST</span>
                                      <input type="text" name="sgst" class="form-control text-right" placeholder="SGST" id="sgst_id">
                                     <span class="color-pwd" id="sgst"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="text-dark">IGST</span>
                                        <input type="text" name="igst" class="form-control text-right" placeholder="IGST" id="igst_id">
                                        <span class="color-pwd" id="igst"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="text-dark">Total Amount</span>
                                        <input type="text" name="total_amount" class="form-control text-right" placeholder="Total Amount" id="total_amount_id">
                                        <span class="color-pwd" id="total_amount"></span>
                                    </div>
                                   </div>
                                <div class="row">

                                    <div class="col-md-12 text-right">
                                      <button type="submit" class="btn btn-success btn_sizes">Submit</button>
                                    </div>
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
                                        <th scope="col">Discount</th>
                                        <th scope="col">Taxable Value</th>
                                        <th scope="col">Tax (%)</th>
                                        <th scope="col">SGST</th>
                                        <th scope="col">CGST</th>
                                        <th scope="col">IGST</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($saleDetail as $list)

                                  <tr id="product{{$list->id}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$list->product_master_tbl->name}}</td>
                                    <td>{{$list->product_master_tbl->hsn}}</td>
                                    <td>{{$list->quantity}}  {{$list->product_master_tbl->unit_master_tbl->name}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$list->rate}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> 0</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$list->amount_without_tax}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$list->tax}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i>{{$list->sgst}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$list->cgst}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$list->igst}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$list->amount}}</td>
                                    <td>
                                      <a onclick="return confirm('Are You Sure to delete this?');" href="{{TRADING_URL_SALE.'/productItem/'.$list->id}}" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                    </td>
                                  </tr>
                                  @endforeach
                                  <tr>
                                    <td colspan="5"><strong>Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>0</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{$saleDetail->sum('amount_without_tax')}}</strong></td>
                                    <td class="align_right"></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{$saleDetail->sum('sgst')}}</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{$saleDetail->sum('cgst')}}</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{$saleDetail->sum('igst')}}</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>{{$saleDetail->sum('amount')}}</strong></td>
                                    <td>&nbsp;</td>
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
    </section>
    <!-- content -->
</aside>
@endsection