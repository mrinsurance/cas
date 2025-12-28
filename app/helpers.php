<?php
// SMS sending Code start
use App\ac_type_model;
use App\bank_model;
use App\branch_model;
use App\company_address_model;
use App\fd_ac_model;
use App\interest_on_fd_tbl;
use App\loan_ac_model;
use App\member_type_model;
use App\product_type_master_tbl;
use App\purchase_detail_tbl;
use App\sale_detail_tbl;
use App\saving_ac_model;
use App\session_master_model;
use App\share_ac_model;
use App\state_model;
use App\tbl_ledger_model;
use App\tbl_loan_return_model;
use App\User;
use Illuminate\Support\Facades\DB;

function sendSms($mobile, $msg)
	{
		// $senderId = "CASKHN";
		// $autKey = "d0d51425e9321071e76e55c441fe971e";
		// $routeId = "1";
		// $serverUrl = "t.treemultisoft.in";
		// $mobileNumber = $mobile;
		// //Prepare you post parameters
		// $postData = array(
		//     'mobileNumbers' => $mobileNumber,
		//     'smsContent' => $msg,
		//     'senderId' => $senderId,
		//     'routeId' => $routeId,
		//     "smsContentType" =>'english'
		// );
		// $data_json = json_encode($postData);
		// $url="http://".$serverUrl."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$autKey;
		// // init the resource
		// $ch = curl_init();
		// curl_setopt_array($ch, array(
		//     CURLOPT_URL => $url,
		//     CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_json)),
		//     CURLOPT_RETURNTRANSFER => true,
		//     CURLOPT_POST => true,
		//     CURLOPT_POSTFIELDS => $data_json,
		//     CURLOPT_SSL_VERIFYHOST => 0,
		//     CURLOPT_SSL_VERIFYPEER => 0
		// ));
		// //get response
		// $output = curl_exec($ch);
		// //Print error if any
		// if(curl_errno($ch))
		// {
		//     echo 'error:' . curl_error($ch);
		// }
		// curl_close($ch);
		// $outp = json_decode($output);
	}
