<?php
include_once('functions.php');
require '/home/ubuntu/workspace/steamauth/userInfo.php';
require '/home/ubuntu/workspace/steamauth/SteamConfig.php';

class Information{
    public $id;
    public $name;
    public $photo;
    public $playtime;
    public $kills;
    public $death;
    public $planted;
    public $defuse;
    public $hs;
    public $wins;
    public $ak;
    public $awp;
    public $m4;
    public $kd;
    public $placar;
    public $ratio;
    public $hspercent;
    public $accuracy;
    
}
$meuid = $steamprofile['steamid'];

function getinfo($id){
    global $steamauth, $steamprofile;
    $json = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0001/?appid=730&key='.$steamauth['apikey'].'&steamids='.$id.'&format=JSON';
    $request = file_get_contents($json);
    $myarray = json_decode($request, true);
    $perfilpublic = $myarray['response']['players']['player'][0]['communityvisibilitystate'];
    if($perfilpublic == 3){
        //public
     $myinfo = new Information();
        
     $jsonv1 = 'https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v1/?appid=730&key='.$steamauth['apikey'].'&steamid='.$id.'&format=JSON';
     $myarrayv1 = json_decode(@file_get_contents($jsonv1), true);
     
     $jsonv3 = 'http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?appid=730&key='.$steamauth['apikey'].'&steamid='.$id.'&format=JSON';
     $myarrayv3 = json_decode(@file_get_contents($jsonv3), true);
     if($myarrayv1 != NULL){
         #dados basicos
     $myinfo->name = $myarray['response']['players']['player'][0]['personaname'];
     $myinfo->photo = $myarray['response']['players']['player'][0]['avatarfull'];
     $myinfo->id = $id;
     $myinfo->playtime = number_format((float)($myarrayv3['response']['games'][0]['playtime_forever']  / 60), 1, '.', '');
     $myinfo->kills = $myarrayv1['playerstats']['stats']['total_kills']['value'];
     $myinfo->death = $myarrayv1['playerstats']['stats']['total_deaths']['value'];
     $myinfo->planted = $myarrayv1['playerstats']['stats']['total_planted_bombs']['value'];
     $myinfo->defuse = $myarrayv1['playerstats']['stats']['total_defused_bombs']['value'];
     $myinfo->hs = $myarrayv1['playerstats']['stats']['total_kills_headshot']['value'];
     $myinfo->wins = $myarrayv['playerstats']['stats']['total_wins']['value'];
     $myinfo->ak = $myarrayv1['playerstats']['stats']['total_kills_ak47']['value'];
     $myinfo->awp = $myarrayv1['playerstats']['stats']['total_kills_awp']['value'];
     $myinfo->m4 = $myarrayv1['playerstats']['stats']['total_kills_m4a1']['value'];
     
     
     //dados calculados
     //resultado do comp
     $rounds = $myarrayv1['playerstats']['stats']{'last_match_rounds'}['value'];
     $wins = $myarrayv1['playerstats']['stats']['last_match_wins']['value'];
     $enemy = $rounds - $wins;
     $myinfo->placar = "$wins x $enemy";
     //resultado ratio
     $vitorias = $myarrayv1['playerstats']['stats']['total_matches_won']['value'];
     $played = $myarrayv1['playerstats']['stats']['total_matches_played']['value'];
     $calc = ($vitorias / $played) * 100;
     $sv = number_format((float)$calc, 1, '.', '');
     $myinfo->ratio = $sv;
     //resultado hp percent
     $hs = $myarrayv1['playerstats']['stats']['total_kills_headshot']['value'];
     $killed = $myarrayv1['playerstats']['stats']['total_kills']['value'];
     $tp = ($hs / $killed) * 100;
     $result = number_format((float)$tp, 2, '.', '');
     $myinfo->hspercent = $result;
     //resultado mira
     $acertados = $myarrayv1['playerstats']['stats']['total_shots_hit']['value'];
     $atirados = $myarrayv1['playerstats']['stats']['total_shots_fired']['value'];
     $mira = ($acertados / $atirados) * 100;
     $resultadomira = number_format((float)$mira, 1, '.', '');
     $myinfo->accuracy = $resultadomira;
     //resultado kd
     $mortos = $myarrayv1['playerstats']['stats']['total_kills']['value'];
     $mortes = $myarrayv1['playerstats']['stats']['total_deaths']['value'];
     $calckd = $mortos / $mortes;
     $resultadokd = number_format((float)$calckd, 2, '.', '');
     $myinfo->kd = $resultadokd;
    
      return $myinfo;
     }else{
         return "not public";
     }
     
    }else{
        //privado
        return "not public";
        
    }
    
    
    
}
function comparevalues($valueA, $valueB,$type){
    if($type == "K/D:"){
        $calcA = $valueA * 10;
        $calcB = $valueB * 10 ;
    }else{
        $calcA = $valueA;
        $calcB = $valueB ;
    }
    
    switch($valueA){
        case $valueA > $valueB:
             return '<tr>
                        <td>'.$type.'<div class="progress-bar progress-bar-animated progress-bar-striped bg-primary" role="progressbar" style="width:'.$calcA.'%; height: 20px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">'.$valueA.'</div>
                        <td>'.$type.'<div class="progress-bar progress-bar-animated progress-bar-striped bg-danger" role="progressbar" style="width: '.$calcB.'%; height: 20px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">'.$valueB.'</div></td>
             </tr> ' ;
            break;
        case $valueA < $valueB:
            return '<tr>
                        <td>'.$type.'<div class="progress-bar progress-bar-animated progress-bar-striped bg-danger" role="progressbar" style="width:'.$calcA.'%; height: 20px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">'.$valueA.'</div>
                        <td>'.$type.'<div class="progress-bar progress-bar-animated progress-bar-striped bg-primary" role="progressbar" style="width: '.$calcB.'%; height: 20px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">'.$valueB.'</div></td>
             </tr> ' ;
            
            break;
        case $valueA == $valueB:
             return '<tr>
                        <td>'.$type.'<div class="progress-bar progress-bar-animated progress-bar-striped bg-warning" role="progressbar" style="width:'.$calcA.'%; height: 20px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">'.$valueA.'</div>
                        <td>'.$type.'<div class="progress-bar progress-bar-animated progress-bar-striped bg-warning" role="progressbar" style="width: '.$calcB.'%; height: 20px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">'.$valueB.'</div></td>
             </tr> ' ;
            
            break;
        
        
    }
    
  
    
}
?>