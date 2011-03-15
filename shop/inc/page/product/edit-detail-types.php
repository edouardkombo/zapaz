<?php

$template = new ModeliXe('product/edit-detail-types.mxt');
$template->SetModeliXe();

$productManager = new ProductManager();
$detailTypeList = $productManager->getAllDetailTypes();

if ($detailTypeList == null || count($detailTypeList) == 0) {
    $template->MxBloc("type", "reset");
} else {
  foreach ($detailTypeList as $t) {
    $template->MxText("type.value", $t->getName());
    $template->MxBloc("type", "loop");
  }
}

$template->MxWrite();

?>
