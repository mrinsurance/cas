<?php

namespace App\Http\Controllers\Audit;

use App\Jobs\UpdateBalanceSheet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\branch_model;
use App\loan_model;
use App\company_address_model;
use App\tbl_ledger_model;
use App\loan_ac_model;
use App\session_master_model;
use App\year_end_tbl;
use App\subgroup_master_model;
use DB;
use Illuminate\Support\Facades\Log;
use PDF;
use Auth;
class reportController extends Controller
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

    protected $from, $toDate, $branch, $financial_year;
    private $allValues2 = [];

    public function rdReport(Request $request)
    {
    	if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
			$openingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
				->where('main_head','CASH')
				->where('type_of_transaction','Dr')
				->where('date_of_transaction' ,'<', $this->from)
				->sum('amount');
			$openingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
				->where('main_head','CASH')
				->where('type_of_transaction','Cr')
				->where('date_of_transaction' ,'<', $this->from)
				->sum('amount');
			
			$closingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
				->where('main_head','CASH')
				->where('type_of_transaction','Dr')
				->where('date_of_transaction' ,'<=', $this->toDate)
				->sum('amount');
			$closingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
				->where('main_head','CASH')
				->where('type_of_transaction','Cr')
				->where('date_of_transaction' ,'<=', $this->toDate)
				->sum('amount');
			
    	$data = [
    		'branch' => $request->branch,
    		'from_date' => $this->from,
    		'to_date' => $this->toDate,
    		'branches' => branch_model::orderBy('name','asc')->get(),
    		'company_address' => company_address_model::first(),
    		'tblLedgers' => tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
    			->groupBy('main_head')
    			->whereNotIn('main_head',['CASH'])
    			->whereBetween('date_of_transaction',[$this->from,$this->toDate])
    			->get(),
    		'openingDrSum' => $openingDrSum,
			'openingCrSum' => $openingCrSum,
			'opening' => $openingDrSum - $openingCrSum,
			'closingDrSum' => $closingDrSum,
			'closingCrSum' => $closingCrSum,
			'closing' => $closingDrSum - $closingCrSum,
    	];
    	return view(AUDIT_REPORT.'/rd_report')->with($data);
    }
