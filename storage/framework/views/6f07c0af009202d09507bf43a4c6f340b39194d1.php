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
            <h1>Ledger Account Report</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(HOME_LINK); ?>">
                        <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                    </a>
                </li>
                <li class="active">RD</li>
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
                                <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Ledger Account Report
                            </div>
                        </div>
                        <div class="portlet-body">

                            <form class="form-horizontal" action="<?php echo e(LEDGER_REPORT_URL_GENERAL_LEDGER); ?>" method="get">
                                <?php echo e(csrf_field()); ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <label class="col-md-4 control-label" for="email">From</label>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" id="from_date" placeholder="Check-In Date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-md-4 control-label" for="email">To</label>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$to_date)); ?>" name="to_date" id="to_date" placeholder="Check-In Date">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-md-4 control-label" for="email">Sub Group</label>
                                            <div class="col-md-8">
                                                <select name="subgroup" class="form-control">
                                                    <?php $__currentLoopData = $subgroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val->id); ?>" <?php echo e(@$subgroup == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                        <div class="col-md-12 col-md-offset-5">
                                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-scrollable">
                                <!-- Print view                         -->
                                <div class="prnt" id="record">

                                    <table class="table table-bordered table-hover" id="mytable_css">
                                        <thead>
                                        <tr>
                                            <td colspan="5">
                                                <div class="col-md-12 col-sm-12 col-lg-12 text-center">
                                                    <h3>
                                                        <?php echo e($company_address->name); ?>

                                                    </h3>
                                                    <?php echo e($company_address->address); ?>

                                                    <h5>
                                                        GENERAL LEDGER REPORT OF <?php echo e($subname->name); ?>

                                                        <br>
                                                        FROM <?php echo e(date('d-M-Y',strtotime($from_date))); ?> To  <?php echo e(date('d-M-Y',strtotime($to_date))); ?>

                                                    </h5>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Credit</th>
                                            <th>Debit</th>
                                            <th>Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i = 1;
                                            $opnbalcr = 0;
                                            $opnbaldr = 0;
                                            $totalDr = 0;
                                            $totalCr = 0;
                                            $totalbal = 0;
                                            $totalbal = $opening;

                                        ?>
                                        <td><?php echo e($i++); ?></td>
                                        <td><?php echo e(date('d-m-Y',strtotime($from_date))); ?> <?php echo e(' OPENING'); ?></td>
                                        <?php if($opening >= 0): ?>
                                            <?php
                                                $opnbalcr=$opening;
                                            ?>
                                            <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($opening,2)); ?></strong></td>
                                            <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format(0,2)); ?></td>
                                            <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($opening,2)); ?><?php echo e('Cr'); ?></strong></td>
                                        <?php endif; ?>
                                        <?php if($opening < 0): ?>
                                            <?php
                                                $opnbaldr=$opening*-1;
                                            ?>
                                            <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format(0,2)); ?></td>
                                            <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($opnbaldr,2)); ?></strong></td>
                                            <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($opening*-1,2)); ?><?php echo e('Dr'); ?></strong></td>
                                        <?php endif; ?>
                                        <!-- $totalbal -->

                                        <?php $__currentLoopData = $tblLedgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainHead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $crSum = \App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                                               ->where('main_head',$mainHead->main_head)
                                               ->where('type_of_transaction','Cr')
                                               ->where('date_of_transaction',$mainHead->date_of_transaction)
                                               ->sum('amount');

                                                $drSum = \App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                                               ->where('main_head',$mainHead->main_head)
                                               ->where('type_of_transaction','Dr')
                                               ->where('date_of_transaction',$mainHead->date_of_transaction)
                                               ->sum('amount');

                                            ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e(date('d-m-Y',strtotime($mainHead->date_of_transaction))); ?></td>
                                                <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($crSum ,2)); ?></td>
                                                <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($drSum,2)); ?></td>
                                                <?php
                                                    $totalbal=$totalbal+$crSum -$drSum;
                                                    $totalCr=$totalCr+$crSum;
                                                    ;$totalDr=$totalDr+$drSum;
                                                ?>


                                                <?php if($totalbal>0): ?>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($totalbal,2)); ?><?php echo e('Cr'); ?></td>
                                                <?php endif; ?>
                                                <?php if($totalbal<0): ?>
                                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($totalbal*-1,2)); ?><?php echo e('Dr'); ?></td>
                                                <?php endif; ?>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- total without opening --><tr>
                                            <td></td>
                                            <td><?php echo e('TOTAL WITHOUT OPENING'); ?></td>
                                            <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($totalCr,2)); ?></strong></td>
                                            <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($totalDr,2)); ?></strong></td>
                                            <td></td>
                                        </tr>
                                        <!-- total with opening -->
                                        <td></td>
                                        <td><?php echo e('TOTAL WITH OPENING'); ?></td>
                                        <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($totalCr+$opnbalcr,2)); ?></strong></td>
                                        <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($totalDr+$opnbaldr,2)); ?></strong></td>
                                        <?php if(($totalCr+$opnbalcr)-($totalDr+$opnbaldr)>0): ?>
                                            <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format(($totalCr+$opnbalcr)-($totalDr+$opnbaldr),2)); ?><?php echo e('Cr'); ?></strong></td>
                                        <?php endif; ?> <?php if(($totalCr+$opnbalcr)-($totalDr+$opnbaldr)<0): ?>
                                            <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format((($totalCr+$opnbalcr)-($totalDr+$opnbaldr))*-1,2)); ?><?php echo e('Dr'); ?></strong></td>
                                        <?php endif; ?>



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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Ledger//general_ledger.blade.php ENDPATH**/ ?>