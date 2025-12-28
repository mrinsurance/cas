@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
    <link href="{{ASSETS_VENDORS}}jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
    <link href="{{ASSETS_VENDORS}}iCheck/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ASSETS_CSS}}jquery-ui.css" />
    <style>
        #mytable_css >tbody>tr>td{
          height:20px;
          padding:1px 2px;
          border-top: 0px;
        }
        #mytable_css >thead>tr>th{
            border-bottom: 1px solid #ccc !important;
        }
        .align_right{
            text-align: right !important;
        }
    </style>
@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
    <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
    <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
    <script src="{{ASSETS_JS}}day_book.js"></script></script>
    <!-- end of page level js -->
    <script type="text/javascript">
    function printDiv(printRecord){
          var printContents = $('#record').html();
          var originalContents = document.body.innerHTML;      
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
    };
    </script>
@endpush

@section('body')

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Dividend Calculation</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Dividend Calculation</li>
        </ol>
    </section>
    <!--section ends-->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet box primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Dividend Calculation
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="{{DIVIDEND_CALCULATION_URL}}" method="get">
                    <div class="row">
                    <div class="col-md-12">
                        {{csrf_field()}}
                        <div class="col-md-6">
                            <label class="col-md-2 control-label" for="email">Session Year</label>
                            <div class="col-md-4">
                                <select name="session_year" class="form-control" required>
                                    <option value="">--- Select ---</option>
                                    @foreach($session_list as $list)
                                        <option value="{{$list->id}}" {{$list->id == @$_REQUEST['session_year'] ? 'selected' : ''}}>{{date('Y',strtotime($list->start_date))}} - {{date('Y',strtotime($list->end_date))}}</option>
                                    @endforeach    
                                </select>
                            </div>
                            
                            <label class="col-md-2 control-label" for="email">Share as On</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" value="{{date('Y-m-d',strtotime($share_as_on))}}" name="share_as_on" placeholder="From">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-2 control-label" for="email">Paid On</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" value="{{date('Y-m-d',strtotime($paid_on))}}" name="paid_on" placeholder="To">
                            </div>
                            <label class="col-md-3 control-label" for="email">Dividend @</label>
                            <div class="col-md-3">
                                <input name="dividend_at" type="text" class="form-control" placeholder="@" value="{{old('dividend_at',$dividend_at)}}" onkeypress="return isNumAndDecimalKey(event)" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <br>
                            <label class="col-md-3 control-label" for="email">Minimum Share</label>
                            <div class="col-md-3">
                                <input name="minimum_share" type="text" class="form-control" onkeypress="return isNumAndDecimalKey(event)" value="{{old('minimum_share',$minimum_share)}}" required>
                            </div>
                            <label class="col-md-3 control-label" for="email">Maximum Share</label>
                            <div class="col-md-3">
                                <input name="maximum_share" type="text" class="form-control" onkeypress="return isNumAndDecimalKey(event)" value="{{old('maximum_share',@$_REQUEST['maximum_share'])}}" required>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button type="submit" name="view" value="1" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </div>
                    </form> 
                    @if(isset($_REQUEST['_token']))
                  <div>  {{ @($_REQUEST['view'])?$ac_holders->appends(['_token' => $_REQUEST['_token'],'share_as_on' => $_REQUEST['share_as_on'],'maximum_share' => $_REQUEST['maximum_share'],'session_year' => $_REQUEST['session_year'],'paid_on' => $_REQUEST['paid_on'],'dividend_at' => $_REQUEST['dividend_at'],'minimum_share' => $_REQUEST['minimum_share'],'view' => $_REQUEST['view']])->render():'' }}</div>
                       @endif
                    @if(session()->has('errors'))
                    <div class="alert alert-danger">
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                      {{ session()->get('errors') }}
                                  </div>
                              @endif
                  @if(session()->has('success'))
                    <div class="alert alert-info">
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                      {{ session()->get('success') }}
                                  </div>
                              @endif
                    <form class="form-horizontal" action="{{DIVIDEND_CALCULATION_URL}}"  method="post">
                    <div class="row">
                        {{csrf_field()}}
                        <input type="hidden" name="share_on" value="{{$share_as_on}}">
                        <input type="hidden" name="paid_on" value="{{$paid_on}}">
                        <input type="hidden" name="dividend_at" value="{{$dividend_at}}">
                       <input type="hidden" name="session_year" value="{{@$_REQUEST['session_year']}}">
                        
                        <div class="col-md-6 col-md-offset-3">
                            <br>
                            @include('mylayout.ajax-msg')
                        </div>
                       
                    </div>                   
                        
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        <div class="prnt" id="record">
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="8">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h4>
                                                Dividend Paid Upto <strong>{{date('d-M-Y',strtotime($share_as_on))}}</strong> Paid on <strong> {{date('d-M-Y',strtotime($paid_on))}}</strong>
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>                                    
                                    <th>Balance</th>
                                    <th>Dividend @</th>
                                    <th>Dividend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                $sr = 0; 
                                $t1 = 0;    
                                $t2 = 0;    
                                $t3 = 0;    
                                $t4 = 0;    
                                $t5 = 0;    
                                $tdiv = 0;    
                                @endphp
                                @foreach($ac_holders as $val)
                                @php

                               $deposit = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','<',$share_as_on)->sum('amount');

                               $withdraw = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','<',$share_as_on)->sum('amount');

                               $deposit_trans = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Deposit')->where('date_of_transaction','>=',$share_as_on)->where('date_of_transaction','<=',$paid_on)->sum('amount');

                               $withdraw_trans = \App\share_ac_model::where('open_new_ac_model_id',$val->id)->where('type_of_transaction','Withdrawal')->where('date_of_transaction','>=',$share_as_on)->where('date_of_transaction','<=',$paid_on)->sum('amount');

                               $opening_balance = ($deposit - $withdraw);
                                 $balance = $opening_balance;
                                 if($balance > $maximum_share)
                                 {
                                    $balance = $maximum_share;
                                 }

                                 if($balance >= $minimum_share)
                                 {
                                    $tdiv = round(($balance * $dividend_at) / 100);
                                 }
                                 else
                                 {
                                    $tdiv = 0;    
                                 }
                                 
                                @endphp


                               @if($opening_balance <> 0 || $deposit_trans <> 0 || $withdraw_trans <> 0)
                                @php 
                                    $sr++; 
                                    $t1 += $opening_balance;
                                    $t2 += $deposit_trans;
                                    $t3 += $withdraw_trans;
                                    $t4 += $balance;
                                    $t5 += $tdiv;
                                @endphp
                                <tr>
                                    <td>{{$sr}}</td>
                                    <td>{{$val->full_name}}</td>
                                    <td>{{$val->account_no}}</td>                                    
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   {{number_format($balance,2)}}
                                    </td>
                                    <td class="align_right">{{$dividend_at}}%</td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   {{number_format($tdiv,2)}}
                                        <input type="hidden" name="s_no_id[]" value="{{$sr+(@($_REQUEST['page'])?$_REQUEST['page'].'00':00)}}">
                                
                                        <input type="hidden" name="dividend_balance[]" value="{{$tdiv}}">
                                        <input type="hidden" name="balance[]" value="{{$balance}}">
                                        <input type="hidden" name="account_no[]" value="{{$val->account_no}}">
                                        <input type="hidden" name="account_id[]" value="{{$val->id}}">
                                        <input type="hidden" name="full_name[]" value="{{$val->full_name}}">
                                        <input type="hidden" name="branch[]" value="{{$val->branch_model_id}}">
                                        <input type="hidden" name="member_type[]" value="{{$val->member_type_model_id}}">
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t4,2)}}</strong>
                                    </td>
                                    <td></td>
                                     <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t5,2)}}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-md-6 col-md-offset-5 text-center">
                            <button type="submit" class="mr-55 btn btn-primary btn_sizes
                            @if($dividend_at && $minimum_share)
                            show
                            @else
                            hide
                            @endif
                            "> Update
                            </button>
                        </div>
                       
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>
</section>
    <!-- content -->
</aside>
<!-- right-side -->
@endsection