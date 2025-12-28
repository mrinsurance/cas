<!DOCTYPE html>
<html>
<head>
  <title>Loan Defaulter | Notice</title>
<link href="<?php echo e(ASSETS_CSS); ?>print-css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo e(ASSETS_VENDORS); ?>simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css" />
<link href="<?php echo e(ASSETS_VENDORS); ?>ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo e(ASSETS_CSS); ?>pages/icon.css" rel="stylesheet" type="text/css" />

<style>
  .tab-space {
      padding-left: 50px !important;
    }
  hr{
    margin-top: 15px !important;
    margin-bottom: 15px !important;
  }  
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
    @media  print{
      .text-blue {
        
        color: #25b1ce !important;
      }
}
</style>
<script src="<?php echo e(ASSETS_CSS); ?>print-css/bootstrap.min.js"></script>
<script src="<?php echo e(ASSETS_CSS); ?>print-css/jquery-1.11.3.min.js"></script>
</head>
<body>

<!------ Include the above in your HEAD tag ---------->

<div class="container">
  <div class="row">
    
        <div class="receipt-main col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
          <div class="row">


          <div class="col-xs-2 col-sm-2 col-md-2 text-left">
            <div class="receipt-left">
              <img  alt="Himachal" src="<?php echo e(ASSETS_CSS); ?>print-css/login-logo.png">
            </div>
          </div>
          <div class="col-xs-10 col-sm-10 col-md-10 text-right">
            <div class="receipt-right">
              <h3 class="text-blue"><strong><?php echo e($company_profile->name); ?></strong></h3>
                       <h4><?php echo e($company_profile->address); ?></h4>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <h3 class="text-blue"><strong>नोटिस</strong></h3>
          </div>
        </div>                  
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
      <hr>
        <div class="receipt-header receipt-header-mid">
          <div class="col-xs-8 col-sm-8 col-md-8 text-left">
            <h4>क्रमांक :_______</h4>
            <h4>खाता संख्या : <strong><?php echo e(@$item->account_no); ?></strong></h4>
            <h4>बनाम श्री/श्रीमति : <strong><?php echo e(@$customer->full_name); ?>

<?php if(@$customer->gender == 'F' && ($customer->marital == 'Married' || $customer->marital == '')): ?>
</strong><em>W/o</em><strong> <?php echo e(@$customer->father_name); ?>

<?php elseif(@$customer->gender == 'F' && $customer->marital == 'UnMarried'): ?>
</strong><em>D/o</em><strong> <?php echo e(@$customer->father_name); ?>

<?php elseif(@$customer->gender == 'F' && $customer->marital == 'Widow'): ?>
</strong><em>W/o</em><strong> <?php echo e(@$customer->father_name); ?>

<?php else: ?>
</strong><em>S/o</em><strong> <?php echo e(@$customer->father_name); ?>

<?php endif; ?>
            </strong></h4>
            पता : <?php echo e(@$customer->current_address_first); ?>, <?php echo e(@$customer->village); ?>,
            <br>
            तहसील : <?php echo e(@$customer->tehsil); ?>, 
            जिला : <?php echo e(@$customer->district_model->name); ?> <br>   
            राज्य : <?php echo e(@$customer->state_model->name); ?>, 
            पिन : <?php echo e(@$customer->pin_code); ?>

          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 text-right">
            <h5>Dated: <strong><?php echo e(date('d-M-Y',strtotime(@$notice_data))); ?></strong></h5>
          </div>
        </div>
      </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <hr>
                <p>आपको सूचित किया जाता है कि आपके जिम्मे इस सभा की  मु0 <strong><?php echo e($pr); ?>/-</strong> मूल राशि और दिनाँक <?php echo e(date('d-M-Y',strtotime($doa))); ?> से <?php echo e(date('d-M-Y',strtotime($notice_data))); ?> तक मु0 <strong><?php echo e($pt); ?>/-</strong> ब्याज कुल मु0 <strong><?php echo e($pt + $pr); ?>/-</strong> की राशि है।
                  <br>
                आपसे इसकी अदायगी हेतु कई बार व्यक्तिगत रूप से मांग की गई परंतु आपने इसे बिना कारण सूचित किए अदा  नहीं किया इसलिए आप इस राशि को 15 दिन के अंदर अंदर सभा में जमा करवा दें अन्यथा आपके विरुद्ध सालसी कार्यवाही हिमाचल प्रदेश एक्ट 1968 की धारा 72-73 के अधीन चलाई जाएगी।
                  <br> 
                इसके ऊपर जो भी खर्च पड़ेगा उसका भुगतान भी आपको करना पड़ेगा।</p>
                <p>यदि आप 15 दिन के अंदर अंदर सभा की शेष राशि वापस नहीं करते है तो आपको चुनाव में प्रत्याशी घोषित नहीं किया जाएगा और न हीं आपको चुनाव प्रक्रिया में भाग लेने का अधिकार होगा।</p>
              </div>
            </div>

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
         <hr>
          <div class="col-xs-12 col-sm-12 col-md-12 text-left">
            <h4><strong>प्रथम जामन</strong></h4>
                <h4 class="tab-space">खाता संख्या : <strong><?php echo e(@$guarantor_one->account_no); ?></strong></h4>
                <h4 class="tab-space">श्री/श्रीमति : <strong><?php echo e(@$guarantor_one->full_name); ?>

