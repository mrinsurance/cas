<!DOCTYPE html>
<html>
<head>
	<title>Interest On Saving List</title>
</head>
<body>
<div class="prnt" id="record">                         
                           <table class="table table-bordered table-hover" id="mytable_css">
                            <thead>
                               <tr>
                                    <td colspan="11">
                                        <div class="col-md-12 text-center">
                                            <h3>
                                                {{$company_address->name}}
                                            </h3>
                                                {{$company_address->address}}
                                            <h4>
                                                Interest Paid On {{$member_type}} From <strong>{{date('d-M-Y',strtotime($share_on))}}</strong> To <strong> {{date('d-M-Y',strtotime($paid_on))}}</strong>
                                            </h4>    
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>                                    
                                    <th>Saving</th>
                                    <th>Interest Amt</th>
                                    <th>Total Amt</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $t4 = 0;
                                    $t5 = 0;
                                @endphp
                                @foreach($items as $item)
                                
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$item->open_new_ac_model->full_name}}</td>
                                    <td>{{$item->account_no}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$item->share}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$item->dividend_amt}}</td>
                                    <td class="align_right"><i class="fa fa-inr"></i> {{$item->share + $item->dividend_amt}}</td>
                                    
                                </tr>
                                    @php 
                                        $t4 += $item->share; 
                                        $t5 += $item->dividend_amt;
    
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t4,2)}}</strong>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td class="align_right">
                                        <i class="fa fa-inr"></i>   
                                        <strong>{{number_format($t5,2)}}</strong>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     
                                </tr>
                            </tbody>
                        </table>
                    </div>
</body>
</html>