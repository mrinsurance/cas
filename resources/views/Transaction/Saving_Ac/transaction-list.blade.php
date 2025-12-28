@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link rel="stylesheet" type="text/css" href="{{ASSETS_VENDORS}}datatables/css/dataTables.bootstrap.css" />
    <link href="{{ASSETS_CSS}}pages/tables.css" rel="stylesheet" type="text/css" />
@endpush

@push('extra_js')
  <script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="{{ASSETS_VENDORS}}datatables/js/dataTables.bootstrap.js"></script>
  <script src="{{ASSETS_SRC_JS}}pages/table-responsive.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}bootbox.js"></script>
  <script type="text/javascript" src="{{ASSETS_JS}}deleteconfirm.js"></script>
@endpush

@section('body')

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side strech">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--section starts-->
        <h1>Saving A/c List - {{$profile->member_type_model->name}} A/C No. -  {{$profile->account_no}} ({{$profile->full_name}})</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{HOME_LINK}}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{TRANSACTION_URL_SAVING_AC}}">
                     Saving A/C
                </a>
            </li>
            <li class="active">A/c Transaction Detail</li>
        </ol>
    </section>
    <!--section ends-->
        <section class="content">
        <div class="row">
            <div class="col-md-12">

                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box primary">
                    <div class="panel-heading portlet-title">
                        <h3 class="panel-title pull-left add_remove_title">
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> A/c Transaction Detail
                        </h3>
                    </div>
                    
                    <div class="portlet-body">
                        @include('mylayout.ajax-msg')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Transaction Date</th>
                                        <th>Deposit Amount</th>
                                        <th>Withdrawal Amount</th>
                                        <th>Balance</th>
                                        <th>Transaction Particular</th>
                                        <th>Action</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                    $val = 0;
                                    @endphp
                                    @foreach($items as $item)
                                      <tr id="product{{$item->id}}">
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{date('d-M-Y',strtotime($item->date_of_transaction))}}</td>
                                        <td>
                                          @if($item->type_of_transaction == 'Deposit')
                                            {{number_format($item->amount)}}
                                          @endif  
                                        </td>
                                        <td>
                                           @if($item->type_of_transaction == 'Withdrawal')
                                            {{number_format($item->amount)}}
                                          @endif  
                                        </td>
                                        <td>
                                          @php
                                            
                                            if($item->type_of_transaction == 'Deposit')
                                            {
                                              $val = $val + $item->amount;
                                            }
                                            else{
                                            $val = $val - $item->amount;
                                          }
                                          @endphp
                                          {{number_format($val)}}
                                          </td>
                                        <td>
                                          {{$item->particular}}
                                        </td>
                                        <td>
                                            @if(!$CheckLock)
                                          @can('product-edit')
                                          <a href="{{TRANSACTION_URL_SAVING_AC.''.$item->id}}/edit" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></a>

                                          @endcan
                                          <a href="{{TRANSACTION_URL_SAVING_AC.''.$item->id}}/print" target="_blank" class="btn btn-success btn_sizes" title="Print"><i class="fa fa-fw fa-print"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                          {{$item->remarks}}
                                        </td>
                                      </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
    </section>
    <!-- content -->
</aside>
<!-- right-side -->
@endsection