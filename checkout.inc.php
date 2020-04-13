<?php
if (isset($_POST['betaling'])) {
    require "dbh.inc.php";

    $product_name = $_POST['pname'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO checkout (product_name, product_price, product_amount) VALUES ($product_name, '1', $amount);";

    mysqli_query($conn, $sql);

}