<?php

$in = $_POST;

$id   = isset($in['id'])   && filter_var($in['id'], FILTER_VALIDATE_INT) && $in['id'] > 0 ? $in['id'] : 0;
$name = isset($in['name']) && $in['name'] != "" ? stripslashes($in['name']) : null;

$result = 0;
if ($id > 0 && $name != null) {
  $productTypeManager = new ProductTypeManager();
  $result = $productTypeManager->saveOrUpdate(new ProductType($name, $id));
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r>
  <result>$result</result>
</r>
END;
?>
