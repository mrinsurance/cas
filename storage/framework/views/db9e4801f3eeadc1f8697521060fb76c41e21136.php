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
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>mis-blur-request.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>mis-deposit.js"></script>

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
                <a href="<?php echo e(TRANSACTION_URL_MIS_AC); ?>"> MIS A/C List </a>
            </li>
            <li class="active">View</li>
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
                            MIS A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                      <form method="post" action="#" class="form-horizontal form-label-left">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Member Type</label>
                                    <div class="col-md-8">
                                      <select name="member_type_model_id" class="form-control" disabled>
                                          <?php $__currentLoopData = $membertypes->where('id',$item->member_type_model_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                        </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" name="account_no" id="ac_no" class="form-control ac_no" value="<?php echo e($item->account_no); ?>" disabled>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4" for="first-name">MIS No.
                                      </label>
                                      <div class="col-md-8">
                                        <input type="text" value="<?php echo e($item->mis_no); ?>" name="mis_no" class="form-control" disabled>
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Amount</label>
                                    <div class="col-md-8">
                                      <input type="text" name="amount" class="form-control amount" onkeypress="return isNumberKey(event)" value="<?php echo e($item->amount); ?>" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Interest Rate (%)
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="interest_rate" class="form-control interest_rate" onkeypress="return isNumAndDecimalKey(event)" value="<?php echo e($item->int_rate); ?>">
                            <span class="color-pwd" id="interest_rate"></span>
                          </div>
                        </div>   
                        
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">MIS Dated</label>
                                    <div class="col-md-8">
                                     <input type="date" name="mis_date" class="form-control" id="mis_start_date" value="<?php echo e($item->start_date); ?>">
                                      <span class="color-pwd" id="mis_date"></span>
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Period of MIS (Month)
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="period_of_mis" class="form-control term" id="month_of_period" onkeypress="return isNumberKey(event)" value="<?php echo e($item->period_of_mis); ?>">
                            <span class="color-pwd" id="period_of_mis"></span>
                          </div>
                        </div> 
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="maturity_date" class="form-control" id="maturity_date_cal" value="<?php echo e($item->maturity_date); ?>" readonly>
                            <span class="color-pwd" id="maturity_date"></span>
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="matured_on_date" class="form-control" id="matured_on_date_cal" value="<?php echo e($item->matured_on_date); ?>" readonly>
                            <span class="color-pwd" id="matured_on_date"></span>
                          </div>
                        </div> 
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Amount
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)" value="<?php echo e($item->maturity_amount); ?>">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Interest
                          </label>
                          <div class="col-md-4">
                            Total Interest
                            <input type="text" name="total_interest" class="form-control total_interest" onkeypress="return isNumberKey(event)" value="<?php echo e($item->total_interest); ?>">
                            <span class="color-pwd" id="total_interest"></span>
                          </div>
                          <div class="col-md-4">
                            Monthly Installment
                            <input type="text" name="monthly_installment" class="form-control monthly_installment" onkeypress="return isNumberKey(event)" value="<?php echo e($item->monthly_installment); ?>">
                            <span class="color-pwd" id="monthly_installment"></span>
                          </div>
                        </div>                         
<!-- Nominee Name -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Nominee Name
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="nominee_name" class="form-control" value="<?php echo e($item->nominee_name); ?>">
                            <span class="color-pwd" id="nominee_name"></span>
                          </div>
                        </div> 
<!-- Nominee Relation -->
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Nominee Relation
                          </label>
                          <div class="col-md-8">
                            <select name="nominee_relation" class="form-control">
                              <?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e($val == $item->nominee_relation ? 'selected' : ''); ?>><?php echo e($val); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="color-pwd" id="nominee_relation"></span>
                          </div>
                        </div>
                        <div class="form-group">
                                    <div class="col-md-12 text-right btn-group-md">
                                        <?php if(!$CheckLock): ?>
                                        <a class="btn btn-success btn_sizes" target="_blank" href="<?php echo e(TRANSACTION_URL_MIS_AC.'print-pdf/'.$item->id.'/'.$item->token); ?>"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
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

                  <div class="panel-body"  style="overflow-y:auto; height: 199px;">
                      <div class="table-scrollable">
                              <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Branch</th>
                                      <td><?php echo e($user_detail->branch_model->name); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td><?php echo e($user_detail->full_name); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td><?php echo e($user_detail->father_name); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td><?php echo e($user_detail->village); ?> <?php echo e($user_detail->post_office); ?> <?php echo e($user_detail->district_model->name); ?> (<?php echo e($user_detail->state_model->name); ?>)</td>
                                  </tr>
                                  
                              </tbody>
                          </table>
                      </div>
                  </div>
                </div>

                <div class="panel panel-primary" id="hidepanel2">
                  <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="address-book" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <span>Installments</span>
                        </h3>
                    </div>

                  <div class="panel-body">
                      <div class="hide text-center" id="error_part">
                        <h4><span id="error_result" class="color-pwd"></span></h4>
                      </div>
                      <?php if($message = Session::get('success')): ?>
                      <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong><?php echo e($message); ?></strong>
                      </div>
                      <?php endif; ?>
                      <!-- Installment table                       -->
                      <form class="form-horizontal" action="<?php echo e(TRANSACTION_URL_MIS_AC); ?>interest" id="post_frm" method="post"> 
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="account_no" value="<?php echo e($user_detail->account_no); ?>">
                        <input type="hidden" name="accound_id" value="<?php echo e($user_detail->id); ?>">
                        <input type="hidden" name="holder_name" value="<?php echo e($user_detail->full_name); ?>">
                        <input type="hidden" name="branch" value="<?php echo e($user_detail->branch_model_id); ?>">
                        <input type="hidden" name="member_type" value="<?php echo e($user_detail->member_type_model_id); ?>">
                        <input type="hidden" name="mis_id" value="<?php echo e($item->id); ?>">
                        Interest Paid Date <input type="date" name="paid_date" class="form-control" value="<?php echo e($date); ?>">

                      <div class="table-scrollable" style="overflow-y:auto; height: 397px;">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>#</th>
                                      <th>Date</th>
                                      <th>Amount</th>
                                      <th>Status</th>                          
                                  </tr> 
                                  <tbody id="userTable">
                                    <?php $__currentLoopData = $mis_installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td align="center"><?php echo e($loop->index + 1); ?></td>
                                        <td align="center"><?php echo e($val->installment_date); ?></td>
                                        <td align="center"><?php echo e($val->monthly_installment); ?></td>
                                        <td align="center">
                                          <?php if($val->status == 0): ?>
                                          <button class="btn btn-danger btn-sm" name="installment_id" value="<?php echo e($val->id); ?>" type="submit">Unpaid</button>
                                          <?php else: ?>
                                          <button type="button" class="btn btn-success btn-sm">Paid</button>
                                          <?php endif; ?>
                                        </td>
                                      </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </tbody>                                
                              </tbody>
                          </table>
                      </div>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbara/resources/views/Transaction/MIS_Ac/edit.blade.php ENDPATH**/ ?>