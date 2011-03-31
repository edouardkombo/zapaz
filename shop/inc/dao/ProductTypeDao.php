<?php

/**
 * Description of ProductTypeDao
 *
 * @author fabien
 */
class ProductTypeDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getProductTypeById($id) {
    if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("SELECT * FROM ProductType WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchProductType($t);
    }
    return null;
  }
  
  public function getAllProductTypes($filter = '', $startIndex = 0, $length = 10) {
    $filter .= "%";
    $array   = array();

    $q = $this->db->prepare("SELECT * FROM `ProductType` WHERE name LIKE ? ORDER BY name ASC LIMIT $startIndex, $length");
    $q->execute(array($filter));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchProductType($t));
      }
    }
    return $array;
  }

  public function count($filter = '') {
    $filter .= "%";
    $q = $this->db->prepare("SELECT COUNT(*) AS count FROM `ProductType` WHERE name LIKE ?");
    $q->execute(array($filter));
    $r = $q->fetch(PDO::FETCH_OBJ);
    return $r != null ? $r->count : 0;
  }
  
  public function saveOrUpdate($productType) {
    if ($productType == null) {
      return 0;
    }
    $sql = "INSERT INTO ProductType (id,name) VALUE (:id,:name) ON DUPLICATE KEY UPDATE id = :id";
    $q = $this->db->prepare($sql);
    $r = $q->execute(array(
      "id"   => $productType->getId(),
      "name" => $productType->getName()
    ));
    return $r;
  }
  
  public function delete($productTypeId) {
    if ($productTypeId == null || $productTypeId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM ProductType WHERE id = ".$this->db->quote($productTypeId, PDO::PARAM_INT));
  }
  
  private function fetchProductType($t) {
    return new ProductType($t["name"], $t["id"]);
  }
}

?>
