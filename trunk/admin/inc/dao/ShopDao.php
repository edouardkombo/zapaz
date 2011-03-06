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
  }
  
  public function update($shop) {
    if ($shop == null || $shop->getId() == null || $shop->getId() < 1) {
      return 0;
    }
  }
  
  public function delete($shopId) {
    if ($shopId == null || $shopId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM Shop WHERE id = ".$this->db->quote($shopId, PDO::PARAM_INT));
  }
  
  private function fetchShop($t) {
    return new Shop($t["name"], $t["currencyId"], $t["latitute"], $t["longitude"], $t["id"]);
  }
}

?>
