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
    <script src="{{ASSETS_JS}}day_book.js"></script>
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
        <h1>Balance Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Loan Balance</li>
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
                        <i class="livicon" data-name="list" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Balance Report of Loan A/C
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="forms-sample" action="{{ route('setting.loan-controller-second') }}" method="get">
                        {{csrf_field()}}
                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">As On</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" placeholder="Check-In Date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Branch</label>
                            <div class="col-md-8">
                                <select name="branch" class="form-control">
                                    <option value="">All</option>
                                    @foreach($branches as $val)
                                    <option value="{{$val->id}}" {{@$branch == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Type</label>
                            <div class="col-md-8">
                                <select name="member_type" class="form-control">
                                    <option value="">All</option>
                                    @foreach($members as $val)
                                    <option value="{{$val->id}}" {{@$member_type == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="email">Loan Type</label>
                            <div class="col-md-8">
                                <select name="loan_type" class="form-control">
                                    <option value="">All</option>
                                    @foreach($loan_types as $val)
                                    <option value="{{$val->id}}" {{$loan_type == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="category">Category</label>
                            <div class="col-md-8">
                                <select name="category" class="form-control">
                                    <option value="">All</option>
                                    @foreach(CategoryTypeList() as $val)
                                    <option value="{{$val['name']}}">{{$val['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="gender">Gender</label>
                            <div class="col-md-8">
                                <select name="gender" class="form-control">
                                    <option value="">All</option>
                                    @foreach(GenderTypeList() as $val)
                                        <option value="{{$val['name']}}">{{$val['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 col-md-offset-5">
                            <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-fw fa-eye"></i> View</button>

                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>

                    </div>
                    </div>
                    </form>
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        <div class="prnt" id="record">

                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <td colspan="24">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h4>
@foreach($members as $val)
@if($val->id == $member_type)
{{$val->name}}
@endif
@endforeach

@foreach($loan_types as $val)
@if($val->id == $loan_type)
{{$val->name}}
@endif
@endforeach
                                     LOAN BALANCE REPORT AS ON {{date('d-M-Y',strtotime($from_date))}}
                                            </h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Admission No.</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>Loan Type</th>
                                    <th>Purpose</th>
                                    <th>Loan Date</th>
                                    <th>Loan Amount</th>
                                    <th>Due Date</th>
                                    <th>ROI</th>
                                    <th>PROI</th>
                                    <th>Installment Amount</th>
                                    <th>F-Installment Date</th>
                                    <th>Period</th>
                                    <th>Loan's Balance</th>
                                    <th>Last Recover Date</th>
                                    <th>Recoverable Intr</th>
                                    <th>Guarantor (A/C) - 1</th>
                                    <th>Guarantor (A/C) - 2</th>
                                    <th>Transaction Date</th>
                                    <th>Disbursal Amount</th>
                                    <th>Received PL</th>
                                    <th>Received INT</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $total_of_balance = 0;
                                    $total_recover_int = 0;
                                @endphp
                                @foreach($items as $key => $item)
                                @php
 //Sum of received principal from loan return table
                                $tbl_loan_return_model_sum = \App\tbl_loan_return_model::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(tbl_loan_return_models.received_principal),0) total_received_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->where('received_date','<=',$from_date)
                                ->first();

//Loan installment

                                @endphp
                                @if(($item->amount - $tbl_loan_return_model_sum->total_received_principal) > 0)
@php
//Get days from loan return table
            $tbl_loan_return_model_days = \App\tbl_loan_return_model::select('id','loan_ac_model_id','received_date','pending_intr')
            ->orderBy('received_date','desc')
            ->where('loan_ac_model_id',$item->id)
            ->where('received_date','<=',$from_date)
            ->first();
            if($tbl_loan_return_model_days)
            {
                $_rdate = $tbl_loan_return_model_days->received_date;
                $pendingInterest =  $tbl_loan_return_model_days->pending_intr;
            }
            else
            {
                $_rdate = $item->date_of_advance;
                $pendingInterest = 0;
            }
            $fdate=date('Y-m-d',strtotime($_rdate));
            $tdate=date('Y-m-d',strtotime($from_date));

            $to = \Carbon\Carbon::createFromFormat('Y-m-d', $fdate);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $tdate);
            $diff_in_days = $to->diffInDays($from);
//Overdue principal from loan installment table
            $loan_ac_installment_sum = \App\loan_ac_installment::select('id','loan_ac_model_id',DB::raw('IFNULL(sum(loan_ac_installments.principal),0) total_principal'))
                                ->where('loan_ac_model_id',$item->id)
                                ->where('installment_date','<=',$from_date)
                                ->first();
$_over_amount = 0;
if($loan_ac_installment_sum->total_principal > $tbl_loan_return_model_sum->total_received_principal)
{
    $_over_amount = $loan_ac_installment_sum->total_principal - $tbl_loan_return_model_sum->total_received_principal;
}
$_amount = ($item->amount - $tbl_loan_return_model_sum->total_received_principal) - $_over_amount;

//Calculating interest Reduce and flat

            $cintr = 0;
            $ointr = 0;
            $tintr = 0;



              if(($_over_amount + $_amount) > 0)
              {
                $ointr = ((($_over_amount * $diff_in_days) * $item->pannelty_int) / 36500);

                $cintr = ((($_amount * $diff_in_days) * $item->interest) / 36500);

                $tintr = $cintr + $ointr;
              }
              else{
                $tintr = 0;

            }

        $tintr = round($tintr + $pendingInterest);


@endphp


                                <tr>
                                    <td>{{$i++}} {{$tbl_loan_return_model_sum->principal}}</td>
                                    <td>{{@$item->open_new_ac_model->id}}</td>
                                    <td>{{@$item->open_new_ac_model->full_name}}</td>
                                    <td>{{$item->account_no ?? ''}}</td>
                                    <td>{{ LoanModelById($item->loan_type ?? 0)}}</td>
                                    <td>{{ PurposeById($item->loan_purpose ?? 0)}}</td>
                                    <td class="align_right">{{ \Carbon\Carbon::parse($item->date_of_advance)->format('Y-m-d')}}</td>
                                    <td class="align_right">{{ $item->amount ?? 0  }}</td>
                                    <td class="align_right">{{ \Carbon\Carbon::parse($item->date_of_advance)->addMonth($item->months)->format('Y-m-d') }}</td>
                                    <td class="align_right">{{ $item->interest ?? 0 }}</td>
                                    <td class="align_right">{{ $item->pannelty_int ?? 0 }}</td>
                                    <td class="align_right">{{ LoanAccountInstallmentById($item->id)['principal'] ?? 0 }}</td>
                                    <td class="align_right">{{ LoanAccountInstallmentById($item->id)['installment_date'] ?? '' }}</td>
                                    <td class="align_right">{{ $item->months ?? '' }}</td>
                                    <td class="align_right"> {{($item->amount - $tbl_loan_return_model_sum->total_received_principal)}}</td>
                                    <td class="align_right">{{ \Carbon\Carbon::parse($_rdate)->format('Y-m-d')}}</td>
                                    <td class="align_right"> {{$tintr ?? 0}}</td>
                                    <td>
                                        @php
                                        $guarnter_one = DB::table('open_new_ac_models')->where('id',$item->guarnter_one)->first();
                                        @endphp
                                        {{@$guarnter_one->full_name}} ({{@$guarnter_one->account_no}})
                                    </td>
                                    <td>
                                        @php
                                            $guarnter_two = DB::table('open_new_ac_models')->where('id',$item->guarnter_two)->first();
                                        @endphp
                                        {{@$guarnter_two->full_name}} ({{@$guarnter_two->account_no}})
                                    </td>
                                    <td class="align_right">
                                        {{ \Carbon\Carbon::parse($item->date_of_advance)->format('Y-m-d')}}
                                        <br>
                                        @foreach(LoanReturnById($item->id, $from_date) as $loanReturnList)
                                            {{ \Carbon\Carbon::parse($loanReturnList->received_date)->format('Y-m-d')}}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td class="align_right">{{ $item->amount ?? 0  }}</td>
                                    <td>
                                        <br>
                                        @foreach(LoanReturnById($item->id, $from_date) as $loanReturnList)
                                            {{ $loanReturnList->received_principal ?? 0 }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <br>
                                        @foreach(LoanReturnById($item->id, $from_date) as $loanReturnList)
                                            {{ $loanReturnList->received_interest ?? 0 }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td></td>
                                </tr>
                                @php
                                    $total_of_balance += ($item->amount - $tbl_loan_return_model_sum->total_received_principal);
                                    $total_recover_int += $tintr;
                                @endphp
                                @endif
                                @endforeach
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td class="align_right"> <strong>{{$total_of_balance ?? 0}}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td class="align_right"> <strong>{{$total_recover_int ?? 0}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
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