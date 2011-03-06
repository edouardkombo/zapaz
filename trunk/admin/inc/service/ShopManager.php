<?php

/**
 * Description of ShopManager
 *
 * @author fabien
 */
class ShopManager {
  
  private $shopDao;
  
  public function __construct() {
    $this->shopDao = new ShopDao();
  }
}

?>
