<?php
include_once('functions.php');
if(!isset($_SESSION)){
    session_start();
}
$user = $_REQUEST['username'];
$pass = $_REQUEST['password'];
if(isset($user) && isset($pass)){
    $id = login($user,$pass);
    if($id > 0){
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $user;
        $_SESSION['password'] = $pass;
        header('location: ../dashboard.php');
        exit();
    }else{
        header('location: ../index.php?error=login');
    }
}else{
    header('location: ../index.php?error=login');
}


?>