<div class="container p-0">
  <?php echo form_open_multipart('student-profile', array('method'=>'post')); ?>
<div class="row mt">
   <div class="col-md-12 p-0">
      <div class="box box-info p-tb-5">
         <div class="box-header with-border">
            <h5 class="box-title text-center b_ty8o"><?= ucwords($page_title); ?></h5>
         </div>

         <div class="box-body">
           <h6 class="text-center"><u></u></h6>

            <?php //$stuId = $student_info->student_id;
            if($stu_row === 0){
              ?>
              <div class="container" style="font-size: 18px;
            	font-weight: 800;
            	padding: 8px;">No Data!!</div>
              <?php
            }else{
             ?>
            <div class="row clearfix">
             <div class="col-xs-12">
              <table class="table">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Name</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th class="stu_021 text-capitalize">Student img</th>
                    <td><img src="<?= base_url('uploads/student/'.$student_info->student_img); ?>" style="width:100px;height:100px;"></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">Student sign</th>
                    <td><img src="<?= base_url('uploads/student/'.$student_info->signature_img); ?>" style="width:100px;height:100px;"></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">thumb img</th>
                    <td><img src="<?= base_url('uploads/student/'.$student_info->thumb_img); ?>" style="width:100px;height:100px;"></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">Student Name</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->student_name ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">date of birth</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->dob ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">Student gender</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->gender ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">mobile</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->mobile ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">category</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->category_name ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">father name</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->father_name ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">mother name</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->mother_name ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">gender</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->gender ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">house</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->house ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">block</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->block ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">district</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->district?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">pincode</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->pincode?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">full address</th>
                    <td class="stu_021 text-capitalize"><?= $student_info->address?></td>
                  </tr>

                </tbody>
              </table>
             </div>



            </div>
          <?php }?>
          </div>


      </div>
   </div>
</div>

<div class="col-xs-12 mb" style="margin-top:10px">
  <div class="col-xs-6">
   <div class="form-group">

       <a class="btn btn-primary" href="<?=base_url('my-profile')?>">back</a>
     </div>
   </div>
   <div class="col-xs-6 bot_01">
    <div class="form-group">
        <input type="submit" name="submit1" class="btn btn-success" value="Edit Details">
      </div>
    </div>
</div>

<?php echo form_close(); ?>
</div>
