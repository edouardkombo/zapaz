<?php

$in = $_POST;

$id   = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;
$name = isset($in['name']) && $in['name'] != ""                      ? $in['name'] : null;
$currencyId   = isset($in['currencyId'])   && is_numeric($in['currencyId']) && $in['currencyId'] > 0 ? $in['currencyId']   : 0;
$latitude = isset($in['latitude']) && $in['latitude'] != ""          ? $in['latitude'] : null;
$longitude = isset($in['longitude']) && $in['longitude'] != ""       ? $in['longitude'] : null;
$email = isset($in['email']) && $in['email'] != ""                   ? $in['email'] : null;

$result = 0;
if ($name != null) {
  $shopManager = new ShopManager();
  $result = $shopManager->saveOrUpdate(new Shop($name, $currencyId, $latitude, $longitude, $email, $id));
}

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<r>';
echo '<result>'.$result.'</result>';
echo '</r>';
?>