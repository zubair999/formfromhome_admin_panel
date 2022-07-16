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
           <?php if($stu_row === 0){
             ?>
             <div class="container" style="font-size: 18px;
             font-weight: 800;
             padding: 8px;">No Data!!</div>
             <?php
           }else{?>
            <div class="row clearfix">

             <div class="col-xs-12">
              <table class="table">
                <?php
                foreach($academicArr as $a){
                  ?>
                <tbody>
                  <tr>
                    <th colspan="2" class="text-center text-capitalize" style="font-size:30px;"><?= $a['qualification_name']; ?></th>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">passing year</th>
                    <td class="stu_021 text-capitalize"><?= $a['passing_year'] ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">board</th>
                    <td class="stu_021 text-capitalize"><?= $a['board_name'] ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">total marks</th>
                    <td class="stu_021 text-capitalize"><?= $a['total_marks'] ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">obtained marks</th>
                    <td class="stu_021 text-capitalize"><?= $a['marks_obtained'] ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">percentage</th>
                    <td class="stu_021 text-capitalize"><?= $a['percentage'] ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">mediam</th>
                    <td class="stu_021 text-capitalize"><?= $a['mediam_name'] ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">stream</th>
                    <td class="stu_021 text-capitalize"><?= $a['stream_name'] ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">extra info</th>
                    <td class="stu_021 text-capitalize"><?= $a['extra_info'] ?></td>
                  </tr>
                  <?php
                  $i=0;
                   foreach($a['document'] as $aa){ ?>
                  <tr>
                    <th class="stu_021 text-capitalize">Document</th>
                    <td class="stu_021 text-capitalize">
                      <iframe id="iframeCertifate" style="width:300px; height:100px;overflow: hidden;" src="<?php echo base_url('uploads/marksheet/'.$aa['marksheet_img']); ?>" border: none;"></iframe>
                    </td>
                  </tr>
                <?php $i++; }?>
                  <tr><td colspan="2"><a class="btn btn-warning" href="<?=base_url('edit-academic/'.$a['academic_idId'])?>">Edit Details</a></td></tr>
                </tbody>
              <?php  }?>
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
            <!-- <a class="btn btn-warning" href="<?=base_url('edit-academic')?>">Edit Detailss</a> -->
          </div>
        </div>
    </div>

<?php echo form_close(); ?>
</div>
