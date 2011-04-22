<?php

if (!defined("MYSQL_HOSTNAME")) {


$root = "/homez.193/datesvac/fabienrenaud/www/zap/argon/";
//$root = substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT']) - 3);

define("ROOT"                     , $root                           );

// Domains
define("DOMAIN"                   , "www.fabienrenaud.com/zap/argon"    );
define("DOMAIN_ADMIN"             , DOMAIN."/www"                   );
define("DOMAIN_ZADMIN"            , DOMAIN."/static"                );
define("PROTOCOL"                 , "http://");
define("BASE_ADMIN"               , "www.fabienrenaud.com/zap/admin/www");
define("GET_SHOPS"                , PROTOCOL.BASE_ADMIN."/getStores.php");

// Chemins
define("TEMPLATE_GENERAL_PATH"    , ROOT."tpl/"                     );
define("INC_GENERAL_PATH"         , ROOT."inc/"                     );
define("MX_GENERAL_PATH"          , INC_GENERAL_PATH."ModeliXe/"    );
define("MX_ERROR_PATH"            , INC_GENERAL_PATH."ModeliXe/"    );
  
// Variables globales
// TOUJOURS DECLARER ET INITIALISER UNE VARIABLE !!!
$result     = "";
$db         = NULL;       // Base de donnée
$currentUrl = $_SERVER['REQUEST_URI'];

$currentLanguage = "en";

include(MX_GENERAL_PATH.'ModeliXe.php');

// Model


// DAO 

// Services
include(INC_GENERAL_PATH.'service/HttpCommunicator.php');
}

?>
