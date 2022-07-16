jQuery(document).ready(function($) {
   $('.enquiryForm').on('click', function() {
      $('#myModal').css('display', 'block');
      var imgName = $(this).attr('data-imgName');
      var productName = $(this).attr('data-productName').toUpperCase();
      var productId = $(this).attr('data-productId');
      $('#productEnquiryId').val(productId);
      $('#productName').val(productName);
      var url = location.origin + '/daduindia1/resources/layouts/images/' + imgName;
      $('#productImgWrapper').empty();
      $('#productImgWrapper').append('<img src="' + url + '">');
      $('#textcont').val('I am interested in ' + '"' + productName + '"' + '. Please send details & quotations.');

   });

   $('.close').on('click', function() {
      $('#myModal').css('display', 'none');
   });



   $('.enquiryBtn').on('click', function(e) {
      var companyName = $('#companyName').val();
      var email = $('#email').val();
      var message = $('#textcont').val();
      var phone = $('#phoneNo').val();
      e.preventDefault();

      $.ajax({
         url: location.origin + '/daduindia1/product/enquiry',
         method: 'post',
         data: {
            companyName: companyName,
            email: email,
            message: message,
            phoneNo: phone
         },
         success: function(response) {
            $('#showError').html(response);
            response = jQuery.parseJSON(response);
            console.log(response['companyName']);
            // for (var i in response) {
            //    $('#companyName').val(response[i].companyName);
            //    $('#email').val(response[i].email);
            // }
         }
      });

      // STOP SUBMITTING FORM
      return false;
   });

   // MAIN ENDS
});