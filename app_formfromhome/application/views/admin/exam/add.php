<div class="row">
   <div class="col-md-12">
      <div class="box box-info">
         <div class="box-header with-border">
            <h3 class="box-title"><?= ucwords($page_title); ?></h3>
         </div>
         <?php echo form_open('exam-add', array('method'=>'post')); ?>
         <div class="box-body">
            <div class="row clearfix">

               <div class="col-md-6">
                  <label for="name_of_post" class="control-label text-capitalize"><span class="text-danger">*</span>name of post</label>
                  <div class="form-group">
                     <input type="text" name="name_of_post" value="<?php echo $this->input->post('name_of_post'); ?>" class="form-control" id="name_of_post" />
                     <span class="text-danger text-capitalize"><?php echo form_error('name_of_post');?></span>
                  </div>
               </div>

               <div class="col-md-2">
                  <label>Post Date</label>
                  <div class="form-group">
                    <div class="input-group date">
                     <input  type="text" name="post_date" value="<?php echo $this->input->post('post_date'); ?>" class="form-control pull-right" placeholder="DD/MM/YYYY" id="post-date" />
                     <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                     </div>
                  </div>
                    <span class="text-danger text-capitalize"><?php echo form_error('post_date');?></span>
                  </div>
               </div>

               <div class="col-md-2 newSelectStyle">
                  <label for="state_name" class="control-label text-capitalize">select state</label>
                  <div class="form-group">
                    <select name="state_name" id="i1_m1K" class="form-control">
                      <option value="">Select State</option>
                      <?php
                       foreach($state_arr as $st)
                      {
                        echo '<option value="'.$st['state_id'].'">'.strtoupper($st['state_name']).'</option>';
                      }
                      //$i++;
                      ?>
                    </select>
                    <span class="text-danger" id="u6_ut0"><?php echo form_error('state_name');?></span>
                  </div>
                </div>


                 <div class="col-md-2">
                  <label>Last Day</label>
                  <div class="form-group">
                    <div class="input-group date">
                     <input  type="text" name="last_date" value="<?php echo $this->input->post('last_date'); ?>" class="form-control pull-right" placeholder="DD/MM/YYYY" id="last-date" />
                     <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                     </div>
                  </div>
                  </div>
                  <span class="text-danger text-capitalize"><?php echo form_error('last_date');?></span>
               </div>

               <div class="col-md-6">
                  <label for="short_info" class="control-label text-capitalize">Short Information</label>
                  <div class="form-group">
                     <textarea name="short_info" class="n2rgi" value="<?php echo $this->input->post('short_info'); ?>"></textarea>
                     <span class="text-danger"><?php echo form_error('short_info');?></span>
                  </div>
               </div>

               
               <div class="col-md-6">
                  <label for="short_info" class="control-label text-capitalize">Select Categories</label>
                  <div class="form-group">
                    <table class="table table-bordered ">
                      <thead>
                        <tr>
                          <th>Sr no.</th>
                          <th>Category</th>
                          <th>Select</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i =1;
                          foreach ($category_arr as $c) {
                            ?>
                              <tr>
                                <td><?=$i?></td>
                                <td><label for="<?= $c['category_idId']?>"><?= ucwords($c['category_name']);?></label></td>
                                <td>
                                  <input id="<?= $c['category_idId']?>" type="checkbox" value="<?= $c['category_idId']?>" data-cateid="<?= $c['category_idId']?>" data-catename="<?= ucwords($c['category_name']);?>" class="create_category" />
                                   <span class="text-danger"><?php echo form_error('category_id[]');?></span>
                                </td>
                              </tr>
                            <?php
                          $i++;
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
               </div>

               <div class="col-md-6">
                  <label for="short_info" class="control-label text-capitalize">Fees Structure</label>
                  <div class="form-group">
                    <table class="table table-bordered " id="category_fee_tbl">
                      <thead>
                        <tr>
                          <th>Category</th>
                          <th>Select</th>
                          <th>Fee</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
               </div>

               <div class="col-md-12">
                  <label for="content" class="control-label text-capitalize">Add Exam Detail</label>
                  <div class="form-group">
                     <textarea id="examFormContent" name="content" value="<?php echo $this->input->post('content'); ?>"></textarea>
                     <span class="text-danger"><?php echo form_error('content');?></span>
                  </div>
               </div>


            </div>


         </div>
         <div class="box-footer">
            <input type="submit" name="submit1" class="btn btn-success" value="Save">
            <!-- <i class="fa fa-check"></i> Save
            </button> -->
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>
