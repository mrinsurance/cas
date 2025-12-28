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
        <h1>Receipt & Disbursement Report</h1>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Receipt & Disbursement Report
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="<?php echo e(AUDIT_REPORT_URL_RD); ?>" method="get">
                        <?php echo e(csrf_field()); ?>

                        <div class="col-md-2">
                            <span>From</span>
                            <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" placeholder="Check-In Date">
                        </div>
                        <div class="col-md-2">
                            <span>To</span>
                            <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$to_date)); ?>" name="to_date">
                        </div>
                        <div class="col-md-2">
                            <span>Branch</span>
                            <select name="branch" class="form-control">
                                <option value="">All</option>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val->id); ?>" <?php echo e(@$branch == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 align_right">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </form>    
                    </div>
                    </div>
                     <!-- Print view                         -->
                        <div class="prnt" id="record">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>
                                <?php echo e($company_address->name); ?>

                            </h3>
                                <?php echo e($company_address->address); ?>

                            <h4>
                                Receipt & Disbursement Report from  <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                to 
                                <?php echo e(date('d-M-Y',strtotime($to_date))); ?>

                            </h4>    
                        </div>
                    </div>
                    <div class="table-scrollable">                      
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Particular</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
    $i = 1;
    $totalDr = 0;
    $totalCr = 0;

?>
                                <?php $__currentLoopData = $tblLedgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainHead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
 $crSum = \App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
->where('main_head',$mainHead->main_head)
->where('type_of_transaction','Cr')
->whereBetween('date_of_transaction',[$from_date,$to_date])
->sum('amount');

 $drSum = \App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
->where('main_head',$mainHead->main_head)
->where('type_of_transaction','Dr')
->whereBetween('date_of_transaction',[$from_date,$to_date])
->sum('amount');

?>                                
                                <tr>
                                    <td><?php echo e($i++); ?></td>
                                    <td><?php echo e(strtoupper($mainHead->main_head)); ?></td>
                                    <td class="align_right"> <?php echo e(number_format($crSum,2,'.','')); ?></td>
                                    <td class="align_right"> <?php echo e(number_format($drSum,2,'.','')); ?></td>
                                </tr>
<?php 
    $totalDr += $drSum;
    $totalCr += $crSum;
?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td colspan="2"><strong>Opening Cash In Hand:</strong></td>
                                    <td class="align_right"> <strong><?php echo e(number_format($opening,2,'.','')); ?></strong></td>
                                    <td class="align_right"> <strong>0.00</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Closing Cash In Hand:</strong></td>
                                    <td class="align_right"> <strong>0.00</strong></td>
                                    <td class="align_right"> <strong><?php echo e(number_format($closing,2,'.','')); ?></strong></td>
                                </tr>                                
                                <tr>
                                    <td colspan="2"><strong>Total:</strong></td>
                                    <td class="align_right"> <strong><?php echo e(number_format($totalCr + $opening,2,'.','')); ?></strong></td>
                                    <td class="align_right"> <strong><?php echo e(number_format($totalDr + $closing,2,'.','')); ?></strong></td>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbara/resources/views/Audit//rd_report.blade.php ENDPATH**/ ?>