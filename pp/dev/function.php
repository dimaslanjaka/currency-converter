<?php

if ('L3n4r0x-PC' != gethostname()) {
  if (!file_exists(__DIR__ . '/class.php')) file_put_contents(__DIR__ . '/class.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/class.php?rev=' . time()));
}
require_once __DIR__ . '/class.php';
if (!file_exists('console.php')) {
  getConsole();
}
if (!class_exists('Console')) include_once __DIR__ . '/console.php';
$v = '1.0.9';

/**
 * Consoler.
 */
function getConsole()
{
  file_put_contents(__DIR__ . '/console.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/console.php?rev=' . time()));
}

/**
 * JSON maker.
 *
 * @param object|array $cfg
 *
 * @return string
 */
function gjson($cfg)
{
  return json_encode($cfg, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
/**
 * Save Config.
 *
 * @param string $file
 * @param array  $content
 */
function saveConfig($file, $content = [
  'loop' => 0,
  'counter' => 0,
  'limit' => 0,
  'curl' => 'v1',
  'body' => 'b1',
  'header' => 'h1',
])
{
  return file_put_contents($file, gjson($content));
}
/**
 * Load default config.
 *
 * @param string $file
 *
 * @return array
 */
function loadConfig($file)
{
  if (!file_exists($file)) {
    saveConfig($file);
    throw new Exception("$file not exist");
  }

  return (array) json_decode(file_get_contents($file));
}

function v2_default($fn = null)
{
  global $v;
  if (!file_exists('loop.txt')) {
    file_put_contents('loop.txt', '0');
  }
  if (!file_exists('rumus.txt')) {
    file_put_contents('rumus.txt', 'usd2twd usd2twd usd2twd twd2usd');
  }
  if (!file_exists('limit.txt')) {
    file_put_contents('limit.txt', '0');
  }
  if (!file_exists('counter.txt')) {
    file_put_contents('counter.txt', '0');
  }
  if (file_exists('max.txt')) {
    file_put_contents('counter.txt', file_get_contents('max.txt'));
    @unlink('max.txt');
  }
  if (!file_exists('csrf.txt')) {
    file_put_contents('csrf.txt', '1GSaHXUdGkzps8ZJyA4lwHJ5lOG6I/avRL+94=');
  }
  if (!file_exists('cookie.txt')) {
    file_put_contents('cookie.txt', 'LANG=en_US%3BID; X-PP-L7=1; cookie_check=yes; ts_c=vr%3D475525001700a1e326b84d26fffef4d5%26vt%3D4755250f1700a1e326b84d26fffef4d4; _ga=GA1.2.1158763546.1581744739; _gat_PayPal=1; _gcl_au=1.1.166798439.1581744739; nsid=s%3A1snkVYEFzlhumhm0ivH1P2g9nLzuYCHl.s6xQoaOzq630SMt7wglbdLp8f7pFNcPzSZhC4fw8pNw; KHcl0EuY7AKSMgfvHl7J5E7hPtK=qYLpw6XdiB_fW_brzzvc2ZZ67_rvRPl47axvKHf5Ny9LY6wsGXSR7jGiA6O3_MRCLAArDAJFOorlQjUA; _gat_gtag_UA_53389718_12=1; login_email=lindsay67f_o49s%40zmat.xyz; ui_experience=d_id%3D105263268f93487c98396b04dd739b6a1581744899385%26login_type%3DEMAIL_PASSWORD%26home%3D2; fn_dt=105263268f93487c98396b04dd739b6a; id_token=idtoken478079faba4047a8ae829e8d13269677; X-PP-ADS=AToBDINHXk1G-FbhehbYE4PU6rvaHK0; SEGM=bRdV1vB0ebq9RKdAb3xSHowCi6QnnlCiDOLNk8i1mAuLl1vTbzHQwWajSsMe8mvoWiJtY1GnpzN4Y-sixGy7BQ; tsrce=moneynodeweb; HaC80bwXscjqZ7KM6VOxULOB534=eCfogkqBiXVR6an3reJ08mrA5TrBuju59uosnc2DGUuhDHI8DAVI0JeRqm5rypJBmi-NEduVXvfsIdkYnGlXwdO_woIJh_27amhUtTayqzoMuTDXSuUhsr63Xqaf_ssWuyMEQm; x-pp-s=eyJ0IjoiMTU4MTc0NTA4Mzc3MyIsImwiOiIwIiwibSI6IjAifQ; X-PP-SILOVER=name%3DLIVE3.WEB.1%26silo_version%3D880%26app%3Dmoneynodeweb%26TIME%3D1581745083%26HTTP_X_PP_AZ_LOCATOR%3Ddcg14.slc; akavpau_ppsd=1581745683~id=8a8988b19d50aca30d56bf270655a32d; ts=vreXpYrS%3D1676439484%26vteXpYrS%3D1581746884%26vr%3D475525001700a1e326b84d26fffef4d5%26vt%3D4755250f1700a1e326b84d26fffef4d4; tcs=main%3Amoneynodeweb%3Atransfer%3AJPY%3Areview%7CreviewConversion');
  }
  if (!file_exists('ua.txt')) {
    file_put_contents('ua.txt', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36');
  }
  if (!file_exists(__DIR__ . '/console.php')) {
    file_put_contents(__DIR__ . '/console.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/console.php'));
  }
  if (!file_exists(__DIR__ . '/function.php')) {
    file_put_contents(__DIR__ . '/function.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/function.php?rev=' . time()));
  }
  if (!file_exists(__DIR__ . '/version.json') || (file_exists(__DIR__ . '/version.json') && date("U", filectime(__DIR__ . '/version.json') <= time() - 3600))) {
    file_put_contents(__DIR__ . '/version.json', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/version.json?rev=' . time()));
  }
  $jv = (array) json_decode(file_get_contents(__DIR__ . '/version.json'));
  if ($jv['version'] > $v) {
    echo Console::red("Update available, to update\nphp $fn update\n\n");
  }
}
/**
 * Parsing parameters.
 */
function get_opt()
{
  if ('cli' === !php_sapi_name()) {
    throw new Exception('Only CLI', 1);
  }

  $options = $opts = getoptreq('abc:d:e::f::', ['one', 'two', 'three:', 'four:', 'five::', 'config:', 'rumus:']);

  return $options;
}

/**
 * Get options from the command line or web request.
 *
 * @param string $options
 * @param array  $longopts
 *
 * @return array
 */
function getoptreq($options, $longopts)
{
  if (PHP_SAPI === 'cli' || empty($_SERVER['REMOTE_ADDR'])) {  // command line
    return getopt($options, $longopts);
  } elseif (isset($_REQUEST)) {  // web script
    $found = [];

    $shortopts = preg_split('@([a-z0-9][:]{0,2})@i', $options, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $opts = array_merge($shortopts, $longopts);

    foreach ($opts as $opt) {
      if ('::' === substr($opt, -2)) {  // optional
        $key = substr($opt, 0, -2);

        if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
          $found[$key] = $_REQUEST[$key];
        } elseif (isset($_REQUEST[$key])) {
          $found[$key] = false;
        }
      } elseif (':' === substr($opt, -1)) {  // required value
        $key = substr($opt, 0, -1);

        if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
          $found[$key] = $_REQUEST[$key];
        }
      } elseif (ctype_alnum($opt)) {  // no value
        if (isset($_REQUEST[$opt])) {
          $found[$opt] = false;
        }
      }
    }

    return $found;
  }

  return false;
}

/**
 * Get String.
 *
 * @param string $string
 * @param string $start
 * @param string $end
 */
function getStr($string, $start, $end)
{
  $str = explode($start, $string);
  if (isset($str[1])) {
    $str = explode($end, ($str[1]));
  }

  return $str[0];
}
/**
 * CSRF parser.
 *
 * @param string $csrf
 */
function csrf($csrf)
{
  return str_replace('_csrf=', '', $csrf);
}
/**
 * Update Script
 *
 * @param string $DIR
 * @return void
 */
function Update($DIR, $file)
{
  global $v;
  file_put_contents($DIR . '/class.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/class.php?rev=' . time()));
  file_put_contents($DIR . '/function.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/function.php?rev=' . time()));
  file_put_contents($DIR . '/console.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/console.php?rev=' . time()));
  file_put_contents($DIR . '/' . $file, file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/dist/mod.php?rev=' . time()));
  file_put_contents(__DIR__ . '/version.json', $v);
}
