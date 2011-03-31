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
  
  public function saveOrUpdate($productType) {
    return $this->productTypeDao->saveOrUpdate($productType);
  }
}

?>
