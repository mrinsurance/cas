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
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>saving-blur-request.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>saving_ac.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Saving A/c</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(TRANSACTION_URL_SAVING_AC); ?>"> A/C List </a>
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
                            Saving A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="<?php echo e(TRANSACTION_URL_POST_SAVING_AC); ?>" id="post_frm" class="form-horizontal form-label-left">
                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="open_ac_id" id="open_ac_id" value="<?php echo e(@$_REQUEST['open_ac_id']); ?>">
                    <input type="hidden" name="ajax_url" value="<?php echo e(url('transaction/saving-account/blur')); ?>" id="ajax_url">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Member Type</label>
                                    <div class="col-md-8">
                                      <select name="member_type_model_id" id="membertype_id" class="form-control">
                                        <?php $__currentLoopData = $membertypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->id); ?>" <?php echo e(request()->member_id == $val->id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                      <span class="color-pwd" id="member_type_model_id"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" name="account_no" class="form-control" onblur="getRdRecord(this.value)" value="<?php echo e(request()->ac_no); ?>">
                                      <span class="color-pwd" id="account_no"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Amount</label>
                                    <div class="col-md-8">
                                      <input type="text" name="amount" class="form-control col-md-7 col-xs-12 amount groupOfTexbox" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-8">
                                      <!-- <input type="text" name="date_of_transaction" class="form-control col-md-7 col-xs-12" id="transaction_date" value="<?php echo e(date('Y-m-d')); ?>" readonly="readonly"> -->
                                      <input type="date" name="date_of_transaction" class="form-control" value="<?php echo e(@($_REQUEST['date'])?$_REQUEST['date']:date('Y-m-d')); ?>">
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
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
            <!-- <input type="radio" name="mode_of_transaction" value="Cheque">Cheque -->
                                        <input type="radio" name="mode_of_transaction" value="Transfer">Transfer
                                      </label>
                                     <span class="color-pwd" id="mode_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <!-- Cheque Detail -->
                                <div id="cheque_mode" class="hide">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="name1">Sub Groups</label>
                                        <div class="col-md-8">
                                            <select name="subGroups" class="form-control">
                                                <?php $__currentLoopData = subGroupsMaster(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->name); ?>"><?php echo e($val->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <span class="color-pwd" id="subGroups"></span>
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
                                      <textarea name="transaction_particular" class="form-control col-md-7 col-xs-12" cols="30" rows="1" id="trans_particular">Deposit by cash</textarea>
                                      <span class="color-pwd" id="transaction_particular"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Remarks</label>
                                    <div class="col-md-8">
                                       <textarea name="remarks" class="form-control col-md-7 col-xs-12" cols="30" rows="1"></textarea>
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
                                        <button type="submit" class="btn btn-warning btn_sizes" <?php echo e(request()->ac_no == FALSE ? 'disabled' : ''); ?>><i class="fa fa-save" aria-hidden="true"></i> Save</button>

                                        <a href="<?php echo e(request()->ac_no == FALSE ? '#' : $view_ac_url); ?>" class="btn btn-warning btn_sizes" id="view_ac" <?php echo e(request()->ac_no == FALSE ? 'disabled' : ''); ?> target="_new"><i class="fa fa-list"></i> Transactions</a>
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

                  <div class="panel-body" style="overflow-y:auto; height: 473px;">
                      <div class="table-scrollable">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <td >
                                        <div class="thumbnail" id="preview">
                                          <img src="<?php echo e(PREFIX1.'default-img/profile.png'); ?>" width="100" class="img-responsive" alt="">
                                        </div>
                                            <?php if(!Auth::user()->hasRole('AGENT')): ?>
                                                <div class="thumbnail" id="sign">
                                                    <img src="<?php echo e(PREFIX1.'default-img/signature.png'); ?>" width="100" class="img-responsive" alt="">
                                                </div>
                                            <?php endif; ?>
                                      </td>
                                      <td style="display: block; height: 270px; overflow-y: scroll;">
                                        <table class="table table-bordered table-hover">
                                            <tbody id="success_part">
                                            <tr>
                                            <th>Branch</th>
                                            <td id="result_branch"><?php echo e(@$branch); ?></td>
                                            </tr>
                                            <tr>
                                            <th>Member Name</th>
                                        <td id="result_full_name"><?php echo e(@$full_name); ?></td>
                                            </tr>
                                            <tr>
                                            <th>Father Name</th>
                                        <td id="result_father"><?php echo e(@$father_name); ?></td>
                                            </tr>
                                            <tr>
                                            <th>Address</th>
                                            <td id="result_address"><?php echo e(@$address); ?></td>
                                            </tr>
                                            <tr>
                                            <th>L/F No.</th>
                                        <td id="lf_no"><?php echo e(@$lf_no); ?></td>
                                            </tr>
                                            <tr>
                                            <th>Available Balance</th>
                                        <td>
                                        <span class="color-pwd" id="result_balance"><i class="fa fa-fw fa-inr"></i><?php echo e(@$balance); ?></span>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td colspan="2">
                                            <a href="<?php echo e(request()->ac_no == FALSE ? '#' : $pl_url); ?>" class="btn btn-primary" id="ledger_id" target="_blank" <?php echo e(request()->ac_no == FALSE ? 'disabled' : ''); ?>>P/L View</a>
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
                                      </td>
                                  </tr>
                                </tbody>
                              </table>
                        <div style="display: flex; flex-direction: column-reverse; height: 150px; overflow-y: scroll;">
                            <div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Deposit Amount</th>
                                        <th>Withdrawal Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody class="loadTableData">
                                <?php
                                    $val = 0;
                                ?>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                    <td><?php echo e(date('d-M-Y',strtotime($item->date_of_transaction))); ?></td>
                                    <td>
                                    <?php if($item->type_of_transaction == 'Deposit'): ?>
                                    <?php echo e(number_format($item->amount)); ?>

                                    <?php endif; ?>
                                    </td>
                                    <td>
                                    <?php if($item->type_of_transaction == 'Withdrawal'): ?>
                                    <?php echo e(number_format($item->amount)); ?>

                                    <?php endif; ?>
                                    </td>
                                    <td>
                                    <?php
                                        if($item->type_of_transaction == 'Deposit')
                                        {
                                          $val = $val + $item->amount;
                                        }
                                        else{
                                        $val = $val - $item->amount;
                                      }
                                    ?>
                                    <?php echo e(number_format($val)); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            </table>
                            </div>
                        </div>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/Transaction/Saving_Ac/create.blade.php ENDPATH**/ ?>