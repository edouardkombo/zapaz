<?php

header("Content-type:application/xml");

$http = new HttpCommunicator(ADMIN_PT);
if ($http->send() && $http->statusIsOk()) {
  echo $http->getResponseContent();
} else {
  echo '<?xml version="1.0" encoding="utf-8"?><root/>';
}

?>
