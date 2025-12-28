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
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>confirm-edit-record.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>matured-fd-record.js"></script>
  <!-- <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>blur-request.js"></script> -->
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>fixed-deposit.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>FD A/c of - <?php echo e(@$customer->full_name); ?> A/C No. -  <?php echo e(@$item->account_no); ?></h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(TRANSACTION_URL_FD_AC); ?>"> FD A/C List </a>
            </li>
            <li class="active">Mature</li>
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
                            Fixed Deposit A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                    <form method="post" action="<?php echo e(TRANSACTION_URL_FD_AC.''.$item->id.'/matured'); ?>" id="confirm_frm" class="form-horizontal form-label-left">

                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('PUT')); ?>

                    <input type="hidden" name="ajax_url" value="<?php echo e(url('transaction/fixed-deposite/blur')); ?>" id="ajax_url">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Member Type</label>
                                    <div class="col-md-9">
                                      <select class="form-control" disabled>
                                          <?php $__currentLoopData = $membertypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val->id); ?>" <?php echo e($val->id == $item->member_type_model_id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">A/c No.</label>
                                    <div class="col-md-9">
                                      <input type="text" name="account_no" value="<?php echo e($item->account_no); ?>" class="form-control" disabled>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-3" for="first-name">FD No.
                                      </label>
                                      <div class="col-md-9">
                                        <input type="text" value="<?php echo e($item->fd_no); ?>" class="form-control" disabled>
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Paid Interest</label>
                                    <div class="col-md-9">
                                      <input type="text" name="paid_interest" value="<?php echo e($intPaidLists); ?>"  class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">FD Amount</label>
                                    <div class="col-md-9">
                                      <input type="text" name="fd_amount" value="<?php echo e($item->amount); ?>"  class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                                      </div>
                                </div>
                                <?php
                                $totalFdAmt = $intPaidLists + $item->amount;
                                ?>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Amount</label>
                                    <div class="col-md-9">
                                      <input type="text" name="amount" value="<?php echo e($totalFdAmt); ?>"  class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Rate (%)
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->int_rate); ?>" class="form-control" onkeypress="return isNumAndDecimalKey(event)" readonly="">
                          </div>
                        </div>
<!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-9">
                            <input type="text" class="form-control int_from_date" value="<?php echo e($item->int_run_from); ?>" readonly="readonly">
                          </div>
                        </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-9">
                                     <input type="text" class="form-control" value="<?php echo e($item->transaction_date); ?>" readonly="readonly">
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Period of FD (Month)
                          </label>
                          <div class="col-md-9">
                            <input type="text"  value="<?php echo e($item->period_fd); ?>" class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                          </div>
                        </div>
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="maturity_date" class="form-control" value="<?php echo e($item->maturity_date); ?>" readonly="readonly">
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="matured_on_date" class="form-control" id="old_matured_on_date_cal" value="<?php echo e($item->status == 1 ? date('Y-m-d') : $item->matured_on_date); ?>" >
                          </div>
                        </div>
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled>
                              <?php $__currentLoopData = $type_of_interest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($val); ?>" <?php echo e($val == $item->interest_type ? 'selected' : ''); ?>><?php echo e($val); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group hidden" id="premature_interest">
                            <label class="control-label col-md-3" for="first-name">Interest@ %
                            </label>
                            <div class="col-md-9">
                                <input type="text" value="<?php echo e($item->int_rate); ?>" name="premature_interest_rate" disabled class="form-control interest_rate" onkeypress="return isNumAndDecimalKey(event)" >
                                <span class="color-pwd" id="premature_interest_rate"></span>
                            </div>
                        </div>
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Amount
                          </label>
                          <div class="col-md-5">
                            <input type="text" value="<?php echo e($item->maturity_amount); ?>" name="maturity_amount" class="form-control" onkeypress="return isNumberKey(event)">
                            <span class="text-danger" id="maturity_amount"></span>
                          </div><div class="col-md-4">
                            <span id="maturity_value">FD = <?php echo e($item->amount); ?>, Interest = <?php echo e($item->maturity_amount - $item->amount); ?></span>
                          </div>
                        </div>
                                <!-- Email input-->
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled>
                                <?php $__currentLoopData = TypeOfDeposit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val['name']); ?>" <?php echo e($val['name'] == $item->type_of_deposite ? 'selected' : ''); ?>><?php echo e($val['name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </div>
                        </div>
<!-- Nominee Name -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Name
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->nominee_name); ?>" class="form-control" disabled>
                          </div>
                        </div>
