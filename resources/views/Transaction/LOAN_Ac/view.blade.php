@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_VENDORS}}x-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_CSS}}pages/user_profile.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
@endpush

@push('extra_js')


@endpush

@section('body')
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
<section class="content-header">
        <!--section starts-->
        <h1>Profile - {{$item->member_type_model->name}} A/C No. -  {{$item->account_no}} ({{$item->full_name}})</h1>
        <ol class="breadcrumb">
        <li>
            <a href="{{HOME_LINK}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
            </a>
        </li>
        <li>
                <a href="{{TRANSACTION_URL_OPEN_NEW_AC}}"> A/C List </a>
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
                                                                <img src="{{$item->file != '' ? MEMBER_PHOTO_THUMB.''.$item->file : ASSETS.'/images/profile.jpg'}}" width="200" class="img-responsive"  alt="SMBNL">
                                                            </div>
                                                        </div>
                                                        <div class="fileinput">
                                                            <div class="thumbnail">
                                                                
                                                                <img src="{{$item->signature != '' ? MEMBER_SIGN_THUMB.''.$item->signature : ASSETS.'/images/signature.png'}}" width="200" class="img-responsive"  alt="SMBNL">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">                                
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th class="success">Branch Name</th>
                                                                <td>{{$item->branch_model->name}}</td>
                                                                <th class="success">Member Type</th>
                                                                <td>{{$item->member_type_model->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">A/C No.</th>
                                                                <td>{{$item->account_no}}</td>
                                                                <th class="success">Type of Account</th>
                                                                <td>{{$item->ac_type_model->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">A/C Opening Date</th>
                                                                <td>{{$item->ac_opening_date}}</td>
                                                                <th class="success">A/C Opening Amount</th>
                                                                <td>{{$item->ac_opening_amount}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Gaurdian Name</th>
                                                                <td>{{$item->gaurdian_name}}</td>
                                                                <th class="success">Gaurdian Aadhar</th>
                                                                <td>{{$item->gaurdian_aadhar}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Gaurdian PAN</th>
                                                                <td>{{$item->gaurdian_pan}}</td>
                                                                <th class="success">Gaurdian Mobile</th>
                                                                <td>{{$item->gaurdian_mobile}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Member Name</th>
                                                                <td>{{$item->full_name}}</td>
                                                                <th class="success">Father Name</th>
                                                                <td>{{$item->father_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Mother Name</th>
                                                                <td>{{$item->mother_name}}</td>
                                                                <th class="success">Date Of Birth</th>
                                                                <td>{{$item->dob}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Gender</th>
                                                                <td>{{$item->gender}}</td>
                                                                <th class="success">Marital Satus</th>
                                                                <td>{{$item->marital}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Husband/Wife Name</th>
                                                                <td>{{$item->husband_name}}</td>
                                                                <th class="success">Aadhar</th>
                                                                <td>{{$item->aadhar}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">PAN</th>
                                                                <td>{{$item->pan}}</td>
                                                                <th class="success">Mobile</th>
                                                                <td>{{$item->contact_no}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Email</th>
                                                                <td>{{$item->email}}</td>
                                                                <th class="success">Relegion</th>
                                                                <td>{{$item->relegion}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Cast Category</th>
                                                                <td>{{$item->category}}</td>
                                                                <th class="success">Status</th>
                                                                <td>{{$item->status == 1 ? 'Active' : 'Deactive'}}</td>
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
                                                                <th class="success">Address Line 1</th>
                                                                <td>{{$item->current_address_first}}</td>
                                                                <th class="success">Village / City</th>
                                                                <td>{{$item->village}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Tehsil</th>
                                                                <td>{{$item->tehsil}}</td>
                                                                <th class="success">District</th>
                                                                <td>{{$item->district_model->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">State</th>
                                                                <td>{{$item->state_model->name}}</td>
                                                                <th class="success">Pin Code</th>
                                                                <td>{{$item->pin_code}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                <h3>Permanent Address</h3>
                                                    <table class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th class="success">Address Line 1</th>
                                                                <td>{{$item->perm_address_first}}</td>
                                                                <th class="success">Village / City</th>
                                                                <td>{{$item->perm_village}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Tehsil</th>
                                                                <td>{{$item->perm_tehsil}}</td>
                                                                <th class="success">District</th>
                                                                <td>{{$permanent_dist->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">State</th>
                                                                <td>{{$permanent_state->name}}</td>
                                                                <th class="success">Pin Code</th>
                                                                <td>{{$item->perm_pin_code}}</td>
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
                                                                <th class="success">Occupation</th>
                                                                <td>{{$item->occupation}}</td>
                                                                <th class="success">Education Qualification</th>
                                                                <td>{{$item->education}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Preferred Language</th>
                                                                <td>{{$item->language}}</td>
                                                                <th class="success">Nationality</th>
                                                                <td>{{$item->nationality}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Residence Type</th>
                                                                <td>{{$item->residence_type}}</td>
                                                                <th class="success">Vehicle</th>
                                                                <td>{{$item->vehicle}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Purpose of Opening A/C</th>
                                                                <td>{{$item->open_ac_purpose}}</td>
                                                                <th class="success">Annual Income</th>
                                                                <td>{{$item->annual_income}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Passport No.</th>
                                                                <td>{{$item->passport}}</td>
                                                                <th class="success">Validity of Passport</th>
                                                                <td>{{$item->passport_validity}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Nominee Name</th>
                                                                <td>{{$item->nominee_name}}</td>
                                                                <th class="success">Nominee Address</th>
                                                                <td>{{$item->nominee_address}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Nominee Relation</th>
                                                                <td>{{$item->nominee_relation}}</td>
                                                                <th class="success">Nominee DOB</th>
                                                                <td>{{$item->nominee_dob}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Agent Code</th>
                                                                <td>{{$item->agent_name}}</td>
                                                                <th class="success">Agent Name</th>
                                                                <td>{{@$agent_name->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Ward</th>
                                                                <td>{{$item->ward}}</td>
                                                                <th class="success">L/F No.</th>
                                                                <td>{{$item->lf_no}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Ledger No.</th>
                                                                <td>{{$item->ledger_no}}</td>
                                                                <th class="success">Page No.</th>
                                                                <td>{{$item->page_no}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="success">Document</th>
                                                                <td><a href="{{url(MEMBER_DOC.''.$item->document)}}" target="_blank">{{$item->document}}</a></td>
                                                                <th class="success"></th>
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
@endsection