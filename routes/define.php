<?php
define('PREFIX1', $base.'public/');
define('BASE_PATH', $base.'/');
define('PREFIX', $base);


define('ASSETS', PREFIX.'assets/');
define('HOME_LINK', PREFIX.'');

define('ASSETS_CSS', ASSETS.'css/');
define('ASSETS_CSS_MAP', ASSETS_CSS.'maps/');

define('ASSETS_IMAGES', ASSETS.'images/');
define('DOWNLOAD', PREFIX1.'download/');

define('ASSETS_JS', ASSETS.'js/');
define('ASSETS_JS_DATEPICKER', ASSETS_JS.'datepicker/');
define('ASSETS_JS_MOMENT', ASSETS_JS.'moment/');

define('ASSETS_SRC', ASSETS.'src/');
define('ASSETS_SRC_JS', ASSETS_SRC.'js/');
define('ASSETS_SRC_JS_helpers', ASSETS_SRC_JS.'helpers/');

define('ASSETS_SRC_SCSS', ASSETS_SRC.'scss/');

define('ASSETS_VENDORS', ASSETS.'vendors/');

// Master folder paths
define('MASTER','Master/');
define('MASTER_MEMBER_TYPE',MASTER.'Member_Type/');
define('MASTER_AC_TYPE',MASTER.'Account_Type/');
define('MASTER_COMPANY_ADDR',MASTER.'Company_Address/');
define('MASTER_RATION_DEPOT',MASTER.'Ration_Depot/');
define('MASTER_STATE_MASTER',MASTER.'State_Master/');
define('MASTER_DIST_MASTER',MASTER.'District_Master/');
define('MASTER_SESSION_MASTER',MASTER.'Session_Master/');
define('MASTER_INTEREST_MASTER',MASTER.'Interest_Master/');
define('MASTER_GROUP_MASTER',MASTER.'Group_Master/');
define('MASTER_SUB_GROUP_MASTER',MASTER.'SubGroup_Master/');
define('MASTER_BAL_SHEET_HEAD_MASTER',MASTER.'Balance_Sheet_Head/');
define('MASTER_LOAN_MASTER',MASTER.'Loan_Master/');
define('MASTER_LOAN_PURPOSE',MASTER.'Loan_Purpose/');
define('MASTER_BRANCH_MASTER',MASTER.'Branch_Master/');
define('MASTER_DESIGNATION_MASTER',MASTER.'Designation_Master/');
define('MASTER_BANK_MASTER',MASTER.'Bank_Master/');
define('MASTER_UPDATE_MASTER',MASTER.'Update/');

define('MASTER_TAX_MASTER',MASTER.'Tax/');
define('MASTER_UNIT_MASTER',MASTER.'Unit/');
define('MASTER_PRODUCT_TYPE_MASTER',MASTER.'Product-Type/');
define('MASTER_PRODUCTS_MASTER',MASTER.'Products/');
define('MASTER_PURCHASE_PARTY',MASTER.'Purchase-Party/');

// Master url path
define('MASTER_URL', PREFIX.'master/');
define('MASTER_URL_MEMBER_TYPE', MASTER_URL.'member-type/');
define('MASTER_URL_POST_MEMBER_TYPE', MASTER_URL.'member-type');
define('MASTER_URL_AC_TYPE', MASTER_URL.'account-type/');
define('MASTER_URL_POST_AC_TYPE', MASTER_URL.'account-type');
define('MASTER_URL_COMPANY_ADDR', MASTER_URL.'company-address/');
define('MASTER_URL_POST_COMPANY_ADDR', MASTER_URL.'company-address');
define('MASTER_URL_RATION_DEPOT', MASTER_URL.'ration-depot/');
define('MASTER_URL_POST_RATION_DEPOT', MASTER_URL.'ration-depot');
define('MASTER_URL_STATE', MASTER_URL.'state/');
define('MASTER_URL_POST_STATE', MASTER_URL.'state');
define('MASTER_URL_DIST', MASTER_URL.'district/');
define('MASTER_URL_POST_DIST', MASTER_URL.'district');
define('MASTER_URL_SESSION', MASTER_URL.'session/');
define('MASTER_URL_POST_SESSION', MASTER_URL.'session');
define('MASTER_URL_INTEREST', MASTER_URL.'interest/');
define('MASTER_URL_POST_INTEREST', MASTER_URL.'interest');
define('MASTER_URL_GROUP', MASTER_URL.'group/');
define('MASTER_URL_POST_GROUP', MASTER_URL.'group');
define('MASTER_URL_SUB_GROUP', MASTER_URL.'sub-group/');
define('MASTER_URL_POST_SUB_GROUP', MASTER_URL.'sub-group');
define('MASTER_URL_BAL_SHEET_HEAD', MASTER_URL.'balance-sheet-head/');
define('MASTER_URL_POST_BAL_SHEET_HEAD', MASTER_URL.'balance-sheet-head');
define('MASTER_URL_LOAN', MASTER_URL.'loan/');
define('MASTER_URL_POST_LOAN', MASTER_URL.'loan');
define('MASTER_URL_LOAN_PURPOSE', MASTER_URL.'loan-purpose/');
define('MASTER_URL_POST_LOAN_PURPOSE', MASTER_URL.'loan-purpose');
define('MASTER_URL_BRANCH', MASTER_URL.'branch/');
define('MASTER_URL_POST_BRANCH', MASTER_URL.'branch');
define('MASTER_URL_DESIGNATION', MASTER_URL.'designation/');
define('MASTER_URL_POST_DESIGNATION', MASTER_URL.'designation');
define('MASTER_URL_BANK', MASTER_URL.'bank/');
define('MASTER_URL_POST_BANK', MASTER_URL.'bank');
define('MASTER_URL_UPDATE', MASTER_URL.'update-tbl-ledger');
define('MASTER_URL_POST_UPDATE', MASTER_URL.'update-tbl-ledger');

