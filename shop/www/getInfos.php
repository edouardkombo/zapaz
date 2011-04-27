<?php

header("Content-type: application/json");
include('../inc/global.config.php');

$in = $_GET;

//Add additional regex for expression for search terms
$publicUid = isset($in['publicUid']) && $in['publicUid'] != '' ? $in['publicUid'] : 0;

$result = 0;
if ($publicUid > 0) {
  $shopManager = new ShopManager();
  $shop = $shopManager->getShopByPublicUid($publicUid);
  
  if ($shop != null) {
    echo $shop->getJSON();
    $result = 1;
  }
}
if ($result = 0) {
  echo "[]";
}

?>
