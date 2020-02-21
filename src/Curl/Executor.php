<?php

namespace Curl;

use Exception;

class Executor extends PP
{
  protected $initialized;
  protected static $wrap_config = [];

  public function __construct()
  {
    parent::__construct();
  }

  public static function verify($rumus, $callback = null)
  {
    if (is_iterable($rumus)) {
      foreach ($rumus as $e) {
        $f = $e;
        $sleep = 1;
        $amount = false;
        if (strpos($e, ':')) {
          $ex = explode(':', $e);
          /*
           * @see https://regex101.com/r/avhwZg/2/
           */
          foreach ($ex as $transversible) {
            if (is_callable($transversible)) {
              $f = $transversible;
            } elseif (preg_match('/sleep\((\d\.?\d*)\)/m', $transversible, $sl)) {
              if (!isset($sl[1]) || !is_numeric($sl[1])) {
                throw new Exception($sl[1] . ' is not number OR Invalid on rumus ' . $sl[0]);
              }
              if (is_numeric($sl[1]) && $sl[1] != (int) 0) {
                $sleep = (int) $sl[1];
              }
            } elseif (preg_match('/amount\((\d\.?\d*)\)/m', $transversible, $sl)) {
              if (!isset($sl[1]) || !is_numeric($sl[1])) {
                throw new Exception($sl[1] . ' is not number OR Invalid on rumus ' . $sl[0]);
              }
              if (is_numeric($sl[1]) && $sl[1] != (int) 0) {
                $amount = (int) $sl[1];
              }
            }
          }
        }
        if (!is_callable($f)) {
          throw new Exception("$f is not function");
        } else {
          self::$wrap_config[] = [
            'function' => $f,
            'sleep' => $sleep,
            'amount' => $amount,
            'rumus' => $e,
          ];
        }
      }
      if (is_callable($callback)) {
        foreach (self::$wrap_config as $function) {
          call_user_func($callback, $function['rumus'], $function['function'], $function['amount'], $function['sleep']);
        }
      }
    }
  }
}
