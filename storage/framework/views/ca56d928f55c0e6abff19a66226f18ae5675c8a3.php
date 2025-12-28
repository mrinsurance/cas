<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
    <link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>jquery-ui.css" />
    <style>
        #mytable_css >tbody>tr>td{
          height:20px;
          padding:1px 2px;
          border-top: 0px;
        }
        #mytable_css >thead>tr>th{
            border-bottom: 1px solid #ccc !important;
        }
        .align_right{
            text-align: right !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(ASSETS_VENDORS); ?>favicon/favicon.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>pages/form_examples.js"></script>
    <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>day_book.js"></script></script>
    <!-- end of page level js -->
    <script type="text/javascript">
    function printDiv(printRecord){
          var printContents = $('#record').html();
          var originalContents = document.body.innerHTML;      
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
    };
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Personal Ledger Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Personal Ledger Report</li>
        </ol>
    </section>
    <!--section ends-->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet box primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Personal Ledger Report
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="<?php echo e(route('ledger.print-personal-ledger')); ?>" method="get">
                    <div class="row">
                    <div class="col-md-12">
                    
                        <?php echo e(csrf_field()); ?>

                        <div class="col-md-3">
                            <label class="col-md-3 control-label" for="email">From</label>
                            <div class="col-md-9">
                                <!-- <input class="form-control" value="<?php echo e(old(date('Y-m-d'),request()->get('from_date'))); ?>" name="from_date" id="from_date" placeholder="Check-In Date" readonly> -->
                                 <input type="date" name="from_date" class="form-control" value="<?php echo e(old(date('Y-m-d'),request()->get('from_date'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-3 control-label" for="email">To</label>
                            <div class="col-md-9">
                                <!-- <input class="form-control" value="<?php echo e(old(date('Y-m-d'),request()->get('to_date'))); ?>" name="to_date" id="to_date" placeholder="Check-In Date" readonly> -->
                                 <input type="date" name="to_date" class="form-control" value="<?php echo e(old(date('Y-m-d'),request()->get('to_date'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-5 control-label" for="email">Member Type</label>
                            <div class="col-md-7">
                                <select name="member_type" class="form-control">
                                    <?php $__currentLoopData = $_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(request()->get('member_type') == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    
                    </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </div>
                </form>
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        <div class="prnt" id="record">
                            <?php $__currentLoopData = $shareData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $share): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php

                                    $function_data = printPersonalLedger($share->account_no,request()->get('member_type'),request()->get('from_date'),request()->get('to_date'));
                                    $_saving = $function_data['_saving'];
                                    $b_share = $function_data['_opening_share_bal'] ?? 0;
                                    $b_loan = $function_data['_opening_loan_bal'] ?? 0;
                                    $b_saving = $function_data['_opening_saving_bal'] ?? 0;
                                ?>
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="11">
                                        <div class="row">
                                             <div class="col-md-12 text-center">
                                            <h3>
                                                <?php echo e($company_address->name); ?>

                                            </h3>
                                                <?php echo e($company_address->address); ?>

                                               <br>
                                                Personal Ledger Report
                                            
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 text-left">
                                            <strong>Member A/C no.: </strong> <em><?php echo e($share->account_no ?? ''); ?></em>
                                            <br>
                                            <strong>Name: </strong> <em><?php echo e($share->open_new_ac_model->full_name ?? ''); ?></em>
                                            <br>
                                            <strong>Father Name: </strong> <em><?php echo e($share->open_new_ac_model->father_name ?? ''); ?></em>
                                            <br>
                                            <strong>From: </strong> <em>(<?php echo e(date('d-M-Y',strtotime(request()->get('from_date')))); ?>)</em> <strong>To: </strong> <em>(<?php echo e(date('d-M-Y',strtotime(request()->get('to_date')))); ?>)</em>
                                            
                                            </div>
                                            <div class="col-md-6 text-center">
                                              
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <th colspan="3">Share</th>
                                    <th colspan="4">Loan</th>
                                    <th colspan="3">Saving</th>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Deposit</th>
                                    <th>Withdraw</th>
                                    <th>Balance</th>
                                    <th>Loan Advance</th>
                                    <th>Loan Return</th>
                                    <th>Interest</th>
                                    <th>Balance</th>
                                    <th>Deposit</th>
                                    <th>Withdraw</th>
                                    <th>Balance</th>
                                </tr>
                                <tr>
                                    <th>
                                        <strong>Opening Balance:</strong>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($b_share)); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($b_loan)); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($b_saving)); ?></th>
                                </tr>
                                
                            </thead>
                            <tbody>


                                    <?php $__currentLoopData = $_saving; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                           <?php echo e($list->dt); ?>

                                        </td>
                                         <td class="align_right">
                                            <?php if($list->share_mode == 'Deposit'): ?>
                                            <i class="fa fa-inr"></i> <?php echo e(number_format($list->share_amt)); ?>

                                            <?php $b_share = $b_share + $list->share_amt; ?>
                                            <?php else: ?>
                                            <i class="fa fa-inr"></i> 0
                                            <?php endif; ?>
                                        </td>
                                        <td class="align_right">
                                            <?php if($list->share_mode == 'Withdrawal'): ?>
                                            <i class="fa fa-inr"></i> <?php echo e(number_format($list->share_amt)); ?>

                                           <?php $b_share = $b_share - $list->share_amt; ?>
                                            <?php else: ?>
                                            <i class="fa fa-inr"></i> 0
                                            <?php endif; ?>
                                        </td>
                                        <td class="align_right">
                                            <i class="fa fa-inr"></i> <?php echo e($b_share); ?>

                                        </td>
                                        <td class="align_right">
                                            <?php if($list->loan < 0 || $list->loan > 0): ?>
                                            <i class="fa fa-inr"></i> <?php echo e($list->loan); ?>

                                            <?php $b_loan = $b_loan + $list->loan; ?>
                                            <?php else: ?>
                                            <i class="fa fa-inr"></i> 0
                                            <?php endif; ?>
                                        </td>
                                        <td class="align_right">
                                            <?php if($list->loan_r < 0 || $list->loan_r > 0): ?>
                                            <i class="fa fa-inr"></i> <?php echo e($list->loan_r); ?>

                                            <?php $b_loan = $b_loan - $list->loan_r; ?>
                                            <?php else: ?>
                                            <i class="fa fa-inr"></i> 0
                                            <?php endif; ?>
                                        </td>
                                        <td class="align_right">
                                            <?php if($list->intr < 0 || $list->intr > 0): ?>
                                            <i class="fa fa-inr"></i> <?php echo e($list->intr); ?>

                                            <?php else: ?>
                                            <i class="fa fa-inr"></i> 0
                                            <?php endif; ?>
                                        </td>
                                         <td class="align_right">
                                            <i class="fa fa-inr"></i> <?php echo e($b_loan); ?>

                                        </td>
                                        <td class="align_right">
                                            <?php if($list->saving_mode == 'Deposit'): ?>
                                            <i class="fa fa-inr"></i> <?php echo e(number_format($list->saving_amt)); ?>

                                            <?php $b_saving = $b_saving + $list->saving_amt; ?>
                                            <?php else: ?>
                                            <i class="fa fa-inr"></i> 0
                                            <?php endif; ?>
                                        </td>
                                        <td class="align_right">
                                            <?php if($list->saving_mode == 'Withdrawal'): ?>
                                            <i class="fa fa-inr"></i> <?php echo e(number_format($list->saving_amt)); ?>

                                           <?php $b_saving = $b_saving - $list->saving_amt; ?>
                                            <?php else: ?>
                                            <i class="fa fa-inr"></i> 0
                                            <?php endif; ?>
                                        </td>
                                        <td class="align_right">
                                            <i class="fa fa-inr"></i> <?php echo e($b_saving); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php if($shareData): ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php echo e($shareData->appends(request()->except('page'))->links()); ?>

                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>
</section>
    <!-- content -->
</aside>
<!-- right-side -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbatran/resources/views/Ledger//print-personal_ledger.blade.php ENDPATH**/ ?>