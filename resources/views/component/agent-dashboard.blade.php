<section class="content">

        @if(!Auth::user()->hasRole('SALEMAN'))
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
                <a href="{{TRANSACTION_URL_DDS_AC}}">
                <!-- Trans label pie charts strats here-->
                <div class="goldbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 text-right">
                                    <div class="number">Saving</div>
                                </div>
                                <i class="livicon  pull-right" data-name="piggybank" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
                <a href="{{TRANSACTION_URL_DDS_AC}}">
                <!-- Trans label pie charts strats here-->
                <div class="goldbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 text-right">
                                    <div class="number">Share</div>
                                </div>
                                <i class="livicon  pull-right" data-name="piggybank" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
                <a href="{{TRANSACTION_URL_DDS_AC}}">
                <!-- Trans label pie charts strats here-->
                <div class="goldbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 text-right">
                                    <div class="number">DDS</div>
                                </div>
                                <i class="livicon  pull-right" data-name="piggybank" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
                <a href="{{TRANSACTION_URL_DRD_AC}}">
                <!-- Trans label pie charts strats here-->
                <div class="lightbluebg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <div class="number">DRD</div>
                                </div>
                                <i class="livicon pull-right" data-name="refresh" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 margin_10 animated fadeInDownBig">
                <a href="{{TRANSACTION_URL_RD_AC}}">
                <!-- Trans label pie charts strats here-->
                <div class="palebluecolorbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <div class="number">RD</div>
                                </div>
                                <i class="livicon pull-right" data-name="link" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInRightBig">
                <a href="{{TRANSACTION_URL_FD_AC}}">
                <!-- Trans label pie charts strats here-->
                <div class="redbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <div class="number">FD</div>
                                </div>
                                <i class="livicon pull-right" data-name="money" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
                <a href="{{TRANSACTION_URL_MIS_AC}}">
                <!-- Trans label pie charts strats here-->
                <div class="lightbluebg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 text-right">
                                    <div class="number">MIS</div>
                                </div>
                                <i class="livicon  pull-right" data-name="calendar" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
                <a href="{{TRANSACTION_URL_LOAN_AC}}">
                <!-- Trans label pie charts strats here-->
                <div class="goldbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <div class="number">Loan</div>
                                </div>
                                <i class="livicon pull-right" data-name="timer" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 margin_10 animated fadeInDownBig">
                <a href="{{DAILY_REPORT_URL_DCR}}">
                <!-- Trans label pie charts strats here-->
                <div class="redbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <div class="number">Daily Collection</div>
                                </div>
                                <i class="livicon pull-right" data-name="printer" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInRightBig">
                <a href="{{DAILY_REPORT_URL_DAY_BOOK}}">
                <!-- Trans label pie charts strats here-->
                <div class="palebluecolorbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <div class="number">Day/Cash Book</div>
                                </div>
                                <i class="livicon pull-right" data-name="notebook" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>

        </div>
        @else
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-md-6 margin_10 animated fadeInDownBig">
                    <a href="{{DAILY_REPORT_URL_DCR}}">
                        <!-- Trans label pie charts strats here-->
                        <div class="redbg no-radius">
                            <div class="panel-body squarebox square_boxs">
                                <div class="col-xs-12 pull-left nopadmar">
                                    <div class="row">
                                        <div class="square_box col-xs-7 pull-left">
                                            <div class="number">Daily Collection</div>
                                        </div>
                                        <i class="livicon pull-right" data-name="printer" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
        <!--/row-->
    </section>