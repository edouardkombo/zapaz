<?php

include('../inc/global.config.php');

$array_page = array("shop", "product");

$javascript = array(
    "http://maps.google.com/maps/api/js?sensor=false",
    PROTOCOL.DOMAIN_ZSHOP."/js/jquery.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/jquery.form.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/jquery.tools.min.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/jquery-ui-admin.min.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/vars.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/filter.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/shop.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/product.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/offer.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/views.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/gmaps.js",
    PROTOCOL.DOMAIN_ZSHOP."/js/main.js"
);
$css = array(
    PROTOCOL.DOMAIN_ZSHOP."/css/design.css",
    PROTOCOL.DOMAIN_ZSHOP."/css/dateinput.css",
    PROTOCOL.DOMAIN_ZSHOP."/css/jquery-ui-admin.css"
);

$template = new ModeliXe('/default.mxt');
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
include('../inc/page/default/view.php');

$template->MxWrite();

?>
