<?php

if ('L3n4r0x-PC' != gethostname()) {
  error_reporting(0);
}
if (!file_exists(__DIR__ . '/function.php')) {
  file_put_contents(__DIR__ . '/function.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/function.php?rev=' . time()));
}
require_once __DIR__ . '/function.php';
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
        Update(__DIR__);
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
$counter = (int) trim(file_get_contents('counter.txt'));
$limit = (int) trim(file_get_contents('limit.txt'));
$rumus = (string) trim(file_get_contents('rumus.txt'));
if (isset($opt['rumus'])) {
  $rumus = (string) trim(file_get_contents($opt['rumus']));
}
$rumuse = explode(' ', $rumus);
$rumuse = array_filter($rumuse);

for ($x = 0; $x < $loop; ++$x) {
  ++$counter;
  if ($counter >= $limit) {
    echo "\nMaksimal '$limit' Bro\n";
    break;
  }
  PP::verify($rumuse, function ($rumus, $func, $ammount, $sleep) {
    global $cookie, $opt, $csrf, $counter;
    if (isset($opt['ua'])) {
      if (file_exists($opt['ua'])) {
        $ua = (string) trim(file_get_contents($opt['ua']));
      }
    } elseif (file_exists('ua.txt')) {
      $ua = (string) trim(file_get_contents('ua.txt'));
    }
    if (isset($ua) && is_string($ua) && !empty(trim($ua))) {
      PP::setua($ua);
    }
    if (is_callable($func)) {
      call_user_func($func, $cookie, $csrf, $counter);
    } else {
      echo "Cannot executing $rumus\n";
    }
  });

  if ($x == $loop - 1) {
    file_put_contents('counter.txt', $counter);
  }
}
