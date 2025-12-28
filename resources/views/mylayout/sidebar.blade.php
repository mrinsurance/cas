<aside class="left-side sidebar-offcanvas collapse-left">
    <section class="sidebar ">
        <div class="page-sidebar  sidebar-nav">

            <div class="clearfix"></div>
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu" id="menu">
                <li class="@if(Request::is('/')) active @endif">
                    <a href="{{HOME_LINK}}">
                        <i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->hasAnyRole('SuperAdmin'))
                <li class="@if(Request::is('master*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-name="barchart" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                        <span class="title">Master</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@if(Request::is('master/member-type*')) active @endif"><a href="{{MASTER_URL_MEMBER_TYPE}}"><i class="fa fa-angle-double-right"></i> Member Types</a></li>
                        <li class="@if(Request::is('master/account-type*')) active @endif"><a href="{{MASTER_URL_AC_TYPE}}"><i class="fa fa-angle-double-right"></i> Account Types</a></li>
                        <li class="@if(Request::is('master/company-address*')) active @endif"><a href="{{MASTER_URL_COMPANY_ADDR}}"><i class="fa fa-angle-double-right"></i> Company Address</a></li>
                        <!-- <li class="@if(Request::is('master/ration-depot*')) active @endif"><a href="{{MASTER_URL_RATION_DEPOT}}"><i class="fa fa-angle-double-right"></i> Ration Depot</a></li> -->
                        <li class="@if(Request::is('master/state*')) active @endif"><a href="{{MASTER_URL_STATE}}"><i class="fa fa-angle-double-right"></i> State</a></li>
                        <li class="@if(Request::is('master/district*')) active @endif"><a href="{{MASTER_URL_DIST}}"><i class="fa fa-angle-double-right"></i> District</a></li>
                        <li class="@if(Request::is('master/patwar*')) active @endif"><a href="{{ route('master.patwar.list') }}"><i class="fa fa-angle-double-right"></i> Patwar</a></li>
                        <li class="@if(Request::is('master/panchayat*')) active @endif"><a href="{{ route('master.panchayat.list') }}"><i class="fa fa-angle-double-right"></i> Panchayat</a></li>
                        <li class="@if(Request::is('master/village*')) active @endif"><a href="{{ route('master.village.list') }}"><i class="fa fa-angle-double-right"></i> Village</a></li>
                        <li class="@if(Request::is('master/relation*')) active @endif"><a href="{{ route('master.relation.list') }}"><i class="fa fa-angle-double-right"></i> Relation</a></li>
                        <li class="@if(Request::is('master/session*')) active @endif"><a href="{{MASTER_URL_SESSION}}"><i class="fa fa-angle-double-right"></i> Session</a></li>
                        <li class="@if(Request::is('master/interest*')) active @endif"><a href="{{MASTER_URL_INTEREST}}"><i class="fa fa-angle-double-right"></i> Interest</a></li>
                        <li class="@if(Request::is('master/balance-sheet-head*')) active @endif"><a href="{{MASTER_URL_BAL_SHEET_HEAD}}"><i class="fa fa-angle-double-right"></i> Balance Sheet head</a></li>
                        <li class="@if(Request::is('master/group*')) active @endif"><a href="{{MASTER_URL_GROUP}}"><i class="fa fa-angle-double-right"></i> Groups</a></li>
                        <li class="@if(Request::is('master/sub-group*')) active @endif"><a href="{{MASTER_URL_SUB_GROUP}}"><i class="fa fa-angle-double-right"></i> Sub Groups</a></li>
                        <li class="@if(Request::is('master/loan*')) active @endif"><a href="{{MASTER_URL_LOAN}}"><i class="fa fa-angle-double-right"></i> Loan</a></li>
                        <li class="@if(Request::is('master/loan-purpose*')) active @endif"><a href="{{MASTER_URL_LOAN_PURPOSE}}"><i class="fa fa-angle-double-right"></i> Loan Purpose</a></li>
                        <li class="@if(Request::is('master/branch*')) active @endif"><a href="{{MASTER_URL_BRANCH}}"><i class="fa fa-angle-double-right"></i> Branch</a></li>
                        <li class="@if(Request::is('master/designation*')) active @endif"><a href="{{MASTER_URL_DESIGNATION}}"><i class="fa fa-angle-double-right"></i> Designation</a></li>
                        <li class="@if(Request::is('master/bank*')) active @endif"><a href="{{MASTER_URL_BANK}}"><i class="fa fa-angle-double-right"></i> Bank</a></li>
                        <li class="@if(Request::is('master/update-tbl-ledger*')) active @endif"><a href="{{MASTER_URL_UPDATE}}"><i class="fa fa-angle-double-right"></i> Update</a></li>

                        <li class="@if(Request::is('master/tax*')) active @endif"><a href="{{MASTER_URL_TAX}}"><i class="fa fa-angle-double-right"></i> Tax</a></li>
                        <li class="@if(Request::is('master/unit*')) active @endif"><a href="{{MASTER_URL_UNIT}}"><i class="fa fa-angle-double-right"></i> Unit</a></li>
                        <li class="@if(Request::is('master/product-type*')) active @endif"><a href="{{MASTER_URL_PRODUCT_TYPE}}"><i class="fa fa-angle-double-right"></i> Product Type</a></li>
                        <li class="@if(Request::is('master/products*')) active @endif"><a href="{{MASTER_URL_PRODUCTS}}"><i class="fa fa-angle-double-right"></i> Products</a></li>
                        <li class="@if(Request::is('master/purchase-party*')) active @endif"><a href="{{MASTER_URL_PURCHASE_PARTY}}"><i class="fa fa-angle-double-right"></i> Purchase Party</a></li>
                        <li class="@if(Request::is('master/sale-party*')) active @endif"><a href="{{ route('master.sale.party.index') }}"><i class="fa fa-angle-double-right"></i> Sale Party</a></li>
                    </ul>
                </li>
                @endif
                @if(!Auth::user()->hasRole('SALEMAN'))
                <li class="@if(Request::is('transaction*')) active @endif">
                    <a href="#"> <i class="livicon" data-name="medal" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i> <span class="title">Transactions</span> <span class="fa arrow"></span> </a>
                    <ul class="sub-menu">
                    @if(!Auth::user()->hasAnyRole(['AGENT']))
                        <li class="@if(Request::is('transaction/new-account*')) active @endif"><a href="#"> <i class="fa fa-angle-double-right"></i> A/C Holders</a>
                            <ul class="sub-menu">
                                <li class="@if(Request::is('transaction/new-account*')) active @endif">
                                    <a href="{{TRANSACTION_URL_OPEN_NEW_AC}}create" >
                                        <i class="fa fa-angle-double-right"></i>
                                        Create Account
                                    </a>
                                </li>
                                <li class="@if(Request::is('transaction/open-short-account*')) active @endif">
                                    <a href="{{ route('transaction.open.short.account') }}" >
                                        <i class="fa fa-angle-double-right"></i>
                                        Create Short Account
                                    </a>
                                </li>
                                <li class="@if(Request::is('transaction/new-account*')) active @endif">
                                    <a href="{{TRANSACTION_URL_OPEN_NEW_AC}}" >
                                        <i class="fa fa-angle-double-right"></i>
                                        Account List
                                    </a>
                                </li>
                                <li class="@if(Request::is('transaction/agent-permission*')) active @endif">
                                    <a href="{{ route('agent-permission') }}" >
                                        <i class="fa fa-angle-double-right"></i>
                                        Agent Permission
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                        <li class="@if(Request::is('transaction/share*')) active @endif"><a href="{{TRANSACTION_URL_SHARE_AC}}" > <i class="fa fa-angle-double-right"></i> Share</a></li>
                        <li class="@if(Request::is('transaction/saving-account*')) active @endif"><a href="{{TRANSACTION_URL_SAVING_AC}}" > <i class="fa fa-angle-double-right"></i> Saving</a></li>
                        <li class="@if(Request::is('transaction/dds*')) active @endif"><a href="{{TRANSACTION_URL_DDS_AC}}" > <i class="fa fa-angle-double-right"></i> DDS</a></li>

                        <li class="@if(Request::is('transaction/fixed-deposite*')) active @endif"><a href="{{TRANSACTION_URL_FD_AC}}" > <i class="fa fa-angle-double-right"></i> Fixed Deposit</a></li>

                        <li class="@if(Request::is('transaction/bank-fixed-deposite*')) active @endif"><a href="{{TRANSACTION_URL_BANK_FD_AC}}" > <i class="fa fa-angle-double-right"></i> Bank FD</a></li>

                        <li class="@if(Request::is('transaction/recurring-deposit*')) active @endif"><a href="{{TRANSACTION_URL_RD_AC}}" > <i class="fa fa-angle-double-right"></i> RD (Monthly)</a></li>
                        <li class="@if(Request::is('transaction/rd-installment*')) active @endif"><a href="{{ route('transaction.rd.installment') }}" > <i class="fa fa-angle-double-right"></i> RD Installment</a></li>
                        <li class="@if(Request::is('transaction/drd*')) active @endif"><a href="{{TRANSACTION_URL_DRD_AC}}" > <i class="fa fa-angle-double-right"></i> DRD (Daily)</a></li>
                        <li class="@if(Request::is('transaction/loan*')) active @endif"><a href="{{TRANSACTION_URL_LOAN_AC}}" > <i class="fa fa-angle-double-right"></i> Loan</a></li>
                        <li class="@if(Request::is('transaction/mis*')) active @endif"><a href="{{TRANSACTION_URL_MIS_AC}}" > <i class="fa fa-angle-double-right"></i> MIS</a></li>
                        <li class="@if(Request::is('transaction/voucher-single*')) active @endif"><a href="{{TRANSACTION_URL_VOUCHER_SINGLE}}" > <i class="fa fa-angle-double-right"></i> Voucher</a></li>

                        <li class="@if(Request::is('transaction/voucher*')) active @endif"><a href="{{TRANSACTION_URL_VOUCHER}}" > <i class="fa fa-angle-double-right"></i> Voucher (Multi)</a></li>

                    </ul>
                </li>
                @endif
                <li class="@if(Request::is('trading*')) active @endif">
                    <a href="#"> <i class="livicon" data-name="medal" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i> <span class="title">Trading</span> <span class="fa arrow"></span> </a>
                    <ul class="sub-menu">
                        <li class="@if(Request::is('trading/products*')) active @endif"><a href="{{TRADING_URL_PRODUCTS}}" > <i class="fa fa-angle-double-right"></i> Product</a></li>
                        <li class="@if(Request::is('trading/purchase*')) active @endif"><a href="{{TRADING_URL_PURCHASE}}" > <i class="fa fa-angle-double-right"></i> Purchase</a></li>
                        <li class="@if(Request::is('trading/sale*')) active @endif"><a href="{{TRADING_URL_SALE}}" > <i class="fa fa-angle-double-right"></i> Sale</a></li>

                        <li class=""><a href="{{TRADING_URL_SALE_PURCHASE_REPORT}}" > <i class="fa fa-angle-double-right"></i> Sale Purchase Report</a></li>

                        <li class=""><a href="{{url('trading/item-ledger')}}" > <i class="fa fa-angle-double-right"></i> Item Ledger</a></li>

                        <li class="@if(Request::is('trading/stock-report*')) active @endif"><a href="{{ route('trading.stock.report') }}" > <i class="fa fa-angle-double-right"></i> Stock Report</a></li>
                        <li class="@if(Request::is('trading/sale-collection-report*')) active @endif"><a href="{{ route('trading.sale.collection.report') }}"> <i class="fa fa-angle-double-right"></i> Collection Report</a></li>
                    </ul>
                </li>

                @if(Auth::user()->staff_type != 'Agent')
                <li class="@if(Request::is('daily-report*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-name="flag" data-c="#418bca" data-hc="#418bca" data-size="18" data-loop="true"></i>
                        <span class="title">Daily Report</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">

                        <li class="@if(Request::is('daily-report/day-book*')) active @endif"><a href="{{DAILY_REPORT_URL_DAY_BOOK}}"> <i class="fa fa-angle-double-right"></i> Cash Book/Day Book</a></li>
                        <li class="@if(Request::is('daily-report/day-book*')) active @endif"><a href="{{ route('daily.report.cash.book.combine') }}"> <i class="fa fa-angle-double-right"></i> Cash Book Combine</a></li>

                        <li class="@if(Request::is('daily-report/dcr*')) active @endif"><a href="{{DAILY_REPORT_URL_DCR}}"> <i class="fa fa-angle-double-right"></i> Daily Collection Report</a></li>
                        @if(Auth::user()->hasAnyRole('ACCOUNTANT'))
                        <li class="@if(Request::is('daily-report/shadow*')) active @endif"><a href="{{DAILY_REPORT_URL_SHADOW}}"> <i class="fa fa-angle-double-right"></i> Daily Collection Status</a></li>
                        @endif
                        <li class="@if(Request::is('daily-report/fd-status-report*')) active @endif"><a href="{{ route('daily.report.fd.status.report') }}"> <i class="fa fa-angle-double-right"></i> FD Status Report</a></li>
                        <li class="@if(Request::is('daily-report/bank-fd-status-report*')) active @endif"><a href="{{ route('daily.report.bank.fd.status.report') }}"> <i class="fa fa-angle-double-right"></i> Bank FD Status Report</a></li>
                        <li class="@if(Request::is('daily-report/loan-recovery-report*')) active @endif"><a href="{{ route('daily.report.loan.recovery.report') }}"> <i class="fa fa-angle-double-right"></i> Loan Recovery Report</a></li>
                    </ul>
                </li>

                <li class="@if(Request::is('balance-report')) active @endif">
                    <a href="#">
                        <i class="livicon" data-name="flag" data-c="#418bca" data-hc="#418bca" data-size="18" data-loop="true"></i>
                        <span class="title">Balance Report</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">

                        <li class="@if(Request::is('balance-report/share*')) active @endif"><a href="{{BALANCE_REPORT_URL_SHARE}}"> <i class="fa fa-angle-double-right"></i> Share</a></li>
                        <li class="@if(Request::is('balance-report/dds*')) active @endif"><a href="{{BALANCE_REPORT_URL_DDS}}"> <i class="fa fa-angle-double-right"></i> DDS</a></li>
                        <li class="@if(Request::is('balance-report/saving*')) active @endif"><a href="{{BALANCE_REPORT_URL_SAVING}}"> <i class="fa fa-angle-double-right"></i> SAVING</a></li>

                        <li class="@if(Request::is('balance-report/fixed-deposit*')) active @endif"><a href="{{BALANCE_REPORT_URL_FD}}"> <i class="fa fa-angle-double-right"></i> Fixed Deposit</a></li>
                        <li class="@if(Request::is('balance-report/bank-fd*')) active @endif"><a href="{{BALANCE_REPORT_URL_BANK_FD}}"> <i class="fa fa-angle-double-right"></i> Bank FD</a></li>
                        <li class="@if(Request::is('balance-report/by-day-bank-fd*')) active @endif"><a href="{{BALANCE_REPORT_URL_BANK_FD_BY_DAY}}"> <i class="fa fa-angle-double-right"></i> Bank FD by Day</a></li>
                        <li class="@if(Request::is('balance-report/rd*')) active @endif"><a href="{{BALANCE_REPORT_URL_RD}}"> <i class="fa fa-angle-double-right"></i> RD</a></li>
                        <li class="@if(Request::is('balance-report/drd*')) active @endif"><a href="{{BALANCE_REPORT_URL_DRD}}"> <i class="fa fa-angle-double-right"></i> DRD</a></li>
                        <li class="@if(Request::is('balance-report/mis*')) active @endif"><a href="{{BALANCE_REPORT_URL_MIS}}"> <i class="fa fa-angle-double-right"></i> MIS</a></li>

                        <li class="@if(Request::is('balance-report/loan*')) active @endif"><a href="{{BALANCE_REPORT_URL_LOAN}}"> <i class="fa fa-angle-double-right"></i> Loan</a></li>
                        <li class="@if(Request::is('balance-report/loan*')) active @endif"><a href="{{BALANCE_REPORT_URL_BALANCE_SHARE_SAVING}}"> <i class="fa fa-angle-double-right"></i>Balance (Share+Saving)</a></li>

                        <li class="@if(Request::is('balance-report/balance-book*')) active @endif"><a href="{{BALANCE_REPORT_URL_BALANCE_BOOK}}"> <i class="fa fa-angle-double-right"></i> Balance Book</a></li>
                        <li class="@if(Request::is('balance-report/balance-book*')) active @endif"><a href="{{BALANCE_REPORT_URL_BALANCE_BOOK_STATUS}}"> <i class="fa fa-angle-double-right"></i> Balance Book Status</a></li>
                        <li class="@if(Request::is('balance-report/balance-book-list*')) active @endif"><a href="{{ route('balance.book.list') }}"> <i class="fa fa-angle-double-right"></i> Balance Book List</a></li>

                    </ul>
                </li>
                <li class="@if(Request::is('balance-report-page-total*')) active @endif">
                        <a href="#">
                            <i class="livicon" data-name="flag" data-c="#418bca" data-hc="#418bca" data-size="18" data-loop="true"></i>
                            <span class="title">Balance Report (Page Total)</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="@if(Request::is('balance-report-page-total/balance-book*')) active @endif"><a href="{{ route('balance.report.page.total.balance.book') }}"> <i class="fa fa-angle-double-right"></i> Balance Book</a></li>
                            <li class="@if(Request::is('balance-report-page-total/fixed-deposit*')) active @endif"><a href="{{ route('balance.report.page.total.fixed.deposit') }}"> <i class="fa fa-angle-double-right"></i> Fixed Deposit</a></li>
                            <li class="@if(Request::is('balance-report-page-total/rd*')) active @endif"><a href="{{ route('balance.report.page.total.balance.rd') }}"> <i class="fa fa-angle-double-right"></i> RD Balance</a></li>
                            <li class="@if(Request::is('balance-report-page-total/bank-fd*')) active @endif"><a href="{{ route('balance.report.page.total.bank.fd') }}"> <i class="fa fa-angle-double-right"></i> Bank FD</a></li>
                            <li class="@if(Request::is('balance-report-page-total/loan-advancement*')) active @endif"><a href="{{ route('balance.report.page.total.loan-advancement') }}"> <i class="fa fa-angle-double-right"></i> Loan Advancement</a></li>
                        </ul>
                    </li>
                <li class="@if(Request::is('detailed-balance-report*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-name="flag" data-c="#418bca" data-hc="#418bca" data-size="18" data-loop="true"></i>
                        <span class="title">Detailed Balance Report</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@if(Request::is('detailed-balance-report/share*')) active @endif"><a href="{{D_BALANCE_REPORT_URL_SHARE}}"> <i class="fa fa-angle-double-right"></i> Share</a></li>
                        <li class="@if(Request::is('detailed-balance-report/dds*')) active @endif"><a href="{{D_BALANCE_REPORT_URL_DDS}}"> <i class="fa fa-angle-double-right"></i> DDS</a></li>
                        <li class="@if(Request::is('detailed-balance-report/saving*')) active @endif"><a href="{{D_BALANCE_REPORT_URL_SAVING}}"> <i class="fa fa-angle-double-right"></i> Saving</a></li>

                        <li class="@if(Request::is('detailed-balance-report/loan-defaulter*')) active @endif"><a href="{{D_BALANCE_REPORT_URL_LOAN_DEFAULTER}}"> <i class="fa fa-angle-double-right"></i> Loan Defaulter</a></li>

                        <li class="@if(Request::is('detailed-balance-report/npa*')) active @endif"><a href="{{D_BALANCE_REPORT_URL_NPA}}"> <i class="fa fa-angle-double-right"></i> NPA</a></li>
                    </ul>
                </li>
                <li class="@if(Request::is('ledger-report*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-name="flag" data-c="#418bca" data-hc="#418bca" data-size="18" data-loop="true"></i>
                        <span class="title">Ledger Report</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@if(Request::is('ledger-report/personal-ledger*')) active @endif"><a href="{{LEDGER_REPORT_URL_PERSONAL_LEDGER}}"> <i class="fa fa-angle-double-right"></i> Personal Ledger</a></li>
                        <li class="@if(Request::is('ledger-report/print-personal-ledger*')) active @endif"><a href="{{ route('ledger.print-personal-ledger') }}"> <i class="fa fa-angle-double-right"></i> Print Personal Ledger</a></li>
                        <li class="@if(Request::is('ledger-report/fd-ledger*')) active @endif"><a href="{{ route('ledger.fd-ledger') }}"> <i class="fa fa-angle-double-right"></i> FD Ledger</a></li>
                        <li class="@if(Request::is('ledger-report/print-fd-ledger*')) active @endif"><a href="{{ route('ledger.print-fd-ledger') }}"> <i class="fa fa-angle-double-right"></i> Print FD Ledger</a></li>
                        <li class="@if(Request::is('ledger-report/head-ledger*')) active @endif"><a href="{{LEDGER_REPORT_URL_HEAD_LEDGER}}"> <i class="fa fa-angle-double-right"></i> Head Ledger</a></li>
                        <li class="@if(Request::is('ledger-report/general-ledger*')) active @endif"><a href="{{LEDGER_REPORT_URL_GENERAL_LEDGER}}"> <i class="fa fa-angle-double-right"></i> General Ledger</a></li>
                        <li class="@if(Request::is('ledger-report/general-ledger-all*')) active @endif"><a href="{{ route('ledger.general-ledger-all') }}"> <i class="fa fa-angle-double-right"></i> General Ledger All</a></li>
                    </ul>
                </li>
                <li class="@if(Request::is('audit-report*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-name="flag" data-c="#418bca" data-hc="#418bca" data-size="18" data-loop="true"></i>
                        <span class="title">Audit Report</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@if(Request::is('audit-report/rd*')) active @endif"><a href="{{AUDIT_REPORT_URL_RD}}"> <i class="fa fa-angle-double-right"></i> RD</a></li>
                        <li class="@if(Request::is('audit-report/trading-account*')) active @endif"><a href="{{AUDIT_REPORT_URL_TRADING_AC}}"> <i class="fa fa-angle-double-right"></i> Trading A/C</a></li>
                        <li class="@if(Request::is('audit-report/profit-loss*')) active @endif"><a href="{{AUDIT_REPORT_URL_PROFIT_LOSS}}"> <i class="fa fa-angle-double-right"></i> Profit & Loss</a></li>

                        <li class="@if(Request::is('audit-report/trading-pl*')) active @endif"><a href="{{AUDIT_REPORT_URL_TRADING_PL}}"> <i class="fa fa-angle-double-right"></i> Trading & P/L</a></li>



                        <li class="@if(Request::is('audit-report/loan-advancement*')) active @endif"><a href="{{AUDIT_REPORT_URL_LOAN_ADVANCEMENT}}"> <i class="fa fa-angle-double-right"></i> Loan Advancement</a></li>
                        <li class="@if(Request::is('audit-report/loan-detail*')) active @endif"><a href="{{ route('audit.report.loan.advance.detail') }}"> <i class="fa fa-angle-double-right"></i> Loan Detail</a></li>


                        <li class="@if(Request::is('audit-report/balance-sheet*')) active @endif"><a href="{{AUDIT_REPORT_URL_BALANCE_SHEET}}"> <i class="fa fa-angle-double-right"></i> Balance Sheet</a></li>

                        <li class="@if(Request::is('audit-report/trial-balance*')) active @endif"><a href="{{AUDIT_REPORT_URL_TRIAL_BALANCE}}"> <i class="fa fa-angle-double-right"></i> Trial Balance</a></li>
                    </ul>
                </li>
                <li class="@if(Request::is('additional-report*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-name="flag" data-c="#418bca" data-hc="#418bca" data-size="18" data-loop="true"></i>
                        <span class="title">Additional Report</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@if(Request::is('additional-report/agent-account-report*')) active @endif"><a href="{{ADDITIONAL_REPORT_URL_AGENT}}"> <i class="fa fa-angle-double-right"></i>Agent A/C Report</a></li>
                        <li class="@if(Request::is('additional-report/ward-report*')) active @endif"><a href="{{ADDITIONAL_WARD_AGENT}}"> <i class="fa fa-angle-double-right"></i>Ward Report</a></li>
                        <li class="@if(Request::is('additional-report/society-status*')) active @endif"><a href="{{ route('additional.report.society.status') }}"> <i class="fa fa-angle-double-right"></i>Society Status</a></li>
                    </ul>
                </li>
                <li class="@if(Request::is('calculations*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-name="flag" data-c="#418bca" data-hc="#418bca" data-size="18" data-loop="true"></i>
                        <span class="title">Calculations</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@if(Request::is('calculations/dividend-calculation*')) active @endif"><a href="{{DIVIDEND_CALCULATION_URL}}"> <i class="fa fa-angle-double-right"></i>Dividend</a></li>

                        <li class="@if(Request::is('calculations/dividend-list*')) active @endif"><a href="{{DIVIDEND_LIST_URL}}"> <i class="fa fa-angle-double-right"></i>Dividend List</a></li>

                        <li class="@if(Request::is('calculations/interest-on-saving*')) active @endif"><a href="{{INTEREST_ON_SAVING_URL}}"> <i class="fa fa-angle-double-right"></i>Interest on Saving</a></li>
                        <li class="@if(Request::is('calculations/interest-on-fd*')) active @endif"><a href="{{ route('calculations.interest-on-fd') }}"> <i class="fa fa-angle-double-right"></i>Interest on FD</a></li>

                        <li class="@if(Request::is('calculations/interest-on-saving-list*')) active @endif"><a href="{{INTEREST_ON_SAVING_LIST_URL}}"> <i class="fa fa-angle-double-right"></i>Interest on Saving List</a></li>
                    </ul>
                </li>
                @endif

                @if(Auth::user()->hasAnyRole('SuperAdmin'))
                <li class="@if(Request::is('users*') || Request::is('roles*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="gears" data-size="18" data-loop="true"></i>
                        <span class="title">Financial Year</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@if(Request::is('users*')) active @endif">
                            <!-- <a href="{{USERS}}">
                                <i class="fa fa-angle-double-right"></i> Session Master
                            </a> -->
                        </li>
                        <li class="@if(Request::is('year-end*')) active @endif">
                            <a href="{{FINANCIAL_YEAR_END_URL}}">
                                <i class="fa fa-angle-double-right"></i> Year End
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                     <a href="{{url('downloads')}}">
                        <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="download" data-size="18" data-loop="true"></i>
                        <span class="title">Download</span>

                    </a>

                </li>
                <li class="@if(Request::is('users*') || Request::is('roles*')) active @endif">
                    <a href="#">
                        <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="gears" data-size="18" data-loop="true"></i>
                        <span class="title">Settings</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('balance.report.update.saving',['m'=>1]) }}" > <i class="fa fa-angle-double-right"></i>Update Saving Member</a></li>
                        <li><a href="{{ route('balance.report.update.saving',['m'=>2]) }}" > <i class="fa fa-angle-double-right"></i>Update Saving N-Member</a></li>
                        <li><a href="{{ route('balance.report.update.share',['m'=>1]) }}" > <i class="fa fa-angle-double-right"></i>Update Share Member</a></li>
                        <li><a href="{{ route('balance.report.update.loan-return-member-type') }}" > <i class="fa fa-angle-double-right"></i>Update Loan Member Type</a></li>
                        <li><a href="{{ route('setting.audit-report.balance-sheet') }}" > <i class="fa fa-angle-double-right"></i>Update Balance Sheet</a></li>
                        <li class="@if(Request::is('users*')) active @endif">
                            <a href="{{USERS}}">
                                <i class="fa fa-angle-double-right"></i> Manage Users
                            </a>
                        </li>
                        <li class="@if(Request::is('roles*')) active @endif">
                            <a href="{{ROLES}}">
                                <i class="fa fa-angle-double-right"></i> Manage Role
                            </a>
                        </li>
                         <li class="@if(Request::is('roles*')) active @endif">
                         <a href="{{url('dbbackup/backup.php')}}" >
                                <i class="fa fa-angle-double-right"></i> Backup database
                            </a>
                        </li>
                       <!-- <li class="@if(Request::is('setting/loan-balance-second*')) active @endif">
                            <a href="{{route('setting.loan-controller-second')}}" >
                                <i class="fa fa-angle-double-right"></i> Loan Balance Second
                            </a>-->
                        </li>
                        <li class="@if(Request::is('setting/fixed-deposit-second*')) active @endif">
                            <a href="{{route('setting.fixed-deposit-second')}}" >
                                <i class="fa fa-angle-double-right"></i> Fixed Deposit Second
                            </a>
                        </li>
                        <li class="@if(Request::is('setting/rd-second*')) active @endif">
                            <a href="{{route('setting.rd-second')}}" >
                                <i class="fa fa-angle-double-right"></i> RD Second
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </section>
    <!-- /.sidebar -->
</aside>
