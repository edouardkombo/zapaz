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
define("INC_GENERAL_PATH"         , ROOT."inc/"                     );
  
// Variables globales
// TOUJOURS DECLARER ET INITIALISER UNE VARIABLE !!!
$result     = "";
$db         = NULL;       // Base de donnée
$currentUrl = $_SERVER['REQUEST_URI'];

$currentLanguage = "en";



// Services
include(INC_GENERAL_PATH.'service/HttpCommunicator.php');
}

?>
