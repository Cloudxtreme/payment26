$(function () {
  $('[data-toggle="popover"]').popover({html:true,placement:"bottom"}); // enable popovers
  $("#no-thanks").click(function(){
      $('#send-ecard').hide();
      $('#mail-card').hide();
  });

  $("#yes-mail-card").click(function(){
      $('#send-ecard').hide();
      $('#mail-card').show();
  });

  $("#yes-send-ecard").click(function(){
      $('#send-ecard').show();
      $('#mail-card').hide();
  });

  $("#card-destination-2").click(function(){
      $('#tribute-card-me').show();
  });
  $("#card-destination-1").click(function(){
      $('#tribute-card-me').hide();
  });

  $("#monthly_donation").click(function(){
    if( $('#monthly_donation').is(':checked') ) {
      $('p.amttimes').text("MONTHLY DONATION");
    } else{
      $('p.amttimes').text("ONE-TIME DONATION");
    }
  });

  $("#tribute_show_honor").click(function(){
    if( $('#tribute_show_honor').is(':checked') ) {
      $('#tribute_honoree_name_row').show();
    } else {
      $('#tribute_honoree_name_row').hide();
    }
  });

  $(".btn-value").click(function(){
    if(this.value){
      $('#cont-don-amount').hide();
    } else {
      $('#cont-don-amount').show();
    }
    $("#donation_amount").val(this.value);
    $("button.btn-value").removeClass("btn-value-selected");
    $(this).addClass("btn-value-selected");
    changeText();
  });

  $("#donation_amount").bind('input change',changeText);

  function changeText(){
    var val = $("#donation_amount").val();
    if (val === "")
      val = "0.00";

    var str= "$ " + val;

    $('p.amtmonies').text(str);
  }


});

