<div class="container p-0">
  <?php echo form_open_multipart('add-academic', array('method'=>'post')); ?>
<div class="row mt">
   <div class="col-md-12 p-0">
      <div class="box box-info p-tb-5">
         <div class="box-header with-border">
            <h5 class="box-title text-center b_ty8o"><?= ucwords($page_title); ?></h5>
         </div>


         <div class="box-body">
           <h6 class="text-center"><u>Qualification Details</u></h6>
            <div class="row clearfix">

              <div class="col-md-12 newSelectStyle">
                 <label for="qualification" class="control-label text-capitalize">qualification</label>
                 <div class="form-group">
                   <select name="qualification" class="form-control full_width" required>
                     <option value="">Select Qualification</option>
                     <?php
                      foreach($qualification_arr as $q){
                       $selected = ($q['qualification_id'] == $this->input->post('qualification')) ?  ' selected="selected" ' : "";
                       echo '<option value="'.$q['qualification_id'].'" '.$selected.'>'.strtoupper($q['qualification_name']).'</option>';
                      }
                     ?>

                   </select>
                   <span class="text-danger" id="u6_ut0"><?php echo form_error('qualification');?></span>
                 </div>
               </div>

               <div class="col-md-12 newSelectStyle">
                  <label for="year" class="control-label text-capitalize">passing year</label>
                  <div class="form-group">
                    <select name="year" class="form-control full_width" required>
                      <option value="">Select Year</option>
                        <?php
                         for($i = 1990; $i<2030; $i++){
                          echo '<option value="'.$i.'">'.$i.'</option>';
                         }
                        ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('year');?></span>
                  </div>
                </div>

                <div class="col-md-12 newSelectStyle">
                   <label for="board" class="control-label text-capitalize">select board/ University/ Medium</label>
                   <div class="form-group">
                     <select name="board" class="form-control full_width" required>
                       <option value="">Select Board</option>
                         <?php
                          foreach($board_arr as $ba){
                            $selected = ($ba['board_id'] == $this->input->post('board')) ?  ' selected="selected" ' : "";
                           echo '<option value="'.$ba['board_id'].'" '.$selected.'>'.strtoupper($ba['board_name']).'</option>';
                          }
                         ?>
                     </select>
                     <span class="text-danger"><?php echo form_error('board');?></span>
                   </div>
                 </div>

                <div class="col-md-12 newSelectStyle">
                   <label for="medium" class="control-label text-capitalize">select medium</label>
                   <div class="form-group">
                     <select name="medium" class="form-control full_width" required>
                       <option value="">Select Medium</option>
                         <?php
                          foreach($medium_arr as $ma){
                            $selected = ($ma['mediam_id'] == $this->input->post('medium')) ?  ' selected="selected" ' : "";
                           echo '<option value="'.$ma['mediam_id'].'" '.$selected.'>'.strtoupper($ma['mediam_name']).'</option>';
                          }
                         ?>
                     </select>
                     <span class="text-danger"><?php echo form_error('medium');?></span>
                   </div>
                 </div>

                <div class="col-md-12 newSelectStyle">
                   <label for="stream" class="control-label text-capitalize">select stream</label>
                   <div class="form-group">
                     <select name="stream" class="form-control full_width" required>
                       <option value="">Select Stream</option>
                         <?php
                          foreach($stream_arr as $sa){
                            $selected = ($sa['stream_id'] == $this->input->post('stream')) ?  ' selected="selected" ' : "";
                           echo '<option value="'.$sa['stream_id'].'" '.$selected.'>'.strtoupper($sa['stream_name']).'</option>';
                          }
                         ?>
                     </select>
                     <span class="text-danger"><?php echo form_error('stream');?></span>
                   </div>
                 </div>


              <div class="col-xs-12">
                 <label class="control-label text-capitalize">total marks</label>
                 <div class="form-group">
                   <div class="input-group full_width">
                    <input  type="text" name="total_marks" value="<?php echo $this->input->post('total_marks'); ?>" class="form-control pull-right" id="oytpO" onkeyup="calPercent()" required/>
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('total_marks');?></span>
                 </div>
              </div>

              <div class="col-xs-12">
                 <label class="control-label text-capitalize">marks obtained</label>
                 <div class="form-group">
                   <div class="input-group full_width">
                    <input  type="text" name="marks_obtained" value="<?php echo $this->input->post('marks_obtained'); ?>" class="form-control pull-right"  id="BnUyp" onkeyup="calPercent()" required/>
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('marks_obtained');?></span>
                 </div>
              </div>
              <div class="col-xs-12">
                 <label class="control-label text-capitalize">percentage</label>
                 <div class="form-group">
                   <div class="input-group full_width">
                    <input  type="text" name="percentage" value="<?php echo $this->input->post('percentage'); ?>" class="form-control pull-right"  id="percent" required/>
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('percentage');?></span>
                 </div>
              </div>

              <div class="col-xs-12">
                 <label class="control-label text-capitalize">Extra Info (Optional:)</label>
                 <div class="form-group">
                   <div class="input-group full_width">
                    <textarea class="form-control" name="extra_info" value="<?php echo $this->input->post('extra_info'); ?>"></textarea>
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('extra_info');?></span>
                 </div>
              </div>


              <div class="col-xs-12" style="margin:10px 0;">
                <div id="gt_0poi">
                  <div class="col-xs-12" style="margin:10px 0">
                    <label for="document_img" class="control-label text-capitalize"><span class="text-danger">* </span>Upload Document Copy</label>
                    <div class="form-group">
                       <input type="file" name="document_img" id="yue_op87" required/>
                       <span class="text-danger text-capitalize"></span>
                    </div>
                  </div>
                </div>
              </div>




              <div class="col-xs-12">
                <h4>Note:</h4>
                 <div class="form-group text-danger">
                   <p>Image Format: JPG|JPEG|PNG|PDF</p>
                   <p>Max Size: 10MB</p>
                 </div>
                 <h6 class="text-danger"> If you are adding Matric Qualification, then upload only Matric Document. You can further add more qualification and document.</h6>
              </div>


              <div class="col-xs-12" style="margin-top:10px">
                 <div class="form-group">
                   <div class="full_width">
                    <input type="button" class="btn btn-primary full_width" data-addDocument="addDocument" value="Add More Document" />
                 </div>
                 </div>
              </div>

            </div>
          </div>


      </div>
   </div>
</div>



<div class="row mb">
  <div class="box-footer">
     <input type="submit" name="submit1" class="btn btn-success" value="Save Details">
  </div>
</div>

<?php echo form_close(); ?>
</div>
