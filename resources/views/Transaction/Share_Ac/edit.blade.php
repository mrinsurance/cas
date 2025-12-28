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
  <script type="text/javascript" src="{{ASSETS_JS}}blur-request.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}share_ac.js"></script>
@endpush

@section('body')
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Share A/c of - {{$item->member_type_model->name}} A/C No. -  {{$item->account_no}} ({{@$item->open_new_ac_model->full_name}})</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{TRANSACTION_URL_SHARE_AC}}"> A/C List </a>
            </li>
            <li class="active">Edit Entry of the A/c Saving</li>
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
                <div class="panel panel-danger" id="hidepanel2">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Share A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="{{TRANSACTION_URL_SHARE_AC.''.$item->id}}" id="edit_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                   
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Member Type</label>
                                    <div class="col-md-8">
                                      <select class="form-control">
                                        <option value="{{$item->member_type_model_id}}"> {{$item->member_type_model->name}}</option>
                                      </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" value="{{$item->account_no}}" class="form-control ac_no" readonly>
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
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Date of Transaction</label>
                                    <div class="col-md-8">
                                      <!-- <input type="text" value="{{$item->date_of_transaction}}" name="date_of_transaction" class="form-control" id="transaction_date" value="{{date('Y-m-d')}}" readonly="readonly"> -->
                                      <input type="date" name="date_of_transaction" class="form-control" value="{{$item->date_of_transaction}}">
                                      <span class="color-pwd" id="date_of_transaction"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-4 control-label">
                                        Mode of Transaction 
                                    </label>
                                    <div class="col-md-6">
                                      <label class="radio-inline">
                                        &nbsp;<input type="radio" name="mode_of_transaction" value="Cash" {{$item->mode_of_transaction == 'Cash' ? 'checked' : ''}}> Cash
                                      </label>
                                      <label class="radio-inline">
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" disabled name="mode_of_transaction" value="Cheque" {{$item->mode_of_transaction == 'Cheque' ? 'checked' : ''}}> Cheque
                                      </label>
                                     <span class="color-pwd" id="mode_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <!-- Cheque Detail                                 -->
                                <div id="cheque_mode" class="{{$item->mode_of_transaction == 'Cash' ? 'hide' : 'show'}}">
                                  <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Cheque Date</label>
                                    <div class="col-md-8">
                                      <input type="text" name="cheque_date" class="form-control" id="date_of_cheque" value="{{$item->cheque_date == '' ? date('Y-m-d') : $item->cheque_date}}" readonly="readonly" disabled>
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
                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-4 control-label">
                                        Type of Transaction 
                                    </label>
                                    <div class="col-md-6">
                                      <label class="radio-inline">
                                        &nbsp;<input type="radio" name="type_of_transaction" value="Deposit" {{$item->type_of_transaction == 'Deposit' ? 'checked' : ''}}> Deposit
                                      </label>
                                      <label class="radio-inline">
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" name="type_of_transaction" value="Withdrawal" {{$item->type_of_transaction == 'Withdrawal' ? 'checked' : ''}}> Withdrawal
                                      </label>
                                     <span class="color-pwd" id="type_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Transaction Particular</label>
                                    <div class="col-md-8">
                                       <textarea name="transaction_particular" class="form-control" cols="30" rows="1" id="trans_particular">{{$item->particular == '' ? 'Deposit by Cash' : $item->particular}}</textarea>
                                      <span class="color-pwd" id="transaction_particular"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Remarks</label>
                                    <div class="col-md-8">
                                       <textarea name="remarks" class="form-control" cols="30" rows="1">{{$item->remarks}}</textarea>
                                      <span class="color-pwd" id="remarks"></span>
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
                                        @if(!$CheckLock)
                                        <button type="submit" class="btn btn-success btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
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
                <div class="panel panel-danger" id="hidepanel2">
                  <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="address-book" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <span>A/C Detail</span>
                        </h3>
                    </div>

                  <div class="panel-body" style="height: 473px;">
                      <div id="success_part">
                        <div class="table-scrollable">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <td><div id="preview" class="thumbnail"><img src="{{PREFIX1.''.@$item->open_new_ac_model->file}}" width="150" alt=""></div></td>
                                      @if(!Auth::user()->hasRole('AGENT'))
                                      <td><div id="sign" class="thumbnail"><img src="{{PREFIX1.''.@$item->open_new_ac_model->signature}}" width="150" alt=""></div></td>
                                      @endif
                                  </tr>
                                </tbody>
                              </table>
                              <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Branch</th>
                                      <td><span id="result_branch">{{@$item->open_new_ac_model->branch_model->name}}</span></td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td><span id="result_full_name">{{@$item->open_new_ac_model->full_name}}</span></td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td><span id="result_father">{{@$item->open_new_ac_model->father_name}}</span></td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td><span id="result_address">{{@$item->open_new_ac_model->village}} {{@$item->open_new_ac_model->post_office}} {{@$item->open_new_ac_model->district_model->name}} {{@$item->open_new_ac_model->state_model->name}}</span></td>
                                  </tr>
                                  <tr>
                                    <th>L/F No.</th>
                                    <td>{{@$item->open_new_ac_model->lf_no}}</td>
                                  </tr>
                                  <tr>
                                    <th>Available Balance</th>
                                      <td><span class="color-pwd"><i class="fa fa-fw fa-inr"></i>{{number_format($balance,2)}}</span></td>
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