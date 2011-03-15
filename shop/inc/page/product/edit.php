<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/global.config.php');

$in = $_GET;

$id = isset($in['id']) && $in['id'] > 0 ? $in['id'] : null;

if (!$fullPage) {
  $template = new ModeliXe('product/edit.mxt');
  $template->SetModeliXe();
}

$productManager = new ProductManager();

$categories = $productManager->getAllCategories();
$productTypes = $productManager->getAllTypes();

$p = null;
if ($id != null) {
  $p = $productManager->getProductById($id);
}
if ($p == null) {
  $p = new Product(0, 0, 0, "", "", 0);
}

$picture = $p->getPicture() != null ? PROTOCOL.DOMAIN_ZSHOP.$p->getPicture() : PROTOCOL.DOMAIN_ZSHOP."/img/noimage.jpg";

$template->MxHidden($pre."hpicture", $template->GetQueryString(array("hpicture" => $p->getPicture())));

$template->MxAttribut($pre."ppicture", $picture);
$template->MxFormField($pre."name", "text", "name", $p->getName());
$template->MxFormField($pre."manufacturer", "text", "manufacturer", $p->getManufacturer());
$template->MxSelect($pre."category", "category", $p->getCategoryId(), $categories);
$template->MxSelect($pre."type", "type", $p->getTypeId(), $productTypes);
$template->MxFormField($pre."price", "text", "price", $p->getPrice());
$template->MxFormField($pre."description", "textarea", "description", $p->getDescription(), 'cols="40" rows="6"');

$details = $p->getDetails();
$detailTypeList = $productManager->getAllDetailTypes();
if ($details == null) {
  $details = array();
}
if (count($details) == 0) {
  array_push($details, new ProductDetail('', '', ''));
}
foreach ($details as $d) {
  $template->MxSelect($pre."detail.type", "detailType", $d->getDetailType(), $detailTypeList);
  $template->MxFormField($pre."detail.name", "text", "detailName", $d->getName());
  $template->MxBloc($pre."detail", "loop");
}

$template->MxHidden($pre."productId", $template->GetQueryString(array("id" => $p->getId())));

if (!$fullPage) {
  $template->MxWrite();
}
?>
