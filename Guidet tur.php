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
                <h1>Guidet tur</h1>
            </div>
            <!-- valg div-->
            <div class="box2">
                    <div class="t1 booking">
                        <p>Vi vender tilbage med pris på bookingen når du har booket, herefter kan du tage stilling til om du vil beholde din booking</p>
                        <form action="includes/booking.inc.php" method="POST">
                <input type="hidden" name="type" value="Guidet tur">
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
                    <h4>Info om Guidet tur</h4>
                    <p>Leder du efter en spændende oplevelse sammen med familie og venner, eller vil du give dine kunder, foreningsmedlemmer eller kollegaer en spændende og anderledes oplevelse, så er en rundvisning i Aalborg Zoo noget for dig. Få et kig ind i hverdagen i Zoo og hør de mange sjove og lærerige historier om dyrene, eller oplev nogle af Aalborg Zoo’s mindste dyr på helt tæt hold – og prøv måske endda at røre dem.</p>
                </div>
            </div>
        </div>
    </div>