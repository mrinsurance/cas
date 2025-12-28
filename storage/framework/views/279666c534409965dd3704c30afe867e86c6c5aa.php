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
                    <form class="form-horizontal" action="<?php echo e(AUDIT_REPORT_URL_TRIAL_BALANCE); ?>" method="get">
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
                    <div class="prnt" id="record">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>
                                <?php echo e($company_address->name); ?>

                            </h3>
                                <?php echo e($company_address->address); ?>

                            <h4>
                                Trial Balance Report From  <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                to 
                                <?php echo e(date('d-M-Y',strtotime($to_date))); ?>

                            </h4>    
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Particular</th>
                                    <th>Opening</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th colspan="2">Balance</th>
                                </tr>
                                <tr>
                                    <th colspan="5"></th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
    $i = 1;
    $totalDr = 0;
    $totalCr = 0;
    $balance = 0;
    
    $baldr = 0;
    $balcr = 0;

?>
                    <?php $__currentLoopData = $tblLedgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainHead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$subGoupName = \App\subgroup_master_model::where('name',$mainHead->main_head)->first();
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

 $crSumOpening = \App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
->where('main_head',$mainHead->main_head)
->where('type_of_transaction','Cr')
->where('date_of_transaction','<',$from_date)
->sum('amount');

 $drSumOpening = \App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
->where('main_head',$mainHead->main_head)
->where('type_of_transaction','Dr')
->where('date_of_transaction','<',$from_date)
->sum('amount');

/* if(@$subGoupName->sub_group_for == 'Trading' || @$subGoupName->sub_group_for == 'Profit & Loss')
{
    $openingBalance = 0;
}
else
{ } */
    $openingBalance = ($drSumOpening - $crSumOpening);
 
$opBalance = ($drSumOpening - $crSumOpening);
$balance = ($opBalance + $drSum - $crSum);

?>                                
                                <tr>
                                    <td><?php echo e($i++); ?></td>
                                    <td><?php echo e(strtoupper($mainHead->main_head)); ?></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>
                                        <?php if($openingBalance > 0): ?>
                                            <?php echo e(number_format($openingBalance,2)); ?> <strong>Dr</strong>
                                        <?php elseif($openingBalance < 0): ?>
                                            <?php echo e(number_format(($openingBalance * -1),2)); ?> <strong>Cr</strong>
                                        <?php else: ?>
                                        0.00 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                        <?php endif; ?> 
                                        </td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($crSum,2)); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(number_format($drSum,2)); ?></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>
                                        <?php if($balance < 0): ?>
                                            <?php echo e(number_format(($balance * -1),2)); ?>

                                            <?php
                                                $balcr += ($balance * -1);
                                            ?>
                                        <?php else: ?>
                                        0.00   
                                        <?php endif; ?> 
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>
                                        <?php if($balance > 0): ?>
                                            <?php echo e(number_format($balance,2)); ?>

                                            <?php
                                                $baldr += $balance;
                                            ?>    
                                        <?php else: ?>
                                        0.00
                                        <?php endif; ?> 
                                    </td>                                   
                                </tr>
                                        <?php 
                                            $totalDr += $drSum;
                                            $totalCr += $crSum;
                                        ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td colspan="3"><strong>Opening Cash In Hand:</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($opening,2)); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>0.00</strong></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Closing Cash In Hand:</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong>0.00</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($closing,2)); ?></strong></td>
                                    <td>&nbsp;</td>
                                     <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($closing,2)); ?></strong></td>
                                </tr>                                
                                <tr>
                                    <td colspan="3"><strong>Total:</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($totalCr + $opening,2)); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($totalDr + $closing,2)); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($balcr,2)); ?></strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format(($baldr + $closing),2)); ?></strong></td>
                                                                        
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Audit//trial-balance.blade.php ENDPATH**/ ?>