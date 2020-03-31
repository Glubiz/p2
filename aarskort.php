<?php
    include "header.php"
?>
    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo Gul.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_gul.png" width="10%"></a> <a href="cart.php"><img src="images/cart_gul.png" width="10%"></a></div>
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
            <div class="box1"><h3>Køb Årskort</h3></div>
            <!-- valg div-->
            <div class="box2">
                <div class="fable">

                    <div class="fr">
                        <div class="fd">Billettype</div>
                        <div class="fd">Stk. Pris</div>
                        <div class="fd">Antal Årskort</div>
                    </div>

                    <div class="fr">
                        <div class="fd">Barn (3-11år)</div>
                        <div class="fd">275 DKK</div>
                        <div class="fd">
                        <button id="minus" onclick="minusbarn()">-</button>
                        <p id="barn" style="display: inline">0</p>
                        <button id="plus" onclick="plusbarn()">+</button>
                        </div>
                    </div>

                    <div class="fr">
                        <div class="fd">Voksne</div>
                        <div class="fd">435 DKK</div>
                        <div class="fd">
                        <button id="minus" onclick="minusvoksen()">-</button>
                        <p id="voksen" style="display: inline">0</p>
                        <button id="plus" onclick="plusvoksen()">+</button>
                        </div>
                    </div>

                    <div class="fr">
                        <div class="fd">Studerende</div>
                        <div class="fd">350 DKK</div>
                        <div class="fd">
                        <button id="minus" onclick="minusstu()">-</button>
                        <p id="studerende" style="display: inline">0</p>
                        <button id="plus" onclick="plusstu()">+</button>
                        </div>
                    </div>

                    <div class="fr">
                        <div class="fd">I alt</div>
                        <div class="fd"></div>
                        <div class="fd"><p id="total" style="display:inline;">0 </p><p style="display:inline;">DKK</p></div>
                    </div>    
                </div>
            </div>
            <!-- add to card div-->
            <div class="box3"><button id="buy" onclick="buy()">Føj til kurv</button></div>
        </div>
    </div>

        <!-- Javascript bliver her brugt til at udregne pris, samt vise hvor mange af de forskellige billetter der er bestilt -->
    <script>
        /*localStorage.clear();*/
        // Henter antal børn
        if (localStorage.getItem("ba") === null) {
            var ba = 0;
        } else {
            var ba = parseFloat(localStorage.getItem("ba"));
            document.getElementById("barn").innerHTML = ba;
        }

        // Henter antal voksene
        if (localStorage.getItem("va") === null) {
            var va = 0;
        } else {
            var va = parseFloat(localStorage.getItem("va"));
            document.getElementById("voksen").innerHTML = va;
        }

        // Henter antal voksene
        if (localStorage.getItem("sa") === null) {
            var sa = 0;
        } else {
            var sa = parseFloat(localStorage.getItem("sa"));
            document.getElementById("studerende").innerHTML = sa;
        }

        var sa = 0;

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
            document.getElementById("barn").innerHTML = ba += 1;
            if (y < 0){
                y = 0;
                document.getElementById("total").innerHTML = y;
            } else {
                document.getElementById("total").innerHTML = y += 275;
            }
        }
        function minusbarn() {
            if (ba>0) {
                document.getElementById("barn").innerHTML = ba -= 1;
                if (y < 0){
                y = 0;
                document.getElementById("total").innerHTML = y;
                } else {
                document.getElementById("total").innerHTML = y -= 275;
                }
            } else{
                document.getElementById("barn").innerHTML = ba = 0;
            }
        }

        function plusvoksen() {
            document.getElementById("voksen").innerHTML = va += 1;
            if (y < 0){
                y = 0;
                document.getElementById("total").innerHTML = y;
            } else {
                document.getElementById("total").innerHTML = y += 435;
                }
        }
        function minusvoksen() {
            if (va>0) {
                document.getElementById("voksen").innerHTML = va -= 1;
                if (y < 0){
                y = 0;
                document.getElementById("total").innerHTML = y;
                } else {
                document.getElementById("total").innerHTML = y -= 435;
                }
            } else{
                document.getElementById("voksen").innerHTML = va = 0;
            }
        }

        function plusstu() {
            document.getElementById("studerende").innerHTML = sa += 1;
            if (y < 0){
                y = 0;
                document.getElementById("total").innerHTML = y;
            } else {
                document.getElementById("total").innerHTML = y += 350;
                }
        }
        function minusstu() {
            if (sa>0) {
                document.getElementById("studerende").innerHTML = sa -= 1;
                if (y < 0){
                y = 0;
                document.getElementById("total").innerHTML = y;
            } else {
                document.getElementById("total").innerHTML = y -= 350;
                }
            } else{
                document.getElementById("studerende").innerHTML = sa = 0;
            }
        }

        // Sørger for total ikke kan gå i minus
        if (ba && sa && va == 0) {
            y = 0 
            document.getElementById("total").innerHTML = y;
        }

        // Laver globale variabler til kurven
        function buy(){
            if (ba > 0) {
                localStorage.setItem("ba", ba);
                
                bp = 0;
                for (let i = 0; i < ba; i++) {
                var bp = bp += 275;
                }
                localStorage.setItem("bp", bp);
            } else {
                localStorage.setItem("ba", ba);
            }

            if (va > 0) {
                localStorage.setItem("va", va);

                vp = 0;
                for (let i = 0; i < va; i++) {
                var vp = vp += 435;
                }
                localStorage.setItem("vp", vp);
            } else {
                localStorage.setItem("va", va);
            }

            if (sa > 0) {
                localStorage.setItem("sa", sa);

                sp = 0;
                for (let i = 0; i < sa; i++) {
                var sp = sp += 350;
                }
                localStorage.setItem("sp", sp);
            } else {
                localStorage.setItem("sa", sa);
            }

            alert("Kurven er opdateret");
            localStorage.setItem("y", y);
            localStorage.setItem('saved', new Date().getTime());
        }
    </script>
</body>
</html>