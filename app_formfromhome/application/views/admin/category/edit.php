<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('edit-caterory/'.$category_id); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="category_name" class="control-label text-capitalize"><span class="text-danger">*</span>service category</label>
               <div class="form-group">
                  <input type="text" name="category_name" value="<?php echo ($this->input->post('category')) ? $this->input->post('category') : $category; ?>" class="form-control" id="category_name" />
                  <span class="text-danger"><?php echo form_error('category_name');?></span>
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

