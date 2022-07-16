<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('edit-admit-card/'.$admitCardId); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="admit_card" class="control-label text-capitalize"><span class="text-danger">*</span>state name</label>
               <div class="form-group">
                  <input type="text" name="admit_card" value="<?php echo ($this->input->post('admit_card')) ? $this->input->post('admit_card') : $admit_card->admit_card_name; ?>" class="form-control" id="admit_card" />
                  <span class="text-danger"><?php echo form_error('admit_card');?></span>
               </div>
            </div>

            <div class="col-md-4">
               <label for="link" class="control-label text-capitalize"><span class="text-danger">*</span>link name</label>
               <div class="form-group">
                  <input type="text" name="link" value="<?php echo ($this->input->post('link')) ? $this->input->post('link') : $admit_card->link; ?>" class="form-control" id="link" />
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
