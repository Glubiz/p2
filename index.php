<?php
session_cache_limiter(FALSE);
session_start();
header('Cache-control: private');
include "includes/dbh.inc.php";

 
    if (isset($_POST["add"])){
        if (isset($_SESSION["cart"])){
            $item_array_id = array_column($_SESSION["cart"],"product_id");
            if (!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["cart"]);
                $item_array = array(
                    'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][$count] = $item_array;
                echo '<script>window.location="dagsbillet.php"</script>';
            }else{
                foreach ($_SESSION["cart"] as $keys => $value){
                    if ($value["product_id"] == $_GET["id"]){
                        unset($_SESSION["cart"][$keys]);
                        $item_array_id = array_column($_SESSION["cart"],"product_id");
                        if (!in_array($_GET["id"],$item_array_id)){
                            $count = count($_SESSION["cart"]);
                            $item_array = array(
                                'product_id' => $_GET["id"],
                                'item_name' => $_POST["hidden_name"],
                                'product_price' => $_POST["hidden_price"],
                                'item_quantity' => $_POST["quantity"],
                            );
                            $_SESSION["cart"][$count] = $item_array;
                    }
                }
                echo '<script>window.location="dagsbillet.php"</script>';
            }}
            
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }
 
    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if ($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["cart"][$keys]);
                    echo '<script>window.location="dagsbillet.php"</script>';
                }
            }
        }
    }

    class Calendar {  
     
        /**
         * Constructor
         */
        public function __construct(){     
            $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
        }
         
        /********************* PROPERTY ********************/  
        private $dayLabels = array("Mon","Tirs","Ons","Tors","Fre","Lør","Søn");
         
        private $currentYear=0;
         
        private $currentMonth=0;
         
        private $currentDay=0;
         
        private $currentDate=null;
         
        private $daysInMonth=0;
         
        private $naviHref= null;
         
        /********************* PUBLIC **********************/  
            
        /**
        * print out the calendar
        */
        public function show() {
            $year  = null;
             
            $month = null;
             
            if(null==$year&&isset($_GET['year'])){
     
                $year = $_GET['year'];
             
            }else if(null==$year){
     
                $year = date("Y",time());  
             
            }          
             
            if(null==$month&&isset($_GET['month'])){
     
                $month = $_GET['month'];
             
            }else if(null==$month){
     
                $month = date("m",time());
             
            }                  
             
            $this->currentYear=$year;
             
            $this->currentMonth=$month;
             
            $this->daysInMonth=$this->_daysInMonth($month,$year);  
             
            $content='<div id="calendar">'.
                            '<div class="box">'.
                            $this->_createNavi().
                            '</div>'.
                            '<div class="box-content">'.
                                    '<ul class="label">'.$this->_createLabels().'</ul>';   
                                    $content.='<div class="clear"></div>';     
                                    $content.='<ul class="dates">';    
                                     
                                    $weeksInMonth = $this->_weeksInMonth($month,$year);
                                    // Create weeks in a month
                                    for( $i=0; $i<$weeksInMonth; $i++ ){
                                         
                                        //Create days in a week
                                        for($j=1;$j<=7;$j++){
                                            $content.=$this->_showDay($i*7+$j);
                                        }
                                    }
                                     
                                    $content.='</ul>';
                                     
                                    $content.='<div class="clear"></div>';     
                 
                            $content.='</div>';
                     
            $content.='</div>';
            return $content;   
        }
         
        /********************* PRIVATE **********************/ 
        /**
        * create the li element for ul
        */
        private function _showDay($cellNumber){
             
            if($this->currentDay==0){
                 
                $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                         
                if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                     
                    $this->currentDay=1;
                     
                }
            }
             
            if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
                 
                $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
                 
                $cellContent = $this->currentDay;
                 
                $this->currentDay++;   
                 
            }else{
                 
                $this->currentDate =null;
     
                $cellContent=null;
            }
                 
             
            return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                    ($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
        }
         
        /**
        * create navigation
        */
        private function _createNavi(){
             
            $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
             
            $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
             
            $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
             
            $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
             
            return
                '<div class="header">'.
                    '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Forige Måned</a>'.
                        '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                    '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Næste Måned</a>'.
                '</div>';
        }
             
        /**
        * create calendar week labels
        */
        private function _createLabels(){  
                     
            $content='';
             
            foreach($this->dayLabels as $index=>$label){
                 
                $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
     
            }
             
            return $content;
        }
         
         
         
        /**
        * calculate number of weeks in a particular month
        */
        private function _weeksInMonth($month=null,$year=null){
             
            if( null==($year) ) {
                $year =  date("Y",time()); 
            }
             
            if(null==($month)) {
                $month = date("m",time());
            }
             
            // find number of days in this month
            $daysInMonths = $this->_daysInMonth($month,$year);
             
            $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
             
            $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
             
            $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
             
            if($monthEndingDay<$monthStartDay){
                 
                $numOfweeks++;
             
            }
             
            return $numOfweeks;
        }
     
        /**
        * calculate number of days in a particular month
        */
        private function _daysInMonth($month=null,$year=null){
             
            if(null==($year))
                $year =  date("Y",time()); 
     
            if(null==($month))
                $month = date("m",time());
                 
            return date('t',strtotime($year.'-'.$month.'-01'));
        }
         
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Zooshoppen</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="style/style1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>

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
            <!-- valg div-->
            <div class="box2">
                <div class="k1"><a href="dagsbillet.php"><button>Dagsbillet</button></a></div>
                <div class="k2"><a href="aarskort.php"><button>Årskort</button></a></div>
                <div class="k3"><a href="gavekort.php"><button>Gavekort</button></a></div>
                <div class="eventkalender">
                  <div class="eo"><h2>Kalender</h2></div>
                  <div class="eb"><p><?php
                    include 'calendar.php';
                    
                    $calendar = new Calendar();
                    
                    echo $calendar->show();
                    ?></p></div>
                </div>
            
            <div class="box3">
                <a href="https://aalborgzoo.dk/mad-og-drikke.aspx"><button>Mad og Drikke</button></a>
                <a href="https://aalborgzoo.dk"><button>Tilbage til hovedsiden</button></a>
            </div>
            </div>
        </div>
    </div>

