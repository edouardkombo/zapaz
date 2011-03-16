<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/global.config.php');

$in = $_POST;
$shopId = isset($in["shopId"]) && is_numeric($in["shopId"]) && $in["shopId"] > 0 ? $in["shopId"] : 0;

if ($shopId > 0) {
  include('shop/view.php');
  exit();
}
if (!$fullPage) {
  $template = new ModeliXe('default/view.mxt');
  $template->SetModeliXe();
} else {
  $shopManager = new ShopManager();
  $shops = $shopManager->getAllShopsAsDictionary();
  array_unshift($shops, "");
  $shops["999999"] = "New Shop...";
  $template->MxSelect("header.shopList", "shops", $shopId, $shops);
  $template->MxHidden("header.currentShopId", $template->GetQueryString(array("currentShopId" => $shopId)));
}

if (!$fullPage) {
  $template->MxWrite();
}

?>