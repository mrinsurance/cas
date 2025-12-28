<?php $__env->startPush('extra_meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title','DashBoard | Cyrus Banking'); ?>

<?php $__env->startPush('extra_css'); ?>
  <link href="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet">
  <link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/all.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo e(ASSETS_CSS); ?>pages/form_layouts.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo e(ASSETS_CSS); ?>pages/form2.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo e(ASSETS_CSS); ?>jquery-ui.css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js'); ?>
  <script src="<?php echo e(ASSETS_VENDORS); ?>jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>pages/form_layouts.js"></script>
  <script type="text/javascript" src="<?php echo e(ASSETS_JS); ?>form-post.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>changestate.js"></script>
  <script src="<?php echo e(ASSETS_JS); ?>open_new_ac.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
 <!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Hello Admin</h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(HOME_LINK); ?>">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(TRANSACTION_URL_OPEN_NEW_AC); ?>"> A/C List </a>
            </li>
            <li class="active">Create</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Open New A/C
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?php echo e(TRANSACTION_URL_POST_OPEN_NEW_AC); ?>" id="post_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                            <div class="form-body">
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Branch Name <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select name="branch_name"  class="form-control">
                                        <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                     <span class="color-pwd" id="branch_name"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Member Type <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select name="member_type_model_id"  class="form-control">
                                        <?php $__currentLoopData = $membertypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                     <span class="color-pwd" id="member_type_model_id"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        A/C No. <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                       <input type="text" name="account_no" placeholder="Account number" class="form-control">
                                       <span class="color-pwd" id="account_no"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        A/C Opening Date <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                       <!-- <input type="text" name="ac_opening_date" placeholder="yyyy-mm-dd" class="form-control" id="opening_date_ac" readonly> -->
                                       <input type="date" name="ac_opening_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                                       <span class="color-pwd" id="ac_opening_date"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        A/C Opening Amount <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                       <input type="text" name="ac_opening_amount" placeholder="A/C Opening Amount" class="form-control" onkeypress="return isNumberKey(event)">
                                       <span class="color-pwd" id="ac_opening_amount"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Type of Account <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select name="type_of_account"  class="form-control type_of_account">
                                      <option value="">--- Select ---</option>
                                       <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                    </select>
                                    <span class="color-pwd" id="type_of_account"></span>
                                    </div>
                                </div>

                                <!-- Gaurdian Details -->
                                <div class="form-group hide" id="gaurdian_account">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Gaurdian Detail</h4>
                                        </div>
                                        <div class="panel-body">
                                            <!-- Form Group                               -->
                                            <div class="form-group">
                                                <label for="inputUsername" class="col-md-4 control-label">
                                                    Gaurdian Name <span class="color-pwd">*</span>
                                                </label>
                                                <div class="col-md-6">
                                                   <input type="text" name="gaurdian_name" placeholder="Gaurdian Name" disabled class="form-control"><span class="color-pwd" id="gaurdian_name"></span>
                                                </div>
                                            </div>
                                            <!-- Form Group                               -->
                                            <div class="form-group">
                                                <label for="inputUsername" class="col-md-4 control-label">
                                                    Gaurdian Aadhar
                                                </label>
                                                <div class="col-md-6">
                                                   <input type="text" name="gaurdian_aadhar" placeholder="Gaurdian Aadhar" disabled class="form-control" onkeypress="return isNumberKey(event)" maxlength="12">
                                                   <span class="color-pwd" id="gaurdian_aadhar"></span>
                                                </div>
                                            </div>
                                            <!-- Form Group                               -->
                                            <div class="form-group">
                                                <label for="inputUsername" class="col-md-4 control-label">
                                                    Gaurdian PAN
                                                </label>
                                                <div class="col-md-6">
                                                   <input type="text" name="gaurdian_pan" placeholder="Gaurdian PAN" disabled class="form-control" maxlength="10">
                                                   <span class="color-pwd" id="gaurdian_pan"></span>
                                                </div>
                                            </div>
                                            <!-- Form Group                               -->
                                            <div class="form-group">
                                                <label for="inputUsername" class="col-md-4 control-label">
                                                    Gaurdian Mobile
                                                </label>
                                                <div class="col-md-6">
                                                   <input type="text" name="gaurdian_mobile" placeholder="Gaurdian Mobile" disabled class="form-control" onkeypress="return isNumberKey(event)" maxlength="10">
                                                   <span class="color-pwd" id="gaurdian_mobile"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Member Name <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="member_name" placeholder="Member Name"  class="form-control">
                <span class="color-pwd" id="member_name"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Father Name <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="father_name" placeholder="Father Name" class="form-control">
                <span class="color-pwd" id="father_name"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Mother Name
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="mother_name" placeholder="Mother Name" class="form-control">
                <span class="color-pwd" id="mother_name"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Gender <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select name="gender" class="form-control">
                                          <option value="">--- Select ---</option>
                                          <?php $__currentLoopData = GenderTypeList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val['name']); ?>"><?php echo e($val['name']); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                <span class="color-pwd" id="gender"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Marital Satus <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select name="marital_status" class="form-control">
                  <?php $__currentLoopData = $marital; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </select>
                <span class="color-pwd" id="marital_status"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Husband/Wife Name 
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="husband_wife_name" placeholder="Husband/Wife Name" class="form-control">
                <span class="color-pwd" id="husband_wife_name"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Aadhar <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="aadhar" placeholder="Aadhar" class="form-control" maxlength="12" onkeypress="return isNumberKey(event)">
                                        <span class="color-pwd" id="aadhar"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        PAN 
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="pan" placeholder="PAN number" class="form-control" maxlength="10" >
                <span class="color-pwd" id="pan"></span>
                                    </div>
                                </div>
                              <!-- Current Address -->
                              <div class="form-group">
                              <div class="col-md-6 col-md-offset-3">
                                  <div class="panel panel-primary">
                                      <div class="panel-heading">
                                          <h4 class="panel-title">Current Address</h4>
                                      </div>
                                      <div class="panel-body">
                                          <!-- Form Group                               -->
                                          <div class="form-group">
                                              <label for="inputUsername" class="col-md-4 control-label">
                                                  Address Line 1
                                              </label>
                                              <div class="col-md-6">
                                                <textarea class="form-control resize_vertical" name="current_address_line" placeholder="Address Line 1..."></textarea>
                                                <span class="color-pwd" id="current_address_line"></span>
                                              </div>
                                          </div>
                                          <!-- Form Group                               -->
                                          <div class="form-group">
                                              <label for="inputUsername" class="col-md-4 control-label">
                                                  Village / City
                                              </label>
                                              <div class="col-md-6">
                                                 <input type="text" name="current_village_or_city" placeholder="Village / City" class="form-control">
                                              <span class="color-pwd" id="current_village_or_city"></span>
                                              </div>
                                          </div>
                                          <!-- Form Group                               -->
                                          <div class="form-group">
                                              <label for="inputUsername" class="col-md-4 control-label">
                                                  State
                                              </label>
                                              <div class="col-md-6">
                                                 <select name="current_state"  class="form-control" id="mailstate">
                                                <option value="">--- Select ---</option>
                                                <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                              </select>
                                              <span class="color-pwd" id="current_state"></span>
                                              </div>
                                          </div>
                                          <!-- Form Group                               -->
                                          <div class="form-group">
                                              <label for="inputUsername" class="col-md-4 control-label">
                                                  District
                                              </label>
                                              <div class="col-md-6">
                                                 <select name="current_district"  class="form-control" id="ajax_mailing_dist">
                                                <option value="">--- Select ---</option>
                                              </select>
                                              <span class="color-pwd" id="current_district"></span>
                                              </div>
                                          </div>
                                          <!-- Form Group                               -->
                                          <div class="form-group">
                                              <label for="inputUsername" class="col-md-4 control-label">
                                                  Tehsil
                                              </label>
                                              <div class="col-md-6">
                                                 <input type="text" name="current_tehsil" placeholder="Tehsil"  class="form-control" id="date_end"><span class="color-pwd" id="current_tehsil"></span>
                                              </div>
                                          </div>
                                          <!-- Form Group                               -->
                                          <div class="form-group">
                                              <label for="inputUsername" class="col-md-4 control-label">
                                                  Pin Code
                                              </label>
                                              <div class="col-md-6">
                                                 <input type="text" name="current_pin_code" placeholder="Pin Code" class="form-control" onkeypress="return isNumberKey(event)" maxlength="6">
                                              <span class="color-pwd" id="current_pin_code"></span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              </div>                                
