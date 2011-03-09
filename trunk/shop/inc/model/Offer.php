<?php

/**
 * Description of Offer
 *
 * @author mohamed
 */
class Offer {

  private $id;
  private $productId;
  private $price;
  private $startTime;
  private $endTime;
  private $commercialImage;
  private $displayOnlyImage;
  private $product = null;

  function __construct($productId, $price, $startTime, $endTime, $id = 0) {
    $this->id = $id;
    $this->productId = $productId;
    $this->price = $price;
    $this->startTime = $startTime;
    $this->endTime = $endTime;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function setProductId($id) {
    $this->productId = $id;
  }

  public function getProductId() {
    return $this->productId;
  }

  public function setPrice($price) {
    $this->price = $price;
  }

  public function getPrice() {
    return $this->price;
  }

  public function setStartTime($startTime) {
    $this->startTime = $startTime;
  }

  public function getStartTime() {
    return $this->startTime;
  }

  public function setEndTime($endTime) {
    $this->endTime = $endTime;
  }

  public function getEndTime() {
    return $this->endTime;
  }
  
  public function getCommercialImage() {
    return $this->commercialImage;
  }

  public function setCommercialImage($commercialImage) {
    $this->commercialImage = $commercialImage;
  }

  public function getDisplayOnlyImage() {
    return $this->displayOnlyImage;
  }

  public function setDisplayOnlyImage($displayOnlyImage) {
    $this->displayOnlyImage = $displayOnlyImage;
  }

  public function getProduct() {
    if ($this->product == null && $this->productId != 0) {
      $d = new OfferDao();
      $this->product = $d->getProductById($this->productId);
    }
    return $this->product;
  }

  public function setProduct($product) {
    if ($product != null && get_class($product) == "product") {
      $this->product = $product;
      $this->productId = $product->getId();
    }
  }

}

?>
