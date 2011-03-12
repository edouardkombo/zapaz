<?php

/**
 * Description of ProductDao
 *
 * @author fabien
 */
class ProductDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getProductById($id) {
    if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("
      SELECT p.*, t.name AS type, c.name AS category 
      FROM `Product` p
        JOIN `Category` c ON p.categoryId = c.id
        JOIN ProductType t ON p.typeId = t.id
      WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchProduct($t);
    }
    return null;
  }
  
  public function getAllProducts($nameFilter = '', $categoryFilter = '', $typeFilter = '',  $startIndex = 0, $length = 10) {
    $nameFilter .= "%";
    $categoryFilter .= '%';
    $typeFilter .= '%';
    $array   = array();

    $q = $this->db->prepare("
      SELECT p.*, t.name AS type, c.name AS category 
      FROM `Product` p
        JOIN `Category` c ON p.categoryId = c.id
        JOIN ProductType t ON p.typeId = t.id
      WHERE p.name LIKE ?
        AND c.name LIKE ?
        AND t.name LIKE ?
      ORDER BY name ASC
      LIMIT $startIndex, $length");
    $q->execute(array($nameFilter, $categoryFilter, $typeFilter));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchProduct($t));
      }
    }
    return $array;
  }
  
  public function count($nameFilter = '', $categoryFilter = '', $typeFilter = '') {
    $nameFilter .= "%";
    $categoryFilter .= '%';
    $typeFilter .= '%';
       
    $q = $this->db->prepare("
      SELECT COUNT(*) AS count
      FROM `Product` p
        JOIN `Category` c ON p.categoryId = c.id
        JOIN ProductType t ON p.typeId = t.id
      WHERE p.name LIKE ?
        AND c.name LIKE ?
        AND t.name LIKE ?");
    $q->execute(array($nameFilter, $categoryFilter, $typeFilter));
    $r = $q->fetch(PDO::FETCH_OBJ);
    return $r != null ? $r->count : 0;
  }
  
  public function delete($productId) {
    if ($productId == null || $productId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM Product WHERE id = ".$this->db->quote($productId, PDO::PARAM_INT));
  }
  
  private function fetchProduct($t) {
    $p = new Product($t["categoryId"], $t["typeId"], $t["shopId"], $t["name"], $t["manufacturer"], $t["price"], $t["id"]);
    $p->setCategory(new Category($t["category"], $t["categoryId"]));
    $p->setType(new ProductType($t["type"], $t["typeId"]));
    $p->setDescription($t["description"]);
    $p->setPicture($t["picture"]);
    return $p;
  }
}

?>