function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ucwords(($Rupees ? $Rupees . 'Rupees ' : '') . $paise);
}
// Word wrap function
	function wordcut($strinn1)
	{

        $width = 15;
        $break = "</br>";
        $cut = false;
        echo wordwrap($strinn1, $width, $break, $cut);
	}

	function saleDetailBySaleId($id)
    {
        return sale_detail_tbl::whereSaleTblId($id)->get();
    }

    function SaleDetailCalculation($id)
    {
        $data = sale_detail_tbl::whereId($id)->first();
        $total = $data->quantity * $data->rate;
        return ['total'=>$total];
    }

    function TermofLoan()
    {
        return ['Daily','Monthly','Monthly Society','Quarterly','Half Yearly','Half Yearly Society', 'Yearly'];
    }

    function SessionYear()
    {
        return session_master_model::orderBy('start_date','asc')->get();
    }

    function SocietyBranch()
    {
        return branch_model::orderBy('name','asc')->get();
    }

    function MemberType()
    {
        return member_type_model::orderBy('id','asc')->get();
    }

    function TypeOfAccount()
    {
        return ac_type_model::orderBy('name','asc')->get();
    }

    function GuardianTypeList()
    {
        return [
            ['id'=>1, 'name'=>'D/O'],
            ['id'=>2, 'name'=>'S/O'],
            ['id'=>3, 'name'=>'W/O'],
            ['id'=>4, 'name'=>'C/O'],
        ];
    }
    function CategoryTypeList()
    {
        return [
            ['id'=>1, 'name'=>'General'],
            ['id'=>2, 'name'=>'OBC'],
            ['id'=>3, 'name'=>'SC'],
            ['id'=>4, 'name'=>'Other'],
        ];
    }
    function GenderTypeList()
    {
        return [
            ['id'=>1, 'name'=>'Male'],
            ['id'=>2, 'name'=>'Female'],
            ['id'=>3, 'name'=>'Other'],
        ];
    }

    function CompanyProfile()
    {
        $data = company_address_model::first();
        return [
            'company_name'=>$data->name,
            'company_address'=>$data->address,
        ];
    }

    function ReportName()
    {
        return ["Payable","Paid","Deposit"];
    }
    function ReportName2()
    {
        return ["Recoverable","Deposit","Received"];
    }

    function BankList()
    {
        return bank_model::orderBy('name','asc')->get();
    }
    function StateList()
    {
        return state_model::orderBy('name','asc')->get();
    }
    function RelationList()
    {
        return [
            ["id"=> 1, "label" => "Father"],
            ["id"=> 2, "label" => "Mother"],
            ["id"=> 3, "label" => "Husband"],
            ["id"=> 4, "label" => "Wife"],
            ["id"=> 5, "label" => "Son"],
            ["id"=> 6, "label" => "Daughter"],
            ["id"=> 7, "label" => "Nephew"],
            ["id"=> 8, "label" => "Elder Brother"],
            ["id"=> 9, "label" => "Younger Brother"],
            ["id"=> 10, "label" => "Elder Sister"],
            ["id"=> 11, "label" => "Younger Sister"],
            ["id"=> 12, "label" => "Grand Father"],
            ["id"=> 13, "label" => "Grand Mother"],
            ["id"=> 14, "label" => "Uncle"],
            ["id"=> 15, "label" => "Aunt"],
            ["id"=> 16, "label" => "Son in LAW"],
            ["id"=> 17, "label" => "Brother in Law"],
            ["id"=> 18, "label" => "Sister in Law"],
            ["id"=> 19, "label" => "Step Mother"],
            ["id"=> 20, "label" => "Step Father"],
            ["id"=> 21, "label" => "Step Sister"],
            ["id"=> 22, "label" => "Step Brother"],
            ["id"=> 23, "label" => "Step Son"],
            ["id"=> 24, "label" => "Step Daughter"],
        ];
    }
    function ReligionList()
    {
        return [
            ["id"=> 1, "label" => "Hinduism"],
            ["id"=> 2, "label" => "Muslim"],
            ["id"=> 3, "label" => "Sikhism"],
            ["id"=> 4, "label" => "Christians"],
            ["id"=> 5, "label" => "Buddhism"],
            ["id"=> 6, "label" => "Jainism"],
        ];
    }
    function PermissionList()
    {
        return [
            ["id"=> 1, "label" => "Share"],
            ["id"=> 2, "label" => "Saving"],
            ["id"=> 3, "label" => "DDS"],
            ["id"=> 4, "label" => "DRD"],
            ["id"=> 5, "label" => "RD"],
            ["id"=> 6, "label" => "FD"],
            ["id"=> 7, "label" => "Loan"],
            ["id"=> 8, "label" => "MIS"],
        ];
    }



    function PurchaseDetailByProductId($FromDate, $ToDate, $ProductId, $Branch)
    {
        $arr = [];
// Purchase Detail Table

        $PurchaseOpeningQuantity = \App\purchase_detail_tbl::where('product_master_tbl_id',$ProductId)->orderBy('date_of_transaction','desc');
        if ($Branch)
        {
            $PurchaseOpeningQuantity->where('branch_model_id',$Branch);
        }
        $PurchaseQuantity = \App\purchase_detail_tbl::where('product_master_tbl_id',$ProductId)->orderBy('date_of_transaction','desc');
        if ($Branch)
        {
            $PurchaseQuantity->where('branch_model_id',$Branch);
        }
        $PurchaseAmountSum = \App\purchase_detail_tbl::where('product_master_tbl_id',$ProductId)->orderBy('date_of_transaction','desc');
        if ($Branch)
        {
            $PurchaseAmountSum->where('branch_model_id',$Branch);
        }
        $arr['PurchaseOpeningQuantity'] = $PurchaseOpeningQuantity->where('date_of_transaction','<',$FromDate)->sum('quantity');
        $arr['PurchaseQuantity'] = $PurchaseQuantity->whereBetween('date_of_transaction',[$FromDate,$ToDate])->sum('quantity');
        $arr['PurchaseAmountSum'] = $PurchaseAmountSum->whereBetween('date_of_transaction',[$FromDate,$ToDate])->sum('amount');

        return $arr;
    }
    function SaleDetailByProductId($FromDate, $ToDate, $ProductId, $Branch)
    {
        $arr = [];
    // SAle Detail Table

        $SaleOpeningQuantity = \App\sale_detail_tbl::where('product_master_tbl_id',$ProductId)->orderBy('date_of_transaction','desc');
        if ($Branch)
        {
            $SaleOpeningQuantity->where('branch_model_id',$Branch);
        }
        $SaleQuantity = \App\sale_detail_tbl::where('product_master_tbl_id',$ProductId)->orderBy('date_of_transaction','desc');
        if ($Branch)
        {
            $SaleQuantity->where('branch_model_id',$Branch);
        }
        $SaleAmountSum = \App\sale_detail_tbl::where('product_master_tbl_id',$ProductId)->orderBy('date_of_transaction','desc');
        if ($Branch)
        {
            $SaleAmountSum->where('branch_model_id',$Branch);
        }
        $arr['SaleOpeningQuantity'] = $SaleOpeningQuantity->where('date_of_transaction','<',$FromDate)->sum('quantity');
        $arr['SaleQuantity'] = $SaleQuantity->whereBetween('date_of_transaction',[$FromDate,$ToDate])->sum('quantity');
        $arr['SaleAmountSum'] = $SaleAmountSum->whereBetween('date_of_transaction',[$FromDate,$ToDate])->sum('amount');

        return $arr;
    }

