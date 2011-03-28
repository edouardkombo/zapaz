<?php

include('../inc/global.config.php');

$in = $_GET;


//Add additional regex for expression for search terms
$publicUid = isset($in["publicUid"]) && $in["publicUid"] != '' ? $in["publicUid"] : 0;
$search1 = isset($in['search1']) ? $in['search1'] : null;
$search2 = isset($in['search2']) ? $in['search2'] : null;

$doc = new DomDocument('1.0', 'utf-8');
$doc->formatOutput = true;
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

$shopManager = new ShopManager();
$shop = $shopManager->getShopByPublicUid($publicUid);

if ($shop != null) {
  $shopId = $shop->getId();

  $productManager = new ProductManager();
  $productResults = $productManager->getAllProducts($shopId);

  foreach ($productResults as $prd) {
    $product = $doc->createElement("product");
    $product = $root->appendChild($product);

    $id = $doc->createElement('id');
    $id->appendChild($doc->createTextNode($prd->getId()));
    $product->appendChild($id);

    $name = $doc->createElement("name");
    $name->appendChild(
            $doc->createTextNode($prd->getName())
    );
    $product->appendChild($name);

    $categoryId = $doc->createElement("categoryId");
    $categoryId->appendChild(
            $doc->createTextNode($prd->getCategoryId())
    );
    $product->appendChild($categoryId);

    $typeId = $doc->createElement("typeId");
    $typeId->appendChild(
            $doc->createTextNode($prd->getTypeId())
    );
    $product->appendChild($typeId);

    $shopId = $doc->createElement('shopId');
    $shopId->appendChild($doc->createTextNode($prd->getShopId()));
    $product->appendChild($shopId);

    $manufactuer = $doc->createElement("manufacturer");
    $manufactuer->appendChild(
            $doc->createTextNode($prd->getManufacturer())
    );
    $product->appendChild($manufactuer);
    
    $price = $doc->createElement("price");
    $price->appendChild(
            $doc->createTextNode($prd->getPrice())
    );
    $product->appendChild($price);
    
    $description = $doc->createElement("description");
    $description->appendChild(
            $doc->createTextNode($prd->getDescription())
    );
    $product->appendChild($description);
    
    $picture = $doc->createElement("picture");
    $picture->appendChild(
            $doc->createTextNode($prd->getPicture())
    );
    $product->appendChild($picture);
    
  }

// tell the browser what kind of file is come in
} else {
  //Send error message
}
//header("Content-type: text/xml");
echo $doc->saveXML();
?>

