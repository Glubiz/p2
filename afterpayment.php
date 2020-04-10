#THIS IS FOR TESTING PURPOSES ONLY. When we move to testing on a real server we should setup a webhook
<?php

use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

$paymentIntentID = $_GET["paymentIntentID"];
echo "<h1>$paymentIntentID</h1>";
#lets check how it went with stripe and update payment status in db

require_once('./includes/stripe-php-7.28.0/init.php');
Stripe::setApiKey('sk_test_prhGuYjyokIQLGK9Nsspa6Ry003Rul9Qk7');

try {
    $paymentIntent = PaymentIntent::retrieve($paymentIntentID);
} catch (ApiErrorException $e) {
    print($e);
}

$status = $paymentIntent["status"];
echo "<div>$paymentIntentID</div>";
echo "<div>$status</div>";

$dbServername = "localhost";
$dbUsername = "solskov_jensen_dk";
$dbPassword = "JKQ1TGTK";
$dbName = "solskov_jensen_dk_db";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$sql = "UPDATE `order` SET `status`=? WHERE `payment_intent_id`=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ss",$status, $paymentIntentID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>