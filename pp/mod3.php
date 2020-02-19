<?php

/**
 * Because we are lazy, shut up error.
 */
error_reporting(0);
session_start();
/**
 * default configuration file.
 */
$cfg_file = __DIR__ . '/' . basename(__FILE__, '.php') . '.json';

/*
 * Determine default configuration
 */
defaultInit();
$cfg = [
  'loop' => 0,
  'counter' => 0,
  'limit' => 0,
  'curl' => 'v1',
  'body' => 'b1',
  'header' => 'h1',
];

/*
 * IS CLI ? lets do it
 */
if (defined('STDIN')) {
  if (isset($argv[1])) {
    switch ($argv[1]) {
      case 'reset':
        $cfg['counter'] = 0;
        echo 'Maximum sudah direset 0';
        exit;
        break;
      case 'help':
        echo file_get_contents('tutor.txt') . "
      ...Update\n
      php " . basename(__FILE__) . " update\n\n
      ...Credit Author\n
      php " . basename(__FILE__) . " credit\n\n
      ";
        exit;
        break;
      case 'update':
        getConsole();
        file_put_contents(__DIR__ . '/' . basename(__FILE__), file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/mod.php?rev=' . time()));
        break;
      case strpos($argv[1], '.json') >= 0:
        exit('using ' . $argv[1]);
        break;
      case 'credit':
        echo "\n\n";
        echo "#################\n#  @muhtoevill  #\n#   SGB-Team    #\n#  Binary-Team  #\n#################\n";
        echo "DWYOR JANGAN SALAHKAN SAYA BILA TERJADI SESUATU YANG TIDAK MENYENANGKAN\n";
        echo "\n\n";
        break;
      default:
        break;
    }
  }
}

/**
 * Configuration does not exists, creating it
 * * Or replace default configuration if exists.
 */
$rewrite = false;
if (!file_exists($cfg_file) || $rewrite) {
  file_put_contents($cfg_file, gjson($cfg));
}
$cfg = array_replace($cfg, (array) json_decode(file_get_contents($cfg_file)));

/**
 * Setup global variable.
 */
$loop = trim($cfg['loop']);
$file = trim(file_get_contents('cookie.txt'));
$cookie = $file;
$csrf = (string) trim(file_get_contents('csrf.txt'));
$cfg['counter'] = $cfg['counter'];
$limit = $cfg['limit'];
$rumus = (string) trim(file_get_contents('rumus.txt'));
$rumuse = explode(' ', $rumus);
$rumuse = array_filter($rumuse);

include_once __DIR__ . '/console.php';

for ($x = 0; $x < $loop; ++$x) {
  ++$cfg['counter'];
  if ($cfg['counter'] >= $limit) {
    echo "\nMaksimal '$limit' Bro\n";
    break;
  }

  foreach ($rumuse as $e) {
    $f = $e;
    $s = 1;
    if (strpos($e, ':')) {
      $ex = explode(':', $e);
      foreach ($ex as $c) {
        if (is_numeric(trim($c))) {
          $s = $c;
        } elseif (is_callable($c)) {
          $f = $c;
        }
      }
    }
    if (is_callable($e)) {
      echo "Executing $e\n";
      call_user_func($e, $cookie, $csrf, $cfg['counter']);
    } else {
      echo "Cannot executing $e\n";
      continue;
    }
  }

  if ($x == $loop - 1) {
    file_put_contents($cfg_file, $cfg);
  }
}

function getStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, ($str[1]));

  return $str[0];
}

/**
 * USD to TWD.
 *
 * @param string $cookie
 * @param string $csrf
 *
 * @return json_decode
 */
function usd_to_twd($cookie, $csrf)
{
  $arr = ["\r", ' '];
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
 * USD to TWD Executor.
 *
 * @param string $cookie
 * @param string $csrf
 *
 * @return json_decode
 */
function usd2twd($cookie, $csrf, $counter, $sleep = false)
{
  $usd_to_twd = usd_to_twd($cookie, $csrf);
  $output_send_usd = json_encode($usd_to_twd);
  $amount = getStr($output_send_usd, '"value":"', '"');
  if (true == strpos($output_send_usd, 'null')) {
    $text1 = "Berhasil convert 0,02 USD to $amount TWD";
    echo $counter . ' ' . date('d-m-Y H:i:s ') . $text1 . "\n";
  } else {
    $text2 = Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
    echo $counter . ' ' . date('d-m-Y H:i:s ') . $text2 . "\n";
  }
  slp($sleep);
}
