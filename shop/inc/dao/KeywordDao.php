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
      return $this->fetchKeyword($t);
    }
    return null;
  }
  
  public function getKeywordsByShopId($shopId) {
    $array = array();
    if ($shopId == null || $shopId < 1) {
      return $array;
    }
    $q = $this->db->query("SELECT k.* FROM Keyword k JOIN ShopKeywords s ON k.id = s.keywordId WHERE s.shopId = ".$this->db->quote($shopId, PDO::PARAM_INT));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchKeyword($t));
      }
    }
    return $array;
  }
  
  public function saveAll($keywords, $shopId) {
    if ($keywords == null || count($keywords) == 0 || $shopId == null || $shopId < 1) {
      return 0;
    }
    
    $r1 = 0;
    $r2 = 0;
    foreach ($keywords as $k) {
      $r1 = $this->db->exec("INSERT INTO `Keyword` (name) VALUES (".$this->db->quote($k->getName(), PDO::PARAM_STR).")");
      $k->setId($this->db->lastInsertId());

      $q  = $this->db->prepare("INSERT INTO `ShopKeywords` (shopId, keywordId) VALUES (?,?)");
      $r2 = $q->execute(array($shopId, $k->getId()));
    }
    return $r1 && $r2;
  }
  
  public function deleteAll($shopId) {
    if ($shopId == null || $shopId < 1) {
      return 0;
    }
    $q = $this->db->query("SELECT keywordId FROM ShopKeywords WHERE shopId = ".$this->db->quote($shopId, PDO::PARAM_INT));
    $r = true;
    while (($t = $q->fetch(PDO::FETCH_ASSOC))) {
      $r &= $this->db->exec("DELETE FROM Keyword WHERE id = ".$this->db->quote($t["keywordId"], PDO::PARAM_INT));
    }
    return $r;
  }
  
  private function fetchKeyword($t) {
    return new Keyword($t["name"], $t["id"]);
  }
}

?>
