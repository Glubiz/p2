<?php
  include "header.php";
?>
<!-- Title -->
<div class="main_block">
  <h1 class="login1">Danmarks Bedste Bank</h1>
</div>

<!-- Login -->
<div class="box1">
  <form class="loginnav" action="includes/loginbank.inc.php" method="post">

  <div class="loginbox">
    <label>Username</label>
    <input type="text" name="username" placeholder="Username">
  </div>
  <br>
  <div class="loginbox">
    <label>Password</label>
    <input type="password" name="password" placeholder="Password">
  </div>
  <br>
    <input class="submit" type="submit" name="login-submit" value="Login">
  </form>
</div>

<!-- Signup -->
<div class="box2">
<form class="my-form1" action="includes/signupbank.inc.php" method="POST">

  <div class="loginbox">
    <label>Bank name</label>
    <input type="text" name="bankname" placeholder="Enter Name">
  </div>

  <div class="loginbox">
    <label>Name</label>
    <input type="text" name="name" placeholder="Enter name">
  </div>

  <div class="loginbox">
    <label>Password</label>
    <input class="password" type="password" name="password" placeholder="Enter Password">
  </div>

  <div class="loginbox">
    <label>Kortnummer</label>
    <input type="text" name="kortnummer" placeholder="Enter Cardnumber">
  </div>

  <div class="loginbox">
    <label>3</label>
    <input type="text" name="three" placeholder="Enter 3">
  </div>
  
  <div class="loginbox">
    <label>Amount</label>
    <input type="text" name="amount" placeholder="Enter Amount">
  
  </div>  <div class="loginbox">
    <label>Username</label>
    <input type="text" name="username" placeholder="Enter Username">
  </div>
  
  <div class="loginbox">
    <label>Udløb</label>
    <input type="text" name="udlob" placeholder="Enter Expiration Date ">
  </div>

  <input class="submit" type="submit" name="signup_submit" value="Signup">

</form>
</div>