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
        <h1>Ward Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Ward Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Ward Report
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="<?php echo e(ADDITIONAL_WARD_AGENT); ?>" method="get">
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
                            <label class="col-md-4 control-label" for="email">Ward</label>
                            <div class="col-md-8">
                                <input type="text" name="ward" class="form-control" value="<?php echo e(request()->ward); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Minimum Share</label>
                            <div class="col-md-8">
                                <input type="text" name="min_share" class="form-control" value="<?php echo e(request()->min_share); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Gender</label>
                            <div class="col-md-8">
                                <select name="gender" class="form-control">
                                    <option value="">All</option>
                                    <option value="Male" <?php echo e(request()->gender == 'Male' ? 'selected' : ''); ?>>Male</option>
                                    <option value="Female" <?php echo e(request()->gender == 'Female' ? 'selected' : ''); ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Category</label>
                            <div class="col-md-8">
                                <select name="category" class="form-control">
                                    <option value="">All</option>
                                    <option value="General" <?php echo e(request()->category == 'General' ? 'selected' : ''); ?>>General</option>
                                    <option value="OBC" <?php echo e(request()->category == 'OBC' ? 'selected' : ''); ?>>OBC</option>
                                    <option value="SC" <?php echo e(request()->category == 'SC' ? 'selected' : ''); ?>>SC</option> 
                                    <option value="ST" <?php echo e(request()->category == 'ST' ? 'selected' : ''); ?>>ST</option> 
                                    <option value="Other" <?php echo e(request()->category == 'Other' ? 'selected' : ''); ?>>Other</option>
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
                                                
                                                Ward <?php echo e(request()->ward); ?> Report as on <?php echo e(date('d-M-Y',strtotime($from_date))); ?> 
<?php if(request()->gender != '' && request()->gender == 'M'): ?>
(Male)
<?php endif; ?>
<?php if(request()->gender != '' && request()->gender == 'F'): ?>
(Female)
<?php endif; ?>
<?php if(request()->category): ?>
(<?php echo e(request()->category); ?>)
<?php endif; ?>

                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>A/C No.</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $rec = 0; 
                                    $prv_total = 0; 
                                    $page_total = 0;  
                                    $grand_total = 0; 
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
                                <?php if($balance >= request()->min_share): ?>
                                <?php 
                                    $srn++;  
                                    $rec++;
                                ?>
                                
                                <tr>
                                    <td><?php echo e($rec); ?></td>
                                    <td><?php echo e($val->full_name); ?></td>
                                    <td><?php echo e($val->father_name); ?></td>
                                    <td><?php echo e($val->account_no); ?></td>
                                    <td> <?php echo e($val->current_address_first); ?></td>
                                </tr>
                                <?php endif; ?>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Additional/ward-report.blade.php ENDPATH**/ ?>