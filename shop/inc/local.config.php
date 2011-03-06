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
  $db = new PDO("mysql:dbname=".MYSQL_DB_SHOP.";host=".MYSQL_HOSTNAME, MYSQL_USERNAME, MYSQL_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  $db->query('SET NAMES "utf8"');
} catch (PDOException $e) {
  exit($e);
}

include(MX_GENERAL_PATH.'ModeliXe.php');

// Model
// include model files here !
// e.g: include(INC_GENERAL_PATH.'model/MyModel.php');

// DAO 
// include dao files here !
// e.g: include(INC_GENERAL_PATH.'dao/MyDAO.php');

// Services
// include services files here !
// e.g: include(INC_GENERAL_PATH.'service/myService.php');
}

?>
