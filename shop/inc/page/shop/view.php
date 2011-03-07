<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/local.config.php');

$in = $_POST;

if (!$fullPage) {
  $template = new ModeliXe('shop/view.mxt');
  $template->SetModeliXe();
}

$shopManager = new ShopManager();
$shop = $shopManager->getShop();
if ($shop == null) {
  $shop = new Shop("", "", "", "", 0, 0);
}

$logo = $shop->getLogo() != null ? PROTOCOL.DOMAIN_ZSHOP.$shop->getLogo() : PROTOCOL.DOMAIN_ZSHOP."/img/logo/nologo.jpg";
$address = $shopManager->splitAddress($shop->getAddress());
$currencyArray = $shopManager->getAllCurrencies();

$template->MxHidden($pre."hlogo", $template->GetQueryString(array("id" => $shop->getId(), "hlogo" => $shop->getLogo())));

$template->MxFormField($pre."name", "text", "name", $shop->getName(), 'id="name"');
$template->MxFormField($pre."email", "text", "email", $shop->getEmail(), 'id="email"');
$template->MxFormField($pre."latitude", "text", "latitude", $shop->getLatitude(), 'id="latitude"');
$template->MxFormField($pre."longitude", "text", "longitude", $shop->getLongitude(), 'id="longitude"');
$template->MxAttribut($pre."logo", $logo);

$template->MxFormField($pre."address0", "text", "address0", $address[0], 'id="address0" size="40" maxlength="85"');
$template->MxFormField($pre."address1", "text", "address1", $address[1], 'id="address1" class="alone" size="40" maxlength="85"');
$template->MxFormField($pre."address2", "text", "address2", $address[2], 'id="address2" class="alone" size="40" maxlength="85"');
$template->MxFormField($pre."zipCode", "text", "zipCode", $shop->getZipCode(), 'id="zipCode"');
$template->MxFormField($pre."city", "text", "city", $shop->getCity(), 'id="city"');
$template->MxFormField($pre."state", "text", "state", $shop->getState(), 'id="state"');
$template->MxSelect($pre."country", "country", $shop->getCountryId(), $countryArray);
$template->MxFormField($pre."phone", "text", "phone", $shop->getPhone(), 'id="phone"');
$template->MxSelect($pre."currency", "currency", $shop->getCurrencyId(), $currencyArray);

/*
$categoryList = $categoryManager->getAllCategories($filter, $startIndex, $limit);
foreach ($categoryList as $c) {
    $template->MxCheckerField($pre."row.input.check", "checkbox", "check", $c->getId());
    $template->MxBloc     ($pre."row.input", "loop");
    $template->MxText     ($pre."row.categoryName", $c->getName());
    $template->MxBloc($pre."row", "loop");
}
*/
if (!$fullPage) {
  $template->MxWrite();
}

?>