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
  <script src="<?php echo e(ASSETS_JS); ?>voucher.js"></script>
  <script>

    var max_count =2;
    $('.add-voucher').click(function() {
      max_count++;
  var divmain = '<div class="row remove-area"><div class="col-md-12"><div class="form-body"><div class="form-group"><div class="col-md-2"><select name="main_group[]"  class="form-control groupchange" id="groupchange'+max_count+'"><option value="">--- Select ---</option><?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  </select><span class="color-pwd main_error" id="main_group'+max_count+'"></span></div><div class="col-md-2"><select name="sub_group[]"  class="form-control subgroupchange'+max_count+'" id="subgroupchange'+max_count+'"><option value="">--- Select ---</option></select><span class="color-pwd sub_error" id="sub_group'+max_count+'"></span></div><div class="col-md-2"><input type="text" name="debit[]" class="form-control text-right drAmount" value="0" id="drAmount'+max_count+'" placeholder="Debit"><span class="color-pwd" id="debit"></span></div><div class="col-md-2"><input type="text" name="credit[]" class="form-control text-right crAmount" value="0" id="crAmount'+max_count+'" placeholder="Credit"><span class="color-pwd" id="credit"></span></div><div class="col-md-3"><textarea name="remark[]" class="form-control" placeholder="Remark" rows="1"></textarea><span class="color-pwd" id="remark"></span></div><div class="col-md-1"><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></div></div></div></div></div>';
  $(".block").append(divmain);
});

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
                <a href="<?php echo e(TRANSACTION_URL_VOUCHER); ?>"> A/C List </a>
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
                        <form method="post" action="<?php echo e(TRANSACTION_URL_POST_VOUCHER); ?>" id="post_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                      <div class="col-md-12 alert-cyan">
                        <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                      <span class="text-dark">Branch</span>
                                        <select name="branch_name" class="form-control" required="">
                                        <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Voucher no</span>
                                      <input type="text" name="voucher_no" class="form-control" placeholder="Voucher no" readonly value="<?php echo e($voucher_count + 1); ?>">
                                     <span class="color-pwd" id="voucher_no"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Cheque no</span>
                                      <input type="text" name="cheque_no" class="form-control" placeholder="Cheque no">
                                     <span class="color-pwd" id="cheque_no"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Date</span>
                                      <input type="date" name="date" placeholder="YYYY-MM-DD" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" data-error="Voucher date is required">
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
                                        <select name="main_group[]"  class="form-control groupchange" id="groupchange0">
                                          <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                     <span class="color-pwd main_error" id="main_group0"></span>
                                    </div>
                                    <div class="col-md-2">
                                      <span class="text-dark">Sub Group</span>
                                        <select name="sub_group[]"  class="form-control subgroupchange0" id="subgroupchange0">
                                          <option value="">--- Select ---</option>
                                      </select>
                                     <span class="color-pwd" id="sub_group0"></span>
                                    </div>
                                    <div class="col-md-2">
                                      <span class="text-dark">Debit <small>(Payment)</small></span>
                                      <input type="text" name="debit[]" class="form-control text-right drAmount" id="drAmount0" value="0" placeholder="Debit">
                                     <span class="color-pwd sub_error" id="debit"></span>
                                    </div>
                                    <div class="col-md-2">
                                      <span class="text-dark">Credit <small>(Receipt)</small></span>
                                      <input type="text" name="credit[]" class="form-control text-right crAmount" id="crAmount0" value="0" placeholder="Credit">
                                     <span class="color-pwd" id="credit"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <span class="text-dark">Remark</span>
                                      <textarea name="remark[]" class="form-control" placeholder="Remark" rows="1"></textarea>
                                      <span class="color-pwd" id="remark"></span>
                                    </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-body">
                            
                             <!-- Form Group  For head entry -->
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <select name="main_group[]"  class="form-control groupchange" id="groupchange1">
                                          <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                     <span class="color-pwd" id="main_group1"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="sub_group[]"  class="form-control subgroupchange1" id="subgroupchange1">
                                          <option value="">--- Select ---</option>
                                      </select>
                                     <span class="color-pwd" id="sub_group1"></span>
                                    </div>
                                    <div class="col-md-2">
                                      <input type="text" name="debit[]" class="form-control text-right drAmount" value="0" id="drAmount1" placeholder="Debit">
                                     <span class="color-pwd" id="debit"></span>
                                    </div>
                                    <div class="col-md-2">
                                      <input type="text" name="credit[]" class="form-control text-right crAmount" value="0" id="crAmount1" placeholder="Credit">
                                     <span class="color-pwd" id="credit"></span>
                                    </div>
                                    <div class="col-md-3">
                                      <textarea name="remark[]" class="form-control" placeholder="Remark" rows="1"></textarea>
                                      <span class="color-pwd" id="remark"></span>
                                    </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="block"></div>
                    <div class="row">
                      <div class="col-md-2">
                          <button type="button" class="btn btn-default add-voucher"><i class="fa fa-plus"></i> Add More</button>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2 col-md-offset-2 text-right">
                          <strong>Total </strong>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="total_debit" class="form-control text-right" id="sumDr" value="0.00" readonly>
                      </div>
                      <div class="col-md-2">
                          <input type="text" name="total_credit" class="form-control text-right" id="sumCr" value="0.00" readonly>
                      </div>
                      <div class="col-md-3">
                        <textarea name="voucher_description" rows="1" class="form-control" placeholder="Voucher Description"></textarea>
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
                            <button type="submit" class="btn btn-success btn_sizes">Submit</button>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Transaction/Voucher/create.blade.php ENDPATH**/ ?>