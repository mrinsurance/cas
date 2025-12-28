<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>CAS Software</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="httotalAmount tps://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="col-md-12">
        <div class="invoice">
            <!-- begin invoice-company -->
            <div class="invoice-company text-inverse f-w-600">
            <span class="pull-right hidden-print">
{{--            <a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>--}}
            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
            </span>
                <img src="{{ asset('/') }}assets/img/print-logo.png" alt="" width="80px"> {{ $company_address->name ?? '' }}
            </div>
            <!-- end invoice-company -->
            <!-- begin invoice-header -->
            <div class="invoice-header">
                <div class="invoice-from">
                    <strong class="text-inverse">GSTIN: {{ $company_address->gst_number ?? '' }} <br></strong>
                    <address class="m-t-5 m-b-5">
                        {{ $company_address->address ?? '' }} <br>
                        Tehsil: {{ $company_address->tehsil ?? '' }} <br>
                        Pin Code: {{ $company_address->pin_code ?? '' }} <br>
                        Mobile: {{ $company_address->mobile ?? '' }} <br>
                    </address>
                </div>
                <div class="invoice-to">
                    <small>To</small>
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">{{ SalePartyNameById($item->client)['name'] ?? '---' }}</strong><br>
                        Address: {{ SalePartyNameById($item->client)['address'] ?? '---' }}
                    </address>
                </div>
                <div class="invoice-date">
                    <small>Invoice</small>
                    <div class="invoice-detail">
                        #{{ $item->invoice_no }}<br>
                    </div>
                    <div class="date text-inverse m-t-5">{{ \Carbon\Carbon::parse($item->date_of_transaction)->format('F d, Y') }}</div>

                </div>
            </div>
            <!-- end invoice-header -->
            <!-- begin invoice-content -->
            <div class="invoice-content">
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table class="table table-invoice table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center" width="2%">SrNo</th>
                            <th class="text-center" width="10%">Desc. Of Goods</th>
                            <th class="text-center" width="8%">HSN</th>
                            <th class="text-center" width="8%">Quantity</th>
                            <th class="text-center" width="8%">Rate</th>
                            <th class="text-center" width="8%">Total</th>
                            <th class="text-center" width="8%">Disc</th>
                            <th class="text-center" width="8%">Taxable Amount</th>
                            <th class="text-center" width="8%" colspan="2">SGST</th>
                            <th class="text-center" width="8%" colspan="2">CGST</th>
                            <th class="text-center" width="8%" colspan="2">IGST</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center" width="">Rate</th>
                            <th class="text-center" width="">Amount</th>
                            <th class="text-center" width="">Rate</th>
                            <th class="text-center" width="">Amount</th>
                            <th class="text-center" width="">Rate</th>
                            <th class="text-center" width="">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $saleTotal = 0;
                        $saleDiscountTotal = 0;
                        $saleSGSTAmountTotal = 0;
                        $saleCGSTAmountTotal = 0;
                        $saleIGSTAmountTotal = 0;
                        $totalAmount = 0;
                        @endphp
                        @foreach(saleDetailBySaleId($item->id) as $sale)
                            @php
                                $calculation = SaleDetailCalculation($sale->id);
                                $saleTotal = $saleTotal + $calculation['total'];
                                $saleSGSTAmountTotal = $saleSGSTAmountTotal + $sale->sgst;
                                $saleCGSTAmountTotal = $saleCGSTAmountTotal + $sale->cgst;
                                $saleIGSTAmountTotal = $saleIGSTAmountTotal + $sale->igst;
                                $totalAmount = $saleTotal + $saleSGSTAmountTotal + $saleCGSTAmountTotal + $saleIGSTAmountTotal;
                            @endphp
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td class="text-center">
                                <span class="text-inverse">{{$sale->product_master_tbl->name ?? ''}}</span>
                            </td>
                            <td class="text-center">
                                {{$sale->product_master_tbl->hsn ?? ''}}
                            </td>
                            <td class="text-center">{{$sale->quantity}} {{$sale->product_master_tbl->unit_master_tbl->name ?? ''}}</td>
                            <td class="text-right">{{number_format($sale->rate,2)}}</td>
                            <td class="text-right">{{ number_format($calculation['total'],2) }}</td>
                            <td class="text-right">0</td>
                            <td class="text-right">{{ number_format($calculation['total'],2) }}</td>
                            <td class="text-right">{{ $sale->tax / 2 }}</td>
                            <td class="text-right">{{number_format($sale->sgst,2)}}</td>
                            <td class="text-right">{{ $sale->tax / 2 }}</td>
                            <td class="text-right">{{number_format($sale->cgst,2)}}</td>
                            <td class="text-right">0</td>
                            <td class="text-right">0</td>
                        </tr>
                        @endforeach
                        <tr class="bg-light">
                            <td class="text-right" colspan="5">Total=</td>
                            <td class="text-right">{{ number_format($saleTotal,2) }}</td>
                            <td class="text-right">0</td>
                            <td class="text-right">{{ number_format($saleTotal,2) }}</td>
                            <td class="text-right"></td>
                            <td class="text-right">{{ number_format($saleSGSTAmountTotal,2) }}</td>
                            <td class="text-right"></td>
                            <td class="text-right">{{ number_format($saleCGSTAmountTotal,2) }}</td>
                            <td class="text-right"></td>
                            <td class="text-right">{{ number_format($saleIGSTAmountTotal,2) }}</td>

                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
                <!-- begin invoice-price -->
                <div class="invoice-price">
                    <div class="invoice-price-left">
                        <div class="invoice-price-row">
                            <div class="sub-price">
                                <small>TAXABLE AMOUNT</small>
                                <span class="text-inverse"><i class="fa fa-inr"></i> {{ number_format($saleTotal,2) }}</span>
                            </div>
                            <div class="sub-price">
                                <i class="fa fa-plus text-muted"></i>
                            </div>
                            <div class="sub-price">
                                <small>SGST</small>
                                <span class="text-inverse"><i class="fa fa-inr"></i> {{ number_format($saleSGSTAmountTotal,2) }}</span>
                            </div>
                            <div class="sub-price">
                                <i class="fa fa-plus text-muted"></i>
                            </div>
                            <div class="sub-price">
                                <small>CGST</small>
                                <span class="text-inverse"><i class="fa fa-inr"></i> {{ number_format($saleCGSTAmountTotal,2) }}</span>
                            </div>
                            <div class="sub-price">
                                <i class="fa fa-plus text-muted"></i>
                            </div>
                            <div class="sub-price">
                                <small>IGST</small>
                                <span class="text-inverse"><i class="fa fa-inr"></i> {{ number_format($saleIGSTAmountTotal,2) }}</span>
                            </div>
                            <div class="sub-price">
                                <h3 class="text-muted">=</h3>
                            </div>
                            <div class="sub-price">
                                <small>Total</small>
                                <span class="text-inverse"><i class="fa fa-inr"></i> {{ number_format($totalAmount,2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="invoice-price-row">
                    <div class="sub-price">
                        <hr>
                        <small><strong>Total in Words:</strong> {{ getIndianCurrency($totalAmount) }}</small>
                    </div>
                </div>
                <!-- end invoice-price -->
            </div>
            <!-- end invoice-content -->
            <!-- begin invoice-note -->
            <div class="invoice-note">
                <p class="text-right m-b-5 f-w-600">
                    <span class="font-weight-bold"><em><u>Signature of Salesman</u></em></span>
                </p>


            </div>
            <div class="invoice-note">
                <div>
                    * Goods once sold not be returnable<br>
                </div>

            </div>
            <!-- end invoice-note -->
            <!-- begin invoice-footer -->
            <div class="invoice-footer">
                <p class="text-center m-b-5 f-w-600">
                    THANK YOU FOR YOUR BUSINESS
                </p>

            </div>
            <!-- end invoice-footer -->
        </div>
    </div>
</div>

<style type="text/css">
    body{
        margin-top:20px;
        background:#eee;
    }

    .invoice {
        background: #fff;
        padding: 20px
    }

    .invoice-company {
        font-size: 20px
    }

    .invoice-header {
        margin: 0 -20px;
        background: #f0f3f4;
        padding: 20px
    }

    .invoice-date,
    .invoice-from,
    .invoice-to {
        display: table-cell;
        width: 1%
    }

    .invoice-from,
    .invoice-to {
        padding-right: 20px
    }

    .invoice-date .date,
    .invoice-from strong,
    .invoice-to strong {
        font-size: 16px;
        font-weight: 600
    }

    .invoice-date {
        text-align: right;
        padding-left: 20px
    }

    .invoice-price {
        background: #f0f3f4;
        display: table;
        width: 100%
    }

    .invoice-price .invoice-price-left,
    .invoice-price .invoice-price-right {
        display: table-cell;
        padding: 20px;
        font-size: 20px;
        font-weight: 600;
        width: 75%;
        position: relative;
        vertical-align: middle
    }

    .invoice-price .invoice-price-left .sub-price {
        display: table-cell;
        vertical-align: middle;
        padding: 0 20px
    }

    .invoice-price small {
        font-size: 12px;
        font-weight: 400;
        display: block
    }

    .invoice-price .invoice-price-row {
        display: table;
        float: left
    }

    .invoice-price .invoice-price-right {
        width: 25%;
        background: #2d353c;
        color: #fff;
        font-size: 28px;
        text-align: right;
        vertical-align: bottom;
        font-weight: 300
    }

    .invoice-price .invoice-price-right small {
        display: block;
        opacity: .6;
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 12px
    }

    .invoice-footer {
        border-top: 1px solid #ddd;
        padding-top: 10px;
        font-size: 10px
    }

    .invoice-note {
        color: #999;
        margin-top: 80px;
        font-size: 85%
    }

    .invoice>div:not(.invoice-footer) {
        margin-bottom: 20px
    }

    .btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
        color: #2d353c;
        background: #fff;
        border-color: #d9dfe3;
    }
    .table td, .table th {
         padding: 2px !important;
    }

</style>

<script type="text/javascript">

</script>
</body>
</html>
