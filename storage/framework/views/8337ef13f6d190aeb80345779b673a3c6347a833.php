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
<?php
    if (request()->get('from_date'))
    {
        $fromDate = \Carbon\Carbon::parse(request()->get('from_date'))->format('Y-m-d');
    }else{
        $fromDate = \Carbon\Carbon::now()->format('Y-m-d');
    }
    if (request()->get('to_date'))
    {
        $toDate = \Carbon\Carbon::parse(request()->get('to_date'))->format('Y-m-d');
    }else{
        $toDate = \Carbon\Carbon::now()->format('Y-m-d');
    }
?>
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
                    <form class="form-horizontal" action="<?php echo e(route('trading.stock.report')); ?>" method="get">
                        <?php echo e(csrf_field()); ?>

                        <div class="col-md-2">
                            <span>From</span>
                            <input type="date" class="form-control" value="<?php echo e($fromDate); ?>" name="from_date" placeholder="Check-In Date">
                        </div>
                        <div class="col-md-2">
                            <span>To</span>
                            <input type="date" class="form-control" value="<?php echo e($toDate); ?>" name="to_date">
                        </div>

                        <div class="col-md-2">
                            <span>Product Type</span>
                            <select name="producttype" class="form-control">
                                <option value="">All</option>
                                <?php $__currentLoopData = GetMasterOfProductType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val->id); ?>" <?php echo e(@$producttype == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <span>Branch</span>
                            <select name="branch" class="form-control">
                                <option value="">All</option>
                                <?php $__currentLoopData = SocietyBranch(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val->id); ?>" <?php echo e(@$branch == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
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
                                <?php echo e(CompanyAddress()['name']); ?>

                            </h3>
                                <?php echo e(CompanyAddress()['address']); ?>

                            <h4>


                      Stock Report as On <?php echo e($toDate); ?>

                            </h4>
                        </div>
                    </div>
                    <div class="table-scrollable">

                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">ITEM CODE</th>
                                    <th rowspan="2">ITEM NAME</th>
                                    <th colspan="3">CLOSING STOCK</th>
                                </tr>
                                <tr>
                                    <th>RATE</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$openTotalAmt = 0;
$purchaseTotalAmt = 0;
$saleTotalAmt = 0;
$closingTotalAmt = 0;
?>
                              <?php $__currentLoopData = $productList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
// Purchase Data
$branch = request()->get('branch');
    $Purchase = PurchaseDetailByProductId($fromDate,$toDate,$list->id,$branch);

    $PurchaseOpeningQuantity = $Purchase['PurchaseOpeningQuantity'];
    $PurchaseQuantity = $Purchase['PurchaseQuantity'];
    $PurchaseAmount = $Purchase['PurchaseAmountSum'];
// Sale Data
    $Sale = SaleDetailByProductId($fromDate,$toDate,$list->id,$branch);

    $SaleOpeningQuantity = $Sale['SaleOpeningQuantity'];
    $SaleQuantity = $Sale['SaleQuantity'];
    $SaleAmountSum = $Sale['SaleAmountSum'];

$lastPurchaseDate = App\purchase_detail_tbl::orderBy('date_of_transaction','desc')->where('date_of_transaction','<=',$fromDate)->where('product_master_tbl_id',$list->id);
if($branch)
{
$lastPurchaseDate->where('branch_model_id',$branch);
}
$lastPurchaseDate = $lastPurchaseDate->first();

$firstPurchaseDate = App\purchase_detail_tbl::orderBy('date_of_transaction','desc')->where('date_of_transaction','<=',$toDate)->where('product_master_tbl_id',$list->id);

if($branch)
{
$firstPurchaseDate->where('branch_model_id',$branch);
}
$firstPurchaseDate = $firstPurchaseDate->first();

$openQty = $PurchaseOpeningQuantity - $SaleOpeningQuantity;

$closeQty = ((($PurchaseOpeningQuantity - $SaleOpeningQuantity) + $PurchaseQuantity) - $SaleQuantity);

$openingAmt = @$lastPurchaseDate->rate * $openQty;
$purchaseAmt = $PurchaseAmount;
$saleAmt = $SaleAmountSum;
$closingAmt = @$firstPurchaseDate->rate * $closeQty;

$openTotalAmt += $openingAmt;
$purchaseTotalAmt += $purchaseAmt;
$saleTotalAmt += $saleAmt;
$closingTotalAmt += $closingAmt;
?>
                                <tr>
                                    <td class="text-right"><?php echo e($loop->index + 1); ?></td>
                                    <td class="text-right"><?php echo e(@$list->id); ?></td>
                                    <td><?php echo e(@$list->name); ?></td>

                                    <td class="text-right"><?php echo e(number_format(@$firstPurchaseDate->rate,2,'.','')); ?></td>
                                    <td class="text-right"><?php echo e(number_format($closeQty,3,'.','')); ?></td>
                                    <td class="text-right"> <?php echo e(number_format($closingAmt,2,'.','')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th></th>
                                    <th class="text-right" colspan="2">Total</th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right"> <?php echo e(number_format($closingTotalAmt,2,'.','')); ?></th>
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

<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbatran/resources/views/Trading/Sale-Purchase//stock-report.blade.php ENDPATH**/ ?>