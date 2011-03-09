<?php

/**
 * Description of ShopManager
 *
 * @author fabien
 */
class ShopManager {
  
  private $shopDao;
  private $keywordDao;
  private $currencyDao;
  
  public function __construct() {
    $this->shopDao = new ShopDao();
    $this->currencyDao = new CurrencyDao();
    $this->keywordDao = new KeywordDao();
  }
  
  public function getShop() {
    return $this->shopDao->getShop();
  }
  
  public function getAllCurrencies() {
    $tmp = $this->currencyDao->getAllCurrencies();
    $array = array();
    if (count($tmp) > 0) {
      foreach ($tmp as $c) {
        $array[$c->getId()] = ucwords($c->getName())." (".$c->getSymbol().")";
      }
    }
    return $array;
  }
  
  public function splitAddress($address) {
    $result = array("", "", "");
    preg_match_all("/\{\{([^\}]*)\}\}/", $address, $matches);
    for ($i = 0; $i < count($matches[1]) && $i < 3; $i++) {
      $result[$i] = $matches[1][$i];
    }
    return $result;
  }
  
  public function mergeAddresses($address0, $address1, $address2) {
    $address  = "{{".$address0."}}";
    $address .= "{{".$address1."}}";
    $address .= "{{".$address2."}}";
    return $address;
  }
  
  public function saveOrUpdate($shop) {
    return $this->shopDao->saveOrUpdate($shop);
  }
}

?>
