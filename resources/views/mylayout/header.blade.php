
    <header class="header">
        <a href="{{asset(HOME_LINK)}}" class="logo">
            <img src="{{ASSETS}}img/logo.png" alt="Logo">
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            @if(AuthRole()->name != 'SALEMAN')
            <div>
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <div class="responsive_nav"></div>
                </a>
            </div>
            @endif
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    @if(AuthRole()->name != 'SALEMAN')
                    <li class="notifications-menu">
                        <a href="#" data-toggle="modal" data-target="#cashInHand">
                            <span class="btn btn-warning">Cash in Hand: {{ ClosingCashInHand() }}</span>
                        </a>
                    </li>
                    {{--<li class="notifications-menu">
                        @if(!$CheckLock)
                        <a href="{{url('lock-today')}}" data-toggle="modal"
                           onclick="event.preventDefault();
                           if (confirm('Are you sure! you want to day closing?'))
                               {
                                   document.getElementById('lock-today').submit();
                               }">
                            <span class="btn btn-primary">Day Closing</span>
                        </a>
                        <form id="lock-today" action="{{ route('lock.today') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @else
                            <a href="#" data-toggle="modal">
                                <span class="btn btn-default">Day Closed</span>
                            </a>
                        @endif
                    </li>--}}
                    <li class="notifications-menu">
                        <a href="#" data-toggle="modal" data-target="#exampleModal">
                            <span class="btn btn-primary">Search Account</span>
                        </a>
                    </li>

                     <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="btn btn-primary">Transaction</span>
                        </a>
                        <ul class="notifications dropdown-menu">
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <i class="livicon danger" data-n="briefcase" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="{{ route('transaction.create.short.account') }}">Open A/c</a>
                                    </li>
                                    <li>
                                        <i class="livicon danger" data-n="briefcase" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="{{TRANSACTION_URL_SHARE_AC}}">Share</a>
                                    </li>
                                    <li>
                                        <i class="livicon success" data-n="piggybank" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="{{TRANSACTION_URL_SAVING_AC}}">Saving</a>
                                    </li>
                                    <li>
                                        <i class="livicon warning" data-n="money" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="{{TRANSACTION_URL_FD_AC}}">Fixed Deposit</a>
                                    </li>
                                    <li>
                                        <i class="livicon bg-aqua" data-n="piggybank" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="{{TRANSACTION_URL_DDS_AC}}">DDS</a>
                                    </li>
                                    <li>
                                        <i class="livicon danger" data-n="link" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="{{TRANSACTION_URL_RD_AC}}">RD <small><em>(Monthly)</em></small></a>
                                    </li>
                                    <li>
                                        <i class="livicon success" data-n="refresh" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="{{TRANSACTION_URL_DRD_AC}}">DRD <small><em>(Daily)</em></small></a>
                                    </li>
                                    <li>
                                        <i class="livicon warning" data-n="timer" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="{{TRANSACTION_URL_LOAN_AC}}">Loan</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif
                    
          <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="riot">
                                <div>
                                    {{Auth::user()->name}}
                                    <span>
                                        <i class="caret"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Body -->
                            <li class="user-header bg-light-blue">
                                <img src="{{PREFIX1.''.Auth::user()->file}}" width="90" class="img-circle img-responsive" height="90" alt="User Image" />
                                <p class="topprofiletext">{{Auth::user()->name}}</p>
                            </li>
                            <!-- Menu Body -->
                            <li>
                                <a href="{{USERS.'/profile/'.Auth::user()->id}}"> <i class="livicon" data-name="user" data-s="18"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="{{USERS.'/password/'.Auth::user()->id}}">
                                    <i class="livicon" data-name="key" data-s="18"></i> Change Password
                                </a>
                            </li>
                            <li role="presentation"></li>
                            <li>
                                <a href="{{url('logout')}}" 
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="livicon" data-name="sign-out" data-s="18"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>