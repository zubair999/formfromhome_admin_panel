<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('reset-password', array('method'=>'post')); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="pass" class="control-label text-capitalize"><span class="text-danger">*</span>New Password</label>
               <div class="form-group">
                  <input type="text" name="pass" value="<?php echo $this->input->post('pass'); ?>" class="form-control" id="pass" autocomplete="off"/>
                  <span class="text-danger text-capitalize"><?php echo form_error('pass');?></span>
               </div>
            </div>
        </div>

         <div class="box-footer">
            <input type="submit" name="submit1" value="Reset" class="btn btn-success">
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>
