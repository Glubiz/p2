<?php
    include "header.php"
?>
    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
<<<<<<< HEAD
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo hvid.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a> <a href="cart.php"><img src="images/cart_hvid.png" width="10%"></a></div>
=======
        <div class="logo"><a href="index.php">LOGO HERE</a></div>
            <div class="cart"><p>MY PROFILE / CART</p></div>
>>>>>>> cab2f4a45737c8f664899f7833e0a56e5a1a1105
            <!-- Admin check header -->
            <?php
              if (isset($_SESSION['user_id'])) {
                if ($_SESSION['user_email'] == 'test@test.com') {
                  echo '<div class="test"><h3>Welcome Admin</h3>
<<<<<<< HEAD
                  Here are you options for administarting the webshop...
                  <div id="button1"><button type="submit" name="logout-submit" onclick="includes/logout.inc.php">Logout</button></div></div></div>';
                } else {
                $user = $_SESSION['user_email'];

=======
                  Here are you options for administarting the webshop...</div></div>';
                } else {
                  $user = $_SESSION['user_email'];
>>>>>>> cab2f4a45737c8f664899f7833e0a56e5a1a1105
                echo '<div class="test"><p>Welcome ' . $user . '</p>
                <form action="includes/logout.inc.php" method="post">
                <div id="button1"><button type="submit" name="logout-submit">Logout</button>
                </form></div></div></div>';
<<<<<<< HEAD

                }
                
=======
                }
>>>>>>> cab2f4a45737c8f664899f7833e0a56e5a1a1105
              } else {
                  Echo '<div class="test">You are not logged in</div></div>';
                } ?> 

                <!-- Admin check main -->
                <!-- main div-->
                <div class="main">
                 <?php
                    if (isset($_SESSION['user_id'])) {
                      if ($_SESSION['user_email'] == 'test@test.com') {
                       echo '<div class="box1">            
                       <h4>Du er logget ind som admin</h4>
                       </div><div class="box2"></div>
                       '; 
                      } else {
                        echo '<!-- overskrift-->
                        <div class="box1">            
<<<<<<< HEAD
                          <h3>Dine køb</h3>
                          </div>
                          <div class="box2">';

=======
                          <h4>Dine køb</h4>
                          </div>
                          <div class="box2">';
>>>>>>> cab2f4a45737c8f664899f7833e0a56e5a1a1105
                        $dbServername = "mysql35.unoeuro.com";
                        $dbUsername = "solskov_jensen_dk";
                        $dbPassword = "JKQ1TGTK";
                        $dbName = "solskov_jensen_dk_db";
      
                        // Create connection
                        $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
      
<<<<<<< HEAD
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
=======
                        $sql = "SELECT * FROM zoobuy WHERE user_email='{$_SESSION['user_email']}'";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);
>>>>>>> cab2f4a45737c8f664899f7833e0a56e5a1a1105
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
                          <td><?php echo $row["user_prize"];?></td>
                        </tr>   
                        <?php
                         }
                        ?>
                        </table>
                        <div class="t2">
                        <p>Infobox</p>
                        </div>
                        </div> 
                        <?php
                      }
                    } else {
<<<<<<< HEAD
                      echo '
                <!-- overskrift-->
                <div class="box1">            
                    <h3>Login</h3>';
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
=======
                      echo '<div class="test">You are not logged in</div></div>
                      <!-- main div-->
            <div class="main">
                <!-- overskrift-->
                <div class="box1">            
                    <h3>Login</h3>
                    </div>
                <!-- valg div-->
                <div class="box2">
                <form action="includes/login.inc.php" method="post">
>>>>>>> cab2f4a45737c8f664899f7833e0a56e5a1a1105
                     <input type="text" name="email" placeholder="Email">
                     <input type="password" name="password" placeholder="Password">
                     <button type="submit" name="login-submit">Login</button>
                   </form>
<<<<<<< HEAD
                   <a href="reset-password.php">Glemt din kode?</a>
                </div>
=======
>>>>>>> cab2f4a45737c8f664899f7833e0a56e5a1a1105
                </div>';
                    }
                 ?> 
        <!-- test users 
              Email: test@test.com
              Kode: Test

              Email: Test1@test.com
              Kode: Test2
      --> 
        
    </div>
</body>
</html>