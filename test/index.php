<?php

require __DIR__ . '/../vendor/autoload.php';

use \Curl\CC;

$c = new CC();
$c->set('USD');
$c->build();
echo $c->pre($c->get_data()->__toString());
