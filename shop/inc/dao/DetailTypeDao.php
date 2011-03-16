<?php

/**
 * Description of DetailTypeDao
 *
 * @author fabien
 */
class DetailTypeDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getDetailTypeById($typeId) {
    if ($typeId == null || $typeId < 1) {
      return null;
    }
    
    $q = $this->db->prepare("SELECT * FROM DetailType WHERE name = ?");
    $q->execute(array($typeId));
    if ($t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetch($t);
    }
    return null;
  }
  
  public function getAllDetailTypes($filter = '', $startIndex = 0, $length = 10) {
    $filter .= "%";
    $array   = array();

    $q = $this->db->prepare("SELECT * FROM `DetailType` WHERE name LIKE ? ORDER BY name ASC LIMIT $startIndex, $length");
    $q->execute(array($filter));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetch($t));
      }
    }
    return $array;
  }
  
  public function getDetailTypeByName($name) {
    if ($name == null || $name == "") {
      return null;
    }
    
    $q = $this->db->prepare("SELECT * FROM DetailType WHERE name = ?");
    $q->execute(array($name));
    if ($t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetch($t);
    }
    return null;
  }
  
  public function saveDetailType($type) {
    if ($type == null) {
      return 0;
    }
    $q = $this->db->prepare("INSERT INTO DetailType (name) VALUES (?)");
    return $q->execute(array($type->getName()));
  }
  
  public function deleteDetailType($type) {
    if ($type == null) {
      return 0;
    }
    $q = $this->db->prepare("DELETE FROM DetailType WHERE name = ?");
    return $q->execute(array($type->getName()));
  }
  
  private function fetch($t) {
    return new DetailType($t["name"], $t["id"]);
  }
}

?>
