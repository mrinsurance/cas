<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
  <link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
  <link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/all.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo e(ASSETS_CSS); ?>pages/form2.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>jquery-ui.css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
  <script src="<?php echo e(ASSETS_VENDORS); ?>favicon/favicon.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>pages/form_examples.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>loan-blur-request.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>loan_ac.js"></script>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
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
            <li>
                <a href="<?php echo e(TRANSACTION_URL_LOAN_AC); ?>"> Loan A/C List </a>
            </li>
            <li class="active">Create</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <div class="row">
            <!--row starts-->
            <div class="col-md-6">
                <!--lg-6 starts-->
                <!--basic form 2 starts-->
                <div class="panel panel-primary" id="hidepanel2">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Loan A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="<?php echo e(TRANSACTION_URL_POST_LOAN_AC); ?>" id="post_frm" class="form-horizontal form-label-left">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="open_ac_id" id="open_ac_id">
                    <input type="hidden" name="ajax_url" value="<?php echo e(url('transaction/loan/blur')); ?>" id="ajax_url">
                    <input type="hidden" name="loan_type_url" id="loan_type_url" value="<?php echo e(url('transaction/loan/loan-type')); ?>">
                    <input type="hidden" name="share_balance" class="result_share_balance">
                    <span id="loop_input"></span>
                            <fieldset>

                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="parnoteNo">Parnote No</label>
                                    <div class="col-md-8">
                                        <input type="number" name="parnoteNo" class="form-control col-md-7 col-xs-12">
                                        <span class="color-pwd" id="parnoteNo"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="date_of_transaction">Date of Advancement</label>
                                    <div class="col-md-8">
                                        <input type="date" name="date_of_transaction" class="form-control col-md-7 col-xs-12" value="<?php echo e(date('Y-m-d')); ?>">
                                        <span class="color-pwd" id="date_of_transaction"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Member Type</label>
                                    <div class="col-md-8">
                                      <select name="member_type_model_id" id="membertype_id" class="form-control">
                                        <?php $__currentLoopData = $membertypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                      <span class="color-pwd" id="member_type_model_id"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" name="account_no" id="ac_no" class="form-control col-md-7 col-xs-12 ac_no">
                                      <span class="color-pwd" id="account_no"></span>
                                      </div>
                                </div>


                                <div class="form-group">
                                <label class="col-md-4 control-label" for="password">Amount</label>
                                <div class="col-md-8">
                                <input type="text" name="amount" class="form-control col-md-7 col-xs-12 amount" onkeypress="return isNumberKey(event)" >
                                <span class="color-pwd" id="amount"></span>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Loan Purpose</label>
                                    <div class="col-md-8">
                                        <select name="loan_purpose" class="form-control">
                                            <option value="">--- Select ---</option>
                                            <?php $__currentLoopData = $loan_purpose; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <span class="color-pwd" id="loan_purpose"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Loan Type</label>
                                    <div class="col-md-8">
                                      <select name="loan_type" class="form-control" id="loan_type_request">
                                        <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $loan_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                      <span class="color-pwd" id="loan_type"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Period</label>
                                    <div class="col-md-4">
                                      Term
                                      <select name="term" class="form-control term">
                                          <option value="">--- Select ---</option>
                                          <?php $__currentLoopData = TermofLoan(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                      <span class="color-pwd" id="term"></span>
                                    </div>
                                    <div class="col-md-4">
                                      Months
                                      <input type="text" class="form-control month_value" name="month_value">
                                      <span class="color-pwd" id="month_value"></span>
                                    </div>
                                </div>

                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Interest %</label>
                                    <div class="col-md-4">
                                      Interest @%
                                      <input type="text" class="form-control interest" name="interest">
                                      <span class="color-pwd" id="interest"></span>
                                    </div>
                                    <div class="col-md-4">
                                      Pannelty Interest
                                      <input type="text" class="form-control pannelty_interest" name="pannelty_interest">
                                      <span class="color-pwd" id="pannelty_interest"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Additional Interest %</label>
                                    <div class="col-md-8">
                                      <input type="text" class="form-control additional_interest" name="additional_interest">
                                      <span class="color-pwd" id="additional_interest"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Type of Interest</label>
                                    <div class="col-md-8">
                                      <select name="type_of_interest" class="form-control type_of_interest">
                                        <?php $__currentLoopData = $loan_interest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                      <span class="color-pwd" id="type_of_interest"></span>
                                    </div>
                                </div>
                                <!-- Email input-->


                                <!-- Email input-->


                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-4 control-label">
                                        Mode of Payment
                                    </label>
                                    <div class="col-md-6">
                                      <label class="radio-inline">
                                        &nbsp;<input type="radio" name="mode_of_transaction" value="Cash" checked>Cash
                                      </label>
                                      <label class="radio-inline">
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" disabled name="mode_of_transaction" value="Cheque">Cheque
                                      </label>
                                     <span class="color-pwd" id="mode_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <!-- Cheque Detail                                 -->
                                <div id="cheque_mode" class="hide">
                                  <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Cheque Date</label>
                                    <div class="col-md-8">
                                      <input type="text" name="cheque_date" class="form-control col-md-7 col-xs-12" id="date_of_cheque" value="<?php echo e(date('Y-m-d')); ?>" readonly="readonly" disabled>
                                      <span class="color-pwd" id="cheque_date"></span>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Cheque No.</label>
                                    <div class="col-md-8">
                                      <input type="text" name="cheque_number" class="form-control col-md-7 col-xs-12 cheque_number" onkeypress="return isNumberKey(event)"  disabled>
                                      <span class="color-pwd" id="cheque_number"></span>
                                    </div>
                                  </div>
                                </div>
                                <!-- Email input-->


                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Guarantor One</label>
                                    <div class="col-md-6">
                                      <select name="guarantor_one" class="form-control">
                                        <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $guarenter_first; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->id); ?>"><?php echo e($val->account_no); ?> - <?php echo e($val->full_name); ?> - <?php echo e($val->father_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                      <span class="color-pwd" id="guarantor_one"></span>
                                      </div>
                                    <div class="col-md-2">
                                      <!-- Large modal -->
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="guarantor1()">
                                          Check
                                        </button>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Guarantor Two</label>
                                    <div class="col-md-6">
                                      <select name="guarantor_two" class="form-control">
                                        <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $guarenter_first; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->id); ?>"><?php echo e($val->account_no); ?> - <?php echo e($val->full_name); ?> - <?php echo e($val->father_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                      <span class="color-pwd" id="guarantor_two"></span>
                                      </div>
                                    <div class="col-md-2">
                                        <!-- Large modal -->
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="guarantor2()">
                                            Check
                                        </button>
                                    </div>
                                </div>
                                <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3 text-center">
                                       <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-right btn-group-md">
                                        <?php if(!$CheckLock): ?>
                                        <button type="button" id="install_btn" class="btn btn-primary btn_sizes"><i class="fa fa-list" aria-hidden="true"></i> Create Installment</button>
                                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
                                        <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                      <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <!--panel body ends-->
                  </div>

            </div>
            <!--md-6 ends-->
            <div class="col-md-6">
                <div class="panel panel-primary" id="hidepanel2">
                  <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="address-book" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <span>A/C Detail</span>
                        </h3>

                    </div>

                  <div class="panel-body" style="height: 777px;">
                      <div class="hide text-center" id="error_part">
                        <h4><span id="error_result" class="color-pwd"></span></h4>
                      </div>
                      <div class="hide" id="success_part">
                        <div class="table-scrollable">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <td ><div id="preview" class="thumbnail "></div></td>
                                      <td ><div id="sign" class="thumbnail"></div></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Branch</th>
                                      <td><span id="result_branch"></span></td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td><span id="result_full_name"></span></td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td><span id="result_father"></span></td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td><span id="result_address"></span></td>
                                  </tr>
                                  <tr>
                                    <th>L/F No.</th>
                                      <td id="lf_no"></td>
                                  </tr>
                                  <tr>
                                    <th>Available Balance</th>
                                      <td><span class="color-pwd" id="result_balance"></span></td>
                                  </tr>
                                    <tr>
                                    <th>Available Share Balance</th>
                                    <td><span class="color-pwd" id="result_share_balance"></span></td>
                                    </tr>

                              </tbody>
                          </table>
                      </div>
                      </div>
