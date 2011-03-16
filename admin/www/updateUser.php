<?php

include('../inc/global.config.php');

$in = $_POST;

$id   = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;
$email = isset($in['email']) && $in['email'] != ""               ? $in['email'] : null ;
$password = isset($in['password']) && $in['password'] != ""      ? $in['password'] : null;

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

$result = 0;
if (ValidateEmail($email) ) {
  $userManager = new UserManager();
  $password =crypt($password);
  echo 'Operation done';
  $result = $userManager->saveOrUpdate(new User($email, $password));
}

// updateUser.php?id=2&email=aaa@gmail.com&password=123

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<r>';
echo '<result>'.$result.'</result>';
echo '<id>'.$id.'</id>';
echo '<email>'.$email.'</email>';
echo '<password>'.$password.'</password>';
echo '</r>';
?>
