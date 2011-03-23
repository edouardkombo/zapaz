<?php

$in = $_GET;
$id = isset($in["id"]) && filter_var($in["id"], FILTER_VALIDATE_INT) && $in["id"] > 0 ? stripslashes($in["id"]) : 0;

$template = new ModeliXe('offer/create.mxt');
$template->SetModeliXe();



$template->MxWrite();

?>
