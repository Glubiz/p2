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
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
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
            <div class="payment">
  <form id="payment-form" action="checkout.inc.php" method="POST">
    <label for="fname"> Fornavn</label>
    <input type="text" id="fname" name="firstname" placeholder="Indtast Navn">

    <label for="email">Efternavn</label>
    <input type="text" id="surname" name="lastname" placeholder="Indtast Efternavn">

    <label for="email"> Email</label>
    <input type="text" id="email" name="email" placeholder="Indtast Email">

    <label for="email">Adresse</label>
    <input type="text" id="adresse" name="adresse" placeholder="Indtast Adresse">
    <div class="stripeElement">
  <div id="card-element">
    <!-- Elements will create input elements here -->
            </div>
  <!-- We'll put the error messages in this element -->
  <div id="card-errors" role="alert"></div>
  </div>
  <button id="submit">Betal</button>
</form>
            </div>
<div class="t2">
                         <!-- Kurv -->
                <h1>Din kurv</h1>
            <!-- valg div-->
            <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
                <th width="30%">Product Name</th>
                <th width="10%">Quantity</th>
                <th width="13%">Price Details</th>
                <th width="10%">Total Price</th>
                <th width="17%">Remove Item</th>
            </tr>
 
            <?php
                if(!empty($_SESSION["cart"])){
                    $total = 0;
                    foreach ($_SESSION["cart"] as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $value["item_name"]; ?></td>
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td><?php echo $value["product_price"]; ?> DKK</td>
                            <td>
                                 <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?> DKK</td>
                            <td><a href="dagsbillet.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span
                                        class="text-danger">Fjern pordukt</span></a></td>
 
                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <th align="right"><?php echo number_format($total, 2); ?> DKK</th>
                            <td></td>
                        </tr>
                        <?php
                    } else {
                        echo "<div class='fail'><h1 id='fail'>Kurven er tom</h1></div>";
                    }
                ?>
            </table>
            </div>
        </div>
        </div>


 
<?php
$totalt = $total * 100;
$custId = rand(1,100000);

require_once('./includes/stripe-php-7.28.0/init.php');
Stripe::setApiKey('sk_test_dQBzFWK0m2H50Ermjvk6coKV001Gyo3RwQ');
echo "<div>$total</div>";
try {
    $intent = PaymentIntent::create([
        'amount' => $totalt,#husk det her er i ører
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


require 'includes/dbh.inc.php';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$sql = "INSERT INTO `order`(`customerID`, `name`, `price`, `clientsecret`, `status`, `payment_intent_id`, `date`) VALUES (?,?,?,?,?,?,?);";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);

$status = "awaiting payment";
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$name = $firstname . ' ' . $lastname;
$date = date("Y-m-d H:i:s");
mysqli_stmt_bind_param($stmt, "sssssss",$custId, $name, $total, $client_secret, $status, $payment_intent_id, $date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


?>
<script>
  const clientSecret = document.getElementById("clientsecretelement").getAttribute("data-client-secret");
  const paymentIntentID = document.getElementById("clientsecretelement").getAttribute("data-payment-intent-id");

  const stripe = Stripe('pk_test_EBSvb5G5W6b9Syls0QHSf9XV00ybOy7VZA');
  const elements = stripe.elements();
  var style = {
    base: {
    color: '#303238',
    fontSmoothing: 'antialiased',
    '::placeholder': {
      color: '#000',
    },
  },
  invalid: {
    color: '#e5424d',
    ':focus': {
      color: '#303238',
    },
  },
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
  name: "John Doe"
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
  window.location.replace('afterpayment.php?paymentIntentID=' + paymentIntentID);

  }
  });
  });
</script>
  </body>
</html>