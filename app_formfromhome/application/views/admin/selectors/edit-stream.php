<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('edit-stream/'.$streamId); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="stream_name" class="control-label text-capitalize"><span class="text-danger">*</span>stream name</label>
               <div class="form-group">
                  <input type="text" name="stream_name" value="<?php echo ($this->input->post('stream_name')) ? $this->input->post('stream_name') : $stream_name; ?>" class="form-control" id="stream_name" />
                  <span class="text-danger"><?php echo form_error('stream_name');?></span>
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
