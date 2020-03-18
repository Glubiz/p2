<?php
    include "header.php"
?>
    <!-- grid div-->
    <div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php">LOGO HERE</a></div>
        <div class="cart"><p><a href="profil.php">MY PROFILE</a> / <a href="cart.php">CART</a></p></div>
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
            <div class="box1"><p>HEADLINER</p></div>
            <!-- valg div-->
            <div class="box2">
                <div class="one">Billettype</div>
                <div class="two">Stk. Pris</div>
                <div class="three">Antal billetter</div>
                <div class="four">Barn (3-11år)</div>
                <div class="five">99,-</div>
                <div class="six">- 0 +</div>
                <div class="seven">Voksne</div>
                <div class="eight">185,-</div>
                <div class="nine">- 0 +</div>
                <div class="ten">Studerende</div>
                <div class="eleven">148,-</div>
                <div class="twelve">- 0 +</div>
                <div class="start">I alt</div>
                <div class="end">0 DKK</div>
            </div>
            <!-- add to card div-->
            <div class="box3"><p>ADD TO CART</p></div>
        </div>
    </div>
</body>
</html>