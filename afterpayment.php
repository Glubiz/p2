#THIS IS FOR TESTING PURPOSES ONLY. When we move to testing on a real server we should setup a webhook
<?php

use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

$paymentIntentID = $_GET["paymentIntentID"];
echo "<h1>$paymentIntentID</h1>";
#lets check how it went with stripe and update payment status in db

require_once('includes/stripe-php-7.28.0/init.php');
Stripe::setApiKey('sk_test_dQBzFWK0m2H50Ermjvk6coKV001Gyo3RwQ');

try {
    $paymentIntent = PaymentIntent::retrieve($paymentIntentID);
} catch (ApiErrorException $e) {
    print($e);
}

$status = $paymentIntent["status"];
echo "<div>$paymentIntentID</div>";
echo "<div>$status</div>";

require 'includes/dbh.inc.php';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$sql = "UPDATE `order` SET `status`=? WHERE `payment_intent_id`=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ss",$status, $paymentIntentID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

session_start();
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(),'',0,'/');
session_regenerate_id(true);

header ("location: index.php?status=success");
exit();
?>