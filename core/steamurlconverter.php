<?php

include_once('functions.php');
require '/home/ubuntu/workspace/steamauth/userInfo.php';
require '/home/ubuntu/workspace/steamauth/SteamConfig.php';
include_once('infos.php');

$url = $_GET['name'];
$parserid = parse_url($url,PHP_URL_PATH);
$urldecoded = explode("/",$parserid);
$id;

if(filter_var($url, FILTER_VALIDATE_URL))
{
  switch($urldecoded[1]){
      case "profiles":
          $id = $urldecoded[2];
          break;
      case "id":
          $convert = 'http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key='.$steamauth['apikey'].'&vanityurl='.$urldecoded[2].'&format=JSO';
          $userarray = json_decode(file_get_contents($convert), true);
          $status = $userarray['response']['success'];
          if($status == 1){ $id = $userarray['response']['steamid'];} else {$id = "invalid";}
          break;
  }
   
}
else
{
         if(is_int((int)$url) && strlen((int)$url) == 17){
           $id = $url;
        }else{
          $convert = 'http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key='.$steamauth['apikey'].'&vanityurl='.$url.'&format=JSON';
            $userarray = json_decode(file_get_contents($convert), true);
            $status = $userarray['response']['success'];
            if($status == 1){ $id = $userarray['response']['steamid'];} else {$id = "invalid";}
        }
          
}
$jsonv1 = 'https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v1/?appid=730&key='.$steamauth['apikey'].'&steamid='.$id.'&format=JSON';
$myarrayv1 = json_decode(@file_get_contents($jsonv1), true);
if($myarrayv1 != NULL){
  header("Location: ../?page=findplayer&id=$id");
}else{
  header("Location: ../?page=findplayer&id=notpublic");
}


?>