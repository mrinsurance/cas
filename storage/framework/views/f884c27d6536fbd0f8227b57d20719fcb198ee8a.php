<!DOCTYPE html>
<html>

<?php echo $__env->make('mylayout.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body class="skin-josh">
<?php if(\Session::has('success')): ?>
    <div class="alert alert-success">
        <ul>
            <li><?php echo \Session::get('success'); ?></li>
        </ul>
    </div>
<?php endif; ?>
<div id="overlay">
        <img id="loading-image" src="<?php echo e(url('assets/img/loading-2.gif')); ?>"/>
</div>    
<?php echo $__env->make('mylayout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
     <?php if(AuthRole()['name']  != 'SALEMAN'): ?>
        <?php echo $__env->make('mylayout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
        <!-- Right side column. Contains the navbar and content of the page -->
<?php echo $__env->yieldContent('body'); ?>       
        <!-- right-side -->
    </div>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!-- global js -->
<?php echo $__env->make('mylayout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('mylayout.search-account-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('mylayout.cash-in-hand-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- end of page level js -->
<script src="<?php echo e(asset('assets/js/get-product-name.js')); ?>"></script>

<script src="<?php echo e(asset('assets/vendors/daterangepicker/js/daterangepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/clockface/js/clockface.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/pages/datepicker.js')); ?>" type="text/javascript"></script>
<script>
    // resources/js/app.js
    Echo.private('balance-sheet')
        .listen('BalanceSheetUpdated', (e) => {
            alert(e.message); // Or update the DOM as necessary
        });

</script>
</body>

</html>
<?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/mylayout/master.blade.php ENDPATH**/ ?>