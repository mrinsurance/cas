
    <header class="header">
        <a href="<?php echo e(asset(HOME_LINK)); ?>" class="logo">
            <img src="<?php echo e(ASSETS); ?>img/logo.png" alt="Logo">
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <?php if(AuthRole()->name != 'SALEMAN'): ?>
            <div>
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <div class="responsive_nav"></div>
                </a>
            </div>
            <?php endif; ?>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <?php if(AuthRole()->name != 'SALEMAN'): ?>
                    <li class="notifications-menu">
                        <a href="#" data-toggle="modal" data-target="#cashInHand">
                            <span class="btn btn-warning">Cash in Hand: <?php echo e(ClosingCashInHand()); ?></span>
                        </a>
                    </li>
                    
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
                                        <a href="<?php echo e(route('transaction.create.short.account')); ?>">Open A/c</a>
                                    </li>
                                    <li>
                                        <i class="livicon danger" data-n="briefcase" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="<?php echo e(TRANSACTION_URL_SHARE_AC); ?>">Share</a>
                                    </li>
                                    <li>
                                        <i class="livicon success" data-n="piggybank" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="<?php echo e(TRANSACTION_URL_SAVING_AC); ?>">Saving</a>
                                    </li>
                                    <li>
                                        <i class="livicon warning" data-n="money" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="<?php echo e(TRANSACTION_URL_FD_AC); ?>">Fixed Deposit</a>
                                    </li>
                                    <li>
                                        <i class="livicon bg-aqua" data-n="piggybank" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="<?php echo e(TRANSACTION_URL_DDS_AC); ?>">DDS</a>
                                    </li>
                                    <li>
                                        <i class="livicon danger" data-n="link" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="<?php echo e(TRANSACTION_URL_RD_AC); ?>">RD <small><em>(Monthly)</em></small></a>
                                    </li>
                                    <li>
                                        <i class="livicon success" data-n="refresh" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="<?php echo e(TRANSACTION_URL_DRD_AC); ?>">DRD <small><em>(Daily)</em></small></a>
                                    </li>
                                    <li>
                                        <i class="livicon warning" data-n="timer" data-s="20" data-c="white" data-hc="white"></i>
                                        <a href="<?php echo e(TRANSACTION_URL_LOAN_AC); ?>">Loan</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    
          <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="riot">
                                <div>
                                    <?php echo e(Auth::user()->name); ?>

                                    <span>
                                        <i class="caret"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Body -->
                            <li class="user-header bg-light-blue">
                                <img src="<?php echo e(PREFIX1.''.Auth::user()->file); ?>" width="90" class="img-circle img-responsive" height="90" alt="User Image" />
                                <p class="topprofiletext"><?php echo e(Auth::user()->name); ?></p>
                            </li>
                            <!-- Menu Body -->
                            <li>
                                <a href="<?php echo e(USERS.'/profile/'.Auth::user()->id); ?>"> <i class="livicon" data-name="user" data-s="18"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="<?php echo e(USERS.'/password/'.Auth::user()->id); ?>">
                                    <i class="livicon" data-name="key" data-s="18"></i> Change Password
                                </a>
                            </li>
                            <li role="presentation"></li>
                            <li>
                                <a href="<?php echo e(url('logout')); ?>" 
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="livicon" data-name="sign-out" data-s="18"></i> Logout
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header><?php /**PATH /home/l0t4shykdrn8/public_html/casbara.himachalsociety.com/resources/views/mylayout/header.blade.php ENDPATH**/ ?>