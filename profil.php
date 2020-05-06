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
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a> <a href="cart.php"><img src="images/cart_hvid.png" width="10%"></a></div>
            <!-- Admin check header -->
            <?php
              if (isset($_SESSION['user_id'])) {
                if ($_SESSION['user_email'] == 'test@test.com') {
                  echo '<div class="test"><h3>Welcome Admin</h3>
                  Here are you options for administarting the webshop...
                  <div id="button1"><form action="includes/logout.inc.php" method="POST"><button type="submit" name="logout-submit">Log ud</button></form></div></div></div>';
                } else {
                $user = $_SESSION['user_email'];

                echo '<div class="test"><p>Du er logget ind som <br>' . $user . '</p>
                <form action="includes/logout.inc.php" method="post">
                <div id="button1"><button type="submit" name="logout-submit">Logout</button>
                </form></div></div></div>';

                }
                
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
                       <h1>Du er logget ind som admin</h1>
                       </div><div class="box2">
                       <h1>Hi</h1>
                       </div'; 
                      }else {
                        echo '<!-- overskrift-->
                        <div class="box1">            
                          <h1>Dine køb</h1>
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
        
    </div>
</body>
</html>