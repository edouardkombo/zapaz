<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/local.config.php');

$in = $_POST;

if (!$fullPage) {
  $template = new ModeliXe('shop/view.mxt');
  $template->SetModeliXe();
}

/*
$categoryList = $categoryManager->getAllCategories($filter, $startIndex, $limit);
foreach ($categoryList as $c) {
    $template->MxCheckerField($pre."row.input.check", "checkbox", "check", $c->getId());
    $template->MxBloc     ($pre."row.input", "loop");
    $template->MxText     ($pre."row.categoryName", $c->getName());
    $template->MxBloc($pre."row", "loop");
}
*/
if (!$fullPage) {
  $template->MxWrite();
}

?>