<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('add-admit-card'); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="admit_card" class="control-label text-capitalize"><span class="text-danger">*</span>admit card name</label>
               <div class="form-group">
                  <input type="text" name="admit_card" value="<?php echo $this->input->post('admit_card'); ?>" class="form-control" id="admit_card" />
                  <span class="text-danger text-capitalize"><?php echo form_error('admit_card');?></span>
               </div>
            </div>

            <div class="col-md-4">
               <label for="link" class="control-label text-capitalize"><span class="text-danger">*</span>admit card link</label>
               <div class="form-group">
                  <input type="text" name="link" value="<?php echo $this->input->post('link'); ?>" class="form-control" id="link" />
                  <span class="text-danger text-capitalize"><?php echo form_error('link');?></span>
               </div>
            </div>

         </div>

         <div class="box-footer">
            <input type="submit" name="submit1" class="btn btn-success" value="Save">
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>

