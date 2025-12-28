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
        <h1>Loan Defaulter</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Loan Defaulter</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Loan Defaulter List
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="<?php echo e(D_BALANCE_REPORT_URL_LOAN_DEFAULTER); ?>" method="get">
                        <?php echo e(csrf_field()); ?>

                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">As On</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="<?php echo e(old(date('Y-m-d'),@$from_date)); ?>" name="from_date" placeholder="Check-In Date">
                            </div>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Loan Type</label>
                            <div class="col-md-8">
                                <select name="loan_type" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $loan_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e($loan_type == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Year</label>
                            <div class="col-md-8">
                                <select name="defaulter_year" class="form-control">
                                    <option value="0">0</option>
                                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($year); ?>" <?php echo e($defaulter_year == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Ward</label>
                            <div class="col-md-8">
                                <select name="ward" class="form-control">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $userWard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ward->ward); ?>" <?php echo e($ward->ward == request()->ward ? 'selected' : ''); ?>><?php echo e($ward->ward); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </select>
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
                                    <td colspan="7">
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
                                     Loan Defaulter List For <?php echo e($defaulter_year); ?> Year as on <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>Loan's Balance</th>
                                    <th>Loan Date</th>
                                    <th>Last Recover Date</th>
                                    <th>Guarantor (A/C)</th>
                                    <th>Recoverable Intr</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1; 
                                    $total_of_balance = 0;
                                    $total_recover_int = 0;
                                ?>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(request()->ward == true && @$item->open_new_ac_model->ward == request()->ward): ?>
                                <?php
 //Sum of received principal from loan return table  
                                $tbl_loan_return_model_sum = \App\tbl_loan_return_model::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(tbl_loan_return_models.received_principal),0) total_received_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->where('received_date','<=',$from_date)
                                ->first();
// Get years between two dates

$date_1 = new DateTime(date('Y-m-d',strtotime($item->date_of_advance)));
$date_2 = new DateTime(date('Y-m-d',strtotime($from_date)));
$difference = $date_2->diff( $date_1 );                                
$yr =  (string)$difference->y;
 
//Loan installment

                                ?>
                                <?php if($yr >= $defaulter_year): ?>
                                <?php if(($item->amount - $tbl_loan_return_model_sum->total_received_principal) > 0): ?>
<?php
//Get days from loan return table                                
            $tbl_loan_return_model_days = \App\tbl_loan_return_model::select('id','loan_ac_model_id','received_date')
            ->orderBy('received_date','desc')
            ->where('loan_ac_model_id',$item->id)
            ->where('received_date','<=',$from_date)
            ->first();                                
            if($tbl_loan_return_model_days)
            {
                $_rdate = $tbl_loan_return_model_days->received_date;
            }
            else
            {
                $_rdate = $item->date_of_advance;
            }
            $fdate=date('Y-m-d',strtotime($_rdate));
            $tdate=date('Y-m-d',strtotime($from_date));

            $to = \Carbon\Carbon::createFromFormat('Y-m-d', $fdate);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $tdate);
            $diff_in_days = $to->diffInDays($from);
//Overdue principal from loan installment table
            $loan_ac_installment_sum = \App\loan_ac_installment::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(loan_ac_installments.principal),0) total_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->where('installment_date','<=',$from_date)
                                ->first();
$_over_amount = 0;
if($loan_ac_installment_sum->total_principal > $tbl_loan_return_model_sum->total_received_principal)       
{
    $_over_amount = $loan_ac_installment_sum->total_principal - $tbl_loan_return_model_sum->total_received_principal;
}
$_amount = ($item->amount - $tbl_loan_return_model_sum->total_received_principal) - $_over_amount;

//Calculating interest Reduce and flat

            $cintr = 0;
            $ointr = 0;
            $tintr = 0;

            
            
              if(($_over_amount + $_amount) > 0)
              {
                $ointr = ((($_over_amount * $diff_in_days) * $item->pannelty_int) / 36500);

                $cintr = ((($_amount * $diff_in_days) * $item->interest) / 36500);

                $tintr = $cintr + $ointr;
              }
              else{
                $tintr = 0;
              
            }                       
        
        $tintr = round($tintr);

        
?>                         


                                <tr>
                                    <td><?php echo e($i++); ?> <?php echo e($tbl_loan_return_model_sum->principal); ?></td>
                                    <td><?php echo e(@$item->open_new_ac_model->full_name); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(($item->amount - $tbl_loan_return_model_sum->total_received_principal)); ?></td>
                                    <td class="align_right"><?php echo e(date('d/m/Y',strtotime($item->date_of_advance))); ?></td>
                                    <td class="align_right"><?php echo e(date('d/m/Y',strtotime($_rdate))); ?></td>
                                    <td>
                                        <?php
                                            $guarnter_one = DB::table('open_new_ac_models')->where('id',$item->guarnter_one)->first();
                                            $guarnter_two = DB::table('open_new_ac_models')->where('id',$item->guarnter_two)->first();
                                        ?>
                                        <?php echo e(@$guarnter_one->full_name); ?> (<?php echo e(@$guarnter_one->account_no); ?>)
                                        <br><?php echo e(@$guarnter_two->full_name); ?> (<?php echo e(@$guarnter_two->account_no); ?>)
                                    </td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($tintr); ?></td>
                                </tr>
                                <?php 
                                    $total_of_balance += ($item->amount - $tbl_loan_return_model_sum->total_received_principal);
                                    $total_recover_int += $tintr;
                                ?>
                                <?php endif; ?>
                                <?php endif; ?>
