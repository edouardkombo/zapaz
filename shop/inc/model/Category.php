<?php

/**
 * Description of Category
 *
 * @author mohamed
 */
class Category {

  private $id;
  private $name;

  function __construct($name, $id = 0) {
    $this->id = $id;
    $this->name = $name;
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

}

?>
