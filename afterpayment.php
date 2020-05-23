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
                $adresse = strval($_GET["address"]);
                $postnr = strval($_GET["postalcode"]);
                $by = strval($_GET["city"]);
                $name = strval($_GET["name"]);

                $created_date = date("Y-m-d H:i:s");
                $selectorB = bin2hex(random_bytes(8));
                $tokenB = random_bytes(32);

                $urlB = "http://www.solskov-jensen.dk/p2/ticket.php?selector=" . $selectorB . "&validator=" . bin2hex($tokenB);

                $expiresB = date("U") + 94608000;
                $uStatus = "unused";
                foreach ($_SESSION["cart"] as $key => $value){
                    $pName = htmlspecialchars($value['item_name'], ENT_QUOTES,'UTF-8');
                    $pAmount = htmlspecialchars($value["item_quantity"], ENT_QUOTES,'UTF-8');
                    $pris = htmlspecialchars($value["product_price"], ENT_QUOTES,'UTF-8');
                    $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    
                    require "includes/dbh.inc.php";
                    $sql = "INSERT INTO `solskov_jensen_dk_db`.`zoobuy` (`user_name`, `user_email`, `user_product`, `p_amount`, `user_price`, `total_price`, `user_dato`, `expiry`, `selector`, `token`, `b_usage`) VALUES (?, ?, ?, ?, ?, '0', ?, ?, ?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "An error occured!2";
                        } else {
                            $hashedTokenB = password_hash($tokenB, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ssssssssss", $name, $email, $pName, $pAmount, $pris, $created_date, $expiresB, $selectorB, $hashedTokenB, $uStatus);
                            mysqli_stmt_execute($stmt);
                        }                  
                    }

                require "includes/dbh.inc.php";
                $sql = "UPDATE zoobuy SET total_price=? WHERE user_dato=? AND total_price='0';";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "An error occured!4";
                } else {
                    mysqli_stmt_bind_param($stmt, "ss", $total, $created_date);
                    mysqli_stmt_execute($stmt);
                }

                // Sender mail
                $to = $email;
            
                $subjekt = 'Tak for dit køb';
            
                $message = '<img src="http://www.solskov-jensen.dk/p2/images/Aalborg Zoo Gul.png">';
                $message .= '<h1>Tak for dit køb</h1>';
                $message .= '<h4>Nedenfor finder du din kvittering</h4>';
                //Generere table i mailen
                $message .= '<table style="width: 100%; text-align: start; background-color:#ccc;"><tr style="border-bottom: 1px #eee solid;">
                <th>Produkt Navn</th>
                <th>Antal</th>
                <th>Stk. Pris</th>
                <th>Total Pris</th>
                </tr>';
                foreach ($_SESSION["cart"] as $key => $value):
                    $name = htmlspecialchars($value['item_name'], ENT_QUOTES,'UTF-8');
                    $antal = htmlspecialchars($value["item_quantity"], ENT_QUOTES,'UTF-8');
                    $pris = htmlspecialchars($value["product_price"], ENT_QUOTES,'UTF-8');
                    $total = $total + ($value["item_quantity"] * $value["product_price"]);
                $message .= '<tr style="border-bottom: 1px #eee solid;"><td>';
                $message .= $name;
                $message .= '</td><td>';
                $message .= $antal;
                $message .= '</td><td>';
                $message .= $pris . ' DKK';
                $message .= '</td>';
              
                endforeach;

                $message .= '<td>';
                $message .= $total/2 . ' DKK';
                $message .= '</td></tr></table>';

                 // knap til brug af billetter
                $message .= '<p>Vis nedenstående til de billetansatte i Aalborg Zoo</p>';
                $message .= '<a href="' . $urlB . '"><button style="width: 50%; height: 70px; text-align: center; background-color: #ff9900cc;">Benyt Billet</button></a>';
            
                $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
                $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
                $headers .= "Content-type: text/html; charset=utf8\r\n";

                mail($to, $subjekt, $message, $headers);

                unset($_SESSION['cart']);
                exit(header ("location: success.php?status=success1"));

            } else {

                // Opretter ny bruger hvis ikke brugeren er lavet.
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

                // Klar gører password creation til brugeren, og generere link til mailen
                $selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);
                $url = "www.solskov-jensen.dk/p2/newUser.php?selector=" . $selector . "&validator=" . bin2hex($token);
                $expires = date("U") + 1800;

                require "includes/dbh.inc.php";
                $sql = "DELETE FROM zoopwdReset WHERE pwdResetEmail=?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "An error occured!3";
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                }
                require "includes/dbh.inc.php";
                $sql = "INSERT INTO zoopwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "An error occured!1";
                } else {
                    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $expires);
                    mysqli_stmt_execute($stmt);
                }

                $created_date = date("Y-m-d H:i:s");
                $selectorB = bin2hex(random_bytes(8));
                $tokenB = random_bytes(32);

                $urlB = "http://www.solskov-jensen.dk/p2/ticket.php?selector=" . $selectorB . "&validator=" . bin2hex($tokenB);

                $expiresB = date("U") + 94608000;
                $uStatus = "unused";
                foreach ($_SESSION["cart"] as $key => $value){
                    $pName = htmlspecialchars($value['item_name'], ENT_QUOTES,'UTF-8');
                    $pAmount = htmlspecialchars($value["item_quantity"], ENT_QUOTES,'UTF-8');
                    $pris = htmlspecialchars($value["product_price"], ENT_QUOTES,'UTF-8');
                    $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    
                    require "includes/dbh.inc.php";
                    $sql = "INSERT INTO `solskov_jensen_dk_db`.`zoobuy` (`user_name`, `user_email`, `user_product`, `p_amount`, `user_price`, `total_price`, `user_dato`, `expiry`, `selector`, `token`, `b_usage`) VALUES (?, ?, ?, ?, ?, '0', ?, ?, ?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "An error occured!2";
                        } else {
                            $hashedTokenB = password_hash($tokenB, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ssssssssss", $name, $email, $pName, $pAmount, $pris, $created_date, $expiresB, $selectorB, $hashedTokenB, $uStatus);
                            mysqli_stmt_execute($stmt);
                        }                  
                    }

                require "includes/dbh.inc.php";
                $sql = "UPDATE zoobuy SET total_price=? WHERE user_dato=? AND total_price='0';";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "An error occured!4";
                } else {
                    mysqli_stmt_bind_param($stmt, "ss", $total, $created_date);
                    mysqli_stmt_execute($stmt);
                }

                
            
                // Sender mail
                $to = $email;
            
                $subjekt = 'Tak for dit køb';
            
                $message = '<img src="http://www.solskov-jensen.dk/p2/images/Aalborg Zoo Gul.png" alt="">';
                $message .= '<h1>Tak for dit køb</h1>';
                $message .= '<h4>Nedenfor finder du din kvittering</h4>';
                //Generere table i mailen
                $message .= '<table style="width: 100%; text-align: start; background-color:#ccc;"><tr style="border-bottom: 1px #eee solid;">
                <th>Produkt Navn</th>
                <th>Antal</th>
                <th>Stk. Pris</th>
                <th>Total Pris</th>
                </tr>';
                foreach ($_SESSION["cart"] as $key => $value):
                    $name = htmlspecialchars($value['item_name'], ENT_QUOTES,'UTF-8');
                    $antal = htmlspecialchars($value["item_quantity"], ENT_QUOTES,'UTF-8');
                    $pris = htmlspecialchars($value["product_price"], ENT_QUOTES,'UTF-8');
                    $total = $total + ($value["item_quantity"] * $value["product_price"]);
                $message .= '<tr style="border-bottom: 1px #eee solid;"><td>';
                $message .= $name;
                $message .= '</td><td>';
                $message .= $antal;
                $message .= '</td><td>';
                $message .= $pris . ' DKK';
                $message .= '</td>';
              
                endforeach;

                $message .= '<td>';
                $message .= $total/2 . ' DKK';
                $message .= '</td></tr></table>';

                $message .= '<p>Hvis du er interresseret i at oprette dig som bruger, kan du føgle linket nedenfor, for at lave en kode</p>';
                $message .= '<a href="' . $url . '">' . $url . '</a>';

                // knap til brug af billetter
                $message .= '<p>Vis nedenstående til de billetansatte i Aalborg Zoo</p>';
                $message .= '<a href="' . $urlB . '"><button style="width: 50%; height: 70px; text-align: center; background-color: #ff9900cc;">Benyt Billet</button></a>';
            
                $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
                $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
                $headers .= "Content-type: text/html; charset=utf8\r\n";

                mail($to, $subjekt, $message, $headers);

                // Fjerner cart session, så kunden ikke kan se hvad der ligger i kurven mere
                unset($_SESSION['cart']);
                exit(header ("location: success.php?status=success2"));
            }
        }

} else {
    exit(header ("location: index.php?status=failed"));
}