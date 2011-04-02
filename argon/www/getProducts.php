<?php

include('../inc/global.config.php');

//$latitude = isset($in['latitude']) && filter_var($in['latitude'], FILTER_VALIDATE_FLOAT) ? $in['latitude'] : null;
//$longitude = isset($in['longitude']) && filter_var($in['longitude'], FILTER_VALIDATE_FLOAT) ? $in['longitude'] : null;

$latitude = 49.115399672969794;
$longitude = 6.175689243408215;

//Gather the stores nearby user
$uri = 'http://admin.zap.com/getStores.php';
$http = new HttpCommunicator($uri);
$http->addParameter("latitude", $latitude);
$http->addParameter("longitude", $longitude);


if ($http->send() && $http->statusIsOk()) {
  echo $http->getResponseContent();
} else {
  echo '<?xml version="1.0" encoding="utf-8"?><root/>'; 
}

//$xml = simplexml_load_string($response);
 

?>