// Trading Account Report
    public function tradingAccountReport(Request $request)
    {
        if(!$request->from_date)
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if(!$request->to_date)
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
        $this->financial_year = $request->financial_year;

        $data = [
                    'branches' => branch_model::orderBy('name','asc')->get(),
                    'branch' => $request->branch,
                    'session_years' => session_master_model::orderBy('start_date','asc')->get(),
                ];
        
        if(!$this->financial_year)
        {
            return view(AUDIT_REPORT.'/trading_ac')->with($data);          
            exit();
        }
        
        
        $yearEndTbls = year_end_tbl::where('session_master_model_id',$this->financial_year)->first();
        $yearEndTblLbs = year_end_tbl::where('session_master_model_id',($this->financial_year - 1))->first();
       
        $openingStock = ($yearEndTbls->opening_stock_depot1 + $yearEndTbls->opening_stock_depot2 + $yearEndTbls->opening_stock_depot3);
        $closingStock = ($yearEndTbls->closing_stock_depot1 + $yearEndTbls->closing_stock_depot2 + $yearEndTbls->closing_stock_depot3);

            $drTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->whereIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT'])                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
            
            $drTotal = 0; 
            $dr;   
            foreach($drTblLedgers as $list)
            {
                $dr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $drTotal = $drTotal + $dr;
               
            } 
            // return $openingStock;
            $drTotal = $drTotal + $openingStock;


          
            $crTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->whereIn('gtype',['DIRECT INCOME','SALES ACCOUNT'])                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();

            $crTotal = 0; 
            $cr;   
            foreach($crTblLedgers as $list)
            {
                $cr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $crTotal = $crTotal + $cr;
               
            }  
            $crTotal = $crTotal + $closingStock; 
            // return $closingStock; 
// Profit & Loss query

    $pldrTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->where('gtype','INDIRECT EXPENSES')                
                ->orWhere('gtype','like','%INTEREST PAID%')                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
            
            $pldrTotal = 0; 
            $pldr;   
            foreach($pldrTblLedgers as $list)
            {
                $pldr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $pldrTotal = $pldrTotal + $pldr;
               
            } 
            $pldrTotal = $pldrTotal ;


          
            $plcrTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->where('gtype','INDIRECT INCOME')                
                ->orWhere('gtype','INTEREST RECEIVED')                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
                // dd($plcrTblLedgers);

            $plcrTotal = 0; 
            $plcr;   
            foreach($plcrTblLedgers as $list)
            {
                $plcr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $plcrTotal = $plcrTotal + $plcr;
               
            }  
            $plcrTotal = $plcrTotal ; 
                
            $data = [
                'financial_year' => $this->financial_year,
                'branch' => $request->branch,
                'from_date' => $this->from,
                'to_date' => $this->toDate,
                'branches' => branch_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'session_years' => session_master_model::orderBy('start_date','asc')->get(),
                
                'yearEndTbls' => $yearEndTbls,
                'openingStock' => $openingStock,
                'closingStock' => $closingStock,
                
                'drTblLedgers' => $drTblLedgers,
                'crTblLedgers' => $crTblLedgers,
                'drTotal' => $drTotal,
                'crTotal' => $crTotal,
                'pldrTblLedgers' => $pldrTblLedgers,
                'plcrTblLedgers' => $plcrTblLedgers,
                'pldrTotal' => $pldrTotal,
                'plcrTotal' => $plcrTotal,

                'npaAmt' => $yearEndTbls->npa_amount,
                'npaIntr' => $yearEndTbls->npa_int,
                'intrFd' => $yearEndTbls->int_payble_fd,
                'intrRd' => $yearEndTbls ->int_payble_rd,
                'intrLoan' => $yearEndTbls ->int_recover_loan,
                'intrBankFd' => $yearEndTbls ->int_recover_bank_fd,
                'intrBankRd' => $yearEndTbls ->int_recover_bank_rd,

                'lbsnpaAmt' => $yearEndTblLbs->npa_amount,
                'lbsnpaIntr' => $yearEndTblLbs->npa_int,
                'lbsintrFd' => $yearEndTblLbs->int_payble_fd,
                'lbsintrRd' => $yearEndTblLbs ->int_payble_rd,
                'lbsintrLoan' => $yearEndTblLbs ->int_recover_loan,
                'lbsintrBankFd' => $yearEndTblLbs ->int_recover_bank_fd,
                'lbsintrBankRd' => $yearEndTblLbs ->int_recover_bank_rd,  
                     
            
        ];
        
        if($this->financial_year)
        {
           
            return view(AUDIT_REPORT.'/trading_ac_report')->with($data);          
        }
        else
        {
            return view(AUDIT_REPORT.'/trading_ac')->with($data);
        }
    }