define('MASTER_URL_TAX', MASTER_URL.'tax');
define('MASTER_URL_UNIT', MASTER_URL.'unit');
define('MASTER_URL_PRODUCT_TYPE', MASTER_URL.'product-type');
define('MASTER_URL_PRODUCTS', MASTER_URL.'products');
define('MASTER_URL_PURCHASE_PARTY', MASTER_URL.'purchase-party');

// ********************************

// Storage Images Path
define('STORAGE',url('public/storage/'));
define('MEMBER_PHOTO',STORAGE.'/member-photo/');
define('MEMBER_PHOTO_THUMB',MEMBER_PHOTO.'thumbnail/');
define('MEMBER_SIGN',STORAGE.'/member-signature/');
define('MEMBER_SIGN_THUMB',MEMBER_SIGN.'thumbnail/');
define('MEMBER_DOC',STORAGE.'/member-document/');
define('USER_PHOTO',STORAGE.'/user-photo/');
define('USER_PHOTO_THUMB',USER_PHOTO.'/thumbnail/');

// Transaction folder paths
define('TRANSACTION','Transaction/');
define('TRANSACTION_OPEN_NEW_AC',TRANSACTION.'Open_New_Ac/');
define('TRANSACTION_SHARE_AC',TRANSACTION.'Share_Ac/');
define('TRANSACTION_SAVING_AC',TRANSACTION.'Saving_Ac/');
define('TRANSACTION_DDS_AC',TRANSACTION.'Dds_Ac/');
define('TRANSACTION_FD_AC',TRANSACTION.'FD_Ac/');
define('TRANSACTION_BANK_FD_AC',TRANSACTION.'Bank_FD_Ac/');
define('TRANSACTION_RD_AC',TRANSACTION.'RD_Ac/');
define('TRANSACTION_DRD_AC',TRANSACTION.'DRD_Ac/');
define('TRANSACTION_LOAN_AC',TRANSACTION.'LOAN_Ac/');
define('TRANSACTION_MIS_AC',TRANSACTION.'MIS_Ac/');
define('TRANSACTION_VOUCHER_SINGLE',TRANSACTION.'Voucher-Single/');
define('TRANSACTION_VOUCHER',TRANSACTION.'Voucher/');

// Transaction url path
define('TRANSACTION_URL', PREFIX.'transaction/');
define('TRANSACTION_URL_OPEN_NEW_AC', TRANSACTION_URL.'new-account/');
define('TRANSACTION_URL_POST_OPEN_NEW_AC', TRANSACTION_URL.'new-account');
define('TRANSACTION_URL_SHARE_AC', TRANSACTION_URL.'share/');
define('TRANSACTION_URL_POST_SHARE_AC', TRANSACTION_URL.'share');
define('TRANSACTION_URL_SAVING_AC', TRANSACTION_URL.'saving-account/');
define('TRANSACTION_URL_POST_SAVING_AC', TRANSACTION_URL.'saving-account');
define('TRANSACTION_URL_DDS_AC', TRANSACTION_URL.'dds/');
define('TRANSACTION_URL_POST_DDS_AC', TRANSACTION_URL.'dds');
define('TRANSACTION_URL_FD_AC', TRANSACTION_URL.'fixed-deposite/');
define('TRANSACTION_URL_POST_FD_AC', TRANSACTION_URL.'fixed-deposite');

