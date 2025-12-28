<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(ASSETS_VENDORS); ?>datatables/css/dataTables.bootstrap.css" />
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
        <style>

        .align_right{
            text-align: right !important;
        }
    </style>
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
            <li class="active">Purchase</li>
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
                            <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Purchase List
                        </h3>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="<?php echo e(TRADING_URL_PURCHASE); ?>/create"><i class="fa fa-plus-circle"></i> Create New</a>
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
                                        <th scope="col">Action</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Invoice No</th>
                                        <th scope="col">Bill No</th>
                                        <th scope="col">Bill Date</th>
                                        <th scope="col">Purchase Date</th>
                                        <th scope="col">Bill Amount (<i class="fa fa-inr"></i>)</th>
                                        <th scope="col">Purchase Party</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php
                                            $amount = App\purchase_detail_tbl::where('purchase_tbl_id',$item->id)->sum('amount');
                                       ?>
                                  <tr id="product<?php echo e($item->id); ?>">
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td>
                                      <a href="<?php echo e(TRADING_URL_PURCHASE.'/'.$item->id); ?>/edit" title="Edit"><i class="fa fa-edit text-danger"></i></a>
                                      <a href="<?php echo e(TRADING_URL_PURCHASE.'/'.$item->id); ?>" title="View"><i class="fa fa-eye text-success"></i></a>
                                    </td>
                                    <td>
                                        <?php if($item->apr_status == TRUE): ?>
                                            <span class="text-success">Approved</span>
                                        <?php else: ?>
                                            <span class="text-danger">UnApproved</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($item->invoice_no); ?></td>
                                    <td><?php echo e($item->bill_no); ?></td>
                                    <td><?php echo e($item->billing_date); ?></td>
                                    <td><?php echo e($item->date_of_transaction); ?></td>
                                    <td class="text-right"><?php echo e(number_format($amount,2)); ?></td>
                                    <td><?php echo e(@$item->purchase_party_tbl->name); ?></td>

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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/Trading/Purchase/list.blade.php ENDPATH**/ ?>