$(document).ready(function() {
  $('#payment-form').bootstrapValidator({
    message: 'This value is not valid',
    feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    submitHandler: function(validator, form, submitButton) {
      // createToken returns immediately - the supplied callback submits the form if there are no errors
      Stripe.card.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-expiry-month').val(),
          exp_year: $('.card-expiry-year').val(),
      		name: $('.card-holder-name').val()+' '+$('.card-holder-surname').val(),
      		address_line1: $('.address').val(),
      		address_city: $('.city').val(),
      		address_zip: $('.zip').val(),
      		address_state: $('.state').val(),
      		address_country: $('.country').val()
      }, stripeResponseHandler);
      return false; // submit from callback
    },
    fields: {
      street: {
          validators: {
              notEmpty: {
                  message: 'The street is required and cannot be empty'
              },
		          stringLength: {
                  min: 6,
                  max: 96,
                  message: 'The street must be more than 6 and less than 96 characters long'
              }
          }
      },
      city: {
          validators: {
              notEmpty: {
                  message: 'The city is required and cannot be empty'
              }
          }
      },
      zip: {
          validators: {
              notEmpty: {
                  message: 'The zip is required and cannot be empty'
              },
	    stringLength: {
                  min: 3,
                  max: 9,
                  message: 'The zip must be more than 3 and less than 9 characters long'
              }
          }
      },
      email: {
        validators: {
              notEmpty: {
                  message: 'The email address is required and can\'t be empty'
              },
              emailAddress: {
                  message: 'The input is not a valid email address'
              },
		    stringLength: {
                  min: 6,
                  max: 65,
                  message: 'The email must be more than 6 and less than 65 characters long'
              }
          }
      },
      cardholdername: {
          validators: {
              notEmpty: {
                  message: 'The card holder name is required and can\'t be empty'
              },
		  stringLength: {
                  min: 2,
                  max: 70,
                  message: 'The card holder name must be more than 2 and less than 70 characters long'
              }
          }
      },
      cardholdersurname: {
          validators: {
              notEmpty: {
                  message: 'The card holder surname is required and can\'t be empty'
              },
      stringLength: {
                  min: 2,
                  max: 70,
                  message: 'The card holder surname must be more than 2 and less than 70 characters long'
              }
          }
      },
      cardnumber: {
        selector: '#cardnumber',
        validators: {
          notEmpty: {
            message: 'The credit card number is required and can\'t be empty'
          },
          creditCard: {
            message: 'The credit card number is invalid'
          },
        }
      },
      phone: {
        selector: '#phone',
        validators: {
          notEmpty: {
            message: 'The phone number is required and can\'t be empty'
          },
        stringLength: {
                          min: 6,
                          max: 30,
                          message: 'The phone number must be more than 6 and less than 30 characters long'
                      }
        }
      },
      expMonth: {
        selector: '[data-stripe="exp-month"]',
        validators: {
          notEmpty: {
              message: 'The expiration month is required'
          },
          digits: {
              message: 'The expiration month can contain digits only'
          },
          callback: {
            message: 'Expired',
            callback: function(value, validator) {
              value = parseInt(value, 10);
              var year         = validator.getFieldElements('expYear').val(),
                  currentMonth = new Date().getMonth() + 1,
                  currentYear  = new Date().getFullYear();
              if (value < 0 || value > 12) {
                  return false;
              }
              if (year == '') {
                  return true;
              }
              year = parseInt(year, 10);
              if (year > currentYear || (year == currentYear && value > currentMonth)) {
                  validator.updateStatus('expYear', 'VALID');
                  return true;
              } else {
                  return false;
              }
            }
          }
        }
      },
      expYear: {
        selector: '[data-stripe="exp-year"]',
        validators: {
          notEmpty: {
              message: 'The expiration year is required'
          },
          digits: {
              message: 'The expiration year can contain digits only'
          },
          callback: {
            message: 'Expired',
            callback: function(value, validator) {
              value = parseInt(value, 10);
              var month        = validator.getFieldElements('expMonth').val(),
                  currentMonth = new Date().getMonth() + 1,
                  currentYear  = new Date().getFullYear();
              if (value < currentYear || value > currentYear + 100) {
                  return false;
              }
              if (month == '') {
                  return false;
              }
              month = parseInt(month, 10);
              if (value > currentYear || (value == currentYear && month > currentMonth)) {
                  validator.updateStatus('expMonth', 'VALID');
                  return true;
              } else {
                  return false;
              }
            }
          }
        }
      },
      cvv: {
        selector: '#cvv',
        validators: {
          notEmpty: {
            message: 'The cvv is required and can\'t be empty'
          },
          cvv: {
            message: 'The value is not a valid CVV',
            creditCardField: 'cardnumber'
          }
        }
      },
    }
  });
  var select = $(".card-expiry-year"),
  year = new Date().getFullYear();

  for (var i = 0; i < 12; i++) {
      select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
  }

  $("a[data-option='US']").trigger("click");
  $("#billing-details > fieldset > div:nth-child(1) > div > div > div > a > span.bfh-selectbox-option").append('<span style="color:red; float:right;">CHANGE COUNTRY</span>');
});

// this identifies your website in the createToken call below
Stripe.setPublishableKey('pk_test_Fn23ogInSLReU7YxlCJc7Hl9');

function stripeResponseHandler(status, response) {
    $('#subscriber_country[type="hidden"]').val($('.bfh-countries input[type="hidden"]').val());
    if (response.error) {
      // re-enable the submit button
      $('.submit-button').removeAttr("disabled");
      // show hidden div
      document.getElementById('a_x200').style.display = 'block';
      // show the errors on the form
      $(".payment-errors").html(response.error.message);
    }
    else {
      var form$ = $("#payment-form");
      // token contains id, last4, and card type
      var token = response['id'];
      // insert the token into the form so it gets submitted to the server
      form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
      //set country field id
      // and submit
      //console.log($('#subscriber_country[type="hidden"]').val());
      form$.get(0).submit();
    }
}
