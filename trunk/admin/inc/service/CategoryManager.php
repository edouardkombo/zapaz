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
  
  public function getAllCategories($filter = '', $startIndex = 0, $limit = 10) {
    return $this->categoryDao->getAllCategories($filter, $startIndex, $limit);
  }
  
  public function count($filter = '') {
    return $this->categoryDao->count($filter);
  }
  
  public function saveOrUpdate($category) {
    return $this->categoryDao->saveOrUpdate($category);
  }
  
  public function delete($categoryId) {
    return $this->categoryDao->delete($categoryId);
  }
}

?>
