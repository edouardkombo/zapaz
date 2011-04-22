<?php

/**
 * Description of User
 *
 * @author mohamed
 */
class User {
  private $session;

  private $id;
  private $facebookId;
  private $facebookName;
  private $creationTime;
  private $lastConnection;
  private $choices = null;

  function __construct($facebookId, $facebookName, $creationTime = 0, $lastConnection = 0, $id = 0) {
    global $session;
    $this->session = $session;
    
    $t = time();
    $this->id             = $id;
    $this->facebookId     = $facebookId;
    $this->facebookName   = $facebookName;
    $this->creationTime   = $creationTime   > 0 ? $creationTime   : $t;
    $this->lastConnection = $lastConnection > 0 ? $lastConnection : $t;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }
  
  public function getFacebookId() {
    return $this->facebookId;
  }

  public function getFacebookName() {
    return $this->facebookName;
  }

  public function getCreationTime() {
    return $this->creationTime;
  }

  public function getLastConnection() {
    return $this->lastConnection;
  }
  
  public function canRead() {
    return $this->session->getPermissions() & PERMISSIONS_VIEW;
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
