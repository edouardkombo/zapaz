<?php
include('../inc/global.config.php');

$uri = 'http://admin.zap.com/getCategories.php';
$httpCommunicator = new HttpCommunicator($uri,$_GET);
if ($httpCommunicator->send()) {
   $xml = $httpCommunicator->getResponseContent();
   echo $xml;
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
