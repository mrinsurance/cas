<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo $__env->yieldPushContent('extra_meta'); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- global css -->
    <link href="<?php echo e(ASSETS_CSS); ?>app.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/vendors/daterangepicker/css/daterangepicker.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet"
          type="text/css" />
    <link href="<?php echo e(asset('assets/vendors/clockface/css/clockface.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- end of global css -->
    <!--page level css -->
    <!--end of page level css-->
    <?php echo $__env->yieldPushContent('extra_css'); ?>
</head><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/mylayout/head.blade.php ENDPATH**/ ?>