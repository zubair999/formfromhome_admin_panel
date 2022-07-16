<div class="container p-0">
  <?php echo form_open_multipart('add-academic', array('method'=>'post')); ?>
<div class="row mt">
   <div class="col-md-12 p-0">
      <div class="box box-info p-tb-5">
         <div class="box-header with-border">
            <h5 class="box-title text-center b_ty8o"><?= ucwords($page_title); ?></h5>
         </div>


         <div class="box-body">

            <div class="row clearfix">

              <div class="col-xs-12" style="margin-top:10px">
                 <div class="form-group">
                   <div class="full_width">

                    <a class="btn btn-primary full_width" href="<?=base_url('personal-details')?>">personal details</a>
                 </div>
                 </div>
              </div>

              <div class="col-xs-12" style="margin-top:10px">
                 <div class="form-group">
                   <div class="full_width">
                     <a class="btn btn-primary full_width" href="<?=base_url('academic-details')?>">academic details</a>

                 </div>
                 </div>
              </div>

              <div class="col-xs-12" style="margin-top:10px">
                 <div class="form-group">
                   <div class="full_width">
                     <a class="btn btn-primary full_width" href="<?=base_url('certificate-details')?>">certificate details</a>

                 </div>
                 </div>
              </div>

            </div>
          </div>


      </div>
   </div>
</div>


<?php echo form_close(); ?>
</div>
