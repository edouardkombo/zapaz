<?php

$in = $_POST;

$id           = isset($in["id"])           && filter_var($in["id"], FILTER_VALIDATE_INT)       && $in["id"]     > 0 ? stripslashes($in["id"])             : 0;
$picture      = isset($in["picture"])      && $in["picture"]      != "" ? stripslashes($in["picture"])      : "";
$name         = isset($in["name"])         && $in["name"]         != "" ? stripslashes($in["name"])         : null;
$manufacturer = isset($in["manufacturer"]) && $in["manufacturer"] != "" ? stripslashes($in["manufacturer"]) : null;
$categoryId   = isset($in["category"])     && filter_var($in["category"], FILTER_VALIDATE_INT) && $in["category"] > 0 ? stripslashes($in["category"]) : null;
$typeId       = isset($in["type"])         && filter_var($in["type"], FILTER_VALIDATE_INT)     && $in["type"]     > 0 ? stripslashes($in["type"])         : null;
$shopId       = isset($in["shop"])         && filter_var($in["shop"], FILTER_VALIDATE_INT)     && $in["shop"]     > 0 ? stripslashes($in["shop"])         : null;
$price        = isset($in["price"])        && is_numeric($in["price"])    && $in["price"]    > 0 ? stripslashes($in["price"])        : 0;
$description  = isset($in["description"])  && $in["description"]  != "" ? stripslashes($in["description"])  : "";
$details      = isset($in["details"])      && $in["details"]      != "" ? stripslashes($in["details"])      : null;

$result = 0;
if ($name != null && $manufacturer != null && $categoryId != null && $typeId != null && $shopId != null && $price != null) {
  $p = new Product($categoryId, $typeId, $shopId, $name, $manufacturer, $price, $id);
  $p->setDescription($description);
  $p->setPicture($picture);
  
  $array = array();
  if ($details != null) {
    $listOfDetails = explode("||", $details);
    foreach ($listOfDetails as $l) {
      $elements = explode(";", $l);
      if (count($elements) == 2) {
        array_push($array, array($elements[0], $elements[1]));
      }
    }
  }
  
  $productManager = new ProductManager();
  $result = $productManager->saveOrUpdateProduct($p, $array);
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r><result>$result</result></r>
END

?>
