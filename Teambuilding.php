<?php
    include "header.php";
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
        <div class="box1">
                <h1>Teambuilding</h1>
            </div>
            <!-- valg div-->
            <div class="box2">
                    <div class="t1 booking">
                        <p>Vi vender tilbage med pris på bookingen når du har booket, herefter kan du tage stilling til om du vil beholde din booking</p>
                <form action="includes/booking.inc.php" method="POST">

                    <input type="hidden" name="type" value="Teambuilding">
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

                    <input class="bbtn1" type="submit" name="bookingSubmit" value="Book">
                </form>
                    </div>
                    <div class="t2">
                    <h4>Info om Teambuilding</h4>
                    <p>Grupper af forskellig størrelse og fra forskellige firmaer, foreninger eller andet har mulighed for benytte Aalborg Zoo til aktiviteter målrettet efter de enkeltes ønsker.<br><br>

                    Aktiviteterne er en kombination af teambuilding og unikke oplevelser med dyrene i Zoo. Mindre grupper dyster mod hinanden om opgaver vedr. dyr, som både giver fysisk aktivitet, tankevirksomhed, påvirker sanser og som for mange vil være en smule (eller meget!) grænseoverskridende! Læs mere <a href="https://aalborgzoo.dk/dyst-med-dyr.aspx" id="underscore">her</a></p>
                </div>
            </div>
        </div>
    </div>