<?php
function CC($from, $to, $amount)
{
  $url = file_get_contents('https://free.currencyconverterapi.com/api/v5/convert?q=' . $from . '_' . $to . '&compact=ultra');
  $json = json_decode($url, true);
  $rate = implode(" ", $json);
  $total = $rate * $amount;
  $rounded = round($total);
  return $total;
}
