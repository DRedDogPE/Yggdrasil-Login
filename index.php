<?php
require_once("MojangLoginAPI.php");
include("logincheck.php");
$Yggdrasil = $_SESSION['yggdrasil'];
$raw = $Yggdrasil->getRaw();

$Yggdrasil->validate($_SESSION['token'], $_SESSION['ctoken']);
if($Yggdrasil->getResponse()[0] == "HTTP/1.1 403 Forbidden") {
    session_destroy();
    header("Location: login.php");
}
?>
<!doctype html>
<html lang="en">
  <head>

    <title>Minecraft Information</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css<?="?v=".date ("ymdHis", filemtime('bootstrap.min.css'));?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css<?="?v=".date ("ymdHis", filemtime('signin.css'));?>" rel="stylesheet">
  </head>

  <body style="padding:9em 0 0 0!important">
        <center>
        <div class="container">
        <h3>ID: <?=$id?></h3>
        <h3>Name: <?=$Yggdrasil->getName()?></h3>
        <h3>Email: <?=$Yggdrasil->getName()?></h3>
        <h3>Premium: <?=$Yggdrasil->isPremium()?></h3>
        <h5>Raw Data: <? print_r($Yggdrasil->getRaw());?></h5>
        </center>
</div> 
</body>
</html>
