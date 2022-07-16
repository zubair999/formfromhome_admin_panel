<div class="container" style="width:50%;">
<div class="row clearfix">
   <div class="col-lg-12 col-md-12">
      <div class="nav-tabs-custom">
         <ul class="nav nav-tabs">
            <li class="active"><a href="#basic" data-toggle="tab" aria-expanded="true">Student Certificate</a></li>
         </ul>
         <div class="tab-content" style="padding: 0; margin-top: 16px;">
            <div class="tab-pane active" id="basic">
               <div class="row">
                  <div class="col-md-12">
                     <?php
                     	$i = 1;
                     	foreach ($student_certificate as $key => $value) {
                     		?>
                     			<a href="<?php echo base_url('a-edit-certificate//'.$value['stu_certificate_idId']) ?>">
                     				<div class="form-control">
										<div class="">
											<div class="col-lg-6">
						                 		<div><?php echo $i.'.'.' '; echo ucwords($value['certificate_name']) ?></div>
						                 	</div>										
										</div>
				               		</div>	
                     			</a>
								
                     		<?php
                     	$i++;
                     	}
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>