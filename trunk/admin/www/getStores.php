<?php

include('../inc/global.config.php');

$in = $_GET;

$latitude = isset($in['latitude']) && filter_var($in['latitude'], FILTER_VALIDATE_FLOAT)  ? $in['latitude']   : null;
$longitude = isset($in['longitude']) && filter_var($in['longitude'], FILTER_VALIDATE_FLOAT)  ? $in['longitude']   : null;
$maxDistance = isset($in['maxDistance']) && filter_var($in['maxDistance'], FILTER_VALIDATE_FLOAT)  ? $in['maxDistance']   : null;
//*Will implement maxDistance later if user is allowed preference

//echo $latitude;
//echo "<br>";
//echo $longitude;

$distanceBox = SpatialManager::getGreatSquareAround($latitude, $longitude);

$latitude1 = $distanceBox[0][0];
$longitude1 = $distanceBox[0][1];
$latitude2 = $distanceBox[1][0];
$longitude2 = $distanceBox[1][1]; //




//echo "<br>";
//echo $latitude1;
//echo "<br>";
//echo $longitude1;
//echo "<br>";
//echo $latitude2;
//echo "<br>";
//echo $longitude2;
//echo "<br>";
//echo $maxDistance;

$shopManager = new ShopManager();
$shopsResult = $shopManager->getAllClosestShops($latitude1, $longitude1, $latitude2, $longitude2, $maxDistance);

$doc = new DomDocument('1.0', 'utf-8');
$root = $doc->createElement('root');
$root = $doc->appendChild($root);

 
foreach( $shopsResult as $shp ){
     $shop = $doc->createElement( "shop" );
     $shop = $root->appendChild($shop);
     
     $id = $doc->createElement('id');
     $id->appendChild($doc->createTextNode($shp->getId()));
     $shop->appendChild($id);

    $publicUid = $doc->createElement( "publicUid" );
    $publicUid->appendChild(
        $doc->createTextNode( $shp->getPublicUid() )
        );
    $shop->appendChild( $publicUid );

    $name = $doc->createElement( "name" );
    $name->appendChild(
        $doc->createTextNode( $shp->getName() )
        );
    $shop->appendChild( $name );

    $currencyId = $doc->createElement( "currencyId" );
    $currencyId->appendChild(
        $doc->createTextNode( $shp->getCurrencyId())
        );
    $shop->appendChild( $currencyId );

    $latitude = $doc->createElement( "latitude" );
    $latitude->appendChild(
        $doc->createTextNode( $shp->getLatitude())
        );
    $shop->appendChild( $latitude );

    $longitude = $doc->createElement( "longitude" );
    $longitude->appendChild(
        $doc->createTextNode( $shp->getLongitude() )
        );
    $shop->appendChild( $longitude );

    $email = $doc->createElement( "email" );
    $email->appendChild(
        $doc->createTextNode( $shp->getEmail() )
        );
    $shop->appendChild( $email );

    $webServiceUrl = $doc->createElement( "webServiceUrl" );
    $webServiceUrl->appendChild(
        $doc->createTextNode( $shp->getWebServiceUrl() )
        );
    $shop->appendChild( $webServiceUrl );


}
    
// tell the browser what kind of file is come in
header("Content-type: text/xml");

$xml_string = $doc->saveXML();
echo $xml_string;
?>

