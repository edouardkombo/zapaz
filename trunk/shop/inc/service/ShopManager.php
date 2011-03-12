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
    global $db;
    try {
      $db->beginTransaction();
      if (!$this->shopDao->saveOrUpdate($shop)) {
        throw new Exception("Failed to save shop.");
      }
        
      if (!$this->keywordDao->deleteAll($shop->getId())) {
        throw new Exception("Failed to delete old keywords.");
      }
      
      if (!$this->keywordDao->saveAll($shop->getKeywords(), $shop->getId())) {
        throw new Exception("Failed to save new keywords.");
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      echo $e;
      return 0;
    }
    return 1;
  }
}

?>
