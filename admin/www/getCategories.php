<?php

include('../inc/global.config.php');

$categoryManager = new CategoryManager();
$categories = $categoryManager->getAllCategories('', 0, 1000000);

$doc = new DomDocument('1.0', 'utf-8');
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

$count = $doc->createElement('count');
$root->appendChild($count);

$value = $doc->createTextNode(count($categories));
$count->appendChild($value);

foreach ($categories as $c) {
  $category = $doc->createElement('category');
  $root->appendChild($category);
  
  $id = $doc->createElement('id');
  $value = $doc->createTextNode($c->getId());
  $id->appendChild($value);
  $category->appendChild($id);
  
  $name = $doc->createElement('name');
  $value = $doc->createTextNode($c->getName());
  $name->appendChild($value);
  $category->appendChild($name);
}

echo $doc->saveXML();
?>
