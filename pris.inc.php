<?php
if (isset($_POST["submitPrice"])) {
    require "dbh.inc.php";
    $product = $_POST["product"];
    $price = $_POST["price"];
    $productID = $_POST["ID"];

    $sql = "UPDATE products SET product_price=? WHERE product_id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: index.php?error=sqlerror1");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $price, $productID);
        mysqli_stmt_execute($stmt);
    }

    header("Location: ../profil.php");
    exit();
} else {
    echo "<script>alert('Tilbage')</script>";
}