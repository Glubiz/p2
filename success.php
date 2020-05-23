<?php
session_cache_limiter(FALSE);
session_start();
header('Cache-control: private');
header('Content-Type: text/html; charset=utf-8');

    require "includes/dbh.inc.php";
    include "header.php";

    header("Refresh: 5; url=index.php");
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
            } ?>" width="10%"></a><a href="https://aalborgzoo.dk"><p>Tilbage til Aalborg Zoo.dk</p></a></div>
            <div class="test">
            </div>
        </div>
        <!-- main div-->
        <div class="main">
            <!-- overskrift-->
            <div class="box1"><h1>Tak for dit køb</h1></div>
            <!-- valg div-->
            <div class="box2">
                <div class="success">
                <h3>Du vil blive omdirregeret til forsiden inden længe</h3>

                <p>Fortsat god dag</p>
                
                </div>
    </div>

    <?php
    include "cart.php";
?> 

    <script>
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

    </script>
</body>
</html>