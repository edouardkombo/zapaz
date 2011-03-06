<?php

$in = $_POST;

$id   = isset($in['id'])   && is_numeric($in['id']) && $in['id'] > 0 ? $in['id']   : 0;
$name = isset($in['name']) && $in['name'] != ""                      ? $in['name'] : null;

$result = 0;
if ($name != null) {
  $categoryManager = new CategoryManager();
  $result = $categoryManager->saveOrUpdate(new Category($name, $id));
}

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<r>';
echo '<result>'.$result.'</result>';
echo '</r>';
?>
