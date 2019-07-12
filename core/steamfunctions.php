<?php
include_once('functions.php');
include_once('infos.php');
require '/home/ubuntu/workspace/steamauth/userInfo.php';
require '/home/ubuntu/workspace/steamauth/SteamConfig.php';
if(!isset($_SESSION['steamid'])){
    header("location: index.php");
}
if(!isset($_SESSION)){
    session_start();
}


function steamstatus(){
    global $steamauth, $steamprofile;
    $statys = $steamprofile['profilestate'];
    switch($status){
        case 1:
            echo '<span class="text-success">[Online]</span>';
            break;
        case 2:
            echo '<span class="text-secondary">[Busy]</span>';
            break;
        case 3:
            echo '<span class="text-warning">[Away]</span>';
            break;
        case 4:
            echo '<span class="text-secondary">[Snooze]</span>';
            break;
        case 5:
            echo '<span class="text-primary">[Looking to trade]</span>';
            break;
        case 6:
            echo '<span class="text-primary">[Looking to play]</span>';
            break;
        default:
            echo '<span class="text-danger">[Offline]</span>';
            break;
           
    }
}
function getall(){
    global $steamauth, $steamprofile;
    $im = getinfo($steamprofile['steamid']);
    $json = 'https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v2/?appid=730&key='.$steamauth['apikey'].'&steamid='.$steamprofile['steamid'].'&format=JSON';
    $contents = @file_get_contents($json);
    $response = $http_response_header[0];
    if($response == 'HTTP/1.0 200 OK'){
        $myarray = json_decode($contents, true);
        echo ' <table class="table text-center bg-darkness border-secondary table-bordered table-dark" style="width: 40%">
                        <thead>
                            <tr>
                            <th scope="col" class="bg-light text-dark">Information</th>
                            <th scope="col" class="bg-light text-dark">Value</th>
                            </tr>
                        </thead>
                        <tbody>';
    for($i = 0; $i < 6; $i++){
        if($i != 2){
            $value = $myarray['playerstats']['stats'][$i]['value'];
            $name = $myarray['playerstats']['stats'][$i]['name'];
            $stdname = str_replace('_', ' ', $name);
            echo' <tr>
            <td>'.$stdname.'</td>
            <td>'.$value.'</td> 
            </tr>';
        }
    }
     echo' <tr>
     <td>Playtime</td>
     <td>'.$im->playtime;' Hours</td> 
     </tr>';
     echo' <tr>
     <td>Win ratio</td>
     <td>'.$im->ratio.'%</td> 
     </tr>';
     echo' <tr>
     <td>HS percent</td>
     <td>'.$im->hspercent.'%</td> 
     </tr>';
     echo' <tr>
     <td>Accuracy</td>
     <td>'.$im->accuracy.'%</td> 
     </tr>';
     
    
    echo ' </tbody></table>';
    }else{
       echo' <div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Set your profile to public!</h4>
  <p>this website needs get info from your steam profile, and only method is if you set your profile to public.</p>
  <hr>
  <p class="mb-0">Try when you setup.</p>
</div>';
    }
    
}
function kd(){
    echo '<div class="progress blue">
                    <span class="progress-left">
                        <span class="progress-bar"></span>
                    </span>
                    <span class="progress-right">
                        <span class="progress-bar"></span>
                    </span>
                    <div class="progress-value">K/D:<?php echo playerStats("kd"); ?></div>';
}

