<div class="root">
  <div class="container p-0">
    <form class="apply-form" action="<?php echo base_url('app/payment/request') ?>" enctype="multipart/form-data" method="post">
  <h4 class="text-center p-0 m-0 loq_2e4 text-capitalize"><?= $page_title.' ['.$cartCount.']'; ?> </h4>
    <div class="row">
      <div class="col-xs-12 m-0 p-0">
        <table class="qaz_i89">
          <thead>
            <tr>
              <th>Exam</th>
              <th>Fee</th>
              <th>Service Charge</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ($cart_item as $ci) {
                ?>
                  <tr>
                    <td><?= $ci['name_of_post']; ?></td>
                    <td><?= $ci['exam_fee']; ?></td>
                    <td><?= $ci['service_charge']; ?></td>
                    <td data-cart_delete_item="<?= $ci['cart_idId']; ?>" style="cursor:pointer;text-align:center;">
                      <svg fill="red" width="20px" height="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	  viewBox="0 0 408.483 408.483" style="enable-background:new 0 0 408.483 408.483;"
	 xml:space="preserve">
<g>
	<g>
		<path d="M87.748,388.784c0.461,11.01,9.521,19.699,20.539,19.699h191.911c11.018,0,20.078-8.689,20.539-19.699l13.705-289.316
			H74.043L87.748,388.784z M247.655,171.329c0-4.61,3.738-8.349,8.35-8.349h13.355c4.609,0,8.35,3.738,8.35,8.349v165.293
			c0,4.611-3.738,8.349-8.35,8.349h-13.355c-4.61,0-8.35-3.736-8.35-8.349V171.329z M189.216,171.329
			c0-4.61,3.738-8.349,8.349-8.349h13.355c4.609,0,8.349,3.738,8.349,8.349v165.293c0,4.611-3.737,8.349-8.349,8.349h-13.355
			c-4.61,0-8.349-3.736-8.349-8.349V171.329L189.216,171.329z M130.775,171.329c0-4.61,3.738-8.349,8.349-8.349h13.356
			c4.61,0,8.349,3.738,8.349,8.349v165.293c0,4.611-3.738,8.349-8.349,8.349h-13.356c-4.61,0-8.349-3.736-8.349-8.349V171.329z"/>
		<path d="M343.567,21.043h-88.535V4.305c0-2.377-1.927-4.305-4.305-4.305h-92.971c-2.377,0-4.304,1.928-4.304,4.305v16.737H64.916
			c-7.125,0-12.9,5.776-12.9,12.901V74.47h304.451V33.944C356.467,26.819,350.692,21.043,343.567,21.043z"/>
	</g>
</g>

</svg>

                    </td>
                  </tr>
                <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <h4 class="text-center p-0 m-0 loq_2e4 text-capitalize">Summary</h4>
      <table class="qaz_i89">
        <thead>
          <tr>
            <th>Total Cart Item</th>
            <th>Total Fee</th>
            <th>Total Service Charge</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="cc_01"><?= $cartCount;?></td>
            <td class="cc_01"><?= $summary['te'];?></td>
            <td class="cc_01"><?= $summary['ts']; ?></td>
          </tr>
          <tr>
            <th colspan="2">Total Charge:</th>
            <td class="cc_01"><?= (float)$summary['te']+(float)$summary['ts']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php 
      if($cartCount > 0){
        ?>
          <div class="row mb">
            <div class="col-xs-12">
              <input type="submit" name="submit1" value="Checkout Now" class="btn btn-primary full_width">
            </div>
          </div>
        <?php
      }
    ?>
    
  </form>
  </div>
</div>
