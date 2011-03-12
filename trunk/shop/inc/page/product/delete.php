<?php

$in = $_POST;

$pids = !isset($in['pids']) ? null : stripslashes($in['pids']);

$result = 0;
if ($pids != null) {
  $productManager = new ProductManager();

  $ids = explode(';', $pids);
  foreach ($ids as $id) {
    if (is_numeric($id)) {
      $result += $productManager->delete($id);
    }
  }
}

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<root>';
echo   '<result>'.$result.'</result>';
echo '</root>';
?>
