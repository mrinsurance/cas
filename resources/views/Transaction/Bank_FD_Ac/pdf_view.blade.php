<!DOCTYPE html>
<html>
<head>
  <title>All Staff Attendance - PDF</title>
<link href="{{ASSETS_CSS}}print-css/bootstrap.min.css" rel="stylesheet">
<link href="{{ASSETS_VENDORS}}simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css" />
<link href="{{ASSETS_VENDORS}}ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<link href="{{ASSETS_CSS}}pages/icon.css" rel="stylesheet" type="text/css" />

<style>
  .text-danger strong {
        color: #9f181c;
    }
    .receipt-main {
      border: 5px double #3c76ab;
      border-radius: 15px;
      background: #ffffff none repeat scroll 0 0;
      margin-top: 50px;
      margin-bottom: 50px;
      position: relative;
      color: #333333;
      font-family: open sans;
    }
    .amt_border{
      border:1px solid #000;
      padding: 5px;
      font-size: 20px;
      font-weight: 700;
    }
    .h4 {
      margin-top: 5px !important;
    }
    .h3 {
      margin-bottom: 0px !important;
    }
    .receipt-main p {
      color: #333333;
      font-family: open sans;
      line-height: 1.42857;
    }
    .receipt-footer h1 {
      font-size: 15px;
      font-weight: 400 !important;
      margin: 0 !important;
    }
    .receipt-main::after {
      background: #414143 none repeat scroll 0 0;
      content: "";
      height: 5px;
      left: 0;
      position: absolute;
      right: 0;
      top: -13px;
    }
    .receipt-main thead {
      /*background: #414143 none repeat scroll 0 0;*/
    }
    .receipt-main thead th {
      color:#000;
    }
    .receipt-right h5 {
      font-size: 16px;
      font-weight: bold;
      margin: 0 0 7px 0;
    }
    .receipt-right p {
      font-size: 12px;
      margin: 0px;
    }
    .receipt-right p i {
      text-align: center;
      width: 18px;
    }
    .receipt-main td {
      padding: 9px 20px !important;
    }
    .receipt-main th {
      /*padding: 13px 20px !important;*/
    }
    .receipt-main td {
      font-size: 13px;
      font-weight: initial !important;
    }
    .receipt-main td p:last-child {
      margin: 0;
      padding: 0;
    } 
    .receipt-main td h2 {
      font-size: 20px;
      font-weight: 900;
      margin: 0;
      text-transform: uppercase;
    }
    .receipt-header-mid .receipt-left h1 {
      font-weight: 100;
      margin: 34px 0 0;
      text-align: left;
      text-transform: uppercase;
    }
    .receipt-left{
      margin: 20px 0 0;
      text-align: left;
    }
    .receipt-header-mid {
      margin: 10px 0;
      overflow: hidden;
    }
    
    #container {
      background-color: #dcdcdc;
    }
    .text-blue{
      color: #25b1ce;
      -webkit-print-color-adjust: exact;
    }
    @media print{
      .text-blue {
        
        color: #25b1ce !important;
      }
}
</style>
<script src="{{ASSETS_CSS}}print-css/bootstrap.min.js"></script>
<script src="{{ASSETS_CSS}}print-css/jquery-1.11.3.min.js"></script>
</head>
<body>

<!------ Include the above in your HEAD tag ---------->

