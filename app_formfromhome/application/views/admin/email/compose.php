<div class="container">
   <div class="col-md-12">

      <?php echo form_open('send-email',array('method'=>'post')) ?>
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title"><?= ucwords($page_title) ?></h3>
         </div>
         <div class="box-body">
            <div class="form-group">
               <input class="form-control" name="to" placeholder="To:" autofocus>
            </div>
            <div class="form-group">
               <input class="form-control" name="subject" placeholder="Subject:">
            </div>
            <div class="form-group">
               <textarea name="message" id="examFormContent" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
               <div class="btn btn-default btn-file">
                  <i class="fa fa-paperclip"></i> Attachment
                  <input type="file" name="attachment">
               </div>
               <p class="help-block">Max. 32MB</p>
            </div>
         </div>
         <div class="box-footer">
            <div class="pull-right">
               <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
            </div>
         </div>
      </div>
      <?php echo form_close(); ?>

   </div>
</div>

