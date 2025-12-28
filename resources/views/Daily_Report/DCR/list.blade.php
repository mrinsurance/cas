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

@endpush

@push('extra_js')
    <script src="{{ASSETS_VENDORS}}favicon/favicon.js"></script>
    <script src="{{ASSETS_VENDORS}}jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="{{ASSETS_VENDORS}}iCheck/js/icheck.js"></script>
    <script src="{{ASSETS_JS}}pages/form_examples.js"></script>
    <script type="text/javascript" src="{{ASSETS_JS}}form-post.js"></script>
    <script src="{{ASSETS_JS}}day_book.js"></script></script>
    <!-- end of page level js -->
@endpush

@section('body')


<aside class="right-side strech">

    <section class="content-header">
        <!--section starts-->
        <h1>Daily Collection Report</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li class="active">Daily Collection Report</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
    <div class="col-md-12">
        <div class="panel-body">
            <form class="form-horizontal" action="{{DAILY_REPORT_URL_DCR}}" method="get">
                {{csrf_field()}}
                <fieldset>
                    <!-- Name input-->
                    <div class="form-group">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">From</label>
                                <div class="col-md-10">
                                    <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$from_date)}}" name="from_date" id="from_date" placeholder="Check-In Date">
                                    <br>
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">View</button>
                                    <button type="submit" class="btn btn-responsive btn-warning btn-sm">Print</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">To</label>
                                <div class="col-md-10">
                                    <input type="date" class="form-control" value="{{old(date('Y-m-d'),@$to_date)}}" name="to_date" id="to_date" placeholder="Check Out Date">
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->staff_type == 'Staff')
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">Branch</label>
                                <div class="col-md-10 text-left">
                                    <select name="branch" class="form-control">
                                        <option value="">All</option>
                                        @foreach($branches as $branch)
                                        <option value="{{$branch->id}}" {{@$search_branch == $branch->id ? 'selected' : ''}}>{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">Users</label>
                                <div class="col-md-10 text-left">
                                    <select name="user_type" class="form-control">
                                        <option value="">All</option>
                                        @foreach($users as $val)
                                        <option value="{{$val->id}}" {{@$search_user == $val->id ? 'selected' : ''}}>{{$val->name}} ({{@$val->designation_model->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>                   
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> 
                            Receipt (Collection Report of {{@$search_branch != '' ? $branch_name->name : 'All'}} Branch, collect by {{@$search_user != '' ? $user_name->name : 'All'}})
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive fixed-table-body">
                            <table class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>A/C No</th>
                                        <th>Particular</th>
                                        <th>Received</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
<!-- Gtype grouping -->
                                @php $receipt = 0; $payment = 0; @endphp
                                    @foreach($gtype_groups as $group)
                                    <tr>
                                        <td class="bg-default" colspan="6">{{$group->gtype}}</td>
                                    </tr>
<!-- Stype loop -->
                                    @foreach($stypes->where('gtype',$group->gtype) as $stype)
                                    <tr>
                                        <td>{{date('d-M-Y',strtotime($stype->date_of_transaction))}}</td>
                                        <td>{{$stype->account_no}}</td>
                                        <td>{{$stype->particular}}</td>
                                        <td class="must-right">
                                            @if($stype->type_of_transaction == 'Cr') 
                                            @php $receipt += $stype->amount + $stype->additional_amt; @endphp
                                                <i class="fa fa-inr"></i> {{number_format($stype->amount + $stype->additional_amt,2)}}
                                            @endif
                                        </td>
                                        <td class="must-right">
                                            @if($stype->type_of_transaction == 'Dr') 
                                            @php $payment += $stype->amount + $stype->additional_amt; @endphp
                                                <i class="fa fa-inr"></i> {{number_format($stype->amount + $stype->additional_amt,2)}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($stype->shadow == 0)
                                                <span class="text text-warning">Shadow</span>    
                                            @else
                                                <span class="text text-success">Clear</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="bg-grey">Total</td>
                                        <td class="bg-grey must-right"><i class="fa fa-inr"></i> {{number_format($receipt,2)}}</td>
                                        <td class="bg-grey must-right"><i class="fa fa-inr"></i> {{number_format($payment,2)}}</td>
                                        <td class="bg-grey must-right">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="bg-danger">Due Balance</td>
                                        <td class="bg-danger must-right"><i class="fa fa-inr"></i> {{number_format(($receipt - $payment),2)}}</td>
                                        <td class="bg-danger must-right">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
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