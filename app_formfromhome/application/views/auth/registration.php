<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title><?= ucwords($page_title); ?></title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="<?php echo ADMIN ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo ADMIN ?>/bower_components/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="<?php echo ADMIN ?>/bower_components/Ionicons/css/ionicons.min.css">
      <link rel="stylesheet" href="<?php echo ADMIN ?>/dist/css/AdminLTE.min.css">
      <link rel="stylesheet" href="<?php echo ADMIN ?>/plugins/iCheck/square/blue.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
            <h1 style="color:#fff">Admin Registration</h1>
         </div>
          <?php echo form_open('reg-secure') ?>
         <div class="login-box-body">
              <?php
                if($this->session->flashdata('notification')){
                  ?>
                    <div style="text-align: center;padding: 5px 0;color:#fff;text-transform: capitalize;">
                      <?php echo $this->session->flashdata('notification'); ?>
                    </div>
                  <?php
                }
              ?>
            <div class="form-group has-feedback">
               <input
                    type="email"
                    name="loginid"
                    value="<?php echo $this->input->post('loginid'); ?>"
                    class="form-control"
                    id="loginid"
                    placeholder="Email"

                    />
               <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
               <div class="text-danger"><?= form_error('loginid'); ?></div>
            </div>
            <div class="form-group has-feedback">
               <input
                    type="password"
                    name="pwd"
                    value="<?php echo $this->input->post('pwd'); ?>"
                    class="form-control"
                    id="pwd"
                    placeholder="Password"

                    />
               <span class="glyphicon glyphicon-lock form-control-feedback"></span>
               <div class="text-danger"><?= form_error('pwd'); ?></div>
            </div>
            <div class="row">
               <div class="col-xs-8">
               </div>
               <div class="col-xs-4">
                  <button id="ao_9i" class="btn btn-primary btn-block btn-flat">Register</button>
               </div>
            </div>
         </div>
         <?php echo form_close(); ?>
      </div>
      <script src="<?php echo ADMIN ?>/bower_components/jquery/dist/jquery.min.js"></script>
      <script src="<?php echo ADMIN ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="<?php echo ADMIN ?>/plugins/iCheck/icheck.min.js"></script>
      <!-- <script>
        $(document).ready(function(){
          $('#ao_9i').on('click', function(e){
            e.preventDefault();
            var datastring = $("#regForm").serialize();
            $.ajax({
              url:location.origin + '/revo_projects/formfromhome/auth/auth/register_admin',
              method:'post',
              dataType:'json',
              data:datastring,
              success:function(response){
                if(response.status == 422){
                  if(response.message[0].error === 1001){
                    console.log(response.message[0].message);
                  }
                  if(response.message[1].error === 1002){
                    console.log(response.message[1].message);
                  }
                }
              },
              error:function(response){
                console.log(response);
                console.log("error");
              }
            });

            return false;
          });
        });
      </script> -->
   </body>
</html>
