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

$template->MxAttribut($pre."plogo", $picture);
$template->MxFormField($pre."name", "text", "name", $p->getName());
$template->MxFormField($pre."manufacturer", "text", "manufacturer", $p->getManufacturer());
$template->MxSelect($pre."category", "category", $p->getCategoryId(), $categories);
$template->MxSelect($pre."type", "type", $p->getTypeId(), $productTypes);
$template->MxFormField($pre."price", "text", "price", $p->getPrice());
$template->MxFormField($pre."description", "textarea", "description", $p->getDescription(), 'cols="40" rows="6"');

$details = $p->getDetails();
if ($details == null) {
  $details = array();
}
array_push($details, new ProductDetail("", 0, 0));
foreach ($details as $d) {
  $typeName = $d->getDetailType() != null ? $d->getDetailType()->getName() : "";
  $template->MxFormField($pre."detail.type", "text", "detailType", $typeName);
  $template->MxFormField($pre."detail.name", "text", "detailName", $d->getName());
  $template->MxBloc("detail", "loop");
}

$offer = $p->getOffer();
if ($offer == null) {
  $offer = new Offer(0, 0, 0, 0, 0);
}

$picture = $offer->getCommercialImage() != null ? PROTOCOL.DOMAIN_ZSHOP.$offer->getCommercialImage() : PROTOCOL.DOMAIN_ZSHOP."/img/noimage.jpg";

$template->MxAttribut($pre."ologo", $picture);
$template->MxAttribut($pre."onlyImage", $offer->getDisplayOnlyImage());
$template->MxFormField($pre."discountPrice", "text", "discountPrice", "0");
$template->MxFormField($pre."startTime", "text", "startTime", "0");
$template->MxFormField($pre."endTime", "text", "endTime", "0");

$template->MxHidden($pre."productId", $template->GetQueryString(array("id" => $p->getId())));

if (!$fullPage) {
  $template->MxWrite();
}
?>
