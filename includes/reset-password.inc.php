<?php
session_cache_limiter(FALSE);
session_start();
  if (isset($_POST['resetpwdsubmit'])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $password1 = $_POST["pwd1"];

    if (empty($password) || empty($password1)) {
        header ("location ../index.php?pwd=empty");
        exit();

    } elseif ($password !== $password1 ) {
        header ("location ../index.php?pwd=different");
        exit();

    } else {
    $currentDate = date("U");
    require "dbh.inc.php";

    $sql = "SELECT * FROM zoopwdReset WHERE pwdResetSelector=? AND pwdResetExpires>=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header ("location ../index.php?error=sqlerror1");
        exit();

    } else {
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)) {
            header ("location ../index.php?error=noresult");
            exit();

        } else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

            if ($tokenCheck === false) {
                header ("location ../index.php?error=error");
                exit();

            } elseif ($tokenCheck === true) {
                $tokenEmail = $row['pwdResetEmail'];
                $sql = "SELECT * FROM zoouser WHERE user_email=?;";
                $stmt = mysqli_stmt_init($conn);
                     if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header ("location ../index.php?error=sqlerror2");
                        exit();

                     } else {
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (!$row = mysqli_fetch_assoc($result)) {
                            header ("location ../index.php?error=error2");
                            exit();

                            } else {
                                $sql = "UPDATE zoouser SET user_password=? WHERE user_email=?;";
                                $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header ("location ../index.php?error=sqlerror3");
                                        exit();

                                    } else {
                                        $newPwdHashed = password_hash($password, PASSWORD_DEFAULT);
                                    mysqli_stmt_bind_param($stmt, "ss", $newPwdHashed, $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                        $sql = "DELETE FROM zoopwdReset WHERE pwdResetEmail=?;";
                                        $stmt = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                                            header ("location ../index.php?error=sqlerror4");
                                            exit();

                                            } else {
                                            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                            mysqli_stmt_execute($stmt);
                                            header("Refresh: 1; ../profil.php?password=passwordupdated");
                                            exit();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
} else {
    header ("location ../index.php");
    exit();
}
