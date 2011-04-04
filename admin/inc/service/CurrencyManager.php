<?php

class CurrencyManager {
  
  private $currencyDao;
  
  public function __construct() {
    $this->currencyDao = new CurrencyDao();
  }
  
  public function getAllCurrencies() {
    return $this->currencyDao->getAllCurrencies();
  }
}
?>
