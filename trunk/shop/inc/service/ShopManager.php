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
  
  public function getShopById($id) {
    return $this->shopDao->getShopById($id);
  }
  
  public function getAllShops() {
    return $this->shopDao->getAllShops('', 0, 1000);
  }
  
  public function getAllShopsAsDictionary() {
    $list = array();
    $tmpList = $this->getAllShops();
    if ($tmpList != null) {
      foreach ($tmpList as $t) {
        $list[$t->getId()] = $t->getName();
      }
    }
    return $list;
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
  
  public function saveOrUpdate($shop, $keywords) {
    global $db;
    try {
      $db->beginTransaction();
      if (!$this->shopDao->saveOrUpdate($shop)) {
        throw new Exception("Failed to save shop.");
      }
      $array = array();
      if ($keywords != null) {
        foreach ($keywords as $w) {
          array_push($array, new Keyword($w, $shop->getId()));
        }
      }
      $shop->setKeywords($array);
      
      $this->keywordDao->deleteAll($shop->getId());
      $this->keywordDao->saveAll($shop->getKeywords());
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
