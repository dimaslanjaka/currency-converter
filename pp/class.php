<?php

class PP
{
  private static $sleep = 5;
  private static $wrap_config = [];
  private static $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36';
  private static $pp = 'https://www.paypal.com/';
  private static $v1 = '/myaccount/money/api/currencies/transfer';
  private static $v2 = '/myaccount/money/api/currencies/exchange-rate';
  private static $amount;
  private static $from;
  private static $to;

  /**
   * Build PP.
   *
   * @param string $path
   *
   * @return void
   */
  public static function build($path)
  {
    return preg_replace('/\/{2,9}/', '/', self::$pp . '/' . $path);
  }

  /**
   * Load PP.
   *
   * @param string $url
   * @param array  $h
   * @param string $body
   *
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
   * Is amount valid.
   *
   * @param number|null $n
   *
   * @return void
   */
  public static function check_amount($n = null)
  {
    if (!$n) {
      $n = self::$amount;
    }
    return ($n && is_numeric($n) && $n != 0);
  }

  /**
   * Set User-agent.
   *
   * @param string $ua
   *
   * @return void
   */
  public static function set_ua($ua)
  {
    if (is_string($ua)) {
      self::$ua = $ua;
    }
  }

  public static function set_amount($n)
  {
    if (strpos($n, ':')) {
      $e = explode(':', $n);
      $n = $e[0];
    }
    switch ($n) {
      case 'jpy_to_twd':
        $n = 2;
        break;
      case 'twd_to_usd':
        $n = 3;
        break;
      case 'usd_to_twd':
        $n = 0.02;
        break;
    }
    if (self::check_amount($n)) {
      self::$amount = $n;
    }
    return $n;
  }

  /**
   * Remove amount.
   *
   * @return void
   */
  public static function remove_amount()
  {
    self::$amount = null;
  }

  /**
   * Console result output.
   *
   * @param string           $fn     function name
   * @param string           $output
   * @param string|int|float $amount
   *
   * @return void
   */
  public static function console($fn, $output, $amount)
  {
    $result = Console::red(date('d-m-Y H:i:s ') . ' Gagal Convert ' . self::$amount . ' ' . self::$from . " to $amount " . self::$to . ' (' . $fn . ')');
    if (true == strpos($output, 'null')) {
      $result = Console::green(date('d-m-Y H:i:s ') . ' Berhasil convert ' . self::$amount . ' ' . self::$from . " to $amount " . self::$to . ' (' . $fn . ')');
    }
    echo $result . "\n";
  }

  /**
   * Body builder.
   *
   * @param string $from
   * @param string $to
   * @param string $csrf
   *
   * @return void
   */
  public static function body($from, $to, $csrf)
  {
    self::$from = $from;
    self::$to = $to;
    if (self::$amount == 0) {
      exit(__FUNCTION__ . ' amount (' . self::$amount . ') is zero');
    }
    $result = "{\"sourceCurrency\":\"$from\",\"sourceAmount\":" . self::$amount . ",\"targetCurrency\":\"$to\",\"_csrf\":\"$csrf\"}";
    //var_dump($result);
    return $result;
  }

  /**
   * Build header.
   *
   * @param string $cookie
   *
   * @return explode
   */
  public static function header($cookie)
  {
    $arr = ["\r", '	'];

    return explode("\n", str_replace($arr, '', "Cookie: $cookie
Content-Type: application/json
user-agent: " . self::$ua));
  }

  /**
   * USD to TWD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function usd_to_twd($cookie, $csrf)
  {
    if (self::check_amount()) {
      self::set_amount(__FUNCTION__);
    }
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
    $h = self::header($cookie);
    $body = self::body('USD', 'TWD', $csrf);

    return json_decode(self::cload($url, $h, $body), true);
  }

  public static function usd_to_ils($cookie, $csrf)
  {
    if (self::check_amount()) {
      self::set_amount(__FUNCTION__);
    }
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
    $h = self::header($cookie);
    $body = self::body('USD', 'ILS', $csrf);

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
  public static function twd_to_usd($cookie, $csrf)
  {
    if (self::check_amount()) {
      self::set_amount(__FUNCTION__);
    }
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
    $h = self::header($cookie);
    $body = self::body('TWD', 'USD', $csrf);

    return json_decode(self::cload($url, $h, $body), true);
  }

  /**
   * JPY to USD.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function jpy_to_twd($cookie, $csrf)
  {
    if (self::check_amount()) {
      self::set_amount(__FUNCTION__);
    }
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
    $h = self::header($cookie);
    $body = self::body('JPY', 'TWD', $csrf);

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
  public static function twd2usd($cookie, $csrf)
  {
    $twd_to_usd = self::twd_to_usd($cookie, $csrf);
    $output_send_twd = json_encode($twd_to_usd);
    $amount = getStr($output_send_twd, '"value":"', '"');
    self::console(__FUNCTION__, $output_send_twd, $amount);
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
  public static function usd2twd($cookie, $csrf)
  {
    $usd_to_twd = self::usd_to_twd($cookie, $csrf);
    $output_send_usd = json_encode($usd_to_twd);
    $amount = getStr($output_send_usd, '"value":"', '"');
    self::console(__FUNCTION__, $output_send_usd, $amount);
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
  public static function jpy2twd($cookie, $csrf)
  {
    $jpy_to_twd = self::jpy_to_twd($cookie, $csrf);
    $output_send_jpy_twd = json_encode($jpy_to_twd);
    $amount = getStr($output_send_jpy_twd, '"value":"', '"');
    self::console(__FUNCTION__, $output_send_jpy_twd, $amount);
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
    echo 'Delay ' . self::$sleep . " Secs\n";

    return sleep(self::$sleep);
  }

  public static function verify($rumus, $callback = null)
  {
    if (is_iterable($rumus)) {
      foreach ($rumus as $e) {
        $f = $e;
        $sleep = 1;
        $amount = 0;
        if (strpos($e, ':')) {
          $ex = explode(':', $e);
          /*
           * @see https://regex101.com/r/avhwZg/2/
           */
          foreach ($ex as $transversible) {
            if (method_exists(__CLASS__, $transversible)) {
              $f = $transversible;
              $amount = self::set_amount($transversible);
            }
            if (preg_match('/sleep\((\d\.?\d*)\)/m', $transversible, $sl)) {
              if (!isset($sl[1]) || !is_numeric($sl[1])) {
                throw new Exception($sl[1] . ' is not number OR Invalid on rumus ' . $sl[0]);
              }
              if (is_numeric($sl[1]) && $sl[1] != 0) {
                $sleep = $sl[1];
              }
            }
            if (preg_match('/amount\((\d\.?\d*)\)/m', $transversible, $sl)) {
              if (!isset($sl[1]) || !is_numeric($sl[1])) {
                throw new Exception($sl[1] . ' is not number OR Invalid on rumus ' . $sl[0]);
              }
              if (is_numeric($sl[1]) && $sl[1] != 0) {
                $amount = $sl[1];
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
            'amount' => $amount,
            'rumus' => $e,
          ];
        }
      }
      if (is_callable($callback)) {
        foreach (self::$wrap_config as $function) {
          if ($function['amount'] == 0) {
            $function['amount'] = self::set_amount(self::shift_function($function['rumus']));
          }
          call_user_func($callback, $function['rumus'], $function['function'], $function['amount'], $function['sleep'], count(self::$wrap_config));
        }
        self::$wrap_config = [];
      }
    }
  }

  static function shift_function($f)
  {
    return str_replace('2', '_to_', $f);
  }
}
