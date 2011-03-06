<?php

/**
 * Description of UserManager
 *
 * @author fabien
 */
class UserManager {
  
  private $userDao;
  
  public function __construct() {
    $this->userDao = new UserDao();
  }
}

?>
