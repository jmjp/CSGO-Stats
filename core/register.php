<?php
include_once('../core/functions.php');
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['id'])){
    header("location: ../pages/dashboard.php");
}
$user = $_REQUEST['username'];
$pass = $_REQUEST['password'];
$email = $_REQUEST['email'];

if(isset($user) && isset($pass) && isset($email)){
    if(register($user,$email,$pass)){
        header('location: login.php');
    }else{
        header('location: ../index.php?error=login');
    }
}else{
    header('location: ../index.php?error=login');
}

?>