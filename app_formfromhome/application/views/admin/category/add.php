<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('add-category'); ?>
      <div class="box-body">

         <div class="row clearfix">
            <div class="col-md-4">
               <label for="category_name" class="control-label text-capitalize"><span class="text-danger">*</span>category</label>
               <div class="form-group">
                  <input type="text" name="category_name" value="<?php echo $this->input->post('category_name'); ?>" class="form-control" id="category_name" />
                  <span class="text-danger text-capitalize"><?php echo form_error('category_name');?></span>
               </div>
            </div>
         </div>
         <div class="box-footer">
            <input type="submit" name="submit1" class="btn btn-success" value="Save">
            <!-- <i class="fa fa-check"></i> Save
            </button> -->
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>

