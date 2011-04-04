<?php

$in = $_POST;

$id   = isset($in['id'])   && filter_var($in['id'], FILTER_VALIDATE_INT) && $in['id'] > 0 ? $in['id'] : 0;
$name = isset($in['name']) && $in['name'] != "" ? stripslashes($in['name']) : null;
$symbol = isset($in['symbol']) && $in['symbol'] != "" ? $in['symbol'] : null;

$result = 0;
if ($id > 0 && $name != null && $symbol != null) {
  $currencyManager = new CurrencyManager();
  $result = $currencyManager->saveOrUpdate(new Currency($name, $symbol, $id));
}

echo <<< END
<?xml version="1.0" encoding="utf-8"?>
<r>
  <result>$result</result>
</r>
END;
?>
