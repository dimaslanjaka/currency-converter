<?php

$str = isset($_REQUEST['c']) ? trim($_REQUEST['c']) : false;
$content = '';
if ($str && !empty($str)) {
  $stre = explode("\n", $str);
  $strr = '';
  foreach ($stre as $line) {
    $rgx = '/Set\-Cookie\:\s/m';
    $x = preg_replace($rgx, '', $line);
    $x = preg_replace('/\n+/m', ";\s", $x);
    $x = str_replace("\n", "", $x);
    $x = str_replace("\r", "", $x);
    $x = str_replace(PHP_EOL, '', $x);
    $x = str_replace('
      ', '', $x);
    $x = preg_replace('/\s+/', ' ', $x);
    $x .= '; ';
    $strr .= trim($x) . ' ';
  }
  $strr = preg_replace('/\;{2,10}|\;(\s|\s+)\;/m', ';', $strr);
  $strr = str_replace(['; ;', '; ;'], ';', $strr);
  $content .= <<<EOF
  <main class="pt-4">
  <div class="alert alert-success">
  <div class="text-center">Result (Non-Urlencoded)</div>
  <textarea class="form-control" cols="30" rows="10" class="form-control">{$strr}</textarea>
  </div>
  </main>
EOF;
  file_put_contents('cookie.txt', $strr);
}
if (isset($_REQUEST['view'])) {
  header("Content-Type: text/plain");
  file_get_contents('cookie.txt');
}

$title = 'Cookie Creator';
$desc = 'PHP Cookie header to Cookie urlencoded';
$canonical = (isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');
$content .= <<<EOF
<main class="pt-4">
  <div class="text-center"><a href="https://www.paypal.com/myaccount/money/api/currencies/transfer" target="_blank" rel="noopener noreferrer">Go currencies transfer page</a></div>
  <img src="/Web-Manajemen/img/pp/cookie.png" alt="" class="img-responsive">
  <form action="" method="post">
  <textarea name="c" id="" cols="30" rows="10" class="form-control" placeholder="Set-Cookie: enforce_policy=; Path=/; Domain=paypal.com; Expires=Thu, 01 Jan 1970 00:00:00 GMT; Secure; SameSite=None\nSet-Cookie: _gat_PayPal=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT; HttpOnly; Secure\nSet-Cookie: LANG=id_ID%3BID; Path=/; Domain=paypal.com; Expires=Thu, 20 Feb 2020 04:14:07 GMT; Max-Age=31556; HttpOnly; Secure; SameSite=None"></textarea>
  <button class="btn btn-block" type="submit">Submit</button>
  </form>
</main>
EOF;
include __DIR__ . '/../test/theme/content.php';
