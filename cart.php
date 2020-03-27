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
                <form action="includes/buy.inc.php" method="POST">
                    <input type="text" name="fnavn" placeholder="Fornavn">
                    <input type="text" name="enavn" placeholder="Efternavn">
                    <input type="text" name="email" placeholder="Email">
                    <input type="text" name="telefon" placeholder="Telefon nummer">
                    <div>
                        <!-- Til Test-->
                    <label for="">Antal børn</label>
                    <select name="btype">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                    <div>
                    </div>
                    <label for="">Antal Voksne</label>
                    <select name="vtype">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                    </div>
                    <div>
                    <label for="">Antal Studernede</label>
                    <select name="stype">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                    </div>

                    <input type="submit" name="buysubmit" value="Køb">

                </form>
            </div>
            <!-- add to card div-->
            <div class="box3"><p>ADD TO CART</p></div>
        </div>
    </div>
</body>
</html>
