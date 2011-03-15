<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductManager
 *
 * @author fabien
 */
class ProductManager {
  
  private $productDao;
  private $typeDao;
  private $categoryDao;
  private $detailTypeDao;
  
  public function __construct() {
    $this->productDao = new ProductDao();
    $this->typeDao = new ProductTypeDao();
    $this->categoryDao = new CategoryDao();
    $this->detailTypeDao = new DetailTypeDao();
  }
  
  public function getProductById($productId) {
    return $this->productDao->getProductById($productId);
  }
  
  public function getAllProducts($nameFilter = '', $categoryFilter = '', $typeFilter = '', $startIndex = 0, $length = 10) {
    return $this->productDao->getAllProducts($nameFilter, $categoryFilter, $typeFilter, $startIndex, $length);
  }
  
  public function getAllCategories() {
    return $this->categoryDao->getAllCategories('', 0, 1000);
  }
  
  public function getAllTypes() {
    return $this->typeDao->getAllProductTypes('', 0, 1000);
  }
  
  public function getAllDetailTypes() {
    return $this->detailTypeDao->getAllDetailTypes('', 0, 1000);
  }
  
  public function saveDetailType($type) {
    return $this->detailTypeDao->saveDetailType($type);
  }
  
  public function deleteDetailType($type) {
    return $this->detailTypeDao->deleteDetailType($type);
  }
  
  public function count($filter = '') {
    return $this->productDao->count($filter);
  }
  
  public function delete($productId) {
    return $this->productDao->delete($productId);
  }
}

?>
