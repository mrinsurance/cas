<?php

namespace App\Http\Controllers\Daily_Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\tbl_ledger_model;
use App\company_address_model;
use Carbon\Carbon;
use PDF;
class dayBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    
    protected $form, $to;
    public function tempIndex(Request $request)
    {
        $loop_date = $request->get('from_date');
        $gtype_groups =  DaybookBetweenDates($loop_date, $loop_date,'Cr');
        $payment_gtype_groups =  DaybookBetweenDates($loop_date, $loop_date, 'Dr');

        $dr_amount = CashInHand($loop_date, 'Dr');
        $cr_amount = CashInHand($loop_date, 'Cr');
        $opening_cash_in_hand = $dr_amount - $cr_amount;

        return view(DAILY_REPORT_DAY_BOOK.'list2');
    }
    public function index(Request $request)
    {
        if($request->from_date == "" && $request->to_date == "")
        {
            $this->from = date('Y-m-d');
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
            $this->to = $request->to_date;
        }
        if($request->next)
        {
            $newFromDate = date('Y-m-d', strtotime($request->from_date. ' + 1 days')); 
            $newToDate = date('Y-m-d', strtotime($request->to_date. ' + 1 days')); 
            $this->from = $newFromDate;
            $this->to = $newToDate;
        }
        if($request->pre)
        {
            $newFromDate = date('Y-m-d', strtotime($request->from_date. ' - 1 days')); 
            $newToDate = date('Y-m-d', strtotime($request->to_date. ' - 1 days')); 
            $this->from = $newFromDate;
            $this->to = $newToDate;
        }
        
        // return $this->from;
        $data['from_date'] = $this->from;
        $data['to_date'] = $this->to;

// For Receipt        
        $data['gtype_groups'] = tbl_ledger_model::groupBy('gtype')->whereBetween('date_of_transaction', array($this->from, $this->to))->whereNotin('gtype',['Cash'])->where('type_of_transaction','Cr')->get();

        $data['stypes'] = tbl_ledger_model::whereBetween('date_of_transaction', array($this->from, $this->to))->orderByRaw("CAST(account_no as UNSIGNED) ASC")->get();

        $data['dr'] = tbl_ledger_model::where('date_of_transaction', '<', $this->from)->where('type_of_transaction','Dr')->where('gtype','Cash')->sum('amount');

        $data['cr'] = tbl_ledger_model::where('date_of_transaction', '<', $this->from)->where('type_of_transaction','Cr')->where('gtype','Cash')->sum('amount');
// For Payment
        $data['payment_gtype_groups'] = tbl_ledger_model::groupBy('gtype')->whereBetween('date_of_transaction', array($this->from, $this->to))->whereNotin('gtype',['Cash'])->where('type_of_transaction','Dr')->get();
        $data['payment_stypes'] = tbl_ledger_model::whereBetween('date_of_transaction', array($this->from, $this->to))->orderByRaw("CAST(account_no as UNSIGNED) ASC")->get();
        
         // dd($data['cr']);
        $data['opening_cash_in_hand'] = ($data['dr'] - $data['cr']);
//        list.blade.php page is first priority list2 is temperory page
        return view(DAILY_REPORT_DAY_BOOK.'list')->with($data);
    }

    public function printPDF(Request $request, $from_date = null, $to_date = null)
    {
        if($request->from_date == "" && $request->to_date == "")
        {
            $this->from = date('Y-m-d');
            $this->to = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
            $this->to = $request->to_date;
        }
        if($request->next)
        {
            $newFromDate = date('Y-m-d', strtotime($request->from_date. ' + 1 days'));
            $newToDate = date('Y-m-d', strtotime($request->to_date. ' + 1 days'));
            $this->from = $newFromDate;
            $this->to = $newToDate;
        }
        if($request->pre)
        {
            $newFromDate = date('Y-m-d', strtotime($request->from_date. ' - 1 days'));
            $newToDate = date('Y-m-d', strtotime($request->to_date. ' - 1 days'));
            $this->from = $newFromDate;
            $this->to = $newToDate;
        }

        // return $this->from;
        $data['from_date'] = $this->from;
        $data['to_date'] = $this->to;

// For Receipt
        $data['gtype_groups'] = tbl_ledger_model::groupBy('gtype')->whereBetween('date_of_transaction', array($this->from, $this->to))->whereNotin('gtype',['Cash'])->where('type_of_transaction','Cr')->get();

        $data['stypes'] = tbl_ledger_model::whereBetween('date_of_transaction', array($this->from, $this->to))->orderByRaw("CAST(account_no as UNSIGNED) ASC")->get();

        $data['dr'] = tbl_ledger_model::where('date_of_transaction', '<', $this->from)->where('type_of_transaction','Dr')->where('gtype','Cash')->sum('amount');

        $data['cr'] = tbl_ledger_model::where('date_of_transaction', '<', $this->from)->where('type_of_transaction','Cr')->where('gtype','Cash')->sum('amount');
// For Payment
        $data['payment_gtype_groups'] = tbl_ledger_model::groupBy('gtype')->whereBetween('date_of_transaction', array($this->from, $this->to))->whereNotin('gtype',['Cash'])->where('type_of_transaction','Dr')->get();
        $data['payment_stypes'] = tbl_ledger_model::whereBetween('date_of_transaction', array($this->from, $this->to))->orderByRaw("CAST(account_no as UNSIGNED) ASC")->get();

        // dd($data['cr']);
        $data['opening_cash_in_hand'] = ($data['dr'] - $data['cr']);
        $data['company_profile'] = company_address_model::first();
        return view(DAILY_REPORT_DAY_BOOK.'pdf_view',compact(['data']));
        $pdf = PDF::loadView(DAILY_REPORT_DAY_BOOK.'pdf_view', $data);
        return $pdf;

         // $view = View(DAILY_REPORT_DAY_BOOK.'pdf_view', ['data' => $data]);
         //    $pdf = \App::make('dompdf.wrapper');
         //    $pdf->loadHTML($view->render());
         //    return $pdf->stream();

    }

    public static function convert_number_to_words($number) {

        $hyphen      = ' ';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . Self::convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Self::convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Self::convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Self::convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return ucwords($string);
    }
}
