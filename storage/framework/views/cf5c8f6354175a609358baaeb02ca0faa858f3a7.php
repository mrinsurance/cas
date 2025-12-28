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
    <script src="<?php echo e(ASSETS_JS); ?>day_book.js"></script>
    <script type="text/javascript">
        function printDiv(printRecord){
            var printContents = $('#record').html();
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        };
    </script>
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
            <li class="active">Sale Collection Report</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
    <div class="col-md-12">
        <div class="panel-body">
            <form action="<?php echo e(route('trading.sale.collection.report')); ?>" method="get">
                <?php echo e(csrf_field()); ?>

                <div class="row">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="first-name-column">From</label>
                                <input type="date" class="form-control" value="<?php echo e($fromDate); ?>" name="fromDate" placeholder="Check-In Date">
                            </div>
                        </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="first-name-column">To</label>
                            <input type="date" class="form-control" value="<?php echo e($toDate); ?>" name="toDate" placeholder="Check Out Date">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="first-name-column">User</label>
                            <select name="user" class="form-control">
                                <option value="">All</option>
                                <?php $__currentLoopData = AllUsers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($list['id']); ?>" <?php echo e($list['id'] == request()->get('user') ? 'selected' : ''); ?>><?php echo e($list['name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-responsive btn-primary btn-sm">View</button>
                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>                   
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="prnt" id="record">
                <div class="portlet box primary">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> 
                            Sale Collection From <?php echo e(request()->get('fromDate')); ?> to <?php echo e(request()->get('toDate')); ?> By
                            <?php if(request()->get('user')): ?>
                                <?php echo e(getUserById(request()->get('user'))['name']); ?>

                            <?php else: ?>
                                All
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive fixed-table-body">
                            <table class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>SR .No.</th>
                                        <th>Date</th>
                                        <th>Bill No.</th>
                                        <th>Bill Amount</th>
                                        <th>Sale By</th>
                                        <th>Product Type</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $saleData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index + 1); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($list->date_of_transaction)->format('d-M-Y')); ?></td>
                                        <td><?php echo e($list->bill_no); ?></td>
                                        <td><?php echo e($list->amount); ?></td>
                                        <td><?php echo e(getUserById($list->user_id)['name']); ?></td>
                                        <td><?php echo e(getProductTypeById($list->product_type_master_tbl_id)['name']); ?></td>

                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                               Total Records = <?php echo e(count($saleData)); ?>

                            </div>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Trading/Sale/collection-report.blade.php ENDPATH**/ ?>