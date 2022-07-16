<?php
  $paytmChecksum = getChecksumFromArray($paytmParams, $MKEY);
  // $transactionURL = "https://securegw-stage.paytm.in/theia/processTransaction";
  $transactionURL = "https://securegw.paytm.in/order/process";



?>
<div class="root">
  <div class="container p-0">
    <center><h1>Please do not refresh this page...</h1></center>
        <form method='post' action='<?php echo $transactionURL; ?>' name='f1'>
            <?php
                foreach($paytmParams as $name => $value) {
                    echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
                }
            ?>
            <input type="hidden" name="CHECKSUMHASH" value="<?php echo $paytmChecksum ?>">
        </form>
        <script type="text/javascript">
            document.f1.submit();
        </script>
  </div>
</div>
