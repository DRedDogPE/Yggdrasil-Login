<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once("MojangLoginAPI.php");
if(!((empty($_POST['email']) || empty($_POST['pass'])) || empty($_POST['token1']) )){
    $_SESSION['error'] = "Cannot have empty fields";
    header("Location: login.php");
}
if(isset($_POST['email']) && isset($_POST['pass']) && !(empty($_POST['email']) || empty($_POST['pass']))){
    $Yggdrasil = new MojangLoginAPI();
    if($Yggdrasil->login($_POST['email'], $_POST['pass'])) {
        $_SESSION['user'] = $Yggdrasil->getName();
        $_SESSION['id'] = $Yggdrasil->getID();
        $_SESSION['yggdrasil'] = $Yggdrasil;
        header("Location: index.php");
    }else{
        $_SESSION['error'] = "Incorrect Login";
        header("Location: login.php");
    }
}elseif(isset($_POST['token1']) && !(empty($_POST['token1']) )){
    $Yggdrasil = new MojangLoginAPI();
    if($Yggdrasil->refresh($_POST['token1'], "")) {
        $_SESSION['user'] = $Yggdrasil->getName();
        $_SESSION['id'] = $Yggdrasil->getID();
        $_SESSION['yggdrasil'] = $Yggdrasil;
        header("Location: index.php");
    }else{
        $_SESSION['error'] = "Incorrect Tokens";
        header("Location: login.php");
    }
}else{
    $_SESSION['error'] = "Please enter username and password or tokens";
    header("Location: login.php");
}