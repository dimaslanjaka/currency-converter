<?php

require __DIR__ . '/../vendor/autoload.php';

use \Curl\CC;

$c = new CC();
$c->set('USD');
$c->build();
$title = 'Live Currency Converter - WMI';
$desc = 'PHP Class Currency Converter Tools.';
$content = include 'views/live.php';
include __DIR__ . '/theme/content.php';
