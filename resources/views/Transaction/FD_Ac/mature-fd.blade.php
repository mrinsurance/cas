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
  <script type="text/javascript" src="{{ASSETS_JS}}matured-fd-record.js"></script>
  <!-- <script type="text/javascript" src="{{ASSETS_JS}}blur-request.js"></script> -->
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}fixed-deposit.js"></script>
@endpush

@section('body')
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>FD A/c of - {{@$customer->full_name}} A/C No. -  {{@$item->account_no}}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{TRANSACTION_URL_FD_AC}}"> FD A/C List </a>
            </li>
            <li class="active">Mature</li>
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
                    <form method="post" action="{{TRANSACTION_URL_FD_AC.''.$item->id.'/matured'}}" id="confirm_frm" class="form-horizontal form-label-left">

                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" name="ajax_url" value="{{url('transaction/fixed-deposite/blur')}}" id="ajax_url">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Member Type</label>
                                    <div class="col-md-9">
                                      <select class="form-control" disabled>
                                          @foreach($membertypes as $val)
                                            <option value="{{$val->id}}" {{$val->id == $item->member_type_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">A/c No.</label>
                                    <div class="col-md-9">
                                      <input type="text" name="account_no" value="{{$item->account_no}}" class="form-control" disabled>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-3" for="first-name">FD No.
                                      </label>
                                      <div class="col-md-9">
                                        <input type="text" value="{{$item->fd_no}}" class="form-control" disabled>
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Paid Interest</label>
                                    <div class="col-md-9">
                                      <input type="text" name="paid_interest" value="{{$intPaidLists}}"  class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">FD Amount</label>
                                    <div class="col-md-9">
                                      <input type="text" name="fd_amount" value="{{$item->amount}}"  class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                                      </div>
                                </div>
                                @php
                                $totalFdAmt = $intPaidLists + $item->amount;
                                @endphp
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Amount</label>
                                    <div class="col-md-9">
                                      <input type="text" name="amount" value="{{$totalFdAmt}}"  class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Rate (%)
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="{{$item->int_rate}}" class="form-control" onkeypress="return isNumAndDecimalKey(event)" readonly="">
                          </div>
                        </div>
<!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-9">
                            <input type="text" class="form-control int_from_date" value="{{$item->int_run_from}}" readonly="readonly">
                          </div>
                        </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-9">
                                     <input type="text" class="form-control" value="{{$item->transaction_date}}" readonly="readonly">
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Period of FD (Month)
                          </label>
                          <div class="col-md-9">
                            <input type="text"  value="{{$item->period_fd}}" class="form-control" onkeypress="return isNumberKey(event)" readonly="">
                          </div>
                        </div>
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="maturity_date" class="form-control" value="{{$item->maturity_date}}" readonly="readonly">
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="matured_on_date" class="form-control" id="old_matured_on_date_cal" value="{{$item->status == 1 ? date('Y-m-d') : $item->matured_on_date}}" >
                          </div>
                        </div>
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled>
                              @foreach($type_of_interest as $val)
                              <option value="{{$val}}" {{$val == $item->interest_type ? 'selected' : ''}}>{{$val}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group hidden" id="premature_interest">
                            <label class="control-label col-md-3" for="first-name">Interest@ %
                            </label>
                            <div class="col-md-9">
                                <input type="text" value="{{$item->int_rate}}" name="premature_interest_rate" disabled class="form-control interest_rate" onkeypress="return isNumAndDecimalKey(event)" >
                                <span class="color-pwd" id="premature_interest_rate"></span>
                            </div>
                        </div>
<!-- Maturity Amount -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Amount
                          </label>
                          <div class="col-md-5">
                            <input type="text" value="{{$item->maturity_amount}}" name="maturity_amount" class="form-control" onkeypress="return isNumberKey(event)">
                            <span class="text-danger" id="maturity_amount"></span>
                          </div><div class="col-md-4">
                            <span id="maturity_value">FD = {{$item->amount}}, Interest = {{ $item->maturity_amount - $item->amount }}</span>
                          </div>
                        </div>
                                <!-- Email input-->
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled>
                                @foreach(TypeOfDeposit() as $val)
                                <option value="{{$val['name']}}" {{$val['name'] == $item->type_of_deposite ? 'selected' : ''}}>{{$val['name']}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
<!-- Nominee Name -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Name
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="{{$item->nominee_name}}" class="form-control" disabled>
                          </div>
                        </div>
<!-- Nominee Relation -->
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Relation
                          </label>
                          <div class="col-md-9">
                            <select class="form-control" disabled>
                                @foreach($relations as $val)
                                <option value="{{$val}}" {{$val == $item->nominee_relation ? 'selected' : ''}}>{{$val}}</option>
                                @endforeach
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
                                  @if(Auth::user()->entry_type == 0)
                                    <div class="col-md-12 text-right btn-group-md">
                                      <input type="hidden" name="mtr" value="sm">
                                        @if($item->status == 1)
                                        <button type="submit" class="btn btn-danger btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Mature</button>
                                        <input type="hidden" name="fdStatus" value="0">
                                        @else
                                        <button type="submit" class="btn btn-success btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> UnMature</button>
                                        <input type="hidden" name="fdStatus" value="1">
                                        @endif

                                        <button type="button" id="show_renew_btn" class="btn btn-warning btn_sizes"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</button>
                                    </div>
                                    @else
                                    <div class="col-md-12 text-right btn-group-md">
                                      <input type="hidden" name="mtr" value="dm">
                                        @if(!$CheckLock)
                                        @if($item->status == 1)
                                        <button type="submit" class="btn btn-danger btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Mature</button>
                                        <input type="hidden" name="fdStatus" value="0">
                                        @else
                                        <button type="submit" class="btn btn-success btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> UnMature</button>
                                        <input type="hidden" name="fdStatus" value="1">
                                        @endif

                                        <button type="button" id="show_renew_btn" class="btn btn-warning btn_sizes"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</button>
                                        @endif
                                    </div>
                                    @endif
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
                            <span>Renew FD Detail</span>
                        </h3>
                    </div>

                    <div class="panel-body hide" style="height: 921px;" id="renew_fd_area">
                    <form method="post" action="{{TRANSACTION_URL_FD_AC.''.$item->id.'/renew'}}" id="mature_fd_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" name="ajax_url" value="{{url('transaction/fixed-deposite/blur')}}" id="ajax_url">
                    <input type="hidden" name="old_amount">
                    <input type="hidden" name="old_matured_on_date">
                    <input type="hidden" name="old_maturity_amount">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name1">Member Type</label>
                                    <div class="col-md-9">
                                      <select class="form-control" disabled>
                                          @foreach($membertypes as $val)
                                            <option value="{{$val->id}}" {{$val->id == $item->member_type_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">A/c No.</label>
                                    <div class="col-md-9">
                                      <input type="text" value="{{$item->account_no}}" class="form-control ac_no" disabled>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-3" for="first-name">FD No.
                                      </label>
                                      <div class="col-md-9">
                                        <input type="text" name="renew_fd_no" value="{{$item->fd_no}}" class="form-control">
                                      </div>
                                    </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Amount <span class="color-pwd">*</span></label>
                                    <div class="col-md-9">
                                      <input type="text" value="{{$item->maturity_amount}}" name="renew_amount" class="form-control renew_amount" onkeypress="return isNumberKey(event)">
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
<!-- Interest Rate (%) -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Rate (%) <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text" value="{{$item->int_rate}}" name="renew_interest_rate" class="form-control renew_interest_rate" onkeypress="return isNumAndDecimalKey(event)" >
                            <span class="color-pwd" id="interest_rate"></span>
                          </div>
                        </div>
<!-- Interest Run From -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Interest Run From
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="renew_interest_run_from" class="form-control" id="int_from_date" value="{{$item->maturity_date}}" readonly="readonly">
                            <span class="color-pwd"></span>
                          </div>
                        </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-9">
                                     <input type="text" name="renew_transaction_date" class="form-control" id="int_on_date" value="{{$item->matured_on_date}}" readonly="readonly">
                            <span class="color-pwd" id="transaction_date"></span>
                                      <span class="color-pwd" id="transaction_date"></span>
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Period of FD (Month) <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <input type="text"  value="" name="renew_period_of_fd" class="form-control" id="renew_month_of_period" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="period_of_fd"></span>
                          </div>
                        </div>
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="renew_maturity_date" class="form-control" id="maturity_date_cal"  value="{{$item->maturity_date}}" readonly="readonly">
                            <span class="color-pwd"></span>
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-9">
                            <input type="text" name="renew_matured_on_date" class="form-control" id="matured_on_date_cal" value="{{$item->matured_on_date}}" readonly="readonly">
                            <span class="color-pwd"></span>
                          </div>
                        </div>
<!-- Type of Interest -->
                      <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Interest
                          </label>
                          <div class="col-md-9">
                            <select name="renew_type_of_interest" class="form-control renew_type_of_interest">
                              @foreach($type_of_interest as $val)
                              <option value="{{$val}}" {{$val == $item->interest_type ? 'selected' : ''}}>{{$val}}</option>
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
                            <input type="text" value="{{$item->maturity_amount}}" name="renew_maturity_amount" class="form-control maturity_amount" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="maturity_amount"></span>
                          </div>
                        </div>
                                <!-- Email input-->
<!-- Type of Deposit -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Type of Deposit
                          </label>
                          <div class="col-md-9">
                            <select name="renew_type_of_deposit" class="form-control">
                                @foreach(TypeOfDeposit() as $val)
                                <option value="{{$val['name']}}" {{$val['name'] == $item->type_of_deposite ? 'selected' : ''}}>{{$val['name']}}</option>
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
                            <input type="text" value="{{$item->nominee_name}}" name="renew_nominee_name" class="form-control">
                            <span class="color-pwd" id="nominee_name"></span>
                          </div>
                        </div>
<!-- Nominee Relation -->
<!-- Nominee Relation -->
                        <div class="form-group">
                          <label class="control-label col-md-3" for="first-name">Nominee Relation <span class="color-pwd">*</span>
                          </label>
                          <div class="col-md-9">
                            <select name="renew_nominee_relation" class="form-control">
                                @foreach($relations as $val)
                                <option value="{{$val}}" {{$val == $item->nominee_relation ? 'selected' : ''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            <span class="color-pwd" id="nominee_relation"></span>
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
                                      @if(Auth::user()->entry_type == 0)
                                      <input type="hidden" name="mtr" value="sm">
                                        <button type="submit" class="btn btn-primary btn_sizes"><i class="fa fa-check" aria-hidden="true"></i> Confirm</button>
                                        @else
                                        <input type="hidden" name="mtr" value="dm">
                                        <button type="submit" class="btn btn-primary btn_sizes"><i class="fa fa-check" aria-hidden="true"></i> Confirm</button>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
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