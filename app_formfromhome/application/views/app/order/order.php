<div class="container p-0">
<div class="row mt">
   <div class="col-md-12 p-0">
      <div class="box box-info p-tb-5">
         <div class="box-header with-border">
            <h5 class="box-title text-center b_ty8o "><?= ucwords($page_title); ?></h5>
         </div>

         <div class="container p-0">

          <div class="row mt">
            <div class="col-xs-12 m-0 p-0">
              <ul class="cvo_w9">

              </ul>
              <table>
                <thead>
                  <tr>
                    <th>Exam Name</th>
                    <th>Fee</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($order_history as $o) {
                      ?>
                        <tr>
                          <td><?= $o['name_of_post'] ?></td>
                          <td><?= $o['exam_fee'] ?></td>
                        </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
   </div>
</div>
</div>
