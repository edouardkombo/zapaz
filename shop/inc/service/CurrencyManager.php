<?php

/**
 * Description of CategoryManager
 *
 * @author fabien
 */
class CurrencyManager {
  private $currencyDao;
  
  public function __construct() {
    $this->currencyDao = new CurrencyDao();
  }
  
  public function saveOrUpdate($currency) {
    return $this->currencyDao->saveOrUpdate($currency);
  }
}

?>
