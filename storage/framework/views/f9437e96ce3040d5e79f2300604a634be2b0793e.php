<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
    <link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>jquery-ui.css" />

<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(ASSETS_VENDORS); ?>favicon/favicon.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>pages/form_examples.js"></script>
    <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>day_book.js"></script></script>
    <!-- end of page level js -->
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Agent Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Agent Report</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
    <div class="col-md-12">
        <div class="panel-body">
            <form class="form-horizontal" action="<?php echo e(ADDITIONAL_REPORT_URL_AGENT); ?>" method="get">
                <?php echo e(csrf_field()); ?>

                <fieldset>
                    <!-- Name input-->
                    <div class="form-group">
                        
                        <?php if(Auth::user()->staff_type == 'Staff'): ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">Branch</label>
                                <div class="col-md-10 text-left">
                                    <select name="branch" class="form-control">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($_item->id); ?>" <?php echo e(@$branch == $_item->id ? 'selected' : ''); ?>><?php echo e($_item->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">User</label>
                                <div class="col-md-10 text-left">
                                    <select name="agent_name" class="form-control">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->id); ?>" <?php echo e(@$agent_name == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?> (<?php echo e(@$val->designation_model->name); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="email">
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">View</button>
                                    <button type="submit" class="btn btn-responsive btn-warning btn-sm">Print</button>
                                </label>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>                   
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> 
                            Receipt (Collection Report of <?php echo e(@$search_branch != '' ? $branch_name->name : 'All'); ?> Branch, collect by <?php echo e(@$search_user != '' ? $user_name->name : 'All'); ?>)
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive fixed-table-body">
                            <table class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>A/C Type</th>
                                        <th>A/C No</th>
                                        <th>Saving</th>
                                        <th>DRD</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $_saving = \App\saving_ac_model::select('id','open_new_ac_model_id')
                                            ->where('open_new_ac_model_id',$_item->id)
                                            ->first();
                                            
                                            $_drd = 
                                            \App\drd_model::select('id','open_new_ac_model_id')
                                            ->where('open_new_ac_model_id',$_item->id)
                                            ->first();
                                        ?>
                                    <tr>
                                        <td><?php echo e($loop->index + 1); ?></td>
                                        <td><?php echo e($_item->member_type_model->name); ?></td>
                                        <td><?php echo e($_item->account_no); ?></td>
                                        <td>
                                            <?php if($_saving): ?>
                                                <i class="fa fa-check text-success"></i>   
                                            <?php else: ?>
                                                <i class="fa fa-close text-danger"></i>   
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($_drd): ?>
                                                <i class="fa fa-check text-success"></i>   
                                            <?php else: ?>
                                                <i class="fa fa-close text-danger"></i>   
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Additional/agent-report.blade.php ENDPATH**/ ?>