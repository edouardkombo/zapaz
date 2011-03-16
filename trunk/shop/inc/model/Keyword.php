<?php

/**
 * Description of Keyword
 *
 * @author mohamed
 */
class Keyword {

  private $id;
  private $name;
  private $shopId;

  function __construct($name, $shopId, $id = 0) {
    $this->id = $id;
    $this->name = $name;
    $this->shopId = $shopId;
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

  public function getShopId() {
    return $this->shopId;
  }

  public function setShopId($shopId) {
    $this->shopId = $shopId;
  }
}

?>
