<?php

include('../inc/global.config.php');

//$in = $_POST;
$in = $_GET;

 $id = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;
 $userId = isset($in['userId'])   && is_numeric($in['userId']) && $in['userId'] > 0 ? $in['userId']   : 0;
 $choice = isset($in['choice']) && $in['choice'] != ""               ? $in['choice'] : null;
 $startTime;
 $endTime;
 $creationTime;
 $lastUpdate;
   



$result = 0;
if (strlen($choice)<=70) {
  $userManager = new UserManager();
  $result = $userManager->saveOrUpdateChoice( new UserChoice($choice, $startTime, $endTime, $userId, $creationTime, $lastUpdate));
}


echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<r>';
echo '<result>'.$result.'</result>';
echo '<id>'.$id.'</id>';
echo '<userId>'.$userId.'</userId>';
echo '<choice>'.$choice.'</choice>';
echo '</r>';

?>
