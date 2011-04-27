<?php

header("Content-type: application/json");
include('../inc/global.config.php');

$in = $_GET;


//Add additional regex for expression for search terms
$publicUid = isset($in['publicUid']) && $in['publicUid'] != '' ? $in['publicUid'] : null;
$search1 = isset($in['search1']) ? $in['search1'] : null;
$search2 = isset($in['search2']) ? $in['search2'] : null;

$doc = new DomDocument('1.0', 'utf-8');
$doc->formatOutput = true;
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

$products = array();
if ($publicUid != null) {
  $shopManager = new ShopManager();
  $shop = $shopManager->getShopByPublicUid($publicUid);

  $products = array();
  if ($shop != null) {
    $shopId = $shop->getId();

    $productManager = new ProductManager();
    $products = $productManager->getAllProducts($shopId);
  }
}

$json = "[";
foreach ($products as $p) {
  if ($json != "[")
    $json .= ", ";
  $json .= $p->getJSON();
}
$json .= "]";
echo $json;

?>

