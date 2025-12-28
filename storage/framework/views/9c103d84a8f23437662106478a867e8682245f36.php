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
        @media  print {
            .record {
                page-break-after: always;
            }
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(ASSETS_VENDORS); ?>favicon/favicon.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>pages/form_examples.js"></script>
    <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>day_book.js"></script>
    <!-- end of page level js -->
    <script type="text/javascript">
        function printDiv(printRecord){
            var printContents = '';
            $('.record').each(function () {
                printContents += $(this).prop('outerHTML') + '<hr>';
            });

            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>FD Ledger Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">FD Ledger Report</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> FD Ledger Report
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="<?php echo e(route('ledger.print-fd-ledger')); ?>" method="get">
                    <div class="row">
                    <div class="col-md-12">
                    
                        <?php echo e(csrf_field()); ?>


                        <div class="col-md-3">
                            <label class="col-md-3 control-label" for="asOn">As On</label>
                            <div class="col-md-9">
                                <!-- <input class="form-control" value="<?php echo e(old(date('Y-m-d'),@$to_date)); ?>" name="to_date" id="to_date" placeholder="Check-In Date" readonly> -->
                                 <input type="date" name="to_date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$to_date)); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-5 control-label" for="email">Member Type</label>
                            <div class="col-md-7">
                                <select name="member_type" class="form-control">
                                    <?php $__currentLoopData = $_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$member_type == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-5 control-label" for="email">A/C no.</label>
                            <div class="col-md-7">
                                <input type="text" name="account" value="<?php echo e(@$_holder->account_no); ?>" class="form-control">
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
                    <?php $__currentLoopData = $allLedgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $running_balance = 0;
                            $_holder = $group['holder'];
                        ?>

                        <div class="table-scrollable page-break">
                            <div class="prnt record">
                            <table class="table table-bordered table-hover" id="mytable_css">
                                <thead>
                                <tr>
                                    <th colspan="14" class="text-center">
                                        <div class="row">
                                            <div class="col-md-14 text-center">
                                                <h3>
                                                    <?php echo e($company_address->name); ?>

                                                </h3>
                                                <?php echo e($company_address->address); ?>

                                                <br>
                                                FD Ledger Report
                                            </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="14">
                                        <strong>Member A/C no.:</strong> <em><?php echo e($_holder->account_no); ?></em><br>
                                        <strong>Name:</strong> <em><?php echo e($_holder->full_name); ?></em><br>
                                        <strong>Father Name:</strong> <em><?php echo e($_holder->father_name); ?></em><br>
                                        <strong>As On:</strong> <em><?php echo e(date('d-M-Y', strtotime($to_date))); ?></em>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date of Transaction</th>
                                    <th>FD No.</th>
                                    <th>Deposit Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Paid Interest</th>
                                    <th>Balance</th>
                                    <th>Interest Rate (%)</th>
                                    <th>Interest Run From</th>
                                    <th>Period of FD (Month)</th>
                                    <th>Maturity Date</th>
                                    <th>Matured on Date</th>
                                    <th>Type of Interest</th>
                                    <th>Maturity Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $group['ledgers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $deposit_amount = (float) $ledger->amount;
                                        $maturity_amount = (float) $ledger->maturity_amount;
                                        $paid_amount = 0;
                                        $paid_interest = 0;
                                        $running_balance += $deposit_amount;
                                    ?>

                                    <tr>
                                        <td><?php echo e(\Carbon\Carbon::parse($ledger->transaction_date)->format('d-m-Y')); ?></td>
                                        <td><?php echo e($ledger->fd_no); ?></td>
                                        <td class="align_right"><?php echo e(number_format($deposit_amount, 2)); ?></td>
                                        <td class="align_right"></td>
                                        <td class="align_right"></td>
                                        <td class="align_right"><?php echo e(number_format($running_balance, 2)); ?></td>
                                        <td class="align_right"><?php echo e($ledger->int_rate); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($ledger->int_run_from)->format('d-m-Y')); ?></td>
                                        <td><?php echo e($ledger->period_fd); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($ledger->maturity_date)->format('d-m-Y')); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($ledger->matured_on_date)->format('d-m-Y')); ?></td>
                                        <td><?php echo e($ledger->interest_type); ?></td>
                                        <td class="align_right"><?php echo e(number_format($maturity_amount, 2)); ?></td>
                                        <td><?php echo e($ledger->status == 1 ? 'Active' : 'Closed'); ?></td>
                                    </tr>

                                    <?php if($ledger->status == 0 && \Carbon\Carbon::parse($ledger->matured_on_date)->lte($to_date)): ?>
                                        <?php
                                            $paid_amount = $deposit_amount;
                                            $paid_interest = $maturity_amount - $deposit_amount;
                                            $running_balance -= $paid_amount;
                                        ?>
                                        <tr>
                                            <td><?php echo e(\Carbon\Carbon::parse($ledger->matured_on_date)->format('d-m-Y')); ?></td>
                                            <td><?php echo e($ledger->fd_no); ?></td>
                                            <td class="align_right"></td>
                                            <td class="align_right"><?php echo e(number_format($paid_amount, 2)); ?></td>
                                            <td class="align_right"><?php echo e(number_format($paid_interest, 2)); ?></td>
                                            <td class="align_right"></td>
                                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Ledger/print-fd-ledger.blade.php ENDPATH**/ ?>