<!-- ward is false  -->
<?php elseif(request()->ward == false): ?>
      <?php
 //Sum of received principal from loan return table  
                                $tbl_loan_return_model_sum = \App\tbl_loan_return_model::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(tbl_loan_return_models.received_principal),0) total_received_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->where('received_date','<=',$from_date)
                                ->first();
// Get years between two dates

$date_1 = new DateTime(date('Y-m-d',strtotime($item->date_of_advance)));
$date_2 = new DateTime(date('Y-m-d',strtotime($from_date)));
$difference = $date_2->diff( $date_1 );                                
$yr =  (string)$difference->y;
 
//Loan installment

                                ?>
                                <?php if($yr >= $defaulter_year): ?>
                                <?php if(($item->amount - $tbl_loan_return_model_sum->total_received_principal) > 0): ?>
<?php
//Get days from loan return table                                
            $tbl_loan_return_model_days = \App\tbl_loan_return_model::select('id','loan_ac_model_id','received_date')
            ->orderBy('received_date','desc')
            ->where('loan_ac_model_id',$item->id)
            ->where('received_date','<=',$from_date)
            ->first();                                
            if($tbl_loan_return_model_days)
            {
                $_rdate = $tbl_loan_return_model_days->received_date;
            }
            else
            {
                $_rdate = $item->date_of_advance;
            }
            $fdate=date('Y-m-d',strtotime($_rdate));
            $tdate=date('Y-m-d',strtotime($from_date));

            $to = \Carbon\Carbon::createFromFormat('Y-m-d', $fdate);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $tdate);
            $diff_in_days = $to->diffInDays($from);
//Overdue principal from loan installment table
            $loan_ac_installment_sum = \App\loan_ac_installment::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(loan_ac_installments.principal),0) total_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->where('installment_date','<=',$from_date)
                                ->first();
$_over_amount = 0;
if($loan_ac_installment_sum->total_principal > $tbl_loan_return_model_sum->total_received_principal)       
{
    $_over_amount = $loan_ac_installment_sum->total_principal - $tbl_loan_return_model_sum->total_received_principal;
}
$_amount = ($item->amount - $tbl_loan_return_model_sum->total_received_principal) - $_over_amount;

//Calculating interest Reduce and flat

            $cintr = 0;
            $ointr = 0;
            $tintr = 0;

            
            
              if(($_over_amount + $_amount) > 0)
              {
                $ointr = ((($_over_amount * $diff_in_days) * $item->pannelty_int) / 36500);

                $cintr = ((($_amount * $diff_in_days) * $item->interest) / 36500);

                $tintr = $cintr + $ointr;
              }
              else{
                $tintr = 0;
              
            }                       
        
        $tintr = round($tintr);

        
?>                         


                                <tr>
                                    <td><?php echo e($i++); ?> <?php echo e($tbl_loan_return_model_sum->principal); ?></td>
                                    <td><?php echo e(@$item->open_new_ac_model->full_name); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e(($item->amount - $tbl_loan_return_model_sum->total_received_principal)); ?></td>
                                    <td class="align_right"><?php echo e(date('d/m/Y',strtotime($item->date_of_advance))); ?></td>
                                    <td class="align_right"><?php echo e(date('d/m/Y',strtotime($_rdate))); ?></td>
                                    <td>
                                        <?php
                                            $guarnter_one = DB::table('open_new_ac_models')->where('id',$item->guarnter_one)->first();
                                            $guarnter_two = DB::table('open_new_ac_models')->where('id',$item->guarnter_two)->first();
                                        ?>
                                        <?php echo e(@$guarnter_one->full_name); ?> (<?php echo e(@$guarnter_one->account_no); ?>)
                                        <br><?php echo e(@$guarnter_two->full_name); ?> (<?php echo e(@$guarnter_two->account_no); ?>)
                                    </td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($tintr); ?></td>
                                </tr>
                                <?php 
                                    $total_of_balance += ($item->amount - $tbl_loan_return_model_sum->total_received_principal);
                                    $total_recover_int += $tintr;
                                ?>
                                <?php endif; ?>
                                <?php endif; ?> 
                                <?php else: ?>                         <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e($total_of_balance); ?></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <strong><?php echo e($total_recover_int); ?></strong></td>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/Balance/loan-defaulter.blade.php ENDPATH**/ ?>