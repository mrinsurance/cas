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
    <script src="<?php echo e(ASSETS_JS); ?>day_book.js"></script>
    <!-- end of page level js -->
    <script type="text/javascript">
    function printDiv(printRecord){
          var printContents = $('#record').html();
          var originalContents = document.body.innerHTML;      
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
    };
    $('input[name="intr_rate"]').on('change', function (){
        if ($(this).is(":checked"))
        {
            $(".intr_rate").removeClass('hidden');
        }
        else {
            $(".intr_rate").addClass('hidden');
        }
    })
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
            <li class="active">Bank FD Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Report of Bank FD A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="<?php echo e(BALANCE_REPORT_URL_BANK_FD); ?>" method="get">
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
                            <label class="col-md-4 control-label" for="email">Bank</label>
                            <div class="col-md-8">
                                <select name="bank" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$bank == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Interest Rate</label>
                                <input type="checkbox" name="intr_rate" class="">

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
                                    <td colspan="<?php echo e(isset(request()->bank) ? 10 : 10); ?>">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                <?php echo e($company_address->name); ?>

                                            </h3>
                                                <?php echo e($company_address->address); ?>

                                            <h4>
<?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($val->id == $bank): ?>
<?php echo e($val->name); ?>

<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                Bank FD Balance Report as on <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th class="<?php echo e(isset(request()->bank) ? 'hide' : ''); ?>">Bank Name</th>
                                    <th>A/C No.</th>
                                    <th>FD No.</th>
                                    <th>FD Dated</th>
                                    <th>FD Amount</th>
                                    <th class="intr_rate hidden">@</th>
                                    <th>Recoverable Int</th>
                                    <th>Maturity Date</th>
                                    <th>Maturity Amount</th>
                                    <!-- <th>Maturity Amount</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalFd = 0;
                                $totalPayInt = 0;
                                $MatAmt = 0;        
                                ?>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$to = \Carbon\Carbon::createFromFormat('Y-m-d', $item->int_run_from);
$from = \Carbon\Carbon::createFromFormat('Y-m-d', $from_date);
$diff_in_days = $to->diffInDays($from);
$z = ($diff_in_days / 360) * 4;
$intr = ((pow((((400 +  $item->int_rate) / (400 * $item->amount)) * $item->amount), $z)) * $item->amount) - $item->amount;
$intr = round($intr);
?>

                                <tr>
                                    <td><?php echo e($loop->index +1); ?></td>
                                    <td class="<?php echo e(isset(request()->bank) ? 'hide' : ''); ?>"><?php echo e($item->bank_model->name); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td><?php echo e($item->fd_no); ?></td>
                                    <td class="align_right"><?php echo e(date('d/m/Y',strtotime($item->int_run_from))); ?></td>
                                    <td class="align_right"><?php echo e(number_format($item->amount,2,'.','')); ?></td>
                                    <td class="align_right intr_rate hidden"><?php echo e(number_format($item->int_rate,2,'.','')); ?>%</td>
                                    <td class="align_right"> <?php echo e(number_format($intr,2,'.','')); ?></td>
                                    <td class="align_right"><?php echo e(date('d/m/Y',strtotime($item->maturity_date))); ?></td>
                                    <td class="align_right"><?php echo e(number_format($item->maturity_amount,2,'.','')); ?></td>
                                </tr>
                                <?php
                                $totalFd = $totalFd + $item->amount;
                                $totalPayInt = $totalPayInt + $intr;
                                $MatAmt = $MatAmt + $item->maturity_amount;
                                ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th colspan="<?php echo e(isset(request()->bank) ? 4 : 5); ?>">Total</th>
                                    <th class="align_right"><?php echo e(number_format($totalFd,2,'.','')); ?></th>
                                    <th class="intr_rate hidden"></th>
                                    <th class="align_right"><?php echo e(number_format($totalPayInt,2,'.','')); ?></th>
                                    <th></th>
                                    <th class="align_right"><?php echo e(number_format($MatAmt,2,'.','')); ?></th>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Balance/bank_fd_balance.blade.php ENDPATH**/ ?>