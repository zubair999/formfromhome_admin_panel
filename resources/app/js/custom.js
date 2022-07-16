var base_url = location.origin;

const loader = () =>{
  return (
    `<div class="holder" id="holder">
        <div class="loader"></div>
      </div>
    `
  );
};

const status_message = (message, alink, $page_title) => {
  return (
    `
      <div class="container p-0">
      <h4 class="text-center p-0 m-0 loq_2e4">${$page_title}</h4>
        <div class="row">
          <div class="col-xs-12 m-0 p-0">
            <ul class="cvo_w9"><li class="text-capitalize ">${message}</li></ul>
          </div>
          <h6 class="text-center"><a class="btn btn-primary" href=${base_url + alink}>Click Here</a></h6>
        </div>
      </div>
    `
  );
}

const showLoader = () => {
  $('#holder').css('display', 'block');
  $('#holder').css('z-index', '11');
};
const hideLoader = () => {
  $('#holder').css('display', 'none');
};

const add_to_cart = (ei) => {
  return (
    `
      <div class="row">
        <div class="col-xs-12">
          <a data-add_exam_cart="${ei}" class="btn btn-primary full_width">Add To Cart</a>
        </div>
      </div>
    `
  );
};
const back = () => {
  return (
    `
      <div class="row mb">
        <div class="col-xs-12">
          <a id="w2e3_yt" class="btn btn-primary full_width">Go Back</a>
        </div>
      </div>
    `
  );
};
const exam_charge_section = (fo,sc,category) => {
  return (
    `
      <div class="row">
        <div class="col-xs-12">
          <table>
            <thead>
              <tr>
                <th style="font-size:18px;color:#000!important;font-weight:600">Exam Fee: (${category}) <p><small>Your category is ${category}</small></p></th>
                <td style="font-size:18px;color:#000!important;font-weight:600">${fo.exam_fee}</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th style="font-size:18px;color:#000!important;font-weight:600">Service Charge(Extra): <p><small>This is FormFromHome Service Charge</small></p></th>
                <td style="font-size:18px;color:#000!important;font-weight:600">${parseFloat(sc)}.00</td>
              </tr>
              <tr>
                <th style="font-size:18px;color:#000!important;font-weight:600">Total Charge: </th>
                <td style="font-size:18px;color:#000!important;font-weight:600">${parseFloat(fo.exam_fee)+parseFloat(sc)}.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    `
  );
};

//add document

const add_document = (i) => {
  return (
    `
       <div class="col-xs-12 docLen" style="margin:10px 0">
         <label for="document_img${i}" class="control-label text-capitalize"><span class="text-danger">* </span>Upload Document Copy</label>
         <div class="form-group">
            <input type="file" name="document_img${i}" id="yue_op87${i}" required/>
            <span class="text-danger text-capitalize"></span>
         </div>
       </div>
    `
  );
}

//add certicifacte
const add_certificate = (i) => {
  return(
    `
    <div class="col-xs-12 cerlen" style="margin:10px 0">
      <label for="certificate_img${i}" class="control-label text-capitalize"><span class="text-danger">* </span>Upload Document Copy</label>
      <div class="form-group">
         <input type="file" name="certificate_img${i}" id="yue_op87${i}" required/>
         <span class="text-danger text-capitalize"></span>
      </div>
    </div>
    `
  );
}


const notification = (noti) => {
  const showNoti = (n) =>{
    return (
      `
      <div class="warningMsg">
          <p style="text-transform:capitalize;">${n}</p>
      </div>
      `
    );
  }
  $('#notiO_9o').html(showNoti(noti));
  $('.warningMsg').css('display', 'flex');
  setTimeout(function(){
    $('.warningMsg').css('display', 'none');
  }, 6000);
}

$('[data-addDocument]').on('click', function(){
  var doc_len = $('.docLen').length;
  $('#gt_0poi').append(add_document(doc_len));
});

$('[data-addcertificate]').on('click',function(){
  var cer_len = $('.cerlen').length;
  $('#ct_0poi').append(add_certificate(cer_len));

});

$(document).on('click', '[data-add_exam_cart]', function(){
  var exam_id = $(this).attr('data-add_exam_cart');
  $.ajax({
    url:base_url+'save-item-to-cart',
    method:'post',
    dataType:'json',
    data:{
      exam_id:exam_id
    },
    beforeSend:function(){

    },
    success:function(res){
      if(res.status === 200){
        notification(res.message);
      }
      else if(res.status === 422){
        notification(res.message);
      }
      else if(res.status === 400){
        notification(res.message);
      }
      else if(res.status === 101){
        notification(res.message);
      }
    },
    error:function(res){
      console.log(res);
    }
  });
});

