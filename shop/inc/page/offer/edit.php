<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/global.config.php');

$in = $_POST;

$id   = isset($in['id'])   && filter_var($in['id'], FILTER_VALIDATE_INT) && $in['id'] > 0 ? $in['id']   : null;
$price = isset($in['price'])   && filter_var($in['price'], FILTER_VALIDATE_FLOAT) && $in['price'] > 0 ? $in['price']   : null;
$startTime = isset($in['startTime'])   && $in['startTime'] > 0 ? $in['startTime']   : null;
$endTime = isset($in['endTime'])   && $in['endTime'] > 0 ? $in['endTime']   : null;
$displayOnlyImage = isset($in['displayOnlyImage'])   && $in['displayOnlyImage'] > 0 ? $in['displayOnlyImage']   : null;

if (!$fullPage) {
  $template = new ModeliXe('offer/create.mxt');
  $template->SetModeliXe();
}

$productManager = new ProductManager();
$offer  = $productManager->saveOffer(new Offer($productId, $price, $startTime, $endTime, $displayOnlyImage));






?>
