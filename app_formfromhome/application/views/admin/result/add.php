<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('add-result'); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="result_name" class="control-label text-capitalize"><span class="text-danger">*</span>result name</label>
               <div class="form-group">
                  <input type="text" name="result_name" value="<?php echo $this->input->post('result_name'); ?>" class="form-control" id="result_name" />
                  <span class="text-danger text-capitalize"><?php echo form_error('result_name');?></span>
               </div>
            </div>

            <div class="col-md-4">
               <label for="link" class="control-label text-capitalize"><span class="text-danger">*</span>result link</label>
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

