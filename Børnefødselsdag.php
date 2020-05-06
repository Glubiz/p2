<?php
    include "header.php";
?>

<!-- grid div-->
<div class="grid">
        <!-- header div-->
        <div class="header">
        <div class="logo"><a href="index.php"><img src="images/Aalborg Zoo hvid.png" alt=""></a></div>
            <div class="cart"><a href="profil.php"><img src="images/user_hvid.png" width="10%"></a><a id="trigger" href="#"><img src="images/cart_hvid.png" width="10%"></a></div>
            <div class="test">
            <?php
             /* if (isset($_SESSION['user_id'])) {
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
        <div class="box1">
                <h1>Børnefødselsdag</h1>
            </div>
            <!-- valg div-->
            <div class="box2">
                    <div class="t1 booking">
                        <p>Vi vender tilbage med pris på bookingen når du har booket, herefter kan du tage stilling til om du vil beholde din booking</p>
                        <form action="includes/booking.inc.php" method="POST">
                <input type="hidden" name="type" value="Børnefødselsdag">
                    <div>
                    <label for="name">Navn</label>
                    <input type="text" name="name" placeholder="Navn">
                    </div>

                    <div>
                    <label for="phone">Telefon Nummer</label>
                    <input type="text" name="phone" placeholder="Telefon Nummer">
                    </div>

                    <div>
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Email">
                    </div>

                    <div>
                    <label for="dato">Dato</label>
                    <input type="date" name="dato" value="<?php echo $_GET['date']; ?>">
                    </div>

                    <div>
                    <label for="quantity">Antal Voksne</label>
                    <input type="number" name="quantity1" placeholder="0" min="0">
                    <label for="quantity">Antal Børn</label>
                    <input type="number" name="quantity2" placeholder="0" min="0">
                    </div>

                    <div>
                    <label for="comment">Kommentar</label>
                    <textarea type="text" name="comment" rows="8" cols="80" placeholder="Særlige forbehold eller ønsker"></textarea>
                    </div>

                    <input type="submit" name="bookingSubmit" value="Book">
                </form>
                    </div>
                    <div class="t2">
                        <h4>Info om Børnefødselsdage</h4>
                        <p>Du kommer på en spændende Zoo-fari rundt i Aalborg Zoo, hvor der skal løses sjove og lærerige opgaver hos de forskellige dyr. Arrangementet varer 1½ - 2 timer, hvor man har en guide til rådighed og der er mulighed for at tilkøbe fødselsdagsmenu i Aalborg Zoos spisested Skovbakken. Læs mere <a href="https://aalborgzoo.dk/boernefoedselsdag.aspx">her</a></p>
                    </div>
            </div>
        </div>
    </div>