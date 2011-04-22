<?php

define("GROUP_ANONYMOUS", 0x0001   );
define("GROUP_REGULAR"  , 0x0010);

define("PERMISSIONS_VIEW", 0x010000);

class SessionManager {

  public function __construct() {
    session_start();
    ob_start();
  }

  public function create($user) {
    $_SESSION['group'] = GROUP_ANONYMOUS; // Anonymous
    if ($user != null && get_class($user) == 'User' && $user->getId() != null) {
      $fid = (int) $user->getFacebookId();
      $_SESSION['group'] = GROUP_REGULAR;
      $_SESSION['uuid']  = $user->getId();
      $_SESSION['fid']   = $user->getFacebookId();
      $_SESSION['fname'] = $user->getFacebookName();
      $_SESSION['ctime'] = $user->getCreationTime();
      $_SESSION['utime'] = $user->getLastConnection();
      return true;
    }
    return false;
  }

  public function getUser() {
    if ($this->isActive()) {
      return new User(
        $_SESSION['fid'],
        $_SESSION['fname'],
        $_SESSION['ctime'],
        $_SESSION['utime'],
        $_SESSION['uuid']
      );
    }
    $_SESSION['group'] = GROUP_ANONYMOUS;
    return new User("Anonymous", "0", "Anonymous");
  }
  
  public function getPermissions() {
    $permissions = PERMISSIONS_VIEW;
    return $permissions;
  }

  public function release() {
    ob_end_flush();
  }

  public function isActive() {
    return isset($_SESSION['group']) && $_SESSION['group'] != GROUP_ANONYMOUS;
  }

  public function getFacebookCookie() {
    $args = array();
    parse_str(trim($_COOKIE['fbs_' . FACEBOOK_APP_ID], '\\"'), $args);
    ksort($args);
    $payload = '';
    foreach ($args as $key => $value) {
      if ($key != 'sig') {
        $payload .= $key . '=' . $value;
      }
    }
    if (md5($payload . FACEBOOK_APP_SECRET) != $args['sig']) {
      return null;
    }
    return $args;
  }

}

?>
