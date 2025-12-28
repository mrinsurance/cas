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
  <script type="text/javascript" src="{{ASSETS_JS}}edit-record.js"></script>
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
                      <form method="post" action="#" class="form-horizontal form-label-left">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Member Type</label>
                                    <div class="col-md-8">
                                      <select name="member_type_model_id" class="form-control" disabled>
                                          @foreach($membertypes->where('id',$item->member_type_model_id) as $val)
                                            <option value="{{$val->id}}">{{$val->name}}</option>
                                          @endforeach  
                                        </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" name="account_no" id="ac_no" class="form-control ac_no" value="{{$item->account_no}}" disabled>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4" for="first-name">MIS No.
                                      </label>
                                      <div class="col-md-8">
                                        <input type="text" value="{{$item->mis_no}}" name="mis_no" class="form-control" disabled>
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Amount</label>
                                    <div class="col-md-8">
                                      <input type="text" name="amount" class="form-control amount" onkeypress="return isNumberKey(event)" value="{{$item->amount}}" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Interest Rate (%)
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="interest_rate" class="form-control interest_rate" onkeypress="return isNumAndDecimalKey(event)" value="{{$item->int_rate}}">
                            <span class="color-pwd" id="interest_rate"></span>
                          </div>
                        </div>   
                        
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">MIS Dated</label>
                                    <div class="col-md-8">
                                     <input type="date" name="mis_date" class="form-control" id="mis_start_date" value="{{$item->start_date}}">
                                      <span class="color-pwd" id="mis_date"></span>
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Period of MIS (Month)
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="period_of_mis" class="form-control term" id="month_of_period" onkeypress="return isNumberKey(event)" value="{{$item->period_of_mis}}">
                            <span class="color-pwd" id="period_of_mis"></span>
                          </div>
                        </div> 
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="maturity_date" class="form-control" id="maturity_date_cal" value="{{$item->maturity_date}}" readonly>
                            <span class="color-pwd" id="maturity_date"></span>
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="matured_on_date" class="form-control" id="matured_on_date_cal" value="{{$item->matured_on_date}}" readonly>
                            <span class="color-pwd" id="matured_on_date"></span>
                          </div>
                        </div> 
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Amount
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)" value="{{$item->maturity_amount}}">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Interest
                          </label>
                          <div class="col-md-4">
                            Total Interest
                            <input type="text" name="total_interest" class="form-control total_interest" onkeypress="return isNumberKey(event)" value="{{$item->total_interest}}">
                            <span class="color-pwd" id="total_interest"></span>
                          </div>
                          <div class="col-md-4">
                            Monthly Installment
                            <input type="text" name="monthly_installment" class="form-control monthly_installment" onkeypress="return isNumberKey(event)" value="{{$item->monthly_installment}}">
                            <span class="color-pwd" id="monthly_installment"></span>
                          </div>
                        </div>                         
<!-- Nominee Name -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Nominee Name
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="nominee_name" class="form-control" value="{{$item->nominee_name}}">
                            <span class="color-pwd" id="nominee_name"></span>
                          </div>
                        </div> 
<!-- Nominee Relation -->
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Nominee Relation
                          </label>
                          <div class="col-md-8">
                            <select name="nominee_relation" class="form-control">
                              @foreach($relations as $val)
                                <option value="{{$val}}" {{$val == $item->nominee_relation ? 'selected' : ''}}>{{$val}}</option>
                              @endforeach
                            </select>
                            <span class="color-pwd" id="nominee_relation"></span>
                          </div>
                        </div>
                        <div class="form-group">
                                    <div class="col-md-12 text-right btn-group-md">
                                        @if(!$CheckLock)
                                        <a class="btn btn-success btn_sizes" target="_blank" href="{{TRANSACTION_URL_MIS_AC.'print-pdf/'.$item->id.'/'.$item->token}}"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
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
                                      <td>{{$user_detail->branch_model->name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td>{{$user_detail->full_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td>{{$user_detail->father_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td>{{$user_detail->village}} {{$user_detail->post_office}} {{$user_detail->district_model->name}} ({{$user_detail->state_model->name}})</td>
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
                      @if ($message = Session::get('success'))
                      <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                      @endif
                      <!-- Installment table                       -->
                      <form class="form-horizontal" action="{{TRANSACTION_URL_MIS_AC}}interest" id="post_frm" method="post"> 
                        {{csrf_field()}}
                        <input type="hidden" name="account_no" value="{{$user_detail->account_no}}">
                        <input type="hidden" name="accound_id" value="{{$user_detail->id}}">
                        <input type="hidden" name="holder_name" value="{{$user_detail->full_name}}">
                        <input type="hidden" name="branch" value="{{$user_detail->branch_model_id}}">
                        <input type="hidden" name="member_type" value="{{$user_detail->member_type_model_id}}">
                        <input type="hidden" name="mis_id" value="{{$item->id}}">
                        Interest Paid Date <input type="date" name="paid_date" class="form-control" value="{{$date}}">

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
                                          <button class="btn btn-danger btn-sm" name="installment_id" value="{{$val->id}}" type="submit">Unpaid</button>
                                          @else
                                          <button type="button" class="btn btn-success btn-sm">Paid</button>
                                          @endif
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>                                
                              </tbody>
                          </table>
                      </div>
                    </form>
                      
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