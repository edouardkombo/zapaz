<?php

include('../inc/global.config.php');

if($publicUid!=null && $webURI!=NULL){
  //Gather the stores nearby user
  $http = new HttpCommunicator(USER_LOGIN);

  $http->addParameter("publicUid", $publicUid);
  $http->addParameter("search1", $search1);
  $http->addParameter("search2", $search2);

  if ($http->send() && $http->statusIsOk()) {
    echo $http->getResponseContent();
  } else {
    echo '<?xml version="1.0" encoding="utf-8"?><r/>';
  }
}
?>
