<?php

if (!defined("MYSQL_HOSTNAME")) {

$root = substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT']) - 3);
  
// Base de données
define("ROOT"                     , $root                           );
define("MYSQL_HOSTNAME"           , "localhost"                     );
define("MYSQL_PORT"               , "3306"                          );
define("MYSQL_USERNAME"           , "root"                          );
define("MYSQL_PASSWORD"           , "zappaz"                        );
define("MYSQL_DB_SHOP"            , ""                       );

// Domaines et sous domaines
define("DOMAIN"                   , "argon.com"                     );
define("DOMAIN_SHOP"              , "shop.".DOMAIN                  );
define("DOMAIN_ZSHOP"             , "static.".DOMAIN_SHOP           );
define("PROTOCOL"                 , "http://"                       );
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

try {
  $db = new PDO("mysql:dbname=".MYSQL_DB_SHOP.";host=".MYSQL_HOSTNAME, MYSQL_USERNAME, MYSQL_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  $db->query('SET NAMES "utf8"');
} catch (PDOException $e) {
  exit($e);
}

include(MX_GENERAL_PATH.'ModeliXe.php');

// Model


// DAO 

// Services
include(INC_GENERAL_PATH.'service/HttpCommunicator.php');
}

?>
