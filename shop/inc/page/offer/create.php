<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";

$in = $_GET;
$id = isset($in["id"]) && filter_var($in["id"], FILTER_VALIDATE_INT) && $in["id"] > 0 ? stripslashes($in["id"]) : 0;

$template = new ModeliXe('offer/create.mxt');
$template->SetModeliXe();


$productManager = new ProductManager();

$p = null;
if ($id != null) {
  $p = $productManager->getOffer($id);
}
if ($p == null) {
  $p = new Offer(0, 0, 0, 0, 0);
}
$picture = $p->getCommercialImage() != null ? PROTOCOL.DOMAIN_ZSHOP.$p->getCommercialImage() : PROTOCOL.DOMAIN_ZSHOP."/img/o/noimage.jpg";

$template->MxHidden($pre."hidden", $template->GetQueryString(array("id" => $p->getId(), "hpicture" => $p->getCommercialImage())));

$template->MxAttribut($pre."ppicture", $picture);

if (!$fullPage) {
  $template->MxWrite();
}

?>
