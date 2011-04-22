<?php

$userAgent = $_SERVER["HTTP_USER_AGENT"];


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Welcome to ZAP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
      html, body { font-family:Arial, Verdana, sans-serif; font-size:11px; }
      #box { position:relative; width:550px; margin:50px auto; }
      h1 { text-align:center; font-size:2.5em; }
      a {
        position:absolute;
        display:block;
        top:80px;
        width:250px;
        height:40px;
        padding-top:200px;
        background-position: top;
        background-repeat: no-repeat;
        font-size:2em;
        font-weight:bold;
        text-align:center;
        text-decoration: none;
        color:#333;
        border:3px solid #06c;
        text-indent:0;
         box-shadow:0 0 8px #06c;
      }
      a:hover { font-size: 2.1em; border-color:#f4c639; box-shadow:0 0 8px #ebc57c; }
      .admin { left:0; background-image: url(admin.jpg); }
      .shop { right:0; background-image: url(shop.jpg); }
    </style>
  </head>
  <body>
    <div id="box">
      <h1>Zap Home</h1>
      <a href="./admin/www" class="admin">Admin</a>
      <a href="./shop/www" class="shop">Shop</a>
    </div>
  </body>
</html>
