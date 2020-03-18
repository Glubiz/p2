<?php
ob_start();
  if (isset($_POST['login-submit'])) {

    require 'dbh.inc.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
      header("Location: ../profil.php?error=emptyfields");
      exit();
    }
    else {
      $sql = "SELECT * FROM zoouser WHERE user_email=?;";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../profil.php?error=sqlerror1");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
          $passwordCheck = password_verify($password, $row['user_password']);
          if ($passwordCheck == false) {
            header("Location: ../profil.php?error=wrongpassword");
            exit();
          }
          else if ($passwordCheck == true) {
            session_cache_limiter(FALSE);
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_email'] = $row['user_email'];
            header("Location: ../profil.php?login=success");
            exit();
          }
          else {
            header("Location: ../index.php?error=wrongpassword");
            exit();
          }
        }
        else {
          header("Location: ../index.php?error=nouser");
          exit();
        }
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else {
    header("Location: ../index.php");
    exit();
  }

ob_flush();
?>
