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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function submitUpdate() {
            // Disable the update button to prevent multiple submissions
            var updateButton = $('#updateButton');
            updateButton.prop('disabled', true);
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            if (!(startDate))
            {
                alert('Select start date');
                updateButton.prop('disabled', false);
                exit();
            }
            if (!(endDate))
            {
                alert('Select end date');
                updateButton.prop('disabled', false);
                exit();
            }
            // Display updating message immediately when the update starts
            $('#successMessage').text('Updating...').show();

            $.ajax({
                url: "<?php echo e(route('setting.audit-report.update-balance-sheet')); ?>",
                type: "POST",
                data: $('#updateBalanceSheetForm').serialize(),
                success: function(response) {
                    // Update the message with the success information from the server
                    $('#successMessage').text(response.message).removeClass('alert-danger').addClass('alert-success');
                },
                error: function(xhr) {
                    // Show error message
                    $('#successMessage').text('Failed to update: ' + xhr.statusText).removeClass('alert-success').addClass('alert-danger');
                },
                complete: function() {
                    // Re-enable the update button whether success or fail
                    updateButton.prop('disabled', false);
                }
            });
        }
    </script>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Receipt & Disbursement Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">RD</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Receipt & Disbursement Report
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" id="updateBalanceSheetForm">
                        <div class="row">
                            <div class="col-md-3">
                                <span>Sub Groups - <?php echo e($subgroups->total()); ?> items (Per page <?php echo e($subgroups->perPage()); ?> items)</span>
                                <select name="recordPerPage" id="recordPerPage" class="form-control">
                                    <?php for($i = 1; $i <= $subgroups->lastPage(); $i++): ?>
                                        <?php
                                            $start = (($i - 1) * $subgroups->perPage()) + 1;
                                            $end = min($subgroups->total(), $i * $subgroups->perPage());
                                        ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e($i == $subgroups->currentPage() ? 'selected' : ''); ?>>
                                            Page no. <?php echo e($i); ?>: <?php echo e($start); ?> - <?php echo e($end); ?> items
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <span>Start Date</span>
                                <input type="date" name="start_date" id="startDate" value="<?php echo e(request()->get('start_date')); ?>" class="form-control" required />
                            </div>
                            <div class="col-md-3">
                                <span>End Date</span>
                                <input type="date" name="end_date" id="endDate" value="<?php echo e(request()->get('end_date')); ?>" class="form-control" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="button" id="updateButton" class="btn btn-primary btn_sizes" onclick="submitUpdate()">
                                    <i class="fa fa-fw fa-save"></i> Update
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <div id="successMessage" class="alert alert-success" style="display:none;"></div>
                            </div>
                        </div>
                    </form>

                </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>
</section>
    <!-- content -->
</aside>
<!-- right-side -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbara/resources/views/Audit/update-balance-sheet.blade.php ENDPATH**/ ?>