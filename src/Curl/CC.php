<?php

namespace Curl;

class CC
{
  private $baseURL = 'https://api.exchangerate-api.com';
  private $pathURL = '/v4/latest/';
  private $cachedir = __DIR__ . '/json';
  private $cur = null;
  function __construct()
  {
    parent::__construct();
  }

  function set($cur)
  {
  }

  function build($cur)
  {
  }
}
