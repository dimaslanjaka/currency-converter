<?php

/**
 * Consoler.
 *
 * @return void
 */
function getConsole()
{
  file_put_contents(__DIR__ . '/console.php', file_get_contents('https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/console.php?rev=' . time()));
}

/**
 * Default Initialization.
 *
 * @return void
 */
function defaultInit()
{
  global $cfg, $rewrite;
  if (file_exists('loop.txt')) {
    $cfg['loop'] = (int) trim(file_get_contents('loop.txt'));
    @unlink('loop.txt');
    $rewrite = 1;
  }
  if (file_exists('max.txt')) {
    $cfg['counter'] = (int) trim(file_get_contents('max.txt'));
    @unlink('max.txt');
    $rewrite = 1;
  }
  if (file_exists('limit.txt')) {
    $cfg['limit'] = (int) trim(file_get_contents('limit.txt'));
    @unlink('limit.txt');
    $rewrite = 1;
  }
  if (!file_exists('ua.txt')) {
    file_put_contents('ua.txt', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36');
  }
  if (!file_exists('rumus.txt')) {
    file_put_contents('rumus.txt', 'usd2twd');
  }
  if (!file_exists('csrf.txt')) {
    file_put_contents('csrf.txt', '1GSaHXUdGkzps8ZJyA4lwHJ5lOG6I/avRL+94=');
  }
  if (!file_exists('cookie.txt')) {
    file_put_contents('cookie.txt', 'LANG=en_US%3BID; X-PP-L7=1; cookie_check=yes; ts_c=vr%3D475525001700a1e326b84d26fffef4d5%26vt%3D4755250f1700a1e326b84d26fffef4d4; _ga=GA1.2.1158763546.1581744739; _gat_PayPal=1; _gcl_au=1.1.166798439.1581744739; nsid=s%3A1snkVYEFzlhumhm0ivH1P2g9nLzuYCHl.s6xQoaOzq630SMt7wglbdLp8f7pFNcPzSZhC4fw8pNw; KHcl0EuY7AKSMgfvHl7J5E7hPtK=qYLpw6XdiB_fW_brzzvc2ZZ67_rvRPl47axvKHf5Ny9LY6wsGXSR7jGiA6O3_MRCLAArDAJFOorlQjUA; _gat_gtag_UA_53389718_12=1; login_email=lindsay67f_o49s%40zmat.xyz; ui_experience=d_id%3D105263268f93487c98396b04dd739b6a1581744899385%26login_type%3DEMAIL_PASSWORD%26home%3D2; fn_dt=105263268f93487c98396b04dd739b6a; id_token=idtoken478079faba4047a8ae829e8d13269677; X-PP-ADS=AToBDINHXk1G-FbhehbYE4PU6rvaHK0; SEGM=bRdV1vB0ebq9RKdAb3xSHowCi6QnnlCiDOLNk8i1mAuLl1vTbzHQwWajSsMe8mvoWiJtY1GnpzN4Y-sixGy7BQ; tsrce=moneynodeweb; HaC80bwXscjqZ7KM6VOxULOB534=eCfogkqBiXVR6an3reJ08mrA5TrBuju59uosnc2DGUuhDHI8DAVI0JeRqm5rypJBmi-NEduVXvfsIdkYnGlXwdO_woIJh_27amhUtTayqzoMuTDXSuUhsr63Xqaf_ssWuyMEQm; x-pp-s=eyJ0IjoiMTU4MTc0NTA4Mzc3MyIsImwiOiIwIiwibSI6IjAifQ; X-PP-SILOVER=name%3DLIVE3.WEB.1%26silo_version%3D880%26app%3Dmoneynodeweb%26TIME%3D1581745083%26HTTP_X_PP_AZ_LOCATOR%3Ddcg14.slc; akavpau_ppsd=1581745683~id=8a8988b19d50aca30d56bf270655a32d; ts=vreXpYrS%3D1676439484%26vteXpYrS%3D1581746884%26vr%3D475525001700a1e326b84d26fffef4d5%26vt%3D4755250f1700a1e326b84d26fffef4d4; tcs=main%3Amoneynodeweb%3Atransfer%3AJPY%3Areview%7CreviewConversion');
  }

  if (!file_exists('console.php')) {
    getConsole();
  }
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
 * Save Config
 *
 * @param string $file
 * @param array $content
 * @return void
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
 * Load default config
 *
 * @param string $file
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

function v2_default()
{
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

function getStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, ($str[1]));

  return $str[0];
}

function csrf($csrf)
{
  return str_replace('_csrf=', '', $csrf);
}
