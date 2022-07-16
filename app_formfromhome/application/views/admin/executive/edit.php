<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('exe-edit/'.$exe); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="executive_name" class="control-label text-capitalize"><span class="text-danger">*</span>name of executive</label>
               <div class="form-group">
                  <input type="text" name="executive_name" value="<?php echo ucwords($exeObj->name); ?>" class="form-control" id="executive_name" />
                  <span class="text-danger"><?php echo form_error('executive_name');?></span>
               </div>
            </div>
            <div class="col-md-4">
               <label for="email" class="control-label text-capitalize"><span class="text-danger">*</span>email</label>
               <div class="form-group">
                  <input type="text" name="email" value="<?php echo ucwords($exeObj->user_name); ?>" class="form-control" id="email" />
                  <span class="text-danger"><?php echo form_error('email');?></span>
               </div>
            </div>
            <div class="col-md-4">
               <label for="mobile" class="control-label text-capitalize"><span class="text-danger">*</span>mobile</label>
               <div class="form-group">
                  <input type="text" name="mobile" value="<?php echo ucwords($exeObj->mobile); ?>" class="form-control" id="mobile" />
                  <span class="text-danger"><?php echo form_error('mobile');?></span>
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
