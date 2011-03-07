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
  
  public function getShop() {
    $q = $this->db->query("SELECT * FROM Shop LIMIT 1");
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchShop($t);
    }
    return null;
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
    $sql = "INSERT INTO Shop (name, address, zipCode, city, state, country, phone, logo, currencyId, email, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $q = $this->db->prepare($sql);
    $r = $q->execute(array(
      $shop->getName(),
      $shop->getAddress(),
      $shop->getZipCode(),
      $shop->getCity(),
      $shop->getState(),
      $shop->getCountryId(),
      $shop->getPhone(),
      $shop->getLogo(),
      $shop->getCurrencyId(),
      $shop->getEmail(),
      $shop->getLatitude(),
      $shop->getLongitude()
    ));
    if ($r == 1) {
      $shop->setId($this->db->lastInsertId());
    }
    return $r;
  }
  
  public function update($shop) {
    if ($shop == null || $shop->getId() == null || $shop->getId() < 1) {
      return 0;
    }
    $sql = "UPDATE Shop SET name = ?, address = ?, zipCode = ?, city = ?, state = ?, country = ?, phone = ?, logo = ?, currencyId = ?, email = ?, latitude = ?, longitude = ? WHERE id = ?";
    $q = $this->db->prepare($sql);
    return $q->execute(array(
      $shop->getName(),
      $shop->getAddress(),
      $shop->getZipCode(),
      $shop->getCity(),
      $shop->getState(),
      $shop->getCountryId(),
      $shop->getPhone(),
      $shop->getLogo(),
      $shop->getCurrencyId(),
      $shop->getEmail(),
      $shop->getLatitude(),
      $shop->getLongitude(),
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
    $shop = new Shop($t["name"], $t["address"], $t["zipCode"], $t["city"], $t["country"], $t["currencyId"], $t["email"], $t["latitude"], $t["longitude"], $t["id"]);
    $shop->setLogo($t["logo"]);
    $shop->setState($t["state"]);
    $shop->setPhone($t["phone"]);
    return $shop;
  }
}

?>
