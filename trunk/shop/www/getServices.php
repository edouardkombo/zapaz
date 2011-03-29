<?php

include('../inc/global.config.php');

$uri = 'http://admin.zap.com/getCategories.php';
$httpCommunicator = new HttpCommunicator($uri);
if ($httpCommunicator->send()) {
  echo $httpCommunicator->getResponseContent();
}


//$categoryManager = new CategoryManager();
//
//$categories = $xml->getElementsByTagName('category');
//
//foreach( $categories as $category )
//  {
//  $name = $category->item(0)->nodeValue;
//  $categories = $categoryManager->saveOrUpdate(new Category($name));
//  }
?>
