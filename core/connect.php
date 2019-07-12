<?php
function connectsql(){
session_start();
$user = "a_jmg";
$password = "linux123";
$host = "localhost";
$db = "c9";
$conn = new PDO('mysql:host='.$host.';dbname='.$db,$user,$password);
$conn->exec("set names utf8");
return $conn;

}
?>