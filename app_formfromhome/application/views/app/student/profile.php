<?php
  if($info_count>0){
      ?>
      <div class="container p-0">
      <div class="row mt">
         <div class="col-md-12 p-0">
            <div class="box box-info p-tb-5">
               <div class="box-header with-border">
                  <h5 class="box-title text-center b_ty8o"><?= ucwords($page_title); ?></h5>
               </div>


               <div class="box-body">
                  <div class="row clearfix">

                    <div class="col-xs-12">
                       <div class="form-group">
                         <div class="input-group full_width" >
                          <h5>Profile already set.</h5>
                       </div>
                         <span class="text-danger text-capitalize"><?php echo form_error('student_name');?></span>
                       </div>
                    </div>

                    <div class="col-xs-12">
                       <div class="form-group">
                         <div class="input-group full_width" >
                          <a href="<?php echo base_url('edit-profile/'.$stu_info_id) ?>" class="btn btn-primary">Edit Details</a>
                       </div>
                         <span class="text-danger text-capitalize"><?php echo form_error('student_name');?></span>
                       </div>
                    </div>

                  </div>
                </div>


            </div>
         </div>
      </div>
      </div>
      <?php
  }
  else{
    ?>
    <div class="container p-0">
      <?php echo form_open_multipart('student-profile', array('method'=>'post')); ?>
    <div class="row mt">
       <div class="col-md-12 p-0">
          <div class="box box-info p-tb-5">
             <div class="box-header with-border">
                <h5 class="box-title text-center b_ty8o"><?= ucwords($page_title); ?></h5>
             </div>


             <div class="box-body">
               <h6 class="text-center"><u>Personal Detail</u></h6>
                <div class="row clearfix">
                  <div class="col-xs-12">
                     <label class="control-label text-capitalize">student name</label>
                     <div class="form-group">
                       <div class="input-group full_width" >
                        <input  type="text" name="student_name" value="<?php echo $this->input->post('student_name'); ?>" class="form-control pull-right transform_01"  required/>
                     </div>
                       <span class="text-danger text-capitalize"><?php echo form_error('student_name');?></span>
                     </div>
                  </div>

                  <div class="col-xs-12">
                     <label class="control-label text-capitalize">father name</label>
                     <div class="form-group">
                       <div class="input-group full_width" >
                        <input  type="text" name="father_name" value="<?php echo $this->input->post('father_name'); ?>" class="form-control pull-right transform_01" required/>
                     </div>
                       <span class="text-danger text-capitalize"><?php echo form_error('father_name');?></span>
                     </div>
                  </div>
                  <div class="col-xs-12">
                     <label class="control-label text-capitalize">mother name</label>
                     <div class="form-group">
                       <div class="input-group full_width">
                        <input  type="text" name="mother_name" value="<?php echo $this->input->post('mother_name'); ?>" class="form-control pull-right transform_01" required />
                     </div>
                       <span class="text-danger text-capitalize"><?php echo form_error('mother_name');?></span>
                     </div>
                  </div>

                  <!-- <div class="col-xs-12">
                     <label class="control-label text-capitalize">guardian name</label>
                     <div class="form-group">
                       <div class="input-group full_width">
                        <input  type="text" name="guardian_name" value="<?php echo $this->input->post('guardian_name'); ?>" class="form-control pull-right transform_01"  required/>
                     </div>
                       <span class="text-danger text-capitalize"><?php echo form_error('guardian_name');?></span>
                     </div>
                  </div> -->


                  <div class="col-xs-12">
                     <label class="control-label text-capitalize">Phone No.</label>
                     <div class="form-group">
                       <div class="input-group full_width">
                        <input  type="text" name="mobile" value="<?php echo $this->input->post('mobile'); ?>" class="form-control pull-right transform_01" required />
                     </div>
                       <span class="text-danger text-capitalize"><?php echo form_error('mobile');?></span>
                     </div>
                  </div>

                   <div class="col-lg-12">
                      <label class="control-label text-capitalize">date of birth</label>
                      <div class="form-group">
                        <div class="input-group full_width">
                          <input  type="date" name="dob" value="<?php echo $this->input->post('dob'); ?>" class="form-control pull-right transform_01" placeholder="DD/MM/YYYY" required />
                        </div>
                        <span class="text-danger text-capitalize"><?php echo form_error('dob');?></span>
                      </div>
                   </div>

                    <div class="col-xs-12">
                      <label for="state_name" class="control-label text-capitalize">Gender</label>
                      <div class="form-group">
                        <select name="gender" class="form-control" required>
                          <option value="">Select Gender</option>
                          <?php
                            $gender_arr = array('0'=>array('gender_id'=>'m','gender'=>'male'),'1'=>array('gender_id'=>'f','gender'=>'female'));
                             foreach($gender_arr as $ga){
                                 $selected = ($ga['gender_id'] == $this->input->post('gender')) ?  ' selected="selected" ' : "";
                                 echo '<option value="'.$ga['gender_id'].'"  '.$selected.'>'.ucwords($ga['gender']).'</option>';
                             }
                          ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('gender');?></span>
                      </div>
                    </div>

                     <div class="col-xs-12">
                       <label for="category_name" class="control-label text-capitalize">Category</label>
                       <div class="form-group">
                         <select name="category_name" class="form-control" required>
                            <option value="">Select Categpry</option>
                            <?php
                              foreach($student_category as $sc){
                                  $selected = ($sc['category_id'] == $this->input->post('category_name')) ?  ' selected="selected" ' : "";
                                  echo '<option value="'.$sc['category_id'].'"  '.$selected.'>'.ucwords($sc['category_name']).'</option>';
                              }
                           ?>
                         </select>
                         <span class="text-danger"><?php echo form_error('category_name');?></span>
                       </div>
                     </div>

                     <div class="col-xs-12">
                        <label class="control-label text-capitalize">village/house no</label>
                        <div class="form-group">
                          <div class="input-group date full_width">
                           <input  type="text" name="house" value="<?php echo $this->input->post('house'); ?>" class="form-control pull-right transform_01" required />
                        </div>
                          <span class="text-danger text-capitalize"><?php echo form_error('house');?></span>
                        </div>
                     </div>

                     <div class="col-xs-12">
                        <label class="control-label text-capitalize">block/post</label>
                        <div class="form-group">
                          <div class="input-group date full_width">
                           <input  type="text" name="block" value="<?php echo $this->input->post('block'); ?>" class="form-control pull-right transform_01"  required/>
                        </div>
                          <span class="text-danger text-capitalize"><?php echo form_error('block');?></span>
                        </div>
                     </div>

                     <div class="col-xs-12">
                       <label for="state_id" class="control-label text-capitalize">state</label>
                       <div class="form-group">
                         <select name="state" class="form-control" required>
                            <option value="">Select state</option>
                             <?php
                               foreach($state as $s){
                                   $selected = ($s['state_id'] == $this->input->post('state')) ?  ' selected="selected" ' : "";
                                   echo '<option value="'.$s['state_id'].'"  '.$selected.'>'.ucwords($s['state_name']).'</option>';
                               }
                            ?>
                         </select>
                         <span class="text-danger"><?php echo form_error('state');?></span>
                       </div>
                     </div>

                     <div class="col-xs-12">
                        <label class="control-label text-capitalize">district</label>
                        <div class="form-group">
                          <div class="input-group date full_width">
                           <input  type="text" name="district" value="<?php echo $this->input->post('district'); ?>" class="form-control pull-right transform_01"  required/>
                        </div>
                          <span class="text-danger text-capitalize"><?php echo form_error('district');?></span>
                        </div>
                     </div>



                     <div class="col-xs-12">
                        <label class="control-label text-capitalize">pincode</label>
                        <div class="form-group">
                          <div class="input-group date full_width">
                           <input  type="text" name="pincode" value="<?php echo $this->input->post('pincode'); ?>" class="form-control pull-right transform_01" required />
                        </div>
                          <span class="text-danger text-capitalize"><?php echo form_error('pincode');?></span>
                        </div>
                     </div>

                   <div class="col-xs-12">
                      <label class="control-label text-capitalize">full address</label>
                      <div class="form-group">
                        <div class="input-group date full_width">
                         <input  type="text" name="address" value="<?php echo $this->input->post('address'); ?>" class="form-control pull-right transform_01"  />
                      </div>
                        <span class="text-danger text-capitalize"><?php echo form_error('address');?></span>
                      </div>
                   </div>

                   <div class="col-xs-12">
                      <h4>Note:</h4>
                      <div class="form-group text-danger">
                        <p>Image Format: JPG|JPEG|PNG</p>
                        <p>Max Size: 10MB</p>
                      </div>
                   </div>

                   <div class="col-xs-12">
                      <label for="exampleInputFile" class="control-label text-capitalize"><span class="text-danger">* </span>student photo</label>
                      <div class="form-group">
                         <input type="file" name="student_img" required/>
                         <span class="text-danger text-capitalize"><?php echo form_error('student_img');?></span>
                      </div>
                   </div>

                   <div class="col-xs-12">
                      <label for="student_sign" class="control-label text-capitalize"><span class="text-danger">* </span>signature photo</label>
                      <div class="form-group">
                         <input type="file" name="student_sign" id="student_sign" required/>
                         <span class="text-danger text-capitalize"><?php echo form_error('student_sign');?></span>
                      </div>
                   </div>


                    <div class="col-xs-12">
                       <label for="thumb_img" class="control-label text-capitalize"><span class="text-danger">* </span>thumb impression</label>
                       <div class="form-group">
                          <input type="file" name="thumb_img" id="thumb_img" required/>
                          <span class="text-danger text-capitalize"><?php echo form_error('thumb_img');?></span>
                       </div>
                    </div>

                </div>
              </div>


          </div>
       </div>
    </div>


    <div class="row mb">
      <div class="box-footer">
         <input type="submit" name="submit1" class="btn btn-success" value="Save Details">
         <!-- <i class="fa fa-check"></i> Save
         </button> -->
      </div>
    </div>

    <?php echo form_close(); ?>
    </div>

    <?php
  }

?>
