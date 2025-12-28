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
        <script type="text/javascript">
    function printDiv(printRecord){
          var printContents = $('#record').html();
          var originalContents = document.body.innerHTML;      
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
    };
    </script>

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
                                <?php echo e($company_address->name); ?>

                            </h3>
                                <?php echo e($company_address->address); ?>

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
                                      <input type="text" name="invoice_no" class="form-control" placeholder="Invoice no" value="<?php echo e($item->invoice_no); ?>" readonly="">
                                     <span class="color-pwd" id="invoice_no"></span>
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Date</span>
                                      <input type="date" name="date" placeholder="YYYY-MM-DD" class="form-control" value="<?php echo e($item->date_of_transaction ? $item->date_of_transaction : date('Y-m-d')); ?>" data-error="Date is required">
                                     <span class="color-pwd" id="date"></span>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Bill Date</span>
                                      <input type="date" name="bill_date" placeholder="YYYY-MM-DD" class="form-control" value="<?php echo e($item->billing_date ? $item->billing_date : date('Y-m-d')); ?>" data-error="Bill date is required">
                                     <span class="color-pwd" id="bill_date"></span>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Client</span>
                                      <select name="client" class="form-control" required="">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->name); ?>" <?php echo e($item->client == $list->name ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                     <span class="color-pwd" id="client"></span>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Product Type</span>
                                      <select name="product_party" class="form-control" required="">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $productTypeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e($item->product_type_master_tbl_id == $list->id ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                     <span class="color-pwd" id="product_party"></span>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <span class="text-dark">Branch</span>
                                        <select name="branch_name" class="form-control" required="">
                                        <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>" <?php echo e($item->branch_model_id == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
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
                                        <th scope="col">Tax (%)</th>
                                        <th scope="col">SGST</th>
                                        <th scope="col">CGST</th>
                                        <th scope="col">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $saleDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr id="product<?php echo e($list->id); ?>">
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($list->product_master_tbl->name); ?></td>
                                    <td><?php echo e($list->product_master_tbl->hsn); ?></td>
                                    <td><?php echo e($list->quantity); ?> <?php echo e($list->product_master_tbl->unit_master_tbl->name); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($list->amount_without_tax,2)); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($list->tax,2)); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i><?php echo e(number_format($list->sgst,2)); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($list->cgst,2)); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($list->amount,2)); ?></td>
                                    
                                  </tr>  
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                  <tr>
                                    <td colspan="5"><strong>Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($saleDetail->sum('sgst'),2)); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($saleDetail->sum('cgst'),2)); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($saleDetail->sum('amount'),2)); ?></strong></td>
                                    
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbatran/resources/views/Trading/Sale/view.blade.php ENDPATH**/ ?>