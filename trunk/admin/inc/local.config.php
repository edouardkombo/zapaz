<?php

include("../../global.config.php");

if (!defined("LOCAL_CONFIG")) {
define("LOCAL_CONFIG", "1");
// Variables globales
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
}

?>
