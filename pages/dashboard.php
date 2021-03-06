<?php
include_once('core/functions.php');
include_once('core/steamfunctions.php');
include_once('core/infos.php');
require 'steamauth/userInfo.php';
if(!isset($_SESSION)){
    session_start();
  }
if(isset($_SESSION['steamid'])){
   
}else{
    header("location: .?page=index");
}
$im = getinfo($steamprofile['steamid']);

?>
<!DOCTYPE HTML>
<HTML lang="pt-br">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>CSGO:MATCH</title>
<!--css-->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet"/>
<link href="css/theme.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<!--js-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body class="bg-main">
    <!--MENU-->
        <nav class="navbar sticky-top navbar-height-80px navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
                <a class="navbar-brand logo-shadow order-0" href="index.php"><strong style="color: rgb(23, 107, 218)">CSGO:</strong>MATCH</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                  <div class="navbar-nav mx-auto order-1">
                    <a class="nav-item nav-link logo-shadow" href="?page=dashboard"></a>
                    <a class="nav-item nav-link logo-shadow" href="?page=findplayer">Find Player</a>
                    <a class="nav-item nav-link logo-shadow" href="?page=compare">Compare</a>
                    <a class="nav-item nav-link logo-shadow" href="?page=support">Help</a>
                  </div>
                </div>
        </div>
        <div class="dropdown order-2">
            <button class="btn btn-secondary bg-transparent border-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?php echo $steamprofile['avatarfull']; ?>" class="rounded-circle" height="54" width="54" style="border: 2px solid white;"> <?php echo $steamprofile['personaname']; ?> <?php steamstatus();?>
            </button>
            <div class="dropdown-menu dropdown-menu-right shadow-bg bg-dark bg-dark text-white" aria-labelledby="dropdownMenuButton">
                <h6 class="dropdown-header">My Account</h6>
                <a class="dropdown-item bg-dark text-white" href="?page=settings">Settings</a>
                <a class="dropdown-item bg-dark text-white" href="steamauth/steamauth.php?logout">Logout</a>
            </div>
        </div>
        </nav>
        
    </div>
    <!--CONTEUDO-->
    
    <div class="container bg-linear text-white mt-3 mb-3 rounded container-shadow">
      <div class="row justify-content-center ">
          <div class="col-sm centered text-center mt-3 shadow-lg" style="font-family: 'Titillium Web', sans-serif;">
            <h3>Welcome <?php echo $steamprofile['personaname'];?>!</h3>
            </div>
            <div class="container mt-3">
            <div class="row ml-3 mr-3">
                    <?php getall(); ?>
                <div class="progress blue">
                    <span class="progress-left">
                        <span class="progress-bar"></span>
                    </span>
                    <span class="progress-right">
                        <span class="progress-bar"></span>
                    </span>
                    <div class="progress-value">K/D: <?php echo $im->kd; ?></div>
                </div>
                <div class="card bg-transparent" style="width: 18rem;">
                  <div class="card-header text-dark text-center bg-light">MY KILLS INFO</div>
                  <ul class="list-group border-white">
                    <li class="list-group-item bg-darkness border-secondary"><img src="img/ak.png"> AK47 <span class="badge badge-primary badge-pill"><?php echo $im->ak;?></span></li>
                    <li class="list-group-item bg-darkness border-secondary"><img src="img/awp.png"> AWP <span class="badge badge-primary badge-pill"><?php echo $im->awp;?></span></li>
                    <li class="list-group-item bg-darkness border-secondary"><img src="img/m4.png"> M4 <span class="badge badge-primary badge-pill"><?php echo $im->m4;?></span></li>
                    <li class="list-group-item bg-darkness border-secondary"><img src="img/hs.png"> HS <span class="badge badge-primary badge-pill"><?php echo $im->hs;?></span></li>
                    <div class="card-header text-dark text-center bg-light">LAST MATCH</div>
                    <li class="list-group-item bg-darkness border-secondary">Favorite Weapon <span class="badge badge-success badge-pill"> <?php echo lastmatch_weapon();?></span></li>
                    <li class="list-group-item bg-darkness border-secondary">Last Match Kills <span class="badge badge-success badge-pill"> <?php echo lastmatch_kills();?></span></li>
                    <li class="list-group-item bg-darkness border-secondary">Last Match Deaths <span class="badge badge-success badge-pill"> <?php echo lastmatch_death();?></span></li>
                    <li class="list-group-item bg-darkness border-secondary">Result  <?php echo lastmatch_result();?></li>
                    <li class="list-group-item bg-darkness border-secondary">Match score <span class="badge badge-primary badge-pill"><?php echo $im->placar;?></span></li>
                  </ul>
                </div>
              </div>
            </div>
      <div class="container text-center">
        <span class="text-muted">All rights reserved <strong style="color: rgb(23, 107, 218)">CSGO:</strong>match© - 2018.</span>
      </div>
</div>
</body>
</HTML>