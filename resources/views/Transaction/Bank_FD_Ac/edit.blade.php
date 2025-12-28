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
  <script type="text/javascript" src="{{ASSETS_JS}}bank-blur-request.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}bank-fixed-deposit.js"></script></script>
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
                <a href="{{TRANSACTION_URL_BANK_FD_AC}}"> Bank FD A/C List </a>
            </li>
            <li class="active">Edit</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <div class="row">
            <!--row starts-->
            <div class="col-md-8 col-md-offset-2">
                <!--lg-6 starts-->
                <!--basic form 2 starts-->
                <div class="panel panel-primary" id="hidepanel2">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Bank Fixed Deposit A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                    <form method="post" action="{{TRANSACTION_URL_BANK_FD_AC.''.$item->id}}" id="edit_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" name="ajax_url" value="{{url('transaction/bank-fixed-deposite/blur')}}" id="ajax_url">
                            <fieldset>
                              <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Branch</label>
                                    <div class="col-md-8">
                                      <select name="branch" class="form-control">
                                          @foreach($branches as $val)
                                            <option value="{{$val->id}}" {{$val->id == $item->branch_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                          @endforeach  
                                        </select>
                                      <span class="color-pwd" id="branch"></span>
                                      </div>
                                </div>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Bank</label>
                                    <div class="col-md-8">
                                      <select name="bank" class="form-control">
                                          @foreach($banks as $val)
                                            <option value="{{$val->id}}" {{$val->id == $item->bank_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                          @endforeach  
                                        </select>
                                      <span class="color-pwd" id="bank"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" name="account_no" value="{{$item->account_no}}" class="form-control ac_no">
                                      <span class="color-pwd" id="account_no"></span>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4" for="first-name">FD No.
                                      </label>
                                      <div class="col-md-8">
                                        <input type="text" name="fd_no" value="{{$item->fd_no}}" class="form-control">
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Amount</label>
                                    <div class="col-md-8">
                                      <input type="text" value="{{$item->amount}}" name="amount" class="form-control amount" onkeypress="return isNumberKey(event)" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Interest Rate (%)
                          </label>
                          <div class="col-md-8">
                            <input type="text" value="{{$item->int_rate}}" name="interest_rate" class="form-control interest_rate" onkeypress="return isNumAndDecimalKey(event)" >
                            <span class="color-pwd" id="interest_rate"></span>
                          </div>
                        </div>   
<!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="interest_run_from" class="form-control" id="int_from_date"  value="{{$item->int_run_from}}" readonly="readonly">
                            <span class="color-pwd" id="interest_run_from"></span>
                          </div>
                        </div>                        
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-8">
                                     <input type="text" name="transaction_date" class="form-control" id="int_on_date" value="{{$item->transaction_date}}" readonly="readonly">
                            <span class="color-pwd" id="transaction_date"></span>
                                      <span class="color-pwd" id="transaction_date"></span>
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Period of FD (Month)
                          </label>
                          <div class="col-md-8">
                            <input type="text"  value="{{$item->period_fd}}" name="period_of_fd" class="form-control" id="month_of_period" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="period_of_fd"></span>
                          </div>
                        </div> 
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-8">
                            <input type="text" name="maturity_date" class="form-control" id="maturity_date_cal"  value="{{$item->maturity_date}}" readonly>
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
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-8">
                            <select name="type_of_interest" class="form-control type_of_interest">
                              @foreach($type_of_interest as $val)
                              <option value="{{$val}}" {{$val == $item->interest_type ? 'selected' : ''}}>{{$val}}</option>
                              @endforeach
                            </select>
                           <span class="color-pwd" id="type_of_interest"></span>
                          </div>
                        </div>
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Amount
                          </label>
                          <div class="col-md-8">
                            <input type="text" value="{{$item->maturity_amount}}" name="maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>                         
                                                                                                     
                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-4 control-label">
                                        Mode of Transaction 
                                    </label>
                                    <div class="col-md-6">
                                      <label class="radio-inline">
                                        &nbsp;<input type="radio" name="mode_of_transaction" value="Cash" {{$item->mode_transaction == 'Cash' ? 'checked' : ''}}>Cash
                                      </label>
                                      <label class="radio-inline">
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" disabled name="mode_of_transaction" value="Cheque" {{$item->mode_transaction == 'Cheque' ? 'checked' : ''}}>Cheque
                                      </label>
                                     <span class="color-pwd" id="mode_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <!-- Cheque Detail                                 -->
                                <div id="cheque_mode" class="hide">
                                  <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Cheque Date</label>
                                    <div class="col-md-8">
                                      <input type="text" name="cheque_date" class="form-control" id="date_of_cheque"  value="{{$item->cheque_date}}" readonly="readonly" disabled>
                                      <span class="color-pwd" id="cheque_date"></span>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Cheque No.</label>
                                    <div class="col-md-8">
                                      <input type="text" value="{{$item->cheque_no}}" name="cheque_number" class="form-control cheque_number" onkeypress="return isNumberKey(event)"  disabled>
                                      <span class="color-pwd" id="cheque_number"></span>
                                    </div>
                                  </div>
                                </div>
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-8">
                            <select name="type_of_deposit" class="form-control">
                                @foreach($type_of_deposite as $val)
                                <option value="{{$val}}" {{$val == $item->type_of_deposite ? 'selected' : ''}}>{{$val}}</option>
                                @endforeach    
                            </select>
                            <span class="color-pwd" id="type_of_deposit"></span>
                          </div>
                        </div>
                                <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3 text-center">
                                       @include('mylayout.ajax-msg')
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-right btn-group-md">
                                        <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <!--panel body ends--> 
                  </div>
                
            </div>
            <!--md-12 ends-->
            </div>
        <!--main content ends--> 
      </section>
    <!-- content --> 
</aside>
@endsection