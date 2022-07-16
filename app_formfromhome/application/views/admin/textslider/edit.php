<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('edit-text-slider/'.$textSliderId); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-12">
               <label for="slider_text" class="control-label text-capitalize"><span class="text-danger">*</span>slider text</label>
               <div class="form-group">
                  <input type="text" name="slider_text" value="<?php echo ($this->input->post('slider_text')) ? $this->input->post('slider_text') : $text_slider->text_slider_text; ?>" class="form-control" id="slider_text" />
                  <span class="text-danger"><?php echo form_error('slider_text');?></span>
               </div>
            </div>

         </div>

         <div class="box-footer">
            <button type="submit" name="submit1" class="btn btn-success">
            <i class="fa fa-check"></i> Save
            </button>
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>
