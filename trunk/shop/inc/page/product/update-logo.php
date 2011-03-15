<?php

define("LOGO_DIR", "../static/img/p/"); // Path to use to access to the folder from that script.
define("SAVE_DIR", "/img/p/");           // Path to use to access to the folder from a www page.


$result = 0;
$path = "";
$error = "";
if (!empty($_FILES)) {
  $file = $_FILES['logo']['name'];
  $name = isset($_POST['name']) && $_POST["name"] != "" ? stripslashes($_POST["name"]) : "pic";
  if ($file != "") {
    $path = LOGO_DIR.strtolower($name);
    $ext = strrchr($file, ".");
    $count = 1;
    $tpath = $path;
    while (file_exists($tpath.$ext)) {
      $tpath = $path.$count; 
      $count++;
    }
    $path = $tpath.$ext;
    if(move_uploaded_file($_FILES['logo']['tmp_name'], $path)) {
      $result = 1;
    } else {
      $error = "Upload failed!";
    }
  }
  $path = str_replace(LOGO_DIR, SAVE_DIR, $path);
}

echo <<< END
<?xml version="1.0" encoding=utf-8"?>
<r>
  <result>$result</result>
  <path>$path</path>
  <error>$error</error>
</r>
END;
?>