<!-- Permanent Address -->
<div class="form-group">
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Permanent Address</h4>
            <span class="pull-right">
            <input type="checkbox" class="custom-checkbox" id="same_permanent">&nbsp; Same as current address
            </span>
        </div>
        <div class="panel-body">
            <!-- Form Group                               -->
            <div class="form-group">
                <label for="inputUsername" class="col-md-4 control-label">
                    Address Line 1
                </label>
                <div class="col-md-6">
                  <textarea class="form-control resize_vertical" name="permanent_address_line" placeholder="Address Line 1..."></textarea>
                  <span class="color-pwd" id="permanent_address_line"></span>
                </div>
            </div>
            <!-- Form Group                               -->
            <div class="form-group">
                <label for="inputUsername" class="col-md-4 control-label">
                    Village / City
                </label>
                <div class="col-md-6">
                   <input type="text" name="permanent_village_or_city" placeholder="Village / City" class="form-control">
                <span class="color-pwd" id="permanent_village_or_city"></span>
                </div>
            </div>
            <!-- Form Group                               -->
            <div class="form-group">
                <label for="inputUsername" class="col-md-4 control-label">
                    State
                </label>
                <div class="col-md-6">
                   <select name="permanent_state"  class="form-control mailstate">
                  <option value="">--- Select ---</option>
                  <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </select>
                <span class="color-pwd" id="permanent_state"></span>
                </div>
            </div>
            <!-- Form Group                               -->
            <div class="form-group">
                <label for="inputUsername" class="col-md-4 control-label">
                    District
                </label>
                <div class="col-md-6">
                   <select name="permanent_district"  class="form-control ajax_mailing_dist">
                  <option value="">--- Select ---</option>
                </select>
                <span class="color-pwd" id="permanent_district"></span>
                </div>
            </div>
            <!-- Form Group                               -->
            <div class="form-group">
                <label for="inputUsername" class="col-md-4 control-label">
                    Tehsil
                </label>
                <div class="col-md-6">
                   <input type="text" name="permanent_tehsil" placeholder="Tehsil"  class="form-control" id="date_end"><span class="color-pwd" id="permanent_tehsil"></span>
                </div>
            </div>
            <!-- Form Group                               -->
            <div class="form-group">
                <label for="inputUsername" class="col-md-4 control-label">
                    Pin Code
                </label>
                <div class="col-md-6">
                   <input type="text" name="permanent_pin_code" placeholder="Pin Code" class="form-control" onkeypress="return isNumberKey(event)" maxlength="6">
                <span class="color-pwd" id="permanent_pin_code"></span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>                                 
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Relegion 
                                    </label>
                                    <div class="col-md-6">
                                        <select name="religion"  class="form-control">
                                        <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $religion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                     <span class="color-pwd" id="religion"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Cast Category 
                                    </label>
                                    <div class="col-md-6">
                                        <select name="cast_category"  class="form-control">
                                         <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = CategoryTypeList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val['name']); ?>"><?php echo e($val['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                     <span class="color-pwd" id="cast_category"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Date Of Birth 
                                    </label>
                                    <div class="col-md-6">
                                        <!-- <input type="text" name="date_of_birth" placeholder="yyyy-mm-dd" class="date-picker form-control"  id="dbirth" readonly> -->
                                        <input type="date" name="date_of_birth" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                                        <span class="color-pwd" id="date_of_birth"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Occupation 
                                    </label>
                                    <div class="col-md-6">
                                         <select name="occupation" class="form-control">
                  <option value="">--- Select ---</option>
                  <?php $__currentLoopData = $occupations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </select>
                <span class="color-pwd" id="occupation"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Education Qualification 
                                    </label>
                                    <div class="col-md-6">
                                        <select name="education"  class="form-control">
                                        <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                     <span class="color-pwd" id="education"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Preferred Language 
                                    </label>
                                    <div class="col-md-6">
                                        <select name="language"  class="form-control">
                                        <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                     <span class="color-pwd" id="language"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Nationality 
                                    </label>
                                    <div class="col-md-6">
                                        <select name="nationality" class="form-control" readonly>
                                        <option value="Indian">Indian</option> 
                                      </select>
                                     <span class="color-pwd" id="nationality"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Residence Type 
                                    </label>
                                    <div class="col-md-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="residence_type" class="radio-blue" value="Owned" checked>&nbsp; Owned</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="residence_type" class="radio-blue" value="Rent">&nbsp; Rent</label>
                                        </div>
                                     <span class="color-pwd" id="residence_type"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Vehicle 
                                    </label>
                                    <div class="col-md-6">
                                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="vehicle[]" class="square-blue" value="<?php echo e($val); ?>">&nbsp; <?php echo e($val); ?></label>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       
                                     <span class="color-pwd" id="vehicle"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Mobile <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="mobile" placeholder="Mobile Number" class="form-control" onkeypress="return isNumberKey(event)" maxlength="10">
                                        <span class="color-pwd" id="mobile"></span>
                                    </div>
                                </div> 
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Email 
                                    </label>
                                    <div class="col-md-6">
                                      <input type="email" name="email" placeholder="Email" class="form-control">
                                        
                                     <span class="color-pwd" id="email"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Purpose of Opening A/C 
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="opening_account_purpose" placeholder="Purpose of Opening A/C" class="form-control">
                                     <span class="color-pwd" id="opening_account_purpose"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Annual Income 
                                    </label>
                                    <div class="col-md-6">
                                      <input type="text" placeholder="Annual Income" name="annual_income" class="form-control">
                                        
                                     <span class="color-pwd" id="annual_income"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Passport No. 
                                    </label>
                                    <div class="col-md-6">
                                      <input type="text" name="passport" placeholder="Passport No."  class="form-control">
                                        
                                     <span class="color-pwd" id="passport"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Validity of Passport 
                                    </label>
                                    <div class="col-md-6">
                                      <!-- <input type="text" name="validity_of_passport"  placeholder="yyyy-mm-dd" id="valid_passport_date" class="form-control" readonly> -->
                                      <input type="date" name="validity_of_passport" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                                        
                                     <span class="color-pwd" id="validity_of_passport"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Nominee Name 
                                    </label>
                                    <div class="col-md-6">
                                      <input type="text" name="nominee_name"  class="form-control">
                                        
                                     <span class="color-pwd" id="nominee_name"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Nominee Address 
                                    </label>
                                    <div class="col-md-6">
                                      <textarea name="nominee_address"  class="form-control"></textarea>
                                     <span class="color-pwd" id="nominee_address"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Nominee Relation 
                                    </label>
                                    <div class="col-md-6">
                                        <select name="nominee_relation"  class="form-control">
                                        <option value="">--- Select ---</option>
                                        <?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                      </select>
                                     <span class="color-pwd" id="nominee_relation"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Nominee DOB 
                                    </label>
                                    <div class="col-md-6">
                                      <!-- <input type="text" name="nominee_dob"  class="form-control" placeholder="yyyy-mm-dd" id="nomineedob" readonly> -->
                                      <input type="date" name="nominee_dob" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                                     <span class="color-pwd" id="nominee_dob"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Agent Name <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select name="agent_name" class="form-control">
                                            <option value="">--- Select ---</option>
                                            <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($agent->id); ?>"><?php echo e($agent->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                     <span class="color-pwd" id="agent_name"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Ward 
                                    </label>
                                    <div class="col-md-6">
                                        <!--<input type="text" name="ward" placeholder="Ward Number" class="form-control" onkeypress="return isNumberKey(event)"> -->
                                        <input type="text" name="ward" placeholder="Ward Number" class="form-control">
                <span class="color-pwd" id="ward"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        L/F No. 
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="lf_no" placeholder="Ledger Folio number" class="form-control">
                <span class="color-pwd" id="lf_no"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Ledger No. 
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="ledger" placeholder="Ledger Number" class="form-control" onkeypress="return isNumberKey(event)">
                <span class="color-pwd" id="ledger"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Page No. 
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="page" placeholder="Page Number" class="form-control" onkeypress="return isNumberKey(event)">
                <span class="color-pwd" id="page"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Status <span class="color-pwd">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                      </select>
                                      <span class="color-pwd" id="status"></span>
                                    </div>
                                </div>
                                <!-- Form Group                               -->
                                <!-- Form Group                               -->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        A/C Permissions 
                                    </label>
                                    <div class="col-md-6">
                                        <?php $i = 1; ?>
                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="checkbox-inline">
                                            <label>
                                                <input type="checkbox" name="ac_permissions[]" class="square-blue" value="<?php echo e($val); ?>" <?php if($i == 1): ?> checked <?php endif; ?>>&nbsp; <?php echo e($val); ?></label>
                                        </div>
                                        <?php $i++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       
                                     <span class="color-pwd" id="ac_permissions"></span>
                                    </div>
                                </div>
                                 <!-- Form Group                               -->
                                <div class="form-group">
                                  <label for="inputUsername" class="col-md-3 control-label">
                                        Images
                                    </label>
                                    <div class="col-md-6 text-center">
                                            <div class="col-md-6 thumbnail">
                                                <img src="<?php echo e(ASSETS); ?>/images/profile.jpg" class="img-responsive" height="100" id="imgphoto">
                                       
                                            <span class="btn btn-warning btn-file mt-10">
                                            Member Photo 
                                            <input name="image" type="file" accept="image/*" onchange="loadFile(event)">
                                            </span>
                                            </div>
                                            <div class="col-md-6 thumbnail">
                                                <img src="<?php echo e(ASSETS); ?>/images/signature.png" class="img-responsive" height="100" id="imgsignature">
                                       
                                            <span class="btn btn-warning btn-file mt-10">
                                            Member Signature 
                                            <input name="signature" type="file" accept="image/*" onchange="loadFile2(event)">
                                            </span>
                                            </div>
                                           
                                      </div>
                                  </div>                               
                                    <!-- Form Group -->
                                    <div class="form-group">
                                            <label class="col-md-3 control-label" for="name">Documents</label>
                                            <div class="col-md-6 thumbnail">
                                                <input name="document" type="file">
                                            </div>
                                        </div>
                                <div class="form-group">
                                  <div class="col-md-6 col-md-offset-3">
                                    <?php echo $__env->make('mylayout.ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                  </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="col-md-offset-3 col-md-6 text-center btn-group-lg">
                                    <?php if(!$CheckLock): ?>
                                    <button type="submit" class="btn btn-success btn_sizes">Submit</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
</aside>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('mylayout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/Transaction/Open_New_Ac/create.blade.php ENDPATH**/ ?>