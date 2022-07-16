<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <?php echo form_open('edit-answer-key/'.$answerKeyId); ?>
      <div class="box-body">

         <div class="row clearfix">

            <div class="col-md-4">
               <label for="answer_key" class="control-label text-capitalize"><span class="text-danger">*</span>state name</label>
               <div class="form-group">
                  <input type="text" name="answer_key" value="<?php echo ($this->input->post('answer_key')) ? $this->input->post('answer_key') : $answer_key->answer_key_name; ?>" class="form-control" id="answer_key" />
                  <span class="text-danger"><?php echo form_error('answer_key');?></span>
               </div>
            </div>

            <div class="col-md-4">
               <label for="link" class="control-label text-capitalize"><span class="text-danger">*</span>link name</label>
               <div class="form-group">
                  <input type="text" name="link" value="<?php echo ($this->input->post('link')) ? $this->input->post('link') : $answer_key->link; ?>" class="form-control" id="link" />
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
