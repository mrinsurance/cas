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

       $('#allcb').click(function(e) {
        $('[name="cb[]"]').prop('checked', this.checked);
    });
    /*
    * Click on another checkbox can affect the select all checkbox
    */
    $('[name="cb[]"]').click(function(e) {
        if ($('[name="cb[]"]:checked').length == $('[name="cb[]"]').length || !this.checked)
            $('#allcb').prop('checked', this.checked);
    });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Dividend Calculation</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Dividend Calculation</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Dividend List
                    </div>
                </div>
                <div class="portlet-body">                             
                        <form class="form-horizontal" action="<?php echo e(DIVIDEND_LIST_URL); ?>" method="get">
                    <div class="row">
                        <?php echo e(csrf_field()); ?>

                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Session Year</label>
                            <div class="col-md-6">
                                <select name="session_year" class="form-control" required>
                                    <option value="">--- Select ---</option>
                                    <?php $__currentLoopData = $session_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e($list->id == $session_year ? 'selected' : ''); ?>><?php echo e(date('Y',strtotime($list->start_date))); ?> - <?php echo e(date('Y',strtotime($list->end_date))); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Share On</label>
                            <div class="col-md-6">
                                <input type="date" name="share_on" value="<?php echo e($share_on); ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Paid On</label>
                            <div class="col-md-6">
                                <input type="date" name="paid_on" value="<?php echo e($paid_on); ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Branch</label>
                            <div class="col-md-6">
                                <select name="branch" class="form-control">
                                    <option value="">--- Select ---</option>
                                    <?php $__currentLoopData = $brancheLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e($list->id == $branch ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Member Type</label>
                            <div class="col-md-6">
                                <select name="member_type" class="form-control">
                                    <option value="">--- Select ---</option>
                                    <?php $__currentLoopData = $memberLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e($list->id == $member_type ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="view" class="btn btn-warning btn_sizes" value="1"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>                            
                        </div>
                    </div>
                    </form> 
                    <?php if(session()->has('errors')): ?>
                    <div class="alert alert-danger">
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                      <?php echo e(session()->get('errors')); ?>

                                  </div>
                              <?php endif; ?>
                  <?php if(session()->has('success')): ?>
                    <div class="alert alert-info">
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                      <?php echo e(session()->get('success')); ?>

                                  </div>
                              <?php endif; ?>
                              <?php echo e(@($_REQUEST['view'])?$items->appends(['_token' => $_REQUEST['_token'],'session_year' => $_REQUEST['session_year'],'paid_on' => $_REQUEST['paid_on'],'branch' => $_REQUEST['branch'],'share_on' => $_REQUEST['share_on'],'member_type' => $_REQUEST['member_type'],'view' => $_REQUEST['view']])->render():''); ?>

                     
                    <form class="form-horizontal" action="<?php echo e(DIVIDEND_LIST_URL); ?>"  method="post"> 
                        
                    <div class="table-scrollable">
                       
                           <!-- Print view                         -->
                        <div class="prnt" id="record">       
                            <?php if(isset($_REQUEST['_token'])): ?>
                                     <p> Page - <?php echo e((@$_REQUEST['page'])?$_REQUEST['page']:1); ?> <span style="float: right">
                                      Total  Dividend Amt	:   <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($divident_total)); ?></strong></span> </p>  
                                        <?php endif; ?>      
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="11">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                <?php echo e($company_address->name); ?>

                                            </h3>
                                                <?php echo e($company_address->address); ?>

                                            <h4>
                                                Dividend Paid Upto <strong><?php echo e(date('d-M-Y',strtotime($share_on))); ?></strong> Paid on <strong> <?php echo e(date('d-M-Y',strtotime($paid_on))); ?></strong>
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>                               
                                <tr>
                                    <th><input type="checkbox" id="allcb" name="allcb"/> All</th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>                                    
                                    <th>Share</th>
                                    
                                    <th>Dividend Amt</th>
                                    <th>Dividend@</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $t4 = 0;
                                    $t5 = 0;
                                ?>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <tr>
                                    <th>
                                        <?php if($item->status == 1): ?>
                                        <input type="checkbox" disabled>
                                        <?php else: ?>
                                        <input type="checkbox" id="cb<?php echo e($loop->index + 1); ?>" name="cb[]" value="<?php echo e($item->id); ?>">
                                        <?php endif; ?>
                                    </th>
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($item->open_new_ac_model->full_name); ?></td>
                                    <td><?php echo e($item->account_no); ?></td>
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($item->share); ?></td>
                                    
                                    <td class="align_right"><i class="fa fa-inr"></i> <?php echo e($item->dividend_amt); ?></td>
                                    <td class="align_right"><?php echo e($item->dividend_at); ?>%</td>
                                    
                                    <td>

                                        <button type="button" onclick="window.location.href='<?php echo e(DIVIDEND_LIST_URL.'/'.$item->id); ?>/edit'" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></button>
                                        <?php if($item->status == 1): ?>
                                            <button class="btn btn-success btn-sm">Paid</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                    <?php 
                                        $t4 += $item->share; 
                                        $t5 += $item->dividend_amt;
    
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="4"><strong>Total</strong></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t4,2)); ?></strong>
                                    </td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong><?php echo e(number_format($t5,2)); ?></strong>
                                    </td>
                                    <td></td>
                                    <td></td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                      
                    <div class="row">
                        <?php echo e(csrf_field()); ?>

                        
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button type="submit" class="btn btn-primary btn_sizes
                            "> Update
                            </button>
                            <br>
                            <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>                       
                    </div>
                </form>
                
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Calculation/dividend-list.blade.php ENDPATH**/ ?>