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
    <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>pages/buttons.css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
  <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>pages/form_layouts.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>edit-record.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>open_new_ac.js"></script></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
 <!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Dividend Calculation</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(DIVIDEND_LIST_URL); ?>">
                    Dividend List
                </a>
            </li>
            <li class="active">Dividend Calculation</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Edit Record
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?php echo e(DIVIDEND_LIST_URL.'/'.$item->id); ?>" id="edit_frm" class="form-horizontal form-label-left">
                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('PUT')); ?>

                            <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        A/C No.
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="<?php echo e($item->account_no); ?>" disabled>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        A/C Holder Name
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="<?php echo e($item->holder_name); ?>" disabled>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Dividend Amount <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="dividend_amount" class="form-control" value="<?php echo e($item->dividend_amt); ?>" onkeypress="return isNumAndDecimalKey(event)" required>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                
                            </div>
                            <div class="form-actions">
                                <div class="col-md-offset-3 col-md-6 text-center btn-group-md">
                                    <button type="submit" class="btn btn-success btn_sizes">Update</button>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Calculation/edit-dividend.blade.php ENDPATH**/ ?>