const get_exam = () => {
  $.ajax({
    url:base_url+'exam',
    method:'post',
    dataType:'json',
    beforeSend:function(){
      showLoader();
    },
    success:function(res){
      hideLoader();
      if(res.status === 200){
        const exam = (components) => {
          return (
            `
              <div class="container p-0">
              <h4 class="text-center p-0 m-0 loq_2e4">Current Exam</h4>
                <div class="row">
                  <div class="col-xs-12 m-0 p-0">
                    <ul class="cvo_w9">${components}</ul>
                  </div>
                </div>
              </div>
            `
          );
        }
        var li = [];
        res.message.forEach(function({name_of_post, exam_idId}){
          li += `<li data-nameOfExam=${exam_idId}>${name_of_post}</li>`;
        });
        $('#root').html(exam(li));
      }
      else if(res.status === 101){
        $('#root').html(status_message(res.message, res.alink, res.page_title));
      }
      else if(res.status === 102){
        $('#root').html(status_message(res.message, res.alink, res.page_title));
      }
    },

    error:function(res){
      console.log("error");
      console.log(res);
    }
  });
}


$('[data-cart_delete_item]').on('click', function(){
  var cart_item = $(this).attr('data-cart_delete_item');
  $.ajax({
    url:base_url+'delete-item',
    method:'post',
    dataType:'json',
    data:{
      cart_item:cart_item
    },
    beforeSend:function(){

    },
    success:function(res){
      if(res.status === 200){
        window.open(base_url+'cart','_self');
        notification('Item deleted');
      }
      else if(res.status === 404){
        notification('action not valid');
      }
      else if(res.status === 422){
        notification('action not valid');
      }
    },
    error:function(res){
      console.log(res)
    }
  });
});


const notification_listing = (components) => {
  return (
    `
    <div class="root">
      <div class="container p-0">
        <h4 class="text-center p-0 m-0 loq_2e4 text-capitalize"><?= $page_title.' ['.$notificationCount.']'; ?> </h4>
        <div class="row mb">
          <div class="col-xs-12 m-0 p-0">

              <table class="rml_12">
                <thead>
                  <tr>
                    <th>form</th>
                    <th colspan="2" style="text-align:center">status</th>
                  </tr>
                </thead>
                <tbody>
                  ${components}
                </tbody>
              </table>

          </div>
        </div>
      </div>
    </div>
    `
  );
}

$('[data-show_notification]').on('click', function(){
  console.log("clicked");
  $.ajax({
    url:base_url+'get-notification',
    method:'post',
    dataType:'json',
    beforeSend:function(){
      showLoader();
    },
    success:function(res){
      // console.log(res.message);
        hideLoader();
        var tr = [];
        res.message.forEach(function({name_of_post}){
          tr += `<tr>
                      <td>${name_of_post}</td>
                      <td><span class="text-success">Form Filled<br>Check Email</span></td>
                </tr>`
        });

      const noti = (tr) =>{
        return (
                `
                  <div class="container p-0">
                      <h4 class="text-center p-0 m-0 loq_2e4">Notification</h4>
                        <div class="row">
                          <div class="col-xs-12 m-0 p-0">
                            <table>
                                ${tr}
                            </table>
                          </div>
                        </div>
                      </div>
                `
              );
      }
      $('#root').html(noti(tr));
    },
    error:function(res){
      console.log("error");
      console.log(res);
    }
  });
});

window.addEventListener('load', function(){
  get_exam();
});

$(document).on('click', '#w2e3_yt', function(){
  get_exam();
});

function calPercent(){
  var total = parseFloat($('#oytpO').val());
  var obtained = parseFloat($('#BnUyp').val());
  console.log(total);
  if(isNaN(total)){
    total = 0;
  }
  if(isNaN(obtained)){
    obtained = 0;
  }
  if(total<0){
    total = Math.abs($('#oytpO').val());
    $('#oytpO').val(total);
  }
  if(obtained<0){
    obtained = Math.abs($('#BnUyp').val());
    $('#BnUyp').val(obtained);
  }

  var per = (obtained*100/total).toFixed(2);
  $('#percent').val(per);
}

$(document).on('click', '[data-nameOfExam]', function(){
  var exam_id = $(this).attr('data-nameOfExam');
  $.ajax({
    url:base_url+'detail',
    method:'post',
    dataType:'json',
    data:{
      exam_id:exam_id
    },
    beforeSend:function(){
      showLoader();
    },
    success:function(res){
      var content_obj = res.content[0];
      var fee_obj = res.exam_charge;
      var service_charge_obj = res.service_charge;
      $('#holder').css('display', 'none');
      const exam = (co) => {
        return (
          `
          <div class="container p-0">
          <h4 class="text-center p-0 m-0 loq_2e4">${co.name_of_post}</h4>
            <div class="row">
              <div class="col-xs-12 m-0">
                <ul class="cvo_w9">
                  <li style="color:red"><strong style="color:#000">Post Date:</strong> ${co.post_date}</li>
                  <li style="color:red"><strong style="color:#000">Last Date:</strong> ${co.last_date}</li>
                  <li style="color:red"><strong style="color:#000">Short Info:</strong> ${co.short_info}</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row q1_we34">
            <div class="c2_1q2">
              ${co.content}
            </div>
          </div>
          ${exam_charge_section(fee_obj, service_charge_obj, res.category)}
          ${add_to_cart(co.exam_idId)}
          ${back()}
          `
        );
      };

      $('#root').html(exam(content_obj));
    },
    error:function(res){
      console.log(res);
    }
  });
});

$("#iframeCertifate").contents().find("img").css({
    'width': '100%',
    'overflow': 'hidden',
});

const App = () =>{
  $('#root').html();
}

App();
