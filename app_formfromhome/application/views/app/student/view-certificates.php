

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
                foreach($certificateArr as $c){
                  ?>
                <tbody>

                  <tr>
                    <th class="stu_021 text-capitalize">title</th>
                    <td class="stu_021 text-capitalize"><?= $c['certificate_name'] ?></td>
                  </tr>
                  <tr>
                    <th class="stu_021 text-capitalize">images</th>



                    <td>
                      <iframe id="iframeCertifate" style="width:300px; height:100px;overflow: hidden;" src="<?php echo base_url('/uploads/certificates/'.$c['certificate_img'])?>" border: none;"></iframe>
                    </td>
                  </tr>
                  <tr>
                    <th> <a href="<?= base_url('edit-certificate/'.$c['stu_certificate_idId']) ?>" class="btn btn-warning btn-xs">Edit</a></th>
                  </tr>
                  <tr>

                  <?php ?>
                 <?php ?>
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
            <a class="btn btn-primary" href="<?=base_url('add-certificate')?>">Add Document</a>
          </div>
        </div>
    </div>

<?php echo form_close(); ?>
</div>
