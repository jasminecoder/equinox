
/*========== CLOSE MOBILE MENU ON CLICK & SMOOTH SCROLL TO LINK a[href^="#"] ==========*/
$(document).on('click', 'a[href^="#"]', function (event) {
    // event.preventDefault();
    $('.navbar-toggler').addClass('collapsed');
    $('#navbarResponsive').removeClass('show');

    // setTimeout(function () {
    //     $('nav.navbar').removeClass('solid-toggle');
    // }, 300);

    // $('html, body').animate({
    //     scrollTop: $($.attr(this, 'href')).offset().top
    // }, 1000);
});



/*========== CONTACT FORM INPUT VALIDATION ==========*/
//Original Resource: https://bootstrapious.com/p/how-to-build-a-working-bootstrap-contact-form
$(function () {

    // init the validator
    // validator files are included in the download package
    // otherwise download from http://1000hz.github.io/bootstrap-validator
  
    $('#contact-form').validator();
  
  
    // when the form is submitted
    $('#contact-form').on('submit', function (e) {
  
        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var url = "contact/gmail-contact.php";
  
            // POST values in the background the the script URL
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data) {
                    // data = JSON object that contact.php returns
  
                    // we recieve the type of the message: success x danger and apply it to the
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;
  
                    // let's compose Bootstrap alert box HTML
                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
  
                    // If we have messageAlert and messageText
                    if (messageAlert && messageText) {
                        // inject the alert to .messages div in our form
                        $('#contact-form').find('.messages').html(alertBox);
                        // empty the form
                        $('#contact-form')[0].reset();
                    }
                }
            });
            return false;
        }
    })
  });
