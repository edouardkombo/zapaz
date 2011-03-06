<?php

/**
 * Description of ProductTypeManager
 *
 * @author fabien
 */
class ProductTypeManager {
  private $productTypeDao;
  
  public function __construct() {
    $this->productTypeDao = new ProductTypeDao();
  }
  
  public function getAllProductTypes($filter = '', $startIndex = 0, $limit = 10) {
    return $this->productTypeDao->getAllProductTypes($filter, $startIndex, $limit);
  }
  
  public function count($filter = '') {
    return $this->productTypeDao->count($filter);
  }
  
  public function saveOrUpdate($productType) {
    return $this->productTypeDao->saveOrUpdate($productType);
  }
  
  public function delete($productTypeId) {
    return $this->productTypeDao->delete($productTypeId);
  }
}

?>
