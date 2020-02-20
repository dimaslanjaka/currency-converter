<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/function.php';
//include_once __DIR__ . '/console.php';

use Curl\Executor;
use Curl\PP;

/**
 * Because we are lazy, shut up error.
 */
//error_reporting(0);
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
        //getConsole();
        //file_put_contents(__DIR__ . '/' . basename(__FILE__), file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/mod.php?rev=' . time()));
        break;
      case false != strpos($argv[1], '.json'):
        echo 'using configuration : ' . $argv[1] . PHP_EOL;
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
  echo 'file ' . basename($cfg_file) . ' sudah dibuat. silahkan di edit dahulu.';
  exit;
}
$cfg = array_replace($cfg, (array) json_decode(file_get_contents($cfg_file)));

/**
 * Setup global variable.
 */
$loop = trim($cfg['loop']);
$cookie = trim(file_get_contents(__DIR__ . '/cookie.txt'));
$csrf = (string) trim(file_get_contents(__DIR__ . '/csrf.txt'));
$limit = $cfg['limit'];
$rumus = (string) trim(file_get_contents(__DIR__ . '/rumus.txt'));
$rumuse = explode(' ', $rumus);
$rumuse = array_filter($rumuse);
$ua = (string) trim(file_get_contents('ua.txt'));
$init = new PP();

for ($x = 0; $x < $loop; ++$x) {
  ++$cfg['counter'];
  if ($cfg['counter'] >= $limit) {
    echo "\nMaksimal '$limit' Bro\n";
    break;
  }
  Executor::verify($rumuse, function ($rumus, $func, $ammount, $sleep) {
    global $cookie, $cfg, $csrf, $init;
    if (is_callable($func)) {
      echo "Executing $func\n";
      call_user_func($func, $cookie, $csrf, $cfg['counter'], $ammount, $sleep);
    } else {
      echo "Cannot executing $rumus\n";
    }
  });

  if ($x == $loop - 1) {
    file_put_contents($cfg_file, $cfg);
  }
}



/**
 * USD to TWD Executor.
 *
 * @param string $cookie
 * @param string $csrf
 *
 * @return json_decode
 */
function usd2twd($cookie, $csrf, $counter, $ammount = false, $sleep = false)
{
  global $init;
  $usd_to_twd = $init->usd_to_twd($cookie, $csrf, $ammount);
  $output_send_usd = json_encode($usd_to_twd);
  $amount = $init->getStr($output_send_usd, '"value":"', '"');
  if (true == strpos($output_send_usd, 'null')) {
    $text1 = Curl\Console::green("Berhasil convert 0,02 USD to $amount TWD");
    echo $counter . ' ' . date('d-m-Y H:i:s ') . $text1 . "\n";
  } else {
    $text2 = Curl\Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
    echo $counter . ' ' . date('d-m-Y H:i:s ') . $text2 . "\n";
  }
  $init->slp($sleep);
}

/**
 * TWD to USD Executor.
 *
 * @param string $cookie
 * @param string $csrf
 *
 * @return json_decode
 */
function twd2usd($cookie, $csrf, $counter, $ammount = false, $sleep = false)
{
  global $init;
  $twd_to_usd = $init->twd_to_usd($cookie, $csrf, $ammount);
  $output_send_twd = json_encode($twd_to_usd);
  $amount = $init->getStr($output_send_twd, '"value":"', '"');
  if (true == strpos($output_send_twd, 'null')) {
    $text3 = Curl\Console::green("Berhasil convert 1 TWD  to $amount USD");
    echo $counter . ' ' . date('d-m-Y H:i:s ') . $text3 . "\n";
  } else {
    $text4 = Console::red('Gagal Convert. (' . __FUNCTION__ . ')');
    echo $counter . ' ' . date('d-m-Y H:i:s ') . $text4 . "\n";
  }
  $init->slp($sleep);
}
