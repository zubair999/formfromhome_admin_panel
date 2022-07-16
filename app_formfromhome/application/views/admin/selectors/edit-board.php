<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('edit-board/'.$boardId); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="board_name" class="control-label text-capitalize"><span class="text-danger">*</span>board name</label>
               <div class="form-group">
                  <input type="text" name="board_name" value="<?php echo ($this->input->post('board_name')) ? $this->input->post('board_name') : $board_name; ?>" class="form-control" id="board_name" />
                  <span class="text-danger"><?php echo form_error('board_name');?></span>
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
