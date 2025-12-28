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
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>bank-blur-request.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>bank-fixed-deposit.js"></script>
  <script>
      $("#show_renew_btn").click(function (){
         $("#renew_fd_area").removeClass('hide');
      });
  </script>
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
                <a href="<?php echo e(TRANSACTION_URL_BANK_FD_AC); ?>"> Bank FD A/C List</a>
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
                            Bank Fixed Deposit A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                    <form method="post" action="<?php echo e(TRANSACTION_URL_BANK_FD_AC.''.$item->id.'/matured'); ?>" id="confirm_frm" class="form-horizontal form-label-left">

                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('PUT')); ?>

                    <input type="hidden" name="ajax_url" value="<?php echo e(url('transaction/bank-fixed-deposite/blur')); ?>" id="ajax_url">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Branch</label>
                                    <div class="col-md-9">
                                     <select class="form-control" disabled="">
                                        <option value=""><?php echo e($item->branch_model->name); ?></option>
                                        </select>
                                      </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Bank</label>
                                    <div class="col-md-9">
                                    <select class="form-control" disabled="">
                                        <option value=""><?php echo e(@$item->bank_model->name); ?></option>
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
                                        <input type="text" name="fd_no" value="<?php echo e($item->fd_no); ?>" class="form-control" readonly="">
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Amount</label>
                                    <div class="col-md-9">
                                      <input type="text" name="amount" value="<?php echo e($item->amount); ?>" class="form-control" readonly="">
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Rate (%)
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->int_rate); ?>" class="form-control" readonly="">
                          </div>
                        </div>
<!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" value="<?php echo e($item->int_run_from); ?>" disabled="">
                          </div>
                        </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-9">
                                     <input type="text" class="form-control" value="<?php echo e($item->transaction_date); ?>" disabled="">
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Period of FD (Month)
                          </label>
                          <div class="col-md-9">
                            <input type="text"  value="<?php echo e($item->period_fd); ?>" class="form-control" disabled="">
                          </div>
                        </div>
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" value="<?php echo e($item->maturity_date); ?>" disabled="">
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="matured_on_date" class="form-control" id="matured_on_date_cal" value="<?php echo e($item->status == 1 ? date('Y-m-d') : $item->matured_on_date); ?>" readonly="readonly">
                            <span class="color-pwd" id="matured_on_date"></span>
                          </div>
                        </div>
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled="">
                              <option value=""><?php echo e($item->interest_type); ?></option>
                            </select>
                          </div>
                        </div>
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Amount
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->maturity_amount); ?>" name="maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>
                                <!-- Email input-->
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled="">
                              <option value=""><?php echo e($item->type_of_deposite); ?></option>
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
                                    <div class="col-md-12 text-right btn-group-md">
                                        <?php if($item->status == 1): ?>
                                        <button type="submit" class="btn btn-danger btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Mature</button>
                                        <input type="hidden" name="fdStatus" value="0">
                                        <?php else: ?>
                                        <button type="submit" class="btn btn-success btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> UnMature</button>
                                        <input type="hidden" name="fdStatus" value="1">
                                        <?php endif; ?>

                                        <button type="button" id="show_renew_btn" class="btn btn-warning btn_sizes"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</button>

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
                            <span>Renew Bank FD Detail</span>
                        </h3>
                    </div>

                    <div class="panel-body hide" style="height: 921px;" id="renew_fd_area">
                    <form method="post" action="<?php echo e(TRANSACTION_URL_BANK_FD_AC.''.$item->id.'/renew'); ?>" id="mature_fd_frm" class="form-horizontal form-label-left">
                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('PUT')); ?>

                    <input type="hidden" name="ajax_url" value="<?php echo e(url('transaction/fixed-deposite/blur')); ?>" id="ajax_url">
                    <input type="hidden" name="old_amount">
                    <input type="hidden" name="old_matured_on_date">
                    <input type="hidden" name="old_maturity_amount">
                             <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Branch</label>
                                    <div class="col-md-9">
                                     <select class="form-control" disabled="">
                                        <option value=""><?php echo e($item->branch_model->name); ?></option>
                                        </select>
                                      </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Bank</label>
                                    <div class="col-md-9">
                                    <select class="form-control" disabled="">
                                        <option value=""><?php echo e(@$item->bank_model->name); ?></option>
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
                                        <input type="text" name="fd_no" value="<?php echo e($item->fd_no); ?>" class="form-control" readonly="">
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Amount</label>
                                    <div class="col-md-9">
                                      <input type="text" name="amount" value="<?php echo e($item->maturity_amount); ?>" class="form-control" readonly="">
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Rate (%)
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->int_rate); ?>" class="form-control" readonly="">
                          </div>
                        </div>
<!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" value="<?php echo e($item->maturity_date); ?>" disabled="">
                          </div>
                        </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-9">
                                     <input type="text" class="form-control" value="<?php echo e($item->status == 1 ? date('Y-m-d') : $item->matured_on_date); ?>" disabled="">
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Period of FD (Month)
                          </label>
                          <div class="col-md-9">
                            <input type="text"  value="<?php echo e($item->period_fd); ?>" class="form-control" disabled="">
                          </div>
                        </div>
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" value="<?php echo e($item->maturity_date); ?>" disabled="">
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="matured_on_date" class="form-control" id="matured_on_date_cal" value="<?php echo e($item->status == 1 ? date('Y-m-d') : $item->matured_on_date); ?>" readonly="readonly">
                            <span class="color-pwd" id="matured_on_date"></span>
                          </div>
                        </div>
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled="">
                              <option value=""><?php echo e($item->interest_type); ?></option>
                            </select>
                          </div>
                        </div>
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Amount
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->maturity_amount); ?>" name="maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>
                                <!-- Email input-->
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled="">
                              <option value=""><?php echo e($item->type_of_deposite); ?></option>
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
                                    <div class="col-md-12 text-right btn-group-md">
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbarin.himachalsociety.com/resources/views/Transaction/Bank_FD_Ac/matured.blade.php ENDPATH**/ ?>