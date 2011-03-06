<?php

if (!defined("ROOT")) {
$documentRoot = explode('/',$_SERVER['DOCUMENT_ROOT']);
$root = "";
$i = 0;
do {
  $root .= $documentRoot[$i++]."/";
} while ($documentRoot[$i-1] != "admin" && $i < count($documentRoot));

// Base de données
define("ROOT"                     , $root                           );
define("MYSQL_HOSTNAME"           , "localhost"                     );
define("MYSQL_PORT"               , "3306"                          );
define("MYSQL_USERNAME"           , "root"                          );
define("MYSQL_PASSWORD"           , "datesvac"                      );
define("MYSQL_DB_ADMIN"           , "zapgen"                        );
define("MYSQL_DB_SHOP"            , "zapshop"                       );

// Domaines et sous domaines
define("DOMAIN"                   , "zap.com"                       );
define("DOMAIN_ADMIN"             , "admin.".DOMAIN                 );
define("DOMAIN_ZADMIN"            , "static.".DOMAIN_ADMIN          );
define("DOMAIN_SHOP"              , "shop.".DOMAIN                  );
define("DOMAIN_ZSHOP"             , "static.".DOMAIN_SHOP           );
define("PROTOCOL"                 , "http://"                       );
// Chemins
define("TEMPLATE_GENERAL_PATH"    , ROOT."tpl/"                     );
define("INC_GENERAL_PATH"         , ROOT."inc/"                     );
define("MX_GENERAL_PATH"          , INC_GENERAL_PATH."ModeliXe/"    );
define("MX_ERROR_PATH"            , INC_GENERAL_PATH."ModeliXe/"    );
}

?>
