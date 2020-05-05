<?php
    include "header.php"
?>

  <!-- Grid div -->
  <div class="grid">
  <!-- Header div -->
          <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo Gul.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a> <a href="cart.php"><img src="images/cart_hvid.png" width="10%"></a></div>
            </div>
            <div class="main">
              <!-- overskrift-->
              <div class="box1">            
                    <h3>Benyt Billetter her</h3>
                    </div>
                <!-- valg div-->
                <div class="box2">
                    <?php
                    $selector = $_GET["selector"];
                    $validator = $_GET["validator"];

                    if (empty($selector) || empty($validator) ) {
                        echo "Could not vaidater you request";
                    } else {
                        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                            
                    require "includes/dbh.inc.php";
                    $sql = "SELECT * FROM zoobuy WHERE selector=? AND b_usage='unused';";
                    $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "An error occured!2";
                        } else {
                            $hashedTokenB = password_hash($tokenB, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "s", $selector);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                        }
                        if(mysqli_num_rows($result) > 0) {
                        ?>

                        <div class="fable">
                        <table>
                            <tr>
                                <th>Produkt Navn</th>
                                <th>Antal</th>
                                <th>Benyt Billet</th>
                            </tr>
                            <?php
                                while ($row = mysqli_fetch_array($result)) {
                            ?>

                            <form action="includes/ticket.inc.php" method="POST">

                            <tr>
                            <td><?php echo $row['user_product'] ?></td>
                            <input type="hidden" name="hidden_name" value="<?php echo $row["user_product"]; ?>">

                            <input type="hidden" name="orderNr" value="<?php echo $row["user_id"];?>">
                            <td><input type="text" value="<?php echo $row["p_amount"]?>" name="amount" readonly>
                            <?php
                            ?>
                            </td>

                            <td><input type="submit" name="use" style="margin-top: 5px;" value="Benyt Billet"></td>
                            </tr>
                            </form>
                            <?php 
                        } ?>
                        </table>
                        </div>
                            <?php                   
                    
                    } else {
                        echo "Billetterne er brugt";
                    }
                }}

                ?>
                </div>
                </div>
                
    </div>
  </body>
</html>