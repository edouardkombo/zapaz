<?php

header("Content-type: application/json");
include('../inc/global.config.php');

$publicUid = isset($in['publicUid']) && $in['publicUid'] != '' ? $in['publicUid'] : 0;
$wsUrl = isset($in['wsUrl']) && filter_var($in['wsUrl'], FILTER_VALIDATE_URL) ? $in['wsUrl'] : null;

if ($publicUid != null && $webURI != null) {
  //Gather the stores nearby user
  $webURI = str_replace("getProducts.php", "getInfos.php", $webURI);

  $http = new HttpCommunicator($webURI);
  $http->addParameter("publicUid", $publicUid);

  if ($http->send() && $http->statusIsOk()) {
    echo $http->getResponseContent();
  } else {
    echo '[]';
  }
}
?>
