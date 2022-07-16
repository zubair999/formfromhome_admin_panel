<?php
  $theadObj = new TableFactory();
  $theadObj->renderTableHead($drawTable, $pageTitle, $tableId, $pl);
?>

<script>
$(function () {
   $('#examListing').DataTable({
      "processing": false,
      "serverSide": true,
      "pageLength": 10,
      // "scrollY":        "500px",
      // "scrollCollapse": true,
      "ajax":{
          url :"<?=base_url('get-exam')?>",
          type: "post",
          error: function(response){
            console.log(response)
              $(".contacts-grid-error").html("");
              $("#contacts-grid").append('<tbody class="contacts-grid-error"><tr><th align="center" colspan="5">No data found in the server</th></tr></tbody>');
              $("#contacts-grid_processing").css("display","none");
          }
      },
   });
});
</script>