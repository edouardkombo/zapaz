<?php

$fullPage = isset($fullPage) ? $fullPage : false;
$pre = $fullPage ? "content." : "";
if (!$fullPage)
  include('../inc/global.config.php');

$in = $_POST;

$startIndex = isset($in['start']) && filter_var($in['start'], FILTER_VALIDATE_INT) && $in['start'] >= 0 ? $in['start'] : 0;
$limit = isset($in['limit']) && filter_var($in['limit'], FILTER_VALIDATE_INT) && $in['limit'] > 0 && $in['limit'] < 100 ? $in['limit'] : 15;
$filter = isset($in['filter']) && $in['filter'] != null ? stripslashes($in['filter']) : '';

if (!$fullPage) {
  $template = new ModeliXe('shop/view.mxt');
  $template->SetModeliXe();
}

$template->MxAttribut($pre . "filterValue", $filter);

$template->MxSelect($pre . "limitSelect", "limit", $limit, array(
    "5" => "5",
    "10" => "10",
    "15" => "15",
    "20" => "20",
    "25" => "25",
    "30" => "30"
));

$shopManager = new ShopManager();
$count = $shopManager->count($filter);
$nbPage = $count / $limit + 1;
while ($startIndex >= $count)
  $startIndex -= $limit;
if ($startIndex < 0)
  $startIndex = 0;

$currentPage = $startIndex / $limit + 1;
for ($i = 1, $j = 0; $i < $nbPage && $j < 5; $i++) {
  if ($i >= $currentPage - 2) {
    $template->MxAttribut($pre . "pageNav.pageNumberLink", "#");
    if ($i == $currentPage)
      $template->MxAttribut($pre . "pageNav.pageNumberClass", "current other-page");
    else
      $template->MxAttribut($pre . "pageNav.pageNumberClass", "other-page");
    $template->MxText($pre . "pageNav.pageNumberText", $i);
    $template->MxBloc($pre . "pageNav", "loop");
    $j++;
  }
}
$template->MxAttribut($pre . "maxPage", (int) $nbPage);


$shopList = $shopManager->getAllShops($filter, $startIndex, $limit);
if (count($shopList) == 0) {
  $template->MxBloc($pre . "row", "reset");
} else {
  foreach ($shopList as $c) {
    $keywords = $c->getKeywords();
    $arr = array();
    foreach ($keywords as $k) {
      array_push($arr, $k->getName());
    }
    $template->MxCheckerField($pre . "row.input.check", "checkbox", "check", $c->getId());
    $template->MxBloc($pre . "row.input", "loop");
    $template->MxText($pre . "row.shopName", $c->getName());
    $template->MxAttribut($pre . "row.mailto", "mailto:" . $c->getEmail());
    $template->MxText($pre . "row.shopEmail", $c->getEmail());
    $template->MxText($pre . "row.shopKeywords", implode(",", $arr));
    $template->MxAttribut($pre . "row.geo", "http://maps.google.com/?ll=" . $c->getLatitude() . "," . $c->getLongitude());
    $template->MxText($pre . "row.shopCoordinates", $c->getLatitude() . " " . $c->getLongitude());
    $template->MxText($pre . "row.shopCurrency", $c->getCurrency()->getName());
    $template->MxBloc($pre . "row", "loop");
  }
}

if (!$fullPage) {
  $template->MxWrite();
}
?>
