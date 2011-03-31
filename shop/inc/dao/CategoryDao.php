<?php

/**
 * Description of CategoryDao
 *
 * @author fabien
 */
class CategoryDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getCategoryById($id) {
    if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("SELECT * FROM Category WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchCategory($t);
    }
    return null;
  }
  
  public function getAllCategories($filter = '', $startIndex = 0, $length = 10) {
    $filter .= "%";
    $array   = array();

    $q = $this->db->prepare("SELECT * FROM `Category` WHERE name LIKE ? ORDER BY name ASC LIMIT $startIndex, $length");
    $q->execute(array($filter));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchCategory($t));
      }
    }
    return $array;
  }
  
  public function getUsedCategories($shopId) {
    $array   = array();
    if ($shopId == null || $shopId < 1) {
      return $array;
    }
    
    $q = $this->db->prepare("SELECT c.* FROM Product p JOIN Category c ON p.categoryId = c.id WHERE p.shopId = ? GROUP BY c.name ASC");
    $q->execute(array($shopId));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchCategory($t));
      }
    }
    return $array;
  }

  public function count($filter = '') {
    $filter .= "%";
    $q = $this->db->prepare("SELECT COUNT(*) AS count FROM `Category` WHERE name LIKE ?");
    $q->execute(array($filter));
    $r = $q->fetch(PDO::FETCH_OBJ);
    return $r != null ? $r->count : 0;
  }
  
  public function saveOrUpdate($category) {
    if ($category == null) {
      return 0;
    }
    $sql = "INSERT INTO Category (id,name) VALUE (:id,:name) ON DUPLICATE KEY UPDATE id = :id";
    $q = $this->db->prepare($sql);
    $r = $q->execute(array(
      "id"   => $category->getId(),
      "name" => $category->getName()
    ));
    return $r;
  }
  
  private function fetchCategory($t) {
    return new Category($t["name"], $t["id"]);
  }
}

?>
