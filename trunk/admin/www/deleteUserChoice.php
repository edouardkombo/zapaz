<?php

include('../inc/global.config.php');

$in = $_POST;

$id = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;

$result = 0;
if ($id !=null) {
  $userManager = new UserManager();
  $result = $userManager->deleteChoice($id);
}


echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<r>';
echo '<result>'.$result.'</result>';
echo '</r>';
?>
