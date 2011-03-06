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
  
  public function saveOrUpdate($keyword) {
    if ($keyword == null) {
      return 0;
    }
    if ($keyword->getId() == 0) {
      return $this->save($keyword);
    }
    return $this->update($keyword);
  }
  
  public function save($keyword) {
    if ($keyword == null) {
      return 0;
    }
  }
  
  public function update($keyword) {
    if ($keyword == null || $keyword->getId() == null || $keyword->getId() < 1) {
      return 0;
    }
  }
  
  public function delete($keywordId) {
    if ($keywordId == null || $keywordId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM Keyword WHERE id = ".$this->db->quote($keywordId, PDO::PARAM_INT));
  }
  
  private function fetchKeyword($t) {
    return new Keyword($t["name"], $t["id"]);
  }
}

?>
