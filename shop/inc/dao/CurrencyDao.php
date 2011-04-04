<?php

/**
 * Description of CurrencyDao
 *
 * @author fabien
 */
class CurrencyDao {
  
  private $db;
  
  public function __construct() {
    global $db;
    $this->db = $db;
  }
  
  public function getCurrencyById($id) {
    if ($id == null || $id < 1) {
      return null;
    }
    $q = $this->db->query("SELECT * FROM Currency WHERE id = ".$this->db->quote($id, PDO::PARAM_INT));
    if ($q != null && $t = $q->fetch(PDO::FETCH_ASSOC)) {
      return $this->fetchCurrency($t);
    }
    return null;
  }
  
  public function getAllCurrencies() {
    $array = array();
    $q = $this->db->query("SELECT * FROM Currency");
    if ($q != null) {
      while ($t = $q->fetch(PDO::FETCH_ASSOC)) {
        array_push($array, $this->fetchCurrency($t));
      }
    }
    return $array;
  }
  
  public function saveOrUpdate($currency) {
    if ($currency == null) {
      return 0;
    }
    $sql = "INSERT INTO Currency (id,name,symbol) VALUE (:id,:name,:symbol) ON DUPLICATE KEY UPDATE id = :id";
    $q = $this->db->prepare($sql);
    $r = $q->execute(array(
      "id"   => $currency->getId(),
      "name" => $currency->getName(),
      "symbol" => $currency->getSymbol()
    ));
    return $r;
  }
  
  private function fetchCurrency($t) {
    return new Currency($t["name"], $t["symbol"], $t["id"]);
  }
}

?>
