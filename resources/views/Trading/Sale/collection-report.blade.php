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
    <script src="{{ASSETS_JS}}day_book.js"></script>
    <script type="text/javascript">
        function printDiv(printRecord){
            var printContents = $('#record').html();
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        };
    </script>
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
            <li class="active">Sale Collection Report</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
    <div class="col-md-12">
        <div class="panel-body">
            <form action="{{ route('trading.sale.collection.report') }}" method="get">
                {{csrf_field()}}
                <div class="row">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="first-name-column">From</label>
                                <input type="date" class="form-control" value="{{ $fromDate }}" name="fromDate" placeholder="Check-In Date">
                            </div>
                        </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="first-name-column">To</label>
                            <input type="date" class="form-control" value="{{ $toDate }}" name="toDate" placeholder="Check Out Date">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="first-name-column">User</label>
                            <select name="user" class="form-control">
                                <option value="">All</option>
                                @foreach(AllUsers() as $list)
                                    <option value="{{ $list['id'] }}" {{ $list['id'] == request()->get('user') ? 'selected' : '' }}>{{ $list['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-responsive btn-primary btn-sm">View</button>
                            <button type="button" onclick="printDiv('printRecord')" id="printBtn" class="btn btn-success btn_sizes"><i class="fa fa-fw fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>                   
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="prnt" id="record">
                <div class="portlet box primary">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> 
                            Sale Collection From {{ request()->get('fromDate') }} to {{ request()->get('toDate') }} By
                            @if(request()->get('user'))
                                {{ getUserById(request()->get('user'))['name']  }}
                            @else
                                All
                            @endif
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive fixed-table-body">
                            <table class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>SR .No.</th>
                                        <th>Date</th>
                                        <th>Bill No.</th>
                                        <th>Bill Amount</th>
                                        <th>Sale By</th>
                                        <th>Product Type</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($saleData as $list)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($list->date_of_transaction)->format('d-M-Y') }}</td>
                                        <td>{{ $list->bill_no }}</td>
                                        <td>{{ $list->amount }}</td>
                                        <td>{{ getUserById($list->user_id)['name'] }}</td>
                                        <td>{{ getProductTypeById($list->product_type_master_tbl_id)['name'] }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                               Total Records = {{ count($saleData) }}
                            </div>
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