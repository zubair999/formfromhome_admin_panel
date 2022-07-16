<div class="container" style="width:50%;">
<div class="row clearfix">
   <div class="col-lg-12 col-md-12">
      <div class="nav-tabs-custom">
         <ul class="nav nav-tabs">
            <li class="active"><a href="#basic" data-toggle="tab" aria-expanded="true">Academic Qualifications</a></li>
         </ul>
         <div class="tab-content" style="padding: 0; margin-top: 16px;">
            <div class="tab-pane active" id="basic">
               <div class="row">
                  <div class="col-md-12">
                     <?php
                     	$i = 1;
                     	foreach ($student_academic as $key => $value) {
                     		?>
                     			<a href="<?php echo base_url('a-edit-academic/'.$value['academic_idId']) ?>">
                     				<div class="form-control">
										<div class="">
											<div class="col-lg-6">
						                 		<div><?php echo $i.'.'.' '; echo ucwords($value['qualification_name']) ?></div>
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