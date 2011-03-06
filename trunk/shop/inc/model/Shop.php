<?php

/**
 * Description of Shop
 *
 * @author mohamed
 */
class Shop {

  private $id;
  private $name;
  private $address;
  private $zipCode;
  private $city;
  private $state = null;
  private $countryId;
  private $phone = null;
  private $logo = null;
  private $currencyId;
  private $currency = null;
  private $keywords = null;

  function __construct($name, $address, $zipCode, $city, $countryId, $currencyId, $id = 0) {
    $this->id = $id;
    $this->name = $name;
    $this->address = $address;
    $this->zipCode = $zipCode;
    $this->city = $city;
    $this->countryId = $countryId;
    $this->currencyId = $currencyId;
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
    return $this->nameId;
  }

  public function setAddress($address) {
    $this->address = $address;
  }

  public function getAddress() {
    return $this->address;
  }

  public function setZipCode($zc) {
    $this->zipCode = $zc;
  }

  public function getZipCode() {
    return $this->zipCode;
  }

  public function setCity($city) {
    $this->city = city;
  }

  public function getCity() {
    return $this->city;
  }

  public function setState($state) {
    $this->state = state;
  }

  public function getState() {
    return $this->state;
  }

  public function setCountryId($countryId) {
    $this->countryId = $countryId;
  }

  public function getCountryId() {
    return $this->countryId;
  }

  public function setCurrencyId($currencyId) {
    $this->currencyId = $currencyId;
  }

  public function getCurrencyId() {
    return $this->currencyId;
  }

  public function setPhone($phone) {
    $this->phone = $phone;
  }

  public function getPhone() {
    return $this->phone;
  }

  public function setLogo($logo) {
    $this->logo = $logo;
  }

  public function getLogo() {
    return $this->logo;
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
