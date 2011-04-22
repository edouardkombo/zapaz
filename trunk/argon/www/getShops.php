<?php

header("Content-type:application/xml");
include('../inc/global.config.php');
$in =$_GET;

$latitude = isset($in['lat']) && filter_var($in['lat'], FILTER_VALIDATE_FLOAT) ? $in['lat'] : null;
$longitude = isset($in['lng']) && filter_var($in['lng'], FILTER_VALIDATE_FLOAT) ? $in['lng'] : null;



//Gather the stores nearby user
$http = new HttpCommunicator(GET_SHOPS);
$http->addParameter("latitude", $latitude);
$http->addParameter("longitude", $longitude);

if ($http->send() && $http->statusIsOk()) {
  echo $http->getResponseContent();
} else {
  echo '<?xml version="1.0" encoding="utf-8"?><root/>';
}
?>
