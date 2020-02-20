<?php

//error_reporting(0);

require __DIR__ . '/function.php';
v2_default();
include_once __DIR__ . '/console.php';
if (defined('STDIN')) {
  $opt = get_opt();

  if (isset($argv[1])) {
    switch ($argv[1]) {
      case 'reset':
        file_put_contents('counter.txt', '0');
        echo 'Maximum sudah direset 0';
        exit;
        break;
      case 'help':
        echo str_replace('\n', "\n", file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/tutor.txt?rev=' . time())) . "
      Utility:\n
      ...Update\n
      php " . basename(__FILE__) . " update\n\n
      ...Credit Author\n
      php " . basename(__FILE__) . " credit\n\n
      ";
        exit;
        break;
      case 'update':
        file_put_contents(__DIR__ . '/function.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/function.php?rev=' . time()));
        file_put_contents(__DIR__ . '/function.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/console.php?rev=' . time()));
        file_put_contents(__DIR__ . '/' . basename(__FILE__), file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/mod.php?rev=' . time()));
        break;
      case 'credit':
        echo "\n\n";
        echo "#################\n#  @muhtoevill  #\n#   SGB-Team    #\n#  Binary-Team  #\n#################\n";
        echo "DWYOR JANGAN SALAHKAN SAYA BILA TERJADI SESUATU YANG TIDAK MENYENANGKAN\n";
        echo "\n\n";
        break;
    }
  }
}

$loop = (int) trim(file_get_contents('loop.txt'));
$file = trim(file_get_contents('cookie.txt'));
$cookie = $file;
$csrf = (string) trim(file_get_contents('csrf.txt'));
$max = (int) trim(file_get_contents('counter.txt'));
$limit = (int) trim(file_get_contents('limit.txt'));
$rumus = (string) trim(file_get_contents('rumus.txt'));
if (isset($opt['rumus'])) {
  $rumus = (string) trim(file_get_contents($opt['rumus']));
}
$rumuse = explode(' ', $rumus);
$rumuse = array_filter($rumuse);
for ($x = 0; $x < $loop; ++$x) {
  ++$max;
  if ($max >= $limit) {
    echo "\nMaksimal '$limit' Bro\n";
    break;
  }
  PP::verify($rumuse, function ($rumus, $func, $ammount, $sleep) {
    global $cookie, $cfg, $csrf, $max;
    //exit(var_dump($rumus, [$func, is_callable($func)], $ammount, $sleep));
    if (is_callable($func)) {
      echo "Executing " . str_replace('PP::', '', $func) . "\n";
      call_user_func($func, $cookie, $csrf, $max);
    } else {
      echo "Cannot executing $rumus\n";
    }
  });

  if ($x == $loop - 1) {
    file_put_contents('counter.txt', $max);
  }
}

class PP
{
  public static $sleep = 5;
  public static $wrap_config = [];

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
    $arr = ["\r", '	'];
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
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
  public static function twd_to_usd($cookie, $csrf)
  {
    $arr = ["\r", '	'];
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
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
  public static function jpy_to_twd($cookie, $csrf)
  {
    $arr = ["\r", '	'];
    $url = 'https://www.paypal.com/myaccount/money/api/currencies/transfer';
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

  /**
   * TWD to USD Executor.
   *
   * @param string $cookie
   * @param string $csrf
   *
   * @return json_decode
   */
  public static function twd2usd($cookie, $csrf, $max)
  {
    $twd_to_usd = self::twd_to_usd($cookie, $csrf);
    $output_send_twd = json_encode($twd_to_usd);
    $amount = getStr($output_send_twd, '"value":"', '"');
    if (true == strpos($output_send_twd, 'null')) {
      $text3 = "Berhasil convert 1 TWD  to $amount USD";
      echo $max . ' ' . date('d-m-Y H:i:s ') . $text3 . "\n";
    } else {
      $text4 = Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
      echo $max . ' ' . date('d-m-Y H:i:s ') . $text4 . "\n";
    }
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
  public static function usd2twd($cookie, $csrf, $max)
  {
    $usd_to_twd = self::usd_to_twd($cookie, $csrf);
    $output_send_usd = json_encode($usd_to_twd);
    $amount = getStr($output_send_usd, '"value":"', '"');
    if (true == strpos($output_send_usd, 'null')) {
      $text1 = "Berhasil convert 0,02 USD to $amount TWD";
      echo $max . ' ' . date('d-m-Y H:i:s ') . $text1 . "\n";
    } else {
      $text2 = Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
      echo $max . ' ' . date('d-m-Y H:i:s ') . $text2 . "\n";
    }
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
  public static function jpy2twd($cookie, $csrf, $max)
  {
    $jpy_to_twd = self::jpy_to_twd($cookie, $csrf);
    $output_send_jpy_twd = json_encode($jpy_to_twd);
    $amount = getStr($output_send_jpy_twd, '"value":"', '"');
    if (true == strpos($output_send_jpy_twd, 'null')) {
      $text3 = "Berhasil convert 2 JPY  to $amount TWD";
      echo $max . ' ' . date('d-m-Y H:i:s ') . $text3 . "\n";
    } else {
      $text4 = Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
      echo $max . ' ' . date('d-m-Y H:i:s ') . $text4 . "\n";
    }
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
        foreach (self::$wrap_config as $function) {
          call_user_func($callback, $function['rumus'], $function['function'], $function['ammount'], $function['sleep']);
        }
      }
    }
  }
}
