<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/global.config.php');

$in = $_POST;

$id   = isset($in['id'])   && filter_var($in['id'], FILTER_VALIDATE_INT) && $in['id'] > 0 ? $in['id']   : null;
$name = isset($in['name']) && $in['name'] != ""                      ? $in['name'] : "";

if (!$fullPage) {
  $template = new ModeliXe('product/edit.mxt');
  $template->SetModeliXe();
}

$productManager = new ProductManager();
$categories     = $productManager->getAllCategoriesAsDictionary();
$productTypes   = $productManager->getAllTypesAsDictionary();

$p = null;
if ($id != null) {
  $p = $productManager->getProductById($id);
}
if ($p == null) {
  $p = new Product(0, 0, 0, $name, "", 0);
}

$picture = $p->getPicture() != null ? PROTOCOL.DOMAIN_ZSHOP.$p->getPicture() : PROTOCOL.DOMAIN_ZSHOP."/img/noimage.jpg";

$template->MxHidden($pre."hidden", $template->GetQueryString(array("id" => $p->getId(), "hpicture" => $p->getPicture())));

$template->MxAttribut($pre."ppicture", $picture);
$template->MxFormField($pre."name", "text", "name", $p->getName());
$template->MxFormField($pre."manufacturer", "text", "manufacturer", $p->getManufacturer());
$template->MxSelect($pre."category", "category", $p->getCategoryId(), $categories);
$template->MxSelect($pre."type", "type", $p->getTypeId(), $productTypes);
$template->MxFormField($pre."price", "text", "price", $p->getPrice());
$template->MxFormField($pre."description", "textarea", "description", $p->getDescription(), 'cols="40" rows="6"');

$details = $p->getDetails();
$tmpList = $productManager->getAllDetailTypes();
$detailTypeList = array();
foreach ($tmpList as $t) {
  $detailTypeList[$t->getName()] = $t->getName();
}
if ($details == null) {
  $details = array();
}
if (count($details) == 0) {
  array_push($details, new ProductDetail('', '', ''));
}
foreach ($details as $d) {
  $selectValue = $d->getDetailType() != null ? $d->getDetailType()->getName() : "";
  $template->MxSelect($pre."detail.type", "detailType", $selectValue, $detailTypeList);
  $template->MxFormField($pre."detail.name", "text", "detailName", $d->getName());
  $template->MxBloc($pre."detail", "loop");
}

if (!$fullPage) {
  $template->MxWrite();
}
?>
