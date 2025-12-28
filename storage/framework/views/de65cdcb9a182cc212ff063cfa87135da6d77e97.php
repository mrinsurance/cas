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
        <h1>Sale & Purchase Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Sale & Purchase</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Sale & Purchase
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">
                    <form class="form-horizontal" action="" method="get">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" value="<?php echo e(route('purchase.product.get.name')); ?>" id="getProduct">
                        <div class="col-md-2">
                            <span>From</span>
                            <input type="date" class="form-control" value="<?php echo e(request()->get('from') ? request()->get('from') : \Carbon\Carbon::now()->format('Y-m-d')); ?>" name="from" placeholder="Check-In Date">
                        </div>
                        <div class="col-md-2">
                            <span>To</span>
                            <input type="date" class="form-control" value="<?php echo e(request()->get('to') ? request()->get('to') : \Carbon\Carbon::now()->format('Y-m-d')); ?>" name="to">
                        </div>

                        <div class="col-md-2">
                            <span>Product Type</span>
                            <select name="product_party" class="form-control">
                                <option value="">All</option>
                                <?php $__currentLoopData = GetMasterOfProductType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val->id); ?>" <?php echo e(request()->get('product_party') == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>Item Name</span>
                            <select name="product_name" class="form-control select2">
                                <option value="">All</option>
                                <?php $__currentLoopData = $productList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($list->id); ?>" <?php echo e(request()->get('product_name') == $list->id ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>Branch</span>
                            <select name="branch" class="form-control">
                                <option value="">All</option>
                                <?php $__currentLoopData = SocietyBranch(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val->id); ?>" <?php echo e(request()->get('branch') == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>


                        <div class="col-md-4 align_right">
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
                                <?php echo e(CompanyAddress()->name); ?>

                            </h3>
                                <?php echo e(CompanyAddress()->address); ?>

                            <h4>
                            Sale & Purchase Report from
                                <?php echo e($from); ?>

                                to
                                <?php echo e($to); ?>

                            </h4>
                        </div>
                    </div>
                    <div class="table-scrollable">

                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>

                                    <th rowspan="2">DATE</th>
                                    <th colspan="2">OPENING STOCK</th>
                                    <th colspan="2">PURCHASE</th>
                                    <th colspan="2">SALE</th>
                                    <th rowspan="2">BALANCE</th>
                                </tr>
                                <tr>
                                    <th>Qty</th>
                                    <th>AMOUNT</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                </tr>

                                <?php
                                    $TradingSalePurchase = TradingPurchaseDetailByProductId(request()->get('from_date'),request()->get('to_date'),request()->get('product'),request()->get('branch'));
                                ?>

                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-right"></td>
                                <td></td>
                                <td><?php echo e($sumOfOpenQuantity); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                            </tr>

                                <?php $__currentLoopData = $ledgerDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-right"><?php echo e($loop->index + 1); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($list->date_of_transaction)->format('d-M-Y')); ?></td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>
                                        <td class="text-right"><?php echo e($list->purchase_quantity ?? 0); ?></td>
                                        <td class="text-right"><?php echo e($list->purchase_amount ?? 0.00); ?></td>
                                        <td class="text-right"><?php echo e($list->sale_quantity ?? 0); ?></td>
                                        <td class="text-right"><?php echo e($list->sale_amount ?? 0.00); ?></td>
                                        <td class="text-right"></td>
                                    </tr>
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

<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbara/resources/views/Trading/item-ledger/index.blade.php ENDPATH**/ ?>