function TradingPurchaseDetailByProductId($FromDate, $ToDate, $ProductId, $Branch)
{
    $arr = [];
// Purchase Detail Table

    $Purchase = \App\purchase_detail_tbl::select('product_master_tbl_id','date_of_transaction','branch_model_id','purchase_detail_tbls.quantity as purchaseQuantity','amount')->groupBy('date_of_transaction')->where('product_master_tbl_id',$ProductId)->whereBetween('date_of_transaction',[$FromDate,$ToDate])->orderBy('date_of_transaction','desc');
    if ($Branch)
    {
        $Purchase->where('branch_model_id',$Branch);
    }
    $Sale = \App\sale_detail_tbl::select('product_master_tbl_id','date_of_transaction','branch_model_id','sale_detail_tbls.quantity as saleQuantity','amount')->groupBy('date_of_transaction')->where('product_master_tbl_id',$ProductId)->whereBetween('date_of_transaction',[$FromDate,$ToDate])->orderBy('date_of_transaction','desc');
    if ($Branch)
    {
        $Sale->where('branch_model_id',$Branch);
    }
//    return $Purchase = $Sale->unionAll($Purchase)->get();
    return  $Purchase->get();
    return  $Sale->get();

}

    function getFullAddressById($id)
    {
        $openAccount = \App\open_new_ac_model::whereId($id)->first();
        return ucfirst(@$openAccount->village).' '. ucfirst(@$openAccount->tehsil).' '. ucfirst(@$openAccount->district_model->name).' '.ucfirst(@$openAccount->state_model->name);
    }
    function getRdInstallmentModelDataByRdModelId($id)
    {
        return $data = \App\rd_installment_model::whereRdModelId($id)->get();

    }

    function ClosingCashInHand()
    {
        $currentDate = \Carbon\Carbon::now();
        $dr = tbl_ledger_model::where('date_of_transaction', '<=', $currentDate)->where('type_of_transaction','Dr')->where('gtype','Cash')->sum('amount');
         $cr = tbl_ledger_model::where('date_of_transaction', '<=', $currentDate)->where('type_of_transaction','Cr')->where('gtype','Cash')->sum('amount');
        return number_format($dr - $cr,2,'.','');
    }

