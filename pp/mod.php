<?php

error_reporting(0);
if (defined('STDIN')) {
  switch ($argv[1]) {
    case 'reset':
      file_put_contents('max.txt', '0');
      echo 'Maximum sudah direset 0';
      exit;
      break;
    case 'help':
      echo "
      isi file limit.txt dengan angka (untuk menentukan maksimal eksekusi)\n
      isi file loop.txt dengan angka (untuk menentukan berapa kali setiap eksekusi)\n
      isi file rumus.txt dengan nama fungsi yang akan dijalankan\n
      rumus.txt separated with space\n
      Example : usd2twd twd2usd jpy2twd\n
      Overflow (alur) Example : usd ke twd > twd ke usd > jpy ke twd\n
      usd2twd (USD to TWD)\n
      twd2usd (TWD to USD)\n
      jpy2twd (JPY to USD)\n\n
      ;Update\n
      php " . basename(__FILE__) . " update\n\n
      ;Credit Author\n
      php " . basename(__FILE__) . " credit\n\n
      ";
      exit;
      break;
    case 'update':
      file_put_contents(__DIR__ . '/console.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/console.php?rev=' . time()));
      file_put_contents(__DIR__ . '/mod.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/mod.php?rev=' . time()));
      break;
    case "credit":
      echo "\n\n";
      echo "#################\n#  @muhtoevill  #\n#   SGB-Team    #\n#  Binary-Team  #\n#################\n";
      echo "DWYOR JANGAN SALAHKAN SAYA BILA TERJADI SESUATU YANG TIDAK MENYENANGKAN\n";
      echo "\n\n";
      break;
  }
  if (!file_exists('loop.txt')) {
    file_put_contents('loop.txt', '0');
  }
  if (!file_exists('rumus.txt')) {
    file_put_contents('rumus.txt', 'usd2twd');
  }
  if (!file_exists('limit.txt')) {
    file_put_contents('limit.txt', '0');
  }
  if (!file_exists('max.txt')) {
    file_put_contents('max.txt', '0');
  }
  if (!file_exists('csrf.txt')) {
    file_put_contents('csrf.txt', '1GSaHXUdGkzps8ZJyA4lwHJ5lOG6I/avRL+94=');
  }
  if (!file_exists('cookie.txt')) {
    file_put_contents('cookie.txt', 'LANG=en_US%3BID; X-PP-L7=1; cookie_check=yes; ts_c=vr%3D475525001700a1e326b84d26fffef4d5%26vt%3D4755250f1700a1e326b84d26fffef4d4; _ga=GA1.2.1158763546.1581744739; _gat_PayPal=1; _gcl_au=1.1.166798439.1581744739; nsid=s%3A1snkVYEFzlhumhm0ivH1P2g9nLzuYCHl.s6xQoaOzq630SMt7wglbdLp8f7pFNcPzSZhC4fw8pNw; KHcl0EuY7AKSMgfvHl7J5E7hPtK=qYLpw6XdiB_fW_brzzvc2ZZ67_rvRPl47axvKHf5Ny9LY6wsGXSR7jGiA6O3_MRCLAArDAJFOorlQjUA; _gat_gtag_UA_53389718_12=1; login_email=lindsay67f_o49s%40zmat.xyz; ui_experience=d_id%3D105263268f93487c98396b04dd739b6a1581744899385%26login_type%3DEMAIL_PASSWORD%26home%3D2; fn_dt=105263268f93487c98396b04dd739b6a; id_token=idtoken478079faba4047a8ae829e8d13269677; X-PP-ADS=AToBDINHXk1G-FbhehbYE4PU6rvaHK0; SEGM=bRdV1vB0ebq9RKdAb3xSHowCi6QnnlCiDOLNk8i1mAuLl1vTbzHQwWajSsMe8mvoWiJtY1GnpzN4Y-sixGy7BQ; tsrce=moneynodeweb; HaC80bwXscjqZ7KM6VOxULOB534=eCfogkqBiXVR6an3reJ08mrA5TrBuju59uosnc2DGUuhDHI8DAVI0JeRqm5rypJBmi-NEduVXvfsIdkYnGlXwdO_woIJh_27amhUtTayqzoMuTDXSuUhsr63Xqaf_ssWuyMEQm; x-pp-s=eyJ0IjoiMTU4MTc0NTA4Mzc3MyIsImwiOiIwIiwibSI6IjAifQ; X-PP-SILOVER=name%3DLIVE3.WEB.1%26silo_version%3D880%26app%3Dmoneynodeweb%26TIME%3D1581745083%26HTTP_X_PP_AZ_LOCATOR%3Ddcg14.slc; akavpau_ppsd=1581745683~id=8a8988b19d50aca30d56bf270655a32d; ts=vreXpYrS%3D1676439484%26vteXpYrS%3D1581746884%26vr%3D475525001700a1e326b84d26fffef4d5%26vt%3D4755250f1700a1e326b84d26fffef4d4; tcs=main%3Amoneynodeweb%3Atransfer%3AJPY%3Areview%7CreviewConversion');
  }

  if (!file_exists('console.php')) {
    file_put_contents(__DIR__ . '/console.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/console.php'));
  }
}

include_once __DIR__ . '/console.php';

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
      call_user_func($e, $cookie, $csrf, $max);
    }
  }

  if ($x == $loop - 1) {
    file_put_contents('max.txt', $max);
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
  $body = "{\"sourceCurrency\":\"TWD\",\"sourceAmount\":1,\"targetCurrency\":\"USD\",\"_csrf\":\"$csrf\"}";
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
 * JPY to TWD.
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
  sleep(1);
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
  sleep(1);
}
/**
 * JPY to TWD Executor.
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