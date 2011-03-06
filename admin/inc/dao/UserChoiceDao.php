<?php

/**
 * Description of UserChoiceDao
 *
 * @author fabien
 */
class UserChoiceDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getUserChoiceById($id) {
    if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("SELECT * FROM UserChoice WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchUserChoice($t);
    }
    return null;
  }
  
  public function getChoicesByUserId($userId) {
    $array = array();
    if ($userId == null || $userId < 1) {
      return $array;
    }
    $q = $this->db->query("SELECT * FROM UserChoice WHERE userId = ".$this->db->quote($userId, PDO::PARAM_INT));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchUserChoice($t));
      }
    }
    return $array;
  }
  
  public function saveOrUpdate($userChoice) {
    if ($userChoice == null) {
      return 0;
    }
    if ($userChoice->getId() == 0) {
      return $this->save($userChoice);
    }
    return $this->update($userChoice);
  }
  
  public function save($userChoice) {
    if ($userChoice == null) {
      return 0;
    }
  }
  
  public function update($userChoice) {
    if ($userChoice == null) {
      return 0;
    }
  }
  
  public function delete($userChoiceId) {
    if ($userChoiceId == null || $userChoiceId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM UserChoice WHERE id = ".$this->db->quote($userChoiceId, PDO::PARAM_INT));
  }
  
  private function fetchUserChoice($t) {
    return new UserChoice($t["choice"], $t["startTime"], $t["endTime"], $t["userId"], $t["id"]);
  }
}

?>
