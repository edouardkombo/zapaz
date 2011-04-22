<?php

header("Content-type:application/xml");
include('../inc/global.config.php');

$session = new SessionManager();

$cookie = SessionManager::getFacebookCookie();
if ($cookie != null) {
  $json     = file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']);
  $facebook = json_decode($json);

  if (isset($cookie)) {
    $facebookId   = $facebook->id;
    $facebookName = $facebook->name;
    if ($facebookId != null && $facebookName != null) {
      $user = new User($facebookId, $facebookName);
      $user->saveOrUpdate();
      if ($session->create($user)) {
        $result = 1;
      }
    } else {
      $result = 1000;
    }
  } else {
    $result = 2000;
  }
} else {
  $result = 1011;
}

$session->release();

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r>
  <result>$result</result>
</r>
END;
?>
