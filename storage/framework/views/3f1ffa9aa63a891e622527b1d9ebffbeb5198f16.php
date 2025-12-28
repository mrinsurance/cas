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
            <li class="active">FD Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Report of FD A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="<?php echo e(route('setting.fixed-deposit-second')); ?>" method="get">
                        <?php echo e(csrf_field()); ?>

                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="control-label" for="email">As On</label>
                                <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" placeholder="Check-In Date">

                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="email">Branch</label>
                                <select name="branch" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$branch == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="email">Member Type</label>
                             <select name="member_type" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$member_type == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="email">Order By</label>
                            <select name="orderBy" class="form-control">
                                <option value="">All</option>
                                    <option value="1" <?php echo e(request()->get('orderBy') == 1 ? 'selected' : ''); ?>>Account No</option>
                                    <option value="2" <?php echo e(request()->get('orderBy') == 2 ? 'selected' : ''); ?>>FD No</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="email">Deposit Type</label>
                                <select name="deposit_type" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = TypeOfDeposit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val['name']); ?>" <?php echo e(request()->deposit_type == $val['name'] ? 'selected' : ''); ?>><?php echo e($val['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <br>
                                <input type="checkbox" name="wp" <?php echo e(request()->wp == TRUE ? 'checked' : ''); ?>>
                            <label class="control-label" for="email">Without Payable</label>

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

                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="13">
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
                                                FD Balance Report as on <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                            </h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Admission No.</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>FD No.</th>
                                    <th>FD Dated</th>
                                    <th>FD Amount</th>
                                    <th>Period</th>
                                    <th>ROI</th>
                                    <th>Interest</th>
                                    <th>Maturity Amount</th>
                                    <th>Maturity Date</th>
                                    <?php if(request()->wp == FALSE): ?>
                                        <th>Payable Int</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalFd = 0;
                                $totalPayInt = 0;
                                ?>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$to = \Carbon\Carbon::createFromFormat('Y-m-d', $item->int_run_from);
$from = \Carbon\Carbon::createFromFormat('Y-m-d', $from_date);
$diff_in_days = $to->diffInDays($from);
switch ($item->interest_type) {
    case "Simple Interest":
        $intr = ($item->amount * $diff_in_days * $item->int_rate) / 36500;
        break;
    case "Quarterly Interest":
        $z = ($diff_in_days / 360) * 4;
        $intr = ((pow((((400 +  $item->int_rate) / (400 * $item->amount)) * $item->amount), $z)) * $item->amount) - $item->amount;
        break;
    case "Yearly Interest":
        $z = ($diff_in_days / 360);
        $intr = ((pow((((100 +  $item->int_rate) / (100 * $item->amount)) * $item->amount), $z)) * $item->amount) - $item->amount;
        break;
}
$intr = round($intr);

$paidIntrQuery = App\interest_on_fd_tbl::where('fd_ac_model_id',$item->id)->whereDate('paid_on','<=',$from_date)->sum('interest_amt');

?>

                                <tr>
                                    <td><?php echo e($loop->index +1); ?></td>
                                    <td><?php echo e($item->open_new_ac_model->id ?? ''); ?></td>
                                    <td><?php echo e(str_limit(trim(@$item->open_new_ac_model->full_name),13)); ?>  <?php echo e($item->lf_no ?? ''); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td><?php echo e($item->fd_no); ?></td>
                                    <td class="align_right"><?php echo e(\Carbon\Carbon::parse($item->int_run_from)->format('Y-m-d')); ?></td>
                                    <td class="align_right"><?php echo e(number_format($item->amount + $paidIntrQuery,2,'.','')); ?></td>
                                    <td class="align_right"><?php echo e($item->period_fd); ?></td>
                                    <td class="align_right"><?php echo e($item->int_rate); ?></td>
                                    <td class="align_right"><?php echo e(($item->maturity_amount - ($item->amount + $paidIntrQuery))); ?></td>
                                    <td class="align_right"><?php echo e($item->maturity_amount); ?></td>
                                    <td class="align_right"><?php echo e(\Carbon\Carbon::parse($item->maturity_date)->format('Y-m-d')); ?></td>
                                    <?php if(request()->wp == FALSE): ?>
                                        <td class="align_right"><?php echo e(number_format($intr,2,'.','')); ?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php
                                $totalFd = $totalFd + $item->amount + $paidIntrQuery;
                                $totalPayInt = $totalPayInt + $intr;
                                ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th class="align_right"><?php echo e(number_format($totalFd,2,'.','')); ?></th>
                                    <?php if(request()->wp == FALSE): ?>
                                    <th class="align_right"><?php echo e(number_format($totalPayInt,2,'.','')); ?></th>
                                    <?php endif; ?>
                                    <th></th>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Balance/fd_balance_second.blade.php ENDPATH**/ ?>