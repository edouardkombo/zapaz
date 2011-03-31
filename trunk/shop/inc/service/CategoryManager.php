<?php

/**
 * Description of CategoryManager
 *
 * @author fabien
 */
class CategoryManager {
  private $categoryDao;
  
  public function __construct() {
    $this->categoryDao = new CategoryDao();
  }
  
  public function saveOrUpdate($category) {
    return $this->categoryDao->saveOrUpdate($category);
  }
}

?>
