<?php

/**
 * Description of KeywordDao
 *
 * @author fabien
 */
class KeywordDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getKeywordById($id) {
    if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("SELECT * FROM Keyword WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetch($t);
    }
    return null;
  }
  
  public function getKeywordsByShopId($shopId) {
    $array = array();
    if ($shopId == null || $shopId < 1) {
      return $array;
    }
    $q = $this->db->query("SELECT * FROM Keyword WHERE shopId = ".$this->db->quote($shopId, PDO::PARAM_INT));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetch($t));
      }
    }
    return $array;
  }
  
  public function saveAll($keywords) {
    if ($keywords == null || count($keywords) == 0) {
      return 0;
    }
    
    $r = true;
    foreach ($keywords as $k) {
      $q = $this->db->prepare("INSERT INTO `Keyword` (name, shopId) VALUES (?,?)");
      $r &= $q->execute(array($k->getName(), $k->getShopId()));
      $k->setId($this->db->lastInsertId());
    }
    return $r;
  }
  
  public function deleteAll($shopId) {
    if ($shopId == null || $shopId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM Keyword WHERE shopId = ".$this->db->quote($shopId, PDO::PARAM_INT));
  }
  
  private function fetch($t) {
    return new Keyword($t["name"], $t["shopId"], $t["id"]);
  }
}

?>
