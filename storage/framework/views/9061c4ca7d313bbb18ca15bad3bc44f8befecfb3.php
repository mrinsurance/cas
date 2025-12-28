<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(ASSETS_VENDORS); ?>datatables/css/dataTables.bootstrap.css" />
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
  <script type="text/javascript" src="<?php echo e(ASSETS_VENDORS); ?>datatables/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_VENDORS); ?>datatables/js/dataTables.bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_SRC_JS); ?>pages/table-responsive.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>bootbox.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>deleteconfirm.js"></script>
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
            <li class="active">Voucher</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="panel-heading portlet-title">
                        <h3 class="panel-title pull-left add_remove_title">
                            <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Vouchers List
                        </h3>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="<?php echo e(TRANSACTION_URL_VOUCHER); ?>create"><i class="fa fa-plus-circle"></i> Create New</a>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="portlet-body">
                        <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Branch</th>
                                        <th scope="col">Voucher no</th>
                                        <th scope="col">Voucher date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Session</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr id="product<?php echo e($item->id); ?>">
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e(@$item->branch_model->name); ?></td>
                                    <td><?php echo e($item->voucher_no); ?></td>
                                    <td><?php echo e($item->voucher_date); ?></td>
                                    <td><?php echo e($item->amount); ?></td>
                                    <td><?php echo e(@$item->session_year); ?></td>
                                    <td>
                                        <?php if(!$CheckLock): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-edit')): ?>
                                      <a href="<?php echo e(TRANSACTION_URL_VOUCHER.''.$item->id); ?>/edit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    <?php endif; ?>  
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-delete')): ?>  
    <button type="button" class="btn btn-danger btn-sm delete-product" value="<?php echo e(TRANSACTION_URL_VOUCHER.''.$item->id); ?>"><i class="fa fa-trash"></i> Delete</button>
    <input type="hidden" value="<?php echo e($item->id); ?>" id="prd_id">
                                    <?php endif; ?>
                                      <a href="<?php echo e(TRANSACTION_URL_VOUCHER.''.$item->id); ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
                                        <?php endif; ?>
                                    </td>
                                  </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
    </section>
    <!-- content -->
</aside>
<!-- right-side -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Transaction/Voucher/list.blade.php ENDPATH**/ ?>