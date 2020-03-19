<?php
    include "header.php"
?>
    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php">LOGO HERE</a></div>
            <div class="cart"><p>MY PROFILE / CART</p></div>
            <!-- Admin check header -->
            <?php
              if (isset($_SESSION['user_id'])) {
                if ($_SESSION['user_email'] == 'test@test.com') {
                  echo '<div class="test"><h3>Welcome Admin</h3>
                  Here are you options for administarting the webshop...</div></div>';
                } else {
                  $user = $_SESSION['user_email'];
                echo '<div class="test"><p>Welcome ' . $user . '</p>
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
                       <h4>Du er logget ind som admin</h4>
                       </div><div class="box2"></div>
                       '; 
                      } else {
                        echo '<!-- overskrift-->
                        <div class="box1">            
                          <h4>Dine køb</h4>
                          </div>
                          <div class="box2">';
                        $dbServername = "mysql35.unoeuro.com";
                        $dbUsername = "solskov_jensen_dk";
                        $dbPassword = "JKQ1TGTK";
                        $dbName = "solskov_jensen_dk_db";
      
                        // Create connection
                        $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
      
                        $sql = "SELECT * FROM zoobuy WHERE user_email='{$_SESSION['user_email']}'";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);
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
                     <input type="text" name="email" placeholder="Email">
                     <input type="password" name="password" placeholder="Password">
                     <button type="submit" name="login-submit">Login</button>
                   </form>
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