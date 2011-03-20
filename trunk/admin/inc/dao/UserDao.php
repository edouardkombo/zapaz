<?php

/**
 * Description of UserDao
 *
 * @author fabien
 */
class UserDao {

  private $db;

  public function __construct() {
    global $db;
    $this->db = $db;
  }

  public function getUserById($id) {
    if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("SELECT * FROM User WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchUser($t);
    }
    return null;
  }
    /* @mohamed
   * 
   */
  public function getAllUsers($filter = '', $startIndex = 0, $length = 10) {
    $filter .= "%";
    $array   = array();

    $q = $this->db->prepare("SELECT * FROM `User` WHERE email LIKE ? ORDER BY email ASC LIMIT $startIndex, $length");
    $q->execute(array($filter));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchUser($t));
      }
    }
    return $array;
  }
  /* @mohamed
   * 
   */
  public function count($filter = '') {
    $filter .= "%";
    $q = $this->db->prepare("SELECT COUNT(*) AS count FROM `User` WHERE email LIKE ?");
    $q->execute(array($filter));
    $r = $q->fetch(PDO::FETCH_OBJ);
    return $r != null ? $r->count : 0;
  }
  
  /*
   * Authentication of a user
   */
  
  public function checkUser($login,$password){
    $filter = '';
    $filter .= "%";
    $q = $this->db->prepare("SELECT * FROM `User` WHERE email='$login' AND password='$password'");
    $q->execute(array($filter));
    $r = $q->fetch(PDO::FETCH_OBJ);
    if ($r!=null) return TRUE;
    else return False;
  }
  
  public function saveOrUpdate($user) {
    if ($user == null) {
      return 0;
    }
    if ($user->getId() == 0) {
      return $this->save($user);
    }
    return $this->update($user);
  }
  
  public function save($user) {
    if ($user == null) {
      return 0;
    }
  }
  
  public function update($user) {
    if ($user == null || $user->getId() == null || $user->getId() < 1) {
      return 0;
    }
  }
  
  public function delete($userId) {
    if ($userId == null || $userId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM User WHERE id = ".$this->db->quote($userId, PDO::PARAM_INT));
  }
  
  private function fetchUser($t) {
    return new User($t["email"], $t["password"], $t["id"]);
  }
}

?>