// Trading Account PL
    public function tradingPLReport(Request $request)
    {
        if(!$request->from_date)
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if(!$request->to_date)
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
        $this->financial_year = $request->financial_year;

        $data = [
                    'branches' => branch_model::orderBy('name','asc')->get(),
                    'branch' => $request->branch,
                    'session_years' => session_master_model::orderBy('start_date','asc')->get(),
                ];
        
        if(!$this->financial_year)
        {
            return view(AUDIT_REPORT.'/trading_pl')->with($data);          
            exit();
        }
        
        
        $yearEndTbls = year_end_tbl::where('session_master_model_id',$this->financial_year)->first();
        $yearEndTblLbs = year_end_tbl::where('session_master_model_id',($this->financial_year - 1))->first();
       
        $openingStock = ($yearEndTbls->opening_stock_depot1 + $yearEndTbls->opening_stock_depot2 + $yearEndTbls->opening_stock_depot3);
        $closingStock = ($yearEndTbls->closing_stock_depot1 + $yearEndTbls->closing_stock_depot2 + $yearEndTbls->closing_stock_depot3);

            $drTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->whereIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT'])                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
            
            $drTotal = 0; 
            $dr;   
            foreach($drTblLedgers as $list)
            {
                $dr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $drTotal = $drTotal + $dr;
               
            } 
            // return $openingStock;
            $drTotal = $drTotal + $openingStock;


          
            $crTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->whereIn('gtype',['DIRECT INCOME','SALES ACCOUNT'])                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();

            $crTotal = 0; 
            $cr;   
            foreach($crTblLedgers as $list)
            {
                $cr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $crTotal = $crTotal + $cr;
               
            }  
            $crTotal = $crTotal + $closingStock; 
            // return $closingStock; 
// Profit & Loss query

    $pldrTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->where('gtype','INDIRECT EXPENSES')                
                ->orWhere('gtype','like','%INTEREST PAID%')                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
            
            $pldrTotal = 0; 
            $pldr;   
            foreach($pldrTblLedgers as $list)
            {
                $pldr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $pldrTotal = $pldrTotal + $pldr;
               
            } 
            $pldrTotal = $pldrTotal ;


          
            $plcrTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->where('gtype','INDIRECT INCOME')                
                ->orWhere('gtype','INTEREST RECEIVED')                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
                // dd($plcrTblLedgers);

            $plcrTotal = 0; 
            $plcr;   
            foreach($plcrTblLedgers as $list)
            {
                $plcr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $plcrTotal = $plcrTotal + $plcr;
               
            }  
            $plcrTotal = $plcrTotal ; 
                
            $data = [
                'financial_year' => $this->financial_year,
                'branch' => $request->branch,
                'from_date' => $this->from,
                'to_date' => $this->toDate,
                'branches' => branch_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'session_years' => session_master_model::orderBy('start_date','asc')->get(),
                
                'yearEndTbls' => $yearEndTbls,
                'openingStock' => $openingStock,
                'closingStock' => $closingStock,
                
                'drTblLedgers' => $drTblLedgers,
                'crTblLedgers' => $crTblLedgers,
                'drTotal' => $drTotal,
                'crTotal' => $crTotal,
                'pldrTblLedgers' => $pldrTblLedgers,
                'plcrTblLedgers' => $plcrTblLedgers,
                'pldrTotal' => $pldrTotal,
                'plcrTotal' => $plcrTotal,

                'npaAmt' => $yearEndTbls->npa_amount,
                'npaIntr' => $yearEndTbls->npa_int,
                'intrFd' => $yearEndTbls->int_payble_fd,
                'intrRd' => $yearEndTbls ->int_payble_rd,
                'intrLoan' => $yearEndTbls ->int_recover_loan,
                'intrBankFd' => $yearEndTbls ->int_recover_bank_fd,
                'intrBankRd' => $yearEndTbls ->int_recover_bank_rd,

                'lbsnpaAmt' => $yearEndTblLbs->npa_amount,
                'lbsnpaIntr' => $yearEndTblLbs->npa_int,
                'lbsintrFd' => $yearEndTblLbs->int_payble_fd,
                'lbsintrRd' => $yearEndTblLbs ->int_payble_rd,
                'lbsintrLoan' => $yearEndTblLbs ->int_recover_loan,
                'lbsintrBankFd' => $yearEndTblLbs ->int_recover_bank_fd,
                'lbsintrBankRd' => $yearEndTblLbs ->int_recover_bank_rd,  
                     
            
        ];
        
        if($this->financial_year)
        {
           
            return view(AUDIT_REPORT.'/trading_pl_report')->with($data);          
        }
        else
        {
            return view(AUDIT_REPORT.'/trading_pl')->with($data);
        }
    }


   

    public function profitLossReport(Request $request)
    {
       if(!$request->from_date)
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if(!$request->to_date)
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
        $this->financial_year = $request->financial_year;

        $data = [
                    'branches' => branch_model::orderBy('name','asc')->get(),
                    'branch' => $request->branch,
                    'session_years' => session_master_model::orderBy('start_date','asc')->get(),
                ];
        
        if(!$this->financial_year)
        {
            return view(AUDIT_REPORT.'/profit_loss')->with($data);          
            exit();
        }
        
        
        $yearEndTbls = year_end_tbl::where('session_master_model_id',$this->financial_year)->first();
        $yearEndTblLbs = year_end_tbl::where('session_master_model_id',($this->financial_year - 1))->first();
       
        $openingStock = ($yearEndTbls->opening_stock_depot1 + $yearEndTbls->opening_stock_depot2 + $yearEndTbls->opening_stock_depot3);
        $closingStock = ($yearEndTbls->closing_stock_depot1 + $yearEndTbls->closing_stock_depot2 + $yearEndTbls->closing_stock_depot3);

            $drTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->whereIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT'])                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
            
            $drTotal = 0; 
            $dr;   
            foreach($drTblLedgers as $list)
            {
                $dr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $drTotal = $drTotal + $dr;
               
            } 
            // return $openingStock;
            $drTotal = $drTotal + $openingStock;


          
            $crTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->whereIn('gtype',['DIRECT INCOME','SALES ACCOUNT'])                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();

            $crTotal = 0; 
            $cr;   
            foreach($crTblLedgers as $list)
            {
                $cr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $crTotal = $crTotal + $cr;
               
            }  
            $crTotal = $crTotal + $closingStock; 
            // return $closingStock; 
// Profit & Loss query

    $pldrTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->where('gtype','INDIRECT EXPENSES')                
                ->orWhere('gtype','like','%INTEREST PAID%')                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
            
            $pldrTotal = 0; 
            $pldr;   
            foreach($pldrTblLedgers as $list)
            {
                $pldr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $pldrTotal = $pldrTotal + $pldr;
               
            } 
            $pldrTotal = $pldrTotal ;


          
            $plcrTblLedgers = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','gtype')
                ->groupBy('main_head')
                ->where('gtype','INDIRECT INCOME')                
                ->orWhere('gtype','INTEREST RECEIVED')                
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get();
                // dd($plcrTblLedgers);

            $plcrTotal = 0; 
            $plcr;   
            foreach($plcrTblLedgers as $list)
            {
                $plcr = tbl_ledger_model::where('main_head',$list->main_head)->whereBetween('date_of_transaction',[$this->from,$this->toDate])->sum('amount');
                $plcrTotal = $plcrTotal + $plcr;
               
            }  
            $plcrTotal = $plcrTotal ; 
                
            $data = [
                'financial_year' => $this->financial_year,
                'branch' => $request->branch,
                'from_date' => $this->from,
                'to_date' => $this->toDate,
                'branches' => branch_model::orderBy('name','asc')->get(),
                'company_address' => company_address_model::first(),
                'session_years' => session_master_model::orderBy('start_date','asc')->get(),
                
                'yearEndTbls' => $yearEndTbls,
                'openingStock' => $openingStock,
                'closingStock' => $closingStock,
                
                'drTblLedgers' => $drTblLedgers,
                'crTblLedgers' => $crTblLedgers,
                'drTotal' => $drTotal,
                'crTotal' => $crTotal,
                'pldrTblLedgers' => $pldrTblLedgers,
                'plcrTblLedgers' => $plcrTblLedgers,
                'pldrTotal' => $pldrTotal,
                'plcrTotal' => $plcrTotal,

                'npaAmt' => $yearEndTbls->npa_amount,
                'npaIntr' => $yearEndTbls->npa_int,
                'intrFd' => $yearEndTbls->int_payble_fd,
                'intrRd' => $yearEndTbls ->int_payble_rd,
                'intrLoan' => $yearEndTbls ->int_recover_loan,
                'intrBankFd' => $yearEndTbls ->int_recover_bank_fd,
                'intrBankRd' => $yearEndTbls ->int_recover_bank_rd,

                'lbsnpaAmt' => $yearEndTblLbs->npa_amount,
                'lbsnpaIntr' => $yearEndTblLbs->npa_int,
                'lbsintrFd' => $yearEndTblLbs->int_payble_fd,
                'lbsintrRd' => $yearEndTblLbs ->int_payble_rd,
                'lbsintrLoan' => $yearEndTblLbs ->int_recover_loan,
                'lbsintrBankFd' => $yearEndTblLbs ->int_recover_bank_fd,
                'lbsintrBankRd' => $yearEndTblLbs ->int_recover_bank_rd,  
                     
            
        ];
        
        if($this->financial_year)
        {
           
            return view(AUDIT_REPORT.'/profit_loss_report')->with($data);          
        }
        else
        {
            return view(AUDIT_REPORT.'/profit_loss')->with($data);
        }
    }

    public function loanAdvanceReport(Request $request)
    {
       if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
        $_loanReport = loan_ac_model::select('id','parnote_no','date_of_advance','account_no','open_new_ac_model_id','amount','loan_purpose','guarnter_one','guarnter_two')
                ->with('open_new_ac_model')
                ->orderBy('date_of_advance','asc')
                ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
                ->whereBetween('date_of_advance',[$this->from,$this->toDate]);
            if($request->loan_type)
            {
                $_loanReport = $_loanReport->where('loan_type',$request->loan_type);
            }    
               $_loanReport = $_loanReport->get();

        $_loanTotal = loan_ac_model::select('id','date_of_advance','amount')
                ->with('open_new_ac_model')
                ->whereBetween('date_of_advance',[$this->from,$this->toDate]);
            if ($request->loan_type) {
                    $_loanTotal = $_loanTotal->where('loan_type',$request->loan_type);
                }    

            $_loanTotal = $_loanTotal->sum('amount');       
            
        $data = [
            'branch' => $request->branch,
            'loan_type' => $request->loan_type,
            'from_date' => $this->from,
            'to_date' => $this->toDate,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'loan_types'    =>  loan_model::all(),
            '_loanReport' => $_loanReport,
            '_loanTotal' => $_loanTotal,    
        ];
        
        return view(AUDIT_REPORT.'/loan-advancement')->with($data);
    }

    public function loanAdvanceReportDetail(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
        $_loanReport = loan_ac_model::select('id','months','interest','pannelty_int','date_of_advance','account_no','open_new_ac_model_id','amount','loan_purpose','guarnter_one','guarnter_two')
            ->with('open_new_ac_model')
            ->orderBy('date_of_advance','asc')
            ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'))
            ->whereBetween('date_of_advance',[$this->from,$this->toDate]);
        if($request->loan_type)
        {
            $_loanReport = $_loanReport->where('loan_type',$request->loan_type);
        }
        $_loanReport = $_loanReport->get();
        $_loanTotal = loan_ac_model::select('id','date_of_advance','amount')
            ->with('open_new_ac_model')
            ->whereBetween('date_of_advance',[$this->from,$this->toDate]);
        if ($request->loan_type) {
            $_loanTotal = $_loanTotal->where('loan_type',$request->loan_type);
        }

        $_loanTotal = $_loanTotal->sum('amount');

        $data = [
            'branch' => $request->branch,
            'loan_type' => $request->loan_type,
            'from_date' => $this->from,
            'to_date' => $this->toDate,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'loan_types'    =>  loan_model::all(),
            '_loanReport' => $_loanReport,
            '_loanTotal' => $_loanTotal,
        ];

        return view(AUDIT_REPORT.'/loan-advancement-detail')->with($data);
    }

 // balanceSheet Report   

    public function balanceSheet(Request $request)
    {
        
        if($request->date == "")
        {
            $this->date = date('Y-m-d');
        }
        else
        {
            $this->date = $request->date;
        }

        $this->financial_year = $request->financial_year;
        $session_years = session_master_model::orderBy('start_date','asc')->get();
        $branches = branch_model::orderBy('name','asc')->get();
        if(!$this->financial_year)
        {
            $data = [
                'session_years' => $session_years,
                'branches' => $branches,
            ];
            return view(AUDIT_REPORT.'/balance_sheet')->with($data);
            exit();
        } 

        $tblLedgers = tbl_ledger_model::select('id','main_head','date_of_transaction','bal_sheet_head_model_id')
                ->orderBy('bal_sheet_head_model_id','asc')
                ->groupBy('bal_sheet_head_model_id')
                ->whereNotIn('gtype',['DIRECT EXPENSES','PURCHASE ACCOUNT','DIRECT INCOME','SALES ACCOUNT','INDIRECT EXPENSES','INTEREST PAID','INDIRECT INCOME','INTEREST RECEIVED','LAST YEAR PROFIT'])  
                ->whereNotNull('bal_sheet_head_model_id')
                ->where('date_of_transaction','<=',$this->date)
                ->get();

$netProfit = year_end_tbl::where('session_master_model_id','<',$this->financial_year)->sum('net_profit');
$lastYearCr = tbl_ledger_model::select('id','main_head','date_of_transaction','type_of_transaction')
                ->where('main_head','LAST YEAR PROFIT')
                ->where('date_of_transaction','<=',$this->date)
                ->where('type_of_transaction','Cr')      
                ->sum('amount');
$lastYearDr = tbl_ledger_model::select('id','main_head','date_of_transaction','type_of_transaction')
                ->where('main_head','LAST YEAR PROFIT')
                ->where('date_of_transaction','<=',$this->date)
                ->where('type_of_transaction','Dr')      
                ->sum('amount');


           
        $data = [
            'session_years' => $session_years,
            'branches' => $branches,
            'company_address' => company_address_model::first(),  
            'tblLedgers' => $tblLedgers,           
            'yearEndTblData' => year_end_tbl::where('session_master_model_id',$this->financial_year)->first(),
            'lastYrProfit' => ($netProfit + ($lastYearCr - $lastYearDr)),
        ];
        return view(AUDIT_REPORT.'/balance_sheet_report')->with($data);
    }
    public function showBalanceSheet(Request $request)
    {
        // Retrieve sessions with only required columns
         $subgroups = subgroup_master_model::select('id')->paginate(50);

        return view('Audit.update-balance-sheet',compact('subgroups'));
    }
    public function balanceSheetUpdate(Request $request)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $page = $request->input('recordPerPage', 1);
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');
            $subgroups = subgroup_master_model::select()->paginate(50, ['*'], 'page', $page);
                foreach ($subgroups as $key => $data) {
                    \Illuminate\Support\Facades\DB::table('tbl_ledger_models')
                        ->whereBetween('date_of_transaction', [$startDate, $endDate])
                        ->where('main_head', $data->name)
                        ->update(['bal_sheet_head_model_id' => $data->bal_sheet_head_model_id]);
                }
            return response()->json(['message' => 'The balance sheet has been successfully updated for page no. '. $page]);
        }
        return response()->json(['message' => 'No session selected'], 400);
    }
    public function balanceSheetPDF($dt, $fy, $br = null)
    {
       // This  $data array will be passed to our PDF blade

       $data = [];
        $pdf = PDF::loadView(AUDIT_REPORT.'balance_sheet_pdf', $data);  
        // return $pdf->download('medium.pdf');
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // pass view file
            // $pdf = PDF::loadView(TRANSACTION_BANK_FD_AC.'pdf_view',compact(['data']));
            // download pdf
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('balance-sheet.pdf',compact(['data']));
    }
