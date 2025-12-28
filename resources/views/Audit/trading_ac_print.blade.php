<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="{{ASSETS_CSS}}app.css" rel="stylesheet" type="text/css" />
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
</head>
<body>
                        <div class="prnt" id="record">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>
                                {{$company_address->name}}
                            </h3>
                                {{$company_address->address}}
                            <h4>
                                Trading Account From {{date('d-M-Y',strtotime($from_date))}} To {{date('d-M-Y',strtotime($to_date))}}
                            </h4>    
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2" width="50%">CREDIT</th>
                                    <th scope="col" colspan="2">DEBIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICUALR</th>
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
@php
$gl = 0;
$gp = 0;
@endphp

                                                @foreach($crTblLedgers->where('gtype','SALES ACCOUNT') as $drList)
                                                @php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->sum('amount');
                                                  
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach($crTblLedgers->where('gtype','DIRECT INCOME') as $drList)
                                                @php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->sum('amount');
                                                   
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td>CLOSING STOCK</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($closingStock,2)}}</td>
                                                </tr>
                                                @if($drTotal > $crTotal)
                                                @php $gl = ($drTotal - $crTotal); @endphp
                                                <tr>
                                                    <td><strong>GROSS LOSS</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($gl,2)}}</td>
                                                </tr>
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICULAR</th>
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
                                                <tr>
                                                    <td>OPENING STOCK</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($openingStock,2)}}</td>
                                                </tr>
                                               
                                                @foreach($drTblLedgers->where('gtype','PURCHASE ACCOUNT') as $drList)
                                                @php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->sum('amount');
                                                  
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach($drTblLedgers->where('gtype','DIRECT EXPENSES') as $drList)
                                                @php
                                                   $mHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->sum('amount');
                                                   
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($mHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                @if($crTotal > $drTotal)
                                                @php $gp = ($crTotal - $drTotal); @endphp
                                                <tr>
                                                    <td><strong>GROSS PROFIT</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($gp,2)}}</td>
                                                </tr>
                                                @endif                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    @if($drTotal > $crTotal)
                                        <td class="align_right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($crTotal + ($drTotal - $crTotal),2)}}</td>
                                    @else
                                        <td class="align_right"  colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($crTotal,2)}}</td>
                                    @endif

                                    @if($crTotal > $drTotal)
                                        <td class="align_right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($drTotal + ($crTotal - $drTotal),2)}}</td>
                                    @else
                                        <td class="align_right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($drTotal,2)}}</td>
                                    @endif  
                                </tr>
                            </tbody>
                        </table>
                        </div>
<!-- Profit and loss account  -->
@php
$plcrTotal = $plcrTotal + $gp;
$pldrTotal = $pldrTotal + $gl;

$pldrTotal = ($pldrTotal + $npaAmt + $npaIntr + $intrFd + $intrRd);
$plcrTotal = ($plcrTotal + $intrLoan + $intrBankFd + $intrBankRd);

$lbspldrTotal = ($lbsintrLoan + $lbsintrBankFd + $lbsintrBankRd);
$lbsplcrTotal = ($lbsintrFd + $lbsintrRd);

$lbsNpa = ($lbsnpaAmt + $lbsnpaIntr);

$pldrTotal = ($pldrTotal + $lbspldrTotal);
$plcrTotal = ($plcrTotal + $lbsplcrTotal + $lbsNpa);

