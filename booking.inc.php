<?php
if (isset($_POST['bookingSubmit'])) {
    require "dbh.inc.php";

    $type = $_POST['type'];
    $navn = $_POST['name'];
    $telefon = $_POST['phone'];
    $email = $_POST['email'];
    $dato = $_POST['dato'];
    $voksen = $_POST['quantity1'];
    $børn = $_POST['quantity2'];
    $kommentar = $_POST['comment'];

    if ($type == 'Teambuilding' || $type == 'Bag kulisserne') {
        $status = 'pending';
    } else {
        $status = 'completed';
    }

    $sql = "INSERT INTO booking (date, name, email, mobile, adults, message, children, type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "An error occured!";
    } else {
        mysqli_stmt_bind_param($stmt, "sssssssss", $dato, $navn, $email, $telefon, $voksen, $kommentar, $børn, $type, $status);
        mysqli_stmt_execute($stmt);
    }

    // Sender mail
    $to = $email;
            
    $subjekt = 'Tak for dit køb';

    $message = '<img src="http://www.solskov-jensen.dk/p2/images/Aalborg Zoo Gul.png" alt="">';
    $message .= '<h1>Tak for din bookning vi vender tilbage så snart vi har behandlet din forspørgsel</h1>';

    $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Content-type: text/html; charset=utf8\r\n";

    mail($to, $subjekt, $message, $headers);

    //Zoo mail
    $zooemail = "glubiz13808@hotmail.com";
    $to = $zooemail;

    $subjekt = 'Der er fortaget en ny event bookning';

    $message = '<img src="http://www.solskov-jensen.dk/p2/images/Aalborg Zoo Gul.png" alt="">';
    $message .= '<h1>Følgende kunde har forespurgt om en event booking</h1>';
    $message .= '<p>Neden for finder ku kundens forspørgsel: </p>';

    $message .= '<br>Navn: ' . $navn;
    $message .= '<br>Email: ' . $email;
    $message .= '<br>Telenor Nummer: ' . $telefon;
    $message .= '<br>Type bookning: ' . $type;
    $message .= '<br>Tid: ' . $dato;
    $message .= '<br>Antal Voksne: ' . $voksen;
    $message .= '<br>Antal Børn: ' . $børn;
    $message .= '<br>Kommentare: ' . $kommentar;

    $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
    $headers .= "Content-type: text/html; charset=utf8\r\n";

    mail($to, $subjekt, $message, $headers);

    header("Location: ../index.php?status=success");
    exit();

} else {
    header("Location: ../index.php?status=failed");
    exit();
}