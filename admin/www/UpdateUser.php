<?php

include('../inc/global.config.php');

//$in = $_POST;
$in = $_GET;



$id   = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;
$email = isset($in['email']) && ValidateEmail($in['email']);
$password = isset($in['password']) && $in['password'] != null &&cryptPassword($in['password']);

function ValidateEmail($email) 
{ 
   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
   if(preg_match($Syntaxe,$email)) 
      return $email; 
   else 
     return null; 
}

function cryptPassword($pw){
  return crypt($pw);
}

$result = 0;
if ($email != null) {
  $userManager = new UserManager();
  $result = $userManager->saveOrUpdate(new User($email, $password));
}

// updateUser.php?id=2&email=aaa@gmail.com&password=123

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<r>';
echo '<result>'.$result.'</result>';
echo '<email>'.$email.'</email>';
echo '<password>'.$password.'</password>';
echo '</r>';
?>
