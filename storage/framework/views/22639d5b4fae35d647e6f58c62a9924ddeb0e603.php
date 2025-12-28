<!DOCTYPE html>
<head>
    <title></title>
     <style type="text/css">
        body
        {
            font-family: Arial;
            font-size: 10pt;
        }
        table
        {
            border: 0px solid #ccc;
            border-collapse: collapse;
        }
        table th
        {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }
        table th, table td
        {
            padding: 5px;
            border: 1px solid #ccc;
        }
        .no-border{
            border: 0px !important;
        }
        table.report-container
        {
            page-break-after: always;
        }
        thead.report-header{
            display: table-header-group;
        }
        .text-right{
            text-align: right;
        }


    </style>
    <script type="text/php">
    if ( isset($pdf) ) {
        $font = Font_Metrics::get_font("helvetica", "bold");
        $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
    }
</script>
</head>
<body>

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
        <div style="margin: 30px 0; text-align: center">
            <div class="col-12 text-center">
                <h3><?php echo e(CompanyAddress()['name']); ?> <br> <?php echo e(CompanyAddress()['address']); ?> <br> Cash Book of <?php echo e(\Carbon\Carbon::parse($loop_from_date)->format('d-M-Y')); ?></h3>
            </div>
        </div>
        <table class="table table-bordered">
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
                    <table class="table table-bordered">
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
                    <table class="table table-bordered">
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
                <td class="text-right"><strong>Total = <?php echo e(number_format(($receipt_total - $opening_cash_in_hand),2)); ?></strong></td>
                <td class="text-right"><strong>Total = <?php echo e(number_format(($payment_total),2)); ?></strong></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-right text-danger"><strong>Cash In Hand = </strong> <strong><i class="fa fa-inr"></i> <?php echo e(number_format(($receipt_total - $payment_total),2)); ?></strong></td>
            </tr>
            <tr class="bg-grey">
                <td class="text-right">Grand Total = <i class="fa fa-inr"></i> <?php echo e(number_format(($receipt_total),2)); ?></td>
                <td class="text-right">Grand Total = <i class="fa fa-inr"></i> <?php echo e(number_format(($bal + ($receipt_total - $payment_total)),2)); ?></td>
            </tr>
            </tbody>
        </table>
    <?php endfor; ?>

</div>

</body>
</html><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Daily_Report/Day_Book/pdf_view_combine.blade.php ENDPATH**/ ?>