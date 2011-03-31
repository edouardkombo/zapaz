<?php

/**
 * Description of ShopManager
 *
 * @author mohamed
 */
class ShopManager {
  
  private $shopDao;
  private $keywordDao;
  
  public function __construct() {
    $this->shopDao = new ShopDao();
    $this->keywordDao = new KeywordDao();
  }
  
  public function getShopByPublicUid($id) {
    return $this->shopDao->getShopByPublicUid($id);
  }
  
  public function getAllShops($filter = '', $startIndex = 0, $limit = 10) {
    return $this->shopDao->getAllShops($filter, $startIndex, $limit);
  }
  
  public function getAllClosestShops($minLat, $maxLat, $minLng, $maxLng) {
    return $this->shopDao->getAllClosestShops($minLat, $maxLat, $minLng, $maxLng);
  }
  
  public function count($filter = '') {
    return $this->shopDao->count($filter);
  }
  
  public function saveOrUpdate($shop) {
    if ($shop == null || get_class($shop) != "Shop") {
      return 0;
    }
    if ($shop->getPublicUid() == null) {
      $p = $shop->getName().$shop->getLatitude().$shop->getLongitude().$shop->getWebServiceUrl();
      $publicUid = md5($p);
      $shop->setPublicUid($publicUid);
    } else {
      $s = $this->shopDao->getShopByPublicUid($shop->getPublicUid());
      if ($s == null) {
        return 0;
      } else {
        $shop->setId($s->getId());
        $shop->setCreationTime($s->getCreationTime());
      }
    }
    $r = $this->shopDao->saveOrUpdate($shop);
    if ($r) {
      $r = $this->keywordDao->saveOrUpdate($shop->getKeywords(), $shop->getId());
      return $r == count($shop->getKeywords());
    }
    return 0;
  }
  
  public function delete($shopId) {
    return $this->shopDao->delete($shopId);
  }
}

?>