<div class="container">
  <div class="row">
    
        <div class="receipt-main col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
          <div class="row">


          <div class="col-xs-2 col-sm-2 col-md-2 text-left">
            <div class="receipt-left">
              <img  alt="Sonanshul" src="{{ASSETS_CSS}}print-css/login-logo.png">
            </div>
          </div>
          <div class="col-xs-10 col-sm-10 col-md-10 text-right">
            <div class="receipt-right">
              <h3 class="text-blue"><strong>Sonanshul Mutual Benefit Nidhi Ltd.</strong></h3>
                       <h4>Classic Complex Near Mal Godam, Najibabad<br>Approved By Government of India</h4>
                       <h6>Reg.: CIN-U65990UP2019PLC117354</h6>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <h4 class="text-blue"><strong>Fixed Deposit Receipt 
            <br>Not Transferable</strong></h4>
          </div>
        </div>                  
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
        <hr>
        <div class="receipt-header receipt-header-mid">
          <div class="col-xs-8 col-sm-8 col-md-8 text-left">
            <h4>A/C No.: <strong>{{@$data['item']->account_no}}</strong></h4>
            <h4>FD No.: <strong>{{@$data['item']->fd_no}}</strong></h4>
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 text-right">
            <h5>Dated: <strong>{{date('d-M-Y',strtotime(@$data['item']->transaction_date))}}</strong></h5>
            <h5>Sales Executive Code: <strong>{{@$data['item']->user_id}}</strong></h5>
          </div>
        </div>
      </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <hr>
                <p>Dear Sir/Madam, <br>
In response to your application, we are pleased to inform you that you have been applied for FD(Fixed Deposit) under Nidhi norms, as per the detailed furnished here under the terms of plan shall be governed by the term of application form. The “General Terms and Conditions printed overleaf” shall comply with the entire rule for carrying on.</p>
<hr>
<p>
  Received with thanks from <strong>{{@$data['customer']->full_name}} </strong> {{@$data['customer']->gender == 'Male' ? 'S/o' : 'D/o'}} <strong>{{@$data['customer']->father_name}}
</strong>
</p>
<p><strong>
  &#8377; {{number_format(@$data['item']->amount,2)}} - ({{\App\Http\Controllers\Transaction\fdController::convert_number_to_words(@$data['item']->amount)}})
</strong>
</p>
<p>
  Matuarity Value <strong>&#8377; {{number_format(@$data['item']->maturity_amount,2)}} ({{\App\Http\Controllers\Transaction\fdController::convert_number_to_words(@$data['item']->maturity_amount)}})
</strong>
</p>
<p>
  As a term deposit for - <strong>{{@$data['item']->period_fd}} Months</strong> bearing interest @ <strong>{{@$data['item']->int_rate}}%</strong> per annum.
</p>
<hr>
              </div>
            </div>
            <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">

                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Interest Run From</th>
                            <th>Term (Months)</th>
                            <th>Interest@</th>
                            <th>Principal Amt</th>
                            <th>Matuarity Date</th>
                            <th>Matuarity Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{date('d-M-Y',strtotime(@$data['item']->int_run_from))}}</td>
                            <td> {{@$data['item']->period_fd}}</td>
                            <td> {{@$data['item']->int_rate}}%</td>
                            <td> &#8377; {{number_format(@$data['item']->amount,2)}}</td>
                            <td> {{date('d-M-Y',strtotime(@$data['item']->matured_on_date))}}</td>
                            <td> &#8377; {{number_format(@$data['item']->maturity_amount,2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <hr>
          <div class="col-xs-6 col-sm-6 col-md-6 text-left">
            <p>Name: <strong>{{@$data['customer']->full_name}}</strong>
          </p>
          <p>Address: <strong>{{@$data['customer']->village}} {{@$data['customer']->post_office}} {{@$data['customer']->district_model->name}} {{@$data['customer']->state_model->name}}</strong>
          </p>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 text-right">
            <p>Name of Nominee: <strong>{{@$data['item']->nominee_name}}</strong>
          </p>
          <p>Relation with Nominee: <strong>{{@$data['item']->nominee_relation}}</strong>
          </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <hr>
          <div class="col-xs-8 col-sm-8 col-md-8 text-left">
            <span class="amt_border">
            <i class="fa fa-fw fa-inr"></i> {{number_format(@$data['item']->amount,2)}}/-
          </span>
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 text-right">
            <h5><strong>Authorised Signatory</strong></h5>
          </div>  
          </div>
          </div>  
          <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
        <hr>      
          <center>
          We Look Forward For Your <strong>"Thanking You"</strong>
          </center>
        </div>
            </div>
      
        </div>    
  </div>
</div>
</body>
</html>