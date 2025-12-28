<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
    <link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>jquery-ui.css" />

<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(ASSETS_VENDORS); ?>favicon/favicon.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>pages/form_examples.js"></script>
    <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>day_book.js"></script></script>
    <!-- end of page level js -->
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>


<aside class="right-side strech">

    <section class="content-header">
        <!--section starts-->
        <h1>Daily Collection Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Daily Collection Report</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
    <div class="col-md-12">
        <div class="panel-body">
            <form class="form-horizontal" action="<?php echo e(DAILY_REPORT_URL_DCR); ?>" method="get">
                <?php echo e(csrf_field()); ?>

                <fieldset>
                    <!-- Name input-->
                    <div class="form-group">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">From</label>
                                <div class="col-md-10">
                                    <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" id="from_date" placeholder="Check-In Date">
                                    <br>
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">View</button>
                                    <button type="submit" class="btn btn-responsive btn-warning btn-sm">Print</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">To</label>
                                <div class="col-md-10">
                                    <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$to_date)); ?>" name="to_date" id="to_date" placeholder="Check Out Date">
                                </div>
                            </div>
                        </div>
                        <?php if(Auth::user()->staff_type == 'Staff'): ?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">Branch</label>
                                <div class="col-md-10 text-left">
                                    <select name="branch" class="form-control">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($branch->id); ?>" <?php echo e(@$search_branch == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">Users</label>
                                <div class="col-md-10 text-left">
                                    <select name="user_type" class="form-control">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->id); ?>" <?php echo e(@$search_user == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?> (<?php echo e(@$val->designation_model->name); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
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
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> 
                            Receipt (Collection Report of <?php echo e(@$search_branch != '' ? $branch_name->name : 'All'); ?> Branch, collect by <?php echo e(@$search_user != '' ? $user_name->name : 'All'); ?>)
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive fixed-table-body">
                            <table class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>A/C No</th>
                                        <th>Particular</th>
                                        <th>Received</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
<!-- Gtype grouping -->
                                <?php $receipt = 0; $payment = 0; ?>
                                    <?php $__currentLoopData = $gtype_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="bg-default" colspan="6"><?php echo e($group->gtype); ?></td>
                                    </tr>
<!-- Stype loop -->
                                    <?php $__currentLoopData = $stypes->where('gtype',$group->gtype); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(date('d-M-Y',strtotime($stype->date_of_transaction))); ?></td>
                                        <td><?php echo e($stype->account_no); ?></td>
                                        <td><?php echo e($stype->particular); ?></td>
                                        <td class="must-right">
                                            <?php if($stype->type_of_transaction == 'Cr'): ?> 
                                            <?php $receipt += $stype->amount + $stype->additional_amt; ?>
                                                <i class="fa fa-inr"></i> <?php echo e(number_format($stype->amount + $stype->additional_amt,2)); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td class="must-right">
                                            <?php if($stype->type_of_transaction == 'Dr'): ?> 
                                            <?php $payment += $stype->amount + $stype->additional_amt; ?>
                                                <i class="fa fa-inr"></i> <?php echo e(number_format($stype->amount + $stype->additional_amt,2)); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($stype->shadow == 0): ?>
                                                <span class="text text-warning">Shadow</span>    
                                            <?php else: ?>
                                                <span class="text text-success">Clear</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td colspan="3" class="bg-grey">Total</td>
                                        <td class="bg-grey must-right"><i class="fa fa-inr"></i> <?php echo e(number_format($receipt,2)); ?></td>
                                        <td class="bg-grey must-right"><i class="fa fa-inr"></i> <?php echo e(number_format($payment,2)); ?></td>
                                        <td class="bg-grey must-right">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="bg-danger">Due Balance</td>
                                        <td class="bg-danger must-right"><i class="fa fa-inr"></i> <?php echo e(number_format(($receipt - $payment),2)); ?></td>
                                        <td class="bg-danger must-right">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Daily_Report/DCR/list.blade.php ENDPATH**/ ?>