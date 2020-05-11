<?php
session_cache_limiter(FALSE);
session_start();
header('Cache-control: private');
    include "header.php"
?>
    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo hvid.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a> <a id="trigger" href="#"><img src="<?php if (isset($_SESSION["cart"])) {
                echo "images/cart_hvid1.png";
            } else{
                echo "images/cart_hvid.png";
            } ?>" width="10%"></a></div>
            <!-- Admin check header -->
            <?php

                  Echo '<div class="test"></div></div>'; ?> 

                <!-- Admin check main -->
                <!-- main div-->
                <div class="main">
                 <?php
                    if (isset($_SESSION['user_id'])) {
                      $user =  $_SESSION["user_email"];
                      if ($_SESSION['user_email'] == 'test@test.com') {
                       echo '<div class="box1">            
                       <h1>Du er logget ind som admin</h1>
                       </div><div class="box2">
                       <h1>Hi</h1>
                       </div'; 
                      }else {
                        echo '<!-- overskrift-->
                        <div class="box1">            
                          <h1>Din profil</h1>
                          </div>
                          <div class="box2">';

                          include "includes/dbh.inc.php";
                          $conn->set_charset("utf8");
      
                        $sql = "SELECT * FROM zoobuy WHERE user_email=? ORDER BY user_dato DESC";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                          header("Location: ../index.php?error=sqlerror1");
                          exit();
                        }
                        else {
                          mysqli_stmt_bind_param($stmt, "s", $user);
                          mysqli_stmt_execute($stmt);
                          $result = mysqli_stmt_get_result($stmt);
                        }
                        ?>
                        <table class="t1">
                        <thead>
                          <tr>
                            <th>Dato</th>
                            <th>Produkt</th>
                            <th>Pris</th>
                          </tr>
                        </thead>
                        <?php
                          while ($row = mysqli_fetch_assoc($result))
                          {
                        ?>
                        <tr>
                          <td><?php echo $row["user_dato"];?></td>
                          <td><?php echo $row["user_product"];?></td>
                          <td><?php echo $row["user_price"];?></td>
                        </tr>   
                        <?php
                         }
                        ?>
                        </table>
                        <div class="t2">
                          <p>Dine informationer</p>
                        <?php
                          $sql = "SELECT * FROM zoouser WHERE user_email=?";
                          $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                          header("Location: ../index.php?error=sqlerror1");
                          exit();
                        }
                        else {
                          mysqli_stmt_bind_param($stmt, "s", $user);
                          mysqli_stmt_execute($stmt);
                          $result = mysqli_stmt_get_result($stmt);
                        }
                        while ($row = mysqli_fetch_assoc($result))
                          {
                        ?>
                        <form action="changeInfo.inc.php" method="POST">
                          <label for="name">Navn</label>
                          <input type="text" name="name" value="<?php echo $row["user_name"];?>">
                          <label for="name">Email</label>
                          <input type="text" name="email" value="<?php echo $row["user_email"];?>">
                          <label for="name">Adresse</label>
                          <input type="text" name="adress" value="<?php echo $row["user_adresse"];?>">
                          <label for="name">Post Nummer</label>
                          <input type="text" name="postalcode" value="<?php echo $row["user_postnr"];?>">
                          <label for="name">By</label>
                          <input type="text" name="city" value="<?php echo $row["user_by"];?>">
                          <input type="submit" name="changeSubmit" value="Skift">
                          <?php
                          }
                        ?>
                        </form>
                  
                        </div>
                        </div> 
                        <?php
                      }
                    } else {
                      echo '
                <!-- overskrift-->
                <div class="box1">            
                    <h1>Login</h1>';
                    if (isset($_GET['error'])){
                      if ($_GET['error'] == "emptyfields") {
                        echo "<p>Udfyld felter</p>";
                      } elseif ($_GET['error'] == "invalidemailusername"){
                        echo "<p>Invalid email</p>";
                      }
                      elseif ($_GET['error'] == "wrongpassword"){
                        echo "<p>Forkert kode</p>";
                      }
                      elseif ($_GET['error'] == "nouser"){
                        echo "<p>Brugeren findes ikke</p>";
                      } 
                      elseif ($_GET['password'] == "passwordupdated") {
                        echo "<p> Din nye kode er ny klar";
                      }
                    }
                    echo '</div>
                <!-- valg div-->
                <div class="box2">
                    <div class="form">
                <form class="form-ligin" action="includes/login.inc.php" method="post">
                     <input type="text" name="email" placeholder="Email">
                     <input type="password" name="password" placeholder="Password">
                     <button type="submit" name="login-submit">Login</button>
                   </form>
                   <a href="reset-password.php">Glemt din kode?</a>
                </div>
                </div>';
                    }
                 ?> 
        <!-- test users 
              Email: test@test.com
              Kode: Test

              Email: Test1@test.com
              Kode: Test2
      --> 
      <!-- Kurv -->
 <div id="mover">
    <div id="fill">
    </div>
    <div id="kurv">
    <div class="box1">
                <h1>Din kurv</h1>
            </div>
            <!-- valg div-->
            <div class="box2">
            <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
                <th width="30%">Produkt Navn</th>
                <th width="10%">Antal</th>
                <th width="13%">Pris</th>
                <th width="10%">Total Pris</th>
                <th width="17%">Fjern Produkt</th>
            </tr>
 
            <?php
                if(!empty($_SESSION["cart"])){
                    $total = 0;
                    foreach ($_SESSION["cart"] as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $value["item_name"]; ?></td>
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td><?php echo $value["product_price"]; ?> DKK</td>
                            <td>
                                 <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?> DKK</td>
                            <td><a href="aarskort.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span>Fjern Produkt</span></a></td>
 
                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                        if ($total < 0) {
                            $total = 0;
                        } else {
                            $total + ($value["item_quantity"] * $value["product_price"]);
                        }
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <th align="right"><?php echo number_format($total, 2); ?> DKK</th>
                            <td></td>
                        </tr>
                        <?php
                    } else {
                        echo "<div class='fail'><h1 id='fail'>Kurven er tom</h1></div>";
                    }
                ?>
            </table>
            <?php 

            ?>
            <div class="box4"><a href="checkout.php"><button class="bbtn">Til Betaling</button></a></div>
        </div>
                </div>

        </div>
        </div>
        </div>
        
    </div>
    <script>
       
       var mover = document.getElementById('mover');
     var trigger = document.querySelector('#trigger');
     var trigger1 = document.querySelector('#fill');
     function showOnClick() {
         mover.className = mover.className === 'go-right'? 'go-left': 'go-right';
     }
     function hideOnClick(){
       mover.className = mover.className === 'go-left'? 'go-right': 'go-left';
     }
     trigger.addEventListener('click', showOnClick);
     trigger1.addEventListener('click', hideOnClick);

   </script>
</body>
</html>