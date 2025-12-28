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
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Balance Book</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Balance Book</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Book
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="<?php echo e(route('balance.report.page.total.balance.book')); ?>" method="get">
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
                                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$member_type == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="submit" value="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

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
                                    <td colspan="8">
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
                                                Balance Book as on <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                            </h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>Share</th>
                                    <th>Loan</th>
                                    <th>Last Recovery</th>
                                    <th>Rec Intr</th>
                                    <th>Saving</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $rec = 0;
                                    $share_prv_total = 0;
                                    $share_page_total = 0;
                                    $share_grand_total = 0;
                                    $loan_grand_total = 0;
                                    $loan_intr_grand_total = 0;

                                    $saving_prv_total = 0;
                                    $saving_page_total = 0;
                                    $saving_grand_total = 0;

                                    $total_of_balance = 0;
                                    $total_recover_int = 0;

                                    $loan_page_total = 0;
                                    $loan_intr_page_total = 0;

                                    $loan_tintr = 0;

                                    $srn = 0;
                                    $trec = 0;
                                    $serial = 0;
                                ?>
                                <?php $__currentLoopData = $ac_holders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $serial++;
     //Share Balance
                                   $share_deposit = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<=',$from_date)->sum('amount');

                                   $share_withdraw = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<=',$from_date)->sum('amount');

                                   $share_balance = ($share_deposit - $share_withdraw);

                                   $share_page_total += $share_balance;
                                   $share_grand_total = ($share_grand_total + $share_balance);
    // Saving Balance
                                   $saving_deposit = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<=',$from_date)->sum('amount');

                                   $saving_withdraw = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<=',$from_date)->sum('amount');

                                   $saving_balance = ($saving_deposit - $saving_withdraw);

                                   $saving_page_total += $saving_balance;
                                   $saving_grand_total = ($saving_grand_total + $saving_balance);
    // Loan Balance
    $loan_tntr = [];
    $loan_date = [];
    $loan_amount = [];
    $cintr = 0;
    $ointr = 0;
    $tintr = 0;
    $fdate = '';
    $_over_amount = 0;
    $_amount = 0;
     //Sum of received principal from loan return table
     $loan_ac_holders = \App\loan_ac_model::where('open_new_ac_model_id',$val->id)->where('loan_type','!=',3)->where('date_of_advance','<=',request()->from_date)->get();

     foreach($loan_ac_holders as $loan_ac_by_holder)
     {

     //Sum of received principal from loan return table
        $tbl_loan_return_model_sum = \App\tbl_loan_return_model::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(tbl_loan_return_models.received_principal),0) total_received_principal'))
        ->where('loan_ac_model_id',$loan_ac_by_holder->id)
        ->where('received_date','<=',$from_date)
        ->first();
        if($tbl_loan_return_model_sum->loan_ac_model_id == null)
        {
            $received_pr = 0;
        }
        else
        {
            $received_pr = $tbl_loan_return_model_sum->total_received_principal;
        }

        if(($loan_ac_by_holder->amount - $received_pr) > 0)
        {
            //Get days from loan return table
                $tbl_loan_return_model_days = \App\tbl_loan_return_model::select('id','loan_ac_model_id','received_date','pending_intr')
                ->orderBy('received_date','desc')
                ->where('loan_ac_model_id',$loan_ac_by_holder->id)
                ->where('received_date','<=',$from_date)
                ->first();

                if($tbl_loan_return_model_days)
                {
                    $_rdate = $tbl_loan_return_model_days->received_date;
                    $pendingInterest =  $tbl_loan_return_model_days->pending_intr;
                }
                else
                {
                    $_rdate = $loan_ac_by_holder->date_of_advance;
                    $pendingInterest = 0;
                }
                $fdate=date('Y-m-d',strtotime($_rdate));
                $tdate=date('Y-m-d',strtotime($from_date));

                $to = \Carbon\Carbon::createFromFormat('Y-m-d', $fdate);
                $from = \Carbon\Carbon::createFromFormat('Y-m-d', $tdate);
                $diff_in_days = $to->diffInDays($from);
    //Overdue principal from loan installment table
                $loan_ac_installment_sum = \App\loan_ac_installment::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(loan_ac_installments.principal),0) total_principal'))
                ->where('loan_ac_model_id',$loan_ac_by_holder->id)
                ->where('installment_date','<=',$from_date)
                ->first();

    $_over_amount = 0;
    $_amount = 0;
    if($loan_ac_installment_sum->total_principal > $tbl_loan_return_model_sum->total_received_principal)
    {
        $_over_amount = $loan_ac_installment_sum->total_principal - $tbl_loan_return_model_sum->total_received_principal;
    }
    $_amount = ($loan_ac_by_holder->amount - $tbl_loan_return_model_sum->total_received_principal) - $_over_amount;

    //Calculating interest Reduce and flat


                  if(($_over_amount + $_amount) > 0)
                  {
                    $ointr = ((($_over_amount * $diff_in_days) * $loan_ac_by_holder->pannelty_int) / 36500);

                    $cintr = ((($_amount * $diff_in_days) * $loan_ac_by_holder->interest) / 36500);

                    $tintr = $cintr + $ointr;
                  }
                  else{
                    $tintr = 0;

                }

           $tintr = round($tintr + $pendingInterest);
        }
        else
        {
            $tintr = 0;
        }
        if(($loan_ac_by_holder->amount - $received_pr) > 0)
        {
            $loan_tntr[] = $tintr;
            $loan_date[] = $fdate;
            $loan_amount[] = ($_over_amount + $_amount);
        }

        $loan_page_total += ($_over_amount + $_amount);
        $loan_intr_page_total += $tintr;
        $loan_grand_total = (($_over_amount + $_amount) + $loan_grand_total);
        $loan_intr_grand_total = ($tintr + $loan_intr_grand_total);
        $_over_amount = 0;
        $_amount = 0;
        $tintr = 0;
     }

                                   $trec++;

                                ?>
                                <?php if($share_balance != 0): ?>
                                <?php
                                    $srn++;
                                    $rec++;
                                    if(count($loan_amount) > 1)
                                    {
                                        $srn = (($srn + count($loan_amount)) - 1);
                                    }
                                    $id = $val->id;
                                ?>
                                <?php if(count($ac_holders) > 32): ?>
                                    <?php if($rec == 1): ?>
                                    <tr>
                                        <td colspan="3"><strong>Previous Total </strong></td>
                                        <td class="align_right"><strong><?php echo e(number_format(0,2,'.','')); ?></strong></td>
                                        <td class="align_right"><strong><?php echo e(number_format(0,2,'.','')); ?></strong></td>
                                        <td></td>
                                        <td class="align_right"><strong><?php echo e(number_format(0,2,'.','')); ?></strong></td>
                                        <td class="align_right"><strong><?php echo e(number_format(0,2,'.','')); ?></strong></td>
                                        
                                    </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <tr>
                                    <td><?php echo e($rec); ?></td>

                                    <td><?php echo e(str_limit(trim($val->full_name),13)); ?></td>
                                    <td><?php echo e($val->account_no); ?></td>
                                    <td class="align_right"><?php echo e(number_format($share_balance,2,'.','')); ?></td>
                                    <td class="align_right">
                                        <?php $__currentLoopData = $loan_amount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($val); ?>

                                        <br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td class="align_right">
                                        <?php $__currentLoopData = $loan_date; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e(date('d-M-Y',strtotime($val))); ?>

                                        <br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td class="align_right">
                                        <?php $__currentLoopData = $loan_tntr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($val); ?>

                                        <br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td class="align_right"><?php echo e(number_format($saving_balance,2,'.','')); ?></td>
                                    
                                </tr>
                                <?php endif; ?>
                                <?php if($srn == 32): ?>
                                    <tr>
                                        <td colspan="3"><strong>Page Total</strong></td>
                                        <td class="align_right"><strong><?php echo e(number_format($share_page_total,2,'.','')); ?></strong></td>
                                        <td class="align_right"><strong><?php echo e(number_format($loan_page_total,2,'.','')); ?></strong></td>
                                        <td></td>
                                        <td class="align_right"><strong><?php echo e(number_format($loan_intr_page_total,2,'.','')); ?></strong></td>
                                        <td class="align_right"><strong><?php echo e(number_format($saving_page_total,2,'.','')); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Grand Total</strong></td>
                                        <td class="align_right"><strong><?php echo e(number_format($share_grand_total,2,'.','')); ?></strong></td>
                                         <td class="align_right"><strong><?php echo e(number_format($loan_grand_total,2,'.','')); ?></strong></td>
                                        <td></td>
                                        <td class="align_right"><strong><?php echo e(number_format($loan_intr_grand_total,2,'.','')); ?></strong></td>
                                        <td class="align_right"><strong><?php echo e(number_format($saving_grand_total,2,'.','')); ?></strong></td>
                                    </tr>
                                    <?php if(count($ac_holders) > $trec): ?>
                                        <tr>
                                            <td colspan="3"><strong>Previous Total</strong></td>
                                            <td class="align_right"><strong><?php echo e(number_format($share_grand_total,2,'.','')); ?></strong></td>
                                            <td class="align_right"><strong><?php echo e(number_format($loan_grand_total,2,'.','')); ?></strong></td>
                                            <td></td>
                                            <td class="align_right"><strong><?php echo e(number_format($loan_intr_grand_total,2,'.','')); ?></strong></td>
                                            <td class="align_right"><strong><?php echo e(number_format($saving_grand_total,2,'.','')); ?></strong></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php
                                $share_page_total = 0;
                                $saving_page_total = 0;
                                $loan_page_total = 0;
                                $loan_intr_page_total = 0;

                                $srn = 0; ?>
                                <?php else: ?>
                                    <?php if(count($ac_holders) == $trec): ?>
                                    <tr>
                                    <td colspan="3"><strong>Page Total</strong></td>
                                    <td class="align_right"><strong><?php echo e(number_format($share_page_total,2,'.','')); ?></strong></td>
                                    <td class="align_right"><strong><?php echo e(number_format($loan_page_total,2,'.','')); ?></strong></td>
                                    <td></td>
                                    <td class="align_right"><strong><?php echo e(number_format($loan_intr_page_total,2,'.','')); ?></strong></td>
                                    <td class="align_right"><strong><?php echo e(number_format($saving_page_total,2,'.','')); ?></strong></td>
                                    </tr>
                                    <tr>
                                    <td colspan="3"><strong>Grand Total</strong></td>
                                    <td class="align_right"><strong><?php echo e(number_format($share_grand_total,2,'.','')); ?></strong></td>
                                    <td class="align_right"><strong><?php echo e(number_format($loan_grand_total,2,'.','')); ?></strong></td>
                                    <td></td>
                                    <td class="align_right"><strong><?php echo e(number_format($loan_intr_grand_total,2,'.','')); ?></strong></td>
                                    <td class="align_right"><strong><?php echo e(number_format($saving_grand_total,2,'.','')); ?></strong></td>
                                    </tr>

                                    <?php endif; ?>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/BalancePageTotal/balance-book.blade.php ENDPATH**/ ?>