define('TRANSACTION_URL_BANK_FD_AC', TRANSACTION_URL.'bank-fixed-deposite/');
define('TRANSACTION_URL_POST_BANK_FD_AC', TRANSACTION_URL.'bank-fixed-deposite');

define('TRANSACTION_URL_RD_AC', TRANSACTION_URL.'recurring-deposit/');
define('TRANSACTION_URL_POST_RD_AC', TRANSACTION_URL.'recurring-deposit');
define('TRANSACTION_URL_POST_RD_INSTALLMENT', TRANSACTION_URL.'recurring-deposit/installment');
define('TRANSACTION_URL_DRD_AC', TRANSACTION_URL.'drd/');
define('TRANSACTION_URL_POST_DRD_AC', TRANSACTION_URL.'drd');
define('TRANSACTION_URL_POST_DRD_INSTALLMENT', TRANSACTION_URL.'drd/installment');
define('TRANSACTION_URL_LOAN_AC', TRANSACTION_URL.'loan/');
define('TRANSACTION_URL_POST_LOAN_AC', TRANSACTION_URL.'loan');
define('TRANSACTION_URL_MIS_AC', TRANSACTION_URL.'mis/');
define('TRANSACTION_URL_POST_MIS_AC', TRANSACTION_URL.'mis');
// single voucher
define('TRANSACTION_URL_VOUCHER_SINGLE', TRANSACTION_URL.'voucher-single/');
define('TRANSACTION_URL_POST_VOUCHER_SINGLE', TRANSACTION_URL.'voucher-single');
// Multi voucher
define('TRANSACTION_URL_VOUCHER', TRANSACTION_URL.'voucher/');
define('TRANSACTION_URL_POST_VOUCHER', TRANSACTION_URL.'voucher');

// Daily Reports folder paths
define('DAILY_REPORT','Daily_Report/');
define('DAILY_REPORT_DAY_BOOK',DAILY_REPORT.'Day_Book/');
define('DAILY_REPORT_DCR',DAILY_REPORT.'DCR/');
define('DAILY_REPORT_SHADOW',DAILY_REPORT.'SHADOW/');

// Daily Reports url path
define('DAILY_REPORT_URL', PREFIX.'daily-report/');
define('DAILY_REPORT_URL_DAY_BOOK', DAILY_REPORT_URL.'day-book/');
define('DAILY_REPORT_URL_DCR', DAILY_REPORT_URL.'dcr/');
define('DAILY_REPORT_URL_SHADOW', DAILY_REPORT_URL.'shadow/');

// Balance Reports folder paths
define('BALANCE_REPORT','Balance/');

// Balance Reports url path
define('BALANCE_REPORT_URL', PREFIX.'balance-report/');
define('BALANCE_REPORT_URL_SHARE', BALANCE_REPORT_URL.'share/');
define('BALANCE_REPORT_URL_DDS', BALANCE_REPORT_URL.'dds/');
define('BALANCE_REPORT_URL_SAVING', BALANCE_REPORT_URL.'saving/');
define('BALANCE_REPORT_URL_FD', BALANCE_REPORT_URL.'fixed-deposit/');
define('BALANCE_REPORT_URL_BANK_FD', BALANCE_REPORT_URL.'bank-fd/');
define('BALANCE_REPORT_URL_BANK_FD_BY_DAY', BALANCE_REPORT_URL.'by-day-bank-fd/');
define('BALANCE_REPORT_URL_RD', BALANCE_REPORT_URL.'rd/');
define('BALANCE_REPORT_URL_DRD', BALANCE_REPORT_URL.'drd/');
define('BALANCE_REPORT_URL_MIS', BALANCE_REPORT_URL.'mis/');
define('BALANCE_REPORT_URL_LOAN', BALANCE_REPORT_URL.'loan/');
define('BALANCE_REPORT_URL_BALANCE_SHARE_SAVING', BALANCE_REPORT_URL.'balance-share-saving/');
define('BALANCE_REPORT_URL_BALANCE_BOOK', BALANCE_REPORT_URL.'balance-book/');
define('BALANCE_REPORT_URL_BALANCE_BOOK_STATUS', BALANCE_REPORT_URL.'balance-book-status/');
// Detailed Balance Reports url path
define('D_BALANCE_REPORT_URL', PREFIX.'detailed-balance-report/');
define('D_BALANCE_REPORT_URL_SHARE', D_BALANCE_REPORT_URL.'share/');
define('D_BALANCE_REPORT_URL_DDS', D_BALANCE_REPORT_URL.'dds/');
define('D_BALANCE_REPORT_URL_SAVING', D_BALANCE_REPORT_URL.'saving/');
define('D_BALANCE_REPORT_URL_LOAN_DEFAULTER', D_BALANCE_REPORT_URL.'loan-defaulter/');
define('D_BALANCE_REPORT_URL_NPA', D_BALANCE_REPORT_URL.'npa/');

