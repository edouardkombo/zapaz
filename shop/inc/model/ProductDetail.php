<?php

/**
 * Description of ProductDetail
 *
 * @author mohamed
 */
class ProductDetail {

  private $id;
  private $name;
  private $productId;
  private $detailTypeId;
  private $product = null;
  private $detailType = null;

  function __construct($name, $productId, $detailTypeId, $id = 0) {
    $this->id = $id;
    $this->name = $name;
    $this->productId = $productId;
    $this->detailTypeId = $detailTypeId;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getName() {
    return $this->name;
  }

  public function setProductId($id) {
    $this->productId = $id;
  }

  public function getProductId() {
    return $this->productId;
  }

  public function setDetailTypeId($id) {
    $this->detailTypeId = $id;
  }

  public function getDetailTypeId() {
    return $this->detailTypeId;
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

  public function getDetailType() {
    if ($this->detailType == null && $this->detailTypeId != 0) {
      $d = new DetailTypeDao();
      $this->detailType = $d->getProductById($this->detailTypeId);
    }
    return $this->detailType;
  }

  public function setDetailType($type) {
    if ($type != null && get_class($type) == "detailtype") {
      $this->detailType = $type;
      $this->detailTypeId = $type->getId();
    }
  }

}

?>
