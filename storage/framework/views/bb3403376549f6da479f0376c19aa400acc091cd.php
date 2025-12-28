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
    <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>rd-installment-request.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
    <script src="<?php echo e(ASSETS_JS); ?>saving_ac.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
    <aside class="right-side strech">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!--section starts-->
            <h1>RD A/c</h1>
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
                                RD A/C
                            </h3>
                        </div>

                        <div class="panel-body">
                            <form method="post" action="<?php echo e(route('transaction.rd.installment.record.submit')); ?>" id="post_frm" class="form-horizontal form-label-left">
                                <?php echo e(csrf_field()); ?>


                                <input type="hidden" name="open_ac_id" id="open_ac_id" value="<?php echo e(@$_REQUEST['open_ac_id']); ?>">
                                <input type="hidden" name="ajax_url" value="<?php echo e(route('transaction.rd.installment.record')); ?>" id="ajax_url">
                                <fieldset>
                                    <!-- Name input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="password">RD No.</label>
                                        <div class="col-md-8">
                                            <input type="text" name="rd_no" class="form-control" onblur="getRdRecord(this.value)" value="<?php echo e(request()->get('rdNo')); ?>">
                                            <span class="color-pwd" id="rd_no"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="memberType">Member Type</label>
                                        <div class="col-md-8">
                                            <input type="text" name="memberType" class="form-control" value="<?php echo e(@$memberType); ?>" readonly>
                                            <span class="color-pwd" id="memberType"></span>
                                        </div>
                                    </div>
                                    <!-- Email input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="accountNo">A/c No.</label>
                                        <div class="col-md-8">
                                            <input type="text" name="accountNo" class="form-control" value="<?php echo e(@$accountNo); ?>" readonly>
                                            <span class="color-pwd" id="accountNo"></span>
                                        </div>
                                    </div>
                                    <!-- Email input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="password">Amount</label>
                                        <div class="col-md-8">
                                            <input type="text" name="amount" class="form-control col-md-7 col-xs-12"  onkeypress="return isNumberKey(event)" >
                                            <span class="color-pwd" id="amount"></span>
                                        </div>
                                    </div>
                                    <!-- Email input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="password">Date of Transaction</label>
                                        <div class="col-md-8">
                                            <input type="date" name="date_of_transaction" class="form-control" value="<?php echo e(request()->get('date_of_transaction') ?? date('Y-m-d')); ?>">
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
                                            <span class="color-pwd" id="mode_of_transaction"></span>
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
                                                <button type="submit" class="btn btn-success btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
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

                        <div class="panel-body" style="overflow-y:auto; height: 521px;">
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
                                        <td style="display: block; height: 320px; overflow-y: scroll;">
                                            <table class="table table-bordered table-hover">
                                                <tbody id="success_part">
                                                <tr>
                                                    <th>Branch</th>
                                                    <td id="branch"><?php echo e(@$branch); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Member Name</th>
                                                    <td id="memberName"><?php echo e(@$memberName); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Father Name</th>
                                                    <td id="fatherName"><?php echo e(@$fatherName); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td id="address"><?php echo e(@$address); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>L/F No.</th>
                                                    <td id="lfNo"><?php echo e(@$lfNo); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Amount</th>
                                                    <td>
                                                        <i class="fa fa-fw fa-inr"></i><span id="rdAmount"><?php echo e(@$rdAmount); ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Interest Rate (%)</th>
                                                    <td id="interestRate"><?php echo e(@$interestRate); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>RD Dated</th>
                                                    <td id="rdDate"><?php echo e(@$rdDate); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Period of RD (Month)</th>
                                                    <td id="periodOfRd"><?php echo e(@$periodOfRd); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Maturity Date</th>
                                                    <td id="maturityDate"><?php echo e(@$maturityDate); ?></td>
                                                </tr><tr>
                                                    <th>Matured on Date</th>
                                                    <td id="maturedOnDate"><?php echo e(@$maturedOnDate); ?></td>
                                                </tr><tr>
                                                    <th>Maturity Amount</th>
                                                    <td>
                                                        <i class="fa fa-fw fa-inr"></i><span id="maturityAmount"><?php echo e(@$maturityAmount); ?></span>
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
                                                <th>Installment Date</th>
                                                <th>Amount<i class="fa fa-fw fa-inr"></i></th>
                                                <th>Balance<i class="fa fa-fw fa-inr"></i></th>
                                            </tr>
                                            </thead>
                                            <tbody class="loadTableData">
                                            <?php $bal = 0; ?>

                                            <?php $__currentLoopData = $transactionList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(\Carbon\Carbon::parse($list->installment_date)->format('d-M-Y')); ?></td>
                                                    <td><?php echo e($list->amount); ?></td>
                                                    <td><?php echo e($bal = $bal + $list->amount); ?></td>
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
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Transaction/RD_Ac/rd-installment.blade.php ENDPATH**/ ?>