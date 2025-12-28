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
            <h1>Balance Report</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(HOME_LINK); ?>">
                        <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                    </a>
                </li>
                <li class="active">RD Balance</li>
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
                                <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Report of RD A/C
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-horizontal" action="<?php echo e(route('balance.report.page.total.balance.rd')); ?>" method="get">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="col-md-3">
                                            <label class="col-md-4 control-label" for="email">As On</label>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" placeholder="Check-In Date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-md-4 control-label" for="email">Branch</label>
                                            <div class="col-md-8">
                                                <select name="branch" class="form-control">
                                                    <option value="">All</option>
                                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val->id); ?>" <?php echo e(@$branch == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-md-4 control-label" for="email">Type</label>
                                            <div class="col-md-8">
                                                <select name="member_type" class="form-control">
                                                    <option value="">All</option>
                                                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val->id); ?>" <?php echo e(@$member_type == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="checkbox" name="wp" <?php echo e(request()->wp == TRUE ? 'checked' : ''); ?>>
                                            <label class="control-label" for="email">Without Payable</label>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                                                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($val->id == $member_type): ?>
                                                                <?php echo e($val->name); ?>

                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        RD Balance Report as on <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                                    </h4>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>A/C No.</th>
                                            <th>RD No.</th>
                                            <th>RD Dated</th>
                                            <th>RD Amount</th>
                                            <?php if(request()->wp == false): ?>
                                                <th>Payable Int</th>
                                            <?php endif; ?>
                                            <th>Maturity Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $totalFd = 0;
                                            $totalPayble = 0;
                                            $srn = 0;
                                            $rec = 0;
                                            $grandTotalFd = 0;
                                            $trec = 0;
                                            $pageTotalFd = 0;
                                            $pageTotalPayInt = 0;
                                            $grandTotalFd = 0;
                                            $grandTotalPayInt = 0;
                                            $totalPayInt = 0;
                                        ?>
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $srn++;
                                            $rec++;
                                            $trec++;
                                                $totall = \App\rd_installment_model::where('rd_model_id',$item->id)
                                                ->where('installment_date','<=',$from_date)
                                                ->sum('amount');

                                                $installment = ($totall / $item->amount);


                                            $principal = $item->amount;
                                            $interest_rate = ($item->int_rate / 100);

                                            $matured_amount = 0;
                                            $n = $installment / 4;
                                            for ($i = $installment; $i >=1 ; $i--) {
                                            $matured_amount = $matured_amount + ($principal * pow(1+$interest_rate/$n, $n*$i/12));
                                            }
                                            $maturity_amount = round($matured_amount);

                                            $pageTotalFd += $totall;
                                            $pageTotalPayInt += ($maturity_amount - $totall);
                                            ?>
                                            <?php if(count($items) > 32): ?>
                                                <?php if($rec == 1): ?>
                                                    <tr>
                                                        <td colspan="5"><strong>Previous Total</strong></td>
                                                        <td class="align_right"><strong><?php echo e(number_format(0,2,'.','')); ?></td>
                                                        <?php if(request()->wp == FALSE): ?>
                                                            <td class="align_right"><strong><?php echo e(number_format(0,2,'.','')); ?></td>
                                                        <?php endif; ?>
                                                        <td class="align_right"></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <tr>
                                                <td><?php echo e($loop->index +1); ?></td>
                                                <td> <?php echo e(str_limit($item->open_new_ac_model->full_name,15)); ?> </td>
                                                <td><?php echo e($item->account_no); ?></td>
                                                <td><?php echo e($item->rd_no); ?></td>
                                                <td class="align_right"><?php echo e(date('d/m/Y',strtotime($item->transaction_date))); ?></td>
                                                <td class="align_right">
                                                    <?php echo e(number_format($totall,2,'.','')); ?>

                                                </td>
                                                <?php if(request()->wp == false): ?>
                                                    <td class="align_right"><?php echo e(number_format($maturity_amount - $totall,2,'.','')); ?></td>
                                                <?php endif; ?>
                                                <td class="align_right"><?php echo e(date('d/m/Y',strtotime($item->maturity_date))); ?></td>
                                            </tr>
                                            <?php if($srn == 32): ?>
                                                <?php
                                                    $grandTotalFd += $pageTotalFd;
                                                    $grandTotalPayInt += $pageTotalPayInt;
                                                ?>
                                                <tr>
                                                    <td colspan="5"><strong>Page Total</strong></td>
                                                    <td class="align_right"> <strong><?php echo e(number_format($pageTotalFd,2,'.','')); ?></strong></td>
                                                    <?php if(request()->wp == FALSE): ?>
                                                        <td class="align_right"> <strong><?php echo e(number_format($pageTotalPayInt,2,'.','')); ?></strong></td>
                                                    <?php endif; ?>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><strong>Grand Total</strong></td>
                                                    <td class="align_right"> <strong><?php echo e(number_format($grandTotalFd,2,'.','')); ?></strong></td>
                                                    <?php if(request()->wp == FALSE): ?>
                                                        <td class="align_right"> <strong><?php echo e(number_format($grandTotalPayInt,2,'.','')); ?></strong></td>
                                                    <?php endif; ?>
                                                    <td></td>
                                                </tr>
                                                <?php if(count($items) > $trec): ?>
                                                    <tr>
                                                        <td colspan="5"><strong>Previous Total</strong></td>
                                                        <td class="align_right"> <strong><?php echo e(number_format($grandTotalFd,2,'.','')); ?></strong></td>
                                                        <?php if(request()->wp == FALSE): ?>
                                                            <td class="align_right"> <strong><?php echo e(number_format($grandTotalPayInt,2,'.','')); ?></strong></td>
                                                        <?php endif; ?>
                                                        <td></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php
                                                    $pageTotalFd = 0;
                                                    $pageTotalPayInt = 0;
                                                   $srn = 0;
                                                ?>
                                            <?php else: ?>
                                                <?php if(count($items) == $trec): ?>
                                                    <?php
                                                        $grandTotalFd += $pageTotalFd;
                                                        $grandTotalPayInt += $pageTotalPayInt;
                                                    ?>
                                                    <tr>
                                                        <td colspan="5"><strong>Page Total</strong></td>
                                                        <td class="align_right"> <strong><?php echo e(number_format($pageTotalFd,2,'.','')); ?></strong></td>
                                                        <?php if(request()->wp == FALSE): ?>
                                                            <td class="align_right"> <strong><?php echo e(number_format($pageTotalPayInt,2,'.','')); ?></strong></td>
                                                        <?php endif; ?>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"><strong>Grand Total</strong></td>
                                                        <td class="align_right"> <strong><?php echo e(number_format($grandTotalFd,2,'.','')); ?></strong></td>
                                                        <?php if(request()->wp == FALSE): ?>
                                                            <td class="align_right"> <strong><?php echo e(number_format($grandTotalPayInt,2,'.','')); ?></strong></td>
                                                        <?php endif; ?>
                                                        <td></td>
                                                    </tr>
                                                <?php endif; ?>

                                            <?php endif; ?>

                                            <?php
                                                $totalFd = $totalFd + $totall;
                                                $totalPayble = ($totalPayble + ($maturity_amount - $totall));
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/BalancePageTotal/rd_balance.blade.php ENDPATH**/ ?>