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
      WHERE startTime < ?
        AND endTime > ?
        AND productId = ?");
    
    $t = time();
    $q->execute(array($t, $t, $productId));
    if ($q != null && $r = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchOffer($r);
    }
    return null;
  }
  
  public function getOffer($id){
  if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("SELECT * FROM Offer WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchOffer($t);
    }
    return null;
  }
  
  public function saveOrUpdate($offer) {
    if ($offer == null) {
      return 0;
    }
    if ($offer->getId() == 0) {
      return $this->save($offer);
    }
    return $this->update($offer);
  }
  
  public function save($offer) {
    if ($offer == null) {
      return 0;
    }
    $sql = "INSERT INTO Offer (productId, price, startTime, endTime, displayOnlyImage) VALUE (?, ?, ?, ?, ?)";
    $q = $this->db->prepare($sql);
    $r = $q->execute(array(
      $offer->getProductId(),
      $offer->getPrice(),
      $offer->getStartTime(),
      $offer->getEndTime(),
      $offer->getDisplayOnlyImage()
    ));
    if ($r == 1) {
      $offer->setId($this->db->lastInsertId());
    }
    return $r;
  }
  
  public function update($offer) {
    if ($offer == null || $offer->getId() == null || $offer->getId() < 1) {
      return 0;
    }
    $sql = "UPDATE Offer SET productId = ?, price = ?, startTime = ?, endTime = ?, displayOnlyImage = ? WHERE id = ?";
    $q = $this->db->prepare($sql);
    return $q->execute(array(
      $offer->getProductId(),
      $offer->getPrice(),
      $offer->getStartTime(),
      $offer->getEndTime(),
      $offer->getDisplayOnlyImage()
    ));
  }
  
 public function delete($offerId) {
    if ($offerId == null || $offerId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM Offer WHERE id = ".$this->db->quote($offerId, PDO::PARAM_INT));
  }

  
  public function fetchOffer($t) {
    $o = new Offer($t["productId"], $t["price"], $t["startTime"], $t["endTime"], $t["displayOnlyImage"], $t["id"]);
    $o->setCommercialImage($t["commercialImage"]);
    return $o;
  }
}

?>