function lastmatch_weapon(){
    global $steamauth, $steamprofile;
    $json = 'https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v1/?appid=730&key='.$steamauth['apikey'].'&steamid='.$steamprofile['steamid'].'&format=JSON';
    $contents = @file_get_contents($json); 
    $myarray = json_decode($contents, true);
    $weaponame;
    $played = $myarray['playerstats']['stats']['last_match_favweapon_id']['value'];
    switch($played){
        case 1:
            $weaponame = "Desert Eagle";
            break;
         case 2:
            $weaponame = "Dual Berettas";
            break;
         case 3:
            $weaponame = "Five-Seven";
            break;
         case 4:
            $weaponame = "Glock-18";
            break;
         case 7:
            $weaponame = "AK-47";
            break;
         case 8:
            $weaponame = "AUG";
            break;
         case 9:
            $weaponame = "AWP";
            break;
         case 10:
            $weaponame = "Famas";
            break;
         case 11:
            $weaponame = "G3SG1";
            break;
         case 13:
            $weaponame = "Galil AR";
            break;
         case 14:
            $weaponame = "M249";
            break;
         case 16:
            $weaponame = "M4";
            break;
         case 17:
            $weaponame = "Mac-10";
            break;
         case 19:
            $weaponame = "P90";
            break;
         case 24:
            $weaponame = "UMP-45";
            break;
         case 25:
            $weaponame = "XM1014";
            break;
          case 26:
            $weaponame = "PP-Bizon";
            break;
         case 27:
            $weaponame = "Mag-7";
            break;
         case 28:
            $weaponame = "Negev";
            break;
         case 29:
            $weaponame = "SawedOff";
            break;
         case 30:
            $weaponame = "Tec-9";
            break;
         case 31:
            $weaponame = "Zeus x27";
            break;
         case 32:
            $weaponame = "P2000";
            break;
         case 33:
            $weaponame = "MP7";
            break;
         case 35:
            $weaponame = "Negev";
            break;
        case 35:
            $weaponame = "Negev";
            break;
        case 36:
            $weaponame = "P250";
            break;
        case 38:
            $weaponame = "Scar-20";
            break;
        case 39:
            $weaponame = "SG553";
            break;
        case 40:
            $weaponame = "SSG08";
            break;
        case 42:
            $weaponame = "Knife";
            break;
        case 43:
            $weaponame = "Flashbang";
            break;
        case 44:
            $weaponame = "HE Grenade";
            break;
        case 45:
            $weaponame = "Smoke Grenade";
            break;
        case 46:
            $weaponame = "Molotov";
            break;
        case 47:
            $weaponame = "Decoy Grenade";
            break;
        case 48:
            $weaponame = "Incendiary Grenade";
            break;
        case 49:
            $weaponame = "C4";
            break;
        case 59:
            $weaponame = "Knife";
            break;
        case 60:
            $weaponame = "M4";
            break;
        case 61:
            $weaponame = "USP-S";
            break;
        case 63:
            $weaponame = "CZ75-Auto";
            break;
        default:
            $weaponame = "Invalid";
            break;
    }
    return $weaponame;
}
function lastmatch_kills(){
    global $steamauth, $steamprofile;
    $json = 'https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v1/?appid=730&key='.$steamauth['apikey'].'&steamid='.$steamprofile['steamid'].'&format=JSON';
    $contents = @file_get_contents($json); 
    $myarray = json_decode($contents, true);
    $played = $myarray['playerstats']['stats']['last_match_kills']['value'];
    return $played;
}
function lastmatch_death(){
    global $steamauth, $steamprofile;
    $json = 'https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v1/?appid=730&key='.$steamauth['apikey'].'&steamid='.$steamprofile['steamid'].'&format=JSON';
    $contents = @file_get_contents($json); 
    $myarray = json_decode($contents, true);
    $played = $myarray['playerstats']['stats']['last_match_deaths']['value'];
    return $played;
}
function lastmatch_result(){
     global $steamauth, $steamprofile;
     $json = 'http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v1/?appid=730&key='.$steamauth['apikey'].'&steamid='.$steamprofile['steamid'].'&format=JSON';
     $contents = @file_get_contents($json); 
     $myarray = json_decode($contents, true);
     $played = $myarray['playerstats']['stats']['last_match_wins']['value'];
     if($played == 16){
         return '<span class="badge badge-success badge-pill">You win last match!</span>';
     }else{
         return '<span class="badge badge-danger badge-pill">You lose last match!</span>';
     }
    
}

?>