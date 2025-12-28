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
            <h1>NPA</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(HOME_LINK); ?>">
                        <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                    </a>
                </li>
                <li class="active">NPA</li>
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
                                <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> NPA List
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" action="<?php echo e(D_BALANCE_REPORT_URL_NPA); ?>" method="get">
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
                                    <div class="form-group">
                                        <label class="radio-inline">
                                            <input type="radio" class="custom-radio" name="RadioDate" id="optionsRadiosInline1" value="1" checked <?php echo e(request()->get('RadioDate') == 1 ? 'checked' : ''); ?>>
                                        From Advancement Date</label>
                                        <label class="radio-inline">
                                            <input type="radio" class="custom-radio" name="RadioDate" id="optionsRadiosInline2" value="2"  <?php echo e(request()->get('RadioDate') == 2 ? 'checked' : ''); ?>>
                                        From Due Date</label>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-md-4 control-label" for="email"></label>
                                        <div class="col-md-8">
                                            <input type="checkbox" name="npa" class="mt-10" <?php echo e(request()->npa == TRUE ? 'checked' : ''); ?>> NPA Interest@100%
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
                                            <td colspan="15">
                                                <div class="col-md-12 text-center">
                                                    <h3>
                                                        <?php echo e($company_address->name); ?>

                                                    </h3>
                                                    <?php echo e($company_address->address); ?>

                                                    <h4>
                                                        <?php
                                                            $ZFTOTAL = 0;
                                                            $FTTOTAL = 0;
                                                            $TFTOTAL = 0;
                                                            $FSTOTAL = 0;
                                                            $ASOTAL = 0;
                                                            $NPA_TOTAL = 0;
                                                            $INT_TOTAL = 0;
                                                            $NPA_INT_TOTAL = 0;

                                                        ?>
                                                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($val->id == $member_type): ?>
                                                                <?php echo e($val->name); ?>

                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        NPA Report As On <?php echo e(date('d-M-Y',strtotime($from_date))); ?>

                                                    </h4>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>A/C No.</th>
                                            <th>Loan Date</th>
                                            <th>Due Date</th>
                                            <th>0-1 Yr</th>
                                            <th>1-3 Yr</th>
                                            <th>3-4 Yr</th>
                                            <th>4-6 Yr</th>
                                            <th>Above 6 Yr</th>
                                            <th>NPA %</th>
                                            <th>NPA Amount</th>
                                            <th>Interest</th>
                                            <th>NPA %</th>
                                            <th>NPA Intr</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i = 1;
                                            $total_of_balance = 0;
                                            $total_recover_int = 0;
                                        ?>
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                               //
                                               $tbl_loan_return_model_days = \App\tbl_loan_return_model::select('id','loan_ac_model_id','received_date','pending_intr')
                                            ->orderBy('received_date','desc')
                                            ->where('loan_ac_model_id',$item->id)
                                            ->where('received_date','<=',$from_date)
                                            ->first();

                                            if($tbl_loan_return_model_days)
                                            {
                                                $_rdate = $tbl_loan_return_model_days->received_date;
                                                $pendingInterest =  $tbl_loan_return_model_days->pending_intr;
                                            }
                                            else
                                            {
                                                $_rdate = $item->date_of_advance;
                                                $pendingInterest = 0;
                                            }

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

                                                        // Get years between two dates for NPA Column
                                                        if (request()->get('RadioDate') == 1)
                                                            {
                                                                $npaDuaDate = new DateTime(date('Y-m-d',strtotime($item->date_of_advance )));
                                                            }
                                                        else{
                                                            $npaDuaDate = new DateTime(date('Y-m-d',strtotime($item->date_of_advance . "+".$item->months." months")));
                                                        }
                                                        $npaAsOnDate = new DateTime(date('Y-m-d',strtotime($from_date)));
                                                        $npaDiff = $npaAsOnDate->diff( $npaDuaDate );
                                                        $npaYRy =  $npaDiff->y;
                                                        $npaYRm =  $npaDiff->m;
                                                        if($npaAsOnDate>$npaDuaDate)
                                                        {
                                                        $npaYR =  (($npaYRy *12) + $npaYRm)/12;
                                                        }
                                                        else{
                                                        $npaYR =0;
                                                        }
                                                        $npaAmount = ($item->amount -  $tbl_loan_return_model_sum->total_received_principal);
                                                        $NPAPPR = 0;
                                                        $NPAPINTR = 0;
                                                    ?>


                                                    <tr>
                                                        <td><?php echo e($i++); ?> <?php echo e($tbl_loan_return_model_sum->principal); ?></td>
                                                        <td><?php echo e(str_limit(trim(@$item->open_new_ac_model->full_name),13)); ?></td>
                                                        <td><?php echo e($item->account_no); ?></td>
                                                        <td class="align_right"><?php echo e(date('d/m/Y',strtotime($item->date_of_advance))); ?></td>
                                                        <td class="align_right"><?php echo e(date('d/m/Y',strtotime($item->date_of_advance . "+".$item->months." months" ))); ?> </td>
                                                        <td class="text-right">
                                                            <?php if($npaYR <= 1): ?>
                                                                <?php
                                                                    $NPAPPR = 0;
                                                                    $NPAPINTR = 0;
                                                                    $ZFTOTAL += $npaAmount;
                                                                ?>
                                                                <?php echo e($npaAmount); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php if($npaYR > 1 && $npaYR <= 3): ?>
                                                                <?php
                                                                    $NPAPPR = 5;
                                                                    $NPAPINTR = 5;
                                                                    $FTTOTAL += $npaAmount;
                                                                ?>
                                                                <?php echo e($npaAmount); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php if($npaYR > 3 && $npaYR <= 4): ?>
                                                                <?php
                                                                    $NPAPPR = 10;
                                                                    $NPAPINTR = 10;
                                                                    $TFTOTAL += $npaAmount;
                                                                ?>
                                                                <?php echo e($npaAmount); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php if($npaYR > 4 && $npaYR <= 6): ?>
                                                                <?php
                                                                    $NPAPPR = 15;
                                                                    $NPAPINTR = 15;
                                                                    $FSTOTAL += $npaAmount;
                                                                ?>
                                                                <?php echo e($npaAmount); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php if($npaYR > 6): ?>
                                                                <?php
                                                                    $NPAPPR = 50;
                                                                    $NPAPINTR = 50;
                                                                    $ASOTAL += $npaAmount;
                                                                ?>
                                                                <?php echo e($npaAmount); ?>

                                                            <?php endif; ?>

                                                        </td>
                                                        <?php
                                                            if(request()->npa == TRUE)
                                                            {
                                                                if($npaYR <= 1)
                                                                {
                                                                    $NPAPINTR = 0;
                                                                }
                                                                else{
                                                                    $NPAPINTR = 100;
                                                                }
                                                            }
                                                        ?>
                                                        <td class="text-right"><?php echo e($NPAPPR); ?></td>
                                                        <td class="text-right"><?php echo e(round(($npaAmount * $NPAPPR) / 100)); ?></td>
                                                        <td class="text-right"> <?php echo e($tintr + $pendingInterest); ?></td>
                                                        <td class="text-right"><?php echo e($NPAPINTR); ?></td>
                                                        <td class="text-right"><?php echo e(round((($tintr + $pendingInterest) * $NPAPINTR) / 100)); ?></td>

                                                    </tr>
                                                    <?php
                                                        $NPA_TOTAL += round(($npaAmount * $NPAPPR) / 100);
                                                        $INT_TOTAL += ($tintr + $pendingInterest);
                                                        $NPA_INT_TOTAL += round((($tintr + $pendingInterest) * $NPAPINTR) / 100);
                                                    ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><strong><?php echo e($ZFTOTAL); ?></strong></td>
                                            <td class="text-right"><strong><?php echo e($FTTOTAL); ?></strong></td>
                                            <td class="text-right"><strong><?php echo e($TFTOTAL); ?></strong></td>
                                            <td class="text-right"><strong><?php echo e($FSTOTAL); ?></strong></td>
                                            <td class="text-right"><strong><?php echo e($ASOTAL); ?></strong></td>
                                            <td></td>
                                            <td class="text-right"><strong><?php echo e($NPA_TOTAL); ?></strong></td>
                                            <td class="text-right"><strong><?php echo e($INT_TOTAL); ?></strong></td>
                                            <td></td>
                                            <td class="text-right"><strong><?php echo e($NPA_INT_TOTAL); ?></strong></td>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbatran/resources/views/Balance//npa.blade.php ENDPATH**/ ?>