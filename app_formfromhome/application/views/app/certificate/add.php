<div class="container p-0">
  <?php echo form_open_multipart('add-certificate', array('method'=>'post')); ?>
<div class="row mt">
   <div class="col-md-12 p-0">
      <div class="box box-info p-tb-5">
         <div class="box-header with-border">
            <h5 class="box-title text-center b_ty8o"><?= ucwords($page_title); ?></h5>
         </div>


         <div class="box-body">
           <h6 class="text-center"><u>Document Details</u></h6>
            <div class="row clearfix">

              <div class="col-xs-12">
                 <label class="control-label text-capitalize">document name</label>
                 <div class="form-group">
                   <div class="input-group full_width">
                    <input  type="text" name="certificate_name"  class="form-control pull-right transform_01"  required />
                 </div>
                   <span class="text-danger text-capitalize"><?php echo form_error('certificate_name');?></span>
                 </div>
              </div>

              <div class="col-xs-12" style="margin:10px 0;">
                <div id="ct_0poi">
                  <div class="col-xs-12" style="margin:10px 0">
                    <label for="certificate_img" class="control-label text-capitalize"><span class="text-danger">* </span>Upload Doc Copy</label>
                    <div class="form-group">
                       <input type="file" name="certificate_img" id="yue_op87" required/>
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
                 <h6 class="text-danger"> Save document with their names. You can add multiple document later.</h6>
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
