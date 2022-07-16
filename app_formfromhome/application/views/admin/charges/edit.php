<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('edit-service-charges/'.$scId); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="amount" class="control-label text-capitalize"><span class="text-danger">*</span>service charges</label>
               <div class="form-group">
                  <input type="text" name="amount" value="<?php echo ($this->input->post('amount')) ? $this->input->post('amount') : $amount; ?>" class="form-control" id="amount" />
                  <span class="text-danger"><?php echo form_error('amount');?></span>
               </div>
            </div>

         </div>

         <div class="box-footer">
            <button type="submit" name="submit1" class="btn btn-success">
            <i class="fa fa-check"></i> update
            </button>
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>

