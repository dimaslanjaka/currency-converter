<?php

if ('L3n4r0x-PC' != gethostname()) {
  //error_reporting(0);
  if (!file_exists(__DIR__ . '/function.php')) {
    file_put_contents(__DIR__ . '/function.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/function.php?rev=' . time()));
  }
}
require_once __DIR__ . '/function.php';
v2_default();
include_once __DIR__ . '/console.php';
$loop_delay = 0;
if (defined('STDIN')) {
  if (isset($argv[1])) {
    switch ($argv[1]) {
      case 'reset':
        file_put_contents('counter.txt', '0');
        echo 'Maximum sudah direset 0';
        exit;
        break;
      case 'help':
        echo str_replace('\n', "\n", file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/tutor.txt?rev=' . time())) . "
      Usage:\n
      ...Custom Rumus\n
      php " . basename(__FILE__) . " --rumus=rumus1.txt\n\n
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
  do {
    echo Console::red("Insert delay in number format, for next Loop (ALL loop iterations)\n");
    echo Console::green("Sleep: ");
    $handle = fopen("php://stdin", "r");
    $loop_delay = fgets($handle);
    $loop_delay = trim($loop_delay);
    if (!is_numeric($loop_delay) || $loop_delay <= 0) {
      echo Console::red("Loop delay must be integer/number, and not zero.\n");
      echo Console::green("Retry!\n");
    }
  } while (!is_numeric($loop_delay) || $loop_delay <= 0);
}

$opt = get_opt();
$loop = (int) trim(file_get_contents('loop.txt'));
$file = trim(file_get_contents('cookie.txt'));
$cookie = $file;
$csrf = (string) trim(file_get_contents('csrf.txt'));
$counter = (int) trim(file_get_contents('counter.txt'));
$limit = (int) trim(file_get_contents('limit.txt'));
if (isset($opt['rumus'])) {
  $rumus = (string) trim(file_get_contents($opt['rumus']));
} elseif (file_exists('rumus.txt')) {
  $rumus = (string) trim(file_get_contents('rumus.txt'));
} else {
  die(Console::red('Rumus file is needed'));
}
$rumuse = explode(' ', $rumus);
$rumuse = array_filter($rumuse);
if (isset($opt['ua'])) {
  if (file_exists($opt['ua'])) {
    $ua = (string) trim(file_get_contents($opt['ua']));
  }
} elseif (file_exists('ua.txt')) {
  $ua = (string) trim(file_get_contents('ua.txt'));
}
$x = 0;
while ($x <= $loop) {
  $counter++;
  $x++;
  if ($counter >= $limit) {
    echo "\nMaksimal '$limit' Bro\n";
    break;
  }
  echo Console::blue("===$counter===\n");
  run($rumuse);
  echo "\n\n";
  echo Console::green("===Sleep for $loop_delay seconds===\n");
  echo "\n\n";
  sleep($loop_delay);

  if ($x == $loop - 1) {
    file_put_contents('counter.txt', $counter);
  }
}

function run($rumuse)
{
  global $cookie, $ua, $csrf;
  PP::verify($rumuse, function ($rumus, $func, $amount, $sleep, $count_all) {
    global $cookie, $ua, $csrf;

    if (!is_string($ua) && empty(trim($ua))) {
      exit('User-agent invalid');
    }
    if (!is_numeric($sleep)) {
      exit("Invalid Sleep ($sleep) format, must be integer/number");
    }
    if (!is_numeric($amount) || $amount == 0) {
      exit("Invalid amount ($amount) format, must be integer/number. and not zero.");
    }
    PP::set_ua($ua);
    PP::set_amount($amount);
    PP::set_sleep($sleep);
    if (is_callable($func)) {
      call_user_func($func, $cookie, $csrf);
    } else {
      echo "Cannot executing $rumus\n";
    }
  });
}
