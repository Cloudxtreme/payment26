<?php
  require 'lib/Stripe.php';
  //var_dump($_POST);
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
    <link rel="stylesheet" href="css/bootstrap-min.css">
    <link rel="stylesheet" href="css/bootstrap-formhelpers-min.css" media="screen">
    <link rel="stylesheet" href="css/bootstrapValidator-min.css"/>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" />
    <link rel="stylesheet" href="css/bootstrap-side-notes.css" />
    <link rel="stylesheet" href="css/custom-callouts.css">
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
          <div class="alert alert-danger" id="a_x200" style="display: none;"> <strong>Error!</strong> <span class="payment-errors"></span> </div>
          <?php if (isset($success) || isset($error)): ?>
            <span class="payment-success">
              <?= $success ?>
              <?= $error ?>
            </span>
          <?php endif; ?>
          <form action="" method="POST" id="payment-form" class="form-horizontal">
            <div class="row">
              <h2>You decide.</h2>
              <p>You now have the power to contribute directly to stage IV/ metastatic breast cancer research, general breast cancer research, or triple negative breast cancer research. Decide where your donation goes by simply selecting a button under “Where would you like your donation to be applied?”<br>
                Thank you - on behalf of everyone impacted by breast cancer everywhere - for joining with Komen to help save lives.</p>
              <p><span class="glyphicon glyphicon-asterisk"></span>required</p>
            </div>
              <!-- First 3 Rows -->
              <div class="row">
                <div class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <h2><span class="glyphicon glyphicon-asterisk"></span>Donation Amount</h2>
                  <div class="wrapper-price">
                    <input type="radio" name="donation-level" id="donation-level-1" value="25">
                    <label for="donation-level-1">$25</label>
                    <input type="radio" name="donation-level" id="donation-level-2" value="50">
                    <label for="donation-level-2">$50</label>
                    <input type="radio" name="donation-level" id="donation-level-3" value="100">
                    <label for="donation-level-3">$100</label>
                    <input type="radio" name="donation-level" id="donation-level-4" value="250">
                    <label for="donation-level-4">$250</label>
                    <input type="radio" name="donation-level" id="donation-level-5" value="500">
                    <label for="donation-level-5">$500</label>
                    <input type="radio" name="donation-level" id="donation-level-6" value="0">
                    <label for="donation-level-6">OTHER</label>
                    <div>
                      <input type="text" name="" id="">
                    </div>
                  </div>
                  <div class="">
                    <input type="checkbox" name="" id="level_standardauto_repeatname">
                    <label for="level_standardauto_repeatname"> Make this my monthly donation.</label>
                    <span class="glyphicon glyphicon-info-sign"></span>
                  </div>
                  We will automatically receive your gift each month.
                  <div class="">
                    <input type="checkbox" name="" id="tribute_show_honor_fieldsname">
                    <label for="tribute_show_honor_fieldsname">Make my gift in honor or memory of a friend or loved one.</label>
                    <span class="glyphicon glyphicon-info-sign"></span>
                  </div>

                  <div id="tribute_honoree_last_name_row">
                    <div class="form-content">
                      <span class="glyphicon glyphicon-asterisk"></span>
                      <label for="tribute_honoree_last_namename">Person's Name or Occasion</label>
                      <input name="tribute_honoree_last_namename" id="tribute_honoree_last_namename" value="" maxlength="50" type="text">
                    </div>
                    <div class="">
                      <span class="glyphicon glyphicon-asterisk"></span>
                      <label><input type="radio" name="tribute_type_text" value="tribute_type_value1">In Memory of </label>
                      <label><input type="radio" name="tribute_type_text" value="tribute_type_value2">In Honor of </label>
                    </div>
                    <div class="">
                      <label><input type="radio" name="send_tribute_radio" value="No_Thanks">No Thanks</label>
                      <label><input type="radio" name="send_tribute_radio" value="Yes_Mail_Card">Yes, Mail Card</label>
                      <label><input type="radio" name="send_tribute_radio" value="Yes_eCard">Yes, Send eCard</label>
                    </div>
                  </div>
                  <!-- Form Name -->
                  <!-- <h1>You Decide.</h1>
                  <p>You now have the power to contribute directly to stage IV/ metastatic breast cancer research, general breast cancer research, or triple negative breast cancer research. Decide where your donation goes by simply selecting a button under “Where would you like your donation to be applied?”</p>
                  <p>Thank you - on behalf of everyone impacted by breast cancer everywhere - for joining with Komen to help save lives.</p> -->
                </div>
              </div>
              <div class="row">
                <div class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- Form Name -->
                  <h2>Special Monthly Gift Offer</h2>
                </div>
              </div>
              <div class="row">
                <div class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- Form Name -->
                  <h2>Where would you like your donation to be applied?</h2>
                  <div>
                    <input type="radio" name="fund_radio" id="donation-stageIV">
                    <label for="donation-stageIV">Stage IV/ Metastatic Breast Cancer Research.</label>
                    <span class="glyphicon glyphicon-info-sign"></span>
                  </div>
                  <div>
                    <input type="radio" name="fund_radio" id="donation-generalBC">
                    <label for="generalBC">General Breast Cancer Research.</label>
                    <span class="glyphicon glyphicon-info-sign"></span>
                  </div>
                  <div>
                    <input type="radio" name="fund_radio" id="donation-">
                    <label for="donation-tripleNBC">Triple Negative Breast Cancer Research.</label>
                    <span class="glyphicon glyphicon-info-sign"></span>
                  </div>
                  <div>
                    <input type="radio" name="fund_radio" id="donation-generalFund">
                    <label for="generalFund">General Fund.</label>
                    <span class="glyphicon glyphicon-info-sign"></span>
                  </div>
                </div>
              </div>
              <!-- Second 3 rows -->
              <div class="row">
                <div class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <fieldset>
                    <h2>Payment Information</h2>
                    <p>All transactions conducted on this website are encrypted using a secure server to protect your privacy. View Privacy Policy.</p>
                    <div class="payamount"><p class="amtmonies">$0.00</p><p class="amttimes">ONE-TIME DONATION</p></div>

                    <!-- Card Number -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Credit Card Number:</label>
                      <div class="col-sm-6">
                        <input type="text" id="cardnumber" maxlength="19" placeholder="Card Number" class="card-number form-control">
                      </div>
                    </div>

                    <!-- Expiry-->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Expiration Date:</label>
                      <div class="col-sm-6">
                        <div class="form-inline">
                          <select name="select2" data-stripe="exp-month" class="card-expiry-month stripe-sensitive required form-control">
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
                          <select name="select2" data-stripe="exp-year" class="card-expiry-year stripe-sensitive required form-control">
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- CVV -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Security Code:</label>
                      <div class="col-sm-3">
                        <input type="text" id="cvv" placeholder="CVV" maxlength="4" class="card-cvc form-control">
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="row">
                <div class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <fieldset>
                    <!-- Form Name -->
                    <h2>Your Information</h2>
                    <!-- Card Holder Name -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label"  for="textinput"><span class="glyphicon glyphicon-asterisk"></span>First name</label>
                      <div class="col-sm-6">
                        <input type="text" name="cardholdername" maxlength="70" placeholder="Card Holder Name" class="card-holder-name form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label"  for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Last Name</label>
                      <div class="col-sm-6">
                        <input type="text" name="cardholdersurname" maxlength="70" placeholder="Card Holder Surname" class="card-holder-surname form-control">
                      </div>
                    </div>
                    <!-- Phone Number -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Phone Number</label>
                      <div class="col-sm-6">
                        <input type="text" name="phone" maxlength="30" placeholder="Phone Number" class="form-control">
                      </div>
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Email Address</label>
                      <div class="col-sm-6">
                        <input type="text" name="email" maxlength="65" placeholder="Email" class="email form-control">
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="row">
                <div class="komen-callout komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <fieldset>
                    <!-- Form Name -->
                    <legend>Billing Details</legend>

                    <!-- Street -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Street</label>
                      <div class="col-sm-6">
                        <input type="text" name="street" placeholder="Street" class="address form-control">
                      </div>
                    </div>

                    <!-- City -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>City</label>
                      <div class="col-sm-6">
                        <input type="text" name="city" placeholder="City" class="city form-control">
                      </div>
                    </div>

                    <!-- State -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>State</label>
                      <div class="col-sm-6">
                        <input type="text" name="state" maxlength="65" placeholder="State" class="state form-control">
                      </div>
                    </div>

                    <!-- Postcal Code -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Postal Code</label>
                      <div class="col-sm-6">
                        <input type="text" name="zip" maxlength="9" placeholder="Postal Code" class="zip form-control">
                      </div>
                    </div>

                    <!-- Country -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="textinput"><span class="glyphicon glyphicon-asterisk"></span>Country</label>
                      <div class="col-sm-6">
                        <!--input type="text" name="country" placeholder="Country" class="country form-control"-->
                        <div class="country bfh-selectbox bfh-countries" name="country" placeholder="Select Country" data-flags="true" data-filter="true"> </div>
                      </div>
                    </div>


                  </fieldset>
                </div>
              </div>
              <div class="row">
                <div class="komen-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <fieldset>
                    <!-- Important notice -->
                    <div class="panel panel-success">
                      <div class="panel-heading">
                        <h3 class="panel-title">Important notice</h3>
                      </div>
                      <div class="panel-body">
                        <p>Your card will be charged 30€ after submit.</p>
                        <p>Your account statement will show the following booking text:
                          XXXXXXX </p>
                      </div>
                    </div>
                    <!-- Submit -->
                    <div class="control-group">
                      <div class="controls">
                        <center>
                          <button class="btn btn-success" type="submit">Pay Now</button>
                        </center>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
          </form>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
  </body>
</html>
