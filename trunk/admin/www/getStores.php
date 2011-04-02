<?php

include('../inc/global.config.php');

$in = $_GET;

$latitude = isset($in['latitude']) && filter_var($in['latitude'], FILTER_VALIDATE_FLOAT) ? $in['latitude'] : null;
$longitude = isset($in['longitude']) && filter_var($in['longitude'], FILTER_VALIDATE_FLOAT) ? $in['longitude'] : null;
$maxDistance = isset($in['maxDistance']) && filter_var($in['maxDistance'], FILTER_VALIDATE_FLOAT) ? $in['maxDistance'] : null;

//echo "longitude: ";
//echo $longitude;

$distanceBox = SpatialManager::getGreatSquareAround($latitude, $longitude);

$lat1 = $distanceBox[0][0];
$lng1 = $distanceBox[0][1];
$lat2 = $distanceBox[1][0];
$lng2 = $distanceBox[1][1]; //

$minLat = min($lat1, $lat2);
$maxLat = max($lat1, $lat2);
$minLng = min($lng1, $lng2);
$maxLng = max($lng1, $lng2);

$shopManager = new ShopManager();
$shopsResult = $shopManager->getAllClosestShops($minLat, $maxLat, $minLng, $maxLng);

$doc = new DomDocument('1.0', 'utf-8');
$doc->formatOutput = true;
$root = $doc->createElement('root');
$root = $doc->appendChild($root);


foreach ($shopsResult as $shp) {
  $shop = $doc->createElement("shop");
  $shop = $root->appendChild($shop);

  $id = $doc->createElement('id');
  $id->appendChild($doc->createTextNode($shp->getId()));
  $shop->appendChild($id);

  $publicUid = $doc->createElement("publicUid");
  $publicUid->appendChild(
          $doc->createTextNode($shp->getPublicUid())
  );
  $shop->appendChild($publicUid);

  $name = $doc->createElement("name");
  $name->appendChild(
          $doc->createTextNode($shp->getName())
  );
  $shop->appendChild($name);

  $currencyId = $doc->createElement("currencyId");
  $currencyId->appendChild(
          $doc->createTextNode($shp->getCurrencyId())
  );
  $shop->appendChild($currencyId);

  $latitude = $doc->createElement("latitude");
  $latitude->appendChild(
          $doc->createTextNode($shp->getLatitude())
  );
  $shop->appendChild($latitude);

  $longitude = $doc->createElement("longitude");
  $longitude->appendChild(
          $doc->createTextNode($shp->getLongitude())
  );
  $shop->appendChild($longitude);

  $email = $doc->createElement("email");
  $email->appendChild(
          $doc->createTextNode($shp->getEmail())
  );
  $shop->appendChild($email);

  $webServiceUrl = $doc->createElement("webServiceUrl");
  $webServiceUrl->appendChild(
          $doc->createTextNode($shp->getWebServiceUrl())
  );
  $shop->appendChild($webServiceUrl);
}

// tell the browser what kind of file is come in
//header("Content-type: text/xml");

$xml_string = $doc->saveXML();
echo $xml_string;
?>

