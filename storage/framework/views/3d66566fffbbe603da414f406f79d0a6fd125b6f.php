<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(ASSETS_VENDORS); ?>datatables/css/dataTables.bootstrap.css" />
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
  <script type="text/javascript" src="<?php echo e(ASSETS_VENDORS); ?>datatables/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_VENDORS); ?>datatables/js/dataTables.bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_SRC_JS); ?>pages/table-responsive.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>bootbox.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>deleteconfirm.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Login with <?php echo e(Auth::user()->name.' '.Auth::user()->last_name); ?></h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Loan A/C</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="panel-heading portlet-title">
                        <h3 class="panel-title pull-left add_remove_title">
                            <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> List of Loan Accounts
                        </h3>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="<?php echo e(TRANSACTION_URL_LOAN_AC); ?>create"><i class="fa fa-plus-circle"></i> Loan Advancement</a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="portlet-body">
<div class="row">
    <div class="col-md-12">
    <form class="form-horizontal" action="<?php echo e(TRANSACTION_URL_LOAN_AC); ?>" method="get">
        <?php echo e(csrf_field()); ?>

        <div class="col-md-3">
            <label class="col-md-6 control-label" for="email">Member Type</label>
            <div class="col-md-6">
                <select name="member" class="form-control">
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$member == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label class="col-md-6 control-label" for="email">A/C</label>
            <div class="col-md-6">
                <input class="form-control" value="<?php echo e(@$account); ?>" name="account" placeholder="Account no.">
            </div>
        </div>
        <div class="col-md-3">
            <label class="col-md-3 control-label" for="email">Date</label>
            <div class="col-md-9">
                <input type="date" name="cur_date" class="form-control" value="<?php echo e(@$cur_date); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> Search</button>
        </div>
    </form>
    </div>
    </div>
                        <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">A/C No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father</th>
                                        <th scope="col">Loan Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
 //Sum of received principal from loan return table
                                $tbl_loan_return_model_sum = \App\tbl_loan_return_model::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(tbl_loan_return_models.received_principal),0) total_received_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->first();
?>
                                  <tr id="product<?php echo e($item->id); ?>">
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td><?php echo e(@$item->open_new_ac_model->full_name); ?></td>
                                    <td><?php echo e(@$item->open_new_ac_model->father_name); ?></td>
                                    <td><?php echo e(LoanType($item->loan_type)['name']); ?></td>
                                    <td><?php echo e(number_format(@$item->amount)); ?></td>
                                    <td><?php echo e(@$item->date_of_advance); ?></td>
                                    <td>
                                        <center>
                                      <?php if(($item->amount - $tbl_loan_return_model_sum->total_received_principal) > 0): ?>
                                      <i class="fa fa-check text-success"></i>
                                      <?php else: ?>
                                        <i class="fa fa-times text-danger"></i>
                                      <?php endif; ?>
                                  </center>
                                    </td>
                                    <td>
                                        <?php if(!$CheckLock): ?>
                                      <a href="<?php echo e(TRANSACTION_URL_LOAN_AC.''.$item->id.'/'.$cur_date); ?>/recovery" class="btn btn-warning btn-sm">Recovery</a>
                                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-delete')): ?>
                                      <button type="button" class="btn btn-danger btn-sm delete-product" value="<?php echo e(TRANSACTION_URL_LOAN_AC.''.$item->id); ?>"><i class="fa fa-trash"></i> Delete</button>
                                        <input type="hidden" id="prd_id" value="<?php echo e($item->id); ?>">
                                        <?php endif; ?>

                                        <?php endif; ?>
                                    </td>
                                  </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
    </section>
    <!-- content -->
</aside>
<!-- right-side -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Transaction/LOAN_Ac/list.blade.php ENDPATH**/ ?>