<!-- Installment table                       -->
                      <div class="table-scrollable" style="overflow-y:auto; height: 323px;">
                          <table class="table table-bordered table-hover">
                                  <tr>
                                      <th>Sr. No.</th>
                                      <th>Date</th>
                                      <th>Principal</th>
                                      <th>Recoverable Int</th>
                                      <th>Net</th>
                                  </tr>
                                  <tbody id="userTable">
                                  </tbody>
                          </table>

                      </div>
                  </div>
                </div>
            </div>
            <!--md-6 ends-->
            </div>
        <!--main content ends-->
      </section>
    <!-- content -->
    <!-- Modal -->
    <div class="modal fade" id="guarantor1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Check Guarantor Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                        <thead>
                        <tr>
                            <th scope="col">A/C No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Father</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody id="loanadv">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</aside>
<script>
  function guarantor1(){

   var guarantor_one = $('select[name=guarantor_one]').val();
   if(guarantor_one==0){
       return false;
   }
   url =`<?php echo e(url('transaction/loan/')); ?>`+"/guarantor_one?guarantor_one="+guarantor_one
    $.get(url, function(res, status){
        $('#loanadv').html(res);
        $('#guarantor1').modal('show');
      });
  }
  function guarantor2(){

      var guarantor_one = $('select[name=guarantor_two]').val();
      if(guarantor_one==0){
          return false;
      }
      url =`<?php echo e(url('transaction/loan/')); ?>`+"/guarantor_one?guarantor_one="+guarantor_one
      $.get(url, function(res, status){
          $('#loanadv').html(res);
          $('#guarantor1').modal('show');
      });
  }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Transaction/LOAN_Ac/create.blade.php ENDPATH**/ ?>