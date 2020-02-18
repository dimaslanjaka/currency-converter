<?php

namespace Curl;

use Exception;

class CC extends Curl
{
  private $ccURL = 'https://api.exchangerate-api.com';
  private $ccPATH = '/v4/latest/';
  private $ccDIR = __DIR__ . '/json';
  public $to;
  public $from;
  /**
   * Endpoint.
   *
   * @var string
   */
  private $cur;
  /**
   * Curl.
   *
   * @var \Curl\Curl
   */
  protected $instance;
  /**
   * Object JSON.
   *
   * @var json_decode|object
   */
  protected $result;
  /**
   * String.
   *
   * @var string
   */
  protected $string;

  public function __construct()
  {
    parent::__construct();
    $this->_ob_();
    if (!is_dir($this->ccDIR)) {
      $this->mdir($this->ccDIR);
    }
  }

  public function set($cur)
  {
    if (!is_string($cur)) {
      throw new Exception('CURRENCY must be instance of string instead of ' . gettype($cur));
    }
    if ('default' == $cur) {
      $cur = 'USD';
    }
    $this->cur = trim(strtoupper($cur));

    return $this;
  }

  public function query()
  {
    if (!$this->ccPATH && !$this->cur) {
      throw new th('CURRENCY must inserted');
    }

    return $this->ccPATH . $this->cur;
  }

  public function build($cur = null, $force = false)
  {
    if ($cur) {
      $this->set($cur);
    }
    $this->instance = new Curl($this->ccURL);
    $f = $this->ccFile = $this->ccDIR . $this->ccPATH . $this->cur . '.json';
    if (file_exists($f)) {
      $this->get_data();
    }
    if ($force) {
      $this->instance->get($this->query());
      if (!$this->instance->error) {
        if (is_object($this->instance->response)) {
          $this->_file_($f, $this->gjson($this->instance->response));
        }
      }
    }

    return $this;
  }

  public function pre($str = null)
  {
    if ($str) {
      $this->string = $str;
    }

    return '<pre>' . $this->__toString() . '</pre>';
  }

  public function gjson($x)
  {
    $this->result = (is_iterable($x)) ? json_encode($x, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $x;
    if (is_iterable($x) && JSON_ERROR_NONE == json_last_error()) {
      $this->string = $this->result;
    }
  }

  public function __toString()
  {
    return $this->string;
  }
  /**
   * Get Data Currencies
   *
   * @param string|null $cur
   * @return $this
   */
  public function get_data($cur = null)
  {
    if ($cur) {
      $this->set($cur);
    }
    $this->result = $this->read($this->ccFile);
    if (is_iterable($this->result)) {
      $this->string = json_encode($this->result);
    } elseif (is_string($this->result)) {
      $this->string = $this->result;
      $this->result = json_decode($this->result);
    }

    return $this;
  }

  public function read($path)
  {
    if (!file_exists($path) || !$path) {
      throw new Exception('Requested cache file is not found, try run build() first');
    }

    return file_get_contents($path);
  }

  public function formatBytes($bytes, $precision = 2)
  {
    $units = ['b', 'kb', 'mb', 'gb', 'tb'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
  }
  /**
   * Convert Currency
   *
   * @param integer $n
   * @param string $to
   * @return $this
   */
  public function convert($n = 1, $to = 'EUR')
  {
    $this->to = $to;
    $this->from = $this->cur;
    $this->string = round(((int) $n * $this->result->rates->{$to}), 2);
    return $this;
  }
  /**
   * Give Suffix to string
   *
   * @param string $s
   * @return $this
   */
  function suffix($s)
  {
    $this->string = $s . ' ' . $this->string;
    return $this;
  }

  function get_result()
  {
    return $this->__toString();
  }

  /**
   * Create folder recursively.
   *
   * @param string $d      pathname or dirname
   * @param mixed  $root   root directory
   *                       * default $_SERVER['DOCUMENT_ROOT']
   * @param bool   $noroot false will return begins with $root
   *
   * @return string
   */
  public function _folder_($d, $root = null, $noroot = null)
  {
    if (!$root) {
      $root = $_SERVER['DOCUMENT_ROOT'];
    }
    if (preg_match('/(\/admin\/assets\/data\/.*)/m', $d, $cmatch)) {
      $d = $cmatch[1];
    } else {
      $d = str_replace($root, '', $d);
    }
    $explode = explode('/', rtrim($d, '/'));
    $explode = array_filter((array) $explode);
    $ready = ('WIN' === strtoupper(substr(PHP_OS, 0, 3)) ? '' : '/');
    foreach ($explode as $x) {
      $ready = rtrim($ready, '/');
      $ready .= '/' . $x;
      $status = file_exists($root . $ready);
      if (false === $status) {
        $this->mdir($root . $ready);
      }
    }

    if (!file_exists($d)) {
      if (file_exists($root . $d) && !$noroot) {
        $d = $root . $d;
      }
    }

    return $d;
  }

  /**
   * Create file and directory recursively.
   *
   * @todo mkdir if not exists then file_put_contents
   *
   * @param string $path   File Path
   * @param bool   $create
   *                       * true to create
   *                       * false to abort create
   * @param bool   $force
   *                       * true force overwrite
   *                       * false not create if exists
   * @param bool   $append append to file
   *
   * @return string filepath
   */
  public function _file_($path, $create = true, $force = false, $append = false)
  {
    $path = $this->smartFilePath($path);
    if (strpos($path, '::1')) {
      $rep = date('dmy') . '-' . isset($_SERVER['HTTP_USER_AGENT']) ? md5($_SERVER['HTTP_USER_AGENT']) : '';
      $path = str_replace('::1', $rep, $path);
    }
    if (false !== $create) {
      if (is_numeric($create) || ctype_digit($create)) {
        $create = (int) $create;
      } elseif (is_string($create)) {
        $create = (string) $create;
      } elseif (is_array($create) || is_object($create)) {
        $create = json_encode($create, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      } else {
        $create = '';
      }

      $path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
      $path = $_SERVER['DOCUMENT_ROOT'] . $path;
      if (!file_exists(dirname($path))) {
        $this->_folder_(dirname($path));
      }
      if ((!file_exists($path) || false !== $force) && false !== $create) {
        try {
          if (!$append) {
            file_put_contents($path, $create, LOCK_EX);
          } else {
            file_put_contents($path, $create, FILE_APPEND | LOCK_EX);
          }
        } catch (Exception $e) {
          $this->_ob_();
          ob_end_clean();
          exit(json_encode(['error' => $e->getMessage()]));
        }
      }
    }

    return $path;
  }

  /**
   * Smart __DIR__.
   *
   * @param string $dir
   *
   * @return string $dir
   */
  public function _dir_($dir = __DIR__)
  {
    if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
      return str_replace('\\', '/', $dir);
    }

    return $dir;
  }

  public function smartFilePath($path)
  {
    return str_replace('\\', '/', $path);
  }

  /**
   * Detect ob_start().
   *
   * @return bool ob_start()
   */
  public function _ob_()
  {
    if (!ob_get_level()) {
      return ob_start();
    }
  }

  /**
   * Create folder 777.
   *
   * @param string $x
   */
  public function mdir($x)
  {
    $oldmask = umask(0);
    mkdir($x, 0777);
    umask($oldmask);
  }
}
