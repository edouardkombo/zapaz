<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OfferDao
 *
 * @author fabien
 */
class OfferDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getOfferByProductId($productId) {
    if ($productId == null || $productId < 1) {
      return null;
    }
    $q = $this->db->prepare("SELECT *
      FROM `Offer`
      WHERE timeStart < ?
        AND timeEnd > ?
        AND productId = ?");
    $t = time();
    $q->execute(array($t, $t, $productId));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchOffer($t);
    }
    return null;
  }
  
  public function fetchOffer($t) {
    $o = new Offer($t["productId"], $t["price"], $t["startTime"], $t["endTime"], $t["displayOnlyImage"], $t["id"]);
    $o->setCommercialImage($t["commercialImage"]);
    return $o;
  }
}

?>
