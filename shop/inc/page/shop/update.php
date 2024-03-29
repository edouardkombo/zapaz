<?php

$in = $_POST;

$id        = isset($in["id"])        && filter_var($in["id"], FILTER_VALIDATE_INT) && $in["id"] > 0  ? $in["id"]     : 0;
$name      = isset($in["name"])      && $in["name"]      != "" ? stripslashes($in["name"])      : null;
$logo      = isset($in["logo"])      && $in["logo"]      != "" ? stripslashes($in["logo"])      : null;
$email     = isset($in["email"])     && $in["email"]     != "" ? stripslashes($in["email"])     : null;
$latitude  = isset($in["latitude"])  && $in["latitude"]  != "" ? stripslashes($in["latitude"])  : null;
$longitude = isset($in["longitude"]) && $in["longitude"] != "" ? stripslashes($in["longitude"]) : null;
$currencyId = isset($in["currencyId"]) && filter_var($in["currencyId"], FILTER_VALIDATE_INT) && $in["currencyId"] > 0 ? $in["currencyId"] : null;
$address0  = isset($in["address0"])  && $in["address0"]  != "" ? stripslashes($in["address0"])  : null;
$address1  = isset($in["address1"])  && $in["address1"]  != "" ? stripslashes($in["address1"])  : "";
$address2  = isset($in["address2"])  && $in["address2"]  != "" ? stripslashes($in["address2"])  : "";
$zipCode   = isset($in["zipCode"])   && $in["zipCode"]   != "" ? stripslashes($in["zipCode"])   : null;
$city      = isset($in["city"])      && $in["city"]      != "" ? stripslashes($in["city"])      : null;
$state     = isset($in["state"])     && $in["state"]     != "" ? stripslashes($in["state"])     : null;
$countryId = isset($in["countryId"]) && filter_var($in["countryId"], FILTER_VALIDATE_INT) && $in["countryId"] > 0 ? $in["countryId"] : null;
$phone     = isset($in["phone"])     && $in["phone"]     != "" ? stripslashes($in["phone"])     : null;
$webServiceUrl = isset($in["webServiceUrl"]) && filter_var($in['webServiceUrl'], FILTER_VALIDATE_URL) ? stripslashes($in["webServiceUrl"]) : null;
$keywords  = isset($in["keywords"])     && $in["keywords"]     != "" ? stripslashes($in["keywords"])     : null;

$result = 0;
if ($name != null
 && $email != null
 && $latitude != null
 && $longitude != null
 && $currencyId != null
 && $address0 != null
 && $zipCode != null
 && $city != null
 && $countryId != null
 && $webServiceUrl != null) {
  $shopManager = new ShopManager();
  $address = $shopManager->mergeAddresses($address0, $address1, $address2);
  $shop = new Shop("", $name, $address, $zipCode, $city, $countryId, $currencyId, $email, $latitude, $longitude, $id);
  $shop->setState($state);
  $shop->setLogo($logo);
  $shop->setPhone($phone);
  $shop->setWebServiceUrl($webServiceUrl);
  
  $words = explode(";", $keywords);
  $keywords = array();
  foreach ($words as $w) {
    if ($w != "") {
      array_push($keywords, $w);
    }
  }
  
  $result = $shopManager->saveOrUpdate($shop, $keywords);
  $id = $shop->getId();
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r>
<result>$result</result>
<id>$id</id>
</r>
END;

?>
