<?php

/**
 * Description of UserChoice
 *
 * @author mohamed
 */
class UserChoice {

  private $id;
  private $userId;
  private $choice;
  private $startTime;
  private $endTime;

  function __construct($choice, $startTime, $endTime, $userId, $id = 0) {
    $this->id = $id;
    $this->userId = $userId;
    $this->choice = $choice;
    $this->startTime = $startTime;
    $this->endTime = $endTime;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function setUserId($id) {
    $this->userId = $id;
  }

  public function getUserId() {
    return $this->userId;
  }

  public function setStartTime($choice) {
    $this->choice = $choice;
  }

  public function getStartTime() {
    return $this->choice;
  }

  public function setEndTime($endTime) {
    $this->endTime = $endTime;
  }

  public function getEndTime() {
    return $this->endTime;
  }

}

?>
