<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/global.config.php');

$in = $_POST;
$shopId = isset($in["shopId"]) && filter_var($in["shopId"], FILTER_VALIDATE_INT) && $in["shopId"] > 0 ? $in["shopId"] : 0;

if (!$fullPage) {
  $template = new ModeliXe('shop/view.mxt');
  $template->SetModeliXe();
}

$shopManager = new ShopManager();
$shop = $shopManager->getShopById($shopId);
if ($shop == null) {
  $shop = new Shop("", "", "", "", "", 1, 1, "", 0, 0);
}

$logo = $shop->getLogo() != null ? PROTOCOL.DOMAIN_ZSHOP.$shop->getLogo() : PROTOCOL.DOMAIN_ZSHOP."/img/logo/nologo.jpg";
$address = $shopManager->splitAddress($shop->getAddress());
$currencyArray = $shopManager->getAllCurrencies();
$wsUrl = $shop->getWebServiceUrl() != null && $shop->getWebServiceUrl() != "" ? $shop->getWebServiceUrl() : PROTOCOL.DOMAIN_SHOP."/getProducts.php";

$template->MxHidden($pre."hlogo", $template->GetQueryString(array("hlogo" => $shop->getLogo())));

$template->MxFormField($pre."name", "text", "name", $shop->getName(), 'id="name"');
$template->MxFormField($pre."email", "text", "email", $shop->getEmail(), 'id="email"');
$template->MxFormField($pre."webServiceUrl", "text", "webServiceUrl", $wsUrl, 'id="webServiceUrl"');
$template->MxSelect($pre."currency", "currency", $shop->getCurrencyId(), $currencyArray);
$template->MxAttribut($pre."logo", $logo);

$template->MxFormField($pre."address0", "text", "address0", $address[0], 'id="address0" size="40" maxlength="85"');
$template->MxFormField($pre."address1", "text", "address1", $address[1], 'id="address1" class="alone" size="40" maxlength="85"');
$template->MxFormField($pre."address2", "text", "address2", $address[2], 'id="address2" class="alone" size="40" maxlength="85"');
$template->MxFormField($pre."zipCode", "text", "zipCode", $shop->getZipCode(), 'id="zipCode"');
$template->MxFormField($pre."city", "text", "city", $shop->getCity(), 'id="city"');
$template->MxFormField($pre."state", "text", "state", $shop->getState(), 'id="state"');
$template->MxSelect($pre."country", "country", $shop->getCountryId(), $countryArray);
$template->MxFormField($pre."phone", "text", "phone", $shop->getPhone(), 'id="phone"');

$template->MxFormField($pre."latitude", "text", "latitude", $shop->getLatitude(), 'id="latitude"');
$template->MxFormField($pre."longitude", "text", "longitude", $shop->getLongitude(), 'id="longitude"');

$keywords = $shop->getKeywords();
if ($keywords == null || count($keywords) == 0) {
  $template->MxBloc($pre."word", "reset");
} else {
  foreach ($keywords as $word) {
    $template->MxText($pre."word.value", $word->getName());
    $template->MxBloc($pre."word", "loop");
  }
}

if (!$fullPage) {
  $template->MxWrite();
}

?>