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
  private $productTypeDao;
  private $productDetailDao;
  private $categoryDao;
  private $detailTypeDao;
  private $offerDao;
  
  public function __construct() {
    $this->productDao = new ProductDao();
    $this->productTypeDao = new ProductTypeDao();
    $this->productDetailDao = new ProductDetailDao();
    $this->categoryDao = new CategoryDao();
    $this->detailTypeDao = new DetailTypeDao();
    $this->offerDao = new OfferDao();
  }
  
  public function getProductById($productId) {
    return $this->productDao->getProductById($productId);
  }
  
  public function getAllProducts($shopId, $nameFilter = '', $categoryFilter = '', $typeFilter = '', $startIndex = 0, $length = 10) {
    return $this->productDao->getAllProducts($shopId, $nameFilter, $categoryFilter, $typeFilter, $startIndex, $length);
  }
   
  public function getAllCategories() {
    return $this->categoryDao->getAllCategories('', 0, 1000);
  }
  
  public function getUsedCategories($shopId) {
    return $this->categoryDao->getUsedCategories($shopId);
  }
  
  public function getAllCategoriesAsDictionary() {
    $list = array();
    $tmpList = $this->getAllCategories();
    if ($tmpList != null) {
      foreach ($tmpList as $t) {
        $list[$t->getId()] = $t->getName();
      }
    }
    return $list;
  }
  
  public function getOfferByProductId($productId){
    return $this->offerDao->getOfferByProductId($productId);
  }
  
   public function getOffer($offerId){
    return $this->offerDao->getOffer($offerId);
  }
  
  public function getAllTypes() {
    return $this->productTypeDao->getAllProductTypes('', 0, 1000);
  }
  
  public function getAllTypesAsDictionary() {
    $list = array();
    $tmpList = $this->getAllTypes();
    if ($tmpList != null) {
      foreach ($tmpList as $t) {
        $list[$t->getId()] = $t->getName();
      }
    }
    return $list;
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
  
  
  public function saveOffer($offer) {
    return $this->offerDao->save($offer);
  }
  
  public function deleteOffer($OfferId) {
    return $this->offerDao->delete($OfferId);
  }
  
  public function count($shopId, $nameFilter = '', $categoryFilter = '', $typeFilter = '') {
    return $this->productDao->count($shopId, $nameFilter, $categoryFilter, $typeFilter);
  }
  
  public function saveOrUpdateProduct($product, $productDetails) {
    global $db;
    try {
      $db->beginTransaction();
      if (!$this->productDao->saveOrUpdate($product)) {
        throw new PDOException("Failed to save the product");
      }
      
      $this->productDetailDao->deleteAll($product->getId());
      if ($productDetails != null && count($productDetails) > 0) {
        foreach ($productDetails as $pd) {
          $t = $this->detailTypeDao->getDetailTypeByName($pd[0]);
          if ($t != null) {
            $d = new ProductDetail($pd[1], $product->getId(), $t->getId());
            if (!$this->productDetailDao->save($d)) {
              throw new PDOException("Failed to save a product detail.");
            }
          }
        }
      }
      
      $db->commit();
    } catch (PDOException $e) {
      echo $e;
      return 0;
    }
    return 1;
  }
  
  
  public function delete($productId) {
    return $this->productDao->delete($productId);
  }
}

?>
