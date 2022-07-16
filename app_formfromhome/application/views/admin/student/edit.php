<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <form action="<?php echo base_url('edit-student/'.$id); ?>" method="post" enctype="multipart/form-data">
      <div class="box-body">
      <div class="container" style="width:50%;">
        <div class="row clearfix">
          <div class="col-lg-12 col-md-12">
         <!-- Custom Tabs -->
         <div class="nav-tabs-custom">
           <ul class="nav nav-tabs">
             <li class="active"><a href="#basic" data-toggle="tab" aria-expanded="true">Basic Details</a></li>
           </ul>
           <div class="tab-content" style="padding: 0; margin-top: 16px;">
             <div class="tab-pane active" id="basic">
               
               <div class="row">
                <div class="col-md-12">
                   <p>Image Format: JPG|JPEG|PNG</p>
                    <p>Max Size: 10MB</p>
                 </div>
                      <div class="tab-pane">
                       <div class="col-md-4 ">
                         <div class="form-group">
                          <img src="<?= base_url('uploads/student/'.$stu_data->student_img); ?>" style="width:100%;height:150px;">
                          <div class="form-group">
                             <label for="student_img" class="control-label text-capitalize changeImg imgDel">Change photo</label>         
                          </div>               
                         </div>
                       </div>
                     </div>


                      <div class="tab-pane">
                       <div class="col-md-4">
                         <div class="form-group">
                         <img src="<?= base_url('uploads/student/'.$stu_data->signature_img); ?>" style="width:100%;height:150px;"> 
                         <div class="form-group">
                           <label for="student_sign" class="control-label text-capitalize changeImg imgDel">Change sign</label>
                           <span class="text-danger text-capitalize"><?php echo form_error('student_sign');?></span>                     
                         </div>              
                         </div>
                       </div>
                     </div>

                


                      <div class="tab-pane">
                       <div class="col-md-4">
                         <div class="form-group">
                         <img src="<?= base_url('uploads/student/'.$stu_data->thumb_img); ?>" style="width:100%;height:150px;">
                         <div class="form-group">
                            <label for="thumb_img" class="control-label text-capitalize changeImg imgDel">Change thumb</label>
                            <span class="text-danger text-capitalize"><?php echo form_error('thumb_img');?></span>                     
                         </div>              
                         </div>
                       </div>
                     </div>

                
               </div>

               
               <div class="col-md-12">
                 <label for="student_name" class="control-label text-capitalize"><span class="text-danger">*</span>student name</label>
                 <div class="form-group">
                    <input type="text" name="student_name" value="<?php echo ($this->input->post('student_name') ? $this->input->post('student_name') : $stu_data->student_name); ?>" class="form-control" id="student_name" autofocus />
                    <span class="text-danger"><?php echo form_error('student_name');?></span>
                 </div>
               </div>

               <div class="col-md-12">
                 <label for="user_name" class="control-label text-capitalize"><span class="text-danger">*</span>email</label>
                 <div class="form-group">
                    <input type="email" name="user_name" value="<?php echo ($this->input->post('user_name') ? $this->input->post('user_name') : $user_data->user_name); ?>" class="form-control" id="user_name" />
                    <span class="text-danger"><?php echo form_error('user_name');?></span>
                 </div>
               </div>

               <div class="col-md-12">
                 <label for="father_name" class="control-label text-capitalize"><span class="text-danger">*</span>father name</label>
                 <div class="form-group">
                    <input type="text" name="father_name" value="<?php echo ($this->input->post('father_name') ? $this->input->post('father_name') : $stu_data->father_name); ?>" class="form-control" id="father_name"/>
                    <span class="text-danger"><?php echo form_error('father_name');?></span>
                 </div>
               </div>
               <div class="col-md-12">
                 <label for="mother_name" class="control-label text-capitalize"><span class="text-danger">*</span>mother name</label>
                 <div class="form-group">
                    <input type="text" name="mother_name" value="<?php echo ($this->input->post('mother_name') ? $this->input->post('mother_name') : $stu_data->mother_name); ?>" class="form-control" id="mother_name" />
                    <span class="text-danger"><?php echo form_error('mother_name');?></span>
                 </div>
               </div>
               <div class="col-md-12">
                 <label for="mobile" class="control-label text-capitalize"><span class="text-danger">*</span>mobile</label>
                 <div class="form-group">
                    <input type="text" name="mobile" value="<?php echo ($this->input->post('mobile') ? $this->input->post('mobile') : $stu_data->mobile); ?>" class="form-control" id="mobile" />
                    <span class="text-danger"><?php echo form_error('mobile');?></span>
                 </div>
               </div>

               <div class="col-md-12">
                  <label>Date of Birth</label>
                  <div class="form-group">
                    <div class="input-group date">
                     <input  type="text" name="dob" value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : $stu_data->dob); ?>" class="form-control pull-right" placeholder="DD/MM/YYYY" id="stuDob" />
                     <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                     </div>
                  </div>
                    <span class="text-danger text-capitalize"><?php echo form_error('dob');?></span>
                  </div>
               </div>



                 <div class="col-md-12">
                   <label for="gender" class="control-label text-capitalize"><span class="text-danger">*</span>gender</label>
                   <div class="form-group">
                     <select name="gender" id="gender" class="form-control my-s" >
                      <option value="" disabled selected> Choose</option>
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
                 <div class="col-md-12">
                   <label for="category_name" class="control-label text-capitalize"><span class="text-danger">*</span> category </label>
                   <div class="form-group">
                     <select name="category_name" id="category_name" class="form-control my-s" >
                      <option value="" disabled selected> Choose</option>
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

                <div class="col-md-12">
                   <label for="state" class="control-label text-capitalize"><span class="text-danger">*</span> state </label>
                   <div class="form-group">
                     <select name="state" id="state" class="form-control my-s" >
                      <option value="" disabled selected> Choose</option>
                          <?php
                            foreach($state as $s){
                                $selected = ($s['state_id'] == $stu_data->state) ?  ' selected="selected" ' : "";
                                echo '<option value="'.$s['state_id'].'"  '.$selected.'>'.ucwords($s['state_name']).'</option>';
                            }
                         ?>
                    </select>
                     <span class="text-danger"><?php echo form_error('state');?></span>

                   </div>
                </div>


                <div class="col-md-12">
                 <label for="house" class="control-label text-capitalize"><span class="text-danger">*</span>house/village</label>
                 <div class="form-group">
                    <input type="text" name="house" value="<?php echo ($this->input->post('house') ? $this->input->post('house') : $stu_data->house); ?>" class="form-control" id="house" />
                    <span class="text-danger"><?php echo form_error('house');?></span>
                 </div>
               </div>

                <div class="col-md-12">
                 <label for="block" class="control-label text-capitalize"><span class="text-danger">*</span>block/post</label>
                 <div class="form-group">
                    <input type="text" name="block" value="<?php echo ($this->input->post('block') ? $this->input->post('block') : $stu_data->block); ?>" class="form-control" id="block" />
                    <span class="text-danger"><?php echo form_error('block');?></span>
                 </div>
               </div>

                <div class="col-md-12">
                 <label for="district" class="control-label text-capitalize"><span class="text-danger">*</span>district</label>
                 <div class="form-group">
                    <input type="text" name="district" value="<?php echo ($this->input->post('district') ? $this->input->post('district') : $stu_data->district); ?>" class="form-control" id="district" />
                    <span class="text-danger"><?php echo form_error('district');?></span>
                 </div>
               </div>
                
                <div class="col-md-12">
                 <label for="pincode" class="control-label text-capitalize"><span class="text-danger">*</span>pincode</label>
                 <div class="form-group">
                    <input type="text" name="pincode" value="<?php echo ($this->input->post('pincode') ? $this->input->post('pincode') : $stu_data->pincode); ?>" class="form-control" id="pincode" />
                    <span class="text-danger"><?php echo form_error('pincode');?></span>
                 </div>
               </div>
               <div class="col-md-12">
                 <label for="address" class="control-label text-capitalize"><span class="text-danger">*</span> full address</label>
                 <div class="form-group">
                    <input type="text" name="address" value="<?php echo ($this->input->post('address') ? $this->input->post('address') : $stu_data->address); ?>" class="form-control" id="address" />
                    <span class="text-danger"><?php echo form_error('address');?></span>
                 </div>
               </div>


             </div>
            
            
           </div>
           <!-- /.tab-content -->
         </div>
         <!-- nav-tabs-custom -->
      </div>
      </div>
         </div>
         <div class="box-footer">
            <input type="submit" name="submit1" class="btn btn-warning" value="Update">
         </div>
       </form>
      </div>
   </div>
</div>


