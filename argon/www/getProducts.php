<?php

header("Content-type: application/json");
include('../inc/global.config.php');

$publicUid = isset($in['publicUid']) && $in['publicUid'] != '' ? $in['publicUid'] : 0;
$search1 = isset($in['search1']) ? $in['search1'] : null;
$search2 = isset($in['search2']) ? $in['search2'] : null;
$wsUrl = isset($in['wsUrl']) && filter_var($in['wsUrl'], FILTER_VALIDATE_URL) ? $in['wsUrl'] : null;

if ($publicUid != null && $wsUrl != null) {
  //Gather the stores nearby user
  $http = new HttpCommunicator($wsUrl);

  $http->addParameter("publicUid", $publicUid);
  $http->addParameter("search1", $search1);
  $http->addParameter("search2", $search2);


  if ($http->send() && $http->statusIsOk()) {
    echo $http->getResponseContent();
  } else {
    echo '[]';
  }
}
?>
