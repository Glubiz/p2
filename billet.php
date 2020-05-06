<?php
ob_start();
session_cache_limiter(FALSE);
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Webshop</title>
    <link rel="stylesheet" type="text/css" href="style/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <br>
    <br>
    <!-- Header --> 
    <div class="header">
    <img src="images/Aalborg Zoo Sort.png" alt="">
    <div class="header-text">
        <h1>Billetter og Årskort</h1>
    </div>
    <div class="header-right">
        <a href="">Konto</a>
        <a href="">Kurv</a>
    </div>
    </div>

    <div class="wrapper-shop">
        <p>Vi bliver </p>
        <form action="includes/shop.inc.php" method="POST">
            <div class="form-input">
            <input type="text" name="voksen" placeholder="0">
            </div>
        <p>voksne og</p>
            <div class="form-input">
            <input type="text" name="barn" placeholder="0">
            </div>
        <p>børn fra 3-11 år</p>
        <input type="submit" name="reset" value="Nulstil">
        <input type="submit" name="submit" value="Udregn">
        </form>
    </div>
    <?php
    if(isset($_POST['submit'])){
        $voksen=$_POST['voksen'];
        $barn=$_POST['barn'];
        $voksenpris=185;
        $barnpris=99;
        
        $totalvoksen=$voksen*$voksenpris;
        $totalbarn=$barn*$barnpris;
        echo "<p>Prisen bliver i alt</p>" . $totalvoksen . "<p>for voksne og</p>" . $totalbarn . "<p>for børn</p>";
    }
    ?>