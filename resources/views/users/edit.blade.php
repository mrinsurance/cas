@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
  <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet">
  <link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
  <link href="{{ASSETS_CSS}}pages/form_layouts.css" rel="stylesheet" type="text/css" />
  <link href="{{ASSETS_CSS}}pages/form2.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ASSETS_CSS}}jquery-ui.css" />
@endpush

@push('extra_js')
  <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
  <script src="{{ASSETS_JS}}pages/form_layouts.js"></script>
    <script src="{{ASSETS_JS}}changestate.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}edit-record.js"></script>
    <script src="{{ASSETS_JS}}create-user.js"></script></script>
@endpush

@section('body')
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>{{$user->name}}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{USERS}}"> Users Management </a>
            </li>
            <li class="active">Edit User</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="user" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Edit User
                                </h3>
                                <!-- <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span> -->
                            </div>
                            <div class="panel-body">
                                <form method="post" action="{{USERS.'/'.$user->id}}" id="edit_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    {{method_field('PUT')}}
<!-- Personal Detail -->
                                <h3>Personal Detail</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
<!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Employee Code: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->employee_code}}" name="employee_code" class="form-control" placeholder="Employee Code">
                                                <span class="color-pwd" id="employee_code"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Name : <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->name}}" name="name" class="form-control" placeholder="Name">
                                                <span class="color-pwd" id="name"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Father's Name: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->father_name}}" name="father_name" class="form-control" placeholder="Father's Name">
                                                <span class="color-pwd" id="father_name"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Mother's Name: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->mother_name}}" name="mother_name" class="form-control" placeholder="Mother's Name">
                                                <span class="color-pwd" id="mother_name"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Nominee Name: </label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->nominee_name}}" name="nominee_name" class="form-control" placeholder="Nominee Name">
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Spouse Name: </label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->spouse_name}}" name="spouse_name" class="form-control" placeholder="Spouse Name">
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Date of Birth: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <!-- <input type="text" value="{{$user->date_of_birth}}" name="date_of_birth" class="form-control" id="dob" placeholder="yyyy-mm-dd" readonly> -->
                                                <input type="date" name="date_of_birth" class="form-control" value="{{@$user->date_of_birth}}">
                                                <span class="color-pwd" id="date_of_birth"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Aadhar Number: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->aadhar_number}}" name="aadhar_number" class="form-control" maxlength="12" placeholder="Aadhar Number">
                                                <span class="color-pwd" id="aadhar_number"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">PAN Number: </label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->pan_number}}" name="pan_number" class="form-control" maxlength="10" placeholder="PAN Number">
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Mobile: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" value="{{$user->mobile}}" name="mobile" class="form-control" maxlength="10" placeholder="Mobile">
                                                <span class="color-pwd" id="mobile"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Email: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <input type="email" value="{{$user->email}}" name="email" class="form-control" placeholder="Email">
                                                <span class="color-pwd" id="email"></span>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Photo: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 180px; height: 130px;">
                                            <img src="{{PREFIX1.''.$user->file}}" alt="">
                                        </div>
                                        <div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="photo" style="transform:none;"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                                <span class="color-pwd" id="photo"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Password: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                                <span class="color-pwd" id="password"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Confirm Password: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                                <span class="color-pwd" id="confirm-password"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Role: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control')) !!}
                                                <span class="color-pwd" id="roles"></span>
                                            </div>
                                        </div>
                                        <!-- From Group -->
                                        <div class="form-group">
                                            <label class="control-label col-md-4" for="first_Name">Qualification: </label>
                                            <div class="col-md-8">
                                                <select name="qualification" class="form-control">
                                                    <option value="">--- Select ---</option>
                                                    @foreach($qualification as $val)
                                                    <option value="{{$val}}" {{$val == $user->qualification ? 'selected' : ''}}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <h3>Mailing Address</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="input-text" class="control-label col-md-4"> Address Line 1: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                              <input type="text" value="{{$user->mailing_address}}" name="mailing_address" class="form-control" placeholder="Address Line 1">
                                              <span class="color-pwd" id="mailing_address"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <label for="input-text" class="control-label col-md-4">Country: <span class="color-pwd">*</span></label>
                                        <div class="col-md-8">
                                            <select name="mailing_country" class="form-control">
                                                <option value="India">India</option>
                                            </select>
                                            <span class="color-pwd" id="mailing_country"></span>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input-text" class="control-label col-md-4">State: <span class="color-pwd">*</span></label>
                                            <div class="col-md-8">
                                                <select name="mailing_state" id="mailstate" class="form-control">
                                                    <option value="">--- Select ---</option>
                                                    @foreach($state as $val)
                                                    <option value="{{$val->id}}" {{$val->id == $user->state_model_id ? 'selected' : ''}}>{{$val->name}}</option>

                                                    @endforeach
                                                </select>
                                              <span class="color-pwd" id="mailing_state"></span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">District: <span class="color-pwd">*</span></label>
                        <div class="col-md-8">
                            <select name="mailing_district" id="ajax_mailing_dist" class="form-control">
                                <option value="">--- Select ---</option>
                                @foreach($district as $val)
                                <option value="{{$val->id}}" {{$val->id == $user->district_model_id ? 'selected' : ''}}>{{$val->name}}</option>

                                @endforeach
                            </select>
                            <span class="color-pwd" id="mailing_district"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">City: <span class="color-pwd">*</span></label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->mailing_city}}" name="mailing_city" class="form-control" placeholder="City">
                            <span class="color-pwd" id="mailing_city"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Pin: <span class="color-pwd">*</span></label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->mailing_pin}}" name="mailing_pin" class="form-control" placeholder="Pin" maxlength="6">
                            <span class="color-pwd" id="mailing_pin"></span>
                        </div>
                    </div>  
                </div>
                                   
                                </div>
                                <h3>Permanent Address</h3>
                                <div class="form-group">
                        <div class="col-sm-4">
                          <input type="checkbox" id="same_permanent"> <label class="control-label"> Same as Mailing Address </label>
                        </div>
                        
                    </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                    <div class="form-group permanent_address">
                        <label for="input-text" class="control-label col-md-4"> Address Line 2: </label>
                        <div class="col-md-8">
                          <input type="text" value="{{$user->permanent_address}}" name="permanent_address" class="form-control" placeholder="Address Line 2">
                        </div>
                    </div>
                    <div class="form-group permanent_country">
                    <label for="input-text" class="control-label col-md-4">Country: </label>
                    <div class="col-md-8">
                        <select name="permanent_country" class="form-control">
                            <option value="India">India</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-group permanent_state">
                        <label for="input-text" class="control-label col-md-4">State: </label>
                        <div class="col-md-8">
                            <select name="permanent_state" id="permstate" class="form-control mailstate">
                                <option value="">--- Select ---</option>
                                @foreach($state as $val)
                                <option value="{{$val->id}}" {{$val->id == $user->permanent_state ? 'selected' : ''}}>{{$val->name}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group permanent_district">
                        <label for="input-text" class="control-label col-md-4">District: </label>
                        <div class="col-md-8">
                            <select name="permanent_district" id="ajax_perm_dist" class="form-control ajax_mailing_dist">
                                <option value="">--- Select ---</option>
                                @foreach($district as $val)
                                <option value="{{$val->id}}" {{$val->id == $user->permanent_district ? 'selected' : ''}}>{{$val->name}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group permanent_city">
                        <label for="input-text" class="control-label col-md-4">City: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->permanent_city}}" name="permanent_city" class="form-control" placeholder="City">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Pin: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->permanent_pin}}" name="permanent_pin" class="form-control" placeholder="Pin" maxlength="6">
                        </div>
                    </div>  
                </div>
                                    
                                </div>
                                <h3>Job Detail</h3>
                                <hr>
                                <div class="row">
                                   <div class="col-md-6">

                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Staff Type: <span class="color-pwd">*</span></label>
                        <div class="col-md-8">
                            <select name="staff_type" id="desigtype" class="form-control">
                                @foreach($staff_type as $val)
                                <option value="{{$val}}" {{$val == $user->staff_type ? 'selected' : ''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            <span class="color-pwd" id="staff_type"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Designation: <span class="color-pwd">*</span></label>
                        <div class="col-md-8">
                            <select name="designation" id="ajax_designation" class="form-control">
                                <option value="">--- Select ---</option>
                                @foreach($designation as $val)
                                <option value="{{$val->id}}" {{$val->id == $user->designation_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                @endforeach
                            </select>
                            <span class="color-pwd" id="designation"></span>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                   
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Branch: <span class="color-pwd">*</span></label>
                        <div class="col-md-8">
                            <select name="branch" class="form-control">
                                <option value="">--- Select ---</option>
                                @foreach($branch as $val)
                                <option value="{{$val->id}}" {{$val->id == $user->branch_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                @endforeach
                            </select>
                            <span class="color-pwd" id="branch"></span>
                        </div>
                    </div>
                </div>
                                </div>
                                <h3>Salary & A/c Detail</h3>
                                <hr>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Pay Scale: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->pay_scale}}" name="pay_scale" class="form-control" placeholder="Pay Scale">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Pay Band: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->pay_band}}" name="pay_band" class="form-control" placeholder="Pay Band">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Grade Pay: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->grade_pay}}" name="grade_pay" class="form-control" placeholder="Grade Pay">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Current Basic: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->current_basic}}" name="current_basic" class="form-control" placeholder="Current Basic">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Other Allowance: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->other_allowance}}" name="other_allowance" class="form-control" placeholder="Other Allowance">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Misc/Advance: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->misc_advance}}" name="misc_advance" class="form-control" placeholder="Misc/Advance">
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Misc Deduction: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->misc_deduction}}" name="misc_deduction" class="form-control" placeholder="Misc Deduction">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Misc Deduction Date: </label>
                        <div class="col-md-8">
                            <!-- <input type="text" value="{{$user->misc_deduction_date}}" name="misc_deduction_date" class="form-control" placeholder="yyyy-mm-dd" id="miscdeductiondate" readonly=""> -->
                            <input type="date" name="misc_deduction_date" class="form-control" value="{{@$user->misc_deduction_date}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Bank Name: </label>
                        <div class="col-md-8">
                            <select name="bank_name" class="form-control">
                                <option value="">--- Select ---</option>
                                @foreach($bank as $val)
                                <option value="{{$val->id}}" {{$val->id == $user->bank_model_id ? 'selected' : ''}}>{{$val->name}}</option>
    
                                @endforeach()
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">Bank A/c Number: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->bank_number}}" name="bank_number" class="form-control" placeholder="Bank A/c Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">PF A/c Number: </label>
                        <div class="col-md-8">
                            <input type="text" value="{{$user->pf_number}}" name="pf_number" class="form-control" placeholder="PF A/c Number">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="input-text" class="control-label col-md-4">PF Applicable: </label>
                        <div class="col-md-4">
                            <label class="radio-inline">
                                <input type="radio" name="pf_applicable" class="radio-blue" value="Yes" {{$user->pf_applicable == 'Yes' ? 'checked' : ''}}> Yes</label>
                        </div>
                        <div class="col-md-4">
                            <label class="radio-inline">
                                <input type="radio" name="pf_applicable" class="radio-blue" value="No" {{$user->pf_applicable == 'No' ? 'checked' : ''}}> No</label>
                        </div>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                    <div class="form-group form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6 text-center text-center btn-group-lg">
                                @include('mylayout.ajax-msg')
                                <button type="submit" class="btn btn-success ">Update</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
</aside>
<!-- right-side -->
@endsection