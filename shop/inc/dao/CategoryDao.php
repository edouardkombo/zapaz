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
    
    $q = $this->db->prepare("SELECT c.* FROM Product p JOIN Category c ON p.categoryId = c.id WHERE p.shopId = ?");
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
    if ($category->getId() == 0) {
      return $this->save($category);
    }
    return $this->update($category);
  }
  
  public function save($category) {
    if ($category == null) {
      return 0;
    }
    $sql = "INSERT INTO Category (name) VALUE (?)";
    $q = $this->db->prepare($sql);
    $r = $q->execute(array($category->getName()));
    if ($r == 1) {
      $category->setId($this->db->lastInsertId());
    }
    return $r;
  }
  
  public function update($category) {
    if ($category == null || $category->getId() == null || $category->getId() < 1) {
      return 0;
    }
    $sql = "UPDATE Category SET name = ? WHERE id = ?";
    $q = $this->db->prepare($sql);
    return $q->execute(array($category->getName(), $category->getId()));
  }
  
  public function delete($categoryId) {
    if ($categoryId == null || $categoryId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM Category WHERE id = ".$this->db->quote($categoryId, PDO::PARAM_INT));
  }
  
  private function fetchCategory($t) {
    return new Category($t["name"], $t["id"]);
  }
}

?>
