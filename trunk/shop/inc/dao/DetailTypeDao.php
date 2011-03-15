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
  
  public function getAllDetailTypes($filter = '', $startIndex = 0, $length = 10) {
    $filter .= "%";
    $array   = array();

    $q = $this->db->prepare("SELECT * FROM `DetailType` WHERE name LIKE ? ORDER BY name ASC LIMIT $startIndex, $length");
    $q->execute(array($filter));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchDetailType($t));
      }
    }
    return $array;
  }
  
  private function fetchDetailType($t) {
    return new DetailType($t["name"], $t["id"]);
  }
}

?>
