<?php
include_once("connect.php");

$mysqlc = connectsql();

function runSQL($sql){
   global $mysqlc;
   $run = $mysqlc->query($sql);
   $run->execute();
   $row = $run->fetch(PDO::FETCH_ASSOC);
   return $row;
}

function login($username,$password){
   global $mysqlc;
   $md5pass = MD5($password);
   $query = 'select * from users where username = :user and password = :pass';
   $run = $mysqlc->prepare($query);
   $run->bindParam(':user',$username);
   $run->bindParam(':pass',$md5pass);
   $run->execute();
   if($run->rowCount() > 0){
      $row = $run->fetch(PDO::FETCH_ASSOC);
      return $row['id'];
   }else{
      return false;
   }
}
function userinfo($id){
   global $mysqlc;
   if($id > 0){
      $query = 'select * from users where id = :userid';
      $run = $mysqlc->prepare($query);
      $run->bindParam('userid',$id);
      $run->execute();
      $row = $run->fetch(PDO::FETCH_ASSOC);
      return $row;
   }else{
      return false;
   }
}
function register($username,$email,$password){
   global $mysqlc;
   $query = 'select * from users where username = :user or email = :email';
   $run = $mysqlc->prepare($query);
   $run->bindParam(':user',$username);
   $run->bindParam(':email',$email);
   $run->execute();
   if($run->rowCount() == 0){
      $md5pass = MD5($password);
      $queryregistration = 'insert into users(username,password,email,premiumdays)values(:user,:pass,:email,:premiumdays)';
      $reg = $mysqlc->prepare($queryregistration);
      $reg->bindParam(':user',$username);
      $reg->bindParam(':email',$email);
      $reg->bindParam(':pass',$md5pass);
      $reg->bindValue(':premiumdays',0);
      $reg->execute();
      if($reg){
         return true;
      }else{
        return false;
      }

   }else{
      return "already have user with this email or username";
   }
}
function news(){
   global $mysqlc;
   $query = 'select * from news inner join users on news.idCreator = users.id WHERE users.rank = "administrador" ORDER BY news.data DESC LIMIT 0,3';
   $reg = $mysqlc->prepare($query);
   $reg->execute();
   while($row = $reg->fetch(PDO::FETCH_ASSOC)){
      echo '<div class="mx-3 my-3">
      <div class="card bg-dark border-primary" style="width: 18rem;">
          <div class="card-body">
              <h5 class="card-title">'.$row['title'].'</h5>
               <h6 class="card-subtitle mb-2 text-muted">by CSGO:MATCH team</h6>
              <p class="card-text">'.$row['content'].'</p>

          </div>
<div class="card-footer">
          <small class="text-muted">'.$row['data'].'</small>
       </div>
          </div>
      </div>';
   }

}



?>