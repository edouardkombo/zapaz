<?php
include('../inc/global.config.php');

$uri = "admin.zap.com/getCategories";
$httpCommunicator = new HttpCommunicator($uri);
$xml = $httpCommunicator->send();

//echo $xml; 

$categoryManager = new CategoryManager();

$categories = $xml->getElementsByTagName('category');

foreach( $categories as $category )
  {
  $name = $category->item(0)->nodeValue;
  $categories = $categoryManager->saveOrUpdate(new Category($name));
  }


?>
