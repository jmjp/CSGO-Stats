<?php

$page = $_GET['page'];

if($page == null){
  include("pages/index.php");
}else{
  include("pages/$page.php");
}


?>