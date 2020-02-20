<?php

$str = isset($_REQUEST['c']) ? trim($_REQUEST['c']) : false;
if ($str && !empty($str)) {
  $x = preg_replace('/Set\-Cookie\:\s/m', '', $str);
  $x = preg_replace('/\r\n+/m', '; ', $x);
  $x .= ';';
  $x = preg_replace('/\;{2,10}/m', ';', $x);
  file_put_contents('cookie.txt', $x);
}
if (isset($_REQUEST['view'])) {
  header("Content-Type: text/plain");
  file_get_contents('cookie.txt');
}

$title = 'Cookie Creator';
$desc = 'PHP Cookie header to Cookie urlencoded';
$canonical = (isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');
$content = <<<EOF
<main class="pt-4">
  <form action="" method="post">
  <textarea name="c" id="" cols="30" rows="10" class="form-control" placeholder="Set-Cookie: enforce_policy=; Path=/; Domain=paypal.com; Expires=Thu, 01 Jan 1970 00:00:00 GMT; Secure; SameSite=None\nSet-Cookie: _gat_PayPal=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT; HttpOnly; Secure\nSet-Cookie: LANG=id_ID%3BID; Path=/; Domain=paypal.com; Expires=Thu, 20 Feb 2020 04:14:07 GMT; Max-Age=31556; HttpOnly; Secure; SameSite=None"></textarea>
  </form>
</main>
EOF;
include __DIR__ . '/../test/theme/content.php';
