<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link href="<?php echo e(ASSETS_CSS); ?>pages/invoice.css" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
 <script src="<?php echo e(ASSETS_JS); ?>pages/invoice.js" type="text/javascript"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
<aside class="right-side strech">

            <!-- Main content -->
            <section class="content paddingleft_right15">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-success">
                            <div class="panel-body" style="border:1px solid #ccc;padding:0;margin:0;">
                                <div class="row" style="padding: 15px;margin-top:5px;">
                                    
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <h3><?php echo e($company_profile->name); ?></h3>
                                            <?php echo e($company_profile->address); ?>

                                            <br><strong>Share
                                            <?php echo e($item->type_of_transaction); ?>


                                             Receipt</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 15px;">
                                    <div class="col-md-9 col-xs-6" style="margin-top:5px;">
                                        <strong><?php if($item->type_of_transaction == 'Deposit'): ?>Received From: <?php else: ?> Paid To: <?php endif; ?></strong>
                                        <br> <?php echo e($item->open_new_ac_model->full_name); ?>

                                        <br> <?php echo e($item->open_new_ac_model->current_address_first); ?>

                                        <br>
                                        <button class="btn btn-default"><h4><i class="fa fa-inr"></i> <?php echo e(@$item->amount); ?>/-</h4></button>
                                        <br>
                                        (<?php echo e(\App\Http\Controllers\Transaction\fdController::convert_number_to_words(@$item->amount)); ?> only)
                                        <br>
                                        <h5>Print Date - <?php echo e(date('d-M-Y')); ?></h5>
                                    </div>
                                    <div class="col-md-3 col-xs-6" style="padding-right:0">
                                        <div id="invoice" style="background-color: #eee;text-align:right;padding: 15px;padding-bottom:23px;border-bottom-left-radius: 6px;border-top-left-radius: 6px;">
                                            <h4><strong>Receipt No. - <?php echo e(@$voucher->voucher_no); ?></strong></h4>
                                            <h4><?php echo e(date('d M Y',strtotime($item->date_of_transaction))); ?></h4>
                                            <?php echo e($item->member_type_model->name); ?> A/C - (<?php echo e($item->account_no); ?>)
                                            <br>          
                                        </div>
                                        <div id="invoice" style="text-align:right;padding: 15px;padding-bottom:23px;border-bottom-left-radius: 6px;border-top-left-radius: 6px;">
                                            <br><br>
                                            Authorized Signatory
                                            <br>
                                        </div>
                                    </div>
                                </div>
                               
                                <div style="background-color: #eee;padding:15px;" id="footer-bg">
                                    
                                    <div style="margin:10px 20px;text-align:center;" class="btn-section">
                                        <button type="button" class="btn btn-responsive button-alignment btn-info" data-toggle="button">
                                            <span style="color:#fff;" onclick="javascript:window.print();">
                                            <i class="livicon" data-name="printer" data-size="16" data-loop="true"
                                               data-c="#fff" data-hc="white" style="position:relative;top:3px;"></i>
                                            Print
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- content -->
        </aside>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Transaction/Share_Ac/share-transaction-print.blade.php ENDPATH**/ ?>