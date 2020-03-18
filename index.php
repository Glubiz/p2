<?php
session_cache_limiter(FALSE);
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>WoM</title>
    <link rel="stylesheet" type="text/css" href="style/style1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>

    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php">LOGO HERE</a></div>
            <div class="cart"><p><a href="profil.php">MY PROFILE</a> / <a href="cart.php">CART</a></p></div>
            <div class="test">
            <?php
              if (isset($_SESSION['user_id'])) {
                $user = $_SESSION['user_email'];
                echo '<p>Welcome ' . $user . '</p>
                <form action="includes/logout.inc.php" method="post">
                <div id="button1"><button type="submit" name="logout-submit">Logout</button>
                </form></div>';
                 }
                 else {
                 echo '<p>You are logged out</p>';
                }
                ?>
            </div>
        </div>
        <!-- main div-->
        <div class="main">
            <!-- valg div-->
            <div class="box2">
                <div class="k1"><a href="dagsbillet.php"><button>Dagsbilletter</button></a></div>
                <div class="k2"><a href="aarskort.php"><button>Årskort</button></a></div>
                <div class="k3"><a href="gavekort.php"><button>Gavekort</button></a></div>
                <div class="k4"><a href="eventkalender.php"><button>Andre aktiviteter</button></a></div>
                <div class="eventkalender"><p>Kalender her</p></div>
            </div>

        </div>
    </div>
    <a href="https://aalborg.taw.bones.dk/#/" target="_blank"><button id="bones">Til Bones</button></a>
</body>
</html>