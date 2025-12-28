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
         table.report-container
        {
            page-break-after: always;
        }
        thead.report-header{
            display: table-header-group;
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
    <script>
        function printData()
        {
            var divToPrint=document.getElementById("printTable");
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
        $('button[name="print"]').on('click',function(){
            printData();
        })
    </script>
    <!-- end of page level js -->
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Day Book</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Day Book</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <form class="form-horizontal" action="<?php echo e(route('daily.report.cash.book.combine')); ?>" method="get">
                        <?php echo e(csrf_field()); ?>

                        <fieldset>
                            <!-- Name input-->
                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="email">From</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i>
                                                </div>
                                                <input type="date" name="from_date" class="form-control"  value="<?php echo e(request()->get('from_date') ? request()->get('from_date') : \Carbon\Carbon::now()->format('Y-m-d')); ?>">

                                                <!-- <input class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" id="from_date" placeholder="Check-In Date" readonly> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-md-offset-1">
                                    <div class="form-group">
                                       <button class="btn btn-danger" name="pre" value="next"> < Previous</button>
                                       <button class="btn btn-success" name="next" value="next">Next ></button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="email">To</label>
                                        <div class="col-md-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i>
                                            </div>
                                            <input type="date" name="to_date" class="form-control" value="<?php echo e(request()->get('from_date') ? request()->get('to_date') : \Carbon\Carbon::now()->format('Y-m-d')); ?>">

                                            <!-- <input class="form-control" value="<?php echo e(old(date('Y-m-d'),@$to_date)); ?>" name="to_date" id="to_date" placeholder="Check Out Date" readonly> -->
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12 text-left">

                                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                                            <a href="<?php echo e(route('daily.report.day.book.print',['from_date'=>request()->get('from_date'), 'to_date'=>request()->get('to_date')])); ?>" target="_blank" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="portlet-body">
                        <div id="printTable" class="table-responsive text-nowrap">
                            <?php
                                $start_date = \Carbon\Carbon::parse(request()->get('from_date'));
                                $end_date = \Carbon\Carbon::parse(request()->get('to_date'));
                                $diff = $start_date->diffInDays($end_date);

                            ?>
                            <?php for($ii = 0; $ii <= $diff; $ii++): ?>
                                <?php
                                        $loop_from_date = \Carbon\Carbon::parse(request()->get('from_date'))->addDay($ii)->format('Y-m-d');
                                        $loop_to_date = \Carbon\Carbon::parse(request()->get('from_date'))->addDay($ii)->format('Y-m-d');
                                        $gtype_groups =  DaybookBetweenDates($loop_from_date, $loop_to_date,'Cr');
                                        $payment_gtype_groups =  DaybookBetweenDates($loop_from_date, $loop_to_date, 'Dr');

                                        $dr_amount = CashInHand($loop_from_date, 'Dr');
                                        $cr_amount = CashInHand($loop_from_date, 'Cr');
                                        $opening_cash_in_hand = $dr_amount - $cr_amount;

                                ?>
                            <table class="table table-bordered report-container">
                                <thead>
                                    <tr class="bg-grey">
                                        <th>
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Receipt
                                                </div>
                                            </div>
                                        </th>
                                        <!-- <th>Type</th> -->
                                        <th>
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Payment
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="table table-bordered report-container">
                                <thead>
                                    <tr class="bg-grey">
                                        <th>Date</th>
                                        <!-- <th>Type</th> -->
                                        <th>A/C No</th>
                                        <th>Particular</th>
                                        <th>Amount</th>
                                        <th>Total </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo e(\Carbon\Carbon::parse($loop_from_date)->format('d-m')); ?></td>
                                        <td colspan="3">Opening Cash In Hand</td>
                                        <td class="text-danger must-right"><i class="fa fa-inr"></i> <?php echo e(number_format($opening_cash_in_hand,2)); ?></td>
                                    </tr>
                                    <?php
                                        $bal = 0;
                                        $receipt_total = 0;
                                        $payment_total = 0;
                                    ?>

                                    <?php $__currentLoopData = $gtype_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td colspan="6"><strong><?php echo e($group->gtype); ?></strong></td>
                                    </tr>
                                    <?php
                                        $total = 0;
                                        $i = 0;
                                    ?>

                                    <?php $__currentLoopData = stypeOfDaybookBetweenDates($loop_from_date, $loop_to_date, $group->gtype, 'Cr'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $i++;
                                        $total += $stype->amount;
                                        $x = count(stypeOfDaybookBetweenDates($loop_from_date, $loop_to_date, $group->gtype,'Cr'));
                                        $bal += $stype->amount;
                                    ?>
                                    <tr>
                                        <td><?php echo e(\Carbon\Carbon::parse($stype->date_of_transaction)->format('d-m')); ?></td>
                                        <td><?php echo e($stype->account_no); ?></td>
                                        <td><?php echo e(str_limit($stype->particular,$limit=100,$end = '...')); ?></td>
                                        <td class=" must-right"><i class="fa fa-inr"></i> <?php echo e(number_format($stype->amount,2)); ?></td>
                                        <td class="<?php if($i == $x): ?> text-danger must-right <?php endif; ?>"> <?php if($i == $x): ?> <i class="fa fa-inr"></i> <?php echo e(number_format($total,2)); ?> <?php endif; ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $receipt_total = ($bal + $opening_cash_in_hand);
                                    ?>
                                </tbody>
                            </table>
                                        </td>
                                        <td>
                                            <table class="table table-bordered report-container">
                                <thead>
                                    <tr class="bg-grey">
                                        <th>Date</th>
                                        <th>A/C No</th>
                                        <th>Particular</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $bal = 0; ?>
<!-- Group type loop                                     -->
                                    <?php $__currentLoopData = $payment_gtype_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td colspan="6"><strong><?php echo e($group->gtype); ?></strong></td>
                                    </tr>
                                    <?php $total = 0; $i = 0; $x = 0; ?>
<!-- Subgroup type loop                                     -->

                                    <?php $__currentLoopData = stypeOfDaybookBetweenDates($loop_from_date, $loop_to_date, $group->gtype, 'Dr'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $i++;
                                    $total += $stype->amount;

                                    $x = count(stypeOfDaybookBetweenDates($loop_from_date, $loop_to_date, $group->gtype, 'Dr'));
                                    $bal += $stype->amount;
                                    ?>
                                    <tr>
                                        <td><?php echo e(date('d-m',strtotime($stype->date_of_transaction))); ?></td>
                                        <!-- <td><?php echo e($stype->entry_type); ?></td> -->
                                        <td><?php echo e($stype->account_no); ?></td>
                                        <td><?php echo e(str_limit($stype->particular,$limit=100,$end = '...')); ?></td>
                                        <td class=" must-right"><i class="fa fa-inr"></i> <?php echo e(number_format($stype->amount,2)); ?></td>
                                        <td class="<?php if($i == $x): ?> text-danger must-right <?php endif; ?>"> <?php if($i == $x): ?> <i class="fa fa-inr"></i> <?php echo e(number_format($total,2)); ?> <?php endif; ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $payment_total = $bal; ?>

                                </tbody>
                            </table>
                                        </td>
                                    </tr>
                                    <tr class="bg-grey">
                                        <td class="must-right"><strong>Total = <?php echo e(number_format(($receipt_total - $opening_cash_in_hand),2)); ?></strong></td>
                                        <td class="must-right"><strong>Total = <?php echo e(number_format(($payment_total),2)); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="must-right text-danger"><strong>Cash In Hand = </strong> <strong><i class="fa fa-inr"></i> <?php echo e(number_format(($receipt_total - $payment_total),2)); ?></strong></td>
                                    </tr>
                                    <tr class="bg-grey">
                                        <td class="must-right">Grand Total = <i class="fa fa-inr"></i> <?php echo e(number_format(($receipt_total),2)); ?></td>
                                        <td class="must-right">Grand Total = <i class="fa fa-inr"></i> <?php echo e(number_format(($bal + ($receipt_total - $payment_total)),2)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php endfor; ?>

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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Daily_Report/Day_Book/list2.blade.php ENDPATH**/ ?>