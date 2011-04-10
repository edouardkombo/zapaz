<?php
include('../inc/global.config.php');

$in = $_POST;

$id = !isset($in['id']) ? null : stripslashes($in['id']);



$result = 0;
if ($id != null) {
  $productManager = new ProductManager();
  $offer = $productManager->getOffer($id);
 
  if($offer != null){
    $result = 1;
    $offerId = $offer.getId();
  }
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r><result>$result</result></r>
<r><offerId>$offerId</offerId></r>
END
?>