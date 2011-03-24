<?php

/**
 * Description of ShopManager
 *
 * @author mohamed
 */
class ShopManager {
  
  private $shopDao;
  
  public function __construct() {
    $this->shopDao = new ShopDao();
  }
  
  public function getAllShops($filter = '', $startIndex = 0, $limit = 10) {
    return $this->shopDao->getAllShops($filter, $startIndex, $limit);
  }
  
  public function getAllClosestShops($latitude1, $longitude1, $latitude2, $longitude2, $maxDistance) {
    return $this->shopDao->getAllClosestShops($latitude1, $longitude1, $latitude2, $longitude2,$maxDistance);
  }
  
  public function count($filter = '') {
    return $this->shopDao->count($filter);
  }
  
  public function saveOrUpdate($shop) {
    return $this->shopDao->saveOrUpdate($shop);
  }
  
  public function delete($shopId) {
    return $this->shopDao->delete($shopId);
  }
  
  public function checkAuthentication($login,$password){
    return $this->shopDao->checkShop($login,$password);
  }
}

?>
