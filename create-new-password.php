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
            <div class="main">
              <!-- overskrift-->
              <div class="box1">            
                    <h3>Login</h3>
                    </div>
                <!-- valg div-->
                <div class="box2">
                    <div class="form">
                    <?php
                    $selector = $_GET["selector"];
                    $validator = $_GET["validator"];

                    if (empty($selector) || empty($validator) ) {
                        echo "Could not vaidater you request";
                    } else {
                        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                            ?>
                            <form action="includes/reset-password.inc.php" method="POST">
                                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                                <input type="password" name="pwd" placeholder="Indtast ny kode">
                                <input type="password" name="pwd1" placeholder="Gentag kode">
                                <button type="submit" name="resetpwdsubmit">Reset password</button>
                            </form>
                            <?php
                        }
                    }

                ?>
                </div>
                </div>
                
</div>
    </div>
  </body>
</html>