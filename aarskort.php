<?php
session_cache_limiter(FALSE);
session_start();
header('Cache-control: private');

        $dbServername = "mysql35.unoeuro.com";
        $dbUsername = "solskov_jensen_dk";
        $dbPassword = "JKQ1TGTK";
        $dbName = "solskov_jensen_dk_db";
            
        // Create connection
        $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);


 
    if (isset($_POST["add"])){
        if (isset($_SESSION["cart"])){
            $item_array_id = array_column($_SESSION["cart"],"product_id");
            if (!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["cart"]);
                $item_array = array(
                    'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][$count] = $item_array;
                echo '<script>window.location="aarskort.php"; alert("Produktet føjet til kurven");</script>';
            }else{
                foreach ($_SESSION["cart"] as $keys => $value){
                    if ($value["item_name"] == $_POST["hidden_name"]){
                        $_SESSION["cart"][$keys]['item_quantity'] = $_POST["quantity"];
                        $item_array_id = array_column($_SESSION["cart"],"product_id");
                        if (!in_array($_GET["id"],$item_array_id)){
                            $count = count($_SESSION["cart"]);
                            $item_array = array(
                                'product_id' => $_GET["id"],
                                'item_name' => $_POST["hidden_name"],
                                'product_price' => $_POST["hidden_price"],
                                'item_quantity' => $_POST["quantity"],
                            );
                            $_SESSION["cart"][$count] = $item_array;
                    }
                }
                echo '<script>window.location="aarskort.php"; alert("Produktet føjet til kurven");</script>';
            }}
            
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }
 
    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if ($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["cart"][$keys]);
                    echo '<script>window.location="aarskort.php"; alert("Produktet er fjernet fra kurven");</script>';
                }
            }
        }
    }
?>
<?php
    include "header.php"
?>
 <!-- grid div-->
 <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo hvid.png" alt=""></a></div>
        <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a><a id="trigger" href="#"><img src="<?php if (isset($_SESSION["cart"])) {
                echo "images/cart_hvid1.png";
            } else{
                echo "images/cart_hvid.png";
            } ?>" width="10%"></a></div>
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
            <!-- overskrift-->
            <div class="box1"><h1>Årskort</h1></div>
            <!-- valg div-->
            <div class="box2">

            <div class="fable">

            <?php
            $type = 'Aarskort';
            
            $conn->set_charset("utf8");

            $sql = "SELECT * FROM products WHERE product_type=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              header("Location: testsql.php?error=sqlerror1");
              exit();
            } else {
              mysqli_stmt_bind_param($stmt, "s", $type);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
          }
            if(mysqli_num_rows($result) > 0) {
                ?>
                <table class="producttable">
                                <thead>
                                    <tr>
                                        <th>
                                            <h2>Billettype</h5>
                                        </th>
                                        <th>
                                            <h2>STK. Pris</h5>
                                        </th>
                                        <th>
                                            <h2>Antal</h5>
                                        </th>
                                        <th>
                                            
                                        </th>
                                    </tr>
                                </thead>
                                <?php
 
                while ($row = mysqli_fetch_array($result)) {
 
                    ?>
                    <div class="container">
                        <form method="post" action="aarskort.php?action=add&id=<?php echo $row["product_id"]; ?>">
 
                                <tbody>
                                    <tr>
                                        <td>
                                            <h5><?php echo $row["product_name"]; ?></h5>
                                            <input type="hidden" name="hidden_name" value="<?php echo $row["product_name"]; ?>">
                                        </td>
                                        <td>
                                            <h5><?php echo $row["product_price"]; ?> DKK</h5>
                                            <input type="hidden" name="hidden_price" value="<?php echo $row["product_price"]; ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="quantity" placeholder="0" value="<?php if (isset($_SESSION["cart"])) {
                                                foreach ($_SESSION["cart"] as $key => $value) {
                                                    if ($value["item_name"] == $row["product_name"]) {
                                                        echo $value["item_quantity"];
                                                    }
                                                }
                                            } else {
                                                echo "";
                                            } ?>" min="0">
                                        </td>
                                        <td>
                                        <input type="submit" name="add" style="margin-top: 5px;"
                                       value="Føj til Kurv">
                                        </td>
                                       </tr>
                                    </form>
                        </tbody>
                        </div>
                    <?php
                }
            }
        ?>
        </table>
        </div>
    </div>
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
        <!-- Javascript bliver her brugt til at udregne pris, samt vise hvor mange af de forskellige billetter der er bestilt -->
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