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
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a><a id="trigger" href="#"><img src="<?php if (isset($_SESSION["cart"])) {
                echo "images/cart_hvid1.png";
            } else{
                echo "images/cart_hvid.png";
            } ?>" width="10%"></a><a href="https://aalborgzoo.dk"><p>Tilbage til Aalborg Zoo.dk</p></a></div>
            <div class="test">
            </div>
        </div>
        <!-- main div-->
        <div class="main">
            <!-- overskrift-->
            <div class="box1"><h1>Betaling</h1></div>
            <!-- valg div-->
            <div class="box2">
            <div class="payment">
  <form id="payment-form" method="POST">
    <label for="fname">Navn</label>
    <input type="text" id="fname" name="name"
    <?php if (isset($_SESSION['user_id'])) {
            $user = $_SESSION['user_email'];
            require 'includes/dbh.inc.php';
            $sql = "SELECT * FROM zoouser WHERE user_email=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?error=sqlerror1");
                exit();
              } else {
                mysqli_stmt_bind_param($stmt, "s", $user);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
              } 
              $row = mysqli_fetch_assoc($result);
            $name = $row['user_name'];
            echo 'value="' . $name . '"';
         } else {
          echo 'placeholder="Indtast Fulde Navn"';
         } ?> >

    <label for="email">Email</label>
    <input type="text" id="email" name="email" 
        <?php if (isset($_SESSION['user_id'])) {
                echo 'value="' . $user . '"';
         } else {
          echo 'placeholder="Indtast Email"';
         } ?> >

    <label for="email">Adresse</label>
    <input type="text" id="adresse" name="adresse"
    <?php if (isset($_SESSION['user_id'])) {
              $adresse = $row['user_adresse'];
              echo 'value="' . $adresse . '"';
            } else {
              echo 'placeholder="Indtast Adresse"';
            } ?> >
    
    <label for="email">Postnummer</label>
    <input type="text" id="postnr" name="postnr"
    <?php if (isset($_SESSION['user_id'])) {
              $postnr = $row['user_postnr'];
              echo 'value="' . $postnr . '"';
            } else {
              echo 'placeholder="Indtast Postnummer"';
            } ?> >

    <label for="email">By</label>
    <input type="text" id="by" name="by"
        <?php if (isset($_SESSION['user_id'])) {
                  $by = $row['user_by'];
                  echo 'value="' . $by . '"';
                } else {
                  echo 'placeholder="Indtast By"';
                } ?> >

    <div class="stripeElement">
  <div id="card-element">
    <!-- Elements will create input elements here -->
            </div>
  <!-- We'll put the error messages in this element -->
  <div id="card-errors" role="alert"></div>
  </div>
  <input type="submit" id="submit" class="bbtn1" value="Betal">
</form>
            </div>
<div class="t2">
                         <!-- Kurv -->
                <h1>Din kurv</h1>
            <!-- valg div-->
            <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
                <th width="30%">Produkt Navn</th>
                <th width="10%">Antal</th>
                <th width="13%">Stk. Pris</th>
                <th width="20%">Total Pris</th>
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
                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <th align="right"><?php echo number_format($total, 2); ?> DKK</th>
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
        'receipt_email' => 'glubiz13808@hotmail.com',

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
    var name = document.querySelector('input[name="name"]').value;
  var email = document.querySelector('input[name="email"]').value;
  var address = document.querySelector('input[name="adresse"]').value;
  var postalCode = document.querySelector('input[name="postnr"]').value;
  var city = document.querySelector('input[name="by"]').value;
  ev.preventDefault();
  stripe.confirmCardPayment(clientSecret, {
  payment_method: {
  card: card,
  billing_details: {
  email: email,
  name: name,
    address: {
            city: city,
            country: null,
            line1: address,
            line2: null,
            postal_code: postalCode,
          },
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
  window.location.replace('afterpayment.php?paymentIntentID=' + paymentIntentID + '&name=' + name + '&address=' + address + '&city=' + city + '&postalcode=' + postalCode + '&email=' + email);

  }
  });
  });
</script>
  </body>
</html>