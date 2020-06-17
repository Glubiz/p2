<?php
session_cache_limiter(FALSE);
session_start();
  ob_start();
  //Kilde: https://www.youtube.com/watch?v=LC9GaXkdxF8

if (isset($_POST['requestpasswordsubmit'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "www.solskov-jensen.dk/p2/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    require "dbh.inc.php";

    $userEmail = $_POST["requestpassword"];

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
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close();

    $to = $userEmail;

    $subjekt = 'Nulstil din kode';

    $message = '<p>Vi har modtaget din forspørgsel om at nulstille koden. Kopier linket nedenunder for at lave en ny kode.</p>';
    $message .= '<p>Her er linket til nulstilningen:</p>';
    $message .= '<a href="' . $url . '">' . $url . '</a>';

    $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subjekt, $message, $headers);

    header("Location: ../reset-password.php?reset=success");


} else {
    header ("Location ../index.php");
    exit();
}
ob_flush();