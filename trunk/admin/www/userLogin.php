<?php

include('../inc/global.config.php');

$in = $_GET;

$id   = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;
$email = isset($in['email']) && $in['email'] != ""               ? $in['email'] : null ;
$password = isset($in['password']) && $in['password'] != ""      ? $in['password'] : null;

session_start(); 

function ValidateEmail($email) 
{ 
   $Syntaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
   if(preg_match($Syntaxe,$email))
      return TRUE; 
   else 
     return FALSE; 
}

function cryptPassword($pw){
  return hash('sha256', $pw, true);;
}

if (ValidateEmail($email)){ 

  
  $userManager = new UserManager();
  if($userManager->verifyUser($email, $password)) {
 
		
		//header(".php"); // redirection to users page
    
  
    $result = 0;
   
    
	}
	else {
		header("Location:userLogin.php?erreur=logout"); //  unknown user
	}
}

if(isset($_GET['erreur']) && $_GET['erreur'] == 'logout'){
	
	session_unset("authentification");
	//header("Location:UserLogin.php?erreur=delog"); To define
}

  //xml output
 echo '<?xml version="1.0" encoding="utf-8"?>';
    echo '<r>';
    echo '<result>'.$result.'</result>';
    echo '<id>'.$id.'</id>';
    echo '<email>'.$email.'</email>';
    //echo '<password>'.$password.'</password>';
    echo '</r>';
?>