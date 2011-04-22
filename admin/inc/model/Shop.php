<?php

/**
 * Description of Shop
 *
 * @author mohamed
 */
class Shop {

  private $id;
  private $publicUid;
  private $name;
  private $currencyId;
  private $latitude;
  private $longitude;
  private $email;
  private $webServiceUrl;
  private $countOfProducts;
  private $creationTime;
  private $lastUpdate;
  private $currency = null;
  private $keywords = null;

  function __construct($publicUid, $name, $currencyId, $latitude, $longitude, $email, $countOfProducts = 0, $creationTime = 0, $lastUpdate = 0, $id = 0) {
    $t = time();
    $this->id = $id;
    $this->publicUid = $publicUid;
    $this->name = $name;
    $this->currencyId = $currencyId;
    $this->longitude = $longitude;
    $this->latitude = $latitude;
    $this->email = $email;
    $this->countOfProducts = $countOfProducts;
    $this->creationTime = $creationTime != 0 ? $creationTime : $t;
    $this->lastUpdate = $lastUpdate != 0 ? $lastUpdate : $t;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function getPublicUid() {
    return $this->publicUid;
  }

  public function setPublicUid($publicUid) {
    $this->publicUid = $publicUid;
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

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function getWebServiceUrl() {
    return $this->webServiceUrl;
  }

  public function setWebServiceUrl($webServiceUrl) {
    $this->webServiceUrl = $webServiceUrl;
  }

  public function getCountOfProducts() {
    return $this->countOfProducts;
  }

  public function setCountOfProducts($countOfProducts) {
    $this->countOfProducts = $countOfProducts;
  }

  public function getCreationTime() {
    return $this->creationTime;
  }

  public function setCreationTime($creationTime) {
    $this->creationTime = $creationTime;
  }

  public function getLastUpdate() {
    return $this->lastUpdate;
  }

  public function setLastUpdate($lastUpdate) {
    $this->lastUpdate = $lastUpdate;
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

  public function addKeyword($word) {
    if ($this->keywords == null) {
      $this->keywords = array();
    }
    if ($word != null && $word != "") {
      array_push($this->keywords, $word);
    }
  }

  public function getKeywords() {
    if ($this->keywords == null && $this->id != 0) {
      $d = new KeywordDao();
      $this->keywords = $d->getKeywordsByShopId($this->id);
    }
    return $this->keywords;
  }

  public function getJSON() {
    $keywords = $this->getKeywords();
    $subJSON = "";

    foreach ($keywords as $k) {
      if ($subJSON != "")
        $subJSON.=",";
      $subJSON.='{"name":"' . $k->getName() . '"}';
    }


    return "{"
    . '"name":"' . $this->getName() . '",'
    . '"publicUid":"' . $this->getPublicUid() . '",'
    . '"currency":"' . $this->getCurrency()->getSymbol() . '",'
    . '"latitude":"' . $this->getLatitude() . '",'
    . '"longitude":"' . $this->getLongitude() . '",'
    . '"email":"' . $this->getEmail() . '",'
    . '"webServiceUrl":"' . $this->getWebServiceUrl() . '",'
    . '"countOfProducts":"' . $this->getCountOfProducts() . '",'
    . '"keywords":[' . $subJSON . ']'
    . "}";
  }

}

?>
