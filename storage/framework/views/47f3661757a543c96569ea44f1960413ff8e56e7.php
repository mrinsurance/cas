<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
<link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
<link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo e(ASSETS_CSS); ?>pages/form2.css" rel="stylesheet"/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(ASSETS_VENDORS); ?>favicon/favicon.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>pages/form_examples.js"></script>
    <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>edit-record.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Hello Admin</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(FINANCIAL_YEAR_END_URL); ?>">
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
            <div class="col-md-6 col-md-offset-3">
                <!--lg-6 starts-->
                <!--basic form starts-->
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Financial Year / Year End
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?php echo e(FINANCIAL_YEAR_END_URL.'/'.$item->id); ?>" id="edit_frm" class="form-horizontal form-label-left">
                    <?php echo e(csrf_field()); ?>

                      <?php echo e(method_field('PUT')); ?>

                            <fieldset>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Financial Year</label>
                                    <div class="col-md-7">
                                       <select name="financial_year" class="form-control" required>
                                        <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $session_years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($list->id); ?>" <?php echo e($list->id == $item->session_master_model_id ? 'selected' : ''); ?>><?php echo e(date('Y', strtotime($list->start_date))); ?> - <?php echo e(date('Y', strtotime($list->end_date))); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                    </select>
                                        <span class="color-pwd padding" id="financial_year"></span>
                                    </div>
                                </div>

                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Opening Stock Depot 1</label>
                                    <div class="col-md-7">
                                       <input type="text" name="opening_stock_depot1"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->opening_stock_depot1); ?>">
                                        <span class="color-pwd padding" id="opening_stock_depot1"></span>
                                    </div>
                                </div>

                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Opening Stock Depot 2</label>
                                    <div class="col-md-7">
                                       <input type="text" name="opening_stock_depot2"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->opening_stock_depot2); ?>">
                                        <span class="color-pwd padding" id="opening_stock_depot2"></span>
                                    </div>
                                </div>

                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Opening Stock Depot 3</label>
                                    <div class="col-md-7">
                                         <input type="text" name="opening_stock_depot3"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->opening_stock_depot3); ?>">
                                        <span class="color-pwd padding" id="opening_stock_depot3"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                 <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Closing Stock Depot 1</label>
                                    <div class="col-md-7">
                                       <input type="text" name="closing_stock_depot1"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->closing_stock_depot1); ?>">
                                        <span class="color-pwd padding" id="closing_stock_depot1"></span>
                                    </div>
                                </div>

                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Closing Stock Depot 2</label>
                                    <div class="col-md-7">
                                       <input type="text" name="closing_stock_depot2"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->closing_stock_depot2); ?>">
                                        <span class="color-pwd padding" id="closing_stock_depot2"></span>
                                    </div>
                                </div>

                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Closing Stock Depot 3</label>
                                    <div class="col-md-7">
                                         <input type="text" name="closing_stock_depot3"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->closing_stock_depot3); ?>">
                                        <span class="color-pwd padding" id="closing_stock_depot3"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">NPA Amount</label>
                                    <div class="col-md-7">
                                         <input type="text" name="npa_amount"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->npa_amount); ?>">
                                        <span class="color-pwd padding" id="npa_amount"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">NPA Interest</label>
                                    <div class="col-md-7">
                                         <input type="text" name="npa_int"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->npa_int); ?>">
                                        <span class="color-pwd padding" id="npa_int"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Interest Payble On FD</label>
                                    <div class="col-md-7">
                                         <input type="text" name="int_payble_fd"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->int_payble_fd); ?>">
                                        <span class="color-pwd padding" id="int_payble_fd"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Interest Payble On RD</label>
                                    <div class="col-md-7">
                                         <input type="text" name="int_payble_rd"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->int_payble_rd); ?>">
                                        <span class="color-pwd padding" id="int_payble_rd"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Interest Recoverable On Loan</label>
                                    <div class="col-md-7">
                                         <input type="text" name="int_recover_loan"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->int_recover_loan); ?>">
                                        <span class="color-pwd padding" id="int_recover_loan"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Interest Recoverable On Bank FD</label>
                                    <div class="col-md-7">
                                         <input type="text" name="int_recover_bank_fd"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->int_recover_bank_fd); ?>">
                                        <span class="color-pwd padding" id="int_recover_bank_fd"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">Interest Recoverable On Bank RD</label>
                                    <div class="col-md-7">
                                         <input type="text" name="int_recover_bank_rd"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->int_recover_bank_rd); ?>">
                                        <span class="color-pwd padding" id="int_recover_bank_rd"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">NET Profit</label>
                                    <div class="col-md-7">
                                         <input type="text" name="net_profit"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->net_profit); ?>">
                                        <span class="color-pwd padding" id="net_profit"></span>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="message">NET Loss</label>
                                    <div class="col-md-7">
                                         <input type="text" name="net_loss"  class="form-control col-md-7 col-xs-12"  onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->net_loss); ?>">
                                        <span class="color-pwd padding" id="net_loss"></span>
                                    </div>
                                </div>
                                                                
                                <!-- Form actions -->
                                <div class="form-group">
                                  <div class="col-md-9 col-md-offset-3">
                                    <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbara/resources/views/FinancialYear/YearEnd/edit.blade.php ENDPATH**/ ?>