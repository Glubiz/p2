<?php
session_cache_limiter(FALSE);
session_start();
ob_start();

if (isset($_POST['buysubmit'])) {
    require "dbh.inc.php";

    $fnavn = $_POST['fnavn'];
    $enavn = $_POST['enavn'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $btype = $_POST['btype'];
    $vtype = $_POST['vtype'];
    $stype = $_POST['stype'];
    $navn = $fnavn . " " . $enavn;
    $pris = 100;
    date_default_timezone_set("Europe/Copenhagen");
    $date = date("Y-m-d H:i:s");
    $randomkode = random_bytes(8);

    // Tjekker for tomme felter 
    if (empty($fnavn) || empty($enavn) || empty($email) || empty($telefon)) {
        header ("Location: ../cart.php?error=emptyfields&fname=".$fnavn."&ename=".$enavn."&email=".$email."&telefon=".$telefon);
        exit();

    //Kigger om der findes nogle brugere i systemet
    } else {
        $sql = "SELECT * FROM zoouser WHERE user_email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header ("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
        // Skaber ny bruger
        if (!$row = mysqli_fetch_assoc($result)) {
            $sql = "INSERT INTO zoouser(user_name, user_email, user_password) VALUES (?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header ("Location: ../index.php?error=sqlerror2");
                    exit();

                    } else {
                    mysqli_stmt_bind_param($stmt, "sss", $navn, $email, $randomkode);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    }

            $sql = "INSERT INTO zoobuy(user_name, user_email, user_product, user_prize, user_dato) VALUES (?, ? ,? ,? , '$date');";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header ("Location: ../index.php?error=sqlerror3");
                    exit();

                    } else {
                    mysqli_stmt_bind_param($stmt, "ssss", $navn, $email, $btype, $pris);
                    mysqli_stmt_execute($stmt);
                    
                    // Skal ændres
                    $to = $email;
                    $url = "http://www.solskov-jensen.dk/p2/reset-password.php";

                    $subjekt = 'Tak for din bestilling';
                
                    $message = '<h3>Tak for din bestilling</h3>';
                    $message .= '<p>Du kan lave en kode ved at gå ind på linket nedenfor, og indtaste din email</p>';
                    $message .= $url;
                
                    $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
                    $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
                    $headers .= "Content-type: text/html\r\n";
                
                    mail($to, $subjekt, $message, $headers);

                    header ("Location: ../index.php?success=sucess1");
                    exit();
                    }
        // Hvis brugen findes tilføjer køb
        } else {
            $sql = "INSERT INTO zoobuy(user_name, user_email, user_product, user_prize, user_dato) VALUES (?, ? ,? ,? , '$date');";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
            header ("Location ../index.php?error=sqlerror4");
            exit();
            } else {
            mysqli_stmt_bind_param($stmt, "ssss", $navn, $email, $btype, $pris);
            mysqli_stmt_execute($stmt); 
            

            // Skal ændres
            $to = $email;

            $subjekt = 'Tak for din bestilling';
        
            $message = '<h3>Tak for din bestilling</h3>';
            $message .= '<p></p>';
        
            $headers = "From: ZooShoppen <solskovjensenWOM@gmail.com>\r\n";
            $headers .= "Rely-To: <solskovjensenWOM@gmail.com>\r\n";
            $headers .= "Content-type: text/html\r\n";
        
            mail($to, $subjekt, $message, $headers);

            header ("Location: ../index.php?success=sucess2");
            exit();
            }
        }
    }


//Tag på Bones
} else {
   header("location: https://aalborg.taw.bones.dk/#/");
   exit();
}
