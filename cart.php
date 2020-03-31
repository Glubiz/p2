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
            <div class="box1">
                <h3>Din kurv</h3>
            </div>
            <!-- valg div-->
            <div class="box2">

            <div class="fable" id="fable">

                    <div class="fr" id="first">
                        <div class="fd">Billettype</div>
                        <div class="fd">Stk. Pris</div>
                        <div class="fd">Antal</div>
                    </div>

                    <!-- div til total pris -->
                    <div class="fr" id="last">
                        <div class="fd">I alt</div>
                        <div class="fd"></div>
                        <div class="fd"><p id="total"></p></div>
                    </div>    
                </div>


            </div>
            <!-- add to card div-->
            <div class="box3"><button>Til Betaling</button></div>
        </div>
    </div>

    <script>
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

        // Total pris
        if (localStorage.getItem("y") === null || localStorage.getItem("y") === null) {
            var y = 0;
        } else {
            var y = parseFloat(localStorage.getItem("y"));
            document.getElementById("total").innerHTML = "Total pris: " + y;
        }
    </script>
</body>
</html>
