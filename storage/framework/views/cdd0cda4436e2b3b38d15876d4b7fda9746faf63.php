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
        <h1>Loan Advancement Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Loan Advancement</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Loan Advancement Report
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="<?php echo e(AUDIT_REPORT_URL_LOAN_ADVANCEMENT); ?>" method="get">
                        <?php echo e(csrf_field()); ?>

                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">From</label>
                            <div class="col-md-8">
                                <!-- <input class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" id="from_date" placeholder="Check-In Date" readonly> -->
                                <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" placeholder="Check-In Date">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">To</label>
                            <div class="col-md-8">
                                <!-- <input class="form-control" value="<?php echo e(old(date('Y-m-d'),@$to_date)); ?>" name="to_date" id="to_date" placeholder="Check-In Date" readonly> -->
                                <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$to_date)); ?>" name="to_date">
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
                            <label class="col-md-4 control-label" for="email">Loan Type</label>
                            <div class="col-md-8">
                                <select name="loan_type" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $loan_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$loan_type == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 col-md-offset-5">
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
                                                Loan Advancement Report from  <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                                to
                                                <?php echo e(date('d-M-Y',strtotime($to_date))); ?>

                                            </h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Parnote No</th>
                                    <th>Date of Advance</th>
                                    <th>A/C No.</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Purpose</th>
                                    <th>Guarantor (A/C)</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $_loanReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($_loan->parnote_no); ?></td>
                                    <td><?php echo e(date('d-M-Y',strtotime($_loan->date_of_advance))); ?></td>
                                    <td><?php echo e($_loan->account_no); ?></td>
                                    <td><?php echo e(@$_loan->open_new_ac_model->full_name); ?></td>
                                    <td class="align_right"><?php echo e(number_format($_loan->amount)); ?></td>
                                    <td>
                                        <?php
                                        $purpose = DB::table('loanpurpose_models')->where('id',$_loan->loan_purpose)->first();
                                        ?>
                                        <?php echo e($purpose->name); ?>

                                    </td>
                                    <td>
                                        <?php
                                        $guarnter_one = DB::table('open_new_ac_models')->where('id',$_loan->guarnter_one)->first();
                                        $guarnter_two = DB::table('open_new_ac_models')->where('id',$_loan->guarnter_two)->first();
                                        ?>
                                        <?php echo e(@$guarnter_one->full_name); ?> (<?php echo e(@$guarnter_one->account_no); ?>)
                                        <br><?php echo e(@$guarnter_two->full_name); ?> (<?php echo e(@$guarnter_two->account_no); ?>)
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="5" class="align_right"><strong>Total</strong></td>
                                    <td class="align_right"><strong><?php echo e(number_format($_loanTotal)); ?></strong></td>
                                    <td colspan="3" >&nbsp;</td>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/Audit//loan-advancement.blade.php ENDPATH**/ ?>