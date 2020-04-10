<?php

use Stripe\PaymentIntent;
use Stripe\Stripe;

session_cache_limiter(FALSE);
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Zooshoppen</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
  <form id="payment-form">
  <div id="card-element" style="">
    <!-- Elements will create input elements here -->
  </div>

  <!-- We'll put the error messages in this element -->
  <div id="card-errors" role="alert"></div>

  <button id="submit">Pay</button>
</form>


 
<?php
$total = rand(10000,20000); #divide by 2000 to get floating point number
$custId = rand(1,100);

require_once('./includes/stripe-php-7.28.0/init.php');
Stripe::setApiKey('sk_test_prhGuYjyokIQLGK9Nsspa6Ry003Rul9Qk7');
echo "<div>$total</div>";
try {
    $intent = PaymentIntent::create([
        'amount' => $total,#husk det her er i ører
        'currency' => 'dkk',
        // Verify your integration in this guide by including this parameter
        'metadata' => ['integration_check' => 'accept_a_payment'],
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    print($e);
   print("payment intent create error");
}

#save clientsecret with the order information



#output to page so we can use it for stripe payment
$client_secret = $intent["client_secret"];
$payment_intent_id = $intent["id"];
echo "<input id=\"clientsecretelement\" type=\"hidden\" data-client-secret=\"$client_secret\", data-payment-intent-id=\"$payment_intent_id\">";


$dbServername = "localhost";
$dbUsername = "solskov_jensen_dk";
$dbPassword = "JKQ1TGTK";
$dbName = "solskov_jensen_dk_db";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$sql = "INSERT INTO `order`(`customerID`, `price`, `clientsecret`, `status`, `payment_intent_id`) VALUES (?,?,?,?,?);";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);

$status = "awaiting payment";
mysqli_stmt_bind_param($stmt, "idsss",$custId, $total, $client_secret, $status, $payment_intent_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


?>
<script>
  const clientSecret = document.getElementById("clientsecretelement").getAttribute("data-client-secret");
  const paymentIntentID = document.getElementById("clientsecretelement").getAttribute("data-payment-intent-id");

  const stripe = Stripe('pk_test_VzlKID2ZAlb14kkesKZlrNUx00y0i8mYZ0');
  const elements = stripe.elements();
  var style = {
      base: {
          color: "#32325d",
      }
  };

  const card = elements.create("card", {style: style});
  card.mount("#card-element");
  card.addEventListener('change', ({error}) => {
  const displayError = document.getElementById('card-errors');
  if (error) {
  displayError.textContent = error.message;
  } else {
  displayError.textContent = '';
  }
  });

  const form = document.getElementById('payment-form');

  form.addEventListener('submit', function(ev) {
  ev.preventDefault();
  stripe.confirmCardPayment(clientSecret, {
  payment_method: {
  card: card,
  billing_details: {
  name: 'Jenny Rosen'
  }
  }
  }).then(function(result) {
  if (result.error) {
  // Show error to your customer (e.g., insufficient funds)
  console.log(result.error.message);
  } else {

  // The payment has been processed!
  if (result.paymentIntent.status === 'succeeded') {

      console.log("succeeded");

  // Show a success message to your customer
  // There's a risk of the customer closing the window before callback
  // execution. Set up a webhook or plugin to listen for the
  // payment_intent.succeeded event that handles any business critical
  // post-payment actions.
  }
  console.log("redirect so we can make php check with stripe and update if succeeded or failed");
  window.location.replace('/afterpayment.php?paymentIntentID=' + paymentIntentID);

  }
  });
  });
</script>
  </body>
</html>