<?php

include('../inc/global.config.php');

$categoryManager = new CategoryManager();
$categories = $categoryManager->getAllCategories();

$doc = new DomDocument('1.0', 'utf-8');
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

foreach ($categories as $cat) {
  $category = $doc->createElement('category');
  $category = $root->appendChild($category);
  $name = $cat->getName();
  $value = $doc->createTextNode($name);
  $value = $category->appendChild($value);
}
$xml_string = $doc->saveXML();
echo $xml_string;
?>
