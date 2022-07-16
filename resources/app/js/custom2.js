var base_url = location.origin;

const ad_qualification = (passyear,i) => {
  return (
    `
    <div class="col-md-12 p-0 box eduEleLen" data-educount${i}="${i}">
      <div class="">
        <div class="box-header with-border" style="margin-top:5px">
            <h5 class="box-title text-center b_ty8o">Add Qualification</h5>
         </div>
         <div class="box-body p-5">
           <h6 class="text-center"><u>Add Qualification</u></h6>
            <div class="row clearfix">

            <div class="col-xs-12">
               <label for="state_name" class="control-label text-capitalize">qualification</label>
               <div class="form-group">
               <select name="qualification[]" id="qu_01${i}" class="form-control">
                 <option value="">Select Qualification</option>

               </select>
                 <span class="text-danger" id="u6_ut0"></span>
               </div>
             </div>


              <div class="col-xs-12">
                 <label for="passing_year" class="control-label text-capitalize">passing year</label>
                 <div class="form-group">
                   <select name="passing_year[]" class="form-control">
                     <option value="">Select year</option>
                     ${passyear()}
                   </select>
                   <span class="text-danger"></span>
                 </div>
               </div>

              <div class="col-xs-12">
                 <label for="total_marks" class="control-label text-capitalize">total marks</label>
                 <div class="form-group">
                   <div class="input-group date full_width">
                    <input type="text" name="total_marks[]" class="form-control pull-right">
                 </div>
                   <span class="text-danger text-capitalize"></span>
                 </div>
              </div>
              <div class="col-xs-12">
                 <label for="marks_obtained" class="control-label text-capitalize">marks obtained</label>
                 <div class="form-group">
                   <div class="input-group date full_width">
                    <input type="text" name="marks_obtained[]" class="form-control pull-right">
                 </div>
                   <span class="text-danger text-capitalize"></span>
                 </div>
              </div>

              <div class="col-xs-12">
                 <label for="percentage" class="control-label text-capitalize">Percentage</label>
                 <div class="form-group">
                   <div class="input-group date full_width" >
                    <input type="text" name="percentage[]" class="form-control pull-right">
                 </div>
                   <span class="text-danger text-capitalize"></span>
                 </div>
              </div>

               <div class="col-xs-12">
                  <label for="board" class="control-label text-capitalize">board</label>
                  <div class="form-group">
                    <select name="board" id="bor_01${i}" class="form-control">
                      <option value="">Select Board</option>

                    </select>
                    <span class="text-danger"></span>
                  </div>
                </div>

                 <div class="col-xs-12">
                   <label for="medium" class="control-label text-capitalize">medium</label>
                   <div class="form-group">
                     <select name="medium[]" id="med_01${i}" class="form-control">
                       <option value="">Select Medium</option>

                     </select>
                     <span class="text-danger"></span>
                   </div>
                 </div>


               <div class="col-xs-12">
                  <label for="stream" class="control-label text-capitalize">stream</label>
                  <div class="form-group">
                  <select name="stream[]" id="str_01${i}" class="form-control">
                    <option value="">Select Stream</option>

                  </select>
                    <span class="text-danger text-capitalize"></span>
                  </div>
               </div>

               <div class="col-xs-12">
                  <div class="form-group">
                  <input type="button" class="btn btn-danger full_width" data-eduEle="${i}" value="Delete"/>
                    <span class="text-danger text-capitalize"></span>
                  </div>
               </div>


            </div>
          </div>


      </div>
   </div>
     `
  );
}

$('[data-qua]').on('click', function(){
  var ele_len = $('.eduEleLen').length;
  $('#q1_epp0').append(ad_qualification(passyear,ele_len));
  qualification(ele_len);
  // board(ele_len);
  // mediam(ele_len);
  // stream(ele_len);
});


$(document).on('click', '[data-eduEle]', function(){
  var all_len = $('.eduEleLen').length;
  var ele_len = $(this).attr('data-eduEle');
  $('[data-educount'+ele_len+']').remove();
  var obj = $('.eduEleLen');
  // for (var i in obj) {
  //
  // }


});

  //passing year
  function passyear(){
    var selectList = [];
    for (var x = 1990; x < 2020; x++) {
        selectList += `<option>${x}</option>`;
    }
    return selectList;
  }

//qualification
      function qualification(i){
        $.ajax({
          url:base_url+'qualification',
          dataType:'json',
          method:'post',
          success:function(res){
            var option = [];
            res.forEach(function({qualification_name,qualification_id}){
              option += `<option value="${qualification_id}" >${qualification_name}</option>`;
            });
            $('#qu_01'+i).html(option);
          },
          error:function(res){
            console.log(res);
          }
        });
      }

//board
      function board(i){
        $.ajax({
          url:base_url+'board',
          dataType:'json',
          method:'post',
          success:function(res){
            var option = [];
            res.forEach(function({board_name,board_id}){
              option += `<option value="${board_id}" >${board_name}</option>`;
            });
            $('#bor_01'+i).html(option);
          },
          error:function(res){
            console.log(res);
          }
        });
      }


      //mediam
        function mediam(i){
          $.ajax({
            url:base_url+'mediam',
            dataType:'json',
            method:'post',
            success:function(res){
              var option = [];
              res.forEach(function({mediam_name,mediam_id}){
                option += `<option value="${mediam_id}" >${mediam_name}</option>`;
              });
              $('#med_01'+i).html(option);
            },
            error:function(res){
              console.log(res);
            }
          });
        }

//stream

      function stream(i){
        $.ajax({
          url:base_url+'stream',
          dataType:'json',
          method:'post',
          success:function(res){
            var option = [];
            res.forEach(function({stream_name,stream_id}){
              option += `<option value="${stream_id}" >${stream_name}</option>`;
            });
            $('#str_01'+i).html(option);
          },
          error:function(res){
            console.log(res);
          }
        });
      }
