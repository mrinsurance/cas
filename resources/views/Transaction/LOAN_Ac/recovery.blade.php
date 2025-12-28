@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
  <link rel="stylesheet" type="text/css" href="{{ASSETS_VENDORS}}datatables/css/dataTables.bootstrap.css" />
  <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
  <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
  <link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
  <link href="{{ASSETS_CSS}}pages/form2.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ASSETS_CSS}}jquery-ui.css" />

@endpush

@push('extra_js')
  <script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/dataTables.bootstrap.js"></script>
  <script src="{{ASSETS_JS}}bootbox.min.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}deleteconfirm.js"></script>
  <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
  <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
  <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
  <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}loan-blur-request.js"></script>
  <script src="{{ASSETS_JS}}changestate.js"></script>
  <script src="{{ASSETS_JS}}loan_ac_recover.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}edit-record.js"></script>


@endpush

@section('body')
    @php
        $total_recoverable_amount = (@$loan_returns_last->pending_intr + @$total_recoverable_int + @$total_add_int) + (@$item->amount - @$total_received_amt);
        $is_sufficiante_balnce = $saving_balance - $total_recoverable_amount;
    @endphp
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
                <a href="{{TRANSACTION_URL_LOAN_AC}}"> Loan A/C List </a>
            </li>
            <li class="active">Recovery</li>
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
                            Loan Recovery
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="{{TRANSACTION_URL_POST_LOAN_AC.'/recover_payment'}}" id="post_frm" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    <input type="hidden" name="open_ac_id" id="open_ac_id">
                    <input type="hidden" name="ajax_url" value="{{url('transaction/loan/blur')}}" id="ajax_url">
                    <input type="hidden" name="loan_type_url" id="loan_type_url" value="{{url('transaction/loan/recovery')}}">

                    <input type="hidden" name="return_url" value="{{$_SERVER['REQUEST_URI']}}">

                    <input type="hidden" id="product_id" value="{{$item->id}}">
                    <input type="hidden" id="rec_date_url" value="{{url('transaction/loan/'.$item->id.'/'.$item->token.'/recovery')}}">
                    <input type="hidden" name="loan_ac_model" value="{{$item->id}}">
                    <input type="hidden" name="member_type_model" value="{{$item->member_type_model_id}}">
                    <input type="hidden" name="account_no" value="{{$item->account_no}}">
                    <input type="hidden" name="loan_type" value="{{$loan_type->name}}">
                    <span id="loop_input"></span>
                            <fieldset>

                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Receiving Date </label>
                                    <div class="col-md-8">
                                      <input type="date" name="receiving_date" class="form-control" id="date1_receiving" value="{{old(date('Y-m-d'),$rec_date)}}">
                                      <!-- <input type="text" name="receiving_date" class="form-control" id="date_receiving" value="{{old(date('Y-m-d'),$rec_date)}}" readonly="readonly"> -->
                                      <span class="color-pwd" id="receiving_date"></span>
                                      </div>
                                </div>

                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Pending Interest</label>
                                    <div class="col-md-8">
                                      <input type="text" name="pending_interest" class="form-control pending_interest" value="{{@$loan_returns_last->pending_intr ? $loan_returns_last->pending_intr : 0}}">

                                      <span class="color-pwd" id="pending_interest"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Recoverable</label>
                                    <div class="col-md-4">
                                      Interest
                                      <input type="text" class="form-control interest_recover" name="interest_recover"  value="{{round($total_recoverable_int) + round($total_add_int)}}">
                                      <span class="color-pwd" id="interest_recover"></span>

                                        <!-- <label class="col-md-4 control-label" for="password">Hidden Intereset</label> -->
                                        <input type="hidden" class="int_recover" name="int_recover" value="{{round($total_recoverable_int)}}">

                                        <!-- <label class="col-md-4 control-label" for="password">Hidden Additional Int</label> -->
                                        <input type="hidden" class="add_recover" name="add_recover" value="{{round($total_add_int)}}">

                                      @if(@$loan_returns_last->pending_intr)
                                        @php $pending_int = @$loan_returns_last->pending_intr + (round($total_recoverable_int) + round($total_add_int)); @endphp
                                      @else
                                      @php $pending_int =  0 + (round($total_recoverable_int) + round($total_add_int)); @endphp
                                      @endif
                                    </div>
                                    <div class="col-md-4">
                                      Principal
                                      <input type="text" class="form-control principal_recover" name="principal_recover" value="{{$item->amount - $total_received_amt}}" readonly>
                                      @php $pr = ($item->amount - $total_received_amt); @endphp
                                      <span class="color-pwd" id="principal_recover"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password"></label>
                                    <div class="col-md-8">
                                      <span class="color-pwd"> Total Recoverable Interest = <i class="fa fa-inr"></i>
                                          <span id="recoverable_interest">
                                              @php
                                                  echo round(@$loan_returns_last->pending_intr + @$total_recoverable_int + @$total_add_int);

                                              @endphp
                                          </span>

                                      </span>

                                      </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password"></label>
                                    <div class="col-md-8">
                                      <span class="color-pwd"> Total Recoverable Amount = <i class="fa fa-inr"></i>
                                          <span id="recoverable_amount">
                                              @php
                                                  echo round($total_recoverable_amount);
                                              @endphp
                                          </span>

                                      </span>

                                      </div>
                                </div>

                                <!-- Email input-->
                                <div class="form-group">
                                    <label for="inputUsername" class="col-md-4 control-label">
                                        Mode of Payment
                                    </label>
                                    <div class="col-md-6">
                                      <label class="radio-inline">
                                        &nbsp;<input type="radio" name="mode_of_transaction" value="Cash" checked>Cash
                                      </label>
                                      <label class="radio-inline">
                                        &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" name="mode_of_transaction" value="Cheque">From A/c
                                      </label>
                                     <span class="color-pwd" id="mode_of_transaction"></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group hidden" id="saving_account_balance">
                                        <label for="" class="col-md-4 control-label">Saving A/c Balance</label>
                                    <div class="col-md-8">
                                        <input type="text" name="saving_account_balance" class="form-control" value="{{ $saving_balance }}" disabled>
                                        <input type="hidden" name="is_sufficiante_balnce" value="{{ $is_sufficiante_balnce }}">
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Total Received</label>
                                    <div class="col-md-8">
                                      <input type="text" name="total_received" class="form-control total_received">
                                      <span class="color-pwd" id="total_received"></span>
                                      </div>
                                </div>
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Received</label>
                                    <div class="col-md-4">
                                      Interest
                                      <input type="text" class="form-control interest_received" name="interest_received" readonly>
                                      <span class="color-pwd" id="interest_received"></span>
                                    </div>
                                    <div class="col-md-4">
                                      Principal
                                      <input type="text" class="form-control principal_received" name="principal_received" readonly>
                                      <span class="color-pwd" id="principal_received"></span>
                                    </div>
                                </div>

                                <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3 text-center">
                                       @include('mylayout.ajax-msg')
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="alert alert-warning hidden is_sufficiante_balance"></div>
                                    <div class="col-md-12 text-right btn-group-md">

                                      @can('product-create')
                                            @if(!$CheckLock)
                                                <button type="submit" class="btn btn-warning btn_sizes" id="submit-btn"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                            @endif
                                      @endcan

                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <!-- Installment table                       -->
                        <span id="togle">+ Click Show</span>
                      <div class="table-scrollable" style="overflow-y:auto; height: 323px;" id="togle_table">
                          <table class="table table-bordered table-hover">
                              <tbody>
                                  <tr>
                                      <th>Sr. No.</th>
                                      <th>Date</th>
                                      <th>Days</th>
                                      <th>Recoverable PR</th>
                                      <th>Received PR</th>
                                      <th>Balance PR</th>
                                      <th>Recoverable Int</th>
                                      <th>Interest</th>
                                      <th>Additional</th>
                                      <th>Net</th>
                                  </tr>
                                  <tbody id="userTable">
