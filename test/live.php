<?php

require __DIR__ . '/../vendor/autoload.php';
if (!function_exists('includeWV')) require __DIR__ . '/theme/function.php';

use Curl\CC;

$c = new CC();
$c->set($c->isreq('from') ? strtoupper($c->isreq('from')) : 'USD');
$c->build();
$title = 'Live Currency Converter - WMI';
$desc = 'PHP Class Currency Converter Tools.';
$canonical = (isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');
$content = includeWV('views/live.php', ['title' => $title, 'c' => $c], false);
include __DIR__ . '/theme/content.php';
