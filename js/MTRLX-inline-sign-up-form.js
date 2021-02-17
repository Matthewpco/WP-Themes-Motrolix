jQuery(document).ready(function( $ ) {
  $('#mtrlx-inline-sign-up-form-inner').on('submit', function(e) {
    e.preventDefault();
    $('#mtrlx-inline-sign-up-form-status').html('');
    $('#mtrlx-inline-sign-up-form-submit').val('Please wait...');
    $('#mtrlx-inline-sign-up-form-submit').attr('disabled', true);
    var form = $(this)
    var nonce = $('input[name="mtrlx-inline-sign-up-form-nonce"]').val();
    jQuery.ajax({
     type : "post",
     dataType : "json",
     url : myAjax.ajaxurl,
     data : {
       action: "mtrlx_inline_sign_up_form_process",
       first_name: $('input[name="mtrlx-inline-sign-up-form-first-name"]').val(),
       last_name: $('input[name="mtrlx-inline-sign-up-form-last-name"]').val(),
       email: $('input[name="mtrlx-inline-sign-up-form-email"]').val(),
       nonce: nonce
     },
     success: function(response) {
        if(response.success) {
           $('#mtrlx-inline-sign-up-form-status').html('Thank you. You have been subscribed to GM Authority!');
           $('#mtrlx-inline-sign-up-form-submit').val('Sign Up');
           $('#mtrlx-inline-sign-up-form-submit').attr('disabled', false);
        }
        else {
           $('#mtrlx-inline-sign-up-form-status').html('There was an error. Please try again');
           $('#mtrlx-inline-sign-up-form-submit').val('Sign Up');
           $('#mtrlx-inline-sign-up-form-submit').attr('disabled', false);
        }
        console.log(response);
     },
     error: function(XMLHttpRequest, textStatus, errorThrown) {
       console.log(errorThrown);
     }
  })
  });
});