// Audit Reports folder path
define('AUDIT_REPORT','Audit/');

// Audit Report url path
define('AUDIT_REPORT_URL',PREFIX.'audit-report/');
define('AUDIT_REPORT_URL_RD',AUDIT_REPORT_URL.'rd/');
define('AUDIT_REPORT_URL_TRADING_AC',AUDIT_REPORT_URL.'trading-account/');
define('AUDIT_REPORT_URL_TRADING_PL',AUDIT_REPORT_URL.'trading-pl/');
define('AUDIT_REPORT_URL_PROFIT_LOSS',AUDIT_REPORT_URL.'profit-loss/');
define('AUDIT_REPORT_URL_LOAN_ADVANCEMENT',AUDIT_REPORT_URL.'loan-advancement/');
define('AUDIT_REPORT_URL_BALANCE_SHEET',AUDIT_REPORT_URL.'balance-sheet/');
define('AUDIT_REPORT_URL_TRIAL_BALANCE',AUDIT_REPORT_URL.'trial-balance/');

// Ledger Reports folder path
define('LEDGER_REPORT','Ledger/');

// Ledger Report url path
define('LEDGER_REPORT_URL',PREFIX.'ledger-report/');
define('LEDGER_REPORT_URL_PERSONAL_LEDGER',LEDGER_REPORT_URL.'personal-ledger/');
define('LEDGER_REPORT_URL_HEAD_LEDGER',LEDGER_REPORT_URL.'head-ledger/');
define('LEDGER_REPORT_URL_GENERAL_LEDGER',LEDGER_REPORT_URL.'general-ledger/');

// Additional Reports folder path
define('ADDITIONAL_REPORT','Additional/');

// Additional Report url path
define('ADDITIONAL_REPORT_URL',PREFIX.'additional-report/');
define('ADDITIONAL_REPORT_URL_AGENT',ADDITIONAL_REPORT_URL.'agent-account-report/');
define('ADDITIONAL_WARD_AGENT',ADDITIONAL_REPORT_URL.'ward-report/');

// Calculation paths
define('CALCULATION_PATH','Calculation/');

// Calculations
define('CALCULATION_URL',PREFIX.'calculations/');
define('DIVIDEND_CALCULATION_URL',CALCULATION_URL.'dividend-calculation');
define('DIVIDEND_LIST_URL',CALCULATION_URL.'dividend-list');

define('INTEREST_ON_SAVING_URL',CALCULATION_URL.'interest-on-saving');
define('INTEREST_ON_SAVING_LIST_URL',CALCULATION_URL.'interest-on-saving-list');



// User Permission & Rolles
define('USERS', PREFIX.'users');
define('ROLES', PREFIX.'roles');

// Trading folder paths
define('TRADING','Trading/');
define('TRADING_PRODUCT_PATH',TRADING.'Products/');
define('TRADING_PURCHASE_PATH',TRADING.'Purchase/');
define('TRADING_SALE_PATH',TRADING.'Sale/');
define('TRADING_SALE_PURCHASE_PATH',TRADING.'Sale-Purchase/');
define('TRADING_ITEM_LEDGER_PATH',TRADING.'item-ledger/');

// Trading url path
define('TRADING_URL', PREFIX.'trading/');
define('TRADING_URL_PRODUCTS', TRADING_URL.'products');
define('TRADING_URL_PURCHASE', TRADING_URL.'purchase');
define('TRADING_URL_SALE', TRADING_URL.'sale');
define('TRADING_URL_SALE_PURCHASE_REPORT', TRADING_URL.'sale-purchase-report');
define('TRADING_URL_ITEM_LEDGER_PATH',TRADING_URL.'item-ledger/');

// Financial Year folder paths
define('FINANCIAL_YEAR','FinancialYear/');
define('FINANCIAL_YEAR_END_FOLDER',FINANCIAL_YEAR.'YearEnd/');

// Financial Year url path
define('FINANCIAL_YEAR_URL', PREFIX.'financial-year/');
define('FINANCIAL_YEAR_END_URL', FINANCIAL_YEAR_URL.'year-end');

?>