<?php
file_put_contents(__DIR__ . '/function.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/function.php'));
require __DIR__ . '/function.php';
v2_default();
include_once __DIR__ . '/console.php';

error_reporting(0);
if (defined('STDIN')) {
  switch ($argv[1]) {
    case 'reset':
      file_put_contents('max.txt', '0');
      echo 'Maximum sudah direset 0';
      exit;
      break;
    case 'config':
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
      file_put_contents(__DIR__ . '/console.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/console.php'));
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

$loop = (int) trim(file_get_contents('loop.txt'));
$file = trim(file_get_contents('cookie.txt'));
$cookie = $file;
$csrf = (string) trim(file_get_contents('csrf.txt'));
$max = (int) trim(file_get_contents('max.txt'));
$limit = (int) trim(file_get_contents('limit.txt'));
$rumus = (string) trim(file_get_contents('rumus.txt'));
$rumuse = explode(' ', $rumus);
$rumuse = array_filter($rumuse);
for ($x = 0; $x < $loop; ++$x) {
  ++$max;
  if ($max >= $limit) {
    echo "\nMaksimal '$limit' Bro\n";
    break;
  }

  foreach ($rumuse as $e) {
    if (is_callable($e)) {
      echo "Executing $e\n";
      call_user_func($e, $cookie, csrf($csrf), $max);
    }
  }

  if ($x == $loop - 1) {
    file_put_contents('max.txt', $max);
  }
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
function twd_to_usd($cookie, $csrf)
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
function jpy_to_twd($cookie, $csrf)
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
function twd2usd($cookie, $csrf, $max)
{
  $twd_to_usd = twd_to_usd($cookie, $csrf);
  $output_send_twd = json_encode($twd_to_usd);
  $amount = getStr($output_send_twd, '"value":"', '"');
  if (true == strpos($output_send_twd, 'null')) {
    $text3 = "Berhasil convert 1 TWD  to $amount USD";
    echo $max . ' ' . date('d-m-Y H:i:s ') . $text3 . "\n";
  } else {
    $text4 = Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
    echo $max . ' ' . date('d-m-Y H:i:s ') . $text4 . "\n";
  }
  sleep(5);
}
/**
 * USD to TWD Executor.
 *
 * @param string $cookie
 * @param string $csrf
 *
 * @return json_decode
 */
function usd2twd($cookie, $csrf, $max)
{
  $usd_to_twd = usd_to_twd($cookie, $csrf);
  $output_send_usd = json_encode($usd_to_twd);
  $amount = getStr($output_send_usd, '"value":"', '"');
  if (true == strpos($output_send_usd, 'null')) {
    $text1 = "Berhasil convert 0,02 USD to $amount TWD";
    echo $max . ' ' . date('d-m-Y H:i:s ') . $text1 . "\n";
  } else {
    $text2 = Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
    echo $max . ' ' . date('d-m-Y H:i:s ') . $text2 . "\n";
  }
  sleep(5);
}
/**
 * JPY to USD Executor.
 *
 * @param string $cookie
 * @param string $csrf
 *
 * @return json_decode
 */
function jpy2twd($cookie, $csrf, $max)
{
  $jpy_to_twd = jpy_to_twd($cookie, $csrf);
  $output_send_jpy_twd = json_encode($jpy_to_twd);
  $amount = getStr($output_send_jpy_twd, '"value":"', '"');
  if (true == strpos($output_send_jpy_twd, 'null')) {
    $text3 = "Berhasil convert 2 JPY  to $amount TWD";
    echo $max . ' ' . date('d-m-Y H:i:s ') . $text3 . "\n";
  } else {
    $text4 = Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
    echo $max . ' ' . date('d-m-Y H:i:s ') . $text4 . "\n";
  }
  sleep(1);
}


class CP
{
  function __callStatic($name, $arguments)
  {
  }
}
