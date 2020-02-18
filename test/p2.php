<?php
$req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if ($response_json) {
  $response_object = json_decode($response_json);
  $base_price = r('usd') or 12; // Your price in USD
  $EUR_price = round(($base_price * $response_object->rates->EUR), 2);
  var_dump($EUR_price);
}

function r($s)
{
  if (isset($_REQUEST[$s]) && !empty($_REQUEST[$s])) return trim(urldecode($_REQUEST[$s]));
}
