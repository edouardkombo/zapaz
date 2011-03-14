<?php

$in = $_POST;

$id   = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;
$name = isset($in['name']) && $in['name'] != ""                      ? $in['name'] : null;
$currencyId   = isset($in['currencyId'])   && is_numeric($in['currencyId']) && $in['currencyId'] > 0 ? $in['currencyId']   : 0;
$latitude = isset($in['latitude']) && $in['latitude'] != ""          ? $in['latitude'] : null;
$longitude = isset($in['longitude']) && $in['longitude'] != ""       ? $in['longitude'] : null;
//$webServiceUrl = isset($in['webServiceUrl']) && ValidateURL($in['webServiceUrl']);
$email = isset($in['email']) && ValidateEmail($in['email']);
$countOfProducts = isset($in['countOfProducts'])   && is_numeric($in['countOfProducts']) ;
$creationTime = isset($in['creationTime'])   && is_numeric($in['creationTime']) ;
$lastUpdate = isset($in['lastUpdate'])   && is_numeric($in['lastUpdate']) ;

function ValidateEmail($email) 
{ 
   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
   if(preg_match($Syntaxe,$email)) 
      return true; 
   else 
     return false; 
}

function ValidateURL($url){

   if (filter_var($url, FILTER_VALIDATE_URL)) 
      return true; 
   else 
     return false; 
}

$result = 0;

if ($name != null) {
  $shopManager = new ShopManager();
  $result = $shopManager->saveOrUpdate(new Shop($id, $name, $currencyId, $latitude, $longitude, $email, $countOfProducts, $creationTime, $lastUpdate));
}

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<r>';
echo '<result>'.$result.'</result>';
echo '</r>';
?>
