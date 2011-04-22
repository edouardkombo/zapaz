<?php

header("Content-type:application/xml");
include('../inc/global.config.php');

$currencyManager = new CurrencyManager();
$currencies = $currencyManager->getAllCurrencies();

$doc = new DomDocument('1.0', 'utf-8');
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

$count = $doc->createElement('count');
$root->appendChild($count);

$value = $doc->createTextNode(count($currencies));
$count->appendChild($value);

foreach ($currencies as $c) {
  $category = $doc->createElement('currency');
  $root->appendChild($category);
  
  $id = $doc->createElement('id');
  $value = $doc->createTextNode($c->getId());
  $id->appendChild($value);
  $category->appendChild($id);
  
  $name = $doc->createElement('name');
  $value = $doc->createTextNode($c->getName());
  $name->appendChild($value);
  $category->appendChild($name);
  
  $symbol = $doc->createElement('symbol');
  $value = $doc->createTextNode($c->getSymbol());
  $symbol->appendChild($value);
  $category->appendChild($symbol);
}

echo $doc->saveXML();
?>
