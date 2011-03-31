<?php

/**
 * Description of ShopDao
 *
 * @author fabien
 */
class ShopDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getShopById($id) {
    if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("SELECT * FROM Shop WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchShop($t);
    }
    return null;
  }
  
  public function getShopByPublicUid($id) {
    $q = $this->db->query("SELECT * FROM Shop WHERE publicUid = ".$this->db->quote($id, PDO::PARAM_STR));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchShop($t);
    }
    return null;
  }
  
  public function getAllShops($filter = '', $startIndex = 0, $length = 10) {
    $filter .= "%";
    $array   = array();

    $q = $this->db->prepare("SELECT * FROM `Shop` WHERE name LIKE ? ORDER BY name ASC LIMIT $startIndex, $length");
    $q->execute(array($filter));
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchShop($t));
      }
    }
    return $array;
  }
  
  public function getAllClosestShops($minLat, $maxLat, $minLng, $maxLng) {
    $array   = array();
    if ($minLat == null || $maxLat == null || $minLng == null || $maxLng == null) {
      return $array;
    }
    
    $q = $this->db->prepare("SELECT * FROM `Shop` WHERE latitude BETWEEN ? AND ? AND longitude BETWEEN ? AND ? ");
    $q->execute(array($minLat, $maxLat, $minLng, $maxLng));
    
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchShop($t));
      }
    }
   
    return $array;
  }
  
  public function count($filter = '') {
    $filter .= "%";
    $q = $this->db->prepare("SELECT COUNT(*) AS count FROM `Shop` WHERE name LIKE ?");
    $q->execute(array($filter));
    $r = $q->fetch(PDO::FETCH_OBJ);
    return $r != null ? $r->count : 0;
  }
  
  public function saveOrUpdate($shop) {
    if ($shop == null) {
      return 0;
    }
    if ($shop->getId() == 0) {
      return $this->save($shop);
    }
    return $this->update($shop);
  }
  
  public function save($shop) {
    if ($shop == null) {
      return 0;
    }
    $q = $this->db->prepare("INSERT INTO Shop (publicUid, name, currencyId, latitude, longitude, email, countOfProducts, creationTime, lastUpdate, webServiceUrl) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $r = $q->execute(array(
      $shop->getPublicUid(),
      $shop->getName(),
      $shop->getCurrencyId(),
      $shop->getLatitude(),
      $shop->getLongitude(),
      $shop->getEmail(),
      $shop->getCountOfProducts(),
      $shop->getCreationTime(),
      $shop->getLastUpdate(),
      $shop->getWebServiceUrl()
    ));
    if ($r) {
      $shop->setId($this->db->lastInsertId());
    }
    return $r;
  }
  
  public function update($shop) {
    if ($shop == null || $shop->getId() == null || $shop->getId() < 1) {
      return 0;
    }
    
    if ($shop == null) {
      return 0;
    }
    $q = $this->db->prepare("UPDATE Shop SET publicUid = ?, name = ?, currencyId = ?, latitude = ?, longitude = ?, email = ?, countOfProducts = ?, creationTime = ?, lastUpdate = ?, webServiceUrl = ? WHERE id = ?");
    return $q->execute(array(
      $shop->getPublicUid(),
      $shop->getName(),
      $shop->getCurrencyId(),
      $shop->getLatitude(),
      $shop->getLongitude(),
      $shop->getEmail(),
      $shop->getCountOfProducts(),
      $shop->getCreationTime(),
      $shop->getLastUpdate(),
      $shop->getWebServiceUrl(),
      $shop->getId()
    ));
  }
  
  public function delete($shopId) {
    if ($shopId == null || $shopId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM Shop WHERE id = ".$this->db->quote($shopId, PDO::PARAM_INT));
  }
  
  private function fetchShop($t) {
    $s = new Shop(
      $t["publicUid"],
      $t["name"],
      $t["currencyId"],
      $t["latitude"],
      $t["longitude"],
      $t["email"],
      $t["countOfProducts"],
      $t["creationTime"],
      $t["lastUpdate"],
      $t["id"]
    );
    $s->setWebServiceUrl($t["webServiceUrl"]);
    return $s;
  }
}

?>
