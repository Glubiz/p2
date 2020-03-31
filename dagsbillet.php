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
            <div class="box1"><h3>Dagsbilletter</h3></div>
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
                        <div class="fd">99 DKK</div>
                        <div class="fd">
                        <button id="minus" onclick="minusbarn()">-</button>
                        <p id="barn" style="display: inline">0</p>
                        <button id="plus" onclick="plusbarn()">+</button>
                        </div>
                    </div>

                    <div class="fr">
                        <div class="fd">Voksne</div>
                        <div class="fd">185 DKK</div>
                        <div class="fd">
                        <button id="minus" onclick="minusvoksen()">-</button>
                        <p id="voksen" style="display: inline">0</p>
                        <button id="plus" onclick="plusvoksen()">+</button>
                        </div>
                    </div>

                    <div class="fr">
                        <div class="fd">Studerende</div>
                        <div class="fd">148 DKK</div>
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
        }
    </script>
</body>
</html>