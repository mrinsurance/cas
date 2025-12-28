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
                <a href="<?php echo e(MASTER_URL_AC_TYPE); ?>">
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
            <div class="col-md-12">
                <!--lg-6 starts-->
                <!--basic form starts-->
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Master / Account Types / Edit
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?php echo e(MASTER_URL_AC_TYPE.''.$item->id); ?>" id="edit_frm" class="form-horizontal form-label-left">
                          <?php echo e(csrf_field()); ?>

                          <?php echo e(method_field('PUT')); ?>

                            <fieldset>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="message">Account Type</label>
                                    <div class="col-md-9">
                                        <input type="text" name="account_type" required="required" class="form-control" value="<?php echo e($item->name); ?>">
                                          <span class="color-pwd padding" id="account_type"></span>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Master/Account_Type/edit.blade.php ENDPATH**/ ?>