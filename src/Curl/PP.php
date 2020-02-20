<?php

namespace Curl;

class PP extends Curl
{
  public $config_file;
  private $pp_url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';

  public function __construct($config_file = null)
  {
    parent::__construct();
    if ($config_file && file_exists($config_file)) {
      $this->config_file = $config_file;
    }
  }

  public function getStr($string, $start, $end)
  {
    $str = explode($start, $string);
    $str = explode($end, ($str[1]));

    return $str[0];
  }

  function pp_send($url, $h, $body)
  {
  }

  /**
   * USD to TWD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public function usd_to_twd($cookie, $csrf)
  {
    $arr = ["\r", '	'];
    $url = $this->pp_url;
    $h = explode("\n", str_replace($arr, '', "Cookie: $cookie
	Content-Type: application/json
	user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36"));
    $body = "{\"sourceCurrency\":\"USD\",\"sourceAmount\":0.02,\"targetCurrency\":\"TWD\",\"_csrf\":\"$csrf\"}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $x = curl_exec($ch);
    curl_close($ch);

    return json_decode($x, true);
  }

  /**
   * TWD to USD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public function twd_to_usd($cookie, $csrf)
  {
    $arr = ["\r", '	'];
    $url = $this->pp_url;
    $h = explode("\n", str_replace($arr, '', "Cookie: $cookie
	Content-Type: application/json
	user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36"));
    $body = "{\"sourceCurrency\":\"TWD\",\"sourceAmount\":3,\"targetCurrency\":\"USD\",\"_csrf\":\"$csrf\"}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $x = curl_exec($ch);
    curl_close($ch);

    return json_decode($x, true);
  }

  /**
   * JPY to USD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public function jpy_to_twd($cookie, $csrf)
  {
    $arr = ["\r", '	'];
    $url = $this->pp_url;
    $h = explode("\n", str_replace($arr, '', "Cookie: $cookie
	Content-Type: application/json
	user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36"));
    $body = "{\"sourceCurrency\":\"JPY\",\"sourceAmount\":2,\"targetCurrency\":\"TWD\",\"_csrf\":\"$csrf\"}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $x = curl_exec($ch);
    curl_close($ch);

    return json_decode($x, true);
  }
}
