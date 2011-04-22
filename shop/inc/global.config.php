<?php

if (!defined("MYSQL_HOSTNAME")) {

$root = "/homez.193/datesvac/fabienrenaud/www/zap/shop/";
//$root = substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT']) - 3);

define("ROOT"                     , $root                           );

// Distant database and domains, for release
define("MYSQL_HOSTNAME"           , "mysql51-19.pro"                );
define("MYSQL_PORT"               , "3306"                          );
define("MYSQL_USERNAME"           , "datesvaczap"                   );
define("MYSQL_PASSWORD"           , "rhMELf23r"                     );
define("MYSQL_DB_SHOP"            , "datesvaczap"                   );

// Domains
define("DOMAIN"                   , "www.fabienrenaud.com/zap/shop"     );
define("DOMAIN_SHOP"             , DOMAIN."/www"                   );
define("DOMAIN_ZSHOP"            , DOMAIN."/static"                );
define("PROTOCOL"                 , "http://"                       );

// Local database, for tests and debug
//define("ROOT"                     , $root                           );
//define("MYSQL_HOSTNAME"           , "localhost"                     );
//define("MYSQL_PORT"               , "3306"                          );
//define("MYSQL_USERNAME"           , "root"                          );
//define("MYSQL_PASSWORD"           , "zappaz"                        );
//define("MYSQL_DB_SHOP"            , "zap"                           );

// Tables
define("TABLE_PREPEND"            , "shop_");
define("TABLE_CATEGORY"           , TABLE_PREPEND."Category"        );
define("TABLE_CURRENCY"           , TABLE_PREPEND."Currency"        );
define("TABLE_DETAIL_TYPE"        , TABLE_PREPEND."DetailType"      );
define("TABLE_KEYWORD"            , TABLE_PREPEND."Keyword"         );
define("TABLE_SHOP"               , TABLE_PREPEND."Shop"            );
define("TABLE_OFFER"              , TABLE_PREPEND."Offer"           );
define("TABLE_PRODUCT"            , TABLE_PREPEND."Product"         );
define("TABLE_PRODUCT_TYPE"       , TABLE_PREPEND."ProductType"     );
define("TABLE_PRODUCT_DETAIL"     , TABLE_PREPEND."ProductDetail"   );

// Urls for admin WS
define("ADMIN_BASE"      , PROTOCOL."www.fabienrenaud.com/zap/admin/www");
define("ADMIN_LOGIN"     , ADMIN_BASE."/loginShop.php"              );
define("ADMIN_REGISTER"  , ADMIN_BASE."/registerShop.php"           );
define("ADMIN_CATEGORIES", ADMIN_BASE."/getCategories.php"          );
define("ADMIN_PT"        , ADMIN_BASE."/getProductTypes.php"        );
define("ADMIN_CURRENCIES", ADMIN_BASE."/getCurrencies.php"          );

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
include(INC_GENERAL_PATH.'service/CategoryManager.php');
include(INC_GENERAL_PATH.'service/CurrencyManager.php');
include(INC_GENERAL_PATH.'service/ProductTypeManager.php');
include(INC_GENERAL_PATH.'service/HttpCommunicator.php');

}

?>
