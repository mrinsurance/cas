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
        <h1>Hello Admin</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Year End</li>
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
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Financial Year / Year End
                        </h3>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="<?php echo e(FINANCIAL_YEAR_END_URL); ?>/create"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="portlet-body">
                        <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"   style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Added Date</th>
                                        <th scope="col">Financial Year</th>
                                        <th scope="col">Opening Stock Depot 1</th>
                                        <th scope="col">Opening Stock Depot 2</th>
                                        <th scope="col">Opening Stock Depot 3</th>
                                        <th scope="col">Closing Stock Depot 1</th>
                                        <th scope="col">Closing Stock Depot 2</th>
                                        <th scope="col">Closing Stock Depot 3</th>
                                        <th scope="col">NPA Amount</th>
                                        <th scope="col">NPA Interest</th>
                                        <th scope="col">Interest Payble On FD</th>
                                        <th scope="col">Interest Payble On RD</th>
                                        <th scope="col">Interest Recoverable On Loan</th>
                                        <th scope="col">Interest Recoverable On Bank FD</th>
                                        <th scope="col">Interest Recoverable On Bank RD</th>
                                        <th scope="col">NET Profit</th>
                                        <th scope="col">NET Loss</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr id="product<?php echo e($item->id); ?>">

                                        <td><?php echo e($loop->index + 1); ?></td>
                                        <td>
                                            <a href="<?php echo e(FINANCIAL_YEAR_END_URL.'/'.$item->id.'/edit'); ?>" title="Edit">
                                                <i class="fa fa-pencil text-success"></i>
                                            </a>
                                            <button class="delete-product" value="<?php echo e(FINANCIAL_YEAR_END_URL.'/'.$item->id); ?>" title="Delete"><i class="fa fa-trash text-danger" style="cursor: pointer;"></i> </button>
                                        <input type="hidden" id="prd_id" value="<?php echo e($item->id); ?>">

                                        </td>
                                        <td><?php echo e(date('d-M-Y, h:i:s A',strtotime($item->created_at))); ?></td>
                                        <td><?php echo e(date('Y',strtotime(@$item->session_master_model->start_date))); ?> - <?php echo e(date('Y',strtotime(@$item->session_master_model->end_date))); ?></td>
                                        <td><?php echo e($item->opening_stock_depot1); ?></td>
                                        <td><?php echo e($item->opening_stock_depot2); ?></td>
                                        <td><?php echo e($item->opening_stock_depot3); ?></td>
                                        <td><?php echo e($item->closing_stock_depot1); ?></td>
                                        <td><?php echo e($item->closing_stock_depot2); ?></td>
                                        <td><?php echo e($item->closing_stock_depot3); ?></td>
                                        <td><?php echo e($item->npa_amount); ?></td>
                                        <td><?php echo e($item->npa_int); ?></td>
                                        <td><?php echo e($item->int_payble_fd); ?></td>
                                        <td><?php echo e($item->int_payble_rd); ?></td>
                                        <td><?php echo e($item->int_recover_loan); ?></td>
                                        <td><?php echo e($item->int_recover_bank_fd); ?></td>
                                        <td><?php echo e($item->int_recover_bank_rd); ?></td>
                                        <td><?php echo e($item->net_profit); ?></td>
                                        <td><?php echo e($item->net_loss); ?></td>
                                        
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/FinancialYear/YearEnd/list.blade.php ENDPATH**/ ?>