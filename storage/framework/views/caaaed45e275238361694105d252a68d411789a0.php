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
        <h1>Detailed Balance Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Share Detailed Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Detailed Balance Report of Share A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="<?php echo e(D_BALANCE_REPORT_URL_SHARE); ?>" method="get">
                    <div class="row">
                    <div class="col-md-12">
                        <?php echo e(csrf_field()); ?>

                        <div class="col-md-6">
                            <label class="col-md-2 control-label" for="email">From</label>
                            <div class="col-md-4">
                                <input class="form-control" value="<?php echo e($from_date); ?>" name="from_date" id="from_date" placeholder="From" readonly>
                            </div>
                            <label class="col-md-2 control-label" for="email">To</label>
                            <div class="col-md-4">
                                <input class="form-control" value="<?php echo e($to_date); ?>" name="to_date" id="to_date" placeholder="To" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-3 control-label" for="email">Branch</label>
                            <div class="col-md-3">
                                <select name="branch" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$branch == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <label class="col-md-3 control-label" for="email">Member Type</label>
                            <div class="col-md-3">
                                <select name="member_type" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$member_type == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </div>
                    </form>    
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        <div class="prnt" id="record">
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="8">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                <?php echo e($company_address->name); ?>

                                            </h3>
                                                <?php echo e($company_address->address); ?>

                                            <h4>
                                                Member Share Balance Report from <strong><?php echo e(date('d-M-Y',strtotime($from_date))); ?></strong> to <strong> <?php echo e(date('d-M-Y',strtotime($to_date))); ?></strong>
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>Opening</th>
                                    <th>Deposit</th>
                                    <th>Withdrawal</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sr = 0; 
                                $t1 = 0;    
                                $t2 = 0;    
                                $t3 = 0;    
                                $t4 = 0;    
                                ?>
                                <?php $__currentLoopData = $ac_holders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php

                               $deposit = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<',$from_date)->sum('amount');

                               $withdraw = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<',$from_date)->sum('amount');

                               $deposit_trans = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','>=',$from_date)->where('date_of_transaction','<=',$to_date)->sum('amount');

                               $withdraw_trans = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','>=',$from_date)->where('date_of_transaction','<=',$to_date)->sum('amount');

                               $opening_balance = ($deposit - $withdraw);
                                 $balance = ($opening_balance + ($deposit_trans - $withdraw_trans));
                                ?>
                               <?php if($opening_balance <> 0 || $deposit_trans <> 0 || $withdraw_trans <> 0): ?>
                                <?php 
                                    $sr++; 
                                    $t1 += $opening_balance;
                                    $t2 += $deposit_trans;
                                    $t3 += $withdraw_trans;
                                    $t4 += $balance;
                                ?>
                                <tr>
                                    <td><?php echo e($sr); ?></td>
                                    <td><?php echo e($val->full_name); ?></td>
                                    <td><?php echo e($val->account_no); ?></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i> <?php echo e(number_format($opening_balance,2)); ?>

                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i> 
                                        <?php echo e(number_format($deposit_trans,2)); ?>

                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i> 
                                        <?php echo e(number_format($withdraw_trans,2)); ?>

                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   <?php echo e(number_format($balance,2)); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t1,2)); ?></strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t2,2)); ?></strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t3,2)); ?></strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t4,2)); ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Balance/share_detailed_balance.blade.php ENDPATH**/ ?>