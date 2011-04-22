<?php

header("Content-type:application/xml");
include('../inc/global.config.php');

$productTypeManager = new ProductTypeManager();
$productTypes = $productTypeManager->getAllProductTypes('', 0, 1000000);

$doc = new DomDocument('1.0', 'utf-8');
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

$count = $doc->createElement('count');
$root->appendChild($count);

$value = $doc->createTextNode(count($productTypes));
$count->appendChild($value);

foreach ($productTypes as $t) {
  $type = $doc->createElement('type');
  $root->appendChild($type);
  
  $id = $doc->createElement('id');
  $value = $doc->createTextNode($t->getId());
  $id->appendChild($value);
  $type->appendChild($id);
  
  $name = $doc->createElement('name');
  $value = $doc->createTextNode($t->getName());
  $name->appendChild($value);
  $type->appendChild($name);
}

echo $doc->saveXML();
?>
