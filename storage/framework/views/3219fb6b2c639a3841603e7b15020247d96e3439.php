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
        <h1>Interest on Saving</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Interest on Saving</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Interest on Saving
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="<?php echo e(INTEREST_ON_SAVING_URL); ?>" method="get">
                    <div class="row">
                    <div class="col-md-12">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Session Year</label>
                            <div class="col-md-6">
                                <select name="session_year" class="form-control" required>
                                    <option value="">--- Select ---</option>
                                    <?php $__currentLoopData = $session_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e($list->id == $session_year ? 'selected' : ''); ?> <?php echo e($list->id == @$_REQUEST['session_year'] ? 'selected' : ''); ?>><?php echo e(date('Y',strtotime($list->start_date))); ?> - <?php echo e(date('Y',strtotime($list->end_date))); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">From</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" value="<?php echo e(date('Y-m-d',strtotime($share_as_on))); ?>" name="share_as_on" placeholder="From">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">To</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" value="<?php echo e(date('Y-m-d',strtotime($paid_on))); ?>" name="paid_on" placeholder="To">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Member type</label>
                            <div class="col-md-6">
                                <select name="member_type" class="form-control">
                                    <option value="">--- All ---</option>
                                    <?php $__currentLoopData = $memberLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e($member_type == $list->id ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                </select>
                            </div>
                        </div>
                    
                    
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Interest @</label>
                            <div class="col-md-6">
                                <input name="dividend_at" type="text" class="form-control" placeholder="@" value="<?php echo e(old('dividend_at',$dividend_at)); ?>" onkeypress="return isNumAndDecimalKey(event)" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Minimum Amount</label>
                            <div class="col-md-6">
                                <input name="minimum_share" type="text" class="form-control" onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e(old('minimum_share',$minimum_share)); ?>" required>
                            </div>
                        </div>                        
                        <div class="col-md-4 text-center">
                            <button type="submit" name="view" value="1" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>
                            <?php if(isset($_REQUEST['_token'])): ?>
                              <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                           
                              <?php else: ?>
                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if(session()->has('errors')): ?>
					  <div class="alert alert-danger">
                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <?php echo e(session()->get('errors')); ?>

                                    </div>
                                <?php endif; ?>
                    <?php if(session()->has('success')): ?>
					  <div class="alert alert-info">
                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <?php echo e(session()->get('success')); ?>

                                    </div>
                                <?php endif; ?>
                    </div>
                    </div>
                    </form> 
                    <div id="paginate">
                    <?php if(isset($_REQUEST['_token'])): ?>
                    <?php echo e(@($_REQUEST['view'])?$ac_holders->appends(['_token' => $_REQUEST['_token'],'session_year' => $_REQUEST['session_year'],'share_as_on' => $_REQUEST['share_as_on'],'paid_on' => $_REQUEST['paid_on'],'member_type' => $_REQUEST['member_type'],'dividend_at' => $_REQUEST['dividend_at'],'minimum_share' => $_REQUEST['minimum_share'],'view' => $_REQUEST['view']])->render():''); ?>

                    <?php endif; ?>  
                    </div> 
                    <form class="form-horizontal" action="<?php echo e(INTEREST_ON_SAVING_URL); ?>" method="post">
                        
                    
                        <div class="row">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="share_on" value="<?php echo e($share_as_on); ?>">
                        <input type="hidden" name="paid_on" value="<?php echo e($paid_on); ?>">
                        <input type="hidden" name="dividend_at" value="<?php echo e($dividend_at); ?>">
                        <input type="hidden" name="session_year" value="<?php echo e(@$_REQUEST['session_year']); ?>">
                        
                       
                        <div class="col-md-6 col-md-offset-3">
                            <br>
                            <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                       
                    </div>                   
                        
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        <div class="prnt" id="record">
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="9">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                <?php echo e($company_address->name); ?>

                                            </h3>
                                                <?php echo e($company_address->address); ?>

                                            <h4>
                                                Interest Paid On <?php echo e($member_type); ?> From <strong><?php echo e(date('d-M-Y',strtotime($share_as_on))); ?></strong> To <strong> <?php echo e(date('d-M-Y',strtotime($paid_on))); ?></strong>
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>                                    
                                    <th>Opening</th>
                                    <th>Deposit</th>
                                    <th>Withdraw</th>
                                    <th>Balance</th>
                                    <th>Interest @</th>
                                    <th>Interest</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sr = 0; 
                                $t1 = 0;    
                                $t2 = 0;    
                                $t3 = 0;    
                                $t4 = 0;    
                                $t5 = 0;    
                                
                                $tdiv = 0;    
                                $dt = $share_as_on;
                                $amt = 0;
                                $cint = 0;
                                $taintr = 0;
                                ?>
                                <?php $__currentLoopData = $ac_holders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $taintr = 0;
        
                               $deposit = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<',$share_as_on)->sum('amount');

                               $withdraw = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<',$share_as_on)->sum('amount');

                               $deposit_trans = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','>=',$share_as_on)->where('date_of_transaction','<=',$paid_on)->sum('amount');

                               $withdraw_trans = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','>=',$share_as_on)->where('date_of_transaction','<=',$paid_on)->sum('amount');

                                $opening_balance = ($deposit - $withdraw);
                                $amt = $opening_balance;
                                $balance = ($opening_balance + ($deposit_trans - $withdraw_trans));

                                $savingTrans = \App\saving_ac_model::where('open_new_ac_model_id',$val->id)->where('date_of_transaction','>=',$share_as_on)->where('date_of_transaction','<=',$paid_on)->orderBy('date_of_transaction','asc')->get();

                               
                                 if($balance >= $minimum_share)
                                 {
                                    $tdiv = round(($balance * $dividend_at) / 100);
                                 }
                                 else
                                 {
                                    $tdiv = 0;    
                                 }

                                 $fdate = date('Y-m-d',strtotime('-1 day',strtotime($dt)));
                                ?>
                                
                                    <?php $__currentLoopData = $savingTrans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $savingTransData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $fdate=$fdate;
                                            $tdate=date('Y-m-d',strtotime($savingTransData->date_of_transaction));

                                            $to = \Carbon\Carbon::createFromFormat('Y-m-d', $fdate);
                                            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $tdate);
                                            $diff_in_days = $from->diffInDays($to);
                                            
                                            if($amt >= $minimum_share)
                                            {
                                                $cint = ($amt * $dividend_at * $diff_in_days) / 36500;
                                            }
                                            else
                                            {
                                                $cint = 0; 
                                            }

                                            $fdate = $savingTransData->date_of_transaction;

                                            $taintr += $cint;

                                            if($savingTransData->type_of_transaction == 'Deposit')
                                            {
                                                $amt = $amt + $savingTransData->amount;
                                            }
                                            else if($savingTransData->type_of_transaction == 'Withdrawal')
                                            {
                                                $amt = $amt - $savingTransData->amount;
                                            }

                                            

                                        ?>
                                       
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  
                                  <?php         
                                     
                                  $to = \Carbon\Carbon::createFromFormat('Y-m-d', $fdate);
                                            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $paid_on);
                                            $diff_in_days = $from->diffInDays($to);
                                            
                                            if($amt >= $minimum_share)
                                            {
                                                $cint = ($amt * $dividend_at * $diff_in_days) / 36500;
                                            }
                                            else
                                            {
                                                $cint = 0; 
                                            }
                                            
                                            $taintr += $cint;
                                            ?>

                               <?php if($opening_balance <> 0 || $deposit_trans <> 0 || $withdraw_trans <> 0): ?>
                                <?php 
                                    $sr++; 
                                    $t1 += $opening_balance;
                                    $t2 += $deposit_trans;
                                    $t3 += $withdraw_trans;
                                    $t4 += $balance;
                                    $t5 += round($taintr);
                                ?>
                                <tr>
                                    <td><?php echo e($sr); ?></td>
                                    <td><?php echo e($val->full_name); ?></td>
                                    <td><?php echo e($val->account_no); ?></td>                                    
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   <?php echo e(number_format($opening_balance,2)); ?>

                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   <?php echo e(number_format($deposit_trans,2)); ?>

                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   <?php echo e(number_format($withdraw_trans,2)); ?>

                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   <?php echo e(number_format($balance,2)); ?>

                                    </td>
                                    <td class="align_right"><?php echo e($dividend_at); ?>%</td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   <?php echo e(number_format(round($taintr),2)); ?>

                                        <input type="hidden" name="s_no_id[]" value="<?php echo e($sr+(@($_REQUEST['page'])?$_REQUEST['page'].'00':00)); ?>">
                                
                                        <input type="hidden" name="dividend_balance[]" value="<?php echo e(round($taintr)); ?>">
                                        <input type="hidden" name="balance[]" value="<?php echo e($balance); ?>">
                                        <input type="hidden" name="account_no[]" value="<?php echo e($val->account_no); ?>">
                                        <input type="hidden" name="account_id[]" value="<?php echo e($val->id); ?>">
                                        <input type="hidden" name="full_name[]" value="<?php echo e($val->full_name); ?>">
                                        <input type="hidden" name="branch[]" value="<?php echo e($val->branch_model_id); ?>">
                                        <input type="hidden" name="member_type[]" value="<?php echo e($val->member_type_model_id); ?>">
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="4"><strong>Total</strong></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t2,2)); ?></strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t3,2)); ?></strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t4,2)); ?></strong>
                                    </td>
                                    <td></td>
                                     <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t5,2)); ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                         
                    </div>
                  
                    <div class="col-md-6 col-md-offset-5 text-center" style="margin-bottom: 20px">
                            <button type="submit" class="mr-55 btn btn-primary btn_sizes
                            <?php if($dividend_at && $minimum_share): ?>
                            show
                            <?php else: ?>
                            hide
                            <?php endif; ?>
                            "> Update
                            </button>
                        </div> 
                    </div>
                </form>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Calculation/interest-on-saving.blade.php ENDPATH**/ ?>