
<div class="container p-0">
  <?php echo form_open_multipart('edit-profile/'.$id, array('method'=>'post')); ?>
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
                    <input value="<?php echo ($this->input->post('student_name') ? $this->input->post('student_name') : $stu_data->student_name); ?>" type="text" name="student_name" class="form-control pull-right transform_01" />
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('student_name');?></span>
                 </div>
              </div>

              <div class="col-xs-12">
                 <label class="control-label text-capitalize transform_01">father name</label>
                 <div class="form-group">
                   <div class="input-group full_width" >
                    <input value="<?php echo ($this->input->post('father_name') ? $this->input->post('father_name') : $stu_data->father_name); ?>" type="text" name="father_name" class="form-control pull-right transform_01"   />
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('father_name');?></span>
                 </div>
              </div>
              <div class="col-xs-12">
                 <label class="control-label text-capitalize">mother name</label>
                 <div class="form-group">
                   <div class="input-group full_width" >
                    <input value="<?php echo ($this->input->post('mother_name') ? $this->input->post('mother_name') : $stu_data->mother_name); ?>"  type="text" name="mother_name" class="form-control pull-right transform_01" />
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('mother_name');?></span>
                 </div>
              </div>
              <!-- <div class="col-xs-12">
                 <label class="control-label text-capitalize">guardian name</label>
                 <div class="form-group">
                   <div class="input-group full_width">
                    <input  value="<?php echo ($this->input->post('guardian_name') ? $this->input->post('guardian_name') : $stu_data->guardian_name); ?>" type="text" name="guardian_name" class="form-control pull-right transform_01" />
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('guardian_name');?></span>
                 </div>
              </div> -->
              <div class="col-xs-12">
                 <label class="control-label text-capitalize">Phone No.</label>
                 <div class="form-group">
                   <div class="input-group date full_width">
                    <input value="<?php echo ($this->input->post('mobile') ? $this->input->post('mobile') : $stu_data->mobile); ?>" type="text" name="mobile" class="form-control pull-right transform_01"  />
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('mobile');?></span>
                 </div>
              </div>

               <div class="col-lg-12">
                  <label class="control-label text-capitalize">date of birth</label>
                  <div class="form-group">
                    <div class="input-group date full_width" data-provide="datepicker">
                      <input value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : $stu_data->dob); ?>" type="date" name="dob" value="<?php echo $stu_data->dob; ?>" class="form-control pull-right" placeholder="DD/MM/YYYY"  />
                    </div>
                    <span class="text-danger text-capitalize"><?php echo form_error('dob');?></span>
                  </div>
               </div>

                <div class="col-xs-12">
                  <label for="state_name" class="control-label text-capitalize">Gender</label>
                  <div class="form-group">
                    <select name="gender" class="form-control transform_01">
                      <option value="">Select Gender</option>

                      <?php
                        $gender_arr = array('0'=>array('gender_id'=>'m','gender'=>'male'),'1'=>array('gender_id'=>'f','gender'=>'female'));
                         foreach($gender_arr as $ga){
                             $selected = ($ga['gender_id'] == $stu_data->gender) ?  ' selected="selected" ' : "";
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
                     <select name="category_name" class="form-control transform_01 ">
                        <option value="">Select Categpry</option>
                        <?php
                           foreach($student_category as $sc){

                               $selected = ($sc['category_id'] == $stu_data->category_id) ?  ' selected="selected" ' : "";
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
                       <input  value="<?php echo ($this->input->post('house') ? $this->input->post('house') : $stu_data->house); ?>" type="text" name="house" class="form-control pull-right transform_01" />
                    </div>
                      <span class="text-danger text-capitalize"><?php echo form_error('house');?></span>
                    </div>
                 </div>

                 <div class="col-xs-12">
                    <label class="control-label text-capitalize">block/post</label>
                    <div class="form-group">
                      <div class="input-group date full_width">
                       <input value="<?php echo ($this->input->post('block') ? $this->input->post('block') : $stu_data->block); ?>" type="text" name="block" class="form-control pull-right transform_01" />
                    </div>
                      <span class="text-danger text-capitalize"><?php echo form_error('block');?></span>
                    </div>
                 </div>

                 <div class="col-xs-12">
                    <label class="control-label text-capitalize">district</label>
                    <div class="form-group">
                      <div class="input-group date full_width">
                       <input value="<?php echo ($this->input->post('district') ? $this->input->post('district') : $stu_data->district); ?>" type="text" name="district" class="form-control pull-right transform_01" />
                    </div>
                      <span class="text-danger text-capitalize"><?php echo form_error('district');?></span>
                    </div>
                 </div>

                 <div class="col-xs-12">
                   <label for="state_id" class="control-label text-capitalize">state</label>
                   <div class="form-group">
                     <select name="state" class="form-control transform_01">
                        <!-- <option value="">Select state</option> -->
                         <?php
                            foreach($state as $s){
                                $selected = ($s['state_id'] == $stu_data->state_id) ?  ' selected="selected" ' : "";
                                echo '<option value="'.$s['state_id'].'"  '.$selected.'>'.ucwords($s['state_name']).'</option>';
                            }
                         ?>
                     </select>
                     <span class="text-danger"><?php echo form_error('state');?></span>
                   </div>
                 </div>

                 <div class="col-xs-12">
                    <label class="control-label text-capitalize">pincode</label>
                    <div class="form-group">
                      <div class="input-group date full_width">
                       <input value="<?php echo ($this->input->post('pincode') ? $this->input->post('pincode') : $stu_data->pincode); ?>" type="text" name="pincode" class="form-control pull-right transform_01" />
                    </div>
                      <span class="text-danger text-capitalize"><?php echo form_error('pincode');?></span>
                    </div>
                 </div>


               <div class="col-xs-12">
                  <label class="control-label text-capitalize">full address</label>
                  <div class="form-group">
                    <div class="input-group date full_width">
                     <input value="<?php echo ($this->input->post('address') ? $this->input->post('address') : $stu_data->address); ?>"  type="text" name="address" class="form-control pull-right transform_01"/>
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
                  <div class="form-group text-danger">
                    <img src="<?= base_url('uploads/student/'.$stu_data->student_img); ?>" style="width:100px;height:100px;">
                  </div>
               </div>

               <div class="col-xs-12">
                  <label for="exampleInputFile" class="control-label text-capitalize"><span class="text-danger">* </span>student photo</label>
                  <div class="form-group">
                     <input type="file" name="student_img" id="student_photo" required />
                     <span class="text-danger text-capitalize"><?php echo form_error('student_img');?></span>
                  </div>
               </div>


               <div class="col-xs-12">
                  <div class="form-group text-danger">
                    <img src="<?= base_url('uploads/student/'.$stu_data->signature_img); ?>" style="width:100px;height:100px;">
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
                  <div class="form-group text-danger">
                    <img src="<?= base_url('uploads/student/'.$stu_data->thumb_img); ?>" style="width:100px;height:100px;">
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
    <div class="col-xs-6">
      <a class="btn btn-primary" href="<?php echo base_url('student-profile'); ?>">Back</a>
    </div>
    <div class="col-xs-6">
       <input type="submit" name="edit1" class="btn btn-success" value="Update Details">
    </div>
  </div>

<?php echo form_close(); ?>
</div>
