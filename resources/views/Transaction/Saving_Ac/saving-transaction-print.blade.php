@extends('mylayout.master')

@push('extra_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title','DashBoard | Cyrus Banking')

@push('extra_css')
    <link href="{{ASSETS_CSS}}pages/invoice.css" rel="stylesheet" type="text/css" />
@endpush

@push('extra_js')
 <script src="{{ASSETS_JS}}pages/invoice.js" type="text/javascript"></script>
@endpush

@section('body')
<aside class="right-side strech">

            <!-- Main content -->
            <section class="content paddingleft_right15">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-success">
                            <div class="panel-body" style="border:1px solid #ccc;padding:0;margin:0;">
                                <div class="row" style="padding: 15px;margin-top:5px;">
                                    
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <h3>{{$company_profile->name}}</h3>
                                            {{$company_profile->address}}
                                            <br><strong>Saving
                                            {{$item->type_of_transaction}}
                                             Receipt</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 15px;">
                                    <div class="col-md-9 col-xs-6" style="margin-top:5px;">
                                        <strong>@if($item->type_of_transaction == 'Deposit')Received From: @else Paid To: @endif</strong>
                                        <br> {{$item->open_new_ac_model->full_name}}
                                        <br> {{$item->open_new_ac_model->current_address_first}}
                                        <br>
                                        <button class="btn btn-default"><h4><i class="fa fa-inr"></i> {{@$item->amount}}/-</h4></button>
                                        <br>
                                        ({{\App\Http\Controllers\Transaction\bankFdController::convert_number_to_words(@$item->amount)}} only)
                                        <br>
                                        <h5>Print Date - {{date('d-M-Y')}}</h5>
                                    </div>
                                    <div class="col-md-3 col-xs-6" style="padding-right:0">
                                        <div id="invoice" style="background-color: #eee;text-align:right;padding: 15px;padding-bottom:23px;border-bottom-left-radius: 6px;border-top-left-radius: 6px;">
                                            <h4><strong>Receipt No. - {{@$voucher->voucher_no}}</strong></h4>
                                            <h4>{{date('d M Y',strtotime($item->date_of_transaction))}}</h4>
                                            {{$item->member_type_model->name}} A/C - ({{$item->account_no}})
                                            <br>          
                                        </div>
                                        <div id="invoice" style="text-align:right;padding: 15px;padding-bottom:23px;border-bottom-left-radius: 6px;border-top-left-radius: 6px;">
                                            <br><br>
                                            Authorized Signatory
                                            <br>
                                        </div>
                                    </div>
                                </div>
                               
                                <div style="background-color: #eee;padding:15px;" id="footer-bg">
                                    
                                    <div style="margin:10px 20px;text-align:center;" class="btn-section">
                                        <button type="button" class="btn btn-responsive button-alignment btn-info" data-toggle="button">
                                            <span style="color:#fff;" onclick="javascript:window.print();">
                                            <i class="livicon" data-name="printer" data-size="16" data-loop="true"
                                               data-c="#fff" data-hc="white" style="position:relative;top:3px;"></i>
                                            Print
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- content -->
        </aside>
@endsection