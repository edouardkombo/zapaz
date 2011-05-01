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
    $q = $this->db->query("SELECT * FROM `".TABLE_USER."` WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchUser($t);
    }
    return null;
  }
  
  public function getAllUsers($filter = '', $startIndex = 0, $length = 10) {
    $filter .= "%";
    $array   = array();

    $q = $this->db->prepare("SELECT * FROM `".TABLE_USER."` WHERE facebookName LIKE ? ORDER BY facebookName ASC LIMIT $startIndex, $length");
    $q->execute(array($filter));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchUser($t));
      }
    }
    return $array;
  }
  
  public function count() {
    $q = $this->db->query("SELECT COUNT(*) AS count FROM `".TABLE_USER."`");
    $r = $q->fetch(PDO::FETCH_OBJ);
    return $r != null ? $r->count : 0;
  }

  public function saveOrUpdate() {
    $sql = "CALL saveOrUpdateUser(?, ?);";
    $q = $this->db->prepare($sql);
    $q->execute(array($this->facebookId, $this->facebookName));
    if ($t = $q->fetch(PDO::FETCH_ASSOC)) {
      $this->id = $t["id"];
      $this->facebookName = $t["facebookName"];
      $this->creationTime = $t["creationTime"];
      $this->lastConnection = $t["lastConnection"];
      return 1;
    }
    return 0;
  }
  
  public function delete($userId) {
    if ($userId == null || $userId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM `".TABLE_USER."` WHERE id = ".$this->db->quote($userId, PDO::PARAM_INT));
  }
  
  private function fetchUser($t) {
    return new User($t["facebookId"], $t["facebookName"], $t["creationTime"], $t["lastConnection"], $t["id"]);
  }
}

?>