$intrPaid = ($intrFd + $intrRd + $lbsintrLoan + $lbsintrBankFd + $lbsintrBankRd);
$intrRec = ($intrLoan + $intrBankFd + $intrBankRd + $lbsintrFd + $lbsintrRd);
$intrNpa = 0;
@endphp
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4>
                                Profit & Loss Account From {{date('d-M-Y',strtotime($from_date))}} To {{date('d-M-Y',strtotime($to_date))}}
                            </h4>    
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <!-- Print view                         -->
                        
                            
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2" width="50%">INCOME</th>
                                    <th scope="col" colspan="2">EXPENSES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICUALR</th>
                                                    <th>&nbsp;</th>
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
                                                @if($gp > 0)
                                                <tr>
                                                    <td>GROSS PROFIT</td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($gp,2)}}</td>
                                                </tr>
                                                @endif
                                                @foreach($plcrTblLedgers->where('gtype','INDIRECT INCOME') as $drList)
                                                @php
                                                   $plmHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->sum('amount');
                                                  
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($plmHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach($plcrTblLedgers->where('gtype','INTEREST RECEIVED') as $drList)
                                                @php
                                                   $plmHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->sum('amount');
                                                   $intrRec = $intrRec + $plmHeadAmt;
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($plmHeadAmt,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                @endforeach
                                               <tr>
                                                    <td>INTEREST RECOVERABLE ON LOAN</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrLoan,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>INTEREST RECOVERABLE ON BANK FD</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrBankFd,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>INTEREST RECOVERABLE ON BANK RD</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrBankRd,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>INTEREST PAYABLE LBS</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($lbsplcrTotal,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>INTEREST RECEIVED</strong></td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(($intrRec),2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>NPA LBS</td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($lbsNpa,2)}}</td>
                                                    
                                                </tr>
                                                @if($pldrTotal > $plcrTotal)
                                                <tr>
                                                    <td><strong>NET LOSS</strong></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(($pldrTotal - $plcrTotal),2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                    <td colspan="2">
                                        <table  class="table table-bordered table-hover" id="mytable_css">
                                            <tbody>
                                                <tr>
                                                    <th>PARTICULAR</th>
                                                    <th>&nbsp;</th>
                                                    <th class="align_right">AMOUNT</th>
                                                </tr>
                                                @if($gl > 0)
                                                <tr>
                                                    <td>GROSS LOSS</td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($gl,2)}}</td>
                                                </tr>
                                                @endif
                                                
                                               
                                                @foreach($pldrTblLedgers->where('gtype','INDIRECT EXPENSES') as $drList)
                                                @php
                                                   $plmHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->sum('amount');
                                                  $intrPaid = $intrPaid + $plmHeadAmt;
                                                @endphp
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td></td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($plmHeadAmt,2)}}</td>
                                                </tr>
                                                @endforeach

                                                @foreach($pldrTblLedgers->where('gtype','INTEREST PAID') as $drList)
                                                @php
                                                   $plmHeadAmt =  App\tbl_ledger_model::where('main_head',$drList->main_head)->sum('amount');
                                                   
                                                @endphp
                                                
                                                <tr>
                                                    <td>{{$drList->main_head}}</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($plmHeadAmt,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                @endforeach
                                                
                                                <tr>
                                                    <td>INTEREST PAYBLE ON FD</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrFd,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>INTEREST PAYBLE ON RD</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($intrRd,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>INTEREST RECOVERABLE LBS</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($lbspldrTotal,2)}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>INTEREST PAID</strong></td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(($intrPaid),2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>NPA AMOUNT</td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($npaAmt,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>NPA INTEREST</td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format($npaIntr,2)}}</td>
                                                </tr>

                                                @if($plcrTotal > $pldrTotal)
                                                <tr>
                                                    <td><strong>NET PROFIT</strong></td>
                                                    <td>&nbsp;</td>
                                                    <td class="align_right"><i class="fa fa-inr"></i> {{number_format(($plcrTotal - $pldrTotal),2)}}</td>
                                                </tr>
                                                @endif                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    @if($pldrTotal > $plcrTotal)
                                        <td class="align_right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($plcrTotal + ($pldrTotal - $plcrTotal),2)}}</td>
                                    @else
                                        <td class="align_right"  colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($plcrTotal,2)}}</td>
                                    @endif

                                    @if($plcrTotal > $pldrTotal)
                                        <td class="align_right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($pldrTotal + ($plcrTotal - $pldrTotal),2)}}</td>
                                    @else
                                        <td class="align_right" colspan="2"><strong class="ml-55">TOTAL:</strong> <i class="fa fa-inr"></i> {{number_format($pldrTotal,2)}}</td>
                                    @endif  
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
</body>
</html>