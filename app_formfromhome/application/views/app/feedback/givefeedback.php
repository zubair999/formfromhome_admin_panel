<div class="container p-0">
   <?php echo form_open_multipart('feedback', array('method'=>'post')); ?>
   <div class="row mt">
      <div class="col-md-12 p-0">
         <div class="box box-info p-tb-5">
            <div class="box-header with-border">
               <h5 class="box-title text-center b_ty8o"><?= ucwords($page_title); ?></h5>
            </div>
            <div class="box-body">
               <h6 class="text-center"><u>Your feedback help us imporve</u></h6>
               <div class="row clearfix">
                  <div class="col-xs-12">
                     <label class="control-label text-capitalize">Write your feedback here.</label>
                     <div class="form-group">
                        <div class="input-group full_width" >
                           <textarea style="height:200px" name="feedback" class="form-control pull-right transform_01" required/></textarea>
                        </div>
                        <span class="text-danger text-capitalize"><?php echo form_error('student_name');?></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row mb">
      <div class="box-footer">
         <input type="submit" name="submit1" class="btn btn-success" value="Send Feedback">
         <!-- <i class="fa fa-check"></i> Save
            </button> -->
      </div>
   </div>
   <?php echo form_close(); ?>
</div>
