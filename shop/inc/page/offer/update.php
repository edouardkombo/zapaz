<?php
 include('../inc/global.config.php');

$in = $_POST;

$productId   = isset($in['productId'])   && filter_var($in['productId'], FILTER_VALIDATE_INT) && $in['productId'] > 0 ? $in['productId']   : null;
$price        = isset($in["price"])        && is_numeric($in["price"])    && $in["price"]    > 0 ? stripslashes($in["price"])        : 0;
$startTime = isset($in['startTime'])   && $in["startTime"]  != "" ? stripslashes($in["startTime"])  : "";
$endTime = isset($in['endTime'])   && $in["endTime"]  != "" ? stripslashes($in["endTime"])  : "";
$displayOnlyImage = isset($in['displayOnlyImage'])   && filter_var($in['displayOnlyImage'], FILTER_VALIDATE_INT) && $in['displayOnlyImage'] > 0 ? $in['displayOnlyImage']   : null;


$time1 = "";
$result = 0;
if ($productId != null && $price != null  && $startTime != null  && $endTime != null) { 
  $productManager = new ProductManager();
  $time1 = strtotime($startTime);
  $time2 = strtotime($endTime);
  $result  = $productManager->saveOffer(new Offer($productId, $price, $time1, $time2, $displayOnlyImage)); 
 }
 

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r>
 <result>$result</result>
 <startTime>$time1</startTime>
</r>
END

?>
