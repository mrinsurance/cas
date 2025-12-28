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
            <li class="active">Share Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Report of Share A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="<?php echo e(BALANCE_REPORT_URL_SHARE); ?>" method="get">
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
                                    <td colspan="5">
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
                                                Share Balance Report as on <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>A/C No.</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $rec = 0; 
                                    $prv_total = 0; 
                                    $page_total = 0;  
                                   
                                    if(@$_REQUEST['paginate_total_grand']){
                                        $grand_total =(int)$_REQUEST['paginate_total_grand'];
                                    }else{
                                        $grand_total = 0;
                                    } 
                                    $srn = 0; 
                                    $trec = 0;
                                ?>
                                <?php $__currentLoopData = $ac_holders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                               $deposit = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<=',$from_date)->sum('amount');

                               $withdraw = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<=',$from_date)->sum('amount');

                               $balance = ($deposit - $withdraw);

                               $page_total += $balance; 
                               $grand_total = ($grand_total + $balance); 
                               $trec++;

                                ?>
                                <?php if($balance != 0): ?>
                                <?php 
                                    $srn++;  
                                    $rec++;
                                ?>
                                <?php if(count($ac_holders) > 32): ?>
                                <?php if($rec == 1): ?>
                                <tr>
                                    <td colspan="4"><strong>Previous Total </strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e((@(int)$_REQUEST['paginate_total_grand'])?$_REQUEST['paginate_total_grand']:number_format(0,2)); ?></strong></td>
                                </tr>
                                <?php endif; ?>
                                <?php endif; ?>
                                <tr>
                                    <td><?php echo e($rec); ?></td>
                                    <td><?php echo e($val->full_name); ?></td>
                                    <td><?php echo e($val->father_name); ?></td>
                                    <td><?php echo e($val->account_no); ?></td>
                                    <td class="align_right"><?php echo e(number_format($balance,2)); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($srn == 32): ?>
                                <tr>
                                    <td colspan="4"><strong>Page Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($page_total,2)); ?></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><strong>Grand Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($grand_total,2)); ?></strong></td>
                                </tr>
                                <?php if(count($ac_holders) > $trec): ?>
                                <tr>
                                    <td colspan="4"><strong>Previous Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($grand_total,2)); ?></strong></td>
                                </tr>
                                <?php endif; ?>
                                <?php $page_total = 0; $srn = 0; ?>
                                <?php else: ?>
                                    <?php if(count($ac_holders) == $trec): ?>
                                    <tr>
                                    <td colspan="4"><strong>Page Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($page_total,2)); ?></strong></td>
                                    </tr>
                                    <tr>
                                    <td colspan="4"><strong>Grand Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e(number_format($grand_total,2)); ?></strong></td>
                                    </tr>
                                    <?php $paginate_total_grand = $grand_total; $page_total = 0; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        </div>
                        <?php if(isset($_REQUEST['_token'])): ?>
                        <div style="float: right;margin-right:10px"><?php echo e(@($_REQUEST['from_date'])?@$ac_holders->appends(['_token' => $_REQUEST['_token'],'branch' => @$_REQUEST['branch'],'from_date' => @$_REQUEST['from_date'],'branch' => $_REQUEST['branch'],'member_type' => @$_REQUEST['member_type'],'paginate_total_grand'=>@$paginate_total_grand])->render():''); ?></div>
                    <?php endif; ?>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Balance/share_balance.blade.php ENDPATH**/ ?>