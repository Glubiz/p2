<?php
    include 'header.php';
?>

    <!-- Intro tekst -->
    <div class="main_block">
        <h1 class="title">P2 projekt</h1>
    </div>
      <br>
      <?php
        if (isset($_SESSION['user_username'])) {
        $name = $_SESSION['user_username'];
          echo '<div class="menu">
                <a href="booking.php"><button class="menu_knap">Booking</button></a>
                <a href="webshop.php"><button class="menu_knap">Webshop</button></a>
                </div>
                <div class="knap">
                <form class="loginout" action="includes/logout.inc.php" method="post">
                <input class="logout" type="submit" name="logout-submit" value="Logout">
                </form>
                </div>
                <button>Test</button>
                <a id="menu" href="#inline"><img src="images/menu.png" alt=""></a>';
        }else {
          echo '<p class="info-box">Hvis du ikke kan de dette, er du ikke logget ind og kan ikke se projektet</p>';
        }

        if ($name == 'Glubiz'){
            echo 'Admin';
        } else {
            echo 'User';
        }
        ?>

    <script>
        $(":button").click(function(){
        $("#menu").();
        }); 
    </script>