<?php
    include "cart.php";
?> 
    <script>
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

    if (localStorage.getItem("ba") === null && localStorage.getItem("bp") === null && localStorage.getItem("bad") === null && localStorage.getItem("bpd") === null && localStorage.getItem("va") === null && localStorage.getItem("vp") === null && localStorage.getItem("vad") === null && localStorage.getItem("vpd") === null && localStorage.getItem("sa") === null && localStorage.getItem("sp") === null && localStorage.getItem("sad") === null && localStorage.getItem("spd") === null && localStorage.getItem("bag") === null && localStorage.getItem("bpg") === null && localStorage.getItem("vag") === null && localStorage.getItem("vpg") === null && localStorage.getItem("vag") === null && localStorage.getItem("vpg") === null && localStorage.getItem("sag") === null && localStorage.getItem("spg") === null && localStorage.getItem("ga") === null && localStorage.getItem("gap") === null) {
        document.getElementById("fail").innerHTML = "Kurven er tom";
        document.getElementById("fable").style.visibility = "hidden";
        document.getElementById("hidden").style.visibility = "hidden";
        
    } else {
        /*$(".fable .fr:last").before('<div class="fr" id="first"><div class="fd"id="fo">Billettype</div><div class="fd" id="fo">Stk. Pris</div><div class="fd" id="fo">Antal</div></div>');
        $(".fable .fr:last").before('<div class="fr" id="last"><div class="fd">I alt</div><div class="fd"><button onClick="reset()">Nulstil kurven</button></div><div class="fd"><p id="total"></p></div></div>'); */

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

        // Børne årskort
        if (localStorage.getItem("bag") === null || localStorage.getItem("bpg") === null) {
            var bag = 0;
        } else {
            var bag = localStorage.getItem("bag");
            var bpg = localStorage.getItem("bpg");
            //Jquery
            $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Børne Årskort Gavekort</p></div><div class="fd"><p>275 DKK</p></div><div class="fd"><p>' + bag + '</p></div></div>');
        }

        // Voksen årskort
        if (localStorage.getItem("vag") === null || localStorage.getItem("vpg") === null) {
            var vag = 0;
        } else {
            var vag = localStorage.getItem("vag");
            var vpg = localStorage.getItem("vpg");
            //Jquery
            $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Voksen Årskort Gavekort</p></div><div class="fd"><p>435 DKK</p></div><div class="fd"><p>' + vag + '</p></div></div>');
        }

        // Studerende årskort
        if (localStorage.getItem("sag") === null || localStorage.getItem("spg") === null) {
            var sag = 0;
        } else {
            var sag = localStorage.getItem("sag");
            var spg = localStorage.getItem("spg");
            //Jquery
            $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Studernede Årskort Gavekort</p></div><div class="fd"><p>350 DKK</p></div><div class="fd"><p>' + sag + '</p></div></div>');
        }

        // Studerende årskort
        if (localStorage.getItem("ga") === null || localStorage.getItem("gap") === null) {
            var ga = 0;
        } else {
            var ga = localStorage.getItem("ga");
            var gap = localStorage.getItem("gap");
            //Jquery
            $(".fable .fr:last").before('<div class="fr"><div class="fd"><p>Gavekort</p></div><div class="fd"><p>' + gap + ' DKK</p></div><div class="fd"><p>' + ga + '</p></div></div>');
        }

        // Total pris
        if (localStorage.getItem("y") === null || localStorage.getItem("y") === null) {
            var y = 0;
        } else {
            var y = parseFloat(localStorage.getItem("y"));
            document.getElementById("total").innerHTML = "Total pris: " + y;
        }

        // Nulstil kurven
        function reset() {
            localStorage.clear();
        }
    }
        
    </script>
</body>
</html>