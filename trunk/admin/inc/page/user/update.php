<?php

$in = $_POST;

$id   = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;
$email = isset($in['email']) && $in['email'] != ""                      ? $in['email'] : null;
$password = isset($in['password']) && $in['password'] != ""          ? $in['password'] : null;
$choices = isset($in['choices']) && $in['choices'] != ""       ? $in['choices'] : null;

$result = 0;
if ($email != null) {
  $userManager = new UserManager();
  $result = $userManager->saveOrUpdate(new User($email, $password));
}

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<r>';
echo '<result>'.$result.'</result>';
echo '</r>';
?>
