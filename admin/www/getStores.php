<?php

header("Content-type: application/json");
include('../inc/global.config.php');

$in = $_GET;

$latitude = isset($in['latitude']) && filter_var($in['latitude'], FILTER_VALIDATE_FLOAT) ? $in['latitude'] : null;
$longitude = isset($in['longitude']) && filter_var($in['longitude'], FILTER_VALIDATE_FLOAT) ? $in['longitude'] : null;


$distanceBox = SpatialManager::getGreatSquareAround($latitude, $longitude);

$lat1 = $distanceBox[0][0];
$lng1 = $distanceBox[0][1];
$lat2 = $distanceBox[1][0];
$lng2 = $distanceBox[1][1]; //

$minLat = min($lat1, $lat2);
$maxLat = max($lat1, $lat2);
$minLng = min($lng1, $lng2);
$maxLng = max($lng1, $lng2);

$shopManager = new ShopManager();
$shopsResult = $shopManager->getAllClosestShops($minLat, $maxLat, $minLng, $maxLng);

$json = "[";
foreach ($shopsResult as $sr){
  if($json != "[")
    $json .= ", ";
  $json .= $sr->getJSON();  
}
$json .= "]";

echo $json;


?>

