
<html>
<head>
    <title>How to Create ZIP File in CodeIgniter</title>
    
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
 <div class="container box">
  <h3 align="center">How to Create ZIP File in CodeIgniter</h3>
  <br />
  <form method="post" action="<?php echo base_url(); ?>admin/zip/download">
  <?php
  foreach($images as $image)
  {
   echo '
   <div class="col-md-2" align="center" style="margin-bottom:24px;">
    <img src="'.base_url().''.$image.'" class="img-thumbnail img-responsive" />
     <br />
    <input type="checkbox" name="images[]" class="select" value="'.$image.'" />
   </div>
   ';
  }
  ?>
  <br />
  <div align="center">
   <input type="submit" name="download" class="btn btn-primary" value="Download" />
  </div>
  </form>
 </div>
</body>
</html>

<script>
$(document).ready(function(){
 $('.select').click(function(){
  if(this.checked)
  {
   $(this).parent().css('border', '5px solid #ff0000');
  }
  else
  {
   $(this).parent().css('border', 'none');
  }
 });
});
</script>

