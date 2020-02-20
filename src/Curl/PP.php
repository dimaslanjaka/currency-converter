<?php

namespace Curl;

class PP extends Curl
{
  public $config_file;
  private $pp_url = '/myaccount/money/api/currencies/transfer';
  private $paypal = 'https://www.paypal.com';
  private $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36';

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
    if (isset($str[1])) $str = explode($end, ($str[1]));

    return $str[0];
  }

  public function pp_send($path, $h, $body)
  {
    //$this->instance = new Curl($this->paypal);
    $this->setUrl($this->paypal);
    $this->setOpt(CURLOPT_HTTPHEADER, $h);
    $this->post($path, $body);
  }

  public function old_request($url, $h, $body)
  {
    if (!$this->isurl($url)) {
      $url = $this->paypal . $url;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $x = curl_exec($ch);
    curl_close($ch);

    return $x;
  }

  public function isurl($url)
  {
    return filter_var($url, FILTER_VALIDATE_URL);
  }

  /**
   * USD to TWD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public function usd_to_twd($cookie, $csrf, $ammount = false)
  {
    $arr = ["\r", '	'];
    $url = $this->pp_url;
    /**
     * $h = explode("\n", str_replace($arr, '', "Cookie: $cookie.
    Content-Type: application/json
    user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36"));
     */
    //$body = "{\"sourceCurrency\":\"USD\",\"sourceAmount\":0.02,\"targetCurrency\":\"TWD\",\"_csrf\":\"$csrf\"}";
    $h = [
      'Content-Type: application/json',
      "Cookie: $cookie",
      'user-agent: ' . $this->ua,
    ];
    if (!is_numeric($ammount)) {
      echo 'Ammount of ' . __FUNCTION__ . " is ({$ammount}) invalid number\n";
      $ammount = 0.02;
      echo "Set ammount default {$ammount}\n";
    }
    $body = $this->gbody([
      'csrf' => $csrf,
      'src' => 'USD',
      'to' => 'TWD',
      'ammount' => $ammount,
    ]);
    $x = $this->old_request($url, $h, $body);

    return json_decode($x, true);
  }

  /**
   * Build Body Post.
   *
   * @param array $cfg
   *
   * @return string
   */
  public function gbody($cfg)
  {
    return gjson([
      'sourceCurrency' => trim(strtoupper($cfg['src'])),
      'sourceAmount' => trim($cfg['ammount']),
      'targetCurrency' => trim(strtoupper($cfg['to'])),
      '_csrf' => trim($cfg['csrf']),
    ]);
  }

  /**
   * Sleep delay.
   *
   * @param mixed $n
   *
   * @return void
   */
  function slp($n)
  {
    if (!$n) {
      $n = 1;
    }
    if (is_numeric($n)) {
      echo "Delay {$n} detik\n";
      sleep($n);
    }
  }

  /**
   * TWD to USD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public function twd_to_usd($cookie, $csrf, $ammount = false)
  {
    $arr = ["\r", '	'];
    $url = $this->pp_url;
    /**
     * $h = explode("\n", str_replace($arr, '', "Cookie: $cookie
	Content-Type: application/json
	user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36"));
    $body = "{\"sourceCurrency\":\"TWD\",\"sourceAmount\":3,\"targetCurrency\":\"USD\",\"_csrf\":\"$csrf\"}";
     */
    $h = [
      'Content-Type: application/json',
      "Cookie: $cookie",
      'user-agent: ' . $this->ua,
    ];
    if (!is_numeric($ammount)) {
      echo 'Ammount of ' . __FUNCTION__ . " is ({$ammount}) invalid number\n";
      $ammount = 3;
      echo "Set ammount default {$ammount}\n";
    }
    $body = $this->gbody([
      'csrf' => $csrf,
      'src' => 'TWD',
      'to' => 'USD',
      'ammount' => $ammount,
    ]);
    $x = $this->old_request($url, $h, $body);

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
    $x = $this->old_request($url, $h, $body);

    return json_decode($x, true);
  }
}
