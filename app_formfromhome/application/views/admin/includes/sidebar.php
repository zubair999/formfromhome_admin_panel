<ul class="sidebar-menu" data-widget="tree">
   <!-- <li class="header">MENU</li> -->

      <?php
            require_once "menu.php";
            $role_id = $this->session->userdata('role_id');
            $menuArr = $menuArr[$role_id - 1];

            $i = 0;
            foreach ($menuArr as $mainMenu => $subMenuOption) {
              ?>
                <li class="treeview">
                   <a href="javascript:void(0)">
                   <i class="fa <?php echo $menuIcon[$mainMenu]; ?>"></i> <span><?php echo ucwords($mainMenu); ?></span>
                   <span class="pull-right-container">
                   <i class="fa fa-angle-left pull-right"></i>
                   </span>
                   </a>

                   <ul class="treeview-menu">
              <?php

              foreach ($subMenuOption as $subMenu => $url) {
                if(is_array($url)){
                  ?>
                    <li class="treeview">
                        <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> <?php echo ucwords($subMenu); ?>
                  <?php
                }
                else{
                  ?>
                    <li>
                        <a href="<?php echo site_url($url);?>"><i class="fa fa-circle-o"></i> <?php echo ucwords($subMenu); ?>
                  <?php
                }
                      ?>

                         <?php
                             if(is_array($url)){
                                 ?>
                                 <span class="pull-right-container">
                                 <i class="fa fa-angle-left pull-right"></i>
                                 </span>
                                 <?php
                             }
                         ?>
                      </a>
                         <ul class="treeview-menu">
                                  <?php
                              if (is_array($url)) {
                                foreach ($url as $innerMenu => $url) {
                                  ?>
                                    <li><a href="<?php echo site_url($url);?>"><i class="fa fa-circle"></i><?php echo ucwords($innerMenu); ?></a></li>
                                  <?php
                                }
                              }
                            ?>
                        </ul>
                    </li>
                <?php
              } ?>
                </ul>
      </li>
      <?php $i++; }
    ?>
    </li>
    <!-- <li><a href="<?php echo site_url();?>login/logout">
    <i class="fa fa-unlock-alt"></i> <span>Logout</span></a></li> -->


</ul>
