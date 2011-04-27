<?php

header("Content-type:application/xml");
include('../inc/global.config.php');

$in = $_POST;

session_start();
ob_start();

$publicUid     = isset($in['publicUid'])     && preg_match("/^([0-9a-f]{32})$/", $in["publicUid"]) ? $in['publicUid'] : null;
$name          = isset($in['name'])          && preg_match("/^[a-zA-Z0-9äëÿüïöâêûîôéèàç'\-_ ]+$/", stripslashes($in["name"])) ? stripslashes($in['name']) : null;
$email         = isset($in['email'])         && filter_var($in['email'], FILTER_VALIDATE_EMAIL) ? $in["email"] : null;
$currencyId    = isset($in['currencyId'])    && is_numeric($in['currencyId']) && $in['currencyId'] > 0 ? $in['currencyId'] : null;
$latitude      = isset($in['latitude'])      && filter_var($in['latitude'], FILTER_VALIDATE_FLOAT) ? $in['latitude'] : null;
$longitude     = isset($in['longitude'])     && filter_var($in['longitude'], FILTER_VALIDATE_FLOAT) ? $in['longitude'] : null;
$webServiceUrl = isset($in['webServiceUrl']) && filter_var($in['webServiceUrl'], FILTER_VALIDATE_URL) ? $in['webServiceUrl'] : null;
$keywordString = isset($in['keywords'])      && $in['keywords'] != "" ? stripslashes($in['keywords']) : null;

$result = 0;
if ($name != null && $latitude != null && $longitude != null && $currencyId != null && $email != null && $webServiceUrl!= null){
  $shopManager = new ShopManager();
  $shop = new Shop($publicUid, $name, $currencyId, $latitude, $longitude, $email);
  $shop->setWebServiceUrl($webServiceUrl);
  
  if ($keywordString != null) {
    $keywordsList = explode(";", $keywordString);
    foreach ($keywordsList as $k) {
      $shop->addKeyword($k);
    }
  }
  
  $result = $shopManager->saveOrUpdate($shop);
  if ($result) {
    $publicUid = $shop->getPublicUid();
    $_SESSION['uusid']= $publicUid;
  }
}

ob_end_flush();

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r>
  <result>$result</result>
  <uid>$publicUid</uid>
</r>
END
?>