function ClosingCashInHandByDate($date)
{
    if ($date)
    {
        $currentDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
    }
    else{
        $currentDate = \Carbon\Carbon::now();
    }
    $dr = tbl_ledger_model::where('date_of_transaction', '<=', $currentDate)->where('type_of_transaction','Dr')->where('gtype','Cash')->sum('amount');
    $cr = tbl_ledger_model::where('date_of_transaction', '<=', $currentDate)->where('type_of_transaction','Cr')->where('gtype','Cash')->sum('amount');
    return number_format($dr - $cr,2,'.','');
}

    function SalePartyNameById($id)
    {
        return \App\salePartyTbl::whereId($id)->first();
    }

    function SetCoins($coins, $amount)
    {
        if ($coins)
        {
            return number_format(($coins * $amount),2,'.','');
        }
        else{
            return number_format(0,2);
        }
    }
    function getSumInterestOnFdById($fdAcModelId)
    {
        return interest_on_fd_tbl::where('fd_ac_model_id',$fdAcModelId)->sum('interest_amt');
    }


    function BalanceFdAmount($request)
    {
        $account = @$request['account'];
        $member = @$request['member'];
        $items_obj = fd_ac_model::select('id','open_new_ac_model_id','member_type_model_id','account_no','fd_no','amount','int_run_from','maturity_date','status','token')
            ->with('open_new_ac_model')
            ->orderBy('status','desc')
            ->orderBy('transaction_date','desc')
            ->where('account_no',$account)->where('member_type_model_id',$member);

        if(Auth::user()->staff_type == 'Agent')
        {
            $items_obj = $items_obj->where('agent_id',Auth()->user()->id);
        }
        return $items_obj = $items_obj->get();

    }



    function CompanyAddress()
    {
        return company_address_model::first();
    }


    function getAccountDetailByAcNo($ac)
    {
        return \App\open_new_ac_model::whereAccountNo($ac)->first();
    }

    function GetMasterOfProductType()
    {
        return product_type_master_tbl::orderBy('name','asc')->get();
    }

    function SumOfPurchaseItemQuantity($arr)
    {
        $from = $arr['from'];
        $to = $arr['to'];
        $productName = $arr['product_name'];
        $branch = $arr['branch'];
        $quantity = [];

        $quantity = purchase_detail_tbl::where('date_of_transaction','<=',$from);
        if($branch)
        {
            $quantity->where('branch_model_id',$branch);
        }
        if($productName)
        {
            $quantity->where('product_master_tbl_id',$productName);
        }
        $quantity = $quantity->sum('quantity');
        return $quantity;
    }

    function SumOfSaleItemQuantity($arr)
    {
        $from = $arr['from'];
        $to = $arr['to'];
        $productName = $arr['product_name'];
        $branch = $arr['branch'];
        $quantity = [];

        $quantity = sale_detail_tbl::where('date_of_transaction','<=',$from);
        if($branch)
        {
            $quantity->where('branch_model_id',$branch);
        }
        if($productName)
        {
            $quantity->where('product_master_tbl_id',$productName);
        }
        $quantity = $quantity->sum('quantity');
        return $quantity;
    }

    function SumOfPurchaseSaleQuantity($arr)
    {
        $from = $arr['from'];
        $to = $arr['to'];
        $productName = $arr['product_name'];
        $branch = $arr['branch'];

// Purchase
        $purchase = DB::table('purchase_detail_tbls')
            ->select(
                'date_of_transaction',
                        'purchase_detail_tbls.quantity as purchase_quantity',
                        'purchase_detail_tbls.amount as purchase_amount',
                        DB::raw("NULL as sale_quantity"),
                        DB::raw("NULL as sale_amount"),
                        'branch_model_id',
                        'product_master_tbl_id'

            );
        if($branch)
        {
            $purchase->where('branch_model_id',$branch);
        }
        if($productName)
        {
            $purchase->where('product_master_tbl_id',$productName);
        }
            $purchase = $purchase->whereBetween('date_of_transaction',[$from,$to]);
// Sale
        $sale = DB::table('sale_detail_tbls')
            ->select(
                    'date_of_transaction',
                            DB::raw("NULL as purchase_quantity"),
                            DB::raw("NULL as purchase_amount"),
                            'sale_detail_tbls.quantity as sale_quantity',
                            'sale_detail_tbls.amount as sale_amount',
                            'branch_model_id',
                            'product_master_tbl_id'
            );
            if($branch)
            {
                $sale->where('branch_model_id',$branch);
            }
            if($productName)
            {
                $sale->where('product_master_tbl_id',$productName);
            }
            $sale = $sale->whereBetween('date_of_transaction',[$from,$to])->orderBy('date_of_transaction','asc')->unionAll($purchase)->get();

       return $sale;

    }
    function getProductStock($id)
    {
        $stock = 0;
        $purchase = purchase_detail_tbl::whereProductMasterTblId($id)->sum('quantity');
        $sale = sale_detail_tbl::whereProductMasterTblId($id)->sum('quantity');

        return $stock = $purchase - $sale;
    }
    function TypeOfDeposit()
    {
        return [
            ['name'=>'FIXED DEPOSIT'],
            ['name'=>'LONG TERM DEPOSIT'],
            ['name'=>'SHORT TERM DEPOSIT'],
            ['name'=>'MARGIN MONEY'],
        ];
    }

    function BalanceShareSum($valId,$transaction,$date)
    {
        return \App\share_ac_model::where('open_new_ac_model_id',$valId)->where('type_of_transaction',$transaction)->where('date_of_transaction','<=',$date)->sum('amount');
    }

    function BalanceSavingSum($valId,$transaction,$date)
    {
        return \App\saving_ac_model::where('open_new_ac_model_id',$valId)->where('type_of_transaction',$transaction)->where('date_of_transaction','<=',$date)->sum('amount');
    }

    function getStateById($id)
    {
        return state_model::find($id);
    }
    function getDistrictById($id)
    {
        return \App\district_model::find($id);
    }
