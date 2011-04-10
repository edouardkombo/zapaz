<?php
 include('../inc/global.config.php');

$in = $_POST;

$productId   = isset($in['productId'])   && filter_var($in['productId'], FILTER_VALIDATE_INT) && $in['productId'] > 0 ? $in['productId']   : null;
$price        = isset($in["price"])        && is_numeric($in["price"])    && $in["price"]    > 0 ? stripslashes($in["price"])        : 0;
$startTime = isset($in['startTime'])   && $in["startTime"]  != "" ? stripslashes($in["startTime"])  : "";
$endTime = isset($in['endTime'])   && $in["endTime"]  != "" ? stripslashes($in["endTime"])  : "";
$displayOnlyImage = isset($in['displayOnlyImage'])   && filter_var($in['displayOnlyImage'], FILTER_VALIDATE_INT) && $in['displayOnlyImage'] > 0 ? $in['displayOnlyImage']   : null;


$result = 0;
if ($productId != null && $price != null  && $startTime != null  && $endTime != null) { 
  $productManager = new ProductManager();
  $result  = $productManager->saveOffer(new Offer($productId, $price, $startTime, $endTime, $displayOnlyImage)); 
 }
 

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r><result>$result</result></r>
<r><productId>$productId</productId></r>
<r><price>$price</price></r>
<r><startTime>$startTime</startTime></r>
<r><endTime>$endTime</endTime></r>
<r><displayOnlyImage>$displayOnlyImage</displayOnlyImage></r>
END

?>
