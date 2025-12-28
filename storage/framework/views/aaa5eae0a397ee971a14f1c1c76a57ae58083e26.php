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
        .mytable_css >tbody>tr>th {
            height:auto;
            padding:1px 2px;
            border-top: 0px;
            line-height: 1.20 !important;
        }
        .mytable_css >tbody>tr>td {
            height:auto;
            padding:1px 2px;
            border-top: 0px;
            line-height: 1.20 !important;
        }
        .mytable_css >thead>tr>th{
            border-bottom: 1px solid #ccc !important;
            padding: 1px 2px !important;
            line-height: 1.20 !important;
        }
        .text-right{
            text-align: right !important;
        }
        .border-left-0{
            border-left: 0px !important;
        }
        .border-right-0{
            border-right: 0px !important;
        }
        @media  print {
            .border-left-0{
                border-left: 0px !important;
            }
            .printme, .printme * {
                visibility: visible;
            }
            .printme {
                position: absolute;
                left: 0;
                top: 0;
            }
            .printme, .printme:last-child {
                page-break-after: avoid;
            }

            .display-none-on, .display-none-on * {
                display: none !important;
            }
            html, body {
                height: auto;
                font-size: 7pt; /* changing to 10pt has no impact */
            }
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
<?php
    $ownedCapital = 0;
    $borrowedCapital = 0;
    $loan = 0;
?>
    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side strech">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!--section starts-->
            <h1>Society Status Report</h1>
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
                                <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Society Status Report
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-horizontal" action="<?php echo e(route('additional.report.society.status')); ?>" method="get">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="col-md-2">
                                            <span>Financial Year</span>
                                            <select name="financial_year" class="form-control" required>
                                                <option value="">--- Select ---</option>
                                                <?php $__currentLoopData = $session_years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($list->id); ?>" <?php echo e(request()->financial_year == $list->id ? 'selected' : ''); ?>><?php echo e(date('Y', strtotime($list->start_date))); ?> - <?php echo e(date('Y', strtotime($list->end_date))); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <span>As On</span>
                                            <input type="date" class="form-control" value="<?php echo e(request()->date ? request()->date : date('Y-m-d')); ?>" name="date" placeholder="Check-In Date">
                                        </div>
                                        <div class="col-md-2">
                                            <span>Branch</span>
                                            <select name="branch" class="form-control">
                                                <option value="">All</option>
                                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->id); ?>" <?php echo e(request()->branch == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>


                                        <!-- <a href="<?php echo e(AUDIT_REPORT_URL_BALANCE_SHEET.'pdf/'.request()->date.'/'.request()->financial_year.'/'.request()->branch); ?>" class="btn btn-danger btn_sizes"><i class="fa fa-fw fa-print"></i> PDF</a> -->


                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Print view                         -->
                            <div class="prnt print printme" id="record">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h3>
                                            <?php echo e($company_address->name ?? '---'); ?>

                                        </h3>
                                        <h5>
                                            <?php echo e($company_address->address); ?>

                                        </h5>
                                        <h4>
                                            Society Status Report As On <?php echo e(date('d-M-Y',strtotime(request()->date))); ?>

                                        </h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <!-- BEGIN:: Owned Capital Table -->
                                        <div class="table-scrollable">
                                            <?php
                                                $Total = 0;
                                                $AssetTotal = 0;
                                            ?>
                                            <table width="100%" class="table table-bordered table-hover mytable_css">
                                                <thead>
                                                <tr>
                                                    <th width="60%">Particular</th>
                                                    <th width="20%"></th>
                                                    <th width="20%">Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $tblLedgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($list->bal_sheet_head_model->name == 'OWNED CAPITAL'): ?>
                                                        <?php
                                                            $balHeadTotalCr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
                                                            ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
                                                            ->whereNotNull('bal_sheet_head_model_id')
                                                            ->where('type_of_transaction','Cr')
                                                            ->where('date_of_transaction','<=',request()->date)
                                                            ->sum('amount');

                                                            $balHeadTotalDr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
                                                                ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
                                                                ->whereNotNull('bal_sheet_head_model_id')
                                                                ->where('type_of_transaction','Dr')
                                                                ->where('date_of_transaction','<=',request()->date)
                                                                ->sum('amount');
                                                            $balHeadAmt =  $balHeadTotalCr - $balHeadTotalDr;
                                                            $ownedCapital = ($balHeadAmt + $lastYrProfit + $yearEndTblData->net_profit);


                                                        ?>
                                                        <?php if($balHeadAmt > 0): ?>
                                                            <tr>
                                                                <th><?php echo e(@$list->bal_sheet_head_model->name); ?></th>
                                                                <th></th>
                                                                <th class="text-right"><?php echo e(number_format($ownedCapital,2)); ?></th>
                                                            </tr>
                                                            <?php
                                                                $Total += $balHeadAmt;
                                                                    $mainHeadGroup = App\tbl_ledger_model::select('id','main_head','bal_sheet_head_model_id')
                                                                    ->where('bal_sheet_head_model_id',$list->bal_sheet_head_model_id)
                                                                    ->groupBy('main_head')
                                                                    ->where('date_of_transaction','<=',request()->date)
                                                                    ->get();
                                                            ?>
                                                            <?php $__currentLoopData = $mainHeadGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $tblLedgersCr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                                                                    ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
                                                                    ->where('date_of_transaction','<=',request()->date)
                                                                    ->where('main_head',$groupName->main_head)
                                                                    ->where('type_of_transaction','Cr')
                                                                    ->sum('amount');

                                                                    $tblLedgersDr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                                                                        ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
                                                                        ->where('date_of_transaction','<=',request()->date)
                                                                        ->where('main_head',$groupName->main_head)
                                                                        ->where('type_of_transaction','Dr')
                                                                        ->sum('amount');
                                                                    $Amt =  $tblLedgersCr - $tblLedgersDr;
                                                                ?>
                                                                <?php if($Amt): ?>
                                                                    <tr>
                                                                        <td><?php echo e($groupName->main_head); ?></td>
                                                                        <td class="text-right"><?php echo e(number_format($Amt,2)); ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                <?php endif; ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($lastYrProfit): ?>
                                                                <tr>
                                                                    <td>LAST YEAR PROFIT</td>
                                                                    <td class="text-right"><?php echo e(number_format(@$lastYrProfit,2)); ?></td>
                                                                    <td></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                            <?php if($yearEndTblData->net_profit): ?>
                                                                <tr>
                                                                    <td>CURRENT YEAR PROFIT</td>
                                                                    <td class="text-right"><?php echo e(number_format(@$yearEndTblData->net_profit,2)); ?></td>
                                                                    <td></td>
                                                                </tr>
                                                            <?php endif; ?>

                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- END:: Owned Capital Table -->

                                        <!-- BEGIN:: Borrowed Capital Table -->
                                        <div class="table-scrollable">
                                            <?php
                                                $Total = 0;
                                                $AssetTotal = 0;
                                            ?>
                                            <table width="100%" class="table table-bordered table-hover mytable_css">
                                                <thead>
                                                <tr>
                                                    <th width="60%">Particular</th>
                                                    <th width="20%"></th>
                                                    <th width="20%">Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $tblLedgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($list->bal_sheet_head_model->name == 'BORROWED CAPITAL'): ?>
                                                        <?php
                                                            $balHeadTotalCr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
                                                            ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
                                                            ->whereNotNull('bal_sheet_head_model_id')
                                                            ->where('type_of_transaction','Cr')
                                                            ->where('date_of_transaction','<=',request()->date)
                                                            ->sum('amount');

                                                            $balHeadTotalDr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
                                                                ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
                                                                ->whereNotNull('bal_sheet_head_model_id')
                                                                ->where('type_of_transaction','Dr')
                                                                ->where('date_of_transaction','<=',request()->date)
                                                                ->sum('amount');
                                                            $balHeadAmt =  $balHeadTotalCr - $balHeadTotalDr;
                                                            $borrowedCapital = $balHeadAmt;
                                                            $mbl = ($ownedCapital * 12);
                                                            if ($balHeadAmt > $mbl){ $bgColor = 'bg-danger'; } else{ $bgColor = 'bg-success'; }


                                                        ?>
                                                        <?php if($balHeadAmt > 0): ?>
                                                            <tr class="<?php echo e($bgColor); ?>">
                                                                <th><?php echo e(@$list->bal_sheet_head_model->name); ?></th>
                                                                <th></th>
                                                                <th class="text-right"><?php echo e(number_format($balHeadAmt,2)); ?></th>
                                                            </tr>
                                                            <?php
                                                                $Total += $balHeadAmt;
                                                                    $mainHeadGroup = App\tbl_ledger_model::select('id','main_head','bal_sheet_head_model_id')
                                                                    ->where('bal_sheet_head_model_id',$list->bal_sheet_head_model_id)
                                                                    ->whereIn('main_head',[
                                                                        'MEMBER SAVING',
                                                                        'NOMINAL MEMBER SAVING',
                                                                        'MEMBER FIXED DEPOSIT',
                                                                        'NOMINAL MEMBER FIXED DEPOSIT',
                                                                        'MEMBER RD',
                                                                        'NOMINAL MEMBER RD',
                                                                        'MEMBER MIS',
                                                                        'NOMINAL MEMBER MIS'])
                                                                    ->groupBy('main_head')
                                                                    ->where('date_of_transaction','<=',request()->date)
                                                                    ->get();

                                                            ?>
                                                            <?php $__currentLoopData = $mainHeadGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $tblLedgersCr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                                                                    ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
                                                                    ->where('date_of_transaction','<=',request()->date)
                                                                    ->where('main_head',$groupName->main_head)
                                                                    ->where('type_of_transaction','Cr')
                                                                    ->sum('amount');

                                                                    $tblLedgersDr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                                                                        ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
                                                                        ->where('date_of_transaction','<=',request()->date)
                                                                        ->where('main_head',$groupName->main_head)
                                                                        ->where('type_of_transaction','Dr')
                                                                        ->sum('amount');
                                                                    $Amt =  $tblLedgersCr - $tblLedgersDr;
                                                                ?>
                                                                <?php if($Amt): ?>
                                                                    <tr>
                                                                        <td><?php echo e($groupName->main_head); ?></td>
                                                                        <td class="text-right"><?php echo e(number_format($Amt,2)); ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                <?php endif; ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- END:: Borrowed Capital Table -->

                                        <!-- BEGIN:: LOAN & Advances Table -->
                                        <div class="table-scrollable">
                                            <?php
                                                $Total = 0;
                                                $AssetTotal = 0;
                                            ?>
                                            <table width="100%"  class="table table-bordered table-hover mytable_css">
                                                <thead>
                                                <tr>
                                                    <th width="60%">PARTICULAR</th>
                                                    <th width="20%">&nbsp;</th>
                                                    <th width="20%" class="text-right">AMOUNT ( <i class="fa fa-inr"></i> )</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $tblLedgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($list->bal_sheet_head_model->name == 'INVESTMENTS' || $list->bal_sheet_head_model->name == 'LOAN & ADVANCE'): ?>
                                                        <?php
                                                            $balHeadTotalCr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
                                                            ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
                                                            ->whereNotNull('bal_sheet_head_model_id')
                                                            ->where('bal_sheet_head_model_id','!=',0)
                                                            ->whereIn('main_head',[
                                                                    'MEMBER LOAN M.T. LOAN',
                                                                    'MEMBER LOAN LOAN AGAINST FD',
                                                                    'MEMBER LOAN KCC LOAN'])
                                                            ->where('type_of_transaction','Cr')
                                                            ->where('date_of_transaction','<=',request()->date)
                                                            ->sum('amount');

                                                            $balHeadTotalDr = App\tbl_ledger_model::select('amount','bal_sheet_head_model_id')
                                                                ->where('bal_sheet_head_model_id',@$list->bal_sheet_head_model_id)
                                                                ->whereNotNull('bal_sheet_head_model_id')
                                                                ->where('bal_sheet_head_model_id','!=',0)
                                                                ->whereIn('main_head',[
                                                                    'MEMBER LOAN M.T. LOAN',
                                                                    'MEMBER LOAN LOAN AGAINST FD',
                                                                    'MEMBER LOAN KCC LOAN'])
                                                                ->where('type_of_transaction','Dr')
                                                                ->where('date_of_transaction','<=',request()->date)
                                                                ->sum('amount');
                                                            $balHeadAmt =  $balHeadTotalCr - $balHeadTotalDr;
                                                             $loan = $balHeadAmt;

                                                            $ml = (($borrowedCapital * 40) / 100);
                                                            if ($balHeadAmt > $ml){ $bgColor = 'bg-danger'; } else{ $bgColor = 'bg-success'; }
                                                        ?>
                                                        <?php if($balHeadAmt < 0): ?>
                                                            <?php
                                                                $AssetTotal += ($balHeadAmt * -1);
                                                            ?>
                                                            <tr class="<?php echo e($bgColor); ?>">
                                                                <th><?php echo e(@$list->bal_sheet_head_model->name); ?></th>
                                                                <th></th>
                                                                <th class="text-right"><?php echo e(number_format($balHeadAmt * -1 ,2)); ?></th>
                                                            </tr>
                                                            <?php
                                                                $mainHeadGroup = App\tbl_ledger_model::select('id','main_head','bal_sheet_head_model_id')
                                                                ->where('bal_sheet_head_model_id',$list->bal_sheet_head_model_id)
                                                                ->whereIn('main_head',[
                                                                    'MEMBER LOAN M.T. LOAN',
                                                                    'MEMBER LOAN LOAN AGAINST FD',
                                                                    'MEMBER LOAN KCC LOAN'])
                                                                ->groupBy('main_head')
                                                                ->where('date_of_transaction','<=',request()->date)
                                                                ->get();
                                                            ?>
                                                            <?php $__currentLoopData = $mainHeadGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $tblLedgersCr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                                                                    ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
                                                                    ->where('date_of_transaction','<=',request()->date)
                                                                    ->where('main_head',$groupName->main_head)
                                                                    ->where('type_of_transaction','Cr')
                                                                    ->sum('amount');

                                                                    $tblLedgersDr = App\tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                                                                        ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])
                                                                        ->where('date_of_transaction','<=',request()->date)
                                                                        ->where('main_head',$groupName->main_head)
                                                                        ->where('type_of_transaction','Dr')
                                                                        ->sum('amount');
                                                                    $Amt =  $tblLedgersCr - $tblLedgersDr;
                                                                ?>
                                                                <?php if($Amt): ?>
                                                                    <tr>
                                                                        <td><?php echo e($groupName->main_head); ?></td>
                                                                        <td class="text-right"><?php echo e(number_format($Amt * -1,2)); ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                            <?php
                                            $bbl = (($ownedCapital * 12) - $borrowedCapital);
                                            $bll = (($borrowedCapital * 40) / 100) - ($loan * -1);
                                            if ($bbl > 0){ $color = 'text-success'; } else { $color = 'text-danger'; }
                                            if ($bll > 0){ $bllColor = 'text-success'; } else { $bllColor = 'text-danger'; }

                                            ?>
                                            <p>Owned Capital = <?php echo e(round($ownedCapital)); ?></p>
                                            <p>Borrowed Capital = <?php echo e(round($borrowedCapital)); ?></p>
                                            <p>Loan = <?php echo e(round($loan * -1)); ?></p>
                                            <p>Maximum borrowing limit (Owned Capital x 12) = <?php echo e(round($ownedCapital * 12)); ?></p>
                                            <p class="<?php echo e($color); ?>">Balance borrowing limit = <?php echo e(round($bbl)); ?></p>
                                            <p>Maximum loan limit (40% of Borrowed Capital) = <?php echo e(round(($borrowedCapital * 40) / 100)); ?></p>
                                            <p class="<?php echo e($bllColor); ?>">Balance loan limit = <?php echo e(round($bll)); ?></p>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/Additional/society-status-report.blade.php ENDPATH**/ ?>