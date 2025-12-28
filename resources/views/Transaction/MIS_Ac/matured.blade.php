@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
  <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
  <link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
      <link href="{{ASSETS_CSS}}pages/form2.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ASSETS_CSS}}jquery-ui.css" />
@endpush

@push('extra_js')
  <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
  <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
  <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}confirm-edit-record.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}mis-blur-request.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}mis-deposit.js"></script>
@endpush

@section('body')
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
                <a href="{{TRANSACTION_URL_MIS_AC}}"> MIS A/C List </a>
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
                      <form method="post" action="{{TRANSACTION_URL_MIS_AC.''.$item->id.'/matured'}}" id="confirm_frm" class="form-horizontal form-label-left">

                    {{csrf_field()}}
                    {{method_field('PUT')}}
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Member Type</label>
                                    <div class="col-md-8">
                                      <select class="form-control" disabled>
                                        <option value="">{{$item->member_type_model->name}}</option>
                                      </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" class="form-control" value="{{$item->account_no}}" disabled>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4" for="first-name">MIS No.
                                      </label>
                                      <div class="col-md-8">
                                        <input type="text" value="{{$item->mis_no}}" class="form-control" disabled>
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Amount</label>
                                    <div class="col-md-8">
                                      <input type="text" name="amount" class="form-control" value="{{$item->amount}}" readonly="">
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Interest Rate (%)
                          </label>
                          <div class="col-md-8">
                            <input type="text" class="form-control" value="{{$item->int_rate}}" disabled="">
                          </div>
                        </div>   
                        
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">MIS Dated</label>
                                    <div class="col-md-8">
                                     <input type="text" class="form-control" value="{{$item->start_date}}" disabled="">
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Period of MIS (Month)
                          </label>
                          <div class="col-md-8">
                            <input type="text" class="form-control" value="{{$item->period_of_mis}}" disabled="">
                          </div>
                        </div> 
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-8">
                            <input type="text" class="form-control" value="{{$item->maturity_date}}" disabled="">
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="matured_on_date" class="form-control" id="matured_on_date_cal" value="{{$item->matured_on_date}}" readonly="readonly">
                          </div>
                        </div> 
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Amount
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="maturity_amount" class="form-control" value="{{$item->maturity_amount}}" readonly="">
                          </div>
                        </div>
<!-- Interest Rate -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Interest
                          </label>
                          <div class="col-md-4">
                            Total Interest
                            <input type="text" class="form-control" value="{{$item->total_interest}}" disabled="">
                          </div>
                          <div class="col-md-4">
                            Monthly Installment
                            <input type="text" class="form-control" value="{{$item->monthly_installment}}" disabled="">
                          </div>
                        </div>                         
<!-- Nominee Name -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Nominee Name
                          </label>
                          <div class="col-md-8">
                            <input type="text" class="form-control" value="{{$item->nominee_name}}" disabled="">
                          </div>
                        </div> 
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Nominee Relation
                          </label>
                          <div class="col-md-8">
                            <select class="form-control" disabled="">
                              <option value="">{{$item->nominee_relation}}</option>
                            </select>
                          </div>
                        </div>
                        <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3 text-center">
                                       @include('mylayout.ajax-msg')
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-right btn-group-md">
                                        @if(!$CheckLock)
                                            @if($item->status == 1)
                                            <button type="submit" class="btn btn-danger btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Mature</button>
                                            <input type="hidden" name="fdStatus" value="0">
                                            @else
                                            <button type="submit" class="btn btn-success btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> UnMature</button>
                                            <input type="hidden" name="fdStatus" value="1">
                                            @endif
                                        @endif

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
                                      <td>{{$item->open_new_ac_model->branch_model->name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td>{{$item->open_new_ac_model->full_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td>{{$item->open_new_ac_model->father_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td>{{$item->open_new_ac_model->village}} {{$item->open_new_ac_model->post_office}} {{$item->open_new_ac_model->district_model->name}} ({{$item->open_new_ac_model->state_model->name}})</td>
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
                      <!-- Installment table                       -->
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
                                    @foreach($mis_installments as $val)
                                      <tr>
                                        <td align="center">{{$loop->index + 1}}</td>
                                        <td align="center">{{$val->installment_date}}</td>
                                        <td align="center">{{$val->monthly_installment}}</td>
                                        <td align="center">
                                          @if($val->status == 0)
                                            <span class="text text-danger">Unpaid</span>
                                          @else
                                            <span class="text text-success">Paid</span>
                                          @endif
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>                                
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
@endsection