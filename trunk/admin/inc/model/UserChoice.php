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
  private $creationTime;
  private $lastUpdate;

  function __construct($choice, $startTime, $endTime, $userId, $creationTime, $lastUpdate, $id = 0) {
    $this->id = $id;
    $this->userId = $userId;
    $this->choice = $choice;
    $this->startTime = $startTime;
    $this->endTime = $endTime;
    $this->creationTime = $creationTime;
    $this->lastUpdate = $lastUpdate;
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

  public function getChoice() {
    return $this->choice;
  }

  public function setChoice($choice) {
    $this->choice = $choice;
  }

  public function getCreationTime() {
    return $this->creationTime;
  }

  public function setCreationTime($creationTime) {
    $this->creationTime = $creationTime;
  }

  public function getLastUpdate() {
    return $this->lastUpdate;
  }

  public function setLastUpdate($lastUpdate) {
    $this->lastUpdate = $lastUpdate;
  }
}

?>
