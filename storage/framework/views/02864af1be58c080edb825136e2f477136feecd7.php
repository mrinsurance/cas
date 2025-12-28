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
            <li class="active">Bank FD A/C List</li>
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
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Bank FD A/C List
                        </h3>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="<?php echo e(TRANSACTION_URL_BANK_FD_AC); ?>create"><i class="fa fa-plus-circle"></i> Create New FD</a>
                        </div>
                    </div>
                    
                    <div class="portlet-body">
                        <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Bank</th>
                                        <th scope="col">FD no</th>
                                        <th scope="col">A/C</th>
                                        <th scope="col">FD Amount <small>(Rs.)</small></th>
                                        <th scope="col">FD Dated</th>
                                        <th scope="col">Matuarity Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr id="product<?php echo e($item->id); ?>">
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($item->bank_model->name); ?></td>
                                    <td><?php echo e($item->fd_no); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td><i class="fa fa-inr"></i> <?php echo e(number_format($item->amount,2)); ?></td>
                                    <td><?php echo e(@$item->int_run_from); ?></td>
                                    <td><?php echo e(@$item->maturity_date); ?></td>
                                    <td>
                                      <?php if($item->status == 1): ?>
                                      <span class="text text-success">Active</span>
                                      <?php else: ?>
                                      <span class="text text-danger">Matured</span>
                                      <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(!$CheckLock): ?>
                                            <?php if($item->status == 1): ?>
                                            <a href="<?php echo e(TRANSACTION_URL_BANK_FD_AC.''.$item->id); ?>/edit" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="<?php echo e(TRANSACTION_URL_BANK_FD_AC.''.$item->id); ?>/matured" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Mature">
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                            <?php else: ?>
                                            <a href="<?php echo e(TRANSACTION_URL_BANK_FD_AC.''.$item->id); ?>/matured" class="btn btn-success btn-sm" data-toggle="tooltip" title="UnMature">
                                                <i class="fa fa-undo"></i>
                                            </a>
                                            <?php endif; ?>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Transaction/Bank_FD_Ac/list.blade.php ENDPATH**/ ?>