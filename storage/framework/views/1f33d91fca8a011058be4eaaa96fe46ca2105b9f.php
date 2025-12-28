<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>
<?php $__env->startPush('extra_css'); ?>
  <link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet">
  <link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/all.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo e(ASSETS_CSS); ?>pages/form_layouts.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo e(ASSETS_CSS); ?>pages/form2.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>jquery-ui.css" />
  <link href="<?php echo e(ASSETS_VENDORS); ?>modal/css/component.css" rel="stylesheet" />
  <link href="<?php echo e(ASSETS_CSS); ?>pages/advmodals.css" rel="stylesheet" />
  <style>

        .align_right{
            text-align: right !important;
        }
        .m-0{
          margin: 0px !important;
          border: 0px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('extra_js'); ?>
  <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>pages/form_layouts.js"></script>
  <!-- <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script> -->
  <script src="<?php echo e(ASSETS_JS); ?>get-unit-type.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>change-subgroups.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>jquery.validate.js"></script>
  <!-- <script src="<?php echo e(ASSETS_JS); ?>voucher.js"></script></script> -->
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>bootbox.js"></script>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('body'); ?>
 <!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <!--section starts-->
      <h1>Login with <?php echo e(Auth::user()->name.' '.Auth::user()->last_name); ?></h1>
      <ol class="breadcrumb">
        <li>
          <a href="<?php echo e(HOME_LINK); ?>">
            <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
          </a>
        </li>
        <li>
          <a href="<?php echo e(TRADING_URL_SALE); ?>"> List </a>
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
                        <form method="post" action="<?php echo e(TRADING_URL_SALE); ?>" id="post_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                          <input type="hidden" value="<?php echo e(TRADING_URL_SALE); ?>/create" id="getUrl">
                            <input type="hidden" value="<?php echo e(route('purchase.product.get.name')); ?>" id="getProduct">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                      <div class="col-md-12 alert-cyan">
                        <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <span class="text-dark">Bill Type</span>
                                        <select name="billType" class="form-control" onchange="saleCalculateRate();">
                                            <?php $__currentLoopData = BillTypeArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($list['id']); ?>"><?php echo e($list['label']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <span class="color-pwd" id="billType"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Invoice no</span>
                                      <input type="text" name="invoice_no" class="form-control" placeholder="Invoice no" value="<?php echo e(request()->inv); ?>" readonly="">
                                     <span class="color-pwd" id="invoice_no"></span>
                                    </div>

                                    <div class="col-md-3">
                                      <span class="text-dark">Date</span>
                                      <input type="date" name="date" placeholder="YYYY-MM-DD" class="form-control" value="<?php echo e(request()->dt == TRUE ? request()->dt : date('Y-m-d')); ?>" data-error="Date is required">
                                     <span class="color-pwd" id="date"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Bill Date</span>
                                      <input type="date" name="bill_date" placeholder="YYYY-MM-DD" class="form-control" value="<?php echo e(request()->bdt == TRUE ? request()->bdt : date('Y-m-d')); ?>" data-error="Bill date is required">
                                     <span class="color-pwd" id="bill_date"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Sale To</span>
                                      <select name="sale_to" class="form-control" required="">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = getSaleParty(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list['id']); ?>" <?php echo e(request()->st == $list['id'] ? 'selected' : ''); ?>><?php echo e($list['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                        <a href="<?php echo e(route('master.sale.party.create')); ?>" target="_new" class="btn btn-default btn-sm">Add Sale Client</a>
                                     <span class="color-pwd" id="sale_by"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Product Type</span>
                                      <select name="product_party" class="form-control" required="">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $productTypeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e(request()->pr == $list->id ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                     <span class="color-pwd" id="product_party"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Sale By</span>
                                      <select name="sale_by" class="form-control" required="">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $SaleList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list); ?>" <?php echo e(request()->sb == $list ? 'selected' : ''); ?>><?php echo e($list); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                     <span class="color-pwd" id="sale_by"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Branch</span>
                                        <select name="branch_name" class="form-control" required="">
                                        <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>" <?php echo e(request()->br == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php if($message = Session::get('success')): ?>
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong><?php echo e($message); ?></strong>
</div>
<?php endif; ?>
<?php if($message = Session::get('error')): ?>
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><?php echo e($message); ?></strong>
</div>
<?php endif; ?>
                             <!-- Form Group  For head entry -->
                                <div class="row">
                                    <div class="col-md-2">
                                      <span class="text-dark">Product Name</span>
                                        <select name="product_name" class="form-control" id="product_name">
                                          <option value="">--- Select ---</option>
                                            <?php $__currentLoopData = getProductNameByTypeId(request()->pr); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($list['id']); ?>"><?php echo e($list['name'].' - '.$list['id']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                  <?php $__currentLoopData = $saleDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                  <tr id="product<?php echo e($list->id); ?>">
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($list->product_master_tbl->name); ?></td>
                                    <td><?php echo e($list->product_master_tbl->hsn); ?></td>
                                    <td><?php echo e($list->quantity); ?>  <?php echo e($list->product_master_tbl->unit_master_tbl->name); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($list->rate); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> 0</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($list->amount_without_tax); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($list->tax); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i><?php echo e($list->sgst); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($list->cgst); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($list->igst); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($list->amount); ?></td>
                                    <td>
                                      <a onclick="return confirm('Are You Sure to delete this?');" href="<?php echo e(TRADING_URL_SALE.'/productItem/'.$list->id); ?>" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                    </td>
                                  </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <tr>
                                    <td colspan="5"><strong>Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>0</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e($saleDetail->sum('amount_without_tax')); ?></strong></td>
                                    <td class="align_right"></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e($saleDetail->sum('sgst')); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e($saleDetail->sum('cgst')); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e($saleDetail->sum('igst')); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e($saleDetail->sum('amount')); ?></strong></td>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/Trading/Sale/create.blade.php ENDPATH**/ ?>