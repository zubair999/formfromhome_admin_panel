<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title><?= ucwords($page_title); ?></title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="<?php echo ADMIN ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo ADMIN ?>/dist/css/AdminLTE.min.css">
      <style media="screen">
         .login-page{
           background: url(<?php echo ADMIN ?>/dist/img/login/1.jpg);
           background-size: cover;
           display: flex;
         }
         @media(max-width:767px){
           .login-page{
              background: url(<?php echo ADMIN ?>/dist/img/login/8.jpg);
            }
         }
      </style>
   </head>
   <body class="hold-transition login-page">
      <div class="login-box">
         <div class="login-logo">
            <h1 style="color:#fff"><?= ucwords($page_title); ?></h1>
         </div>
         <div class="login-box-body">
              <?php
                if($this->session->flashdata('notification')){
                  ?>
                    <div style="text-align: center;padding: 5px 0;color:#fff;text-transform: capitalize; ">
                      <?php echo $this->session->flashdata('notification'); ?>
                    </div>
                  <?php
                }
              ?>
         </div>
      </div>
   </body>
</html>
