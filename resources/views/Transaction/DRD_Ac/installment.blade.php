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
        <link rel="stylesheet" type="text/css" href="{{ASSETS_VENDORS}}datatables/css/dataTables.bootstrap.css" />
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
@endpush

@push('extra_js')
  <script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/dataTables.bootstrap.js"></script>
  <script src="{{ASSETS_SRC_JS}}pages/table-responsive.js"></script>
  <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
  <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
  <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}drd-blur-request.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}drd-installment.js"></script>
@endpush

@section('body')
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>DRD No. - {{$item->drd_no}} / Member A/C No. - {{$item->account_no}} /  ({{$ac_holder->full_name}})</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{TRANSACTION_URL_DRD_AC}}"> DRD A/C List </a>
            </li>
            <li class="active">Installment</li>
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
                            DRD A/C / Installment
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="{{TRANSACTION_URL_POST_DRD_INSTALLMENT}}" id="post_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    <!-- <input type="hidden" name="ajax_url" value="{{url('transaction/recurring-deposite/blur')}}" id="ajax_url"> -->
                    <input type="hidden" name="drd_id" value="{{$item->id}}"> 
                    <input type="hidden" name="member_type_id" value="{{$item->member_type_model_id}}"> 
                    <input type="hidden" name="account_no" value="{{$item->account_no}}"> 
                    <input type="hidden" name="drd_no" value="{{$item->drd_no}}"> 
                    <input type="hidden" name="back_url" value="{{Request::fullUrl()}}"> 
                    <input type="hidden" name="drd_monthly_amount" id="drd_monthly_amount" value="{{$item->amount}}"> 
                    <input type="hidden" name="paid_install" value="{{$total_paid_install}}"> 
                    <input type="hidden" name="period_drd" value="{{$item->period_drd}}"> 
                            <fieldset>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Installment Date</label>
                                    <div class="col-md-8">
                                     <!-- <input type="text" name="installment_date" class="form-control col-md-7 col-xs-12" id="date_installment" value="{{date('Y-m-d')}}" readonly="readonly"> -->
                                     <input type="date" name="installment_date" class="form-control" value="{{date('Y-m-d')}}">
                                      <span class="color-pwd" id="installment_date"></span>
                                      </div>
                                </div>                                
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Amount</label>
                                    <div class="col-md-8">
                                      <input type="text" name="amount" class="form-control col-md-7 col-xs-12" id="inst_amount" onkeypress="return isNumberKey(event)" >
                                      <span class="color-pwd" id="amount"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">No. of Installment</label>
                                    <div class="col-md-8">
                                      <input type="text" name="no_of_installment" class="form-control col-md-7 col-xs-12" id="installs_no" onkeypress="return isNumberKey(event)" readonly>
                                      <span class="color-pwd" id="no_of_installment"></span>
                                      </div>
                                </div>
                               <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3 text-center">
                                       @include('mylayout.ajax-msg')
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 text-left">
                                      <h4 class="color-pwd">Installment Received - {{$total_paid_install}}</h4 class="color-pwd">
                                    </div>
                                    <div class="col-md-6 text-right btn-group-md">
                                        @if(!$CheckLock)
                                        <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Installment Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php $bal = 0; @endphp
                                    @foreach($installs as $val)
                                      <tr id="product{{$val->id}}">
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{date('d-M-Y',strtotime($val->installment_date))}}</td>
                                        <td>{{$val->amount}}</td>
                                        <td>{{ $bal = $bal + $val->amount}}</td>
                                      </tr>
                                      @endforeach
                                </tbody>
                            </table>
                        </div>
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

                  <div class="panel-body">
                      <div class="table-scrollable">
                              <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Branch</th>
                                      <td>{{@$ac_holder->branch_model->name}}</td>
                                  </tr>
                                  <tr>
                                      <th>Member Type</th>
                                      <td>{{@$item->member_type_model->name}}</td>
                                  </tr>
                                  <tr class="color-pwd">
                                      <th>A/C No.</th>
                                      <td>{{$item->account_no}}</td>
                                  </tr>
                                  <tr class="color-pwd">
                                    <th>Member Name</th>
                                      <td>{{$ac_holder->full_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Father Name</th>
                                      <td>{{$ac_holder->father_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Address</th>
                                      <td>{{@$ac_holder->village.' '.@$ac_holder->post_office.' '.@$ac_holder->district_model->name.' - ('.@$ac_holder->state_model->name.')'}}</td>
                                  </tr>
                                  <tr>
                                    <th>RD No.</th>
                                      <td>{{$item->drd_no}}</td>
                                  </tr>
                                  <tr>
                                    <th>Amount</th>
                                      <td><i class="fa fa-fw fa-inr"></i>{{$item->amount}}</td>
                                  </tr>
                                  <tr>
                                    <th>Interest Rate (%)</th>
                                      <td>{{$item->int_rate}}</td>
                                  </tr>
                                  <tr>
                                    <th>DRD Dated</th>
                                      <td>{{$item->transaction_date}}</td>
                                  </tr>
                                  <tr>
                                    <th>Period of DRD (Month)</th>
                                      <td>{{$item->period_drd}}</td>
                                  </tr>
                                  <tr>
                                    <th>Maturity Date</th>
                                      <td>{{$item->maturity_date}}</td>
                                  </tr>
                                  <tr>
                                    <th>Matured on Date</th>
                                      <td>{{$item->matured_on_date}}</td>
                                  </tr>
                                  <tr>
                                    <th>Maturity Amount</th>
                                      <td><i class="fa fa-fw fa-inr"></i>{{$item->maturity_amount}}</td>
                                  </tr>
                                  <tr>
                                    <th>Nominee Name</th>
                                      <td>{{$item->nominee_name}}</td>
                                  </tr>
                                  <tr>
                                    <th>Nominee Relation</th>
                                      <td>{{$item->nominee_relation}}</td>
                                  </tr>
                                  <tr>
                                    <th>Status</th>
                                      <td>
                                        @if($item->status == 1)
                                        <span class="text-success">Active</span>
                                        @else
                                        <span class="color-pwd">Matured</span>
                                        @endif
                                      </td>
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