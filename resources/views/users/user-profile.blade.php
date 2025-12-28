@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_VENDORS}}x-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_CSS}}pages/user_profile.css" rel="stylesheet" type="text/css" />
@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js" type="text/javascript"></script>
    <script src="{{ASSETS_VENDORS}}jquery-mockjax/js/jquery.mockjax.js" type="text/javascript"></script>
    <script src="{{ASSETS_VENDORS}}x-editable/js/bootstrap-editable.js" type="text/javascript"></script>
    <script src="{{ASSETS_JS}}pages/user_profile.js" type="text/javascript"></script>
@endpush

@section('body')
 <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side strech">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <!--section starts-->
                <h1>{{Auth::user()->name}}</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">
                            <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#">User</a>
                    </li>
                    <li class="active">User Profile</li>
                </ol>
            </section>
            <!--section ends-->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav  nav-tabs ">
                            <li class="active">
                                <a href="#tab1" data-toggle="tab">
                                    <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i> User Profile</a>
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
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-file">
                                                                <img src="{{PREFIX1.''.Auth::user()->file}}"  class="img-responsive"  alt="riot">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>{{$profile->name}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Father Name</td>
                                                                    <td>{{@$profile->father_name}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mother Name</td>
                                                                    <td>{{@$profile->mother_name}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Designation</td>
                                                                   <td>{{@$profile->designation_model->name}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Role</td>
                                                                    <td>
                                                                    @if(!empty($profile->getRoleNames()))
                                                                        @foreach($profile->getRoleNames() as $v){{ $v }}
                                                                        @endforeach
                                                                    @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Date of Birth</td>
                                                                    <td>{{date('d-M-Y',strtotime($profile->date_of_birth))}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mobile</td>
                                                                    <td>{{$profile->mobile}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td>{{$profile->email}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mailing Address</td>
                                                                    <td>{{@$profile->mailing_address}} {{@$profile->mailing_city}} {{@$profile->district_model->name}} {{@$profile->state_model->name}} {{@$profile->mailing_pin}}</td>
                                                                </tr>
                                                                
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- content -->
        </aside>
@endsection