<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductDetailDao
 *
 * @author fabien
 */
class ProductDetailDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getDetailsForProductId($productId) {
    $array = array();
    if ($productId == null || $productId < 1) {
      return $array();
    }
    
    $q = $this->db->query("SELECT * FROM ProductDetail WHERE productId = ".$this->db->quote($productId, PDO::PARAM_INT));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetch($t));
      }
    }
    
    return $array;
  }
  
  public function saveOrUpdate($productDetail) {
    if ($productDetail == null) {
      return 0;
    }
    if ($productDetail->getId() == 0) {
      return $this->save($productDetail);
    }
    return $this->update($productDetail);
  }
  
  public function save($productDetail) {
    if ($productDetail == null) {
      return 0;
    }
    $sql = "INSERT INTO ProductDetail (name, productId, detailTypeId) VALUE (?, ?, ?)";
    $q = $this->db->prepare($sql);
    $r = $q->execute(array(
      $productDetail->getName(),
      $productDetail->getProductId(),
      $productDetail->getDetailTypeId()
    ));
    if ($r == 1) {
      $productDetail->setId($this->db->lastInsertId());
    }
    return $r;
  }
  
  public function update($productDetail) {
    if ($productDetail == null || $productDetail->getId() == null || $productDetail->getId() < 1) {
      return 0;
    }
    $sql = "UPDATE ProductDetail SET name = ?, productId = ?, detailTypeId = ? WHERE id = ?";
    $q = $this->db->prepare($sql);
    return $q->execute(array(
      $productDetail->getName(),
      $productDetail->getProductId(),
      $productDetail->getDetailTypeId(),
      $productDetail->getId()
    ));
  }
  
  public function delete($productDetailId) {
    if ($productDetailId == null || $productDetailId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM ProductDetail WHERE id = ".$this->db->quote($productDetailId, PDO::PARAM_INT));
  }
  
  public function deleteAll($productId) {
    if ($productId == null || $productId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM ProductDetail WHERE productId = ".$this->db->quote($productId, PDO::PARAM_INT));
  }
  
  private function fetch($t) {
    return new ProductDetail($t["name"], $t["productId"], $t["detailTypeId"], $t["id"]);
  }
}

?>