<!-- Nominee Relation -->
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Relation
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled>
                                <?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e($val == $item->nominee_relation ? 'selected' : ''); ?>><?php echo e($val); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </div>
                        </div>
                                <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3 text-center">
                                       <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <?php if(Auth::user()->entry_type == 0): ?>
                                    <div class="col-md-12 text-right btn-group-md">
                                      <input type="hidden" name="mtr" value="sm">
                                        <?php if($item->status == 1): ?>
                                        <button type="submit" class="btn btn-danger btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Mature</button>
                                        <input type="hidden" name="fdStatus" value="0">
                                        <?php else: ?>
                                        <button type="submit" class="btn btn-success btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> UnMature</button>
                                        <input type="hidden" name="fdStatus" value="1">
                                        <?php endif; ?>

                                        <button type="button" id="show_renew_btn" class="btn btn-warning btn_sizes"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</button>
                                    </div>
                                    <?php else: ?>
                                    <div class="col-md-12 text-right btn-group-md">
                                      <input type="hidden" name="mtr" value="dm">
                                        <?php if(!$CheckLock): ?>
                                        <?php if($item->status == 1): ?>
                                        <button type="submit" class="btn btn-danger btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Mature</button>
                                        <input type="hidden" name="fdStatus" value="0">
                                        <?php else: ?>
                                        <button type="submit" class="btn btn-success btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> UnMature</button>
                                        <input type="hidden" name="fdStatus" value="1">
                                        <?php endif; ?>

                                        <button type="button" id="show_renew_btn" class="btn btn-warning btn_sizes"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</button>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
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
                            <span>Renew FD Detail</span>
                        </h3>
                    </div>

                    <div class="panel-body hide" style="height: 921px;" id="renew_fd_area">
                    <form method="post" action="<?php echo e(TRANSACTION_URL_FD_AC.''.$item->id.'/renew'); ?>" id="mature_fd_frm" class="form-horizontal form-label-left">
                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('PUT')); ?>

                    <input type="hidden" name="ajax_url" value="<?php echo e(url('transaction/fixed-deposite/blur')); ?>" id="ajax_url">
                    <input type="hidden" name="old_amount">
                    <input type="hidden" name="old_matured_on_date">
                    <input type="hidden" name="old_maturity_amount">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Member Type</label>
                                    <div class="col-md-9">
                                      <select class="form-control" disabled>
                                          <?php $__currentLoopData = $membertypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val->id); ?>" <?php echo e($val->id == $item->member_type_model_id ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">A/c No.</label>
                                    <div class="col-md-9">
                                      <input type="text" value="<?php echo e($item->account_no); ?>" class="form-control ac_no" disabled>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-3" for="first-name">FD No.
                                      </label>
                                      <div class="col-md-9">
                                        <input type="text" name="renew_fd_no" value="<?php echo e($item->fd_no); ?>" class="form-control">
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Amount <span class="color-pwd">*</span></label>
                                    <div class="col-md-9">
                                      <input type="text" value="<?php echo e($item->maturity_amount); ?>" name="renew_amount" class="form-control renew_amount" onkeypress="return isNumberKey(event)">
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Rate (%) <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->int_rate); ?>" name="renew_interest_rate" class="form-control renew_interest_rate" onkeypress="return isNumAndDecimalKey(event)" >
                            <span class="color-pwd" id="interest_rate"></span>
                          </div>
                        </div>
<!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="renew_interest_run_from" class="form-control" id="int_from_date" value="<?php echo e($item->maturity_date); ?>" readonly="readonly">
                            <span class="color-pwd"></span>
                          </div>
                        </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-9">
                                     <input type="text" name="renew_transaction_date" class="form-control" id="int_on_date" value="<?php echo e($item->matured_on_date); ?>" readonly="readonly">
                            <span class="color-pwd" id="transaction_date"></span>
                                      <span class="color-pwd" id="transaction_date"></span>
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Period of FD (Month) <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text"  value="" name="renew_period_of_fd" class="form-control" id="renew_month_of_period" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="period_of_fd"></span>
                          </div>
                        </div>
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="renew_maturity_date" class="form-control" id="maturity_date_cal"  value="<?php echo e($item->maturity_date); ?>" readonly="readonly">
                            <span class="color-pwd"></span>
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="renew_matured_on_date" class="form-control" id="matured_on_date_cal" value="<?php echo e($item->matured_on_date); ?>" readonly="readonly">
                            <span class="color-pwd"></span>
                          </div>
                        </div>
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-9">
                            <select name="renew_type_of_interest" class="form-control renew_type_of_interest">
                              <?php $__currentLoopData = $type_of_interest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($val); ?>" <?php echo e($val == $item->interest_type ? 'selected' : ''); ?>><?php echo e($val); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                           <span class="color-pwd" id="type_of_interest"></span>
                          </div>
                        </div>

<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Amount <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->maturity_amount); ?>" name="renew_maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>
                                <!-- Email input-->
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-9">
                            <select name="renew_type_of_deposit" class="form-control">
                                <?php $__currentLoopData = TypeOfDeposit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val['name']); ?>" <?php echo e($val['name'] == $item->type_of_deposite ? 'selected' : ''); ?>><?php echo e($val['name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="color-pwd" id="type_of_deposit"></span>
                          </div>
                        </div>
<!-- Nominee Name -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Name <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->nominee_name); ?>" name="renew_nominee_name" class="form-control">
                            <span class="color-pwd" id="nominee_name"></span>
                          </div>
                        </div>
<!-- Nominee Relation -->
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Relation <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <select name="renew_nominee_relation" class="form-control">
                                <?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e($val == $item->nominee_relation ? 'selected' : ''); ?>><?php echo e($val); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="color-pwd" id="nominee_relation"></span>
                          </div>
                        </div>
                                <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3 text-center">
                                       <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-right btn-group-md">
                                      <?php if(Auth::user()->entry_type == 0): ?>
                                      <input type="hidden" name="mtr" value="sm">
                                        <button type="submit" class="btn btn-primary btn_sizes"><i class="fa fa-check" aria-hidden="true"></i> Confirm</button>
                                        <?php else: ?>
                                        <input type="hidden" name="mtr" value="dm">
                                        <button type="submit" class="btn btn-primary btn_sizes"><i class="fa fa-check" aria-hidden="true"></i> Confirm</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Transaction/FD_Ac/mature-fd.blade.php ENDPATH**/ ?>