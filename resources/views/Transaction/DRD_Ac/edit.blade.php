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
  <script type="text/javascript" src="{{ASSETS_JS}}drd-blur-request.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}drd-deposit.js"></script>
@endpush

@section('body')
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Hello Admin</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{TRANSACTION_URL_DRD_AC}}"> DRD A/C List </a>
            </li>
            <li class="active">Edit</li>
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
                            DRD A/C
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="{{TRANSACTION_URL_DRD_AC.''.$item->id}}" id="edit_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" name="ajax_url" value="{{url('transaction/drd/blur')}}" id="ajax_url">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name1">Member Type</label>
                                    <div class="col-md-8">
                                      <select class="form-control" disabled>
                                          @foreach($membertypes as $val)
                                            <option value="{{$val->id}}" {{$val->id == $item->member_type_model_id ? 'selected' : ''}}>{{$val->name}}</option>
                                          @endforeach  
                                        </select>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">A/c No.</label>
                                    <div class="col-md-8">
                                      <input type="text" value="{{$item->account_no}}" class="form-control" disabled>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4" for="first-name">DRD No.
                                      </label>
                                      <div class="col-md-8">
                                        <input type="text" value="{{$item->drd_no}}" class="form-control" disabled>
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
                        
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">DRD Dated</label>
                                    <div class="col-md-8">
                                     <input type="date" name="drd_date" class="form-control" id="drd_start_date" value="{{$item->transaction_date}}" readonly="readonly">
                                      <span class="color-pwd" id="drd_date"></span>
                                      </div>
                                </div>
<!-- Period of FD -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Period of DRD (Days)
                          </label>
                          <div class="col-md-8">
                            <input type="text" value="{{$item->period_drd}}" name="period_of_drd" class="form-control" id="month_of_period" onkeypress="return isNumberKey(event)">
                            <span class="color-pwd" id="period_of_drd"></span>
                          </div>
                        </div> 
<!-- Maturity Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Maturity Date
                          </label>
                          <div class="col-md-8">
                            <input type="date" name="maturity_date" class="form-control" id="maturity_date_cal" value="{{$item->maturity_date}}" readonly="readonly">
                            <span class="color-pwd" id="maturity_date"></span>
                          </div>
                        </div>
<!-- Matured on Date -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Matured on Date
                          </label>
                          <div class="col-md-8">
                            <input type="date" name="matured_on_date" class="form-control" id="matured_on_date_cal" value="{{$item->matured_on_date}}" readonly="readonly">
                            <span class="color-pwd" id="matured_on_date"></span>
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
<!-- Nominee Name -->
                        <div class="form-group">
                          <label class="control-label col-md-4" for="first-name">Nominee Name
                          </label>
                          <div class="col-md-8">
                            <input type="text" value="{{$item->nominee_name}}" name="nominee_name" class="form-control">
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
                                <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3 text-center">
                                       @include('mylayout.ajax-msg')
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-right btn-group-md">
                                        @if(!$CheckLock)
                                        <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
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

                  <div class="panel-body" style="height: 683px;">
                      <div class="table-scrollable">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <td ><div class="thumbnail "><img src="{{PREFIX1.''.$user_detail->file}}" width="150" class="img-responsive"  alt=""></div></td>
                                      <td ><div class="thumbnail"><img src="{{PREFIX1.''.$user_detail->signature}}" width="150" class="img-responsive"  alt=""></div></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Branch</th>
                                      <td>{{@$user_detail->branch_model->name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Member Name</th>
                                      <td>{{@$user_detail->full_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td>{{@$user_detail->father_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td>{{@$user_detail->village}} {{@$user_detail->post_office}} {{@$user_detail->district_model->name}} ({{@$user_detail->state_model->name}})</td>
                                  </tr>
                                                                    
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