<?php
 include('../inc/global.config.php');

$in = $_POST;

$id = !isset($in['id']) ? null : stripslashes($in['id']);

$result = 0;
if ($id != null) {
  $productManager = new ProductManager();
  
  $result = $productManager->deleteOffer($id);
    
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r><result>$result</result></r>
END

?>