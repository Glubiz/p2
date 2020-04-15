<?php
session_cache_limiter(FALSE);
session_start();
header('Cache-control: private');

use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

$paymentIntentID = $_GET["paymentIntentID"];
#lets check how it went with stripe and update payment status in db

require_once('includes/stripe-php-7.28.0/init.php');
Stripe::setApiKey('sk_test_dQBzFWK0m2H50Ermjvk6coKV001Gyo3RwQ');

try {
    $paymentIntent = PaymentIntent::retrieve($paymentIntentID);
} catch (ApiErrorException $e) {
    print($e);
}

$status = $paymentIntent["status"];

require 'includes/dbh.inc.php';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$sql = "UPDATE `order` SET `status`=? WHERE `payment_intent_id`=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ss",$status, $paymentIntentID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$email = $_POST['email'];
$sql = "SELECT * FROM zoouser WHERE user_email=?";
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: index.php?error=sqlerror1");
    exit();
  }
  else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_stmt_num_rows($stmt);
  }
  if ($resultCheck > 0) {
    $to = $email;

    $subjekt = 'Tak for dit køb';
    
    $message = '<p>Vi har modtaget din forspørgsel om at nulstille koden. Kopier linket nedenunder for at lave en ny kode.</p>';
    $message .= '<p>Her er linket til nulstilningen:</p>';
    
    $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Content-type: text/html\r\n";
  } else {
    $to = "glubiz13808@hotmail.com";

    $subjekt = 'Nulstil din kode';

    $message = '<p>Vi har modtaget din forspørgsel om at nulstille koden. Kopier linket nedenunder for at lave en ny kode.</p>';
    $message .= '<p>Her er linket til nulstilningen:</p>';

    $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Content-type: text/html\r\n";
  }

  unset($_SESSION['cart']);

exit(header ("location: index.php?status=success"));
?>