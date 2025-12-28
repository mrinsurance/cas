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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
  <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>pages/form_layouts.js"></script>
  <!-- <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script> -->
  <script src="<?php echo e(ASSETS_JS); ?>change-groups.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>change-subgroups.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>jquery.validate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>edit-voucher.js"></script>
  <script>

$(document).on('click','.remove',function() {
  $(this).parents('.remove-area').remove();
  calculateDrSum();
  calculateCrSum();
});

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
                <a href="<?php echo e(TRANSACTION_URL_VOUCHER); ?>"> Voucher List </a>
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
                        <form method="post" action="<?php echo e(TRANSACTION_URL_POST_VOUCHER.'/'.$item->id); ?>" id="edit_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('PUT')); ?>

                    <div class="row">
                      <div class="col-md-12 alert-cyan">
                        <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                      <span class="text-dark">Branch</span>
                                        <select name="branch_name" class="form-control" required="">
                                          <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>" <?php echo e($item->branch_model_id == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Voucher no</span>
                                      <input type="text" name="voucher_no" class="form-control" placeholder="Voucher no" readonly value="<?php echo e($item->voucher_no); ?>">
                                     <span class="color-pwd" id="voucher_no"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Cheque no</span>
                                      <input type="text" name="cheque_no" class="form-control" placeholder="Cheque no" value="<?php echo e($item->cheque_no); ?>">
                                     <span class="color-pwd" id="cheque_no"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Date</span>
                                      <input type="date" name="date" placeholder="YYYY-MM-DD" class="form-control" id="voucher_date" value="<?php echo e($item->voucher_date); ?>" data-error="Voucher date is required">
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
<?php $__currentLoopData = $tbl_ledger_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledgerItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
<input type="hidden" name="voucher_ledger_id[]" value="<?php echo e($ledgerItem->id); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php $i = 0; ?>
    <?php $__currentLoopData = $voucher_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucherItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <input type="hidden" name="voucher_detail_id[]" value="<?php echo e($voucherItem->id); ?>">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-body">
                            
                             <!-- Form Group  For head entry -->
                                <div class="form-group">
                                    <div class="col-md-2">
                                     
                                        <select name="main_group[]"  class="form-control groupchange" id="groupchange<?php echo e($i); ?>">
                                          <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>" <?php echo e($val->id == $voucherItem->group_master_model_id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                     <span class="color-pwd main_error" id="main_group0"></span>
                                    </div>
                                    <div class="col-md-2">
                                      
                                        <select name="sub_group[]"  class="form-control subgroupchange<?php echo e($i); ?>" id="subgroupchange<?php echo e($i); ?>">
                                          <option value="">--- Select ---</option>
                                          <?php $__currentLoopData = $subGroups->where('group_master_model_id',$voucherItem->group_master_model_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>" <?php echo e($val->id == $voucherItem->subgroup_master_model_id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                     <span class="color-pwd" id="sub_group<?php echo e($i); ?>"></span>
                                    </div>
                                    <div class="col-md-2">
                                      
                                      <input type="text" name="debit[]" class="form-control text-right drAmount" id="drAmount<?php echo e($i); ?>" placeholder="Debit" value="<?php echo e($voucherItem->dr_amount); ?>">
                                     <span class="color-pwd sub_error" id="debit"></span>
                                    </div>
                                    <div class="col-md-2">
                                      
                                      <input type="text" name="credit[]" class="form-control text-right crAmount" id="crAmount<?php echo e($i); ?>" placeholder="Credit" value="<?php echo e($voucherItem->cr_amount); ?>">
                                     <span class="color-pwd" id="credit"></span>
                                    </div>
                                    <div class="col-md-3">
                                      
                                      <textarea name="remark[]" class="form-control" placeholder="Remark" rows="1"><?php echo e($voucherItem->remarks); ?></textarea>
                                      <span class="color-pwd" id="remark"></span>
                                    </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    <?php $i++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <div class="row">
                      <div class="col-md-2 col-md-offset-2 text-right">
                          <strong>Total </strong>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="total_debit" class="form-control text-right" id="sumDr" value="<?php echo e($item->amount); ?>" readonly>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="total_credit" class="form-control text-right" id="sumCr" value="<?php echo e($item->amount); ?>" readonly>
                      </div>
                      <div class="col-md-3">
                        <textarea name="voucher_description" rows="1" class="form-control" placeholder="Voucher Description"><?php echo $item->voucher_desc; ?></textarea>
                      </div>
                    </div> 
                    <hr>
                    <div class="row">
                      <div class="col-md-6 col-md-offset-3">
                        <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-offset-3 col-md-6 text-center btn-group-md">
                            <?php if(!$CheckLock): ?>
                            <button type="submit" class="btn btn-success btn_sizes">Update</button>
                            <?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbatran/resources/views/Transaction/Voucher/edit.blade.php ENDPATH**/ ?>