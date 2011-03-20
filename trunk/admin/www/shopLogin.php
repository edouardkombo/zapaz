<?php
include('../inc/global.config.php');

$in = $_POST;

session_start();

function cryptPassword($pw){
  return hash('sha256', $pw, true);;
}

if(isset($_GET['error']) && ($_GET['error'] == "login")) { 
  echo "login or password incorrect";
}
else if (isset($_GET['error']) && ($_GET['error'] == "invalidLogin")) {
  echo "re-enter a valid email";
}
else if (isset($_GET['error']) && ($_GET['error'] == "logout")) {
  echo "Logout succeeded";
}


if (isset($in['email']) && isset($in['publicUId'])){ 
	$login = addslashes($in['email']); 
	$password = addslashes(cryptPassword($in['publicUId'])); 
	

    if (filter_var($login, FILTER_VALIDATE_EMAIL)){ 
      
    
        $shopManager = new ShopManager();
       if($shopManager->checkAuthentication($login, $password)) {
	
            session_register("authentication"); // Register the session
		
            // Session parameters
            $_SESSION['login'] = 'email';
            $_SESSION['password'] = 'password';
		    
             $result = 0;
     
        }
        else {
        header("Location:shopLogin.php?error=login"); // unknown user
        }
        
    }
    else{
      header("Location:shopLogin.php?error=invalidLogin"); // invalid email format 
    }
}
// only the email is provided, in this case the shop intent is to register
else if(isset($in['email']) && !isset($in['publicUId'])){
  header("Location:updateShop.php?email=email");
}

// disconnection
if(isset($_GET['error']) && $_GET['error'] == 'logout'){ 
	session_unset("authentication");
	header("Location:index.php?erreur=logout");
}
//xml authentication output
 echo '<?xml version="1.0" encoding="utf-8"?>';
    echo '<r>';
    echo '<result>'.$result.'</result>';
    echo '</r>';
    
?>
 