<?php

/**
 * Description of Label
 *
 * @author mohamed
 */
class Shop {

  private $id;
  private $name;
  private $currencyId;
  private $latitude;
  private $longitude;
  private $currency = null;
  private $keywords = null;

  function __construct($name, $currencyId, $latitude, $longitude, $id = 0) {
    $this->id = $id;
    $this->name = $name;
    $this->currencyId = $currencyId;
    $this->longitude = $longitude;
    $this->latitude = $latitude;
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

  public function setCurrencyId($id) {
    $this->currencyId = $id;
  }

  public function getCurrencyId() {
    return $this->currencyId;
  }

  public function setLatitude($latitude) {
    $this->latitude = $latitude;
  }

  public function getLatitude() {
    return $this->latitude;
  }

  public function setLongitude($longitude) {
    $this->longitude = $longitude;
  }

  public function getLongitude() {
    return $this->longitude;
  }

  public function getCurrency() {
    if ($this->currency == null && $this->currencyId != 0) {
      $d = new CurrencyDao();
      $this->currency = $d->getCurrencyById($this->currencyId);
    }
    return $this->currency;
  }

  public function setCurrency($currency) {
    if ($currency != null && get_class($currency) == "currency") {
      $this->currency = $currency;
      $this->currencyId = $currency->getId();
    }
  }

  public function getKeywords() {
    if ($this->keywords == null && $this->id != 0) {
      $d = new KeywordDao();
      $this->keywords = $d->getKeywordsByShopId($this->id);
    }
    return $this->keywords;
  }
}

?>
