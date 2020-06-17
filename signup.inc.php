<?php
 ob_start();
 //Kilde: https://www.youtube.com/watch?v=LC9GaXkdxF8
      if (isset($_POST['signup_submit'])) {

        require 'dbh.inc.php';

      $name = $_POST['name'];
      $password = $_POST['password'];
      $email = $_POST['email'];

      if (empty($name) || empty($password) || empty($email)) {
        header("Location: ../signup.php?error=emptyfields&name=".$name."&username=".$username."&email=".$email);
        exit();
      }
      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invalidemailusername");
        exit();
      }
      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidemailusername&name=".$name."&username=".$username);
        exit();
      }
      else {
        $sql = "SELECT user_email FROM zoouser WHERE user_email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else {
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if ($resultCheck > 0) {
            header("Location: ../signup.php?error=usertaken&email=".$email);
            exit();
          }
        else {
          $sql = "INSERT INTO zoouser (user_name, user_email, user_password) VALUES (?, ?, ?)";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else {
          $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedpassword);
          mysqli_stmt_execute($stmt);
          header("Refresh: 1; ../success.php");
          exit();
        }
        }
      }
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }
    else {
      header("Location: ../signup.php");
      exit();
    }
ob_flush();
?>
