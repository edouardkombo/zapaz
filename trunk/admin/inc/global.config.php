<?php

if (!defined("MYSQL_HOSTNAME")) {
$root = substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT']) - 3);
  
define("ROOT"                     , $root                           );

//Distant database and domains, for release
//define("MYSQL_HOSTNAME"           , "mysql51-19.pro"                );
//define("MYSQL_PORT"               , "3306"                          );
//define("MYSQL_USERNAME"           , "datesvaczap"                   );
//define("MYSQL_PASSWORD"           , "zappaz"                    );
//define("MYSQL_DB_ADMIN"           , "datesvaczap"                   );
//define("DOMAIN"                   , "zap.dates-vacances-scolaires.com");
//define("DOMAIN_ADMIN"             , DOMAIN                 );
//define("DOMAIN_ZADMIN"            , "static.".DOMAIN_ADMIN          );
//define("PROTOCOL"                 , "http://"                       );

// Local database, for tests and debug
define("MYSQL_HOSTNAME"           , "localhost"                     );
define("MYSQL_PORT"               , "3306"                          );
define("MYSQL_USERNAME"           , "root"                          );
define("MYSQL_PASSWORD"           , "zappaz"                      );
define("MYSQL_DB_ADMIN"           , "zapgen"                        );
define("DOMAIN"                   , "zap.com"                       );
define("DOMAIN_ADMIN"             , "admin.".DOMAIN                 );
define("DOMAIN_ZADMIN"            , "static.".DOMAIN_ADMIN          );
define("PROTOCOL"                 , "http://"                       );

// Paths
define("TEMPLATE_GENERAL_PATH"    , ROOT."tpl/"                     );
define("INC_GENERAL_PATH"         , ROOT."inc/"                     );
define("MX_GENERAL_PATH"          , INC_GENERAL_PATH."ModeliXe/"    );
define("MX_ERROR_PATH"            , INC_GENERAL_PATH."ModeliXe/"    );

// Variables globales
define("MAX_HORIZON", 500); // meters

// TOUJOURS DECLARER ET INITIALISER UNE VARIABLE !!!
$result     = "";
$db         = NULL;       // Base de donnée
$currentUrl = $_SERVER['REQUEST_URI'];

$currentLanguage = "en";

try {
  $db = new PDO("mysql:dbname=".MYSQL_DB_ADMIN.";host=".MYSQL_HOSTNAME, MYSQL_USERNAME, MYSQL_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  $db->query('SET NAMES "utf8"');
} catch (PDOException $e) {
  exit($e);
}

include(MX_GENERAL_PATH.'ModeliXe.php');

// Model
include(INC_GENERAL_PATH.'model/Category.php');
include(INC_GENERAL_PATH.'model/Currency.php');
include(INC_GENERAL_PATH.'model/Keyword.php');
include(INC_GENERAL_PATH.'model/ProductType.php');
include(INC_GENERAL_PATH.'model/Shop.php');
include(INC_GENERAL_PATH.'model/User.php');
include(INC_GENERAL_PATH.'model/UserChoice.php');


// DAO 
include(INC_GENERAL_PATH.'dao/CategoryDao.php');
include(INC_GENERAL_PATH.'dao/CurrencyDao.php');
include(INC_GENERAL_PATH.'dao/KeywordDao.php');
include(INC_GENERAL_PATH.'dao/ProductTypeDao.php');
include(INC_GENERAL_PATH.'dao/ShopDao.php');
include(INC_GENERAL_PATH.'dao/UserDao.php');
include(INC_GENERAL_PATH.'dao/UserChoiceDao.php');

// Services
include(INC_GENERAL_PATH.'service/CategoryManager.php');
include(INC_GENERAL_PATH.'service/ProductTypeManager.php');
include(INC_GENERAL_PATH.'service/ShopManager.php');
include(INC_GENERAL_PATH.'service/UserManager.php');
include(INC_GENERAL_PATH.'service/SpatialManager.php');
}

?>
