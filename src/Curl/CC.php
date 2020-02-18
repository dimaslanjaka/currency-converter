<?php

namespace Curl;

class CC extends Curl
{
  private $ccURL = 'https://api.exchangerate-api.com';
  private $ccPATH = '/v4/latest/';
  private $ccDIR = __DIR__ . '/json';
  private $cur = null;
  function __construct()
  {
    parent::__construct();
  }

  function set($cur)
  {
    if (is_string($cur)) {
      throw new th("CURRENCY must be instance of string instead of " . gettype($cur));
    }
    if ($cur == 'default') $cur = 'USD';
    $this->cur = trim(strtoupper($cur));
  }

  function build($cur)
  {
  }
}
