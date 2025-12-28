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
  <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}loan-on-load.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}loan_ac.js"></script>

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
                <a href="{{TRANSACTION_URL_LOAN_AC}}"> Loan A/C List </a>
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
                            Loan A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="{{ route('transaction.loan.update',$loan->id) }}" id="post_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    @method('PUT')
                    <input type="hidden" name="open_ac_id" id="open_ac_id">
                    <input type="hidden" name="ajax_url" value="{{url('transaction/loan/blur')}}" id="ajax_url">
                    <input type="hidden" name="loan_type_url" id="loan_type_url" value="{{url('transaction/loan/loan-type')}}">
                    <input type="hidden" name="share_balance" class="result_share_balance">
                    <span id="loop_input"></span>
                            <fieldset>

                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Member Type</label>
                                    <div class="col-md-8">
                                      <select name="member_type_model_id" id="membertype_id" class="form-control">
                                        @foreach($membertypes as $val)
                                          <option value="{{$val->id}}" {{ $val->id == $loan->member_type_model_id ? 'selected' : '' }}>{{$val->name}}</option>
                                        @endforeach
                                      </select>
                                      <span class="color-pwd" id="member_type_model_id"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" name="account_no" id="ac_no" class="form-control col-md-7 col-xs-12 ac_no" value="{{ $loan->open_new_ac_model_id }}">
                                      <span class="color-pwd" id="account_no"></span>
                                      </div>
                                </div>
    <div class="form-group">
    <label class="col-md-4 control-label" for="password">Date of Advancement</label>
<div class="col-md-8">
    <input type="date" name="date_of_transaction" class="form-control col-md-7 col-xs-12" id="transaction_date" value="{{ \Carbon\Carbon::parse($loan->date_of_advance)->format('m-d-Y') }}">
    <span class="color-pwd" id="date_of_transaction"></span>
    </div>
    </div>
    <div class="form-group">
    <label class="col-md-4 control-label" for="password">Loan Purpose</label>
<div class="col-md-8">
    <select name="loan_purpose" class="form-control">
    <option value="">--- Select ---</option>
        @foreach($loan_purpose as $val)
    <option value="{{$val->id}}" {{ $val->id == $loan->loan_purpose ? 'selected' : '' }}>{{$val->name}}</option>
        @endforeach
    </select>
    <span class="color-pwd" id="loan_purpose"></span>
    </div>
    </div>
    <div class="form-group">
    <label class="col-md-4 control-label" for="password">Amount</label>
    <div class="col-md-8">
    <input type="text" name="amount" class="form-control col-md-7 col-xs-12 amount" value="{{ $loan->amount }}" onkeypress="return isNumberKey(event)" >
    <span class="color-pwd" id="amount"></span>
    </div>
    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Loan Type</label>
                                    <div class="col-md-8">
                                      <select name="loan_type" class="form-control" id="loan_type_request">
                                        <option value="">--- Select ---</option>
                                        @foreach($loan_types as $val)
                                        <option value="{{$val->id}}" {{ $val->id == $loan->loan_type ? 'selected' : '' }}>{{$val->name}}</option>
                                        @endforeach
                                      </select>
                                      <span class="color-pwd" id="loan_type"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Period</label>
                                    <div class="col-md-4">
                                      Term
                                      <select name="term" class="form-control term">
                                          <option value="">--- Select ---</option>
                                          @foreach(TermofLoan() as $val)
                                          <option value="{{$val}}" {{ $val == $loan->term ? 'selected' : '' }}>{{$val}}</option>
                                          @endforeach
                                      </select>
                                      <span class="color-pwd" id="term"></span>
                                    </div>
                                    <div class="col-md-4">
                                      Months
                                      <input type="text" class="form-control month_value" name="month_value" value="{{ $loan->months }}">
                                      <span class="color-pwd" id="month_value"></span>
                                    </div>
                                </div>

                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Interest %</label>
                                    <div class="col-md-4">
                                      Interest @%
                                      <input type="text" class="form-control interest" name="interest" value="{{ $loan->interest }}">
                                      <span class="color-pwd" id="interest"></span>
                                    </div>
                                    <div class="col-md-4">
                                      Pannelty Interest
                                      <input type="text" class="form-control pannelty_interest" name="pannelty_interest" value="{{ $loan->pannelty_int }}">
                                      <span class="color-pwd" id="pannelty_interest"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Additional Interest %</label>
                                    <div class="col-md-8">
                                      <input type="text" class="form-control additional_interest" name="additional_interest" value="{{ $loan->additional_int }}">
                                      <span class="color-pwd" id="additional_interest"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Type of Interest</label>
                                    <div class="col-md-8">
                                      <select name="type_of_interest" class="form-control type_of_interest">
                                        @foreach($loan_interest as $val)
                                        <option value="{{$val}}" {{ $val == $loan->type_of_interest ? 'selected' : '' }}>{{$val}}</option>
                                        @endforeach
                                      </select>
                                      <span class="color-pwd" id="type_of_interest"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3 text-center">
                                       @include('mylayout.ajax-msg')
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-right btn-group-md">
                                        @if(!$CheckLock)
                                      <button type="button" id="install_btn" class="btn btn-primary btn_sizes"><i class="fa fa-list" aria-hidden="true"></i> Create Installment</button>
                                      @can('product-create')
                                        <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                      @endcan
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

                  <div class="panel-body" style="height: 777px;">
                      <div class="hide text-center" id="error_part">
                        <h4><span id="error_result" class="color-pwd"></span></h4>
                      </div>
                      <div class="hide" id="success_part">
                        <div class="table-scrollable">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <td ><div id="preview" class="thumbnail "></div></td>
                                      <td ><div id="sign" class="thumbnail"></div></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Branch</th>
                                      <td><span id="result_branch"></span></td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td><span id="result_full_name"></span></td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td><span id="result_father"></span></td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td><span id="result_address"></span></td>
                                  </tr>
                                  <tr>
                                    <th>L/F No.</th>
                                      <td id="lf_no"></td>
                                  </tr>
                                  <tr>
                                    <th>Available Balance</th>
                                      <td><span class="color-pwd" id="result_balance"></span></td>
                                  </tr>
                                    <tr>
                                    <th>Available Share Balance</th>
                                    <td><span class="color-pwd" id="result_share_balance"></span></td>
                                    </tr>

                              </tbody>
                          </table>
                      </div>
                      </div>
<!-- Installment table                       -->
                      <div class="table-scrollable" style="overflow-y:auto; height: 323px;">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Sr. No.</th>
                                      <th>Date</th>
                                      <th>Principal</th>
                                      <th>Recoverable Int</th>
                                      <th>Net</th>
                                  </tr>
                                  <tbody id="userTable">
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
