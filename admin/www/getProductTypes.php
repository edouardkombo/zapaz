<?php
include('../inc/global.config.php');



  $productTypeManager = new ProductTypeManager();
  $productTypes = $productTypeManager->getAllProductTypes();
  
$doc = new DomDocument('1.0', 'utf-8');
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

foreach ($productTypes as $pt) {
  
  $productType = $doc->createElement('product-Type');
  $productType = $root->appendChild($productType);
  $name = $pt->getName();
  $value = $doc->createTextNode($name);
  $value = $productType->appendChild($value);
}
$xml_string = $doc->saveXML();
echo $xml_string;


?>
