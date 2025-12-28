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
<script type="text/javascript">
    function printDiv(printRecord){
          var printContents = $('#record').html();
          var originalContents = document.body.innerHTML;      
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
    };
    </script>

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
                        
                        <div class="tab-content mar-top">                           
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                                    </div>
                                </div>
                                <div class="row prnt" id="record">
                                    <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                                <br>
                                                Account Opening Form
                                            </div>
                                    <div class="col-md-8 col-md-offset-2">
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <tbody>
                                                    <tr>
                                                        <th>Branch Name:</th>
                                                        <td>{{$item->branch_model->name}}</td>
                                                        <td rowspan="20">
                                                            <div class="thumbnail">
                                                                <img src="{{PREFIX1.''.$item->file}}" width="150" class=""  alt="SMBNL">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Member Type:</th>
                                                        <td>{{$item->member_type_model->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Type of Account:</th>
                                                        <td>{{$item->ac_type_model->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>A/C No.:</th>
                                                        <td>{{$item->account_no}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Member Name:</th>
                                                        <td>{{$item->full_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Father Name:</th>
                                                        <td>{{$item->father_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Gender:</th>
                                                        <td>{{$item->gender}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Aadhar:</th>
                                                        <td>{{$item->aadhar}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>PAN:</th>
                                                        <td>{{$item->pan}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address Line 1:</th>
                                                        <td>{{$item->current_address_first}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Village / City:</th>
                                                        <td>{{$item->village}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tehsil:</th>
                                                        <td>{{$item->tehsil}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>District:</th>
                                                        <td>{{$item->district_model->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>State:</th>
                                                        <td>{{$item->state_model->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ward:</th>
                                                        <td>{{$item->ward}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cast Category:</th>
                                                        <td>{{$item->category}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Date Of Birth:</th>
                                                        <td>{{date('d-M-Y',strtotime($item->dob))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nominee Name:</th>
                                                        <td>{{$item->nominee_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nominee Relation:</th>
                                                        <td>{{$item->nominee_relation}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Mobile:</th>
                                                        <td>{{$item->contact_no}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3"> <br>Authorized Signature <br><br></th>
                                                    </tr>
                                                </tbody>
                                            </table>
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