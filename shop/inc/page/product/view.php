<?php

$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/global.config.php');

$in = $_POST;
$shopId = isset($in["shopId"]) && filter_var($in["shopId"], FILTER_VALIDATE_INT) && $in["shopId"] > 0 ? $in["shopId"] : 0;

$startIndex     = isset($in['start']) && filter_var($in['start'], FILTER_VALIDATE_INT) && $in['start'] >= 0                      ? $in['start']                        : 0;
$limit          = isset($in['limit']) && filter_var($in['limit'], FILTER_VALIDATE_INT) && $in['limit'] > 0 && $in['limit'] < 100 ? $in['limit']                        : 15;
$nameFilter     = isset($in['nameFilter'])     && $in['nameFilter'] != null              ? stripslashes($in['nameFilter'])     : '';
$categoryFilter = isset($in['categoryFilter']) && $in['categoryFilter'] != null          ? stripslashes($in['categoryFilter']) : '';
$typeFilter     = isset($in['typeFilter'])     && $in['typeFilter'] != null              ? stripslashes($in['typeFilter'])     : '';

if (!$fullPage) {
  $template = new ModeliXe('product/view.mxt');
  $template->SetModeliXe();
}

$template->MxAttribut($pre."nameFilter", $nameFilter);
$template->MxAttribut($pre."typeFilter", $typeFilter);

$template->MxSelect($pre."limitSelect", "limit", $limit, array(
  "5" => "5",
  "10" => "10",
  "15" => "15",
  "20" => "20",
  "25" => "25",
  "30" => "30"
));

$productManager = new ProductManager();
$count = $productManager->count($shopId, $nameFilter, $categoryFilter, $typeFilter);
$nbPage = $count / $limit + 1;
while ($startIndex >= $count)
  $startIndex -= $limit;
if ($startIndex < 0)
  $startIndex = 0;

$currentPage = $startIndex / $limit + 1;
for ($i = 1, $j = 0; $i < $nbPage && $j < 5; $i++) {
  if ($i >= $currentPage - 2) {
    $template->MxAttribut ($pre."pageNav.pageNumberLink", "#");
    if ($i == $currentPage)
        $template->MxAttribut ($pre."pageNav.pageNumberClass", "current other-page");
    else
        $template->MxAttribut ($pre."pageNav.pageNumberClass", "other-page");
    $template->MxText     ($pre."pageNav.pageNumberText", $i);
    $template->MxBloc     ($pre."pageNav", "loop");
    $j++;
  }
}
$template->MxAttribut($pre."maxPage", (int)$nbPage);
$template->MxFormField($pre."newProduct", "text", "productName", "", 'size="60"');

$productList = $productManager->getAllProducts($shopId, $nameFilter, $categoryFilter, $typeFilter, $startIndex, $limit);
if (count($productList) == 0) {
  $template->MxBloc($pre."row", "reset");
} else {
  foreach ($productList as $p) {
    $description = $p->getDescription();
    if (strlen($description) > 70) {
      $description = substr($description, 0, 69)."…";
    }
    
    $template->MxCheckerField($pre."row.input.check", "checkbox", "check", $p->getId());
    $template->MxBloc     ($pre."row.input", "loop");
    $template->MxText     ($pre."row.name", $p->getName());
    $template->MxText     ($pre."row.type", $p->getType()->getName());
    $template->MxText     ($pre."row.manufacturer", $p->getManufacturer());
    $template->MxText     ($pre."row.price", $p->getPrice());
    $template->MxText     ($pre."row.description", $description);
    
    $color = $p->getPicture() == null ? "red" : "green";
    $template->MxAttribut ($pre."row.c1", "light $color");
    $template->MxImage    ($pre."row.light1", PROTOCOL.DOMAIN_ZSHOP."/img/light.png", $color);
    
    $color = $p->getCurrentOffer() == null ? "red" : "green";
    $template->MxAttribut ($pre."row.c2", "light $color");
    $template->MxImage    ($pre."row.light2", PROTOCOL.DOMAIN_ZSHOP."/img/light.png", $color);
    
    $template->MxBloc($pre."row", "loop");
  }
}

if (!$fullPage) {
  $template->MxWrite();
}
?>
