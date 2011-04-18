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
    $q = $this->db->query("SELECT * FROM `".TABLE_KEYWORD."` WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
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
    $q = $this->db->query("SELECT k.* FROM `".TABLE_KEYWORD."` k JOIN `".TABLE_SHOP_KEYWORDS."` s ON k.id = s.keywordId WHERE s.shopId = ".$this->db->quote($shopId, PDO::PARAM_INT));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchKeyword($t));
      }
    }
    return $array;
  }
  
  public function saveOrUpdate($keywordList, $shopId) {
    if ($keywordList == null || !is_array($keywordList) || count($keywordList) < 1 || $shopId == null || $shopId < 1) {
      return 0;
    }
    $q = $this->db->exec("DELETE FROM `".TABLE_SHOP_KEYWORDS."` WHERE shopId = ".$this->db->quote($shopId, PDO::PARAM_INT));
    $c = 0;
    foreach ($keywordList as $k) {
      $id = 0;
      $q = $this->db->query("SELECT * FROM `".TABLE_KEYWORD."` WHERE name = ".$this->db->quote($k, PDO::PARAM_STR));
      if ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        $id = $t["id"];
      }
      if ($id == 0) {
        $q = $this->db->exec("INSERT INTO `".TABLE_KEYWORD."` (name) VALUE (".$this->db->quote($k, PDO::PARAM_STR).")");
        if ($q) {
          $id = $this->db->lastInsertId();
        }
      }
      if ($id > 0) {
        $q = $this->db->prepare("INSERT INTO `".TABLE_SHOP_KEYWORDS."` (keywordId, shopId) VALUES (?,?)");
        if ($q->execute(array($id, $shopId))) {
          $c++;
        }
      }
    }
    return $c;
  }
  
  public function delete($keywordId) {
    if ($keywordId == null || $keywordId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM `".TABLE_KEYWORD."` WHERE id = ".$this->db->quote($keywordId, PDO::PARAM_INT));
  }
  
  private function fetchKeyword($t) {
    return new Keyword($t["name"], $t["id"]);
  }
}

?>
