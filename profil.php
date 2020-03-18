<?php
    include "header.php"
?>
    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php">LOGO HERE</a></div>
            <div class="cart"><p>MY PROFILE / CART</p></div>
            <div class="test">
            <!-- Admin check -->
            <?php
              if (isset($_SESSION['user_id'])) {
                if (isset($_SESSION['user_email']) == 'Test@test.com') {
                  echo '<h3>Welcome Admin</h3>
                  Here are you options for administarting the webshop...';
                }
                else {
                $user = $_SESSION['user_email'];
                echo '<p>Welcome ' . $user . '</p>
                <form action="includes/logout.inc.php" method="post">
                <div id="button1"><button type="submit" name="logout-submit">Logout</button>
                </form></div>';
                 }
              }
                ?>
            </div>
        </div>
        <!-- main div-->
        <div class="main">
            <!-- overskrift-->
            <div class="box1">            
                <?php
              if (isset($_SESSION['user_id'])) {
                $user = $_SESSION['user_email'];
                echo '<h4>Dine køb</h4>';
                 }
                 else {
                 echo '<p>Login</p>';
                }
                ?>
                </div>
            <!-- valg div-->
            <div class="box2">

            <?php
              if (isset($_SESSION['user_id'])) {
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
            <p>Info box</p>
            </div>
            <?php
                 }
                 else {
                 echo '<form action="includes/login.inc.php" method="post">
                 <input type="text" name="email" placeholder="Email">
                 <input type="password" name="password" placeholder="Password">
                 <button type="submit" name="login-submit">Login</button>
               </form>';
                }
                ?>
</div>
        
    
                  
            
        </div>
    </div>
</body>
</html>