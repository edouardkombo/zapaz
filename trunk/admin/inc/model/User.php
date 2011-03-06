<?php

/**
 * Description of User
 *
 * @author mohamed
 */
class User {

  private $id;
  private $email;
  private $password;
  private $choices = null;

  function __construct($email, $password, $id = 0) {
    $this->id = $id;
    $this->email = $email;
    $this->password = $password;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setPassword($pw) {
    $this->password = $pw;
  }

  public function getPassword() {
    return $this->password;
  }
  
  public function getChoices() {
    if ($this->choices == null && $this->id != 0) {
      $d = new UserChoiceDao();
      $this->choices = $d->getChoicesByUserId($this->id);
    }
    return $this->choices;
  }
}

?>
