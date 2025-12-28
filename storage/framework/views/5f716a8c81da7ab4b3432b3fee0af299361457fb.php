<!DOCTYPE html>
<html>

<head>
    <title>Login | Cyrus Banking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link href="<?php echo e(ASSETS_CSS); ?>bootstrap.min.css" rel="stylesheet" />
    <!-- end of global level css -->
    <link href="<?php echo e(ASSETS_VENDORS); ?>iCheck/css/square/blue.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(ASSETS_VENDORS); ?>bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" />
    <!-- page level css -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(ASSETS_CSS); ?>pages/login.css" />
    <!-- end of page level css -->
</head>

<body>
    <div class="container">
        <div class="row vertical-offset-100">
            <div class="col-sm-6 col-sm-offset-3  col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <div id="container_demo">
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <a class="hiddenanchor" id="toforgot"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                                <h3 class="primary_bg">
                                    <img src="<?php echo e(ASSETS); ?>/img/login-logo.png" alt="Sonanshulnidhi" width="50%">
                                </h3>
                                <h5 class="text-center">
                                    <?php echo e($companyDetail->name ?? ''); ?>

                                </h5>

















                                <div class="form-group ">
                                    <label style="margin-bottom:0;" for="email1" class="uname control-label"> <i class="livicon" data-name="calendar" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i> Date
                                    </label>
                                   <input type="date" placeholder="Date" name="dt" required value="<?php echo e(date('Y-m-d')); ?>" autofocus>
                                    <div class="col-sm-12">
                                        <?php if ($errors->has('dt')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('dt'); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label style="margin-bottom:0;" for="email1" class="uname control-label"> <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i> E-mail
                                    </label>
                                   <input id="email" type="email" placeholder="E-mail" name="email" required autocomplete="email" autofocus>
                                    <div class="col-sm-12">
                                        <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label style="margin-bottom:0;" for="password" class="youpasswd"> <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i> Password
                                    </label>
                                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter a password">
                                    <div class="col-sm-12">
                                        <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember" class="square-blue" <?php echo e(old('remember') ? 'checked' : ''); ?> /> Keep me logged in
                                    </label>
                                </div>
                                <p class="login button">
                                    <input type="submit" value="Log In" class="btn btn-success" />
                                </p>
                                <p class="change_link">
                                    <a href="#toforgot" class="btn btn-responsive botton-alignment btn-warning btn-sm">Forgot password
                                    </a>
                                </p>
                            </form>
                        </div>
                        <div id="forgot" class="animate form">
                            <form action="<?php echo e(route('password.request')); ?>" id="reset_pw" autocomplete="on" method="post">
                                <h3 class="black_bg">
                                    <img src="<?php echo e(ASSETS); ?>/img/login-logo.png" alt="Sonanshulnidhi">
                                </h3>
                                <p>
                                    Enter your email address below and we'll send a special reset password link to your inbox.
                                </p>
                                <div class="form-group">
                                    <label style="margin-bottom:0;" for="username2" class="youmai">
                                        <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i> Your email
                                    </label>
                                    <input id="username2" name="username2" placeholder="your@mail.com" />
                                </div>
                                <p class="login button reset_button">
                                    <input type="submit" value="Reset Password" class="btn btn-raised btn-success btn-block" />
                                </p>
                                <p class="change_link">
                                    <a href="#tologin" class="btn btn-raised btn-responsive botton-alignment btn-warning btn-sm to_register">Back
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script src="<?php echo e(ASSETS_JS); ?>app.js" type="text/javascript"></script>
    <!-- end of global js -->
    <script src="<?php echo e(ASSETS_VENDORS); ?>bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script src="<?php echo e(ASSETS_VENDORS); ?>iCheck/js/icheck.js" type="text/javascript"></script>
    <script src="<?php echo e(ASSETS_JS); ?>pages/login.js" type="text/javascript"></script>
</body>

</html>
<?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casbatran/resources/views/auth/login.blade.php ENDPATH**/ ?>