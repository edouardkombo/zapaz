<?php
$fullPage = isset($fullPage) ? $fullPage : false;
$pre      = $fullPage        ? "content.": "";
if (!$fullPage)
  include('../inc/local.config.php');

$in = $_POST;

if (!$fullPage) {
  $template = new ModeliXe('product/logo.mxt');
  $template->SetModeliXe();
}

if (!$fullPage) {
  $template->MxWrite();
}

?>