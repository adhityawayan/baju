<!DOCTYPE html>

<!-- 

Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6

Version: 4.6

Author: KeenThemes

Website: http://www.keenthemes.com/

Contact: support@keenthemes.com

Follow: www.twitter.com/keenthemes

Dribbble: www.dribbble.com/keenthemes

Like: www.facebook.com/keenthemes

Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes

Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes

License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->

<!--[if !IE]><!-->

<html lang="en">

<!--<![endif]-->

<!-- BEGIN HEAD -->



<head>

    <meta charset="utf-8" />

    <title>Login | Master</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <meta content="" name="description" />

    <meta content="" name="author" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" /> -->

    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->

    <link href="<?php echo base_url(); ?>assets/pinky/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/pinky/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->

    <link href="<?php echo base_url(); ?>assets/pinky/pages/css/login-3.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/pinky/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />

    <!-- END PAGE LEVEL STYLES -->

    <!-- BEGIN THEME LAYOUT STYLES -->

    <!-- END THEME LAYOUT STYLES -->

    <link rel="shortcut icon" href="favicon.ico" /> </head>

<!-- END HEAD -->



<body class=" login">

<!-- BEGIN LOGO -->

<div class="logo">

</div>

<!-- END LOGO -->

<!-- BEGIN LOGIN -->

<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?=$this->session->flashdata('pesan')?>
    <form class="login-form" action="<?php echo base_url(); ?>auth/do_login" method="post">

        <!-- BEGIN LOGO -->

        <div class="logo" style="margin: 0px auto 15px;">

            <img src="<?php echo base_url(); ?>assets/pinky/pages/img/logo-big.png" alt="" />

        </div>

        <!-- END LOGO -->
        


        <div class="form-group">

            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

            <label class="control-label visible-ie8 visible-ie9">Username</label>

            <div class="input-icon">

                <i class="fa fa-user"></i>

                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>

        </div>

        <div class="form-group">

            <label class="control-label visible-ie8 visible-ie9">Password</label>

            <div class="input-icon">

                <i class="fa fa-lock"></i>

                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>

        </div>

        <div class="form-actions">

            <label class="rememberme mt-checkbox mt-checkbox-outline">

            </label>

            <button type="submit" class="btn default pull-right"> Login </button>

        </div>

    </form>

</div>

<!-- END LOGIN -->

<!--[if lt IE 9]>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/respond.min.js"></script>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/excanvas.min.js"></script>

<![endif]-->

<!-- BEGIN CORE PLUGINS -->

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/jquery.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/js.cookie.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pinky/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->

<script src="<?php echo base_url(); ?>assets/pinky/global/scripts/app.min.js" type="text/javascript"></script>

<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo base_url(); ?>assets/pinky/pages/scripts/login.min.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->

<!-- END THEME LAYOUT SCRIPTS -->

</body>



</html>