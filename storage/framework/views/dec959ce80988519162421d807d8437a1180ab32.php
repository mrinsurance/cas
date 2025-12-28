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
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>edit-record.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>blur-request.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>fixed-deposit.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>FD A/c of - <?php echo e($customer->full_name); ?> A/C No. -  <?php echo e($item->account_no); ?></h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(TRANSACTION_URL_FD_AC); ?>"> FD A/C List </a>
            </li>
            <li class="active">Edit</li>
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
                    <form method="post" action="<?php echo e(TRANSACTION_URL_FD_AC.''.$item->id); ?>" id="edit_frm" class="form-horizontal form-label-left">
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
                                            <option value="<?php echo e($val->id); ?>" <?php echo e($val->id == $item->member_type_model_id ? 'selected' : ''); ?>><?php echo e($val->name ?? ''); ?></option>
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
                                      <label class="control-label col-md-3" for="first-name">FD No. <span class="color-pwd">*</span>
                                      </label>
                                      <div class="col-md-9">
                                        <input type="text" name="fd_no" value="<?php echo e($item->fd_no); ?>" class="form-control" onkeypress="return isNumberKey(event)">
                                        <span class="color-pwd" id="fd_no"></span>
                                      </div>
                                    </div>
                                    
                                    
                                    
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Amount <span class="color-pwd">*</span></label>
                                    <div class="col-md-9">
                                      <input type="text" value="<?php echo e($item->amount); ?>" name="amount" class="form-control amount" onkeypress="return isNumberKey(event)" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Rate (%) <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="<?php echo e($item->int_rate); ?>" name="interest_rate" class="form-control interest_rate" onkeypress="return isNumAndDecimalKey(event)" >
                            <span class="color-pwd" id="interest_rate"></span>
                          </div>
                        </div>
                                <!-- Paid Interest -->
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="PaidInterest">Paid Interest
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" name="PaidInterest" class="form-control" value="<?php echo e($item->paid_interest); ?>" onkeypress="return isNumAndDecimalKey(event)" >
                                        <span class="color-pwd" id="PaidInterest"></span>
                                    </div>
                                </div>
                                <!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="interest_run_from" class="form-control" id="int_from_date"  value="<?php echo e($item->int_run_from); ?>" readonly="readonly">
                            <span class="color-pwd" id="interest_run_from"></span>
                          </div>
                        </div>                        
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-9">
                                     <input type="text" name="transaction_date" class="form-control" id="int_on_date" value="<?php echo e($item->transaction_date); ?>" readonly="readonly">
                            <span class="color-pwd" id="transaction_date"></span>
                                      <span class="color-pwd" id="transaction_date"></span>
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Period of FD (Month) <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text"  value="<?php echo e($item->period_fd); ?>" name="period_of_fd" class="form-control" id="month_of_period" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="period_of_fd"></span>
                          </div>
                        </div> 
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="maturity_date" class="form-control" id="maturity_date_cal"  value="<?php echo e($item->maturity_date); ?>" readonly>
                            <span class="color-pwd" id="maturity_date"></span>
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="matured_on_date" class="form-control" id="matured_on_date_cal" value="<?php echo e($item->matured_on_date); ?>" readonly>
                            <span class="color-pwd" id="matured_on_date"></span>
                          </div>
                        </div> 
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-9">
                            <select name="type_of_interest" class="form-control type_of_interest">
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
                            <input type="text" value="<?php echo e($item->maturity_amount); ?>" name="maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>                         
                                                                                                     
                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Mode of Transaction 
                                    </label>
                                    <div class="col-md-6">
                                      <label class="radio-inline">
                                        &nbsp;<input type="radio" name="mode_of_transaction" value="Cash" <?php echo e($item->mode_transaction == 'Cash' ? 'checked' : ''); ?>>Cash
                                      </label>
                                      <label class="radio-inline">
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" disabled name="mode_of_transaction" value="Cheque" <?php echo e($item->mode_transaction == 'Cheque' ? 'checked' : ''); ?>>Cheque
                                      </label>
                                     <span class="color-pwd" id="mode_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <!-- Cheque Detail                                 -->
                                <div id="cheque_mode" class="hide">
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Cheque Date</label>
                                    <div class="col-md-9">
                                      <input type="text" name="cheque_date" class="form-control" id="date_of_cheque"  value="<?php echo e($item->cheque_date); ?>" readonly="readonly" disabled>
                                      <span class="color-pwd" id="cheque_date"></span>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Cheque No.</label>
                                    <div class="col-md-9">
                                      <input type="text" value="<?php echo e($item->cheque_no); ?>" name="cheque_number" class="form-control cheque_number" onkeypress="return isNumberKey(event)"  disabled>
                                      <span class="color-pwd" id="cheque_number"></span>
                                    </div>
                                  </div>
                                </div>
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-9">
                            <select name="type_of_deposit" class="form-control">
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
                            <input type="text" value="<?php echo e($item->nominee_name); ?>" name="nominee_name" class="form-control">
                            <span class="color-pwd" id="nominee_name"></span>
                          </div>
                        </div> 
<!-- Nominee Relation -->
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Relation <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <select name="nominee_relation" class="form-control">
                                <?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e($val == $item->nominee_relation ? 'selected' : ''); ?>><?php echo e($val); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                            </select>
                            <span class="color-pwd" id="nominee_relation"></span>
                          </div>
                        </div>
<!-- LF No -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Ledger Folio
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="lf_no" value="<?php echo e($item->lf_no); ?>" class="form-control">
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
                                        <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
                                        <a class="btn btn-success btn_sizes" target="_blank" href="<?php echo e(TRANSACTION_URL_FD_AC.'print-pdf/'.$item->id.'/'.$item->token); ?>"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
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

                  <div class="panel-body" style="height: 995px;">
                      <div class="table-scrollable">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <td><div class="thumbnail "><img src="<?php echo e(PREFIX1.''.$customer->file); ?>" alt="" width="150" class="img-responsive"></div></td>
                                      <td><div class="thumbnail"><img src="<?php echo e(PREFIX1.''.$customer->signature); ?>" alt="" width="150" class="img-responsive"></div></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Branch</th>
                                      <td><?php echo e($customer->branch_model->name ?? ''); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td><?php echo e($customer->full_name); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td><?php echo e($customer->father_name); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td><?php echo e($customer->village); ?> <?php echo e($customer->post_office); ?> <?php echo e($customer->district_model->name ?? ''); ?> (<?php echo e($customer->state_model->name ?? ''); ?>)</td>
                                  </tr>
                                   <tr>
                                    <th>Ledger Folio</th>
                                      <td><?php echo e($item->lf_no); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Available Balance</th>
                                      <td><span class="color-pwd"><i class="fa fa-fw fa-inr"></i><?php echo e(number_format($balance,2)); ?> </span></td>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbara/resources/views/Transaction/FD_Ac/edit.blade.php ENDPATH**/ ?>