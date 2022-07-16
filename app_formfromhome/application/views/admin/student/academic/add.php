<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <form action="<?php echo base_url('a-add-academic/'.$id); ?>" method="post" enctype="multipart/form-data">
      <div class="box-body">
      <div class="container" style="width:50%;">
        <div class="row clearfix">
          <div class="col-lg-12 col-md-12">
         <!-- Custom Tabs -->
         <div class="nav-tabs-custom">
           <div class="tab-content" style="padding: 0; margin-top: 16px;">
             <!-- <div class="tab-pane active" id="basic"> -->
               
               
               
               <div class="col-md-12">
                   <label for="qualification" class="control-label text-capitalize"><span class="text-danger">*</span> qualification </label>
                   <div class="form-group">
                     <select name="qualification" id="category_name" class="form-control my-s" >
                      <option value="" disabled selected> Choose</option>
                          <?php
                           foreach($qualification_arr as $q){
                             $selected = ($q['qualification_id'] == $this->input->post('qualification')) ?  ' selected="selected" ' : "";
                             echo '<option value="'.$q['qualification_id'].'" '.$selected.'>'.strtoupper($q['qualification_name']).'</option>';
                            }
                        ?>
                    </select>
                     <span class="text-danger"><?php echo form_error('qualification');?></span>

                   </div>
                </div>

              <div class="col-md-12">
                   <label for="year" class="control-label text-capitalize"><span class="text-danger">*</span> year </label>
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

            

               <div class="col-md-12">
                   <label for="board" class="control-label text-capitalize"><span class="text-danger">*</span> board </label>
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

                   <div class="col-md-12">
                   <label for="medium" class="control-label text-capitalize"><span class="text-danger">*</span> medium </label>
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

               <div class="col-md-12">
                   <label for="stream" class="control-label text-capitalize"><span class="text-danger">*</span> stream </label>
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

               <div class="col-md-12">
                 <label for="total_marks" class="control-label text-capitalize"><span class="text-danger">*</span>total marks</label>
                 <div class="form-group">
                    <input onkeyup="calculatePercentage()" id="totalm" type="text" name="total_marks" value="<?php echo $this->input->post('total_marks'); ?>" class="form-control" />
                    <span class="text-danger"><?php echo form_error('total_marks');?></span>
                 </div>
               </div>
               <div class="col-md-12">
                 <label for="marks_obtained" class="control-label text-capitalize"><span class="text-danger">*</span>marks obtained</label>
                 <div class="form-group">
                    <input onkeyup="calculatePercentage()" id="markso" type="text" name="marks_obtained" value="<?php echo $this->input->post('marks_obtained'); ?>" class="form-control" />
                    <span class="text-danger"><?php echo form_error('marks_obtained');?></span>
                 </div>
               </div>
               <div class="col-md-12">
                 <label for="percentage" class="control-label text-capitalize"><span class="text-danger">*</span>percentage</label>
                 <div class="form-group">
                    <input type="text" name="percentage" value="<?php echo $this->input->post('percentage'); ?>" class="form-control" id="perc" />
                    <span class="text-danger"><?php echo form_error('percentage');?></span>
                 </div>
               </div>
               <div class="col-md-12">
                 <label for="extra_info" class="control-label text-capitalize"><span class="text-danger">*</span>Extra Info (Optional:)</label>
                 <div class="form-group">
                    <input type="text" name="extra_info" value="<?php echo $this->input->post('extra_info'); ?>" class="form-control" id="dob" />
                    <span class="text-danger"><?php echo form_error('extra_info');?></span>
                 </div>
               </div>

                <!-- <div class="tab-pane"> -->
                   <div class="col-md-12">
                     <p>Image Format: JPG|JPEG|PNG</p>
                      <p>Max Size: 10MB</p>
                   </div>
                 <!-- </div> -->
                 <!-- <div class="tab-pane"> -->
                   <div class="col-md-12">
                     <div class="form-group">
                       <label for="document_img1" class="control-label text-capitalize">File: 1</label>
                       <input type="file" name="document_img1" id="document_img1" required>
                     </div>
                   </div>



                   <div class="col-md-12">
                     <div class="form-group">
                       <label for="addMoreFile" class="control-label text-capitalize"></label>
                       <input type="button"  value="Add More File +" id="addMoreFile">             
                     </div>
                   </div>


            
           </div>
           <!-- /.tab-content -->
         </div>
         <!-- nav-tabs-custom -->
      </div>
      </div>
         </div>
         <div class="box-footer">
            <input type="submit" name="submit1" class="btn btn-success" value="Save">
         </div>
       </form>
      </div>
   </div>
</div>


<script>
  function calculatePercentage(){
    let totalMarks = document.getElementById('totalm').value;
    let marksObtained = document.getElementById('markso').value;
    if(totalMarks != '' && totalMarks != null && totalMarks != undefined && marksObtained != '' && marksObtained != null && marksObtained != undefined){
      document.getElementById('perc').value = (parseFloat(marksObtained)/parseFloat(totalMarks) * 100).toFixed(2); 
    }
    else{
      document.getElementById('perc').value = '';
    }
  }

  document.getElementById('addMoreFile').onclick = (e) =>{
    const inputElem = document.querySelectorAll('input[type="file"]').length;
    const add = `<div class="col-md-12">
                     <div class="form-group">
                       <label for="document_img${inputElem+1}" class="control-label text-capitalize">File: ${inputElem+1}</label>
                       <input type="file" name="document_img${inputElem+1}" id="document_img${inputElem+1}" required>
                     </div>
                   </div>`;
    e.target.parentElement.parentElement.insertAdjacentHTML('beforebegin',add);
  }
</script>