@php $n = 0; @endphp
                                    @foreach($loan_installments as $val)
@php
$tdate=date('Y-m-d',strtotime($rec_date));

$diff_in_days = $diff_in_days;
$cint = 0;
$nint = 0;
$aint = 0;

if($item->type_of_interest == 'Reducing')
{
if($tdate <= $val->installment_date)
{

  $cint = ((($val->principal - $val->received_principal) * $diff_in_days * $item->interest) / 36500);

  if(($val->principal - $val->received_principal) == 0)
  {
    $cint = 0;
  }

  $aint = ((($val->principal - $val->received_principal) * $diff_in_days * $item->additional_int) / 36500);
  if(($val->principal - $val->received_principal) == 0)
  {
    $aint = 0;
  }
}
else{
  $cint = ((($val->principal - $val->received_principal) * $diff_in_days * $item->pannelty_int) / 36500);

  $aint = ((($val->principal - $val->received_principal) * $diff_in_days * $item->additional_int) / 36500);
}}
else
{
  //$n = ($diff_in_days / 30) / 12;
  $n = $item->months / 12;
  if($interest_cal_date < $val->installment_date)
  {
  if($tdate > $val->installment_date)
  {
    $cint = ((($val->principal - $val->received_principal) * $item->interest * $n) / 100);
    if(($val->principal - $val->received_principal) == 0)
    {
      $cint = 0;
    }

    $aint = ((($val->principal - $val->received_principal) * $item->additional_int * $n) / 100);
    if(($val->principal - $val->received_principal) == 0)
    {
      $aint = 0;
    }
  }
  else{
    $cint = 0;
    $aint = 0;
  }
  }
  else{
    $cint = 0;
    $aint = 0;
}
}
@endphp
                                      <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$val->installment_date}}</td>
                                        <td>{{$diff_in_days}}</td>
                                        <td>
                                          <i class="fa fa-inr"></i> {{number_format($val->principal)}}
                                        </td>
                                        <td>
                                          <i class="fa fa-inr"></i> {{number_format($val->received_principal)}}</td>
                                        <td>
                                          <i class="fa fa-inr"></i> {{number_format($val->principal - $val->received_principal)}}</td>
                                        <td>
                                          <i class="fa fa-inr"></i> {{number_format($cint + $aint,2)}}</td>
                                        <td>
                                          <i class="fa fa-inr"></i> {{number_format($cint)}}</td>
                                        <td>
                                          <i class="fa fa-inr"></i> {{number_format($aint)}}</td>
                                        <td>
                                          <i class="fa fa-inr"></i> {{number_format($val->received_principal)}}</td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                              </tbody>
                          </table>

                      </div>
                    </div>
                    <!--panel body ends-->
                  </div>
