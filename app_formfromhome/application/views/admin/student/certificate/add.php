<div class="row">
<div class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title"><?= ucwords($page_title); ?></h3>
      </div>
      <form action="<?php echo base_url('a-add-certificate/'.$id); ?>" method="post" enctype="multipart/form-data">
      <div class="box-body">
      <div class="container" style="width:50%;">
        <div class="row clearfix">
          <div class="col-lg-12 col-md-12">
         <!-- Custom Tabs -->
         <div class="nav-tabs-custom">
           <div class="tab-content" style="padding: 0; margin-top: 16px;">
             <!-- <div class="tab-pane active" id="basic"> -->

            

               <div class="col-md-12">
                 <label for="percentage" class="control-label text-capitalize"><span class="text-danger">*</span>document name</label>
                 <div class="form-group">
                    <input type="text" name="certificate_name" value="<?php echo $this->input->post('certificate_name'); ?>" class="form-control" id="certificate_name" />
                    <span class="text-danger"><?php echo form_error('certificate_name');?></span>
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
                       <label for="certificate_img" class="control-label text-capitalize">student photo</label>
                       <input type="file" name="certificate_img" id="certificate_img" required>
                       <span class="text-danger text-capitalize"><?php echo form_error('certificate_img');?></span>                     
                     </div>
                   </div>
                 <!-- </div> -->





             <!-- </div> -->
             <!-- /.tab-pane -->
            

             




             <!---images--->
            
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
