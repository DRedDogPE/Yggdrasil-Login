<?php
session_start();
include("https.php");
?><!DOCTYPE html>
<html lang="en">
  <head>

    <title>Yggdrasil Login</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css<?="?v=".date ("ymdHis", filemtime('bootstrap.min.css'));?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css<?="?v=".date ("ymdHis", filemtime('signin.css'));?>" rel="stylesheet">
  </head>

  <body style="padding:10em 0 9em 0!important">

      <div class="container">
      <center>
      <img src="https://wynndata.tk/assets/images/items/ids/313.png" style="    width: 64px;height: 64px;    max-width: 90%;    image-rendering: pixelated;"/> <!-- LOGO FOR THE MOD -->
      </center>
    <form action="post.php" method="post" class="form-signin">
        <div class="form-signin-heading">
        <h2 style="margin-bottom:0">Please sign in</h2>
        <span style="font-size: 12px;">(using mojang login)</span>
        </div>
        
        <label for="username" class="sr-only">Username</label>
        <input type="text" name="email" id="username" class="form-control <?php if(isset($_SESSION['error'])) echo 'is-invalid';?>" placeholder="Email address" autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="pass" id="inputPassword" class="form-control <?php if(isset($_SESSION['error'])) echo 'is-invalid';?>" placeholder="Password">
        <?php
        if(isset($_SESSION['error'])) {
        ?>
        <div class="invalid-feedback">
        <?php echo $_SESSION['error']; ?>
        </div>
        <?php
        unset($_SESSION['error']);
        } ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <a href="https://account.mojang.com/password" style="font-size: 12px;">Forgot Password?</a>
      </form>
      <div id="yggdrasil">Powered by <a href="http://wiki.vg/Authentication">Yggdrasil Authentication</a></div>
    </div>
  </body>
</html>