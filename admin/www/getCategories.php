<?php

include('../inc/global.config.php');

$categoryManager = new CategoryManager();
$categories = $categoryManager->getAllCategories('', 0, 1000000);

$doc = new DomDocument('1.0', 'utf-8');
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

foreach ($categories as $cat) {
  $category = $doc->createElement('category');
  $category = $root->appendChild($category);
  
  $value = $doc->createTextNode($cat->getName());
  $category->appendChild($value);
}

echo $doc->saveXML();
?>
