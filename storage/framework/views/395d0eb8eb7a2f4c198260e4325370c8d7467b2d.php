<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
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
            <li class="active">Account List</li>
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

                            Total Account Holders -> <?php echo e($items->firstItem()); ?> - <?php echo e($items->lastItem()); ?> of <?php echo e($items->total()); ?> (for page <?php echo e($items->currentPage()); ?> )
                        </h3>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
                        <div class="pull-right">
                            <a class="btn btn-default btn-sm" href="<?php echo e(TRANSACTION_URL_OPEN_NEW_AC); ?>create" target="_new"><i class="fa fa-plus-circle"></i> Create Account</a>
                        </div>
                        <?php endif; ?>
                    </div>


                    <div class="portlet-body">
                        <div class="row pt-0 pb-0">
                        <div class="col-md-3 pull-right">
                            <form action="<?php echo e(TRANSACTION_URL_OPEN_NEW_AC); ?>" method="get" role="search">
                              <?php echo e(csrf_field()); ?>

                             <div class="form-group row">
                              <div class="col-sm-8">
                                  <input type="text" name="search" value="<?php echo e(old('search',@$search)); ?>" class="form-control">
                                </div>
                              <div class="col-sm-4">
                                  <button type="submit" class="btn btn-warning">Search</button>
                                </div>
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
                                        <th scope="col">Member Type</th>
                                        <th scope="col">Account No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father Name</th>
                                        <th scope="col">Village</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr id="product<?php echo e($item->id); ?>">
                                    <td><?php echo e($loop->index + $items->firstItem()); ?></td>
                                    <td><?php echo e(@$item->member_type_model->name); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td><?php echo e($item->full_name); ?></td>
                                    <td><?php echo e(@$item->father_name); ?></td>
                                    <td><?php echo e($item->village); ?></td>
                                    <td><?php echo e(@$item->contact_no); ?></td>
                                    <td><center>
                                      <?php if($item->status == 1): ?>
                                      <i class="fa fa-fw fa-check text-success"></i>
                                      <?php else: ?>
                                        <i class="fa fa-fw fa-times text-danger"></i>
                                      <?php endif; ?>
                                  </center>
                                    </td>
                                    <td>
                                        <?php if(!$CheckLock): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-edit')): ?>
                                      <a href="<?php echo e(TRANSACTION_URL_OPEN_NEW_AC.''.$item->id); ?>/edit" data-toggle="tooltip" title="Edit" target="_new" class="mr-10"><i class="fa fa-edit text-warning"></i></a>
                                    <?php endif; ?>

                                      <a href="<?php echo e(TRANSACTION_URL_OPEN_NEW_AC.''.$item->id); ?>" data-toggle="tooltip" title="View" target="_new" class="mr-10"><i class="fa fa-eye text-success"></i></a>

                                      <a href="<?php echo e(TRANSACTION_URL_OPEN_NEW_AC.'print/'.$item->id); ?>" data-toggle="tooltip" title="Print" target="_new"><i class="fa fa-print text-danger"></i></a>
                                        <?php endif; ?>
                                    </td>
                                  </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                       <center> <?php echo e($items->links()); ?> </center>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Transaction/Open_New_Ac/list.blade.php ENDPATH**/ ?>