<?php
    session_cache_limiter(FALSE);
    session_start();
    header('Cache-control: private');
    header('Content-Type: text/html; charset=utf-8');
        require "includes/dbh.inc.php";
    
     
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
                    echo '<script>window.location="guide.php"</script>';
                }else{
                    foreach ($_SESSION["cart"] as $keys => $value){
                        if ($value["product_id"] == $_GET["id"]){
                            unset($_SESSION["cart"][$keys]);
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
                    echo '<script>window.location="guide.php"</script>';
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
                        echo '<script>window.location="guide.php"</script>';
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
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a><a id="trigger" href="#"><img src="images/cart_hvid.png" width="10%"></a></div>
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
                <div class="box1"><h1><?php echo "Mulige bookninger"; ?></h1></div>
                <!-- valg div-->
                <div class="box2">
    
                <div class="fable">
    
                <?php
                $type = 'guide';
    
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

                                            </th>
                                        </tr>
                                    </thead>
                                    <?php
     
                    while ($row = mysqli_fetch_array($result)) {
     
                        ?>
                        <div class="container">
                            <form method="post" action="arrangementer.php?action=add&id=<?php echo $row["product_id"]; ?>">
     
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h5><?php echo $row["product_name"]; ?></h5>
                                                <input type="hidden" name="hidden_name" value="<?php echo $row["product_name"]; ?>">
                                            </td>
                                            <td>
                                                <a href="<?php echo $row['product_name'] . '.php?date=' . $_GET['date'];?>"><h5>Book</h5></a>
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
    
        <?php
        include "cart.php";
    ?> 
    
        <!-- Javascript bliver her brugt til at udregne pris, samt vise hvor mange af de forskellige billetter der er bestilt -->
        <script>
            //localStorage.clear();
            // Henter antal børn
            if (localStorage.getItem("bad") === null) {
                var bad = 0;
            } else {
                var bad = parseFloat(localStorage.getItem("bad"));
                document.getElementById("barn").innerHTML = bad;
            }
    
            // Henter antal voksene
            if (localStorage.getItem("vad") === null) {
                var vad = 0;
            } else {
                var vad = parseFloat(localStorage.getItem("vad"));
                document.getElementById("voksen").innerHTML = vad;
            }
    
            // Henter antal voksene
            if (localStorage.getItem("sad") === null) {
                var sad = 0;
            } else {
                var sad = parseFloat(localStorage.getItem("sad"));
                document.getElementById("studerende").innerHTML = sad;
            }
    
            // Sætter timer
            let minutes = 30;
            let saved = localStorage.getItem('saved')
            if (saved && (new Date().getTime() - saved > minutes * 60 * 1000)) {
                localStorage.clear();
            }
    
            // Henter total prisen
            if (localStorage.getItem("y") === null) {
                var y = 0;
            } else {
                var y = parseFloat(localStorage.getItem("y"));
                document.getElementById("total").innerHTML = y;
            }
    
            // Funktionsknapperne til + - knapperne
            function plusbarn() {
                document.getElementById("barn").innerHTML = bad += 1;
                if (y < 0){
                    y = 0;
                    document.getElementById("total").innerHTML = y;
                } else {
                    document.getElementById("total").innerHTML = y += 99;
                }
            }
            function minusbarn() {
                if (bad>0) {
                    document.getElementById("barn").innerHTML = bad -= 1;
                    if (y < 0){
                    y = 0;
                    document.getElementById("total").innerHTML = y;
                    } else {
                    document.getElementById("total").innerHTML = y -= 99;
                    }
                } else{
                    document.getElementById("barn").innerHTML = bad = 0;
                }
            }
    
            function plusvoksen() {
                document.getElementById("voksen").innerHTML = vad += 1;
                if (y < 0){
                    y = 0;
                    document.getElementById("total").innerHTML = y;
                } else {
                    document.getElementById("total").innerHTML = y += 185;
                    }
            }
            function minusvoksen() {
                if (vad>0) {
                    document.getElementById("voksen").innerHTML = vad -= 1;
                    if (y < 0){
                    y = 0;
                    document.getElementById("total").innerHTML = y;
                    } else {
                    document.getElementById("total").innerHTML = y -= 185;
                    }
                } else{
                    document.getElementById("voksen").innerHTML = vad = 0;
                }
            }
    
            function plusstu() {
                document.getElementById("studerende").innerHTML = sad += 1;
                if (y < 0){
                    y = 0;
                    document.getElementById("total").innerHTML = y;
                } else {
                    document.getElementById("total").innerHTML = y += 148;
                    }
            }
            function minusstu() {
                if (sad>0) {
                    document.getElementById("studerende").innerHTML = sad -= 1;
                    if (y < 0){
                    y = 0;
                    document.getElementById("total").innerHTML = y;
                } else {
                    document.getElementById("total").innerHTML = y -= 148;
                    }
                } else{
                    document.getElementById("studerende").innerHTML = sad = 0;
                }
            }
    
            // Sørger for total ikke kan gå i minus
            if (bad && sad && vad == 0) {
                y = 0 
                document.getElementById("total").innerHTML = y;
            }
    
            // Laver globale variabler til kurven
            function buy(){
                if (bad > 0) {
                    localStorage.setItem("bad", bad);
                    
                    bpd = 0;
                    for (let i = 0; i < bad; i++) {
                    var bpd = bpd += 99;
                    }
                    localStorage.setItem("bpd", bpd);
                } else {
                    localStorage.setItem("bad", bad);
                }
    
                if (vad > 0) {
                    localStorage.setItem("vad", vad);
    
                    vpd = 0;
                    for (let i = 0; i < vad; i++) {
                    var vpd = vpd += 185;
                    }
                    localStorage.setItem("vpd", vpd);
                } else {
                    localStorage.setItem("vad", vad);
                }
    
                if (sad > 0) {
                    localStorage.setItem("sad", sad);
    
                    spd = 0;
                    for (let i = 0; i < sad; i++) {
                    var spd = spd += 148;
                    }
                    localStorage.setItem("spd", spd);
                } else {
                    localStorage.setItem("sad", sad);
                }
    
                alert("Kurven er opdateret");
                localStorage.setItem("y", y);
                localStorage.setItem('saved', new Date().getTime());
                location.reload();
            }
    
        //Kurv
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
    
        if (localStorage.getItem("ba") === null && localStorage.getItem("bp") === null && localStorage.getItem("bad") === null && localStorage.getItem("bpd") === null && localStorage.getItem("va") === null && localStorage.getItem("vp") === null && localStorage.getItem("vad") === null && localStorage.getItem("vpd") === null && localStorage.getItem("sa") === null && localStorage.getItem("sp") === null && localStorage.getItem("sad") === null && localStorage.getItem("spd") === null && localStorage.getItem("bag") === null && localStorage.getItem("bpg") === null && localStorage.getItem("vag") === null && localStorage.getItem("vpg") === null && localStorage.getItem("vag") === null && localStorage.getItem("vpg") === null && localStorage.getItem("sag") === null && localStorage.getItem("spg") === null && localStorage.getItem("ga") === null && localStorage.getItem("gap") === null) {
            document.getElementById("fail").innerHTML = "Kurven er tom";
            document.getElementById("fable").style.visibility = "hidden";
            document.getElementById("hidden").style.visibility = "hidden";
            
        } else {
            // Børne årskort
            if (localStorage.getItem("ba") === null || localStorage.getItem("bp") === null) {
                var ba = 0;
            } else {
                var ba = localStorage.getItem("ba");
                var bp = localStorage.getItem("bp");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Børne Årskort</p></div><div class="fd"><p>275 DKK</p></div><div class="fd"><p>' + ba + '</p></div></div>');
            }
    
            // Børne billet
            if (localStorage.getItem("bad") === null || localStorage.getItem("bpd") === null) {
                var bad = 0;
            } else {
                var bad = localStorage.getItem("bad");
                var bpd = localStorage.getItem("bpd");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Børne Billetter</p></div><div class="fd"><p>99 DKK</p></div><div class="fd"><p>' + bad + '</p></div></div>');
            }
    
            // Voksen årskort
            if (localStorage.getItem("va") === null || localStorage.getItem("vp") === null) {
                var va = 0;
            } else {
                var va = localStorage.getItem("va");
                var vp = localStorage.getItem("vp");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Voksen Årskort</p></div><div class="fd"><p>435 DKK</p></div><div class="fd"><p>' + va + '</p></div></div>');
            }
    
            // Voksen billet
            if (localStorage.getItem("vad") === null || localStorage.getItem("vpd") === null) {
                var vad = 0;
            } else {
                var vad = localStorage.getItem("vad");
                var vpd = localStorage.getItem("vpd");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Voksen Billetter</p></div><div class="fd"><p>185 DKK</p></div><div class="fd"><p>' + vad + '</p></div></div>');
            }
    
            // Studerende årskort
            if (localStorage.getItem("sa") === null || localStorage.getItem("sp") === null) {
                var sa = 0;
            } else {
                var sa = localStorage.getItem("sa");
                var sp = localStorage.getItem("sp");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Studernede Årskort</p></div><div class="fd"><p>350 DKK</p></div><div class="fd"><p>' + sa + '</p></div></div>');
            }
    
            // Studerende billet
            if (localStorage.getItem("sad") === null || localStorage.getItem("spd") === null) {
                var sad = 0;
            } else {
                var sad = localStorage.getItem("sad");
                var spd = localStorage.getItem("spd");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Studernede Billetter</p></div><div class="fd"><p>148 DKK</p></div><div class="fd"><p>' + sad + '</p></div></div>');
            }
    
            // Børne årskort
            if (localStorage.getItem("bag") === null || localStorage.getItem("bpg") === null) {
                var bag = 0;
            } else {
                var bag = localStorage.getItem("bag");
                var bpg = localStorage.getItem("bpg");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Børne Årskort Gavekort</p></div><div class="fd"><p>275 DKK</p></div><div class="fd"><p>' + bag + '</p></div></div>');
            }
    
            // Voksen årskort
            if (localStorage.getItem("vag") === null || localStorage.getItem("vpg") === null) {
                var vag = 0;
            } else {
                var vag = localStorage.getItem("vag");
                var vpg = localStorage.getItem("vpg");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Voksen Årskort Gavekort</p></div><div class="fd"><p>435 DKK</p></div><div class="fd"><p>' + vag + '</p></div></div>');
            }
    
            // Studerende årskort
            if (localStorage.getItem("sag") === null || localStorage.getItem("spg") === null) {
                var sag = 0;
            } else {
                var sag = localStorage.getItem("sag");
                var spg = localStorage.getItem("spg");
                //Jquery
                $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Studernede Årskort Gavekort</p></div><div class="fd"><p>350 DKK</p></div><div class="fd"><p>' + sag + '</p></div></div>');
            }
    
            // Total pris
            if (localStorage.getItem("y") === null || localStorage.getItem("y") === null) {
                var y = 0;
            } else {
                var y = parseFloat(localStorage.getItem("y"));
                document.getElementById("totalp").innerHTML = "Total pris: " + y;
            }
    
            // Nulstil kurven
            function reset() {
                localStorage.clear();
            }
        }
        </script>
    </body>
    </html>
?>