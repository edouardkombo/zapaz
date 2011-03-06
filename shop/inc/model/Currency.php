<?php

/**
 * Description of Currency
 *
 * @author mohamed
 */
class Currency {

  private $id;
  private $name;
  private $symbol;

  function __construct($name, $symbol, $id = 0) {
    $this->id = $id;
    $this->name = $name;
    $this->symbol = $symbol;
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

  public function setSymbol($symbol) {
    $this->symbol = $symbol;
  }

  public function getSymbol() {
    return $this->symbol;
  }

}

?>
