<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open_multipart('send-email/'.$id); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="amount" class="control-label text-capitalize"><span class="text-danger">*</span>Upload Image (Max File Size: 100kb, Only PDF file format is allowed.)</label>
               <div class="form-group">
                  <input type="file" name="form" value="<?php echo $this->input->post('amount'); ?>" class="form-control" id="amount" />
                  <span class="text-danger text-capitalize"><?php echo form_error('amount');?></span>

               </div>
            </div>



         </div>

         <div class="box-footer">
            <input type="submit" name="submit1" class="btn btn-success" value="Send Email">
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>