<?php if(@$guarantor_one->gender == 'F' && ($guarantor_one->marital == 'Married' || $guarantor_one->marital == '')): ?>
</strong><em>W/o</em><strong> <?php echo e(@$guarantor_one->father_name); ?>

<?php elseif(@$guarantor_one->gender == 'F' && $guarantor_one->marital == 'UnMarried'): ?>
</strong><em>D/o</em><strong> <?php echo e(@$guarantor_one->father_name); ?>

<?php elseif(@$guarantor_one->gender == 'F' && $guarantor_one->marital == 'Widow'): ?>
</strong><em>W/o</em><strong> <?php echo e(@$guarantor_one->father_name); ?>

<?php else: ?>
</strong><em>S/o</em><strong> <?php echo e(@$guarantor_one->father_name); ?>

<?php endif; ?>
                </strong></h4>
               <span class="tab-space">
                पता : <?php echo e(@$guarantor_one->current_address_first); ?>, <?php echo e(@$guarantor_one->village); ?>, </span>
                <br>
                <span class="tab-space">
                तहसील : <?php echo e(@$guarantor_one->tehsil); ?>, 
                जिला : <?php echo e(@$guarantor_one->district_model->name); ?>  
                राज्य : <?php echo e(@$guarantor_one->state_model->name); ?>, 
                पिन : <?php echo e(@$guarantor_one->pin_code); ?>

              </span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
        
          <div class="col-xs-12 col-sm-12 col-md-12 text-left">
            <h4><strong>द्वितीय जामन</strong></h4>
                <h4 class="tab-space">खाता संख्या : <strong><?php echo e(@$guarantor_two->account_no); ?></strong></h4>
                <h4 class="tab-space">श्री/श्रीमति : <strong><?php echo e(@$guarantor_two->full_name); ?>

<?php if(@$guarantor_two->gender == 'F' && ($guarantor_two->marital == 'Married' || $guarantor_two->marital == '')): ?>
</strong><em>W/o</em><strong> <?php echo e(@$guarantor_two->father_name); ?>

<?php elseif(@$guarantor_two->gender == 'F' && $guarantor_two->marital == 'UnMarried'): ?>
</strong><em>D/o</em><strong> <?php echo e(@$guarantor_two->father_name); ?>

<?php elseif(@$guarantor_two->gender == 'F' && $guarantor_two->marital == 'Widow'): ?>
</strong><em>W/o</em><strong> <?php echo e(@$guarantor_two->father_name); ?>

<?php else: ?>
</strong><em>S/o</em><strong> <?php echo e(@$guarantor_two->father_name); ?>

<?php endif; ?>
                </strong></h4>
               <span class="tab-space">
                पता : <?php echo e(@$guarantor_two->current_address_first); ?>, <?php echo e(@$guarantor_two->village); ?>, </span>
                <br>
                <span class="tab-space">
               तहसील : <?php echo e(@$guarantor_two->tehsil); ?>, 
                जिला : <?php echo e(@$guarantor_two->district_model->name); ?> 
                राज्य : <?php echo e(@$guarantor_two->state_model->name); ?>, 
                पिन : <?php echo e(@$guarantor_two->pin_code); ?>

              </span>
               <br> 
                
                <p>नोट:- जामन न. 1/जामन न. 2 आपके द्वारा उपरोक्त ऋणी सदस्य की ऋण के लिए जमानत डाली गई है/थी अतः आप इस ऋण की शीघ्र अदायगी करवा दे अन्यथा अप्रत्यक्ष रूप से ऋण/जमानत दोषी नियमानुसार होने के कारण आपको भी सभा की चुनाव प्रक्रिया में भाग लेने का अधिकार नहीं होगा।</p>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <hr>
          <div class="col-xs-8 col-sm-8 col-md-8 text-left">
           <h4><strong>प्रधान</strong></h4>
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 text-right">
            <h4><strong>सचिव</strong></h4>
          </div>
          </div>

          </div>
          <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <hr><hr>
          </div>
          </div>       
        </div>    
  </div>
</div>
</body>
</html><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/Transaction/LOAN_Ac/notice-election.blade.php ENDPATH**/ ?>