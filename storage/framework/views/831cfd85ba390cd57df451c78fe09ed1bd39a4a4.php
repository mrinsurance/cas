<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
  <link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
  <link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/all.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo e(ASSETS_CSS); ?>pages/form2.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(ASSETS_VENDORS); ?>datatables/css/dataTables.bootstrap.css" />
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
  <script type="text/javascript" src="<?php echo e(ASSETS_VENDORS); ?>datatables/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_VENDORS); ?>datatables/js/dataTables.bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_SRC_JS); ?>pages/table-responsive.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>favicon/favicon.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>pages/form_examples.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>rd-blur-request.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>rd-installment.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>bootbox.min.js"></script>
  <script src="<?php echo e(asset('assets/js/deleterd.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>RD No. - <?php echo e($item->rd_no); ?> / Member A/C No. - <?php echo e($item->account_no); ?> /  (<?php echo e($ac_holder->full_name); ?>)</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(TRANSACTION_URL_RD_AC); ?>"> RD A/C List </a>
            </li>
            <li class="active">Installment</li>
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
                            Recurring Deposit A/C / Installment
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="<?php echo e(TRANSACTION_URL_POST_RD_INSTALLMENT); ?>" id="post_frm" class="form-horizontal form-label-left">
                    <?php echo e(csrf_field()); ?>

                    <!-- <input type="hidden" name="ajax_url" value="<?php echo e(url('transaction/recurring-deposite/blur')); ?>" id="ajax_url"> -->
                    <input type="hidden" name="rd_id" value="<?php echo e($item->id); ?>">
                    <input type="hidden" name="member_type_id" value="<?php echo e($item->member_type_model_id); ?>">
                    <input type="hidden" name="account_no" value="<?php echo e($item->account_no); ?>">
                    <input type="hidden" name="rd_no" value="<?php echo e($item->rd_no); ?>">
                    <input type="hidden" name="back_url" value="<?php echo e(Request::fullUrl()); ?>">
                    <input type="hidden" name="rd_monthly_amount" id="rd_monthly_amount" value="<?php echo e($item->amount); ?>">
                    <input type="hidden" name="paid_install" value="<?php echo e($total_paid_install); ?>">
                    <input type="hidden" name="period_rd" value="<?php echo e($item->period_rd); ?>">
                            <fieldset>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Installment Date</label>
                                    <div class="col-md-8">
                                     <input type="date" name="installment_date" class="form-control col-md-7 col-xs-12" id="date_installment" value="<?php echo e(date('Y-m-d')); ?>">
                                      <span class="color-pwd" id="installment_date"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Amount</label>
                                    <div class="col-md-8">
                                      <input type="text" name="amount" class="form-control col-md-7 col-xs-12" id="inst_amount" onkeypress="return isNumberKey(event)" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">No. of Installment</label>
                                    <div class="col-md-8">
                                      <input type="text" name="no_of_installment" class="form-control col-md-7 col-xs-12" id="installs_no" onkeypress="return isNumberKey(event)" readonly>
                                      <span class="color-pwd" id="no_of_installment"></span>
                                      </div>
                                </div>
                               <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3 text-center">
                                       <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 text-left">
                                      <h4 class="color-pwd">Installment Received - <?php echo e($total_paid_install); ?></h4 class="color-pwd">
                                    </div>
                                    <div class="col-md-6 text-right btn-group-md">
                                        <?php if(!$CheckLock): ?>
                                        <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </fieldset>
                        </form>

                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Installment Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $bal = 0;
                                        $i = 1; $ct = count($installs);
                                   ?>
                                    <?php $__currentLoopData = $installs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr id="product<?php echo e($val->id); ?>">
                                        <td><?php echo e($loop->index + 1); ?></td>
                                        <td><?php echo e(date('d-M-Y',strtotime($val->installment_date))); ?></td>
                                        <td><?php echo e($val->amount); ?></td>
                                        <td><?php echo e($bal = $bal + $val->amount); ?></td>
                                        <td>
                                            <?php if(!$CheckLock): ?>
                                          <a href="<?php echo e(TRANSACTION_URL_RD_AC.''.$val->id); ?>/print" target="_blank" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i></a>

                                          <button type="button" title="Delete"  class="btn btn-danger delete-product" value="<?php echo e(TRANSACTION_URL_RD_AC.''.$val->id); ?>">
                                            <i class="fa fa-power-off"></i>

                                            <?php endif; ?>
                                        </td>
                                      </tr>
                                       <?php $i++; ?>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
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
                  <div class="panel-body">
                      <div class="table-scrollable">
                              <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Branch</th>
                                      <td><?php echo e(@$ac_holder->branch_model->name); ?></td>
                                  </tr>
                                  <tr>
                                      <th>Member Type</th>
                                      <td><?php echo e(@$item->member_type_model->name); ?></td>
                                  </tr>
                                  <tr class="color-pwd">
                                      <th>A/C No.</th>
                                      <td><?php echo e($item->account_no); ?></td>
                                  </tr>
                                  <tr class="color-pwd">
                                    <th>Member Name</th>
                                      <td><?php echo e($ac_holder->full_name); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td><?php echo e($ac_holder->father_name); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td><?php echo e(@$ac_holder->village.' '.@$ac_holder->post_office.' '.@$ac_holder->district_model->name.' - ('.@$ac_holder->state_model->name.')'); ?></td>
                                  </tr>
                                  <tr>
                                    <th>RD No.</th>
                                      <td><?php echo e($item->rd_no); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Amount</th>
                                      <td><i class="fa fa-fw fa-inr"></i><?php echo e($item->amount); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Interest Rate (%)</th>
                                      <td><?php echo e($item->int_rate); ?></td>
                                  </tr>
                                  <tr>
                                    <th>RD Dated</th>
                                      <td><?php echo e($item->transaction_date); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Period of RD (Month)</th>
                                      <td><?php echo e($item->period_rd); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Maturity Date</th>
                                      <td><?php echo e($item->maturity_date); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Matured on Date</th>
                                      <td><?php echo e($item->matured_on_date); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Maturity Amount</th>
                                      <td><i class="fa fa-fw fa-inr"></i><?php echo e($item->maturity_amount); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Nominee Name</th>
                                      <td><?php echo e($item->nominee_name); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Nominee Relation</th>
                                      <td><?php echo e($item->nominee_relation); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Ledger Folio</th>
                                      <td><?php echo e($item->lf_no); ?></td>
                                  </tr>
                                  <tr>
                                    <th>Status</th>
                                      <td>
                                        <?php if($item->status == 1): ?>
                                        <span class="text-success">Active</span>
                                        <?php else: ?>
                                        <span class="color-pwd">Matured</span>
                                        <?php endif; ?>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/Transaction/RD_Ac/installment.blade.php ENDPATH**/ ?>