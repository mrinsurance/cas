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
        <h1>Share A/c List - <?php echo e($profile->member_type_model->name); ?> A/C No. -  <?php echo e($profile->account_no); ?> (<?php echo e($profile->full_name); ?>)</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(TRANSACTION_URL_SHARE_AC); ?>">
                     Share A/C
                </a>
            </li>
            <li class="active">A/c Transaction Detail</li>
        </ol>
    </section>
    <!--section ends-->
        <section class="content">
        <div class="row">
            <div class="col-md-12">

                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box danger">
                    <div class="panel-heading portlet-title">
                        <h3 class="panel-title pull-left add_remove_title">
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> A/c Transaction Detail
                        </h3>
                    </div>
                    
                    <div class="portlet-body">
                        <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Transaction Date</th>
                                        <th>Deposit Amount (<i class="fa fa-inr"></i>)</th>
                                        <th>Withdrawal Amount (<i class="fa fa-inr"></i>)</th>
                                        <th>Balance (<i class="fa fa-inr"></i>)</th>
                                        <th>Transaction Particular</th>
                                        <th>Action</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $val = 0;
                                    ?>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr id="product<?php echo e($item->id); ?>">
                                        <td><?php echo e($loop->index + 1); ?></td>
                                        <td><?php echo e(date('d-M-Y',strtotime($item->date_of_transaction))); ?></td>
                                        <td class="text-right">
                                          <?php if($item->type_of_transaction == 'Deposit'): ?>
                                            <?php echo e(number_format($item->amount,2)); ?>

                                          <?php endif; ?>  
                                        </td>
                                        <td class="text-right">
                                           <?php if($item->type_of_transaction == 'Withdrawal'): ?>
                                            <?php echo e(number_format($item->amount,2)); ?>

                                          <?php endif; ?>  
                                        </td>
                                        <td class="text-right">
                                          <?php
                                            
                                            if($item->type_of_transaction == 'Deposit')
                                            {
                                              $val = $val + $item->amount;
                                            }
                                            else{
                                            $val = $val - $item->amount;
                                          }
                                          ?>
                                          <?php echo e(number_format($val,2)); ?>

                                          </td>
                                        <td>
                                          <?php echo e($item->particular); ?>

                                        </td>
                                        <td>
                                            <?php if(!$CheckLock): ?>
                                          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-edit')): ?>
                                          <a href="<?php echo e(TRANSACTION_URL_SHARE_AC.''.$item->id); ?>/edit" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-danger"></i></a>
                                          <?php endif; ?>
                                          <a href="<?php echo e(TRANSACTION_URL_SHARE_AC.''.$item->id); ?>/print" target="_blank" data-toggle="tooltip" title="Print"><i class="fa fa-fw fa-print text-success"></i></a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                          <?php echo e($item->remarks); ?>

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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbara/resources/views/Transaction/Share_Ac/transaction-list.blade.php ENDPATH**/ ?>