<?php

header("Content-type:application/xml");
include('../inc/global.config.php');



//Gather the stores nearby user
$http = new HttpCommunicator(pa);
$http->addParameter("latitude", $latitude);
$http->addParameter("longitude", $longitude);

if ($http->send() && $http->statusIsOk()) {
  echo $http->getResponseContent();
} else {
  echo '<?xml version="1.0" encoding="utf-8"?><root/>';
}
?>