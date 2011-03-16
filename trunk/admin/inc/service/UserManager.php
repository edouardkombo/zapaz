<?php

/**
 * Description of ShopManager
 *
 * @author mohamed
 */
class UserManager {
  
  private $userDao;
  private $userChoiceDao;
  
  public function __construct() {
    $this->userDao = new UserDao();
    $this->userChoiceDao = new UserChoiceDao();
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
  
  public function saveOrUpdateChoice($userChoice) {
    return $this->userChoiceDao->saveOrUpdate($userChoice);
  }
  
  public function deleteChoice($userChoiceId) {
    return $this->userChoiceDao->delete($userChoiceId);
  }
  
}

?>