// ==================== Start Daily Report Day Book functions ==========================
    function DaybookBetweenDates($from, $to, $type)
    {
        return tbl_ledger_model::select('gtype','date_of_transaction','type_of_transaction')
                ->groupBy('gtype')
                ->whereBetween('date_of_transaction', array($from, $to))
                ->whereNotin('gtype',['Cash'])
                ->where('type_of_transaction',$type)
                ->get();
    }
    function CashInHand($from_date, $transaction_type)
    {
        $item = tbl_ledger_model::select();
        if ($from_date)
        {
            $item->where('date_of_transaction', '<', $from_date);
        }
        if ($transaction_type)
        {
            $item->where('type_of_transaction',$transaction_type);
        }
        return $item->where('gtype','Cash')->sum('amount');
    }

    function stypeOfDaybookBetweenDates($from_date, $to_date, $gtype, $type)
    {
        return tbl_ledger_model::select('gtype','date_of_transaction','account_no','amount','type_of_transaction','entry_type','particular')
                    ->whereBetween('date_of_transaction', array($from_date, $to_date))
                    ->orderByRaw("CAST(account_no as UNSIGNED) ASC")
                    ->whereIn('gtype',[$gtype,strtoupper($gtype)])
                    ->where('type_of_transaction',$type)
                    ->get();
    }
// ==================== End Daily Report Day Book functions ==========================

