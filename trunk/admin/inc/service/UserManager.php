<?php

/**
 * Description of ShopManager
 *
 * @author mohamed
 */
class UserManager {
  
  private $userDao;
  
  public function __construct() {
    $this->userDao = new UserDao();
  }
  public function getAllUsers($filter = '', $startIndex = 0, $limit = 10) {
    return $this->userDao->getAllUsers($filter, $startIndex, $limit);
  }
  
  public function count($filter = '') {
    return $this->userDao->count($filter);
  }
  
  public function saveOrUpdate($user) {
    return $this->userDao->saveOrUpdate($user);
  }
  
  public function delete($userId) {
    return $this->userDao->delete($userId);
  }
}

?>
