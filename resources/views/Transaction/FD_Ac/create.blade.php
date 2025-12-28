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
  <script type="text/javascript" src="{{ASSETS_JS}}fd-blur-request.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}fixed-deposit.js"></script>
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
                <a href="{{TRANSACTION_URL_FD_AC}}"> FD A/C List </a>
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
                            Fixed Deposit A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="{{TRANSACTION_URL_POST_FD_AC}}" id="post_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    <input type="hidden" name="ajax_url" value="{{url('transaction/fixed-deposite/blur')}}" id="ajax_url">
                    <input type="hidden" name="open_ac_id" id="open_ac_id">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Member Type</label>
                                    <div class="col-md-9">
                                      <select name="member_type_model_id" id="membertype_id" class="form-control">
                                          @foreach($membertypes as $val)
                                            <option value="{{$val->id}}">{{$val->name}}</option>
                                          @endforeach
                                        </select>
                                      <span class="color-pwd" id="member_type_model_id"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">A/c No. <span class="color-pwd">*</span></label>
                                    <div class="col-md-9">
                                      <input type="text" name="account_no" id="ac_no" class="form-control ac_no" >
                                      <span class="color-pwd" id="account_no"></span>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-3" for="first-name">FD No. <span class="color-pwd">*</span>
                                      </label>
                                      <div class="col-md-9">
                                        <input type="text" value="{{@$auto_id->fd_no
                                        + 1}}" name="fd_no" class="form-control" onkeypress="return isNumberKey(event)">
                                        <span class="color-pwd" id="fd_no"></span>
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Amount <span class="color-pwd">*</span></label>
                                    <div class="col-md-9">
                                      <input type="text" name="amount" class="form-control amount" onkeypress="return isNumberKey(event)" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Rate (%) <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="interest_rate" class="form-control interest_rate" onkeypress="return isNumAndDecimalKey(event)" >
                            <span class="color-pwd" id="interest_rate"></span>
                          </div>
                        </div>
                        <!-- Paid Interest -->
                        <div class="form-group">
                            <label class="control-label col-md-3" for="PaidInterest">Paid Interest
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="PaidInterest" class="form-control" onkeypress="return isNumAndDecimalKey(event)" value="0" >
                                <span class="color-pwd" id="PaidInterest"></span>
                            </div>
                        </div>
<!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="interest_run_from" class="form-control" id="int_from_date" value="{{date('Y-m-d')}}" readonly="readonly">
                            <span class="color-pwd" id="interest_run_from"></span>
                          </div>
                        </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-9">
                                     <input type="text" name="transaction_date" class="form-control" id="int_on_date" value="{{date('Y-m-d')}}" readonly="readonly">
                            <span class="color-pwd" id="transaction_date"></span>
                                      <span class="color-pwd" id="transaction_date"></span>
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Period of FD (Month) <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="period_of_fd" class="form-control" id="month_of_period" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="period_of_fd"></span>
                          </div>
                        </div>
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="maturity_date" class="form-control" id="maturity_date_cal" value="{{date('Y-m-d')}}" readonly>
                            <span class="color-pwd" id="maturity_date"></span>
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="matured_on_date" class="form-control" id="matured_on_date_cal" value="{{date('Y-m-d')}}" readonly>
                            <span class="color-pwd" id="matured_on_date"></span>
                          </div>
                        </div>
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-9">
                            <select name="type_of_interest" class="form-control type_of_interest">
                              @foreach($type_of_interest as $val)
                              <option value="{{$val}}">{{$val}}</option>
                              @endforeach
                            </select>
                           <span class="color-pwd" id="type_of_interest"></span>
                          </div>
                        </div>
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Amount <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>

                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-3 control-label">
                                        Mode of Transaction
                                    </label>
                                    <div class="col-md-6">
                                      <label class="radio-inline">
                                        &nbsp;<input type="radio" name="mode_of_transaction" value="Cash" checked>Cash
                                      </label>
                                      <label class="radio-inline">
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" disabled name="mode_of_transaction" value="Cheque">Cheque
                                      </label>
                                     <span class="color-pwd" id="mode_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <!-- Cheque Detail                                 -->
                                <div id="cheque_mode" class="hide">
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Cheque Date</label>
                                    <div class="col-md-9">
                                      <input type="text" name="cheque_date" class="form-control" id="date_of_cheque" value="{{date('Y-m-d')}}" readonly="readonly" disabled>
                                      <span class="color-pwd" id="cheque_date"></span>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Cheque No.</label>
                                    <div class="col-md-9">
                                      <input type="text" name="cheque_number" class="form-control cheque_number" onkeypress="return isNumberKey(event)"  disabled>
                                      <span class="color-pwd" id="cheque_number"></span>
                                    </div>
                                  </div>
                                </div>
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-9">
                            <select name="type_of_deposit" class="form-control">
                              @foreach(TypeOfDeposit() as $val)
                                <option value="{{$val['name']}}">{{$val['name']}}</option>
                                @endforeach
                            </select>
                            <span class="color-pwd" id="type_of_deposit"></span>
                          </div>
                        </div>
<!-- Nominee Name -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Name <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="nominee_name" class="form-control" placeholder="Nominee Name">
                            <span class="color-pwd" id="nominee_name"></span>
                          </div>
                        </div>
<!-- Nominee Relation -->
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Relation <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <select name="nominee_relation" class="form-control">
                                @foreach($relations as $val)
                                <option value="{{$val}}">{{$val}}</option>
                                @endforeach
                            </select>
                            <span class="color-pwd" id="nominee_relation"></span>
                          </div>
                        </div>
<!-- LF No -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Ledger Folio
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="lf_no" class="form-control">
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
                                        <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
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

                  <div class="panel-body" style="height: 995px;">
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
                                    <th>Available Balance</th>
                                      <td>
                                          <span class="color-pwd" id="result_balance"></span>
                                      </td>
                                  </tr>

                              </tbody>
                          </table>
                      </div>
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