<!-- **************************
    Loan Return Detail
************************** -->
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Loan Return
                        </h3>
                    </div>
                    <div class="panel-body">
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Principal</th>
                <th scope="col">Interest</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
          @php $i = 1; $ct = count($loan_returns); @endphp
          @foreach($loan_returns as $val)
          <input type="hidden" id="prd_id" value="{{$val->id}}">
          <tr id="product{{$val->id}}">
                <td>{{$loop->index + 1}}</td>
                <td>{{$val->received_date}}</td>
                <td>{{$val->received_principal}}</td>
                <td>{{$val->received_interest}}</td>
                <td>
{{--                  @if($i == $ct)--}}
                    @if(!$CheckLock)
                  <button type="button" title="Delete"  class="btn btn-danger  delete-product" value="{{url(TRANSACTION_URL_LOAN_AC.'recover_payment/'.$val->id.'/'.$item->id.'/'.$val->received_date)}}">
                    <i class="fa fa-power-off"></i>
                </button>
                    @endif

{{--                @endif--}}
                </td>
            </tr>
            @php $i++; @endphp
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
                      <div class="hide text-center" id="error_part">
                        <h4><span id="error_result" class="color-pwd"></span></h4>
                      </div>

                       <div class="table-scrollable">
@php
$one = \App\open_new_ac_model::where('id',$item->guarnter_one)->count();
$two = \App\open_new_ac_model::where('id',$item->guarnter_two)->count();
if($one)
{
  $gaurnter_one = \App\open_new_ac_model::findOrFail($item->guarnter_one);
}
if($two)
{
  $gaurnter_two = \App\open_new_ac_model::findOrFail($item->guarnter_two);
}
@endphp
    <table class="table table-bordered table-hover">
    <tbody>
        <tr>
            <th>Branch</th>
            <td>{{$item->open_new_ac_model->branch_model->name}}</td>
        </tr>
        <tr>
          <th>Member Type</th>
            <td>{{$item->member_type_model->name}}</td>
        </tr>
        <tr>
          <th>A/C No.</th>
            <td>{{$item->account_no}}</td>
        </tr>
        <tr>
          <th>L/F No.</th>
          <td>{{@$item->open_new_ac_model->lf_no}}</td>
        </tr>
        <tr>
          <th>Name</th>
            <td>{{$item->open_new_ac_model->full_name}}</td>
        </tr>
        <tr>
          <th>Father Name</th>
            <td>{{$item->open_new_ac_model->father_name}}</td>
        </tr>
        <tr>
          <th>Loan Type</th>
            <td>{{$loan_type->name}}</td>
        </tr>
        <tr>
          <th>Period</th>
            <td>Term - ({{$item->term}}) & Months - ({{$item->months}})</td>
        </tr>
        <tr>
          <th>Interest %</th>
            <td>Interest @% - ({{$item->interest}}) & Pannelty Interest - ({{$item->pannelty_int}})</td>
        </tr>
        <tr>
          <th>Type of Interest</th>
            <td>{{$item->type_of_interest}}</td>
        </tr>
        <!-- <tr>
          <th>Loan Purpose</th>
            <td>{{$item->loan_purpose}}</td>
        </tr> -->
        <tr>
          <th>Date of Advancement</th>
            <td>{{$item->date_of_advance}}</td>
        </tr>
        <tr>
          <th>Amount</th>
            <td><i class="fa fa-inr"></i> <strong>{{number_format($item->amount)}}</strong></td>
        </tr>
        <tr>
          <th>Installment Amt</th>
            <td><i class="fa fa-inr"></i> <strong>{{number_format($item->inst_amt)}}</strong></td>
        </tr>
        @if($one)
        <tr>
          <th>Guarantor One</th>
            <td>A/C No. - {{$gaurnter_one->account_no}} ({{$gaurnter_one->full_name}})</td>
        </tr>
        @endif
        @if($two)
        <tr>
          <th>Guarantor Two</th>
            <td>A/C No. - {{$gaurnter_two->account_no}} ({{$gaurnter_two->full_name}})</td>
        </tr>
        @endif
        <tr>
          <td><a class="btn btn-success btn_sizes" target="_blank" href="{{asset(TRANSACTION_URL_LOAN_AC.'notice/'.$item->id.'/'.old(date('Y-m-d'),$rec_date)).'/'.$pending_int.'/'.$pr.'/'.$item->date_of_advance}}?page=notice"><i class="fa fa-print" aria-hidden="true"></i> Notice</a>
            <a class="btn btn-primary btn_sizes" target="_blank" href="{{asset(TRANSACTION_URL_LOAN_AC.'notice/'.$item->id.'/'.old(date('Y-m-d'),$rec_date)).'/'.$pending_int.'/'.$pr.'/'.$item->date_of_advance}}?page=election"><i class="fa fa-print" aria-hidden="true"></i> Notice Election</a></td>
          <td><a class="btn btn-success btn_sizes" target="_blank" href="{{asset(LEDGER_REPORT_URL_PERSONAL_LEDGER.'?_token=4eLSx7hR0YeCoXDlJtgE7fmwvKLcT7oky9c5qi8S&from_date='.date('Y-m-d').'&to_date='.date('Y-m-d').'&member_type='.$item->member_type_model_id.'&account='.$item->account_no)}}"> P/L View </a>
