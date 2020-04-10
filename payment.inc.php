<?php
if (isset($_POST['submit'])) {

$product = $_POST['product[]'];
$price = $_POST['price[]'];
$amount = $_POST['amount[]'];
$expires = date("U") + 1800;

$dbServername = "mysql35.unoeuro.com";
$dbUsername = "solskov_jensen_dk";
$dbPassword = "JKQ1TGTK";
$dbName = "solskov_jensen_dk_db";
    
// Create connection
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

$sql = "INSERT INTO checkout (product_name, product_price, product_amount, checkout_expiration) VALUES (?,?,?,?)";
$stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: testsql.php?error=sqlerror1");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ssss", $product, $price, $amount, $expires);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}

header("Location: ../testsql.php");
exit();
} else {
    echo "you are not allowed to be here";
}