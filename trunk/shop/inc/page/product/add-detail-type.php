<?php

$in = $_POST;

$type = isset($in["type"]) && $in["type"] != "" ? $in["type"] : null;

$result = 0;
if ($type != null) {
  $productManager = new ProductManager();
  $result = $productManager->saveDetailType(new DetailType($type));
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r><result>$result</result></r>
END
?>
