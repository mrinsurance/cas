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
        <h1>Interest on Saving Calculation</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Interest on Saving Calculation</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Interest on Saving Calculation List
                    </div>
                </div>
                <div class="portlet-body">                             
                        <form class="form-horizontal" action="<?php echo e(INTEREST_ON_SAVING_LIST_URL); ?>" method="get">
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
                            <label class="col-md-4 control-label" for="email">From</label>
                            <div class="col-md-6">
                                <input type="date" name="share_on" value="<?php echo e($share_on); ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">To</label>
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
                                    <option value="">--- All ---</option>
                                    <?php $__currentLoopData = $brancheLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e($list->id == $branch ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-4 control-label" for="email">Member Type</label>
                            <div class="col-md-6">
                                <select name="member_type" class="form-control" required>
                                    <option value="">--- All ---</option>
                                    <?php $__currentLoopData = $memberLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($list->id); ?>" <?php echo e($list->id == $member_type ? 'selected' : ''); ?>><?php echo e($list->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="view" class="btn btn-warning btn_sizes" value="1"><i class="fa fa-fw fa-eye"></i> View</button>
                            <?php if(isset($_REQUEST['_token'])): ?>
                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                            <?php else: ?>
                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                           <?php endif; ?>
                          
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
                    <form class="form-horizontal" action="<?php echo e(INTEREST_ON_SAVING_LIST_URL); ?>"  method="post"> 
                        
                    <div class="table-scrollable">
                           <!-- Print view                         -->
                        <div class="prnt" id="record">   
                            <?php if(isset($_REQUEST['_token'])): ?>
                            <p> Page - <?php echo e((@$_REQUEST['page'])?$_REQUEST['page']:1); ?> <span style="float: right">
                             Total  Interest Amt	:   <i class="fa fa-inr"></i>   
                               <strong><?php echo e(number_format(@$divident_total)); ?></strong></span> </p>  
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
                                                Interest Paid On <?php echo e($member_type); ?> From <strong><?php echo e(date('d-M-Y',strtotime($share_on))); ?></strong> To <strong> <?php echo e(date('d-M-Y',strtotime($paid_on))); ?></strong>
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th><input type="checkbox" id="allcb" name="allcb"/> All</th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>                                    
                                    <th>Saving</th>
                                    
                                    <th>Interest Amt</th>
                                    <th>Interest@</th>
                                    
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
                                    
                                    <td class="align_right"><i class="fa fa-inr"></i> <span id="s_no_<?php echo e($loop->index + 1); ?>"><?php echo e($item->dividend_amt); ?></span></td>
                                    <td class="align_right"><?php echo e($item->dividend_at); ?>%</td>
                                    
                                    <td>

                                        <?php if($item->status == 1): ?>
                                            <button class="btn btn-success btn-sm">Paid</button>
                                        <?php else: ?>
                                        <button type="button" onclick="getinterestlistedit(<?php echo e($item->id); ?>,<?php echo e($loop->index + 1); ?>)" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></button>
                                            
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
                    <?php if(isset($_REQUEST['_token'])): ?>
                    <?php echo e(@($_REQUEST['view'])?$items->appends(['_token' => $_REQUEST['_token'],'session_year' => $_REQUEST['session_year'],'paid_on' => $_REQUEST['paid_on'],'branch' => $_REQUEST['branch'],'share_on' => $_REQUEST['share_on'],'member_type' => $_REQUEST['member_type'],'view' => $_REQUEST['view']])->render():''); ?>

                     <?php endif; ?>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel">Edit</h4>
        </div>
        <div class="modal-body">
            <form method="post"action="<?php echo e(INTEREST_ON_SAVING_LIST_URL); ?>" id="edit_interest_list_frm" class="form-horizontal form-label-left" method="post">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('PUT')); ?>

                        <div class="form-body">
                            <input type="hidden" name="item_id" id="item_id" value="">
                            <input type="hidden" name="s_no" id="s_no" value="">
                            <!-- Form Group                               -->
                            <div class="form-group">
                                <label for="inputUsername" class="col-md-3 control-label">
                                    A/C No.
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="account_no" class="form-control" value="" disabled>
                                </div>
                            </div>
                            <!-- Form Group                               -->
                            <div class="form-group">
                                <label for="inputUsername" class="col-md-3 control-label">
                                    A/C Holder Name
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="holder_name" class="form-control" value="" disabled>
                                </div>
                            </div>
                            <!-- Form Group                               -->
                            <div class="form-group">
                                <label for="inputUsername" class="col-md-3 control-label">
                                    Interest Amount <span class="color-pwd">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="dividend_amount" name="dividend_amount" class="form-control" value="" onkeypress="return isNumAndDecimalKey(event)" required>
                                </div>
                            </div>
                            <!-- Form Group                               -->
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" onclick="getformeditvalue()" class="btn btn-success btn_sizes">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        
                    </form>
        </div>

      </div>
    </div>
  </div>
  <script>
    function getformeditvalue() { 
      $("#edit_interest_list_frm").submit(function(e) { 
       e.preventDefault();
       var form = $(this);
       item_id = document.getElementById('item_id').value;
       var url = form.attr("action")+'/'+item_id; 
       var data = new FormData(form[0]);
       $.ajax({
           url: url,
           type: 'POST',
           data: data,
           cache: false,
           processData: false,
           contentType: false,
           beforeSend: function() {
               $("#overlay").show();
               $('.print-warning-msg').css('display', 'block');
               $(".print-success-msg").css('display', 'none');
               $(".print-error-msg").css('display', 'none');
           },
           success: function(data) {
               sno = document.getElementById('s_no').value;
               divident = data.dividend_amt;
               s_no = `s_no_`+sno;
               console.log(s_no);
               if (data.error_msg) {
                   customErrorMsg(data.error_msg);
               } else if (data.error) {
                   printErrorMsg(data.error, data.sec_key);
               } else {
                   var $seckey = [];
                   $.each(data.sec_key, function(key, value) {
                       $seckey.push(key);
                   });
                   for (var len = 0; len <= $seckey.length; len++) {
                       $("#" + $seckey[len]).html('');
                       $("." + $seckey[len]).removeClass('has-error');
                   }
   
                   $(".print-success-msg").find("ul").html('');
                   $(".print-success-msg").css('display', 'block');
                   $(".print-error-msg").css('display', 'none');
                   $(".print-success-msg").find("ul").append(data.success);
                   // setTimeout(
                   //     function() {
                   //         location.href = data.return_url;
                   //     },
                   //     2000);
               }
           },
           error: function(jqXHR, textStatus, errorThrown) {
               $("#overlay").hide();
               console.log(jqXHR, textStatus, errorThrown);
           },
           complete: function() {
               document.getElementById("edit_interest_list_frm").reset();
   
               $('#myModal').modal('hide');
               document.getElementById("dividend_amount").value = '';
               document.getElementById("holder_name").value = '';
               document.getElementById("account_no").value = '';
               document.getElementById("s_no").value = '';
               document.getElementById(s_no).innerHTML  = divident;
               
               $("#overlay").hide();
               $('.print-warning-msg').css('display', 'none');
           }
       });
   });
   
               }
               </script>
  <script>
function getinterestlistedit(id,s_no){ 
     url =`<?php echo e(url('calculations/interest-on-saving-list-edit/')); ?>`+"?edit_id="+id;
    $.get(url, function(data, status){ console.log(data)
        dividend_amount =data.item.dividend_amt;
        holder_name =data.item.holder_name;
        account_no =data.item.account_no;
        document.getElementById("dividend_amount").value = dividend_amount;
        document.getElementById("holder_name").value = holder_name;
        document.getElementById("account_no").value = account_no;
        document.getElementById("s_no").value = s_no;
        document.getElementById('item_id').value  = data.item.id;
        $('#myModal').modal('show');
});
}

  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Calculation/interest-on-saving-list.blade.php ENDPATH**/ ?>