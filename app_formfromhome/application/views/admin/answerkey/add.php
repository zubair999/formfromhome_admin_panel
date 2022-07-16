<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('add-answer-key'); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="answer_key" class="control-label text-capitalize"><span class="text-danger">*</span>answer key name</label>
               <div class="form-group">
                  <input type="text" name="answer_key" value="<?php echo $this->input->post('answer_key'); ?>" class="form-control" id="answer_key" />
                  <span class="text-danger text-capitalize"><?php echo form_error('answer_key');?></span>
               </div>
            </div>

            <div class="col-md-4">
               <label for="link" class="control-label text-capitalize"><span class="text-danger">*</span>answer key link</label>
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

