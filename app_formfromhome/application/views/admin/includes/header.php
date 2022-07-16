    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Form From Home </title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <!-- Bootstrap 3.3.6 -->

            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/font-awesome/css/font-awesome.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/Ionicons/css/ionicons.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/fullcalendar/dist/fullcalendar.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>plugins/iCheck/all.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>plugins/timepicker/bootstrap-timepicker.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/select2/dist/css/select2.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/jvectormap/jquery-jvectormap.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>dist/css/AdminLTE.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>dist/css/skins/_all-skins.min.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>bower_components/morris.js/morris.css">
            <!-- <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
            <link rel="stylesheet" href="<?php echo ADMIN ?>plugins/yearpicker/yearpicker.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>dist/css/style.css">
            <link rel="stylesheet" href="<?php echo ADMIN ?>dist/css/customMaterialCss.css">
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <!--  Data table files-->
            <script src="<?php echo ADMIN ?>bower_components/jquery/dist/jquery.min.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script src="<?php echo ADMIN ?>bower_components/PACE/pace.min.js"></script>

            <script src="<?php echo ADMIN ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo ADMIN ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />

            <style media="screen">
            .dashboardLogo {
              	background: url(https://formfromhome.com/resources/admin/dist/img/logo/1.png);
              	background-repeat: no-repeat;
              	background-position: center;
              	background-size: 325px;
              	background-position-y: 0px;
              }
              
              .content{
                opacity: .85;
              }
            </style>
    </head>


        <body class="hold-transition skin-blue sidebar-mini">
            <div id="appRoot">
                
            </div>
            <div id="gifLoader" class="gifLoader" style="display:none">
                <img src="<?php echo ADMIN ?>dist/img/loader/4.gif">
                <h4 style="color:#fff">Processing..., Please Wait.</h4>
            </div>
    
            <?php
               if($this->session->flashdata('notification')){
                   ?>
                        <div class="warningMsg">
                            <p><?php echo ucwords($this->session->flashdata('notification')); ?></p>
                        </div>
                   <?php
               }
            ?>
    <!-- Site wrapper -->
    <div class="wrapper" style="height: 1300px;">
        <header class="main-header">
            <!-- Logo -->
            <a href="javascript:void(0)" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>V</b>P</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?php echo ucwords($this->name); ?></b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">



                    <!-- MR NOTIFICATION -->

                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>

                        </a>
                        <ul class="dropdown-menu">


                        </ul>
                    </li>








                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding:12px 15px 7px 15px;">
                    <!-- <img src="" class="user-image" alt="User Image"> -->
                    <span class="">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    	 width="25px" height="25px" fill="#fff" viewBox="0 0 631.742 631.742" style="enable-background:new 0 0 631.742 631.742;"
    	 xml:space="preserve">
                            <g>
                            	<g id="Off">
                            		<g>
                            			<path d="M489.738,74.368c-5.034-3.495-10.779-5.192-16.484-5.251c-9.516-0.119-18.913,4.343-24.717,12.733
                            				c-9.318,13.464-5.962,31.903,7.482,41.221c66.767,46.236,106.626,122.005,106.626,202.671
                            				c0,136.081-110.693,246.774-246.774,246.774S69.097,461.823,69.097,325.742c0-80.666,39.859-156.435,106.626-202.69
                            				c13.464-9.299,16.8-27.757,7.482-41.221c-5.922-8.548-15.557-13.01-25.25-12.694c-5.528,0.158-11.076,1.856-15.952,5.232
                            				C59.266,131.679,9.871,225.65,9.871,325.742c0,168.734,137.266,306,306,306s306-137.266,306-306
                            				C621.871,225.65,572.477,131.679,489.738,74.368z M315.871,236.903c16.366,0,29.613-13.267,29.613-29.613V29.613
                            				C345.484,13.267,332.237,0,315.871,0s-29.613,13.267-29.613,29.613v177.677C286.258,223.637,299.505,236.903,315.871,236.903z"/>
                            		</g>
                            	</g>
                            </g>
                        </svg>
                    </span>
                    </a>
                    <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">


                        <p>

                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!-- <li class="user-body">
                        <div class="row">
                        <div class="col-xs-4 text-center">
                            <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                        </div>
                    </li> -->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                                                    <a href="<?php echo base_url('profile/view');?>" class="btn btn-default btn-flat">Profile</a>


                        </div>
                        <div class="pull-right">
                        <a href="<?php echo base_url('auth-logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
                </ul>
            </div>
            </nav>
        </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

        <?php include('sidebar.php'); ?>
        </section>
        <!-- /.sidebar -->
    </aside>



        <div class="content-wrapper dashboardLogo" >



                    <!-- Main content -->
                    <section class="content p-lr-0" id="allContentWrapper">
