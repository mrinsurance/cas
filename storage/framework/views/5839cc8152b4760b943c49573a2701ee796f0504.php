<?php $__env->startPush('extra_meta'); ?>
  <!-- // -->
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link href="<?php echo e(ASSETS_VENDORS); ?>fullcalendar/css/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(ASSETS_CSS); ?>pages/calendar_custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" media="all" href="<?php echo e(ASSETS_VENDORS); ?>bower-jvectormap/css/jquery-jvectormap-1.2.2.css" />
    <link rel="stylesheet" href="<?php echo e(ASSETS_VENDORS); ?>animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(ASSETS_VENDORS); ?>datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>pages/only_dashboard.css" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(ASSETS_VENDORS); ?>jquery.easy-pie-chart/js/easypiechart.min.js"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>jquery.easy-pie-chart/js/jquery.easypiechart.min.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>jquery.easingpie.js"></script>
    <!--end easy pie chart -->
    <!--for calendar-->

    <!--   Realtime Server Load  -->
    <script src="<?php echo e(ASSETS_VENDORS); ?>flotchart/js/jquery.flot.js" type="text/javascript"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>flotchart/js/jquery.flot.resize.js" type="text/javascript"></script>
    <!--Sparkline Chart-->
    <script src="<?php echo e(ASSETS_VENDORS); ?>sparklinecharts/jquery.sparkline.js"></script>
    <!-- Back to Top-->

    <!--  todolist-->
    <script src="<?php echo e(ASSETS_JS); ?>pages/todolist.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>pages/dashboard.js" type="text/javascript"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
 <aside class="right-side strech">

    <div class="alert alert-primary alert-dismissable margin5">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success:</strong> You have successfully logged in.
    </div>
    <!-- Main content -->
    <section class="content-header">
        <h1>Welcome to Dashboard 
<!-- User roles         -->
            
            
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="livicon" data-name="home" data-size="14" data-color="#333" data-hovercolor="#333"></i> Dashboard
                </a>
            </li>
        </ol>
    </section>
    <!-- Agent Dashboard -->

            <?php if(AuthRole()['name'] == 'AGENT'): ?>
                <?php echo $__env->make('component.agent-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(AuthRole()['name'] == 'STAFF' || AuthRole()['name'] == 'SuperAdmin'): ?>
                <?php echo $__env->make('component.staff-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(AuthRole()['name'] == 'SALEMAN'): ?>
                 <?php echo $__env->make('component.saleman-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
                                        
</aside>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/home.blade.php ENDPATH**/ ?>