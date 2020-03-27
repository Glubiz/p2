<?php
session_cache_limiter(FALSE);
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Zooshoppen</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="style/style1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>/*
$(document).ready(function(){
  $('.header, .k1, .k2, .k3, .k4, .eventkalender').css('display', 'none');
  $('.header').delay(100).fadeIn(700);
  $('.k1').delay(600).fadeIn(1000);
  $('.k2').delay(1200).fadeIn(1000);
  $('.k3').delay(1800).fadeIn(1000);
  $('.eventkalender').delay(2400).fadeIn(1000);
});*/
</script>
  </head>
  <body>

    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo Gul.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_gul.png" width="10%"></a> <a href="cart.php"><img src="images/cart_gul.png" width="40%"></a></div>
            <div class="test">
            <?php
              /*if (isset($_SESSION['user_id'])) {
                $user = $_SESSION['user_email'];
                echo '<p>Welcome ' . $user . '</p>
                <form action="includes/logout.inc.php" method="post">
                <div id="button1"><button type="submit" name="logout-submit">Logout</button>
                </form></div>';
                 }
                 else {
                 echo '<p>You are logged out</p>';
                }*/
                ?>
            </div>
        </div>
        <!-- main div-->
        <div class="main">
            <!-- valg div-->
            <div class="box2">
                <div class="k1"><a href="dagsbillet.php"><button>Dagsbillet</button></a></div>
                <div class="k2"><a href="aarskort.php"><button>Årskort</button></a></div>
                <div class="k3"><a href="gavekort.php"><button>Gavekort</button></a></div>
                <div class="eventkalender"><p>Kalender her</p></div>
            
            <div class="box3">
                <a href="https://aalborgzoo.dk/mad-og-drikke.aspx"><button>Mad og Drikke</button></a>
                <a href="https://aalborgzoo.dk"><button>Tilbage til hovedsiden</button></a>
            </div>
            </div>
        </div>
    </div>
</body>
</html>