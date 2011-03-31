<?php

if (!defined("MYSQL_HOSTNAME")) {

$root = substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT']) - 3);
  
// Base de données
define("ROOT"                     , $root                           );
define("MYSQL_HOSTNAME"           , "localhost"                     );
define("MYSQL_PORT"               , "3306"                          );
define("MYSQL_USERNAME"           , "root"                          );
define("MYSQL_PASSWORD"           , "zappaz"                        );
define("MYSQL_DB_SHOP"            , "zapshop"                       );

// Domaines et sous domaines
define("DOMAIN"                   , "zap.com"                       );
define("DOMAIN_SHOP"              , "shop.".DOMAIN                  );
define("DOMAIN_ZSHOP"             , "static.".DOMAIN_SHOP           );
define("PROTOCOL"                 , "http://"                       );

// Urls for admin WS
define("ADMIN_LOGIN"     , "http://admin.zap.com/loginShop.php");
define("ADMIN_REGISTER"  , "http://admin.zap.com/registerShop.php");
define("ADMIN_CATEGORIES", "http://admin.zap.com/getCategories.php");
define("ADMIN_PT"        , "http://admin.zap.com/getProductTypes.php");

// Chemins
define("TEMPLATE_GENERAL_PATH"    , ROOT."tpl/"                     );
define("INC_GENERAL_PATH"         , ROOT."inc/"                     );
define("MX_GENERAL_PATH"          , INC_GENERAL_PATH."ModeliXe/"    );
define("MX_ERROR_PATH"            , INC_GENERAL_PATH."ModeliXe/"    );

$countryArray = array(
    "1" => "France",
    "2" => "Germany",
    "3" => "England",
    "4" => "USA"
);
  
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
include(INC_GENERAL_PATH.'model/Category.php');
include(INC_GENERAL_PATH.'model/Currency.php');
include(INC_GENERAL_PATH.'model/DetailType.php');
include(INC_GENERAL_PATH.'model/Keyword.php');
include(INC_GENERAL_PATH.'model/Offer.php');
include(INC_GENERAL_PATH.'model/Product.php');
include(INC_GENERAL_PATH.'model/ProductDetail.php');
include(INC_GENERAL_PATH.'model/ProductType.php');
include(INC_GENERAL_PATH.'model/Shop.php');

// DAO 
include(INC_GENERAL_PATH.'dao/CategoryDao.php');
include(INC_GENERAL_PATH.'dao/CurrencyDao.php');
include(INC_GENERAL_PATH.'dao/DetailTypeDao.php');
include(INC_GENERAL_PATH.'dao/KeywordDao.php');
include(INC_GENERAL_PATH.'dao/OfferDao.php');
include(INC_GENERAL_PATH.'dao/ProductDao.php');
include(INC_GENERAL_PATH.'dao/ProductDetailDao.php');
include(INC_GENERAL_PATH.'dao/ProductTypeDao.php');
include(INC_GENERAL_PATH.'dao/ShopDao.php');

// Services
include(INC_GENERAL_PATH.'service/ProductManager.php');
include(INC_GENERAL_PATH.'service/ShopManager.php');
include(INC_GENERAL_PATH.'service/HttpCommunicator.php');
}

?>
