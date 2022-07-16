<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('edit-result/'.$resultId); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="result_name" class="control-label text-capitalize"><span class="text-danger">*</span>state name</label>
               <div class="form-group">
                  <input type="text" name="result_name" value="<?php echo ($this->input->post('result_name')) ? $this->input->post('result_name') : $result->result_name; ?>" class="form-control" id="result_name" />
                  <span class="text-danger"><?php echo form_error('result_name');?></span>
               </div>
            </div>

            <div class="col-md-4">
               <label for="link" class="control-label text-capitalize"><span class="text-danger">*</span>link name</label>
               <div class="form-group">
                  <input type="text" name="link" value="<?php echo ($this->input->post('link')) ? $this->input->post('link') : $result->link; ?>" class="form-control" id="link" />
                  <span class="text-danger"><?php echo form_error('link');?></span>
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