// Trial balance
    public function trialBalance(Request $request)
    {
        if($request->from_date == "")
        {
            $this->from = date('Y-m-d');
        }
        else
        {
            $this->from = $request->from_date;
        }

        if($request->to_date == "")
        {
            $this->toDate = date('Y-m-d');
        }
        else
        {
            $this->toDate = $request->to_date;
        }
            $openingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                ->where('main_head','CASH')
                ->where('type_of_transaction','Dr')
                ->where('date_of_transaction' ,'<', $this->from)
                ->sum('amount');
            $openingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                ->where('main_head','CASH')
                ->where('type_of_transaction','Cr')
                ->where('date_of_transaction' ,'<', $this->from)
                ->sum('amount');
            
            $closingDrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                ->where('main_head','CASH')
                ->where('type_of_transaction','Dr')
                ->where('date_of_transaction' ,'<=', $this->toDate)
                ->sum('amount');
            $closingCrSum = tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                ->where('main_head','CASH')
                ->where('type_of_transaction','Cr')
                ->where('date_of_transaction' ,'<=', $this->toDate)
                ->sum('amount');
            
        $data = [
            'branch' => $request->branch,
            'from_date' => $this->from,
            'to_date' => $this->toDate,
            'branches' => branch_model::orderBy('name','asc')->get(),
            'company_address' => company_address_model::first(),
            'tblLedgers' => tbl_ledger_model::select('id','amount','main_head','date_of_transaction','type_of_transaction')
                ->groupBy('main_head')
                ->whereNotIn('main_head',['CASH'])
                ->whereBetween('date_of_transaction',[$this->from,$this->toDate])
                ->get(),
              
            'openingDrSum' => $openingDrSum,
            'openingCrSum' => $openingCrSum,
            'opening' => $openingDrSum - $openingCrSum,
            'closingDrSum' => $closingDrSum,
            'closingCrSum' => $closingCrSum,
            'closing' => $closingDrSum - $closingCrSum,
        ];
        return view(AUDIT_REPORT.'/trial-balance')->with($data);
    }
}
