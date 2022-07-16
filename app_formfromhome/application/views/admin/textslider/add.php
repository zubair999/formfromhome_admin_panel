<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('add-text-slider'); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-12">
               <label for="slider_text" class="control-label text-capitalize"><span class="text-danger">*</span>slider text</label>
               <div class="form-group">
                  <input type="text" name="slider_text" value="<?php echo $this->input->post('slider_text'); ?>" class="form-control" id="slider_text" />
                  <span class="text-danger text-capitalize"><?php echo form_error('slider_text');?></span>
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

