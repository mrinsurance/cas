<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
    <link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(ASSETS_VENDORS); ?>x-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(ASSETS_CSS); ?>pages/user_profile.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(ASSETS_CSS); ?>pages/tables.css" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>


<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
<section class="content-header">
        <!--section starts-->
        <h1>Profile - <?php echo e($item->member_type_model->name); ?> A/C No. -  <?php echo e($item->account_no); ?> (<?php echo e($item->full_name); ?>)</h1>
        <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(HOME_LINK); ?>">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
            </a>
        </li>
        <li>
                <a href="<?php echo e(TRANSACTION_URL_OPEN_NEW_AC); ?>"> A/C List </a>
            </li>
            <li class="active">View A/c</li>
        </ol>
    </section>
            <!--section ends-->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav  nav-tabs ">
                            <li class="active">
                                <a href="#tab1" data-toggle="tab">
                                    <i class="livicon" data-name="address-book" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i> General Detail</a>
                            </li>
                            <li>
                                <a href="#tab2" data-toggle="tab">
                                    <i class="livicon" data-name="pin-off" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i> Address</a>
                            </li>
                            <li>
                                <a href="#tab3" data-toggle="tab">
                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i> Other Detail</a>
                            </li>
                        </ul>
                        <div class="tab-content mar-top">
                            <div id="tab1" class="tab-pane fade active in">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel">
                                           
                                            <div class="panel-body">
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <div class="fileinput">
                                                            <div class="thumbnail">
                                                                <img src="<?php echo e(PREFIX1.''.$item->file); ?>" width="200" class="img-responsive"  alt="SMBNL">
                                                            </div>
                                                        </div>
                                                        <div class="fileinput">
                                                            <div class="thumbnail">
                                                                
                                                                <img src="<?php echo e(PREFIX1.''.$item->signature); ?>" width="200" class="img-responsive"  alt="SMBNL">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">                                
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th>Branch Name</th>
                                                                <td><?php echo e($item->branch_model->name); ?></td>
                                                                <th>Member Type</th>
                                                                <td><?php echo e($item->member_type_model->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>A/C No.</th>
                                                                <td><?php echo e($item->account_no); ?></td>
                                                                <th>Type of Account</th>
                                                                <td><?php echo e($item->ac_type_model->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>A/C Opening Date</th>
                                                                <td><?php echo e(date('d-M-Y',strtotime($item->ac_opening_date))); ?></td>
                                                                <th>A/C Opening Amount</th>
                                                                <td><?php echo e($item->ac_opening_amount); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Gaurdian Name</th>
                                                                <td><?php echo e($item->gaurdian_name); ?></td>
                                                                <th>Gaurdian Aadhar</th>
                                                                <td><?php echo e($item->gaurdian_aadhar); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Gaurdian PAN</th>
                                                                <td><?php echo e($item->gaurdian_pan); ?></td>
                                                                <th>Gaurdian Mobile</th>
                                                                <td><?php echo e($item->gaurdian_mobile); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Member Name</th>
                                                                <td><?php echo e($item->full_name); ?></td>
                                                                <th>Father Name</th>
                                                                <td><?php echo e($item->father_name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Mother Name</th>
                                                                <td><?php echo e($item->mother_name); ?></td>
                                                                <th>Date Of Birth</th>
                                                                <td><?php echo e(date('d-M-Y',strtotime($item->dob))); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Gender</th>
                                                                <td><?php echo e($item->gender); ?></td>
                                                                <th>Marital Satus</th>
                                                                <td><?php echo e($item->marital); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Husband/Wife Name</th>
                                                                <td><?php echo e($item->husband_name); ?></td>
                                                                <th>Aadhar</th>
                                                                <td><?php echo e($item->aadhar); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>PAN</th>
                                                                <td><?php echo e($item->pan); ?></td>
                                                                <th>Mobile</th>
                                                                <td><?php echo e($item->contact_no); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Email</th>
                                                                <td><?php echo e($item->email); ?></td>
                                                                <th>Relegion</th>
                                                                <td><?php echo e($item->relegion); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Cast Category</th>
                                                                <td><?php echo e($item->category); ?></td>
                                                                <th>Status</th>
                                                                <td><?php echo e($item->status == 1 ? 'Active' : 'Deactive'); ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>             
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab2" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <h3>Current Address</h3>
                                                    <table class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th>Address Line 1</th>
                                                                <td><?php echo e($item->current_address_first); ?></td>
                                                                <th>Village / City</th>
                                                                <td><?php echo e($item->village); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tehsil</th>
                                                                <td><?php echo e($item->tehsil); ?></td>
                                                                <th>District</th>
                                                                <td><?php echo e(@$item->district_model->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>State</th>
                                                                <td><?php echo e(@$item->state_model->name); ?></td>
                                                                <th>Pin Code</th>
                                                                <td><?php echo e($item->pin_code); ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                <h3>Permanent Address</h3>
                                                    <table class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th>Address Line 1</th>
                                                                <td><?php echo e($item->perm_address_first); ?></td>
                                                                <th>Village / City</th>
                                                                <td><?php echo e($item->perm_village); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tehsil</th>
                                                                <td><?php echo e($item->perm_tehsil); ?></td>
                                                                <th>District</th>
                                                                <td><?php echo e(@$permanent_dist->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>State</th>
                                                                <td><?php echo e(@$permanent_state->name); ?></td>
                                                                <th>Pin Code</th>
                                                                <td><?php echo e($item->perm_pin_code); ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                            
                                                </div>  
                                    </div>
                                </div>
                            </div>
                            <div id="tab3" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th>Occupation</th>
                                                                <td><?php echo e($item->occupation); ?></td>
                                                                <th>Education Qualification</th>
                                                                <td><?php echo e($item->education); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Preferred Language</th>
                                                                <td><?php echo e($item->language); ?></td>
                                                                <th>Nationality</th>
                                                                <td><?php echo e($item->nationality); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Residence Type</th>
                                                                <td><?php echo e($item->residence_type); ?></td>
                                                                <th>Vehicle</th>
                                                                <td><?php echo e($item->vehicle); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Purpose of Opening A/C</th>
                                                                <td><?php echo e($item->open_ac_purpose); ?></td>
                                                                <th>Annual Income</th>
                                                                <td><?php echo e($item->annual_income); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Passport No.</th>
                                                                <td><?php echo e($item->passport); ?></td>
                                                                <th>Validity of Passport</th>
                                                                <td><?php echo e($item->passport_validity); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nominee Name</th>
                                                                <td><?php echo e($item->nominee_name); ?></td>
                                                                <th>Nominee Address</th>
                                                                <td><?php echo e($item->nominee_address); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nominee Relation</th>
                                                                <td><?php echo e($item->nominee_relation); ?></td>
                                                                <th>Nominee DOB</th>
                                                                <td><?php echo e(date('d-M-Y',strtotime($item->nominee_dob))); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Agent Code</th>
                                                                <td><?php echo e($item->agent_name); ?></td>
                                                                <th>Agent Name</th>
                                                                <td><?php echo e(@$agent_name->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Ward</th>
                                                                <td><?php echo e($item->ward); ?></td>
                                                                <th>L/F No.</th>
                                                                <td><?php echo e($item->lf_no); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Ledger No.</th>
                                                                <td><?php echo e($item->ledger_no); ?></td>
                                                                <th>Page No.</th>
                                                                <td><?php echo e($item->page_no); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Document</th>
                                                                <td><a href="<?php echo e(url(MEMBER_DOC.''.$item->document)); ?>" target="_blank"><?php echo e($item->document); ?></a></td>
                                                                <th></th>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                            
                                                </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    <!-- content --> </aside>
<!-- right-side -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Transaction/Open_New_Ac/view.blade.php ENDPATH**/ ?>