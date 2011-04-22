<?php

/**
 * Description of Product
 *
 * @author mohamed
 */
class Product {

  private $id;
  private $name;
  private $categoryId;
  private $typeId;
  private $shopId;
  private $manufacturer;
  private $price;
  private $picture;
  private $description = null;
  private $category = null;
  private $type = null;
  private $shop = null;
  private $details = null;
  private $offer = null;
  
  function __construct($categoryId, $typeId, $shopId, $name, $manufacturer, $price, $id = 0) {
    $this->id = $id;
    $this->name = $name;
    $this->categoryId = $categoryId;
    $this->typeId = $typeId;
    $this->shopId = $shopId;
    $this->manufacturer = $manufacturer;
    $this->price = $price;
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

  public function setCategoryId($id) {
    $this->categoryId = $id;
  }

  public function getCategoryId() {
    return $this->categoryId;
  }

  public function setTypeId($id) {
    $this->typeId = $id;
  }

  public function getTypeId() {
    return $this->typeId;
  }

  public function setShopId($id) {
    $this->shopId = $id;
  }

  public function getShopId() {
    return $this->shopId;
  }

  public function setManufacturer($manufacturer) {
    $this->manufacturer = $manufacturer;
  }

  public function getManufacturer() {
    return $this->manufacturer;
  }

  public function setPrice($price) {
    $this->price = $price;
  }

  public function getPrice() {
    return $this->price;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getCategory() {
    if ($this->category == null && $this->categoryId > 0) {
      $d = new CategoryDao();
      $this->category = $d->getCategoryById($this->categoryId);
    }
    return $this->category;
  }

  public function setCategory($category) {
    if ($category != null && get_class($category) == "category") {
      $this->category = $category;
      $this->categoryId = $category->getId();
    }
  }

  public function getType() {
    if ($this->type == null && $this->typeId > 0) {
      $d = new ProductTypeDao();
      $this->type = $d->getProductTypeById($this->typeId);
    }
    return $this->type;
  }

  public function setType($type) {
    if ($type != null && get_class($type) == "producttype") {
      $this->type = $type;
      $this->typeId = $type->getId();
    }
  }
  
  public function getPicture() {
    return $this->picture;
  }

  public function setPicture($picture) {
    $this->picture = $picture;
  }
  
  public function getShop() {
    if ($this->shop == null && $this->shopId > 0) {
      $d = new ShopDao();
      $this->shop = $d->getShopById($this->shopId);
    }
    return $this->shop;
  }

  public function setShop($shop) {
    if ($shop != null && get_class($shop) == "shop") {
      $this->shop = $shop;
      $this->shopId = $shop->getId();
    }
  }

  public function getDetails() {
    if ($this->details == null && $this->id > 0) {
      $d = new ProductDetailDao();
      $this->details = $d->getDetailsForProductId($this->id);
    }
    return $this->details;
  }

  public function setDetails($details) {
    $this->details = $details;
  }
  
  /**
   * Get the current offer.
   * @return The current available offer.
   */
  public function getCurrentOffer() {
    if ($this->offer == null && $this->id > 0) {
      $d = new OfferDao();
      $this->offer = $d->getOfferByProductId($this->id);
    }
    return $this->offer;
  }
  
  public function setOffer($offer) {
    $this->offer = $offer;
  }
  
  public function getJSON() {
    $details = $this->getDetails();
    $subJson = "";
    foreach ($details as $d) {
      if ($subJson != "")
        $subJson .= ",";
      $subJson .= '{ "name":"'.$d->getDetailType()->getName().'" , "value":"'.$d->getName().'" }';
    }     
    return '{'
     . '"name":"'.$this->getName().'",'
     . '"manufacturer":"'.$this->getManufacturer().'",'
     . '"category":"'.$this->getCategory()->getName().'",'
     . '"type":"'.$this->getType()->getName().'",'
     . '"price":"'.$this->getPrice().'",'
     . '"description":"'.$this->getDescription().'",'
     . '"details":['.$subJson.']'
     . '}';
  }
}

?>
