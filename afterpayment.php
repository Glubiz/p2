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
    $email = strval($_GET["email"]);

require 'includes/dbh.inc.php';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$sql = "UPDATE `order` SET `status`=? WHERE `payment_intent_id`=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ss", $status, $paymentIntentID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if($status == "succeeded"){
    
    require 'includes/dbh.inc.php';
    $sql1 = "SELECT * FROM zoouser WHERE user_email=?";
    $stmt1 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt1, $sql1)) {
        header("Location: index.php?error=sqlerror1");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt1, "s", $email);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_store_result($stmt1);
        $resultCheck = mysqli_stmt_num_rows($stmt1);
            if ($resultCheck > 0) {
                $to = $email;
            
                $subjekt = 'Tak for dit køb';
                
                $message = '<p>Vi har modtaget din forspørgsel om at nulstille koden. Kopier linket nedenunder for at lave en ny kode.</p>';
                $message .= '<p>Her er linket til nulstilningen:</p>';
                
                $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
                $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
                $headers .= "Content-type: text/html; charset=utf8\r\n";

                mail($to, $subjekt, $message, $headers);

                unset($_SESSION['cart']);
                exit(header ("location: index.php?status=success1"));

            } else {
                $adresse = strval($_GET["address"]);
                $postnr = strval($_GET["postalcode"]);
                $by = strval($_GET["city"]);
                $name = strval($_GET["name"]);
                require 'includes/dbh.inc.php';
                $sql = "INSERT INTO zoouser (user_name, user_email, user_adresse, user_postnr, user_by, user_password) VALUES (?, ?, ?, ?, ?, '231212d12d')";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: index.php?error=sqlerror2");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $adresse, $postnr, $by);
                    mysqli_stmt_execute($stmt);
                }

                $selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);

                $url = "www.solskov-jensen.dk/p2/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

                $expires = date("U") + 1800;

                require "includes/dbh.inc.php";

                $sql = "DELETE FROM zoopwdReset WHERE pwdResetEmail=?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "An error occured!";
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $userEmail);
                    mysqli_stmt_execute($stmt);
                }

                $sql = "INSERT INTO zoopwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "An error occured!";
                } else {
                    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $expires);
                    mysqli_stmt_execute($stmt);
                }

                mysqli_stmt_close($stmt);
            
                $to = $email;
            
                $subjekt = 'Nulstil din kode';
            
                $message = '<p>Vi har modtaget din forspørgsel om at nulstille koden. Kopier linket nedenunder for at lave en ny kode.</p>';
                $message .= '<p>Hvis du er interresseret i at oprette dig som bruger, kan du føgle linket nedenfor, for at lave en kode</p>';
                $message .= '<a href="' . $url . '">' . $url . '</a>';
            
                $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
                $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
                $headers .= "Content-type: text/html; charset=utf8\r\n";

                mail($to, $subjekt, $message, $headers);

                unset($_SESSION['cart']);
                exit(header ("location: index.php?status=success2"));
            }
        }

} else {
    exit(header ("location: index.php?status=failed"));
}