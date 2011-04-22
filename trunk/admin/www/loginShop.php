<?php

header("Content-type:application/xml");
$in = $_POST;

session_start();
ob_start();

$publicUid     = isset($in['publicUid'])     && preg_match("/^([0-9A-Za-z]*)$/", $in['publicUid']) && $in['publicUid'] > 0 ? $in['publicUid'] : null;

$result = 0;
if ($publicUid != null) {
  $shopManager = new ShopManager();
  $shop = $shopManager->getShopByPublicUid($publicUid);
  if ($shop != null) {
    $r = 1;
    $_SESSION['uusid'] = $publicUid;
  }
}

ob_end_flush();

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r>
  <result>$result</result>
</r>
END
?>
