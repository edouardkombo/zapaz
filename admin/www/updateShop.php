<?php

include('../inc/global.config.php');

$in = $_POST;

session_start();

$id            = isset($in['id'])            && is_numeric($in['id']) && $in['id'] > 0 ? $in['id'] : 0;
$publicUid     = isset($in['id'])            && is_numeric($in['id']) && $in['id'] > 0 ? $in['id'] : 0;
$name          = isset($in['name'])          && preg_match("/^[a-zA-Zäëÿüïöâêûîôéèàç\-_ ]+$/", $in["name"]) ? $in['name'] : null;
$email         = isset($in['email'])         && filter_var($in['email'], FILTER_VALIDATE_EMAIL) ? $in["email"] : null;
$currencyId    = isset($in['currencyId'])    && is_numeric($in['currencyId']) && $in['currencyId'] > 0 ? $in['currencyId'] : 0;
$latitude      = isset($in['latitude'])      && filter_var($in['latitude'], FILTER_VALIDATE_FLOAT) ? $in['latitude'] : null;
$longitude     = isset($in['longitude'])     && filter_var($in['longitude'], FILTER_VALIDATE_FLOAT) ? $in['longitude'] : null;
$webServiceUrl = isset($in['webServiceUrl']) && filter_var($in['webServiceUrl'], FILTER_VALIDATE_URL) ? $in['webServiceUrl'] : null;

$result = 0;

function cryptPassword($pw){
  return hash('sha256', $pw, true);;
}

if ($name != null && $email!=null && $publicUid !=null &&  $webServiceUrl!= null){
  $shopManager = new ShopManager();
  $result = $shopManager->saveOrUpdate(new Shop(cryptPassword($publicUid), $name, $currencyId, $latitude, $longitude, $email, $countOfProducts, $creationTime, $lastUpdate));
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r>
  <result>$result</result>
  <id>$id</id>
  <publicUid>$publicUid</publicUid>
  <name>$name</name>
  <currencyId>$currencyId</currencyId>
  <latitude>$latitude</latitude>
  <longitude>$longitude</longitude>
  <email>$email</email>
  <webServiceUrl>$webServiceUrl</webServiceUrl>
  <countOfProducts>$countOfProducts</countOfProducts>
  <creationTime>$creationTime</creationTime>
  <lastUpdate>$lastUpdate</lastUpdate>
</r>
END
?>
