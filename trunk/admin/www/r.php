<?php

include('../inc/global.config.php');

$d = isset($_GET['d']) && $_GET['d'] != "" ? stripslashes($_GET['d']) : null;
$p = isset($_GET['p']) && $_GET['p'] != "" ? stripslashes($_GET['p']) : null;

if ($p == null || $d == null) {
  exit();
}

if (!preg_match("/^([a-zäëÿüïöâêûîôéèàç\-\+]+)$/", $d)
 || !preg_match("/^([a-zäëÿüïöâêûîôéèàç\-\+]+)$/", $p)) {
  exit();
}


$path = ROOT."inc/page/$d/$p.php";
if (file_exists($path)) {
  include($path);
}

?>
