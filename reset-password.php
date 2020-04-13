<?php
    include "header.php"
?>

  <!-- Grid div -->
  <div class="grid">
  <!-- Header div -->
          <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo hvid.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a> <a href="cart.php"><img src="images/cart_hvid.png" width="10%"></a></div>
            </div>
          <!-- Info div -->
          <div class="main">
            <div class="box1">
              <h2>Nulstil din kode her</h2>
              <p>Vi har sendt en email med yderligere instruktioner til hvordan du nulstiller koden, når du har indtastet emailen og trykket "Send email"</p>
            </div>

  <!-- Main div -->
          <!-- Table div -->
            <div class="box2">
            <div class="form">
                <form action="includes/request-password.inc.php" method="POST">
                  <input type="text" name="requestpassword" placeholder="Indtast email">
                  <button type="submit" name="requestpasswordsubmit">Send email</button>
                </form>
                <?php
                  if (isset($_GET['reset'])) {
                    if ($_GET['reset'] == "success") {
                      echo "<p>Tjek din email</p>";
                    } elseif ($_GET['password'] == "passwordupdated") {
                      echo "<p> Din nye kode er ny klar";
                    }
                  }

                ?>
                </div>
                </div>
</div>
    </div>
  </body>
</html>

