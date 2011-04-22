<?php

header("Content-type:application/xml");
include('../inc/global.config.php');

$session = new SessionManager();

$in = $_POST;

$id = isset($in['id'])   && filter_var($in['id'], FILTER_VALIDATE_INT) && $in['id'] > 0 ? $in['id']   : 0;
$choice = isset($in['choice']) && $in['choice'] != ""               ? $in['choice'] : null;
$startTime    = 0;
$endTime      = 0;
$creationTime = 0;
$lastUpdate   = 0;

$result = 0;
$user = $session->getUser();
if ($user != null && strlen($choice) <= 70) {
  $userManager = new UserManager();
  $result = $userManager->saveOrUpdateChoice( new UserChoice($choice, $startTime, $endTime, $user->getId(), $creationTime, $lastUpdate));
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>';
<r>
  <result>$result</result>
  <id>$id</id>
  <userId>$userId</userId>
  <choice>$choice</choice>
</r>
END;
?>
