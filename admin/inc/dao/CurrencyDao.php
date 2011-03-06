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
  
  public function saveOrUpdate($currency) {
    if ($currency == null) {
      return 0;
    }
    if ($currency->getId() == 0) {
      return $this->save($currency);
    }
    return $this->update($currency);
  }
  
  public function save($currency) {
    if ($currency == null) {
      return 0;
    }
  }
  
  public function update($currency) {
    if ($currency == null || $currency->getId() == null || $currency->getId() < 1) {
      return 0;
    }
  }
  
  public function delete($currencyId) {
    if ($currencyId == null || $currencyId < 1) {
      return 0;
    }
    return $this->db->exec("DELETE FROM Currency WHERE id = ".$this->db->quote($currencyId, PDO::PARAM_INT));
  }
  
  private function fetchCurrency($t) {
    return new Currency($t["name"], $t["symbol"], $t["id"]);
  }
}

?>
