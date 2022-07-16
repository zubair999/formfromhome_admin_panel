
<section class="content">

      <!-- Info boxes -->





      <div class="row">


          <div class="col-md-12" style="height:0">
              <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu notificationMsg">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o" style="color:#fff"></i>
              <span class="label label-warning"><?= $form_pending; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?= $form_pending; ?> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="<?php echo base_url('product/lessQtyProduct');?>">
                      <i class="fa fa-product-hunt text-aqua"></i> <?= $form_pending; ?> unfullfilled application.
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
          </div>


          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-green bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">Form Filled</span>
                <span class="info-box-number"><?= $form_filled; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-green bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">Total Sales</br> </span>
                <span class="info-box-number"><?= $total_income->total_amount; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-green bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">Total Commission Earned</br> </span>
                <span class="info-box-number"><?= $commission->service_charge; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-green bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">Total Exam Fee Collected</br> </span>
                <span class="info-box-number"><?= $total_exam_fee->exam_fee; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>




          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-orange bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">New Application</span>
                <span class="info-box-number"><?= $unviewed; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-info bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">Active Exam</span>
                <span class="info-box-number"><?= $active_application; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-info bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">Expired Exam</span>
                <span class="info-box-number"><?= $expired_application; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-red bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">Email Pending</span>
                <span class="info-box-number"><?= $email_pending; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-md-4 col-sm-6 col-xs-12 moreHeight">
            <div class="info-box bg-red bg-red-shadow">
              <span class="info-box-icon bg-default"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-white">Form Pending </span>
                <span class="info-box-number"><?= $form_pending; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>





        <!-- /.col -->

      </div>

      <!-- /.row -->











        <!-- /.col -->

      </div>

      <!-- /.row -->








      <!-- /.row -->



      <!-- /.row -->

    <div></section>
