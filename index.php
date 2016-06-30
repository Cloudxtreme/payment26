<?php
  require 'lib/Stripe.php';
  if ($_POST) {

    Stripe::setApiKey("sk_test_IUz6zrnBkj94Rheo7LpYIKXx");
    $error = '';
    $success = '';

    try {
    if (empty($_POST['street']) || empty($_POST['city']) || empty($_POST['zip']))
        throw new Exception("Fill out all required fields.");
      if (!isset($_POST['stripeToken']))
        throw new Exception("The Stripe Token was not generated correctly");
      Stripe_Charge::create(array("amount" => 3000,
                                  "currency" => "eur",
                                  "card" => $_POST['stripeToken'],
                  "description" => $_POST['email']));
      $success = '<div class="alert alert-success">
                  <strong>Success!</strong> Your payment was successful.
          </div>';
    }
    catch (Exception $e) {
    $error = '<div class="alert alert-danger">
          <strong>Error!</strong> '.$e->getMessage().'
          </div>';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Payment Form</title>

    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,100,300,500,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-min.css">
    <link rel="stylesheet" href="css/bootstrap-formhelpers-min.css" media="screen">
    <link rel="stylesheet" href="css/bootstrapValidator-min.css"/>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" />
    <link rel="stylesheet" href="css/bootstrap-side-notes.css" />
    <link rel="stylesheet" type="text/css" href="css/payment.css">

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap-min.js"></script>
    <script src="js/bootstrap-formhelpers-min.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator-min.js"></script>
    <script type="text/javascript" src="js/payment.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-lg-4 col-xs-12">
          <div class="sidebar_donate">
            <p><strong>DONATE BY PHONE</strong></p>
            <p>1-877 GO KOMEN <br>(1-877-465-6636, option 4)</p>
          </div>
        </div>
        <div class="col-md-7  col-lg-7 col-xs-12">
          <noscript>
            <div class="bs-callout bs-callout-danger">
              <h4>JavaScript is not enabled!</h4>
              <p>This payment form requires your browser to have JavaScript enabled. Please activate JavaScript and reload this page. Check <a href="http://enable-javascript.com" target="_blank">enable-javascript.com</a> for more informations.</p>
            </div>
          </noscript>
          <script>
          $(function () {
            $('[data-toggle="popover"]').popover({html:true,placement:"bottom"}); // enable popovers

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

            monthly_donation
          })
          </script>
          <div class="alert alert-danger" id="a_x200" style="display: none;"> <strong>Error!</strong> <span class="payment-errors"></span> </div>
          <pre>
            <?php
                print_r($_POST);
            ?>
          </pre>
          <?php if (isset($success) || isset($error)): ?>
            <span class="payment-success">
              <?= $success ?>
              <?= $error ?>
            </span>
          <?php endif; ?>
          <form action="" method="POST" id="payment-form" class="form-horizontal">
            <div class="row komen-callout komen-section">
              <h1>You decide.</h1>
              <p class="komen-p">You now have the power to contribute directly to stage IV/ metastatic breast cancer research, general breast cancer research, or triple negative breast cancer research. Decide where your donation goes by simply selecting a button under “Where would you like your donation to be applied?”<br>
                Thank you - on behalf of everyone impacted by breast cancer everywhere - for joining with Komen to help save lives.</p>
              <p class="h6"><span class="glyphicon glyphicon-asterisk required"></span>required</p>
            </div>
              <!-- First 3 Rows -->
              <div class="row ">
                <div class="komen-callout komen-section komen-no-top col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <h2><span class="glyphicon glyphicon-asterisk required"></span>Donation Amount</h2>
                  <div class="row">
                    <div class="row">
                      <button class="btn-value  "type="button" value="25">$25</button>
                      <button class="btn-value  "type="button" value="50">$50</button>
                      <button class="btn-value  "type="button" value="100">$100</button>
                      <button class="btn-value  "type="button" value="250">$250</button>
                      <button class="btn-value   "type="button" value="500">$500</button>
                      <button class="btn-value  "type="button" value="">OTHER</button>
                    </div>

                    <div id="cont-don-amount"class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <input class="form-control" type="text" name="donation_amount" id="donation_amount" placeholder="$0.00">
                    </div>
                  </div>
                  <div class="checkbox">
                    <input type="checkbox" checked="checked" name="monthly_donation" id="monthly_donation">
                    <label for="monthly_donation"> Make this my monthly donation.</label>
                    <span data-trigger="click" tabindex="0" class="glyphicon glyphicon-info-sign info" role="button" data-toggle="popover" data-content="If selected, you will be enrolled in our monthly program. Your monthly gift will be processed automatically with the credit card information you have provided.<br><a href='http://ww5.komen.org/HelpFAQ/HelpFAQs.html' target='_blank'>Learn More</a>"></span>
                  </div>
                  <div class="checkbox">
                    <input type="checkbox" checked="checked" name="tribute_show_honor" id="tribute_show_honor">
                    <label for="tribute_show_honor">Make my gift in honor or memory of a friend or loved one.</label>
                    <span data-trigger="click" tabindex="0" class="glyphicon glyphicon-info-sign info" role="button" data-toggle="popover" data-content="<strong>Honorariums</strong> are a great way to show your appreciation for a special someone by making a donation to Susan G. Komen® in their name. Honor gifts are perfect for anniversaries, birthdays and other special events.<br>
                    <strong>A Memorial gift</strong> is a beautiful tribute to the life of a loved one who has passed on. "></span>
                  </div>

                  <div id="tribute_honoree_name_row">
                    <div class="form-content col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <span class="glyphicon glyphicon-asterisk required"></span>
                      <label for="tribute_honoree_name">Person's Name or Occasion</label>
                      <input class="form-control" name="tribute_honoree_name" id="tribute_honoree_name" value="" maxlength="50" type="text" placeholder="Person's Name or Occasion">
                      <div id="cont-tribute">
                        <div class="">
                          <span class="glyphicon glyphicon-asterisk required"></span>
                          <label class="radio"><input type="radio" name="tribute_text" value="in_memory_of">In Memory of </label>
                          <label class="radio"><input type="radio" name="tribute_text" value="in_honor_of">In Honor of </label>
                        </div>
                        <div class="">
                          <label class="radio-inline"><input type="radio" name="tribute" value="no">No Thanks</label>
                          <label class="radio-inline"><input type="radio" name="tribute" value="mail">Yes, Mail Card</label>
                          <label class="radio-inline"><input type="radio" name="tribute" value="ecard">Yes, Send eCard</label>
                        </div>
                      </div>
                    </div>

                    </div>

                  <!-- Form Name -->
                </div>
              </div>
              <div class="row">
                <div class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- Form Name -->
                  <h2>Special Monthly Gift Offer</h2>
                  <img class="col-xs-2 col-sm-2 col-md-2 col-lg-2" src="img/notepad.jpg" alt="Special Monthly Gift Offer">
                  <p class="komen-p">Click on the checkbox above to enroll in our monthly giving program and give $25 or more a month to receive a free journal and pen after your third monthly gift. <sup>1</sup></p>
                </div>
              </div>
              <div class="row">
                <div class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- Form Name -->
                  <h2><span class="glyphicon glyphicon-asterisk required"></span>Where would you like your donation to be applied?</h2>
                  <div class="radio">
                    <input type="radio" name="fund_destination" value="stage4" id="donation-stage4">
                    <label for="donation-stage4">Stage IV/ Metastatic Breast Cancer Research. <sup>2</sup> </label>
                    <span data-trigger="click" tabindex="0" class="glyphicon glyphicon-info-sign info" role="button" data-toggle="popover" data-content=" <strong>Stage IV/ Metastatic Breast Cancer Research</strong>
                    Your gift will help us support research that focuses on Stage IV/ Metastatic Breast Cancer Research—cancer that has spread beyond the breast to other organs which is responsible for nearly all breast cancer deaths (including 40,000 in the U.S. this year alone)."></span>

                  </div>
                  <div class="radio">
                    <input type="radio" name="fund_destination" value="general-bc" id="donation-general-bc">
                    <label for="donation-general-bc">General Breast Cancer Research. <sup>2</sup> </label>
                    <span data-trigger="click" tabindex="0" class="glyphicon glyphicon-info-sign info" role="button" data-toggle="popover" data-content=" <strong>General Breast Cancer Research</strong>
                    Your gift will help us support the best breast cancer research, investigating everything from prevention through treatment and beyond."></span>
                  </div>
                  <div class="radio">
                    <input type="radio" name="fund_destination" value="triple-nbc" id="donation-triple-nbc">
                    <label for="donation-triple-nbc">Triple Negative Breast Cancer Research. <sup>2</sup> </label>
                    <span data-trigger="click" tabindex="0" class="glyphicon glyphicon-info-sign info" role="button" data-toggle="popover" data-content="<strong>Triple Negative Breast Cancer Research</strong>
                    Your gift will help us support research focusing on triple negative breast cancer a highly aggressive form of breast cancer for which no targeted treatment currently exists."></span>
                  </div>
                  <div class="radio">
                    <input type="radio" name="fund_destination" value="general-fund" id="donation-general-fund">
                    <label for="donation-general-fund">General Fund. <sup>2</sup> </label>
                    <span data-trigger="click" tabindex="0" class="glyphicon glyphicon-info-sign info" role="button" data-toggle="popover" data-content="<strong> General Fund</strong>
                    Your gift will help us support research, education and support while providing information and other programs to assist women, men and families facing breast cancer, and general administrative costs."></span>

                  </div>
                </div>
              </div>
              <!-- Second 3 rows -->
              <div class="row">
                <div id="payment-information" class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <fieldset>
                    <h2>Payment Information</h2>
                    <p  class="komen-p" id="payment-information">All transactions conducted on this website are encrypted using a secure server to protect your privacy. View Privacy Policy.</p>
                    <div class="payamount"><p class="amtmonies">$0.00</p><p class="amttimes">ONE-TIME DONATION</p></div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <!-- Card Number -->
                        <div class="form-group card-data">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>Credit Card Number:</label>
                          <input type="text" id="cardnumber" maxlength="19" placeholder="Card Number" class="card-number form-control">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <!-- CVV -->
                        <div class="form-group card-data">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>CVV:</label>
                            <input type="text" id="cvv" placeholder="CVV" maxlength="4" class="card-cvc form-control">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <!-- Expiry-->
                        <div class="form-group card-data">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>Expiration Date:</label>
                          <div class="form-inline">
                            <select data-stripe="exp-month" class="card-expiry-month stripe-sensitive required form-control">
                              <option value="01" selected="selected">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>
                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                            <span> / </span>
                            <select data-stripe="exp-year" class="card-expiry-year stripe-sensitive required form-control">
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="row">
                <div id="your-information" class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <fieldset>
                    <div class="row">
                      <!-- Form Name -->
                      <h2>Your Information</h2>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <!-- Card Holder Name -->
                        <div class="form-group">
                          <label class="control-label"  for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>First name</label>
                          <input type="text" name="card_holder_name" maxlength="70" placeholder="Card Holder Name" class="card-holder-name form-control">
                        </div>
                        <div class="form-group">
                          <label class="control-label"  for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>Last Name</label>
                          <input type="text" name="card_holder_surname" maxlength="70" placeholder="Card Holder Surname" class="card-holder-surname form-control">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <!-- Phone Number -->
                        <div class="form-group">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>Phone Number</label>
                          <input type="text" id="phone" name="phone" maxlength="30" placeholder="Phone Number" class="form-control">
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>Email Address</label>
                          <input type="text" name="email" maxlength="65" placeholder="Email" class="email form-control">
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="row">
                <div  id="billing-details" class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <fieldset>
                    <div class="row">
                      <!-- Form Name -->
                      <h2>Billing Details</h2>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <!-- Country -->
                        <div class="form-group">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>Country</label>
                          <!--input type="text" name="country" placeholder="Country" class="country form-control"-->
                          <div class="country bfh-selectbox bfh-countries" name="country" placeholder="Select Country" data-flags="true" data-filter="true"></div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <!-- Postcal Code -->
                        <div class="form-group">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>Postal Code</label>
                          <input type="text" name="zip" maxlength="9" placeholder="Postal Code" class="zip form-control">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <!-- Street -->
                        <div class="form-group">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>Street Address, Apt. or Ste.#</label>
                          <input type="text" name="street" placeholder="Street" class="address form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <!-- City -->
                        <div class="form-group">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>City</label>
                            <input type="text" name="city" placeholder="City" class="city form-control">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <!-- State -->
                        <div class="form-group">
                          <label class="control-label" for="textinput"><span class="glyphicon glyphicon-asterisk required"></span>State</label>
                          <input type="text" name="state" maxlength="65" placeholder="State" class="state form-control">
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="row">
                <div id="end-payment" class="komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div>
                    <input type="hidden" id="subscriber_country" name="subscriber_country">
                    <input type="checkbox" name="subscribe" id="subscribe" checked="checked">
                    <label for="subscribe">
                      Yes, I would like to receive&nbsp;emails from Susan G. Komen®
                    </label>
                    <!-- Submit -->
                    <button class="step-button action-button finish-step" type="submit">SEND MY DONATION</button>
                    <div class="payamount"><p class="amtmonies">$0.00</p><p class="amttimes">ONE-TIME DONATION</p></div>
                  </div>
                </div>
              </div>
          </form>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </body>
</html>
