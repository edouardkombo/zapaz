<?php

include('../inc/global.config.php');

$array_page = array("shop", "user", "category", "product-type");

$page = isset($_GET['p']) && in_array($_GET['p'], $array_page) ? $_GET['p'] : $array_page[0];

$javascript = array(
    PROTOCOL.DOMAIN_ZADMIN."/js/jquery.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/jquery.tools.min.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/jquery-ui-admin.min.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/vars.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/filter.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/category.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/product-type.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/shop.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/user.js",
    PROTOCOL.DOMAIN_ZADMIN."/js/main.js"
);
$css = array(
    PROTOCOL.DOMAIN_ZADMIN."/css/design.css",
    PROTOCOL.DOMAIN_ZADMIN."/css/dateinput.css",
    PROTOCOL.DOMAIN_ZADMIN."/css/jquery-ui-admin.css"
);

$template = new ModeliXe($page.'/default.mxt');
$template->SetModeliXe();

foreach ($css as $f) {
    $template->MxUrl  ("header.css.cssf"  , $f);
    $template->MxBloc ("header.css"       , "loop");
}
foreach ($javascript as $js) {
    $template->MxAttribut("header.script.source" , $js   );
    $template->MxBloc    ("header.script"        , "loop");
}

$fullPage = true;
include('../inc/page/'.$page.'/view.php');

$template->MxWrite();


?>