// Print Personal Ledger
    function printPersonalLedger($account_id,$member_type,$from,$to)
    {
        $from = $from ?? date('Y-m-d');
        $to = $to ?? date('Y-m-d');
        // Share
        $_share = DB::table('share_ac_models')
            ->select(
                "share_ac_models.date_of_transaction as dt",
                "share_ac_models.amount as share_amt",
                "share_ac_models.type_of_transaction as share_mode",
                DB::raw("NULL as loan"),
                DB::raw("NULL as loan_r"),
                DB::raw("NULL as intr"),
                DB::raw("NULL as saving_amt"),
                DB::raw("NULL as saving_mode"))
            ->where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->whereBetween('date_of_transaction',[$from,$to]);

// Loan Advance
        $_loan_model = DB::table("loan_ac_models")
            ->select(
                "loan_ac_models.date_of_advance as dt",
                DB::raw("NULL as share_amt"),
                DB::raw("NULL as share_mode"),
                "loan_ac_models.amount as loan",
                DB::raw("NULL as loan_r"),
                DB::raw("NULL as intr"),
                DB::raw("NULL as saving_amt"),
                DB::raw("NULL as saving_mode"))
            ->where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->whereBetween('date_of_advance',[$from,$to]);
// Loan Return
        $_loan_return = DB::table('tbl_loan_return_models')
            ->select(
                "tbl_loan_return_models.received_date as dt",
                DB::raw("NULL as share_amt"),
                DB::raw("NULL as share_mode"),
                DB::raw("NULL as loan"),
                "tbl_loan_return_models.received_principal as loan_r",
                "tbl_loan_return_models.received_interest as intr",
                DB::raw("NULL as saving_amt"),
                DB::raw("NULL as saving_mode"))
            ->where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->whereBetween('received_date',[$from,$to]);
// Saving
      $_saving = DB::table("saving_ac_models")
            ->select(
                "saving_ac_models.date_of_transaction as dt",
                DB::raw("NULL as share_amt"),
                DB::raw("NULL as share_mode"),
                DB::raw("NULL as loan"),
                DB::raw("NULL as loan_r"),
                DB::raw("NULL as intr"),
                "saving_ac_models.amount as saving_amt",
                "saving_ac_models.type_of_transaction as saving_mode")
            ->where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->whereBetween('date_of_transaction',[$from,$to])
            ->unionAll($_loan_model)
            ->unionAll($_loan_return)
            ->unionAll($_share)
            ->orderBy('dt','asc')
            ->get();

// Share
        $_opening_share_dr = share_ac_model::where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->where('type_of_transaction','Deposit')
            ->where('date_of_transaction','<',$from)
            ->sum('amount');
        $_opening_share_cr = share_ac_model::where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->where('type_of_transaction','Withdrawal')
            ->where('date_of_transaction','<',$from)
            ->sum('amount');

// Saving
        $_opening_saving_dr = saving_ac_model::where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->where('type_of_transaction','Deposit')
            ->where('date_of_transaction','<',$from)
            ->sum('amount');

        $_opening_saving_cr = saving_ac_model::where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->where('type_of_transaction','Withdrawal')
            ->where('date_of_transaction','<',$from)
            ->sum('amount');

// Loan Advance
        $_opening_loan_dr = loan_ac_model::where('account_no',$account_id)
            ->where('member_type_model_id',$member_type)
            ->where('date_of_advance','<',$from)
            ->sum('amount');

// Loan Return
        $_opening_loan_cr = tbl_loan_return_model::where('account_no',$account_id)
            ->where('received_date','<',$from)
            ->sum('received_principal');
        $_opening_share_bal = ($_opening_share_dr - $_opening_share_cr);
        $_opening_loan_bal = ($_opening_loan_dr - $_opening_loan_cr);
        $_opening_saving_bal = ($_opening_saving_dr - $_opening_saving_cr);

        return ['_saving'=>$_saving,
            '_opening_share_bal'=>$_opening_share_bal,
            '_opening_loan_bal'=>$_opening_loan_bal,
            '_opening_saving_bal'=>$_opening_saving_bal
        ];
    }
?>
