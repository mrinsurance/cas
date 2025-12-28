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
    <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
    <script src="{{ASSETS_JS}}changestate.js"></script>
    <script src="{{ASSETS_JS}}onchange.js"></script>
    <script src="{{ASSETS_JS}}open_new_ac.js"></script>
    <script>
        function guardianType(val)
        {
            if (val == 1 || val == 2)
            {
                $(".fatherName").removeClass('hide');
                $(".husbandName").addClass('hide');
                $(".guardianName").addClass('hide');

                $("input[name=fatherName]").attr('disabled',false);
                $("input[name=husbandName]").attr('disabled',true);
                $("input[name=guardianName]").attr('disabled',true);
            }
            else if (val == 3)
            {
                $(".fatherName").addClass('hide');
                $(".husbandName").removeClass('hide');
                $(".guardianName").addClass('hide');

                $("input[name=fatherName]").attr('disabled',true);
                $("input[name=husbandName]").attr('disabled',false);
                $("input[name=guardianName]").attr('disabled',true);
            }else if (val == 4)
            {
                $(".fatherName").addClass('hide');
                $(".husbandName").addClass('hide');
                $(".guardianName").removeClass('hide');

                $("input[name=fatherName]").attr('disabled',true);
                $("input[name=husbandName]").attr('disabled',true);
                $("input[name=guardianName]").attr('disabled',false);
            }
            else {
                $(".fatherName").addClass('hide');
                $(".husbandName").addClass('hide');
                $(".guardianName").addClass('hide');

                $("input[name=fatherName]").attr('disabled',true);
                $("input[name=husbandName]").attr('disabled',true);
                $("input[name=guardianName]").attr('disabled',true);
            }
        }
    </script>
    @endpush

    @section('body')
    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side strech">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <!--section starts-->
        <h1>Login with {{Auth::user()->name.' '.Auth::user()->last_name}}</h1>
    <ol class="breadcrumb">
        <li>
        <a href="{{HOME_LINK}}">
        <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
        </a>
        </li>
        <li>
        <a href="{{TRANSACTION_URL_OPEN_NEW_AC}}"> A/C List </a>
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
        <form method="post" action="{{ route('transaction.create.short.account.submit') }}" id="post_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
            {{csrf_field()}}
        <div class="form-body">
        <!-- Form Group                               -->
            <div class="form-group">
                <label for="branch_name" class="col-md-3 control-label">
                    Branch Name <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <select name="branch_name"  class="form-control">
                        @foreach(SocietyBranch() as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                    <span class="color-pwd" id="branch_name"></span>
                </div>
            </div>
        <!-- Form Group                               -->
            <div class="form-group">
                <label for="member_type_model_id" class="col-md-3 control-label">
                    Member Type <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <select name="member_type_model_id"  class="form-control">
                        @foreach(MemberType() as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                    <span class="color-pwd" id="member_type_model_id"></span>
                </div>
            </div>
        <!-- Form Group                               -->
            <div class="form-group">
                <label for="account_no" class="col-md-3 control-label">
                    A/C No. <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" name="account_no" placeholder="Account number" class="form-control">
                    <span class="color-pwd" id="account_no"></span>
                </div>
            </div>
        <!-- Form Group                               -->
            <div class="form-group">
                <label for="ac_opening_date" class="col-md-3 control-label">
                    A/C Opening Date <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <input type="date" name="ac_opening_date" class="form-control" value="{{date('Y-m-d')}}">
                    <span class="color-pwd" id="ac_opening_date"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="type_of_account" class="col-md-3 control-label">
                    Type of Account <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <select name="type_of_account"  class="form-control type_of_account">
                        @foreach(TypeOfAccount() as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                    <span class="color-pwd" id="type_of_account"></span>
                </div>
            </div>

        <!-- Gaurdian Details -->
            <div class="form-group hide" id="gaurdian_account">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h4 class="panel-title">Guardian Detail</h4>
                        </div>
                        <div class="panel-body">
                            <!-- Form Group                               -->
                            <div class="form-group">
                                <label for="member_gaurdian_name" class="col-md-4 control-label">
                                    Guardian Name <span class="color-pwd">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" name="member_gaurdian_name" placeholder="Guardian Name" disabled class="form-control">
                                    <span class="color-pwd" id="member_gaurdian_name"></span>
                                </div>
                            </div>
                            <!-- Form Group                               -->
                            <div class="form-group">
                                <label for="gaurdian_aadhar" class="col-md-4 control-label">
                                    Guardian Aadhar
                                </label>
                                <div class="col-md-6">
                                    <input type="text" name="gaurdian_aadhar" placeholder="Gaurdian Aadhar" disabled class="form-control" onkeypress="return isNumberKey(event)" maxlength="12">
                                    <span class="color-pwd" id="gaurdian_aadhar"></span>
                                </div>
                            </div>
                            <!-- Form Group                               -->
                            <div class="form-group">
                                <label for="inputUsername" class="col-md-4 control-label">
                                    Guardian PAN
                                </label>
                                <div class="col-md-6">
                                    <input type="text" name="gaurdian_pan" placeholder="Guardian PAN" disabled class="form-control" maxlength="10">
                                    <span class="color-pwd" id="gaurdian_pan"></span>
                                </div>
                            </div>
                            <!-- Form Group                               -->
                            <div class="form-group">
                                <label for="inputUsername" class="col-md-4 control-label">
                                    Guardian Mobile
                                </label>
                                <div class="col-md-6">
                                    <input type="text" name="gaurdian_mobile" placeholder="Guardian Mobile" disabled class="form-control" onkeypress="return isNumberKey(event)" maxlength="10">
                                    <span class="color-pwd" id="gaurdian_mobile"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Form Group                               -->
            <div class="form-group">
                <label for="member_name" class="col-md-3 control-label">
                    Member Name <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" name="member_name" placeholder="Member Name"  class="form-control">
                    <span class="color-pwd" id="member_name"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="GuardianType" class="col-md-3 control-label">
                    Guardian Type <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <select name="GuardianType"  class="form-control" onchange="guardianType(this.value)">
                        @foreach(GuardianTypeList() as $val)
                            <option value="{{$val['id']}}" {{ $val['id'] == 2 ? 'selected' : '' }}>{{$val['name']}}</option>
                        @endforeach
                    </select>
                    <span class="color-pwd" id="GuardianType"></span>
                </div>
            </div>
        <!-- Form Group                               -->
            <div class="form-group fatherName hide">
                <label for="fatherName" class="col-md-3 control-label">
                    Father Name
                </label>
                <div class="col-md-6">
                    <input type="text" name="fatherName" placeholder="Father Name" class="form-control" disabled>
                    <span class="color-pwd" id="fatherName"></span>
                </div>
            </div>
            <div class="form-group husbandName hide">
                <label for="husbandName" class="col-md-3 control-label">
                    Husband Name
                </label>
                <div class="col-md-6">
                    <input type="text" name="husbandName" placeholder="Husband Name" class="form-control" disabled>
                    <span class="color-pwd" id="husbandName"></span>
                </div>
            </div>
            <div class="form-group guardianName hide">
                <label for="guardianName" class="col-md-3 control-label">
                    Guardian Name
                </label>
                <div class="col-md-6">
                    <input type="text" name="guardianName" placeholder="Guardian Name" class="form-control" disabled>
                    <span class="color-pwd" id="guardianName"></span>
                </div>
            </div>

        <!-- Form Group                               -->
            <div class="form-group">
                <label for="gender" class="col-md-3 control-label">
                    Gender <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <select name="gender" class="form-control">
                        @foreach(GenderTypeList() as $val)
                            <option value="{{ $val['name'] }}">{{ $val['name'] }}</option>
                        @endforeach
                    </select>
                    <span class="color-pwd" id="gender"></span>
                </div>
            </div>
        <!-- Form Group                               -->
            <div class="form-group">
                <label for="aadhar" class="col-md-3 control-label">
                    Aadhar <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" name="aadhar" placeholder="Aadhar" class="form-control" maxlength="12" onkeypress="return isNumberKey(event)" value="111111111111">
                    <span class="color-pwd" id="aadhar"></span>
                </div>
            </div>
        <!-- Form Group                               -->

            <!-- Form Group                               -->
            <div class="form-group">
                <label for="mobile" class="col-md-3 control-label">
                    Mobile <span class="color-pwd">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" name="mobile" placeholder="Mobile Number" class="form-control" onkeypress="return isNumberKey(event)" maxlength="10" value="0000000000">
                    <span class="color-pwd" id="mobile"></span>
                </div>
            </div>
            <!-- Form Group                               -->
            <div class="form-group">
                <label for="current_state" class="col-md-3 control-label">
                    State
                </label>
                <div class="col-md-6">
                    <select name="current_state"  class="form-control" onchange="getDistictByState(this, '{{ route("get.district.by.state") }}')">
                        @php
                            $address = CompanyAddress();
                        @endphp
                            <option value="{{ $address->state_model_id }}">{{ getStateById($address->state_model_id)['name'] }}</option>

                    </select>
                    <span class="color-pwd" id="current_state"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="current_district" class="col-md-3 control-label">
                    District
                </label>
                <div class="col-md-6">
                    <select name="current_district"  class="form-control current_district" onchange="getPatwarByDistrict(this, '{{ route("get.patwar.by.district") }}')">
                        @php
                            $address = CompanyAddress();
                        @endphp
                        <option value="{{ $address->district_model_id }}">{{ getDistrictById($address->district_model_id)['name'] }}</option>
                    </select>
                    <span class="color-pwd" id="current_district"></span>
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
                    </select>
                    <span class="color-pwd" id="status"></span>
                </div>
            </div>
        <!-- Form Group                               -->
            <div class="form-group">
                <label for="inputUsername" class="col-md-3 control-label">
                    A/C Permissions
                </label>
                <div class="col-md-6">
                    @foreach(PermissionList() as $val)
                        <div class="checkbox-inline">
                            <label>
                                <input type="checkbox" name="ac_permissions[]" class="square-blue" value="{{ $val['label'] }}" checked >&nbsp; {{ $val['label'] }}</label>
                        </div>
                    @endforeach
                            <span class="color-pwd" id="ac_permissions"></span>
                </div>
            </div>
        <!-- Form Group -->

            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    @include('mylayout.ajax-msg')
                </div>
            </div>
        </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6 text-center btn-group-md">
                    @if(!$CheckLock)
                    <button type="submit" class="btn btn-success btn_sizes">Submit</button>
                    @endif
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
    @endsection