<button type="button" class="btn btn-info btn_sizes" data-toggle="modal" data-target="#myModal">Edit Guarantor</button>
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
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form method="post" action="{{TRANSACTION_URL_POST_LOAN_AC.'-gaurntor/'.$item->id}}" id="edit_frm" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <!-- Email input-->


          <div class="form-group">
              <label class="col-md-4 control-label" for="password">Guarantor One</label>
              <div class="col-md-8">
                <select name="guarantor_one" class="form-control">
                  <option value="">--- Select ---</option>
                  @foreach($guarenter_first as $val)
                  <option value="{{$val->id}}" {{$item->guarnter_one == $val->id ? 'selected' : ''}}>{{$val->account_no}} - {{$val->full_name}}</option>
                  @endforeach
                </select>
                <span class="color-pwd" id="guarantor_one"></span>
                </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="password">Guarantor Two</label>
              <div class="col-md-8">
                <select name="guarantor_two" class="form-control">
                  <option value="">--- Select ---</option>
                  @foreach($guarenter_first as $val)
                  <option value="{{$val->id}}" {{$item->guarnter_two == $val->id ? 'selected' : ''}}>{{$val->account_no}} - {{$val->full_name}}</option>
                  @endforeach
                </select>
                <span class="color-pwd" id="guarantor_two"></span>
                </div>
          </div>
          <div class="form-group">
              <label class="col-md-4 control-label" for="password">Loan Purpose</label>
              <div class="col-md-8">
                <select name="loan_purpose" class="form-control">
                  <option value="">--- Select ---</option>
                  @foreach($loan_purpose as $val)
                  <option value="{{$val->id}}" {{$item->loan_purpose == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                  @endforeach
                </select>
                <span class="color-pwd" id="loan_purpose"></span>
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-4 control-label" for="parnote">Parnote No</label>
              <div class="col-md-8">
                  <input type="text" name="parnote" class="form-control">
                  <span class="color-pwd" id="parnote"></span>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" value="{{URL::current()}}" name="pageurl">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>

  </div>
</div>
@endsection