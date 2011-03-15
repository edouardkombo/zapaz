<?php

$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/local.config.php');

$in = $_POST;

$limit          = isset($in['limit'])          && $in['limit'] > 0 && $in['limit'] < 100 ? $in['limit']                        : 15;
$startIndex     = isset($in['start'])          && $in['start'] >= 0                      ? $in['start']                        : 0;
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
$count = $productManager->count($nameFilter, $categoryFilter, $typeFilter);
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

$productList = $productManager->getAllProducts($nameFilter, $categoryFilter, $typeFilter, $startIndex, $limit);
if (count($productList) == 0) {
  $template->MxBloc($pre."row", "reset");
} else {
  foreach ($productList as $p) {
    $template->MxCheckerField($pre."row.input.check", "checkbox", "check", $c->getId());
    $template->MxBloc     ($pre."row.input", "loop");
    $template->MxText     ($pre."row.name", $p->getName());
    $template->MxText     ($pre."row.category", $p->getCategory()->getName());
    $template->MxText     ($pre."row.type", $p->getType()->getName());
    $template->MxText     ($pre."row.manufacturer", $p->getManufacturer());
    $template->MxText     ($pre."row.price", $p->getPrice());
    $template->MxText     ($pre."row.description", $p->getDescription());
    
    $color = $p->getPicture() == null ? "red" : "green";
    $template->MxAttribut ($pre."row.c1", "light $color");
    $template->MxImage    ($pre."row.light1", PROTOCOL.DOMAIN_ZADMIN."/img/light.png", $color);
    $template->MxBloc     ($pre."row", "loop");
    
    $color = $ns->getOffer() == null ? "red" : "green";
    $template->MxAttribut ($pre."row.c2", "light $color");
    $template->MxImage    ($pre."row.light2", PROTOCOL.DOMAIN_ZADMIN."/img/light.png", $color);
    $template->MxBloc     ($pre."row", "loop");
    
    $template->MxBloc($pre."row", "loop");
  }
}

if (!$fullPage) {
  $template->MxWrite();
}
?>
