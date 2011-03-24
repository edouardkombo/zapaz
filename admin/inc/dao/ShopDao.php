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
  /* @mohamed
   * 
   */
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
 
/*Returns shops within a maximum distance of specified
*latitude and longitude. 
* -Rachel
*/
  public function getAllClosestShops($latitude1, $longitude1, $latitude2, $longitude2, $maxDistance) {
    $array   = array();
    //$query = "SELECT * FROM `Shop` "; //add lat,long...
    
    $q = $this->db->prepare("SELECT * FROM `Shop` WHERE latitude BETWEEN :latitude2 AND :latitude1 AND longitude BETWEEN :longitude1 AND :longitude2 ");
    $q->execute(array(':latitude1' => $latitude1, ':latitude2' => $latitude2, ':longitude1' => $longitude1, ':longitude2' => $longitude2));
    
    if ($q != null) {
      //echo "not null";
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchShop($t));
      }
    }
   
    return $array;
  }
  
  /* @mohamed
   * 
   */
  public function count($filter = '') {
    $filter .= "%";
    $q = $this->db->prepare("SELECT COUNT(*) AS count FROM `Shop` WHERE name LIKE ?");
    $q->execute(array($filter));
    $r = $q->fetch(PDO::FETCH_OBJ);
    return $r != null ? $r->count : 0;
  }
  
  /*
   * Authentication of a shop
   */
  
  public function checkShop($login,$password){
    $filter = '';
    $filter .= "%";
    $q = $this->db->prepare("SELECT * FROM `Shop` WHERE email='$login' AND publicUid='$password'");
    $q->execute(array($filter));
    $r = $q->fetch(PDO::FETCH_OBJ);
    if ($r!=null) return TRUE;
    else return False;
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
