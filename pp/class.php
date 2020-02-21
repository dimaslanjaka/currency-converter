<?php

class PP
{
  public static $sleep = 5;
  public static $wrap_config = [];
  private static $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36';
  protected static $counter;
  public static $pp = 'https://www.paypal.com/';
  public static $v1 = '/myaccount/money/api/currencies/transfer';
  public static $v2 = '/myaccount/money/api/currencies/exchange-rate';
  /**
   * Build PP
   *
   * @param string $path
   * @return void
   */
  public static function build($path)
  {
    return preg_replace('/\/{2,9}/', '/', self::$pp . '/' . $path);
  }
  /**
   * Load PP
   *
   * @param string $url
   * @param array $h
   * @param string $body
   * @return void
   */
  public static function cload($url, $h, $body)
  {
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

  /**
   * USD to TWD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function usd_to_twd($cookie, $csrf, $ammount = '0.02')
  {
    if (!$ammount || $ammount <= 0 || !is_numeric($ammount)) {
      $ammount = 0.02;
    }
    $arr = ["\r", '	'];
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
    $h = explode("\n", str_replace($arr, '', "Cookie: $cookie
	Content-Type: application/json
	user-agent: " . self::$ua));
    $body = "{\"sourceCurrency\":\"USD\",\"sourceAmount\":0.02,\"targetCurrency\":\"TWD\",\"_csrf\":\"$csrf\"}";

    return json_decode(self::cload($url, $h, $body), true);
  }

  /**
   * TWD to USD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function twd_to_usd($cookie, $csrf, $ammount = 3)
  {
    if (!$ammount || $ammount <= 0 || !is_numeric($ammount)) {
      $ammount = 3;
    }
    $arr = ["\r", '	'];
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
    $h = explode("\n", str_replace($arr, '', "Cookie: $cookie
	Content-Type: application/json
	user-agent: " . self::$ua));
    $body = "{\"sourceCurrency\":\"TWD\",\"sourceAmount\":$ammount,\"targetCurrency\":\"USD\",\"_csrf\":\"$csrf\"}";

    return json_decode(self::cload($url, $h, $body), true);
  }
  /**
   * Set User-agent
   *
   * @param string $ua
   * @return void
   */
  public static function setua($ua)
  {
    if (is_string($ua)) {
      self::$ua = $ua;
    }
  }

  /**
   * JPY to USD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function jpy_to_twd($cookie, $csrf, $ammount = 2)
  {
    if (!$ammount || $ammount <= 0 || !is_numeric($ammount)) {
      $ammount = 2;
    }
    $arr = ["\r", '	'];
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
    $h = explode("\n", str_replace($arr, '', "Cookie: $cookie
	Content-Type: application/json
	user-agent: " . self::$ua));
    $body = "{\"sourceCurrency\":\"JPY\",\"sourceAmount\":$ammount,\"targetCurrency\":\"TWD\",\"_csrf\":\"$csrf\"}";

    return json_decode(self::cload($url, $h, $body), true);
  }

  /**
   * TWD to USD Executor.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function twd2usd($cookie, $csrf, $counter)
  {
    $twd_to_usd = self::twd_to_usd($cookie, $csrf);
    $output_send_twd = json_encode($twd_to_usd);
    $amount = getStr($output_send_twd, '"value":"', '"');
    $result = Console::red($counter . ' ' . date('d-m-Y H:i:s ') . ' Gagal Convert. (' . __FUNCTION__ . ')');
    if (true == strpos($output_send_twd, 'null')) {
      $result = Console::green($counter . ' ' . date('d-m-Y H:i:s ') . " Berhasil convert 1 TWD to $amount USD (" . __FUNCTION__ . ')');
    }
    echo $result . "\n";
    self::sleep();
  }

  /**
   * USD to TWD Executor.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function usd2twd($cookie, $csrf, $counter)
  {
    $usd_to_twd = self::usd_to_twd($cookie, $csrf);
    $output_send_usd = json_encode($usd_to_twd);
    $amount = getStr($output_send_usd, '"value":"', '"');
    $result = Console::red($counter . ' ' . date('d-m-Y H:i:s ') . ' Gagal Convert. (' . __FUNCTION__ . ')');
    if (true == strpos($output_send_usd, 'null')) {
      $result = Console::green($counter . ' ' . date('d-m-Y H:i:s ') . " Berhasil convert 0,02 USD to $amount TWD (" . __FUNCTION__ . ')');
    }
    echo $result . "\n";
    self::sleep();
  }

  /**
   * JPY to USD Executor.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function jpy2twd($cookie, $csrf, $counter)
  {
    $jpy_to_twd = self::jpy_to_twd($cookie, $csrf);
    $output_send_jpy_twd = json_encode($jpy_to_twd);
    $amount = getStr($output_send_jpy_twd, '"value":"', '"');
    $result = Console::red($counter . ' ' . date('d-m-Y H:i:s ') . 'Gagal Convert. (' . __FUNCTION__ . ')');
    if (true == strpos($output_send_jpy_twd, 'null')) {
      $result = Console::green($counter . ' ' . date('d-m-Y H:i:s ') . "Berhasil convert 2 JPY to $amount TWD (" . __FUNCTION__ . ')');
    }
    echo $result . "\n";
    self::sleep();
  }

  public static function set_sleep($n)
  {
    if (is_numeric($n) && $n > 0) {
      self::$sleep = $n;
    }
  }

  public static function sleep()
  {
    return sleep(self::$sleep);
  }

  public static function verify($rumus, $callback = null)
  {
    if (is_iterable($rumus)) {
      foreach ($rumus as $e) {
        $f = $e;
        $sleep = 1;
        $ammount = false;
        if (strpos($e, ':')) {
          $ex = explode(':', $e);
          /*
           * @see https://regex101.com/r/avhwZg/2/
           */
          foreach ($ex as $transversible) {
            if (method_exists(__CLASS__, $transversible)) {
              $f = $transversible;
            } elseif (preg_match('/sleep\((\d\.?\d*)\)/m', $transversible, $sl)) {
              if (!isset($sl[1]) || !is_numeric($sl[1])) {
                throw new Exception($sl[1] . ' is not number OR Invalid on rumus ' . $sl[0]);
              }
              if (is_numeric($sl[1]) && $sl[1] != (int) 0) {
                $sleep = (int) $sl[1];
              }
            } elseif (preg_match('/ammount\((\d\.?\d*)\)/m', $transversible, $sl)) {
              if (!isset($sl[1]) || !is_numeric($sl[1])) {
                throw new Exception($sl[1] . ' is not number OR Invalid on rumus ' . $sl[0]);
              }
              if (is_numeric($sl[1]) && $sl[1] != (int) 0) {
                $ammount = (int) $sl[1];
              }
            }
          }
        }
        if (!method_exists(__CLASS__, $f)) {
          throw new Exception("$f is not function");
        } else {
          self::$wrap_config[] = [
            'function' => __CLASS__ . '::' . $f,
            'sleep' => $sleep,
            'ammount' => $ammount,
            'rumus' => $e,
          ];
        }
      }
      if (is_callable($callback)) {
        exit(var_dump(self::$wrap_config));
        foreach (self::$wrap_config as $function) {
          call_user_func($callback, $function['rumus'], $function['function'], $function['ammount'], $function['sleep']);
        }
      }
    }
  }
}
