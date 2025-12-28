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
          height:auto;
          padding:1px 2px;
          border-top: 0px;
          line-height: 1.20 !important;
        }
        #mytable_css >thead>tr>th{
            border-bottom: 0px solid #ccc !important;
            padding: 3px 5px !important;
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

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Trading A/C</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Trading A/C</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Trading A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="<?php echo e(AUDIT_REPORT_URL_TRADING_AC); ?>" method="get">
                        <?php echo e(csrf_field()); ?>

                        <div class="col-md-2">
                            <span class="text-dark">From</span>
                            <input type="date" class="form-control" value="<?php echo e($from_date ? $from_date : date('Y-m-d')); ?>" name="from_date" required>
                        </div>
                        <div class="col-md-2">
                            <span class="text-dark">To</span>
                            <input type="date" class="form-control" value="<?php echo e($to_date ? $to_date : date('Y-m-d')); ?>" name="to_date" required>
                        </div>
                        <div class="col-md-2">
                            <span class="text-dark">Financial Year</span>
                            <select name="financial_year" class="form-control" required>
                                <option value="">--- Select ---</option>
                                <?php $__currentLoopData = $session_years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($list->id); ?>" <?php echo e($financial_year == $list->id ? 'selected' : ''); ?>><?php echo e(date('Y', strtotime($list->start_date))); ?> - <?php echo e(date('Y', strtotime($list->end_date))); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span class="text-dark">Branch</span>
                            <select name="branch" class="form-control">
                                <option value="">All</option>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val->id); ?>" <?php echo e(@$branch == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>
                        </div>
                        <div class="col-md-2">
                            <!-- <a href="<?php echo e(url()->full()); ?>&p=1">print</a> -->
                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </form>
                    </div>
                    </div>
                    <div class="prnt print printme" id="record">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>
                                <?php echo e($company_address->name); ?>

                            </h3>
                            <h5>
                                <?php echo e($company_address->address); ?>

                            </h5>
                            <h4>
                                Trading Account From <?php echo e(date('d-M-Y',strtotime($from_date))); ?> To <?php echo e(date('d-M-Y',strtotime($to_date))); ?>

                            </h4>
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <!-- Print view                         -->


                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2" width="50%">CREDIT</th>
                                    <th scope="col" colspan="2">DEBIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICUALR</th>
                                                    <th class="text-right">AMOUNT</th>
                                                </tr>
<?php
$gl = 0;
$gp = 0;
?>

                                                <?php $__currentLoopData = $crTblLedgers->where('gtype','SALES ACCOUNT'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $drList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');

                                                ?>
                                                <tr>
                                                    <td><?php echo e($drList->main_head); ?></td>
                                                    <td class="text-right"><?php echo e(number_format($mHeadAmt,2,'.','')); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $crTblLedgers->where('gtype','DIRECT INCOME'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $drList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');

                                                ?>
                                                <tr>
                                                    <td><?php echo e($drList->main_head); ?></td>
                                                    <td class="text-right"><?php echo e(number_format($mHeadAmt,2,'.','')); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>CLOSING STOCK</td>
                                                    <td class="text-right"><?php echo e(number_format($closingStock,2,'.','')); ?></td>
                                                </tr>
                                                <?php if($drTotal > $crTotal): ?>
                                                <?php $gl = ($drTotal - $crTotal); ?>
                                                <tr>
                                                    <td><strong>GROSS LOSS</strong></td>
                                                    <td class="text-right"><?php echo e(number_format($gl,2,'.','')); ?></td>
                                                </tr>
                                                <?php endif; ?>

                                            </tbody>
                                        </table>
                                    </td>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICULAR</th>
                                                    <th class="text-right">AMOUNT</th>
                                                </tr>
                                                <tr>
                                                    <td>OPENING STOCK</td>
                                                    <td class="text-right"><?php echo e(number_format($openingStock,2,'.','')); ?></td>
                                                </tr>

                                                <?php $__currentLoopData = $drTblLedgers->where('gtype','PURCHASE ACCOUNT'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $drList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');

                                                ?>
                                                <tr>
                                                    <td><?php echo e($drList->main_head); ?></td>
                                                    <td class="text-right"><?php echo e(number_format($mHeadAmt,2,'.','')); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $drTblLedgers->where('gtype','DIRECT EXPENSES'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $drList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->whereBetween('date_of_transaction',[$from_date,$to_date])->sum('amount');

                                                ?>
                                                <tr>
                                                    <td><?php echo e($drList->main_head); ?></td>
                                                    <td class="text-right"><?php echo e(number_format($mHeadAmt,2,'.','')); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($crTotal > $drTotal): ?>
                                                <?php $gp = ($crTotal - $drTotal); ?>
                                                <tr>
                                                    <td><strong>GROSS PROFIT</strong></td>
                                                    <td class="text-right"><?php echo e(number_format($gp,2,'.','')); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if($drTotal > $crTotal): ?>
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <?php echo e(number_format($crTotal + ($drTotal - $crTotal),2,'.','')); ?></td>
                                    <?php else: ?>
                                        <td class="text-right"  colspan="2"><strong class="ml-55">TOTAL:</strong> <?php echo e(number_format($crTotal,2,'.','')); ?></td>
                                    <?php endif; ?>

                                    <?php if($crTotal > $drTotal): ?>
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <?php echo e(number_format($drTotal + ($crTotal - $drTotal),2,'.','')); ?></td>
                                    <?php else: ?>
                                        <td class="text-right" colspan="2"><strong class="ml-55">TOTAL:</strong> <?php echo e(number_format($drTotal,2,'.','')); ?></td>
                                    <?php endif; ?>
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

<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/Audit//trading_ac_report.blade.php ENDPATH**/ ?>