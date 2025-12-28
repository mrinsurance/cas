<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(ASSETS_VENDORS); ?>datatables/css/dataTables.bootstrap.css" />
<link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>


<script src="<?php echo e(ASSETS_SRC_JS); ?>pages/table-responsive.js"></script>
<script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>bootbox.js"></script>
<script>
   function deleteFunction(val) { 
      if(confirm("Are You Sure to delete this"))
      {
        event.preventDefault();
        document.getElementById('delete-form-'+val).submit()
      }
        event.preventDefault();
  }
 </script>
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
            <li class="active">FD A/C List</li>
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
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> FD A/C List
                        </h3>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="<?php echo e(TRANSACTION_URL_FD_AC); ?>create"><i class="fa fa-plus-circle"></i> Create New FD</a>
                        </div>
                    </div>
                    
                    <div class="portlet-body">
<div class="row">
    <form class="form-horizontal" action="<?php echo e(TRANSACTION_URL_FD_AC); ?>" method="get">
        <?php echo e(csrf_field()); ?>


        <div class="col-md-3">
            <label class="control-label" for="email">Member Type</label>
                <select name="member" class="form-control">
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val->id); ?>" <?php echo e(@$member == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="control-label" for="email">A/C</label>
            <input class="form-control" value="<?php echo e(@$account); ?>" name="account" placeholder="Account no.">
        </div>
        <div class="col-md-3">
            <label class="control-label" for="">
                <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> Search</button>
            </label>
        </div>
    </form>
    </div>
                        <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php if($message = Session::get('success')): ?>
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
  <strong><?php echo e($message); ?></strong>
</div>
<?php endif; ?>
<?php if($message = Session::get('error')): ?>
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong><?php echo e($message); ?></strong>
</div>
<?php endif; ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">A/C</th>
                                        <th scope="col">FD No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father</th>
                                        <th scope="col">FD Amount <small>(Rs.)</small></th>
                                        <th scope="col">Paid Interest <small>(Rs.)</small></th>
                                        <th scope="col">Total <small>(Rs.)</small></th>
                                        <th scope="col">FD Dated</th>
                                        <th scope="col">Matuarity Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $amount = 0;
                                    $paidInt = 0;
                                    $amount = 0;
                                ?>
                                  <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <?php
                                          $InterestOnFd = getSumInterestOnFdById($item->id);
                                            if ($item->status == 1)
                                                {
                                                    $amount += $item->amount;
                                                    $paidInt += $InterestOnFd;
                                                }
                                      ?>
                                  <tr id="product<?php echo e($item->id); ?>">
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td><?php echo e($item->fd_no); ?></td>
                                    <td><?php echo e(@$item->open_new_ac_model->full_name); ?></td>
                                    <td><?php echo e(@$item->open_new_ac_model->father_name); ?></td>
                                    <td><?php echo e(number_format($item->amount,2,'.','')); ?></td>
                                    <td><?php echo e(number_format($InterestOnFd,2,'.','')); ?></td>
                                    <td><?php echo e(number_format($item->amount + $InterestOnFd,2,'.','')); ?></td>
                                    <td><?php echo e(@$item->int_run_from); ?></td>
                                    <td><?php echo e(@$item->maturity_date); ?></td>
                                    <td>
                                      <?php if($item->status == 1): ?>
                                      <span class="text text-success">Active</span>
                                      <?php else: ?>
                                      <span class="text text-danger">Matured</span>
                                      <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(!$CheckLock): ?>
                                            <?php if($item->status == 1): ?>
                                            <a onclick="return deleteFunction(<?php echo e($item->id); ?>);" href="#" data-toggle="tooltip" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            <form id="delete-form-<?php echo e($item->id); ?>" action="<?php echo e(TRANSACTION_URL_FD_AC.''.$item->id); ?>" method="POST" style="display: none;">
                                            <?php echo method_field('delete'); ?>
                                            <?php echo csrf_field(); ?>
                                            </form>

                                            <a href="<?php echo e(TRANSACTION_URL_FD_AC.''.$item->id); ?>/edit" class="ml-10" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit text-warning"></i>
                                            </a>
                                            <a href="<?php echo e(TRANSACTION_URL_FD_AC.''.$item->id); ?>/matured" class="ml-10" data-toggle="tooltip" title="Mature">
                                                <i class="fa fa-arrow-right text-info"></i>
                                            </a>
                                            <?php else: ?>
                                            <a href="<?php echo e(TRANSACTION_URL_FD_AC.''.$item->id); ?>/matured" data-toggle="tooltip" title="UnMature">
                                                <i class="fa fa-undo text-success"></i>
                                            </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                  </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="12" class="text-right text-danger">Balance FD Amount = <?php echo e($amount + $paidInt); ?></td>
                                </tr>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbara/resources/views/Transaction/FD_Ac/list.blade.php ENDPATH**/ ?>