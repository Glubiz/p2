<?php
if (isset($_POST['betaling'])) {
    $dbServername = "mysql35.unoeuro.com";
    $dbUsername = "solskov_jensen_dk";
    $dbPassword = "JKQ1TGTK";
    $dbName = "solskov_jensen_dk_db";

    // Create connection
    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

    $product_name = $_POST['pname'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO checkout (product_name, product_price, product_amount) VALUES ($product_name, '1', $amount);";

    mysqli_query($conn, $sql);

}