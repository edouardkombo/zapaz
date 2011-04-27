<?php

header("Content-type: application/json");
include('../inc/global.config.php');

$in = $_GET;

$publicUid = isset($in['publicUid']) && $in['publicUid'] != '' ? $in['publicUid'] : 0;
$wsUrl = isset($in['wsUrl']) && filter_var($in['wsUrl'], FILTER_VALIDATE_URL) ? $in['wsUrl'] : null;

if ($publicUid != null && $wsUrl != null) {
  //Gather the stores nearby user
  $wsUrl = str_replace("getProducts.php", "getInfos.php", $wsUrl);

  $http = new HttpCommunicator($wsUrl);
  $http->addParameter("publicUid", $publicUid);

  if ($http->send() && $http->statusIsOk()) {
    echo $http->getResponseContent();
  } else {
    echo '[]';
  }
}
?>
