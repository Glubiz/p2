<?php
    include "header.php"
?>
    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo hvid.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a> <a href="cart.php"><img src="images/cart_hvid.png" width="10%"></a></div>
            <div class="test">
            <?php
              if (isset($_SESSION['user_id'])) {
                $user = $_SESSION['user_email'];
                echo '<p>Welcome ' . $user . '</p>
                <form action="includes/logout.inc.php" method="post">
                <div id="button1"><button type="submit" name="logout-submit">Logout</button>
                </form></div>';
                 }
                 else {
                 echo '<p>You are logged out</p>';
                }
                ?>
            </div>
        </div>
        <!-- main div-->
        <div class="main">
            <!-- overskrift-->
            <div class="box1"><h3>Gavekort Årskort</h3></div>
            <!-- valg div-->
            <div class="box2">
                <div class="one">Billettype</div>
                <div class="two">Stk. Pris</div>
                <div class="three">Antal billetter</div>
                <div class="four">Barn (3-11år)</div>
                <div class="five">275,-</div>
                <div class="six">
                    <button id="minus" onclick="minusbarn()">-</button>
                    <p id="barn" style="display: inline">0</p>
                    <button id="plus" onclick="plusbarn()">+</button></div>
                <div class="seven">Voksne</div>
                <div class="eight">435,-</div>
                <div class="nine">
                    <button id="minus" onclick="minusvoksen()">-</button>
                    <p id="voksen" style="display: inline">0</p>
                    <button id="plus" onclick="plusvoksen()">+</button>
                </div>
                <div class="ten">Studerende</div>
                <div class="eleven">350,-</div>
                <div class="twelve">
                    <button id="minus" onclick="minusstu()">-</button>
                    <p id="studerende" style="display: inline">0</p>
                    <button id="plus" onclick="plusstu()">+</button>
                </div>
                <div class="start">I alt</div>
                <div class="end"><p id="total" style="display:inline;">0 </p><p style="display:inline;">DKK</p></div>
            </div>
            <!-- add to card div-->
            <div class="box3"><button href="">Føj til kurv</button></div>
        </div>
    </div>


        <!-- Javascript bliver her brugt til at udregne pris, samt vise hvor mange af de forskellige billetter der er bestilt -->
    <script>

        var b = 0
        var v = 0
        var s = 0
        var y = sessionStorage.getItem("y");
        if (y = 0) {
            var y = 0
        } else {
            var y = sessionStorage.getItem("y");
            document.getElementById("total").innerHTML = y;
        }

        function plusbarn() {
            document.getElementById("barn").innerHTML = b += 1;
            document.getElementById("total").innerHTML = y += 275;
            sessionStorage.setItem("y", y);
        }
        function minusbarn() {
            if (b>0) {
                document.getElementById("barn").innerHTML = b -= 1;
                document.getElementById("total").innerHTML = y -= 275;
                sessionStorage.setItem("y", y);
            } else{
                document.getElementById("barn").innerHTML = b = 0;
            }
        }

        function plusvoksen() {
            document.getElementById("voksen").innerHTML = v += 1;
            document.getElementById("total").innerHTML = y += 435;
            sessionStorage.setItem("y", y);
        }
        function minusvoksen() {
            if (v>0) {
                document.getElementById("voksen").innerHTML = v -= 1;
                document.getElementById("total").innerHTML = y -= 435;
                sessionStorage.setItem("y", y);
            } else{
                document.getElementById("voksen").innerHTML = v = 0;
            }
        }

        function plusstu() {
            document.getElementById("studerende").innerHTML = s += 1;
            document.getElementById("total").innerHTML = y += 350;
            sessionStorage.setItem("y", y);
        }
        function minusstu() {
            if (s>0) {
                document.getElementById("studerende").innerHTML = s -= 1;
                document.getElementById("total").innerHTML = y -= 350;
                sessionStorage.setItem("y", y);
            } else{
                document.getElementById("studerende").innerHTML = s = 0;
            }
        }
    </script>
</body>
</html>