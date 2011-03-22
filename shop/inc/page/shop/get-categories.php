<?php
include('../inc/global.config.php');

$in = $_POST;
$shopId = isset($in["shopId"]) && filter_var($in["shopId"], FILTER_VALIDATE_INT) && $in["shopId"] > 0 ? $in["shopId"] : 0;

$productManager = new ProductManager();

echo '<?xml version="1.0" encoding="utf-8"?><r>';

$usedCategories = $productManager->getUsedCategories($shopId);
if ($usedCategories != null) {
  foreach ($usedCategories as $uc) {
    echo '<c>'.$uc->getName().'</c>';
  }
}


echo '</r>';
?>
