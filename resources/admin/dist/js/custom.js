$(document).ready(function($) {

  var base_url = location.origin + '/';

   tinymce.init({
            selector: '#examFormContent',
            height: 400,
            plugins: [
                'advlist autolink lists link charmap print preview hr pagebreak',
                'searchreplace  fullscreen',
                'insertdatetime nonbreaking save table contextmenu directionality',
                'emoticons paste textcolor colorpicker textpattern imagetools'
            ]
        });

   const renderModal = (components) =>{
        const show_modal = () =>{
        return (
                `<div id="modal-container">
                  <div class="modal-background">

                    <div class="row modal lio_yu ov_s01">
                    <div id="closeModal" class="closeModal">x</div>
                        ${components}
                        </div>
                        <svg class="modal-svg" +xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none">
                            <rect x="0" y="0" fill="none" width="226" height="162" rx="3" ry="3"></rect>
                        </svg>
                    </div>
                 </div>
                </div>`
                );
        };

        $('body').append(show_modal());
        $('#modal-container').removeAttr('class').addClass('one');
        $('body').addClass('modal-active');
        $('body').css('margin-right', '16px');
    }

    $(document).on('click', '.showModal', function(){
      console.log("clicked");
        var exam = $(this).attr('data-exam');
        $.ajax({
            url:base_url+'exam-detail',
            method:'post',
            dataType:'json',
            data:{
                exam:exam
            },
            success:function(response){
                console.log(response);
                var  component = `<h3 class="col-md-12">${response.content.name_of_post}</h3>
                                    <p>Post Date:${response.content.post_date}, Last Date:${response.content.last_date}</p>
                                    <div id="boxy" class="kpo_ui">
                                        <div class="n1q_u">
                                            ${response.content.content}
                                        </div>
                                        `;
                renderModal(component);
              },
            error:function(response){
                // console.log(response);

            }
        });


       // renderModal("hi");
    });


    $(document).on('click', '#closeModal', function(){
       $('#modal-container').addClass('out');
       $('body').removeClass('modal-active');
       $('body').css('margin-right', '0');
       setTimeout(function(){
         $('#modal-container').remove();
       },800);
    });

    $(document).on('click','.showstudentmodel',function(){

        var student = $(this).attr('data-student');
        console.log(student);
        //console.log('sss');

        $.ajax({
            url:base_url+'student-details',
            method:'post',
            dataType:'json',
            data:{
                student:student
            },
            success:function(response){
                //console.log(response.message);
                if(response.status === 200){
                    renderModal(response.message);
                     console.log(response.message);
                }
                else if(response.status === 422){
                    console.log(response.message);
                }
            },
            error:function(response){
                console.log(response);
            }

        });
    });

    $(document).on('click','.cateId', function(){
      var category_id = $(this).attr('data-cateid');
      console.log(category_id);
      var obj = $('  [data-feeObj = ' + category_id + ' ]');

      if($(this).is(':checked')){
        obj.removeAttr('readonly');
      }
      else{
        console.log("tr must be romoved");
        obj.prop('readonly', true);
        obj.val(0);
      }
    });


    $(document).on('click','.create_category', function(){
      var category_id = $(this).attr('data-cateid');
      var category_name = $(this).attr('data-catename');

      if($(this).is(':checked')){
        $('#category_fee_tbl tbody').append(
          $('<tr data-row='+category_id+' >')
          .append($('<td>').append(category_name))
          .append($('<td style="width:84px"><input type="checkbox" name="category_id[]" value='+category_id+' class="cateId smallInputQty" data-cateid='+category_id+'>').append(''))
          .append($('<td style="width:84px"><input autocomplete="off" type="text" name="exam_fee[]" min="0" class="smallInputQty mobInptWidth"  data-feeObj='+category_id+' readonly >').append(''))
        );
      }
      else{
        $('[data-row='+category_id+']').remove();
      }


      $('[data-feeObj]').on('keyup', function(){
        var fee = parseFloat($(this).val());
        var n = fee.toString();
        //console.log(fee);
          if(fee < 0){
            fee = Math.abs(fee);
            $(this).val(fee);
          }
          else if(n.match(/[A-Za-z+#.@!^&*(|?/}>":(<{"]/)){
              $(this).val(0);
            //  console.log('ssss');

          }
            else if(n.match(/[A-Za-z]/)){
            $(this).val(0);
            //valid float
        }
        //else if(n)
      });


});

  $(document).on('click','.changestatus', function(){
      var id = $(this).attr('data-status');
      $.ajax({
        url:base_url+'application-status',
        method:'post',
        data:{
              ap_id:id
        },
        success:function(response){
          window.open(base_url + 'application-view','_self');
        },
        error:function(response){
          console.log(response);
        },
      })
  });

  $(document).on('click','[data-approved]',function(){
    console.log('ssss');
      var a_id =  $(this).attr('data-approved');
      $.ajax({
        url:base_url+'app-info',
        dataType:'json',
        method:'post',
        data:{
          a_id:a_id
        },
        success:function(response){
          console.log(response);
          var component = `<h3 class="col-md-12">This form filled by ${response.content.name} and
                                email by ${response.content.name} </h3>
                                <p>Exam: ${response.content.name_of_post}</p>
                                <p>Student Name: ${response.content.name_of_post}</p>
                                `;
          renderModal(component);
        },
        error:function(response){
          console.log(response);
        }
      });
  });



  // $(document).on('click','[data-stuinfo]',function(){
  //   console.log("clicked");
  //   var stuid = $(this).attr('data-stuinfo');
  //   $.ajax({
  //       url:base_url+'student-info',
  //       dataType:'json',
  //       method:'post',
  //       data:{
  //         stu_id:stuid
  //       },
  //       success:function(response){
  //         console.log(response);
  //         var si = response.info;
  //         var ac = response.academic;
  //         var cer = response.certificate;
  //         const show_marksheet = () =>{
  //             return (
  //               `
  //               <div class="shw_mak01" id="shw_mak01">
  //               <span id="c_Modal" class='closeModal'>x</span>
  //               <div class="mwp_r"></div>
  //               </div>
  //               `
  //             );
  //         };

  //         const certificate =(cer) =>{
  //           if(cer === false){
  //             return `<div style="color:red;text-decoration:underline">No certificate uploaded yet.</div>`
  //           }
  //           else{
  //               var cer_t = [];
  //               cer.forEach(function(c){
  //               cer_t += `
  //                         <tr>
  //                         <td class="stu_021 text-capitalize set-011" style="width:0px;">
  //                         <a href="${base_url}uploads/certificates/${c.certificate_img}" download >
  //                         <div class="cert-09">${c.certificate_name}</div>
  //                         <img src="${base_url}uploads/certificates/${c.certificate_img}" title="Download">
  //                         download</a>
  //                         </td>
  //                         </tr>
  //                       `;
  //             });  `<tr></tr>`
  //             return cer_t;
  //           }
  //         }
  //         const info = (si) => {
  //           return (
  //             `<div class="col-xs-12">
  //             <div class="col-xs-8">
  //             <table class="table table-bordered stu-info-01 tblt-se-01">
  //                   <tr>
  //                     <th class="stu_021 text-capitalize text-center" style="font-size:30px;">personal information</th>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">student name</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText1">${si.student_name.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn1"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">date of birth</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText2">${si.dob}<div></td>
  //                     <td><button class="copyText" id="copytextBtn2"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">email</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText3">${si.user_name}<div></td>
  //                     <td><button class="copyText" id="copytextBtn3"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">category</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText4">${si.category_name.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn4"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">house no</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText5">${si.house.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn5"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">block</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText6">${si.block.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn6"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">district</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText7">${si.district.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn7"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">state</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText8">${si.state.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn8"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">pincode</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText9"${si.pincode}<div></td>
  //                     <td><button class="copyText" id="copytextBtn9"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>

  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">locality</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText10"${si.locality.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn10"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">full address</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText11">${si.address.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn11"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">father name</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText12">${si.father_name.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn12"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //                   <tr>
  //                     <th class="stu_021 text-capitalize">mother name</th>
  //                     <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText13">${si.mother_name.toUpperCase()}<div></td>
  //                     <td><button class="copyText" id="copytextBtn13"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //                   </tr>
  //             </table>
  //             </div>

  //             <div class="col-xs-4">
  //             <div class="col-xs-12">
  //             <table class="table table-bordered stu-info-01 tblt-se-01">
  //             <tr>
  //             <td>photo</td>
  //             <td>signature</td>
  //             <td>thumb impression</td>
  //             </tr>
  //             <tbody>
  //                 <tr>

  //                     <td class="stu_021 text-capitalize set-011" style="width:0px;">
  //                       <a href="${base_url}uploads/student/${si.student_img}" download >
  //                       <img src="${base_url}uploads/student/${si.student_img}" title="Download">
  //                         download
  //                       </a>
  //                     </td>

  //                     <td class="stu_021 text-capitalize set-011" style="width:0px;">
  //                       <a href="${base_url}uploads/student/${si.signature_img}" download >
  //                       <img src="${base_url}uploads/student/${si.signature_img}" title="Download">
  //                         download
  //                       </a>
  //                     </td>

  //                     <td class="stu_021 text-capitalize set-011" style="width:0px;">
  //                       <a href="${base_url}uploads/student/${si.thumb_img}" download >
  //                       <img src="${base_url}uploads/student/${si.thumb_img}" title="Download">
  //                         download
  //                       </a>
  //                     </td>

  //                 </tr>
  //                 <tr><td>Download Document</td></tr>
  //             </tbody>
  //             </table>
  //             </div>
  //             <div class="col-xs-12">
  //             <table class="table table-bordered stu-info-01 tblt-se-01" style="height:325px;display:block;overflow:scroll;">
  //             <tr>
  //             <td colspan="1">certificates</td>
  //             </tr>
  //             <tbody>
  //               ${certificate(cer)}
  //             </tbody>
  //             </table>
  //             </div>
  //             </div>

  //             </div>
  //             `
  //           );
  //         }

  //         var a_info = [];
  //         ac.forEach(function(ac){
  //           var docu = ac.document;
  //           var d_info = [];
  //           //  docu.forEach(function(item){
  //           //     d_info += `<tr>
  //           //                 <th class="stu_021 text-capitalize">document</th>
  //           //                 <td class="stu_021 text-capitalize"><button class="btn btn-primary" data-document="${item.marksheet_img}" >view document</button></td>
  //           //                 </tr>`

  //           // });

  //           a_info += `<tbody>
  //               <tr>
  //                 <th colspan="2" class="text-center text-capitalize" style="font-size:30px;">${ac.qualification_name}</th>
  //               </tr>
  //               <tr>
  //                 <th class="stu_021 text-capitalize">passing year</th>
  //                 <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText14">${ac.passing_year}</div></td>
  //                 <td><button class="copyText" id="copytextBtn14"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //               </tr>
  //               <tr>
  //                 <th class="stu_021 text-capitalize">board</th>
  //                 <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText15">${ac.board_name.toUpperCase()}</div></td>
  //                 <td><button class="copyText" id="copytextBtn15"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //               </tr>
  //               <tr>
  //                 <th class="stu_021 text-capitalize">total marks</th>
  //                 <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText16">${ac.total_marks}</div></td>
  //                 <td><button class="copyText" id="copytextBtn16"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //               </tr>
  //               <tr>
  //                 <th class="stu_021 text-capitalize">obtained marks</th>
  //                 <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText17">${ac.marks_obtained}</div></td>
  //                 <td><button class="copyText" id="copytextBtn17"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //               </tr>
  //               <tr>
  //                 <th class="stu_021 text-capitalize">percentage</th>
  //                 <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText18">${ac.percentage}</div></td>
  //                 <td><button class="copyText" id="copytextBtn18"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //               </tr>
  //               <tr>
  //                 <th class="stu_021 text-capitalize">mediam</th>
  //                 <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText19">${ac.mediam_name.toUpperCase()}</div></td>
  //                 <td><button class="copyText" id="copytextBtn19"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //               </tr>
  //               <tr>
  //                 <th class="stu_021 text-capitalize">stream</th>
  //                 <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText20">${ac.stream_name.toUpperCase()}</div></td>
  //                 <td><button class="copyText" id="copytextBtn20"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //               </tr>
  //               <tr>
  //                 <th class="stu_021 text-capitalize">extra info</th>
  //                 <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText21">${ac.extra_info.toUpperCase()}</div></td>
  //                 <td><button class="copyText" id="copytextBtn21"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
  //               </tr>
  //             </tbody>`
  //         });

  //         const student_profile = () => {
  //           return (
  //             `
  //             <div class="cvb1_we">
  //               ${info(si)}
  //               <div class="cer-01"></div>
  //               <table class="table table-bordered tblt-se-01">${a_info}</table>
  //               ${show_marksheet()}
  //             </div>



  //             `
  //           );
  //         }

  //         var  component = `<h3 class="col-md-12"></h3>
  //                             <p>Student Profile</p>
  //                             <div id="boxy" class="kpo_ui">
  //                                 <div class="n1q_u">
  //                                     ${student_profile()}
  //                                 </div>
  //                                 `;
  //         renderModal(component);

  //       },
  //       error:function(response){
  //         console.log(response);
  //       }
  //   });
  // });


  $(document).on('click','[data-document]',function(){
    var doc_name = $(this).attr('data-document');
    $('.shw_mak01').css('display','block');
    $('.mwp_r').html('<a href='+base_url+'uploads/marksheet/'+doc_name+' download><img src='+base_url+'uploads/marksheet/'+doc_name+'></a>');
  });

  $(document).on('click', '#c_Modal', function(){
     $('#shw_mak01').css('display', 'none');
  });



        var clipboard = new ClipboardJS('#copytextBtn1', {
            target: function() {
                return document.querySelector('#copyText1');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn2', {
            target: function() {
                return document.querySelector('#copyText2');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn3', {
            target: function() {
                return document.querySelector('#copyText3');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn4', {
            target: function() {
                return document.querySelector('#copyText4');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn5', {
            target: function() {
                return document.querySelector('#copyText5');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn6', {
            target: function() {
                return document.querySelector('#copyText6');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn7', {
            target: function() {
                return document.querySelector('#copyText7');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn8', {
            target: function() {
                return document.querySelector('#copyText8');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn9', {
            target: function() {
                return document.querySelector('#copyText9');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn10', {
            target: function() {
                return document.querySelector('#copyText10');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn11', {
            target: function() {
                return document.querySelector('#copyText11');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn12', {
            target: function() {
                return document.querySelector('#copyText12');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn13', {
            target: function() {
                return document.querySelector('#copyText13');
            }
        });

       var clipboard = new ClipboardJS('#copytextBtn14', {
            target: function() {
                return document.querySelector('#copyText14');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn15', {
            target: function() {
                return document.querySelector('#copyText15');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn16', {
            target: function() {
                return document.querySelector('#copyText16');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn17', {
            target: function() {
                return document.querySelector('#copyText17');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn18', {
            target: function() {
                return document.querySelector('#copyText18');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn19', {
            target: function() {
                return document.querySelector('#copyText19');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn20', {
            target: function() {
                return document.querySelector('#copyText20');
            }
        });

        var clipboard = new ClipboardJS('#copytextBtn21', {
            target: function() {
                return document.querySelector('#copyText21');
            }
        });

        $("#iframeCertifate").contents().find("img").css({
            'width': '100%',
            'height': '100%'
        });

//MAIN CLOSE
});
