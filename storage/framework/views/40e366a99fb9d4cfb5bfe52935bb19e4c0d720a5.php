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
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>share-blur-request.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>share_ac.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
       <h1>Share A/C</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(TRANSACTION_URL_SHARE_AC); ?>"> A/C List </a>
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
                <div class="panel panel-danger" id="hidepanel2">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Share A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="<?php echo e(TRANSACTION_URL_POST_SHARE_AC); ?>" id="post_frm" class="form-horizontal form-label-left">
                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="ajax_url" value="<?php echo e(url('transaction/share/blur')); ?>" id="ajax_url">
                    <input type="hidden" id="open_ac_id" name="open_ac_id">
                            <fieldset>
                                <!-- Name input-->
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
                                      <input type="text" name="account_no" onblur="getRdRecord(this.value)" id="ac_no" class="form-control ac_no">
                                      <span class="color-pwd" id="account_no"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Amount</label>
                                    <div class="col-md-8">
                                      <input type="text" name="amount" class="form-control amount" onkeypress="return isNumberKey(event)" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-8">
                                      <!-- <input type="text" name="date_of_transaction" class="form-control" id="transaction_date" value="<?php echo e(date('Y-m-d')); ?>" readonly="readonly"> -->
                                      <input type="date" name="date_of_transaction" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                                      <span class="color-pwd" id="date_of_transaction"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-4 control-label">
                                        Mode of Transaction
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
                                      <input type="text" name="cheque_date" class="form-control" id="date_of_cheque" value="<?php echo e(date('Y-m-d')); ?>" readonly="readonly" disabled>
                                      <span class="color-pwd" id="cheque_date"></span>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Cheque No.</label>
                                    <div class="col-md-8">
                                      <input type="text" name="cheque_number" class="form-control cheque_number" onkeypress="return isNumberKey(event)"  disabled>
                                      <span class="color-pwd" id="cheque_number"></span>
                                    </div>
                                  </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-4 control-label">
                                        Type of Transaction
                                    </label>
                                    <div class="col-md-6">
                                      <label class="radio-inline">
                                        &nbsp;<input type="radio" name="type_of_transaction" value="Deposit" checked>&nbsp; Deposit
                                      </label>
                                      <label class="radio-inline">
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" name="type_of_transaction" value="Withdrawal">&nbsp; Withdrawal
                                      </label>
                                     <span class="color-pwd" id="type_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Transaction Particular</label>
                                    <div class="col-md-8">
                                      <textarea name="transaction_particular" class="form-control" cols="30" rows="1" id="trans_particular">Deposit by Cash</textarea>
                                      <span class="color-pwd" id="transaction_particular"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Remarks</label>
                                    <div class="col-md-8">
                                       <textarea name="remarks" class="form-control" cols="30" rows="1"></textarea>
                                      <span class="color-pwd" id="remarks"></span>
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
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
                                        <button type="submit" class="btn btn-warning btn_sizes" disabled><i class="fa fa-save" aria-hidden="true"></i> Save</button>

                                        <a href="#" class="btn btn-success btn_sizes" id="view_ac" disabled target="_new"><i class="fa fa-list"></i> Transactions</a>
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
                <div class="panel panel-danger" id="hidepanel2">
                  <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="address-book" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <span>A/C Detail</span>
                        </h3>
                    </div>

                  <div class="panel-body" style="overflow-y:auto; height: 473px;">
                        <div class="table-scrollable">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <td >
                                        <div class="thumbnail" id="preview">
                                          <img src="<?php echo e(PREFIX1.'default-img/profile.png'); ?>" width="150" class="img-responsive" alt="">
                                        </div>
                                      </td>
                                      <?php if(!Auth::user()->hasRole('AGENT')): ?>
                                      <td >
                                        <div class="thumbnail" id="sign">
                                          <img src="<?php echo e(PREFIX1.'default-img/signature.png'); ?>" width="150" class="img-responsive" alt="">
                                        </div>
                                      </td>
                                      <?php endif; ?>
                                  </tr>
                                </tbody>
                              </table>
                              <table class="table table-bordered table-hover">
                              <tbody id="success_part">
                                  <tr>
                                      <th>Branch</th>
                                      <td id="result_branch"></td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td id="result_full_name"></td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td id="result_father"></td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td id="result_address"></td>
                                  </tr>
                                  <tr>
                                    <th>L/F No.</th>
                                      <td id="lf_no"></td>
                                  </tr>
                                  <tr>
                                    <th>Available Balance</th>
                                      <td>
                                        <span class="color-pwd" id="result_balance"></span>
                                      </td>
                                  </tr>
                              </tbody>
                              <tbody id="error_part" class="hide">
                                <tr>
                                  <td colspan="2">
                                    <span class="color-pwd" id="error_result"></span>
                                  </td>
                                </tr>
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
</aside>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Transaction/Share_Ac/create.blade.php ENDPATH**/ ?>