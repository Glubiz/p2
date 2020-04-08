<?php
session_cache_limiter(FALSE);
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Zooshoppen</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
$(document).ready(function(){
  /*$('.header, .box2').css('display', 'none');
  $('.header').delay(100).fadeIn(700);
  $('.k1').delay(600).fadeIn(1000);
  $('.k2').delay(1600).fadeIn(1000);
  $('.k3').delay(2600).fadeIn(1000);
  $('.k4').delay(3600).fadeIn(1000);*/
});
</script>

<style>

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}
</style>
  </head>
  <body>

 <!-- grid div-->
 <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo hvid.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a><a id="trigger"><img src="images/cart_hvid.png" width="10%"></a></div>
            <div class="test">
            <?php
              /*if (isset($_SESSION['user_id'])) {
                $user = $_SESSION['user_email'];
                echo '<p>Welcome ' . $user . '</p>
                <form action="includes/logout.inc.php" method="post">
                <div id="button1"><button type="submit" name="logout-submit">Logout</button>
                </form></div>';
                 }
                 else {
                 echo '<p>You are logged out</p>';
                }*/
                ?>
            </div>
        </div>
        <!-- main div-->
        <div class="main">
            <!-- overskrift-->
            <div class="box1"><h1>Betaling</h1></div>
            <!-- valg div-->
            <div class="box2">

            <div class="row">
            <div class="col-75">
                <div class="container">
                    <form action="/action_page.php">
      
                    <div class="row">
                        <div class="col-50">
                            <label for="fname"><i class="fa fa-user"></i> Navn</label>
                            <input type="text" id="fname" name="firstname" placeholder="Indtast Navn">
                            <label for="email"><i class="fa fa-envelope"></i> Email</label>
                            <input type="text" id="email" name="email" placeholder="Indtast email">
                    </div>
                </div>

                <div class="col-50">
                    <h3>Betaling</h3>
                    <label for="cname">Kortholders Navn</label>
                    <input type="text" id="cname" name="cardname" placeholder="Indtast Kortholders Navn">
                    <label for="ccnum">Kort Nummer</label>
                    <input type="text" id="ccnum" name="cardnumber" placeholder="XXXX-XXXX-XXXX-XXXX">
                <div class="row">
                <div class="col-50">
                    <label for="expmonth">Udløbsdato</label>
                    <input type="month" id="expmonth" name="expmonth">
                </div>
                <div class="col-50">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="XXX">
                </div>
            </div>
        </div>
          
        </div>
        <input type="submit" value="Continue to checkout" class="btn">
      </form>
    </div>
  </div>
</div>

            <!-- <form action="/charge" method="post" id="payment-form">
            <div class="form-row">
            <label for="card-element">
            Credit or debit card
            </label>
            <div id="card-element"> -->
            <!-- A Stripe Element will be inserted here.
            <input id="ccn" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="16" placeholder="xxxx xxxx xxxx xxxx">
            </div> -->

            <!-- Used to display Element errors. 
            <div id="card-errors" role="alert"></div>
            </div>

            <button>Submit Payment</button>
            </form>
            </div>
        </div>
        </div>
    </div>-->


<script>
    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys
    var stripe = Stripe('pk_test_EBSvb5G5W6b9Syls0QHSf9XV00ybOy7VZA');
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    var style = {
    base: {
    // Add your base input styles here. For example:
    fontSize: '16px',
    color: '#32325d',
    },
};

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Create a token or display an error when the form is submitted.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the customer that there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
    });
});

    function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
    }

    // Set your secret key. Remember to switch to your live secret key in production!
    // See your keys here: https://dashboard.stripe.com/account/apikeys
    Stripe.apiKey = "sk_test_dQBzFWK0m2H50Ermjvk6coKV001Gyo3RwQ";

    // Token is created using Stripe Checkout or Elements!
    // Get the payment token ID submitted by the form:
    String token = request.getParameter("stripeToken");

    ChargeCreateParams params =
    ChargeCreateParams.builder()
    .setAmount(999L)
    .setCurrency("dkk")
    .setDescription("Example charge")
    .setSource(token)
    .build();

    Charge charge = Charge.create(params);

</script>