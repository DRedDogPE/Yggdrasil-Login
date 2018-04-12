<?php
require_once("MojangLoginAPI.php");
session_start();
$Yggdrasil = $_SESSION['yggdrasil'];
$Yggdrasil->validate($_SESSION['token'], $_SESSION['ctoken']);

if($Yggdrasil->getResponse()[0] != "HTTP/1.1 403 Forbidden") {
    $Yggdrasil->invalidate($_SESSION['token'], $_SESSION['ctoken']);
    session_destroy();
    header("Location: login.php");    
}else{
    session_destroy();
    header("Location: login.php");
}